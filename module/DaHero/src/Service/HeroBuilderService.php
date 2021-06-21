<?php

namespace DaHero\Service;

use DaHero\Entity\Hero;
use DaHero\Entity\HeroAbility;
use DaHero\Entity\HeroTalent;
use DaHero\Repository\HeroAbilityRepository;
use DaHero\Repository\HeroRepository;
use DaHero\Repository\HeroTalentRepository;
use DaItem\Entity\Item;
use DaItem\Entity\NeutralItem;
use DaItem\Repository\ItemRepository;
use DaItem\Repository\NeutralItemRepository;
use Doctrine\ORM\EntityManager;

class HeroBuilderService
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var HeroRepository
     */
    protected $heroRepository;

    /**
     * @var ItemRepository
     */
    protected $itemRepository;

    /**
     * @var NeutralItemRepository
     */
    protected $neutralItemRepository;

    /**
     * @var HeroTalentRepository
     */
    protected $heroTalentRepository;

    /**
     * @var HeroAbilityRepository
     */
    protected $heroAbilityRepository;

    /**
     * HeroBuilderService constructor.
     *
     * @param EntityManager $entityManager
     * @param               $heroRepository
     * @param               $itemRepository
     * @param               $neutralItemRepository
     * @param               $heroTalentRepository
     * @param               $heroAbilityRepository
     */
    public function __construct(
        EntityManager $entityManager,
        $heroRepository,
        $itemRepository,
        $neutralItemRepository,
        $heroTalentRepository,
        $heroAbilityRepository
    ) {
        $this->entityManager = $entityManager;
        $this->heroRepository = $heroRepository;
        $this->itemRepository = $itemRepository;
        $this->neutralItemRepository = $neutralItemRepository;
        $this->heroTalentRepository = $heroTalentRepository;
        $this->heroAbilityRepository = $heroAbilityRepository;
    }

    public function getHeroesList()
    {
        return $this->heroRepository->findAll();
    }

    public function computeHeroStats($hero, $level, $talentsFromQuery, $itemsFromQuery, $neutralItemFromQuery)
    {
        /**
         * @var $hero          Hero
         * @var $heroAbilities HeroAbility[]
         * @var $heroTalents   HeroTalent[]
         * @var $talentRes     HeroTalent
         * @var $itemRes       Item
         * @var $neutralItem   NeutralItem
         */
        $heroAbilities = $this->heroAbilityRepository->findAbilitiesByHero($hero);
        $heroTalents = $this->heroTalentRepository->findTalentsByHero($hero);
        $statsAmplifiers = [
            'dmg'     => 0,
            'armor'   => 0,
            'ms'      => 0,
            'str'     => 0,
            'agi'     => 0,
            'int'     => 0,
            'hp'      => 0,
            'mp'      => 0,
            'hpRegen' => 0,
            'mpRegen' => 0,
        ];
        if($talentsFromQuery) {
            $talentIdsFromQuery = explode(',', $talentsFromQuery);
            foreach ($talentIdsFromQuery as $talentFromQuery) {
                $talentRes = $this->heroTalentRepository->findById($talentFromQuery);
                $statsAmplifiers['dmg'] += $talentRes->getDmgIncrease();
                $statsAmplifiers['armor'] += $talentRes->getArmorIncrease();
                $statsAmplifiers['ms'] += $talentRes->getMsIncrease();
                $statsAmplifiers['str'] += $talentRes->getStrIncrease();
                $statsAmplifiers['agi'] += $talentRes->getAgiIncrease();
                $statsAmplifiers['int'] += $talentRes->getIntIncrease();
                $statsAmplifiers['hp'] += $talentRes->getHpIncrease();;
                $statsAmplifiers['mp'] += $talentRes->getMpIncrease();;
                $statsAmplifiers['hpRegen'] += $talentRes->getHpRegenIncrease();
                $statsAmplifiers['mpRegen'] += $talentRes->getMpRegenIncrease();
            }
        }
        if($itemsFromQuery) {
            $itemIdsFromQuery = explode(',', $itemsFromQuery);
            foreach ($itemIdsFromQuery as $itemFromQuery) {
                $itemRes = $this->itemRepository->findById($itemFromQuery)[0];
                $statsAmplifiers['dmg'] += $itemRes->getDmgIncrease();
                $statsAmplifiers['armor'] += $itemRes->getArmorIncrease();
                $statsAmplifiers['ms'] += $itemRes->getMoveSpeedIncrease();
                $statsAmplifiers['str'] += $itemRes->getStrIncrease();
                $statsAmplifiers['agi'] += $itemRes->getAgiIncrease();
                $statsAmplifiers['int'] += $itemRes->getIntIncrease();
                $statsAmplifiers['hp'] += $itemRes->getHpIncrease();;
                $statsAmplifiers['mp'] += $itemRes->getMpIncrease();;
                $statsAmplifiers['hpRegen'] += $itemRes->getHpRegenIncrease();
                $statsAmplifiers['mpRegen'] += $itemRes->getMpRegenIncrease();
            }
        }
        if($neutralItemFromQuery) {
            $neutralItem = $this->neutralItemRepository->findById($neutralItemFromQuery)[0];
            $neutralAmplifiers = [
                'dmg'     => [
                    'type' => (is_numeric($neutralItem->getDmgIncrease()) || is_null($neutralItem->getDmgIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getDmgIncrease()) || is_null($neutralItem->getDmgIncrease())) ?
                        intval($neutralItem->getDmgIncrease()) :
                        1 + intval($neutralItem->getDmgIncrease())/100,
                    ],
                'armor'   => [
                    'type' => (is_numeric($neutralItem->getArmorIncrease()) || is_null($neutralItem->getArmorIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getArmorIncrease()) || is_null($neutralItem->getArmorIncrease())) ?
                        intval($neutralItem->getArmorIncrease()) :
                        1 + intval($neutralItem->getArmorIncrease())/100,
                ],
                'ms'      => [
                    'type' => (is_numeric($neutralItem->getMoveSpeedIncrease()) || is_null($neutralItem->getMoveSpeedIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getMoveSpeedIncrease()) || is_null($neutralItem->getMoveSpeedIncrease())) ?
                        intval($neutralItem->getMoveSpeedIncrease()) :
                        1 + intval($neutralItem->getMoveSpeedIncrease())/100,
                ],
                'str'     => [
                    'type' => (is_numeric($neutralItem->getStrIncrease()) || is_null($neutralItem->getStrIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getStrIncrease()) || is_null($neutralItem->getStrIncrease())) ?
                        intval($neutralItem->getStrIncrease()) :
                        1 + intval($neutralItem->getStrIncrease())/100,
                ],
                'agi'     => [
                    'type' => (is_numeric($neutralItem->getAgiIncrease()) || is_null($neutralItem->getAgiIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getAgiIncrease()) || is_null($neutralItem->getAgiIncrease())) ?
                        intval($neutralItem->getAgiIncrease()) :
                        1 + intval($neutralItem->getAgiIncrease())/100,
                ],
                'int'     => [
                    'type' => (is_numeric($neutralItem->getIntIncrease()) || is_null($neutralItem->getIntIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getIntIncrease()) || is_null($neutralItem->getIntIncrease())) ?
                        intval($neutralItem->getIntIncrease()) :
                        1 + intval($neutralItem->getIntIncrease())/100,
                ],
                'hp'      => [
                    'type' => (is_numeric($neutralItem->getHpIncrease()) || is_null($neutralItem->getHpIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getHpIncrease()) || is_null($neutralItem->getHpIncrease())) ?
                        intval($neutralItem->getHpIncrease()) :
                        1 + intval($neutralItem->getHpIncrease())/100,
                ],
                'mp'      => [
                    'type' => (is_numeric($neutralItem->getMpIncrease()) || is_null($neutralItem->getMpIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getMpIncrease()) || is_null($neutralItem->getMpIncrease())) ?
                        intval($neutralItem->getMpIncrease()) :
                        1 + intval($neutralItem->getMpIncrease())/100,
                ],
                'hpRegen' => [
                    'type' => (is_numeric($neutralItem->getHpRegenIncrease()) || is_null($neutralItem->getHpRegenIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getHpRegenIncrease()) || is_null($neutralItem->getHpRegenIncrease())) ?
                        intval($neutralItem->getHpRegenIncrease()) :
                        1 + intval($neutralItem->getHpRegenIncrease())/100,
                ],
                'mpRegen' => [
                    'type' => (is_numeric($neutralItem->getMpRegenIncrease()) || is_null($neutralItem->getMpRegenIncrease())) ? 'sum' : 'mult',
                    'value' => (is_numeric($neutralItem->getMpRegenIncrease()) || is_null($neutralItem->getMpRegenIncrease())) ?
                        intval($neutralItem->getMpRegenIncrease()) :
                        1 + intval($neutralItem->getMpRegenIncrease())/100,
                ],
            ];
        }
        $currentMs = $hero->getBaseMoveSpeed() + $statsAmplifiers['ms'];
        if($neutralAmplifiers && $neutralAmplifiers['ms']['type']=='sum'){
            $currentMs += $neutralAmplifiers['ms']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['ms']['type']=='mult'){
            $currentMs *= $neutralAmplifiers['ms']['value'];
        }
        $currentStr = $hero->getBaseStr() + round($hero->getStrGain() * ($level - 1)) + $statsAmplifiers['str'];
        if($neutralAmplifiers && $neutralAmplifiers['str']['type']=='sum'){
            $currentStr += $neutralAmplifiers['str']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['ms']['type']=='mult'){
            $currentStr *= $neutralAmplifiers['str']['value'];
        }
        $currentAgi = $hero->getBaseAgi() + round($hero->getAgiGain() * ($level - 1)) + $statsAmplifiers['agi'];
        if($neutralAmplifiers && $neutralAmplifiers['agi']['type']=='sum'){
            $currentAgi += $neutralAmplifiers['agi']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['agi']['type']=='mult'){
            $currentAgi *= $neutralAmplifiers['agi']['value'];
        }
        $currentInt = $hero->getBaseInt() + round($hero->getIntGain() * ($level - 1)) + $statsAmplifiers['int'];
        if($neutralAmplifiers && $neutralAmplifiers['int']['type']=='sum'){
            $currentInt += $neutralAmplifiers['int']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['int']['type']=='mult'){
            $currentInt *= $neutralAmplifiers['int']['value'];
        }
        $currentHp = $hero->getBaseHp() + $currentStr * 20 + $statsAmplifiers['hp'];
        if($neutralAmplifiers && $neutralAmplifiers['hp']['type']=='sum'){
            $currentHp += $neutralAmplifiers['hp']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['hp']['type']=='mult'){
            $currentHp *= $neutralAmplifiers['hp']['value'];
        }
        $currentMp = 75 + $currentInt * 12 + $statsAmplifiers['mp'];
        if($neutralAmplifiers && $neutralAmplifiers['mp']['type']=='sum'){
            $currentMp += $neutralAmplifiers['mp']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['mp']['type']=='mult'){
            $currentMp *= $neutralAmplifiers['mp']['value'];
        }
        $currentArmor = $hero->getBaseArmor() + $currentAgi / 6 + $statsAmplifiers['armor'];
        if($neutralAmplifiers && $neutralAmplifiers['armor']['type']=='sum'){
            $currentArmor += $neutralAmplifiers['armor']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['armor']['type']=='mult'){
            $currentArmor *= $neutralAmplifiers['armor']['value'];
        }
        $currentArmorPercent = round(0.06 * $currentArmor / (1 + 0.06 * $currentArmor) * 100);
        $currentHpRegen = $currentStr * 0.1 + $statsAmplifiers['hpRegen'];
        if($neutralAmplifiers && $neutralAmplifiers['hpRegen']['type']=='sum'){
            $currentHpRegen += $neutralAmplifiers['hpRegen']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['hpRegen']['type']=='mult'){
            $currentHpRegen *= $neutralAmplifiers['hpRegen']['value'];
        }
        $currentMpRegen = $currentInt * 0.05 + $statsAmplifiers['mpRegen'];
        if($neutralAmplifiers && $neutralAmplifiers['mpRegen']['type']=='sum'){
            $currentMpRegen += $neutralAmplifiers['mpRegen']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['mpRegen']['type']=='mult'){
            $currentMpRegen *= $neutralAmplifiers['mpRegen']['value'];
        }
        $dmgChange = ($hero->getMainAttribute() == 1 ? $currentStr : ($hero->getMainAttribute() == 1 ? $currentAgi : $currentInt)) + $statsAmplifiers['dmg'];
        if($neutralAmplifiers && $neutralAmplifiers['dmg']['type']=='sum'){
            $dmgChange += $neutralAmplifiers['dmg']['value'];
        }elseif($neutralAmplifiers && $neutralAmplifiers['dmg']['type']=='mult'){
            $dmgChange *= $neutralAmplifiers['dmg']['value'];
        }
        $computedValues = [
            'currentMs'           => round($currentMs),
            'currentHp'           => round($currentHp),
            'currentMp'           => round($currentMp),
            'currentStr'          => round($currentStr),
            'currentAgi'          => round($currentAgi),
            'currentInt'          => round($currentInt),
            'currentArmor'        => round($currentArmor,2),
            'currentArmorPercent' => $currentArmorPercent,
            'currentHpRegen'      => round($currentHpRegen, 2),
            'currentMpRegen'      => round($currentMpRegen, 2),
            'currentDmgMin'       => round($hero->getBaseDamageMin() + $dmgChange),
            'currentDmgMax'       => round($hero->getBaseDamageMax() + $dmgChange),
        ];
        foreach ($heroAbilities as $heroAbility) {
            $abilities[] = [
                'id'            => $heroAbility->getId(),
                'heroId'        => $heroAbility->getHero()->getId(),
                'abilityName'   => $heroAbility->getAbilityName(),
                'image'         => $heroAbility->getImage(),
                'description'   => $heroAbility->getDescription(),
                'abilityNumber' => $heroAbility->getAbilityNumber()
            ];
        }
        foreach ($heroTalents as $heroTalent) {
            $talents[] = [
                'id'              => $heroTalent->getId(),
                'hero_id'         => $heroTalent->getHero()->getId(),
                'description'     => $heroTalent->getDescription(),
                'level'           => $heroTalent->getLevel(),
                'dmgIncrease'     => $heroTalent->getDmgIncrease(),
                'armorIncrease'   => $heroTalent->getArmorIncrease(),
                'msIncrease'      => $heroTalent->getMsIncrease(),
                'strIncrease'     => $heroTalent->getStrIncrease(),
                'agiIncrease'     => $heroTalent->getAgiIncrease(),
                'intIncrease'     => $heroTalent->getIntIncrease(),
                'hpIncrease'      => $heroTalent->getHpIncrease(),
                'mpIncrease'      => $heroTalent->getMpIncrease(),
                'hpRegenIncrease' => $heroTalent->getHpRegenIncrease(),
                'mpRegenIncrease' => $heroTalent->getMpRegenIncrease()
            ];
        }
        $heroData = [
            'id'            => $hero->getId(),
            'name'          => $hero->getName(),
            'mainAttr'      => $hero->getMainAttribute(),
            'baseStr'       => $hero->getBaseStr(),
            'strGain'       => $hero->getStrGain(),
            'baseAgi'       => $hero->getBaseAgi(),
            'agiGain'       => $hero->getAgiGain(),
            'baseInt'       => $hero->getBaseInt(),
            'intGain'       => $hero->getIntGain(),
            'baseDamageMin' => $hero->getBaseDamageMin(),
            'baseDamageMax' => $hero->getBaseDamageMax(),
            'baseHp'        => $hero->getBaseHp(),
            'baseArmor'     => $hero->getBaseArmor(),
            'baseMoveSpeed' => $hero->getBaseMoveSpeed(),
            'image'         => $hero->getImage(),
            'abilities'     => $abilities,
            'talents'       => $talents,
            'computed'      => $computedValues,
        ];
        return $heroData;
    }
}