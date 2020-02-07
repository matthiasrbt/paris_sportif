<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractController
{
    public function teamsList()
    {
        // Creation du tableau
        $teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        //Passage du tableau au template
        return $this->render('team/teams.html.twig',['title'=>"Liste des équipes",'teams'=>$teams]);
    }

}