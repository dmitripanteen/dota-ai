<?php

namespace DaMatch\Entity;

use DaBase\Entity\AbstractEntity;
use DaHero\Entity\Hero;
use DaItem\Entity\Item;
use DaItem\Entity\NeutralItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="matches")
 */
class Match extends AbstractEntity
{

    const GAME_MODE_CAPTAINS_MODE = 2;
    const GAME_MODE_RANDOM_DRAFT = 3;
    const GAME_MODE_SINGLE_DRAFT = 4;
    const GAME_MODE_ALL_RANDOM = 5;
    const GAME_MODE_ALL_PICK = 22;
    const GAME_MODE_TURBO = 23;

    const LOBBY_TYPE_NORMAL = 0;
    const LOBBY_TYPE_RANKED = 7;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $openDotaMatchId;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player0;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player1;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player2;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player3;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player4;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player5;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player6;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player7;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player8;

    /**
     * @var MatchPlayer|null
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\MatchPlayer", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $player9;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $duration;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $radiantScore;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $direScore;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $lobbyType;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $gameMode;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $radiantWin;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $startTime;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getOpenDotaMatchId()
    {
        return $this->openDotaMatchId;
    }

    /**
     * @param int $openDotaMatchId
     *
     * @return Match
     */
    public function setOpenDotaMatchId($openDotaMatchId): self
    {
        $this->openDotaMatchId = $openDotaMatchId;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer0()
    {
        return $this->player0;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer0($player): self
    {
        $this->player0 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer1($player): self
    {
        $this->player1 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer2($player): self
    {
        $this->player2 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer3()
    {
        return $this->player3;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer3($player): self
    {
        $this->player3 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer4()
    {
        return $this->player4;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer4($player): self
    {
        $this->player4 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer5()
    {
        return $this->player5;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer5($player): self
    {
        $this->player5 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer6()
    {
        return $this->player6;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer6($player): self
    {
        $this->player6 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer7()
    {
        return $this->player7;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer7($player): self
    {
        $this->player7 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer8()
    {
        return $this->player8;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer8($player): self
    {
        $this->player8 = $player;
        return $this;
    }

    /**
     * @return MatchPlayer|null
     */
    public function getPlayer9()
    {
        return $this->player9;
    }

    /**
     * @param MatchPlayer|null $player
     *
     * @return Match
     */
    public function setPlayer9($player): self
    {
        $this->player9 = $player;
        return $this;
    }

    /**
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return Match
     */
    public function setDuration($duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return integer
     */
    public function getRadiantScore()
    {
        return $this->radiantScore;
    }

    /**
     * @param int $radiantScore
     *
     * @return Match
     */
    public function setRadiantScore($radiantScore): self
    {
        $this->radiantScore = $radiantScore;
        return $this;
    }

    /**
     * @return integer
     */
    public function getDireScore()
    {
        return $this->direScore;
    }

    /**
     * @param int $direScore
     *
     * @return Match
     */
    public function setDireScore($direScore): self
    {
        $this->direScore = $direScore;
        return $this;
    }

    /**
     * @return integer
     */
    public function getLobbyType()
    {
        return $this->lobbyType;
    }

    /**
     * @param int $lobbyType
     *
     * @return Match
     */
    public function setLobbyType($lobbyType): self
    {
        $this->lobbyType = $lobbyType;
        return $this;
    }

    /**
     * @return integer
     */
    public function getGameMode()
    {
        return $this->gameMode;
    }

    /**
     * @param int $gameMode
     *
     * @return Match
     */
    public function setGameMode($gameMode): self
    {
        $this->gameMode = $gameMode;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRadiantWin()
    {
        return $this->radiantWin;
    }

    /**
     * @param bool $radiantWin
     *
     * @return Match
     */
    public function setRadiantWin($radiantWin): self
    {
        $this->radiantWin = $radiantWin;
        return $this;
    }

    /**
     * @return integer
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param int $startTime
     *
     * @return Match
     */
    public function setStartTime($startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

}