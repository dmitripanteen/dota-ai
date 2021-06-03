<?php

namespace DaHero\Entity;

use DaBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hero")
 */
class Hero extends AbstractEntity
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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text" , nullable=true)
     */
    protected $lore;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $mainAttr;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $baseStr;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $strGain;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $baseAgi;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $agiGain;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $baseInt;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $intGain;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $baseDamageMin;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $baseDamageMax;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $baseHp;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $baseArmor;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $baseMoveSpeed;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Hero
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLore()
    {
        return $this->lore;
    }

    /**
     * @param $lore
     *
     * @return Hero
     */
    public function setLore($lore): self
    {
        $this->lore = $lore;
        return $this;
    }

    /**
     * @return string
     */
    public function getMainAttribute()
    {
        return $this->mainAttr;
    }

    /**
     * @param int $mainAttr
     *
     * @return Hero
     */
    public function setMainAttribute($mainAttr): self
    {
        $this->mainAttr = $mainAttr;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseStr()
    {
        return $this->baseStr;
    }

    /**
     * @param int $baseStr
     *
     * @return Hero
     */
    public function setBaseStr($baseStr): self
    {
        $this->baseStr = $baseStr;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseAgi()
    {
        return $this->baseAgi;
    }

    /**
     * @param int $baseAgi
     *
     * @return Hero
     */
    public function setBaseAgi($baseAgi): self
    {
        $this->baseAgi = $baseAgi;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseInt()
    {
        return $this->baseStr;
    }

    /**
     * @param int $baseInt
     *
     * @return Hero
     */
    public function setBaseInt($baseInt): self
    {
        $this->baseInt = $baseInt;
        return $this;
    }

    /**
     * @return float
     */
    public function getStrGain()
    {
        return $this->strGain;
    }

    /**
     * @param float $strGain
     *
     * @return Hero
     */
    public function setStrGain($strGain): self
    {
        $this->strGain = $strGain;
        return $this;
    }

    /**
     * @return float
     */
    public function getAgiGain()
    {
        return $this->agiGain;
    }

    /**
     * @param float $agiGain
     *
     * @return Hero
     */
    public function setAgiGain($agiGain): self
    {
        $this->agiGain = $agiGain;
        return $this;
    }

    /**
     * @return float
     */
    public function getIntGain()
    {
        return $this->intGain;
    }

    /**
     * @param float $intGain
     *
     * @return Hero
     */
    public function setIntGain($intGain): self
    {
        $this->intGain = $intGain;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseDamageMin()
    {
        return $this->baseDamageMin;
    }

    /**
     * @param int $baseDamageMin
     *
     * @return Hero
     */
    public function setBaseDamageMin($baseDamageMin): self
    {
        $this->baseDamageMin = $baseDamageMin;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseDamageMax()
    {
        return $this->baseDamageMax;
    }

    /**
     * @param int $baseDamageMax
     *
     * @return Hero
     */
    public function setBaseDamageMax($baseDamageMax): self
    {
        $this->baseDamageMax = $baseDamageMax;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseHp()
    {
        return $this->baseHp;
    }

    /**
     * @param int $baseHp
     *
     * @return Hero
     */
    public function setBaseHp($baseHp): self
    {
        $this->baseHp = $baseHp;
        return $this;
    }

    /**
     * @return float
     */
    public function getBaseArmor()
    {
        return $this->baseArmor;
    }

    /**
     * @param float $baseArmor
     *
     * @return Hero
     */
    public function setBaseArmor($baseArmor): self
    {
        $this->baseArmor = $baseArmor;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBaseMoveSpeed()
    {
        return $this->baseMoveSpeed;
    }

    /**
     * @param int $baseMoveSpeed
     *
     * @return Hero
     */
    public function setBaseMoveSpeed($baseMoveSpeed): self
    {
        $this->baseMoveSpeed = $baseMoveSpeed;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Hero
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

}