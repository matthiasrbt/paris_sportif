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
    public function checkMyBets(){
        $iduser = $this->checkConnexion();
        $bets = $this->getDoctrine()->getRepository(Bet::class)->findAll();
        $myBets = array();
        foreach ($bets as $bet){
            if($bet->getUser()->getId() == $iduser){
                $myBets[] = $bet;
            }
        }
        if(empty($myBets)){
            return false;
        }
        else {
            return $myBets;
        }
    }
    public function matchIsNotOver(){
        $matchs = $this->getDoctrine()->getRepository(Match::class)->findAll();
        $matchsAVenir = array();
        foreach ($matchs as $match) {
            if ($match->getDateTime() >= new \DateTime()) { //On vérifie que la DATE et HEURE du MATCH ne soit pas dépassée
                $matchsAVenir[] = $match;
            }
        }
        if(empty($matchsAVenir)){
            return false;
        }
        else{
            return $matchsAVenir;
        }
    }
    public function parisList()
    {
        $listematchs = array();
        if ($this->checkConnexion() != false) { //Si l'utilisateur est connecté
            $myBets = $this->checkMyBets();
            if($this->matchIsNotOver() != false){
                $lesMatchsAVenir = $this->matchIsNotOver();
                foreach ($lesMatchsAVenir as $matchAVenir) { //Pour chaque match à venir
                    $i =0;
                    if (!empty($myBets)) { //On vérifie que l'utilisateur a déjà parié
                        $nbBet = 0;
                        foreach ($myBets as $myBet) { //Pour chaque paris
                            if ($matchAVenir->getId() == $myBet->getMatch()->getId()) { //Si l'utilisateur a pas déjà parié sur ce match
                                $nbBet++;
                            }
                        }
                        if ($nbBet == 0) { //Si l'utilisateur n'a jamais parié sur ce match
                            $listematchs[] = $matchAVenir;
                        }
                        $i ++;
                    }
                    if($i == 0){ //Si le match n'a pas été encore ajouté
                        $listematchs[] = $matchAVenir;
                    }
                }
                if(empty($listematchs)){
                    $this->addFlash('warning', 'Aucun match n\'est disponible !');
                }
            }
            else{
                $this->addFlash('warning', 'Aucun match n\'est disponible !');
            }
        }
        else { //Si l'utilisateur n'est pas connecté
            if($this->matchIsNotOver() != false) {
                $lesMatchsAVenir = $this->matchIsNotOver();
                foreach ($lesMatchsAVenir as $matchAVenir) { //Pour chaque match à venir
                    $listematchs[] = $matchAVenir;
                }
            }
            else{
                $this->addFlash('warning', 'Aucun match n\'est disponible !');
            }
        }
        return $this->render('bet/formBet.html.twig', ['matchs' => $listematchs]);
    }
    public function toBet($id,Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $match = $this->getDoctrine()->getRepository(Match::class)->find($id);
        $user = $this->getUser();
        if ($this->checkConnexion() != false){
            if(isset($_POST['result']) OR $_POST['result'] >= 0 AND $_POST['result'] <= 2){
                $result = $_POST['result'];
                if($match->getDateTime() >= new \DateTime()){
                    if($this->checkMyBets() != false){
                        $myBets = $this->checkMyBets();
                        $nbBet = 0;
                        foreach($myBets as $myBet){
                            if($myBet->getMatch()->getId() == $match->getId()){
                                $nbBet ++;
                            }
                        }
                        if($nbBet == 0){
                            $bet = new Bet();
                            $bet->setUser($user);
                            $bet->setMatch($match);
                            $bet->setResult($result);
                            $bet->setBetDatetime(new \DateTime());

                            $entityManager->persist($bet); //stocké en mémoire dans la collection de livres
                            $entityManager->flush(); // synchronisation avec la BDD -> production d'un ordre SQL de type INSERT

                        }
                        $nbBet ++;
                    }
                    if($nbBet == 0){
                        $bet = new Bet();
                        $bet->setUser($user);
                        $bet->setMatch($match);
                        $bet->setResult($result);
                        $bet->setBetDatetime(new \DateTime());

                        $entityManager->persist($bet); //stocké en mémoire dans la collection de livres
                        $entityManager->flush(); // synchronisation avec la BDD -> production d'un ordre SQL de type INSERT
                    }
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
        $this->addFlash('success', 'Le paris a bien été enregistré');
        return $this->redirectToRoute('paris');
    }
    /*public function toBet($id,Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $match = $this->getDoctrine()->getRepository(Match::class)->find($id);
        $user = $this->getUser();
        if($user != null){
            if(isset($_POST['result']) AND $_POST['result'] >= 0 AND $_POST['result'] <= 2){
                $result = $_POST['result'];
                if($match->getDateTime() >= new \DateTime()){
                    $myBets = $this->checkMyBets();
                    if(!empty($myBets)){
                        foreach($myBets as $myBet){
                            if($myBet->getMatch()->getId() != $match->getId()){
                                $bet = new Bet();
                                $bet->setUser($user);
                                $bet->setMatch($match);
                                $bet->setResult($result);
                                $bet->setBetDatetime(new \DateTime());

                                $entityManager->persist($bet); //stocké en mémoire dans la collection de livres
                                $entityManager->flush(); // synchronisation avec la BDD -> production d'un ordre SQL de type INSERT
                            }
                        }
                    }
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
        $this->addFlash('success', 'Le paris a bien été enregistré');
        return $this->redirectToRoute('paris');
    }*/
    public function mesParis(){
        if($this->checkConnexion() != false){
            if($this->checkMyBets() != false){
                $myBets = $this->checkMyBets();
                $listBetWaiting = array();
                $listBetWin = array();
                $listBetLose = array();
                foreach($myBets as $myBet){
                    if($myBet->getMatch()->getDateTime() >= new \DateTime()) {
                        $listBetWaiting[] = $myBet;
                    }
                    else {
                        if($myBet->getResult() === $myBet->getMatch()->getResult()){
                            $listBetWin[] = $myBet;
                        }
                        else{
                            $listBetLose[] = $myBet;
                        }
                    }
                }
                if(empty($listBetWaiting) AND empty($listBetFinished)){
                    $this->addFlash('error', 'Vous n\'avez effectué aucun paris !');
                }
            }
            else{
                $this->addFlash('error', 'Vous n\'avez effectué aucun paris !');
            }
        }
        else{
            return $this->redirectToRoute('login');
        }
        return $this->render('bet/mesParis.html.twig', ['bets_encours'=> $listBetWaiting, 'bets_win'=>$listBetWin, 'bets_lose'=>$listBetLose]);
    }
}
