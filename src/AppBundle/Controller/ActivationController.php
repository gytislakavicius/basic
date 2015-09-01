<?php

namespace AppBundle\Controller;

use AppBundle\Form\RegisterType;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class ActivationController extends Controller
{
    /**
     * @Route("/register/", name="fos_user_registration_register")
     */
    public function registerAction(Request $request)
    {
        $registerForm = $this->createForm(new RegisterType());

        $registerForm->handleRequest($request);

        if ($registerForm->isValid()) {
            $formData = $registerForm->getData();

            try {
                $this->container->get('basic.users')->sendActivationEmail(strtolower($formData['VPavarde']));

                return $this->redirectToRoute('registration_success');
            } catch(\Exception $ex) {
                return $this->render(
                    'default/register.html.twig',
                    [
                        'register_form' => $registerForm->createView(),
                        'error'         => $ex->getMessage(),
                    ]
                );
            }
        }

        return $this->render(
            'default/register.html.twig',
            [
                'register_form' => $registerForm->createView()
            ]
        );
    }

    /**
     * @Route("registration-sucess", name="registration_success")
     */
    public function successAction()
    {
        return $this->render(
            'default/registrationSuccess.html.twig'
        );
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     *
     * @Route("/confirm/{token}", name="fos_user_registration_confirm")
     */
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('Naudotojas su tokiu aktyvacijos kodu "%s" neegzistuoja', $token));
        }
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());
        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_change_password'));
        $this->authenticateUser($user, $response);
        return $response;
    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
}
