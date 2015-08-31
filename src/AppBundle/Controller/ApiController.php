<?php

namespace AppBundle\Controller;

use AppBundle\Service\Api;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        /** @var Api $apiService */
        $apiService = $this->get('basic.api');

        return new JsonResponse(
            [
                'inProgress' => $apiService->isGameInProgress(),
                'isGameDone' => $apiService->isGameDone(),
                'questions'  => $apiService->getQuestions(),
            ]
        );
    }

    /**
     * @Route("/team/list", name="api.team")
     */
    public function teamAction()
    {
        throw new \Exception('Feature not implemented yet.');
    }

    /**
     * @Route("/person/list", name="api.person")
     */
    public function personAction()
    {
        /** @var Api $apiService */
        $apiService = $this->get('basic.api');

        return new JsonResponse(
            [
                'persons' => $apiService->getPersons(),
            ]
        );
    }

    /**
     * Returns status:
     * success - if everything went fine
     * expired - if question is no longer active
     * not found - if question was not found
     *
     * @Route("/game/answer/{questionId}/{answer}", name="api.answer")
     *
     * @param $questionId
     * @param $answer
     *
     * @return JsonResponse
     */
    public function answerAction($questionId, $answer)
    {
        /** @var Api $apiService */
        $apiService = $this->get('basic.api');

        $status = 'sucess';
        try {
            $apiService->setAnswer($this->getUser(), $questionId, $answer);
        } catch (\Exception $e) {
            switch ($e) {
                case $e instanceof EntityNotFoundException:
                    $status = 'not found';
                    break;
                case $e instanceof AccessDeniedException:
                    $status = 'expired';
            }
        }

        return new JsonResponse(
            [
                'status' => $status,
            ]
        );
    }
}
