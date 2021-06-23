<?php

namespace DaItem\Entity;

use DaBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item extends AbstractEntity
{

    const TYPE_BASIC = 1;
    const TYPE_UPGRADE = 2;

    const CATEGORY_CONSUMABLES = 1;
    const CATEGORY_ATTRIBUTES = 2;
    const CATEGORY_EQUIPMENT = 3;
    const CATEGORY_MISCELLANEOUS = 4;
    const CATEGORY_SECRET_SHOP = 5;
    const CATEGORY_ROSHAN_DROP = 6;
    const CATEGORY_ACCESSORIES = 7;
    const CATEGORY_SUPPORT = 8;
    const CATEGORY_MAGICAL = 9;
    const CATEGORY_ARMOR = 10;
    const CATEGORY_WEAPONS = 11;
    const CATEGORY_ARTIFACTS = 12;

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
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $price;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $dmgIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $strIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $agiIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $intIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $hpIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $mpIncrease;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $hpRegenIncrease;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $mpRegenIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $armorIncrease;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
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
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $category;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $buildsInto;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isRecipeRequired;

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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     *
     * @return Item
     */
    public function setPrice($price): self
    {
        $this->price = $price;
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
     * @param int $dmgIncrease
     *
     * @return Item
     */
    public function setDmgIncrease($dmgIncrease): self
    {
        $this->dmgIncrease = $dmgIncrease;
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
     * @param int $strIncrease
     *
     * @return Item
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
     * @param int $agiIncrease
     *
     * @return Item
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
     * @param int $intIncrease
     *
     * @return Item
     */
    public function setIntIncrease($intIncrease): self
    {
        $this->intIncrease = $intIncrease;
        return $this;
    }

    /**
     * @return float
     */
    public function getHpIncrease()
    {
        return $this->hpIncrease;
    }

    /**
     * @param float $hpIncrease
     *
     * @return Item
     */
    public function setHpIncrease($hpIncrease): self
    {
        $this->hpIncrease = $hpIncrease;
        return $this;
    }

    /**
     * @return float
     */
    public function getMpIncrease()
    {
        return $this->mpIncrease;
    }

    /**
     * @param float $mpIncrease
     *
     * @return Item
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
     * @param float $hpRegenIncrease
     *
     * @return Item
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
     * @param float $mpRegenIncrease
     *
     * @return Item
     */
    public function setMpRegenIncrease($mpRegenIncrease): self
    {
        $this->mpRegenIncrease = $mpRegenIncrease;
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
     * @param int $armorIncrease
     *
     * @return Item
     */
    public function setArmorIncrease($armorIncrease): self
    {
        $this->armorIncrease = $armorIncrease;
        return $this;
    }

    /**
     * @return integer
     */
    public function getMoveSpeedIncrease()
    {
        return $this->msIncrease;
    }

    /**
     * @param int $moveSpeedIncrease
     *
     * @return Item
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
     * @return Item
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Item
     */
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     *
     * @return Item
     */
    public function setCategory($category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return array
     */
    public function getBuildsInto()
    {
        return $this->buildsInto;
    }

    /**
     * @param array $buildsInto
     *
     * @return Item
     */
    public function setBuildsInto($buildsInto): self
    {
        $this->buildsInto = $buildsInto;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRecipeRequired()
    {
        return $this->isRecipeRequired;
    }

    /**
     * @param bool $isRecipeRequired
     *
     * @return Item
     */
    public function setIsRecipeRequired($isRecipeRequired): self
    {
        $this->isRecipeRequired = $isRecipeRequired;
        return $this;
    }

}