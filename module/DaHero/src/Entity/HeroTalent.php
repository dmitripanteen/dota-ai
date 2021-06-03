<?php

namespace DaHero\Entity;

use DaBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="DaHero\Repository\HeroTalentRepository")
 * @ORM\Table(name="hero_talent")
 */
class HeroTalent extends AbstractEntity
{
    const MAIN_ATTR_STRENGTH = 1;
    const MAIN_ATTR_AGILITY = 2;
    const MAIN_ATTR_INTELLIGENCE = 3;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var Hero
     *
     * @ORM\ManyToOne(targetEntity="DaHero\Entity\Hero", inversedBy="id")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    protected $hero;

    /**
     * @var int
     *
     * @ORM\Column(type="integer" , nullable=false)
     */
    protected $level;

    /**
     * @var string
     *
     * @ORM\Column(type="string" , nullable=false)
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $dmgIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $armorIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $msIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $strIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $agiIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $intIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $hpIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $mpIncrease;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false, options={"default" : 0})
     */
    protected $hpRegenIncrease;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false, options={"default" : 0})
     */
    protected $mpRegenIncrease;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return HeroTalent
     */
    public function setHero($hero): self
    {
        $this->hero = $hero;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param $level
     *
     * @return HeroTalent
     */
    public function setLevel($level): self
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     *
     * @return HeroTalent
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getDmgIncrease()
    {
        return $this->dmgIncrease;
    }

    /**
     * @param $dmgIncrease
     *
     * @return HeroTalent
     */
    public function setDmgIncrease($dmgIncrease): self
    {
        $this->dmgIncrease = $dmgIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getArmorIncrease()
    {
        return $this->armorIncrease;
    }

    /**
     * @param $armorIncrease
     *
     * @return HeroTalent
     */
    public function setArmorIncrease($armorIncrease): self
    {
        $this->armorIncrease = $armorIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getMsIncrease()
    {
        return $this->msIncrease;
    }

    /**
     * @param $msIncrease
     *
     * @return HeroTalent
     */
    public function setMsIncrease($msIncrease): self
    {
        $this->msIncrease = $msIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getStrIncrease()
    {
        return $this->strIncrease;
    }

    /**
     * @param $strIncrease
     *
     * @return HeroTalent
     */
    public function setStrIncrease($strIncrease): self
    {
        $this->strIncrease = $strIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getAgiIncrease()
    {
        return $this->agiIncrease;
    }

    /**
     * @param $agiIncrease
     *
     * @return HeroTalent
     */
    public function setAgiIncrease($agiIncrease): self
    {
        $this->agiIncrease = $agiIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getIntIncrease()
    {
        return $this->intIncrease;
    }

    /**
     * @param $intIncrease
     *
     * @return HeroTalent
     */
    public function setIntIncrease($intIncrease): self
    {
        $this->intIncrease = $intIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getHpIncrease()
    {
        return $this->hpIncrease;
    }

    /**
     * @param $hpIncrease
     *
     * @return HeroTalent
     */
    public function setHpIncrease($hpIncrease): self
    {
        $this->hpIncrease = $hpIncrease;
        return $this;
    }

    /**
     * @return int
     */
    public function getMpIncrease()
    {
        return $this->mpIncrease;
    }

    /**
     * @param $mpIncrease
     *
     * @return HeroTalent
     */
    public function setMpIncrease($mpIncrease): self
    {
        $this->mpIncrease = $mpIncrease;
        return $this;
    }

    /**
     * @return float
     */
    public function getHpRegenIncrease()
    {
        return $this->hpRegenIncrease;
    }

    /**
     * @param $hpRegenIncrease
     *
     * @return HeroTalent
     */
    public function setHpRegenIncrease($hpRegenIncrease): self
    {
        $this->hpRegenIncrease = $hpRegenIncrease;
        return $this;
    }

    /**
     * @return float
     */
    public function getMpRegenIncrease()
    {
        return $this->mpRegenIncrease;
    }

    /**
     * @param $mpRegenIncrease
     *
     * @return HeroTalent
     */
    public function setMpRegenIncrease($mpRegenIncrease): self
    {
        $this->mpRegenIncrease = $mpRegenIncrease;
        return $this;
    }

}