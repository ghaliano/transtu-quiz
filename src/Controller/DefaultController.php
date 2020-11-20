<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Quiz;
use App\Service\ExamManager;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $quizs = $this->getDoctrine()->getRepository(Quiz::class)->findAll();

        return $this->render('default/index.html.twig', [
            'quizs' => $quizs,
        ]);
    }

    /**
     * @Route("/quiz/{id}", name="exam")
     */
    public function quiz(
        Quiz $quiz, 
        Request $request, ExamManager $examManager): Response
    {
        if ($request->isMethod('post')){
            $responses = $request->request->get('responses');
            $examManager->insertResponses($responses);
        }

        return $this->render('default/exam.html.twig', [
            'quiz' => $quiz,
        ]);
    }
}
