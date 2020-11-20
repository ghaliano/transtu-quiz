<?php

namespace App\Service ;

use App\Entity\Response;
use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ExamManager 
{
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function insertResponses ($responses)
    {

        foreach($responses as $question){
            foreach($question as $resp){
                    $response = new Response();
                    $response->setCandidat($this->getUser());
                    $response->setAnswer($this->getAnswerById($resp));
    
                    $this->entityManager->persist($response);
                    $this->entityManager->flush();
            }
        }
        
    }

    private function getAnswerById($id)
    {
        return $this->entityManager->getRepository(Answer::class)->find($id);
    }

    private function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}