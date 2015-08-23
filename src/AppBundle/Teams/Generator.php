<?php

namespace AppBundle\Teams;

use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Generator
{
    /** @var int */
    private $teamSize = 1;

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
        $users = $this->getActiveUsers();
        if (empty($users)) {
            throw new NotFoundHttpException('No active users found.');
        }

        $chunkedUsers = $this->getChunkedUsers($users);

        foreach ($chunkedUsers as $teamUsers) {
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

    private function getActiveUsers()
    {
        $queryBuilder = $this->entityManager
            ->createQuery(
                'SELECT u FROM AppBundle:User u WHERE u.enabled = true AND u.team IS NULL AND u.roles NOT LIKE :role'
            )->setParameter('role', '%"ROLE_SUPER_ADMIN"%');

        return $queryBuilder->getResult();
    }

    /**
     * @param User[] $users
     * @return array|bool
     */
    private function getChunkedUsers($users)
    {
        return array_chunk($users, $this->teamSize);
    }
}
