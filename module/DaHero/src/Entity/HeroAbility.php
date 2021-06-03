<?php

namespace DaHero\Entity;

use DaBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="DaHero\Repository\HeroAbilityRepository")
 * @ORM\Table(name="hero_ability")
 */
class HeroAbility extends AbstractEntity
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
     * @var string
     *
     * @ORM\Column(type="string" , nullable=false)
     */
    protected $abilityName;

    /**
     * @var string
     *
     * @ORM\Column(type="text" , nullable=false)
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default" : 1})
     */
    protected $abilityNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $video;

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
     * @return HeroAbility
     */
    public function setHero($hero): self
    {
        $this->hero = $hero;
        return $this;
    }

    /**
     * @return int
     */
    public function getAbilityName()
    {
        return $this->abilityName;
    }

    /**
     * @param $abilityName
     *
     * @return HeroAbility
     */
    public function setAbilityName($abilityName): self
    {
        $this->abilityName = $abilityName;
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
     * @return HeroAbility
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getAbilityNumber()
    {
        return $this->abilityNumber;
    }

    /**
     * @param $abilityNumber
     *
     * @return HeroAbility
     */
    public function setAbilityNumber($abilityNumber): self
    {
        $this->abilityNumber = $abilityNumber;
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
     * @param $image
     *
     * @return HeroAbility
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param $video
     *
     * @return HeroAbility
     */
    public function setVideo($video): self
    {
        $this->video = $video;
        return $this;
    }

}