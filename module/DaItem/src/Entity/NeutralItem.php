<?php

namespace DaItem\Entity;

use DaBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="neutral_item")
 */
class NeutralItem extends AbstractEntity
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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $alias;

    /**
     * @var string
     *
     * @ORM\Column(type="text" , nullable=true)
     */
    protected $lore;

    /**
     * @var string
     *
     * @ORM\Column(type="text" , nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dmgIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $strIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $agiIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $intIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $hpIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $mpIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $hpRegenIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $mpRegenIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $armorIncrease;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $msIncrease;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tier;

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
     * @return NeutralItem
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return NeutralItem
     */
    public function setAlias($alias): self
    {
        $this->alias = $alias;
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
     * @return NeutralItem
     */
    public function setLore($lore): self
    {
        $this->lore = $lore;
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
     * @return NeutralItem
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDmgIncrease()
    {
        return $this->strIncrease;
    }

    /**
     * @param string $dmgIncrease
     *
     * @return NeutralItem
     */
    public function setDmgIncrease($dmgIncrease): self
    {
        $this->dmgIncrease = $dmgIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrIncrease()
    {
        return $this->strIncrease;
    }

    /**
     * @param string $strIncrease
     *
     * @return NeutralItem
     */
    public function setStrIncrease($strIncrease): self
    {
        $this->strIncrease = $strIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgiIncrease()
    {
        return $this->agiIncrease;
    }

    /**
     * @param string $agiIncrease
     *
     * @return NeutralItem
     */
    public function setAgiIncrease($agiIncrease): self
    {
        $this->agiIncrease = $agiIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntIncrease()
    {
        return $this->intIncrease;
    }

    /**
     * @param string $intIncrease
     *
     * @return NeutralItem
     */
    public function setIntIncrease($intIncrease): self
    {
        $this->intIncrease = $intIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getHpIncrease()
    {
        return $this->hpIncrease;
    }

    /**
     * @param string $hpIncrease
     *
     * @return NeutralItem
     */
    public function setHpIncrease($hpIncrease): self
    {
        $this->hpIncrease = $hpIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getMpIncrease()
    {
        return $this->mpIncrease;
    }

    /**
     * @param string $mpIncrease
     *
     * @return NeutralItem
     */
    public function setMpIncrease($mpIncrease): self
    {
        $this->mpIncrease = $mpIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getHpRegenIncrease()
    {
        return $this->hpRegenIncrease;
    }

    /**
     * @param string $hpRegenIncrease
     *
     * @return NeutralItem
     */
    public function setHpRegenIncrease($hpRegenIncrease): self
    {
        $this->hpRegenIncrease = $hpRegenIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getMpRegenIncrease()
    {
        return $this->mpRegenIncrease;
    }

    /**
     * @param string $mpRegenIncrease
     *
     * @return NeutralItem
     */
    public function setMpRegenIncrease($mpRegenIncrease): self
    {
        $this->mpRegenIncrease = $mpRegenIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getArmorIncrease()
    {
        return $this->armorIncrease;
    }

    /**
     * @param string $armorIncrease
     *
     * @return NeutralItem
     */
    public function setArmorIncrease($armorIncrease): self
    {
        $this->armorIncrease = $armorIncrease;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoveSpeedIncrease()
    {
        return $this->msIncrease;
    }

    /**
     * @param string $moveSpeedIncrease
     *
     * @return NeutralItem
     */
    public function setMoveSpeedIncrease($moveSpeedIncrease): self
    {
        $this->msIncrease = $moveSpeedIncrease;
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
     * @return NeutralItem
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return int
     */
    public function getTier()
    {
        return $this->tier;
    }

    /**
     * @param int $tier
     *
     * @return NeutralItem
     */
    public function setTier($tier): self
    {
        $this->tier = $tier;
        return $this;
    }

}