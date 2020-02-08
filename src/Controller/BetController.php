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
                if($match->getDateTime() >= new \DateTime()){
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
                    $this->addFlash('warning', 'Le match a déjà commencé !');
                    return $this->redirectToRoute('paris');
                }
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
        else{
            return false;
        }
    }
    public function mesParis(){
        if($this->checkConnexion() != false){
            $iduser = $this->checkConnexion();
            $bets = $this->getDoctrine()->getRepository(Bet::class)->findAll();
            $listBetWaiting = array();
            $listBetWin = array();
            $listBetLose = array();
            foreach ($bets as $bet){
                if($bet->getUser()->getId() == $iduser) {
                    //$bet->getBetDateTime() <= $bet->getMatch()->getDateTime()
                    if($bet->getMatch()->getDateTime() >= new \DateTime()) {
                        $listBetWaiting[] = $bet;
                    }
                    else {
                        if($bet->getResult() === $bet->getMatch()->getResult()){
                            $listBetWin[] = $bet;
                        }
                        else{
                            $listBetLose[] = $bet;
                        }
                    }
                }
            }
            if(empty($listBetWaiting) AND empty($listBetFinished)){
                $this->addFlash('error', 'Vous n\'avez effectué aucun paris !');
            }
            return $this->render('bet/mesParis.html.twig', ['bets_encours'=> $listBetWaiting, 'bets_win'=>$listBetWin, 'bets_lose'=>$listBetLose]);
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
}
