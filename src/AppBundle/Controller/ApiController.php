<?php

namespace AppBundle\Controller;

use AppBundle\Service\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
