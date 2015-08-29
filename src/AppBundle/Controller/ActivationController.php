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
}
