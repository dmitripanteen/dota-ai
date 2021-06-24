<?php

namespace DaItem\Helper;

class ItemHelper
{
    public static $categoryMap = [
        1  => 'Consumables',
        2  => 'Attributes',
        3  => 'Equipment',
        4  => 'Miscellaneous',
        5  => 'Secret Shop',
        6  => 'Roshan Drop',
        7  => 'Accessories',
        8  => 'Support',
        9  => 'Magical',
        10 => 'Armor',
        11 => 'Weapons',
        12 => 'Artifacts',
    ];

    public static $recipeMap = [
        'bottom' => [
            1 => 'https://liquipedia.net/commons/images/b/b6/Recipe_line1.png',
            2 => 'https://liquipedia.net/commons/images/9/97/Recipe_line2.png',
            3 => 'https://liquipedia.net/commons/images/6/64/Recipe_line3.png',
            4 => 'https://liquipedia.net/commons/images/f/fc/Recipe_line4.png',
            5 => 'https://liquipedia.net/commons/images/d/d8/Recipe_line5.png',
            6 => '',
        ],
        'top'    => [
            1 => 'https://liquipedia.net/commons/images/b/b6/Recipe_line1.png',
            2 => 'https://liquipedia.net/commons/images/5/5d/Recipe_line2_top.png',
            3 => 'https://liquipedia.net/commons/images/2/21/Recipe_line3_top.png',
            4 => 'https://liquipedia.net/commons/images/7/72/Recipe_line4_top.png',
            5 => 'https://liquipedia.net/commons/images/d/d1/Recipe_line5_top.png',
            6 => 'https://liquipedia.net/commons/images/2/20/Recipe_line6_top.png',
        ],
    ];
}