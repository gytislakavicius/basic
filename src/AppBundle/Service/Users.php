<?php

namespace AppBundle\Service;

use FOS\UserBundle\Doctrine\UserManager;

/**
 * Class Users
 **/
class Users
{
    /** @var UserManager */
    protected $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param $usersObject
     */
    public function updateUsers($usersObject)
    {
        foreach ($usersObject->people as $user) {
            $userEntity = $this->userManager->findUserBy(['intranetId' => $user->intranet_id]);

            if (!$userEntity) {
                $userEntity = $this->userManager->createUser();
            }

            $userEntity->setId($user->intranet_id);
            $userEntity->setUsername($user->username);
            $userEntity->setFullName($user->full_name);
            $userEntity->setIntranetId($user->intranet_id);
            // todo: change to normal emil
            $userEntity->setEmail($user->username . '@nfq.lt');
            $userEntity->setPlainPassword(uniqid());

            if ($user->username == 'murnieza') {
                $userEntity->setEnabled(true);
                $userEntity->setSuperAdmin(true);
                $userEntity->setPlainPassword('admin');
            }

            $this->userManager->updateUser($userEntity);
        }
    }
}
