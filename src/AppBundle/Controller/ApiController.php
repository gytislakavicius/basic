<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Team;
use AppBundle\Service\Api;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ApiController
 **/
class ApiController extends Controller
{
    /**
     * @Route("/game", name="api.game")
     */
    public function gameAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        /** @var Api $apiService */
        $apiService = $this->get('basic.api');
        /** @var Team $team */
        $team = $this->getUser()->getTeam();

        return new JsonResponse(
            [
                'inProgress' => $apiService->isGameInProgress(),
                'isGameDone' => $apiService->isGameDone(),
                'userWon'    => (bool) $this->getUser()->isWinner(),
                'teamWon'    => !is_null($team) ? (bool) $team->isWinner(): false,
                'questions'  => $apiService->getQuestions($this->getUser()),
            ]
        );
    }

    /**
     * Returns status:
     * success - if everything went fine
     * expired - if question is no longer active
     * not found - if question, user or team was not found
     * already answered - if question was already answered
     *
     * @Route("/game/answer/{questionId}/{answer}", name="api.answer")
     *
     * @param $questionId
     * @param $answer
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function answerAction($questionId, $answer)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        /** @var Api $apiService */
        $apiService = $this->get('basic.api');
        $status = 'success';

        try {
            $apiService->setAnswer($this->getUser(), $questionId, $answer);
        } catch (\Exception $e) {
            switch ($e) {
                case $e instanceof EntityNotFoundException:
                    $status = 'not found';
                    break;
                case $e instanceof AccessDeniedException:
                    $status = 'expired';
                    break;
                case $e instanceof AlreadySubmittedException:
                    $status = 'already answered';
                    break;
                default:
                    throw $e;
            }
        }

        return new JsonResponse(
            [
                'status' => $status,
            ]
        );
    }
}
