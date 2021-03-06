<?php

namespace DaMatch\Helper;

use DaMatch\Entity\Match;
use DaMatch\Entity\MatchPlayer;

class MatchHelper
{
    public static $openDotaHeroMap =
        [
            1   => 4, //Anti-Mage
            2   => 6, //Axe
            3   => 7, //Bane
            4   => 10, //Bloodseeker
            5   => 20, //Crystal Maiden
            6   => 29, //Drow Ranger
            7   => 31, //Earthshaker
            8   => 44, //Juggernaut
            9   => 60, //Mirana
            10  => 62, //Morphling
            11  => 85, //Shadow Fiend
            12  => 74, //Phantom Lancer
            13  => 76, //Puck
            14  => 77, //Pudge
            15  => 80, //Razor
            16  => 83, //Sand King
            17  => 95, //Storm Spirit
            18  => 96, //Sven
            19  => 103, //Tiny
            20  => 110, //Vengeful Spirit
            21  => 117, //Windranger
            22  => 121, //Zeus
            23  => 46, //Kunkka
            25  => 51, //Lina
            26  => 52, //Lion
            27  => 86, //Shadow Shaman
            28  => 89, //Slardar
            29  => 100, //Tidehunter
            30  => 119, //Witch Doctor
            31  => 49, //Lich
            32  => 81, //Riki
            33  => 35, //Enigma
            34  => 102, //Tinker
            35  => 92, //Sniper
            36  => 65, //Necrophos
            37  => 115, //Warlock
            38  => 9, //Beastmaster
            39  => 79, //Queen of Pain
            40  => 111, //Venomancer
            41  => 36, //Faceless Void
            42  => 120, //Wraith King
            43  => 25, //Death Prophet
            44  => 73, //Phantom Assassin
            45  => 78, //Pugna
            46  => 98, //Templar Assassin
            47  => 112, //Viper
            48  => 54, //Luna
            49  => 28, //Dragon Knight
            50  => 24, //Dazzle
            51  => 19, //Clockwerk
            52  => 48, //Leshrac
            53  => 64, //Nature's Prophet
            54  => 50, //Lifestealer
            55  => 21, //Dark Seer
            56  => 18, //Clinkz
            57  => 69, //Omniknight
            58  => 34, //Enchantress
            59  => 40, //Huskar
            60  => 66, //Night Stalker
            61  => 14, //Broodmother
            62  => 11, //Bounty Hunter
            63  => 116, //Weaver
            64  => 43, //Jakiro
            65  => 8, //Batrider
            66  => 17, //Chen
            67  => 93, //Spectre
            68  => 3, //Ancient Apparition
            69  => 27, //Doom
            70  => 109, //Ursa
            71  => 94, //Spirit Breaker
            72  => 38, //Gyrocopter
            73  => 2, //Alchemist
            74  => 41, //Invoker
            75  => 87, //Silencer
            76  => 71, //Outworld Destroyer
            77  => 55, //Lycan
            78  => 12, //Brewmaster
            79  => 84, //Shadow Demon
            80  => 53, //Lone Druid
            81  => 16, //Chaos Knight
            82  => 59, //Meepo
            83  => 104, //Treant Protector
            84  => 68, //Ogre Magi
            85  => 108, //Undying
            86  => 82, //Rubick
            87  => 26, //Disruptor
            88  => 67, //Nyx Assassin
            89  => 63, //Naga Siren
            90  => 45, //Keeper of the Light
            91  => 42, //Io
            92  => 113, //Visage
            93  => 90, //Slark
            94  => 58, //Medusa
            95  => 105, //Troll Warlord
            96  => 15, //Centaur Warrunner
            97  => 56, //Magnus
            98  => 101, //Timbersaw
            99  => 13, //Bristleback
            100 => 106, //Tusk
            101 => 88, //Skywrath Mage
            102 => 1, //Abaddon
            103 => 32, //Elder Titan
            104 => 47, //Legion Commander
            105 => 97, //Techies
            106 => 33, //Ember Spirit
            107 => 30, //Earth Spirit
            108 => 107, //Underlord
            109 => 99, //Terrorblade
            110 => 75, //Phoenix
            111 => 70, //Oracle
            112 => 118, //Winter Wyvern
            113 => 5, //Arc Warden
            114 => 61, //Monkey King
            119 => 22, //Dark Willow
            120 => 72, //Pangolier
            121 => 37, //Grimstroke
            123 => 39, //Hoodwink
            126 => 114, //Void Spirit
            128 => 91, //Snapfire
            129 => 57, //Mars
            135 => 23, //Dawnbreaker
        ];

