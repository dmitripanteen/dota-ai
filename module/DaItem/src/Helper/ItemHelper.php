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
            1 => '/img/recipe-line/Recipe_line1.png',
            2 => '/img/recipe-line/Recipe_line2.png',
            3 => '/img/recipe-line/Recipe_line3.png',
            4 => '/img/recipe-line/Recipe_line4.png',
            5 => '/img/recipe-line/Recipe_line5.png',
        ],
        'top'    => [
            1 => '/img/recipe-line/Recipe_line1.png',
            2 => '/img/recipe-line/Recipe_line2_top.png',
            3 => '/img/recipe-line/Recipe_line3_top.png',
            4 => '/img/recipe-line/Recipe_line4_top.png',
            5 => '/img/recipe-line/Recipe_line5_top.png',
            6 => '/img/recipe-line/Recipe_line6_top.png',
        ],
    ];
}