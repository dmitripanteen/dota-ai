<?php

namespace DaMatch\Entity;

use DaBase\Entity\AbstractEntity;
use DaHero\Entity\Hero;
use DaItem\Entity\Item;
use DaItem\Entity\NeutralItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="match_player")
 */
class MatchPlayer extends AbstractEntity
{

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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $accountId;

    /**
     * @var Match
     *
     * @ORM\ManyToOne(targetEntity="DaMatch\Entity\Match", inversedBy="id")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    protected $match;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $kills;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $deaths;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $assists;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $denies;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $lastHits;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $backpack0;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $backpack1;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $backpack2;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $backpack3;

    /**
     * @var Hero
     *
     * @ORM\ManyToOne(targetEntity="DaHero\Entity\Hero", inversedBy="id")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $hero;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $item0;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $item1;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $item2;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $item3;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $item4;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\Item", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $item5;

    /**
     * @var NeutralItem|null
     *
     * @ORM\ManyToOne(targetEntity="DaItem\Entity\NeutralItem", inversedBy="id")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $neutralItem;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $personaName;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isRadiant;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $win;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $lose;

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
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     *
     * @return MatchPlayer
     */
    public function setAccountId($accountId): self
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param Match $match
     *
     * @return MatchPlayer
     */
    public function setMatch(Match $match): self
    {
        $this->match = $match;
        return $this;
    }

    /**
     * @return integer
     */
    public function getKills()
    {
        return $this->kills;
    }

    /**
     * @param int $kills
     *
     * @return MatchPlayer
     */
    public function setKills($kills): self
    {
        $this->kills = $kills;
        return $this;
    }

    /**
     * @return integer
     */
    public function getDeaths()
    {
        return $this->deaths;
    }

    /**
     * @param int $deaths
     *
     * @return MatchPlayer
     */
    public function setDeaths($deaths): self
    {
        $this->deaths = $deaths;
        return $this;
    }

    /**
     * @return integer
     */
    public function getAssists()
    {
        return $this->assists;
    }

    /**
     * @param int $assists
     *
     * @return MatchPlayer
     */
    public function setAssists($assists): self
    {
        $this->assists = $assists;
        return $this;
    }

    /**
     * @return integer
     */
    public function getDenies()
    {
        return $this->denies;
    }

    /**
     * @param int $denies
     *
     * @return MatchPlayer
     */
    public function setDenies($denies): self
    {
        $this->denies = $denies;
        return $this;
    }

    /**
     * @return integer
     */
    public function getLastHits()
    {
        return $this->lastHits;
    }

    /**
     * @param int $lastHits
     *
     * @return MatchPlayer
     */
    public function setLastHits($lastHits): self
    {
        $this->lastHits = $lastHits;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getBackpack0()
    {
        return $this->backpack0;
    }

    /**
     * @param Item|null $backpack0
     *
     * @return MatchPlayer
     */
    public function setBackpack0($backpack0): self
    {
        $this->backpack0 = $backpack0;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getBackpack1()
    {
        return $this->backpack1;
    }

    /**
     * @param Item|null $backpack1
     *
     * @return MatchPlayer
     */
    public function setBackpack1($backpack1): self
    {
        $this->backpack1 = $backpack1;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getBackpack2()
    {
        return $this->backpack2;
    }

    /**
     * @param Item|null $backpack2
     *
     * @return MatchPlayer
     */
    public function setBackpack2($backpack2): self
    {
        $this->backpack2 = $backpack2;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getBackpack3()
    {
        return $this->backpack3;
    }

    /**
     * @param Item|null $backpack3
     *
     * @return MatchPlayer
     */
    public function setBackpack3($backpack3): self
    {
        $this->backpack3 = $backpack3;
        return $this;
    }

    /**
     * @return Hero
     */
    public function getHero()
    {
        return $this->hero;
    }

    /**
     * @param Hero $hero
     *
     * @return MatchPlayer
     */
    public function setHero($hero): self
    {
        $this->hero = $hero;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getItem0()
    {
        return $this->item0;
    }

    /**
     * @param Item|null $item0
     *
     * @return MatchPlayer
     */
    public function setItem0($item0): self
    {
        $this->item0 = $item0;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getItem1()
    {
        return $this->item1;
    }

    /**
     * @param Item|null $item1
     *
     * @return MatchPlayer
     */
    public function setItem1($item1): self
    {
        $this->item1 = $item1;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getItem2()
    {
        return $this->item2;
    }

    /**
     * @param Item|null $item2
     *
     * @return MatchPlayer
     */
    public function setItem2($item2): self
    {
        $this->item2 = $item2;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getItem3()
    {
        return $this->item3;
    }

    /**
     * @param Item|null $item3
     *
     * @return MatchPlayer
     */
    public function setItem3($item3): self
    {
        $this->item3 = $item3;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getItem4()
    {
        return $this->item4;
    }

    /**
     * @param Item|null $item4
     *
     * @return MatchPlayer
     */
    public function setItem4($item4): self
    {
        $this->item4 = $item4;
        return $this;
    }

    /**
     * @return Item|null
     */
    public function getItem5()
    {
        return $this->item5;
    }

    /**
     * @param Item|null $item5
     *
     * @return MatchPlayer
     */
    public function setItem5($item5): self
    {
        $this->item5 = $item5;
        return $this;
    }

    /**
     * @return NeutralItem|null
     */
    public function getNeutralItem()
    {
        return $this->neutralItem;
    }

    /**
     * @param NeutralItem|null $neutralItem
     *
     * @return MatchPlayer
     */
    public function setNeutralItem($neutralItem): self
    {
        $this->neutralItem = $neutralItem;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonaName()
    {
        return $this->personaName;
    }

    /**
     * @param string $personaName
     *
     * @return MatchPlayer
     */
    public function setPersonaName($personaName): self
    {
        $this->personaName = $personaName;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRadiant()
    {
        return $this->isRadiant;
    }

    /**
     * @param bool $isRadiant
     *
     * @return MatchPlayer
     */
    public function setIsRadiant($isRadiant): self
    {
        $this->isRadiant = $isRadiant;
        return $this;
    }

    /**
     * @return bool
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * @param bool $win
     *
     * @return MatchPlayer
     */
    public function setWin($win): self
    {
        $this->win = $win;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLose()
    {
        return $this->lose;
    }

    /**
     * @param bool $lose
     *
     * @return MatchPlayer
     */
    public function setLose($lose): self
    {
        $this->lose = $lose;
        return $this;
    }

}