    public static $openDotaItemMap =
        [
            1    => 20, //Blink Dagger
            2    => 18, //Blades of Attack
            3    => 29, //Broadsword
            4    => 32, //Chainmail
            5    => 36, //Claymore
            6    => 74, //Helm of Iron Will
            7    => 83, //Javelin
            8    => 98, //Mithril Hammer
            9    => 117, //Platemail
            10   => 120, //Quarterstaff
            11   => 121, //Quelling Blade
            12   => 128, //Ring of Protection
            13   => 62, //Gauntlets of Strength
            14   => 145, //Slippers of Agility
            15   => 93, //Mantle of Intelligence
            16   => 82, //Iron Branch
            17   => 14, //Belt of Strength
            18   => 12, //Band of Elvenskin
            19   => 131, //Robe of the Magi
            20   => 34, //Circlet
            21   => 109, //Ogre Axe
            22   => 17, //Blade of Alacrity
            23   => 151, //Staff of Wizardry
            24   => 159, //Ultimate Orb
            25   => 67, //Gloves of Haste
            26   => 102, //Morbid Mask
            27   => 129, //Ring of Regen
            28   => 134, //Sage's Mask
            29   => 24, //Boots of Speed
            30   => 63, //Gem of True Sight
            31   => 37, //Cloak
            32   => 154, //Talisman of Evasion
            33   => 33, //Cheese
            34   => 90, //Magic Stick
            36   => 91, //Magic Wand
            37   => 64, //Ghost Scepter
            38   => 35, //Clarity
            39   => 71, //Healing Salve
            40   => 49, //Dust of Appearance
            41   => 27, //Bottle
            42   => 107, //Observer Ward
            43   => 108, //Sentry Ward
            44   => 155, //Tango
            46   => 157, //Town Portal Scroll
            48   => 25, //Boots of Travel
            50   => 115, //Phase Boots
            51   => 43, //Demon Edge
            52   => 50, //Eaglesong
            53   => 123, //Reaver
            54   => 133, //Sacred Relic
            55   => 80, //Hyperstone
            56   => 127, //Ring of Health
            57   => 165, //Void Stone
            58   => 103, //Mystic Staff
            59   => 53, //Energy Booster
            60   => 118, //Point Booster
            61   => 163, //Vitality Booster
            63   => 119, //Power Treads
            65   => 69, //Hand of Midas
            67   => 106, //Oblivion Staff
            69   => 114, //Perseverance
            73   => 28, //Bracer
            75   => 170, //Wraith Band
            77   => 104, //Null Talisman
            79   => 96, //Mekansm
            81   => 164, //Vladmir's Offering
            86   => 30, //Buckler
            88   => 126, //Ring of Basilius
            90   => 116, //Pipe of Insight
            92   => 160, //Urn of Shadows
            94   => 70, //Headdress
            96   => 138, //Scythe of Vyse
            98   => 112, //Orchid Malevolence
            100  => 56, //Eul's Scepter of Divinity
            102  => 61, //Force Staff
            104  => 42, //Dagon
            108  => 6, //Aghanim's Scepter
            110  => 124, //Refresher Orb
            112  => 11, //Assault Cuirass
            114  => 72, //Heart of Tarrasque
            116  => 15, //Black King Bar
            117  => 2, //Aegis of the Immortal
            119  => 142, //Shiva's Guard
            121  => 22, //Bloodstone
            123  => 86, //Linken's Sphere
            125  => 161, //Vanguard
            127  => 16, //Blade Mail
            129  => 148, //Soul Booster
            131  => 78, //Hood of Defiance
            133  => 46, //Divine Rapier
            135  => 100, //Monkey King Bar
            137  => 122, //Radiance
            139  => 31, //Butterfly
            141  => 41, //Daedalus
            144  => 143, //Skull Basher
            145  => 13, //Battle Fury
            147  => 92, //Manta Style
            149  => 40, //Crystalys
            151  => 10, //Armlet of Mordiggian
            152  => 141, //Shadow Blade
            154  => 136, //Sange and Yasha
            156  => 137, //Satanic
            158  => 99, //Mjollnir
            160  => 57, //Eye of Skadi
            162  => 135, //Sange
            164  => 75, //Helm of the Dominator
            166  => 88, //Maelstrom
            168  => 44, //Desolator
            170  => 171, //Yasha
            172  => 94, //Mask of Madness
            174  => 45, //Diffusal Blade
            176  => 55, //Ethereal Blade
            178  => 149, //Soul Ring
            180  => 9, //Arcane Boots
            181  => 111, //Orb of Venom
            182  => 152, //Stout Shield
            185  => 48, //Drum of Endurance
            187  => 95, //Medallion of Courage
            188  => 146, //Smoke of Deceit
            190  => 162, //Veil of Discord
            206  => 132, //Rod of Atos
            208  => 1, //Abyssal Blade
            210  => 73, //Heaven's Halberd
            214  => 158, //Tranquil Boots
            215  => 140, //Shadow Amulet
            216  => 52, //Enchanted Mango
            220  => 26, //Boots of Travel 2
            223  => 97, //Meteor Hammer
            225  => 105, //Nullifier
            226  => 87, //Lotus Orb
            229  => 147, //Solar Crest
            231  => 68, //Guardian Greaves
            232  => 4, //Aether Lens
            235  => 108, //Octarine Core
            236  => 47, //Dragon Lance
            237  => 58, //Faerie Fire
            240  => 19, //Blight Stone
            242  => 38, //Crimson Guard
            244  => 167, //Wind Lace
            247  => 101, //Moon Shard
            249  => 143, //Silver Edge
            250  => 23, //Bloodthorn
            252  => 51, //Echo Sabre
            254  => 66, //Glimmer Cape
            256  => 3, //Aeon Disk
            257  => 156, //Tome of Knowledge
            259  => 84, //Kaya
            260  => 125, //Refresher Shard
            261  => 39, //Crown
            263  => 79, //Hurricane Pike
            265  => 81, //Infused Raindrops
            267  => 150, //Spirit Vessel
            269  => 77, //Holy Locket
            271  => 5, //Aghanim's Blessing
            273  => 85, //Kaya and Sange
            277  => 172, //Yasha and Kaya
            279  => 130, //Ring of Tarrasque
            473  => 166, //Voodoo Mask
            485  => 21, //Blitz Knuckles
            534  => 169, //Witch Blade
            569  => 110, //Orb of Corrosion
            593  => 60, //Fluffy Hat
            596  => 59, //Falcon Blade
            598  => 89, //Mage Slayer
            600  => 113, //Overwhelming Blink
            603  => 153, //Swift Blink
            604  => 8, //Arcane Blink
            609  => 7, //Aghanim's Shard
            610  => 168, //Wind Waker
            635  => 76, //Helm of the Overlord
            692  => 54, //Eternal Shroud
            1466 => 65, //Gleipnir
        ];

