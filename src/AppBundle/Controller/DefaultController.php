<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Form\AnswerType;
use AppBundle\Form\QuestionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("admin/question", name="question")
     */
    public function questionAction(Request $request)
    {
        $questionForm = $this->createForm(
            new QuestionType(),
            new Question()
        );

        $questionForm->handleRequest($request);

        if ($questionForm->isValid()) {
            $question = $questionForm->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render(
            'default/newQuestion.html.twig',
            [
                'question_form' => $questionForm->createView()
            ]
        );
    }

    /**
     * @Route("admin/success", name="task_success")
     */
    public function successAction()
    {
        return $this->render(
            'default/success.html.twig'
        );
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        return $this->render(
            'default/admin.index.html.twig'
        );
    }

    /**
     * @Route("admin/answer", name="answer")
     */
    public function answerAction(Request $request)
    {
        $answerForm = $this->createForm(
            new AnswerType(),
            new Answer()
        );

        $answerForm->handleRequest($request);

        if ($answerForm->isValid()) {
            $answer = $answerForm->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render(
            'default/newAnswer.html.twig',
            [
                'answer_form' => $answerForm->createView()
            ]
        );
    }
}
