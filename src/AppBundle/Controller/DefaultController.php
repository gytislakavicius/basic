<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        if (!$this->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render('default/index.html.twig');
    }
}
