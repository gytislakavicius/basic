<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\Api;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/", name="fos_user_profile_show")
     */
    public function indexAction()
    {
        if (!$this->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $apiService = $this->get('basic.api');

        return $this->render(
            'default/index.html.twig',
            [
                'isGameInProgress' => $apiService->isGameInProgress()
            ]
        );
    }

    /**
     * @Route("/rules", name="rules")
     */
    public function rulesAction()
    {
        if (!$this->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render('default/rules.html.twig');
    }

    /**
     * @Route("/myTeam", name="myTeam")
     */
    public function myTeamAction()
    {
        if (!$this->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        /** @var User $user */
        $user = $this->getUser();

        $team = $this->getDoctrine()->getRepository('AppBundle:Team')->findOneBy(['id' => $user->getTeam()]);

        return $this->render(
            'default/myTeam.html.twig',
            [
                'teamName'    => $team ? $team->getName() : "You have no team.",
                'teamMembers' => $team
                    ? $this->getDoctrine()->getRepository('AppBundle:User')->findBy(['team' => $user->getTeam()])
                    : [],
            ]
        );
    }

    /**
     * @Route("/statistics", name="statistics")
     */
    public function statisticsAction()
    {
        if (!$this->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $teams = $this->getDoctrine()->getRepository('AppBundle:Team')->findBy([], ['score' => 'DESC']);

        return $this->render(
            'default/statistics.html.twig',
            [
                'teams' => $teams,
            ]
        );
    }

    /**
     * @Route("/questions", name="questions")
     */
    public function questionsAction()
    {
        if (!$this->isGranted(['IS_AUTHENTICATED_FULLY'])) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render(
            'default/questions.html.twig',
            [
                'questions' => $this->get('basic.questions')->getMyQuestions($this->getUser()),
            ]
        );
    }
}
