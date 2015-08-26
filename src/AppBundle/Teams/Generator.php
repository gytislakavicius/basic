<?php

namespace AppBundle\Teams;

use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Generator
{
    /**
     * Or what's set on admin settings as 'team_size' value
     * 
     * @var int
     */
    private $teamSize = 5;

    /** @var TeamNameGenerator */
    private $teamNameGenerator;

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param int $teamSize
     */
    public function setTeamSize($teamSize)
    {
        $this->teamSize = $teamSize;
    }

    /**
     * @param TeamNameGenerator $teamNameGenerator
     */
    public function setTeamNameGenerator($teamNameGenerator)
    {
        $this->teamNameGenerator = $teamNameGenerator;
    }

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate()
    {
        $this->removeExistingTeams();
        $users = $this->getActiveUsers();
        if (empty($users)) {
            throw new NotFoundHttpException('No active users found.');
        }

        $teams = $this->getTeamsAsArray($users);

        foreach ($teams as $teamUsers) {
            $team = new Team();
            $this->teamNameGenerator->addTeamName($team);
            $this->entityManager->persist($team);

            /** @var User $user */
            foreach ($teamUsers as $user) {
                $user->setTeam($team);
                $this->entityManager->persist($user);
            }
        }

        $this->entityManager->flush();
    }

    private function removeExistingTeams()
    {
        $teams = $this->entityManager->getRepository('AppBundle:Team')->findAll();

        foreach ($teams as $team) {
            $this->entityManager->remove($team);
        }

        $this->entityManager->flush();
    }

    private function getActiveUsers()
    {
        $queryBuilder = $this->entityManager
            ->createQuery(
                'SELECT u FROM AppBundle:User u WHERE u.enabled = true AND u.team IS NULL AND u.roles NOT LIKE :role'
            )->setParameter('role', '%"ROLE_SUPER_ADMIN"%');

        return $queryBuilder->getResult();
    }

    private function getTeamSize()
    {
        $setting = $this->entityManager->getRepository('AppBundle:Settings')->findOneBy(['name' => 'team_size']);
        if ($setting !== null) {
            $this->teamSize = (int)$setting->getValue();
        }

        return $this->teamSize;
    }

    /**
     * @param User[] $users
     * @return array|bool
     */
    private function getTeamsAsArray($users)
    {
        $equalisedList = array_chunk($users, $this->getTeamSize());

        do {
            $initial = $equalisedList;
            $equalisedList = $this->equalizeTeamSizes($equalisedList);
        } while ($equalisedList != $initial);
        
        return $equalisedList;
    }

    /**
     * @param $equalisedList
     * @return array
     */
    private function equalizeTeamSizes($equalisedList)
    {
        $lastKey = count($equalisedList) - 1;
        if (isset($equalisedList[$lastKey - 1])
            && count($equalisedList[$lastKey - 1]) == count($equalisedList[$lastKey])) {
            return $equalisedList;
        }

        for ($i = 1; $i <= $lastKey; $i++) {
            if (isset($equalisedList[$lastKey - $i])
                && count($equalisedList[$lastKey - $i]) > (count($equalisedList[$lastKey]) + 1)) {
                $exchangeUser = end($equalisedList[$lastKey - $i]);
                $equalisedList[$lastKey][] = $exchangeUser;
                $keys = array_keys($equalisedList[$lastKey - $i]);
                unset($equalisedList[$lastKey - $i][end($keys)]);
            }
        }

        return $equalisedList;
    }
}
