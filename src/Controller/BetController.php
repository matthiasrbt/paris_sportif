<?php


namespace App\Controller;


use App\Entity\Bet;
use App\Entity\Match;
use App\Form\BetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Choice;
use function Sodium\add;

class BetController extends AbstractController
{
    public function parisList(){
        $matchs = $this->getDoctrine()->getRepository(Match::class)->findAll();
        $listematchs = array();
        foreach ($matchs as $match){
            if($match->getDateTime() >= new \DateTime()){
                dump(new \DateTime());
                $listematchs[] = $match;
            }
        }
        if(empty($listematchs)){
            $this->addFlash('error', 'Aucun match n\'est disponible !');
        }
        return $this->render('bet/formBet.html.twig', ['matchs'=> $listematchs]);
    }
    public function toBet($id,Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $match = $this->getDoctrine()->getRepository(Match::class)->find($id);
        $user = $this->getUser();

        if($user != null){
            if(isset($_POST['result']) AND $_POST['result'] >= 0 AND $_POST['result'] <= 2){
                $result = $_POST['result'];

                $bet = new Bet();
                $bet->setUser($user);
                $bet->setMatch($match);
                $bet->setResult($result);
                $bet->setBetDatetime(new \DateTime());

                $entityManager->persist($bet); //stocké en mémoire dans la collection de livres
                $entityManager->flush(); // synchronisation avec la BDD -> production d'un ordre SQL de type INSERT

                $this->addFlash('success', 'Le paris a bien été enregistré');
                return $this->redirectToRoute('paris');
            }
            else{
                $this->addFlash('warning', 'Paris non valide !');
                return $this->redirectToRoute('paris');
            }
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    public function checkConnexion(){
        $user = $this->getUser();
        if($user != null){
            $iduser = $user->getId();
            return $iduser;
        }
    }
    public function mesParis(){
        $iduser = $this->checkConnexion();
        if($iduser != null){
            $myBets = $this->getDoctrine()->getRepository(Bet::class)->findAll();
            $listBetWaiting = array();
            $listBetFinished = array();
            foreach ($myBets as $myBet){
                if($myBet->getUser()->getId() == $iduser) {
                    if($myBet->getBetDateTime() <= $myBet->getMatch()->getDateTime()) {
                        $listBetWaiting[] = $myBet;
                    }
                    else {
                        $listBetFinished[] = $myBet;
                    }
                }
            }
            if(empty($listBetWaiting) AND empty($listBetFinished)){
                $this->addFlash('error', 'Vous n\'avez effectué aucun paris !');
            }
            return $this->render('bet/mesParis.html.twig', ['bets_encours'=> $listBetWaiting, 'bets_resultat'=>$listBetFinished]);
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
}
