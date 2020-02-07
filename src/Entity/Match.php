<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 * @ORM\Table(name="match")
 */
class Match
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="match_idmatch_seq")
     * @ORM\Column(type="integer",name="idmatch")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="id_dom", referencedColumnName="idteam")
     */
    private $team_dom;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="id_ext", referencedColumnName="idteam")
     */
    private $team_ext;
    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $score_dom;
    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $score_ext;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;
    /**
     * @ORM\Column(type="datetimetz")
     */
    private $datetime;
    /**
     * @ORM\Column(type="integer")
     */
    private $result;

    public function getScoreDom(): ?int
    {
        return $this->score_dom;
    }

    public function setScoreDom(int $score_dom): self
    {
        $this->score_dom = $score_dom;

        return $this;
    }

    public function getScoreExt(): ?int
    {
        return $this->score_ext;
    }

    public function setScoreExt(int $score_ext): self
    {
        $this->score_ext = $score_ext;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getTeamDom(): ?Team
    {
        return $this->team_dom;
    }

    public function setTeamDom(?Team $team_dom): self
    {
        $this->team_dom = $team_dom;

        return $this;
    }

    public function getTeamExt(): ?Team
    {
        return $this->team_ext;
    }

    public function setTeamExt(?Team $team_ext): self
    {
        $this->team_ext = $team_ext;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }
}