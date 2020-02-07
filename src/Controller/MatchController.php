<?php


namespace App\Controller;
use App\Entity\Match;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchController extends AbstractController
{
    public function matchsList()
    {
        // Creation du tableau
        $matchs = $this->getDoctrine()->getRepository(Match::class)->findAll();
        //Passage du tableau au template
        return $this->render('match/matchs.html.twig',['title'=>"Liste des matchs",'matchs'=>$matchs]);
    }
}