    public static $openDotaNeutralItemMap = [
        212 => 20, //Ring of Aquila
        287 => 7, //Keen Optic
        288 => 14, //Grove Bow
        289 => 29, //Quickening Charm
        290 => 17, //Philosopher's Stone
        291 => 49, //Force Boots
        292 => 54, //Stygian Desolator
        294 => 53, //Seer Stone
        300 => 41, //Timeless Relic
        301 => 51, //Mirror Shield
        304 => 6, //Ironwood Tree
        306 => 18, //Pupil's Gift
        309 => 25, //Mind Breaker
        311 => 37, //Spell Prism
        326 => 30, //Spider Legs
        334 => 15, //Imp Claw
        335 => 32, //Flicker
        336 => 39, //Telescope
        349 => 1, //Arcane Ring
        354 => 8, //Ocean Heart
        355 => 2, //Broom Handle
        356 => 10, //Trusty Shovel
        357 => 16, //Nether Shawl
        358 => 12, //Dragon Scale
        359 => 13, //Essence Ring
        361 => 24, //Enchanted Quiver
        362 => 35, //Ninja Gear
        363 => 33, //Illusionist's Cape
        366 => 43, //Apex
        367 => 44, //Ballista
        370 => 46, //Book of the Dead
        371 => 48, //Fallen Sky
        372 => 52, //Pirate Hat
        374 => 47, //Ex Machina
        375 => 4, //Faded Broach
        376 => 27, //Paladin Sword
        377 => 34, //Minotaur Horn
        378 => 26, //Orb of Destruction
        379 => 40, //The Leveller
        381 => 31, //Titan Sliver
        565 => 3, //Chipped Vest
        571 => 42, //Trickster Cloak
        573 => 23, //Elven Tunic
        574 => 22, //Cloak of Flames
        577 => 9, //Possessed Mask
        585 => 38, //Stormcrafter
        589 => 5, //Fairy's Trinket
        638 => 36, //Penta-Edged Sword
        675 => 28, //Psychic Headband
        676 => 21, //Ceremonial Robe
        677 => 45, //Book of Shadows
        678 => 50, //Giant's Ring
        680 => 11, //Bullwhip
        686 => 19, //Quicksilver Amulet
    ];

