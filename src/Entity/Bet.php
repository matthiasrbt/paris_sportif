<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BetRepository")
 * @ORM\Table(name="bet")
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="iduser", referencedColumnName="iduser")
     */
    private $user;
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Match")
     * @ORM\JoinColumn(name="idmatch", referencedColumnName="idmatch")
     */
    private $match;
    /**
     * @ORM\Column(type="integer")
     */
    private $result;
    /**
     * @ORM\Column(type="datetimetz")
     */
    private $bet_datetime;

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMatch(): ?Match
    {
        return $this->match;
    }

    public function setMatch(?Match $match): self
    {
        $this->match = $match;

        return $this;
    }

    public function getBetDatetime(): ?\DateTimeInterface
    {
        return $this->bet_datetime;
    }

    public function setBetDatetime(\DateTimeInterface $bet_datetime): self
    {
        $this->bet_datetime = $bet_datetime;

        return $this;
    }
}