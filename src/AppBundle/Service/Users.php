<?php

namespace AppBundle\Service;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Mailer\Mailer;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Users
 **/
class Users
{
    /** @var UserManager */
    protected $userManager;

    /** @var Mailer */
    protected $mailer;

    /**
     * @param UserManager $userManager
     * @param Mailer      $mailer
     */
    public function __construct(UserManager $userManager, Mailer $mailer)
    {
        $this->userManager = $userManager;
        $this->mailer = $mailer;
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

    /**
     * Sets confirmation token and sends activation email for user if found
     */
    public function sendActivationEmail($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (empty($user)) {
            throw new NotFoundHttpException(sprintf('The user with username "%s" does not exist', $username));
        } elseif ($user->isEnabled()) {
            throw new AlreadySubmittedException(sprintf('The user with username "%s" is already activated', $username));
        }

        $user->setConfirmationToken(sha1(uniqid(mt_rand(), true)));
        $this->userManager->updateUser($user);
        $this->mailer->sendConfirmationEmailMessage($user);
    }
}