    public static $lobbyTypeMap = [
        2  => "Captain's Mode",
        3  => "Random Draft",
        4  => "Single Draft",
        5  => 'All Random',
        22 => 'All Pick',
        23 => 'Turbo',
    ];

    public static function mapOpendotaHeroesToLocal($id)
    {
        return self::$openDotaHeroMap[$id];
    }

    public static function mapOpendotaItemsToLocal($id)
    {
        return self::$openDotaItemMap[$id];
    }

    public static function mapOpendotaNeutralItemsToLocal($id)
    {
        return self::$openDotaNeutralItemMap[$id];
    }

    public static function convertStringToTime($timeString)
    {
        $hours = floor(((int)$timeString) / 3600);
        $minutes = floor(((int)$timeString - $hours * 3600) / 60);
        $seconds = (int)$timeString - $hours * 3600 - $minutes * 60;
        if ($hours) {
            return $hours . ':' . ($minutes < 10 ? '0' . $minutes : $minutes) . ':' . ($seconds < 10 ? '0' . $seconds : $seconds);
        }
        return $minutes . ':' . ($seconds < 10 ? '0' . $seconds : $seconds);
    }

    public static function getTimeDiff($datetime)
    {
        $elapsedTime = time() - $datetime;

        if ($elapsedTime < 1) {
            return '0 seconds';
        }

        $a = array(
            365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60  => 'month',
            24 * 60 * 60       => 'day',
            60 * 60            => 'hour',
            60                 => 'minute',
            1                  => 'second'
        );

        foreach ($a as $secs => $str) {
            $d = $elapsedTime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }

    public static function getPlayerNetWorth(MatchPlayer $matchPlayer)
    {
        $nwRaw = 0;
        $nwRaw += $matchPlayer->getItem0() ? $matchPlayer->getItem0()->getPrice() : 0;
        $nwRaw += $matchPlayer->getItem1() ? $matchPlayer->getItem1()->getPrice() : 0;
        $nwRaw += $matchPlayer->getItem2() ? $matchPlayer->getItem2()->getPrice() : 0;
        $nwRaw += $matchPlayer->getItem3() ? $matchPlayer->getItem3()->getPrice() : 0;
        $nwRaw += $matchPlayer->getItem4() ? $matchPlayer->getItem4()->getPrice() : 0;
        $nwRaw += $matchPlayer->getItem5() ? $matchPlayer->getItem5()->getPrice() : 0;
        $nwRaw += $matchPlayer->getBackpack0() ? $matchPlayer->getBackpack0()->getPrice() : 0;
        $nwRaw += $matchPlayer->getBackpack1() ? $matchPlayer->getBackpack1()->getPrice() : 0;
        $nwRaw += $matchPlayer->getBackpack2() ? $matchPlayer->getBackpack2()->getPrice() : 0;
        $nwRaw += $matchPlayer->getBackpack3() ? $matchPlayer->getBackpack3()->getPrice() : 0;
        if ($nwRaw > 1000) {
            $nwFormatted = ((floor($nwRaw / 100)) / 10) . 'k';
        } else {
            $nwFormatted = $nwRaw;
        }
        return [
            'raw'       => $nwRaw,
            'formatted' => $nwFormatted,
        ];
    }

    public static function getPlayerGpm(Match $match, MatchPlayer $matchPlayer)
    {
        $netWorth = self::getPlayerNetWorth($matchPlayer);
        return round($netWorth['raw'] / $match->getDuration() * 60);
    }
}