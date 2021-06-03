<?php

namespace DaItem\Form;

use DaBase\Repository\CustomRepository;
use DaItem\Entity\Item;
use DaItem\Repository\ItemRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Select;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class ItemForm extends Form
    implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ItemForm constructor.
     *
     * @param EntityManager $entityManager
     * @param               $itemRepository
     */
    public function __construct(
        EntityManager $entityManager,
        $itemRepository
    ) {
        parent::__construct('item');
        $this->entityManager = $entityManager;
        $this->itemRepository = $itemRepository;

        $itemsArr = [];
        $items = $this->itemRepository->findBy([], ['name' => 'ASC']);
        foreach ($items as $item) {
            $itemsArr[] = [
                'value' => $item->getId(),
                'label' => $item->getName(),
            ];
        }

        $this->add(
            [
                'name' => 'id',
                'type' => 'hidden',
            ]
        );

        $this->add(
            [
                'name'    => 'name',
                'type'    => 'text',
                'options' => [
                    'label' => 'Name'
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'lore',
                'type'    => 'textarea',
                'options' => [
                    'label' => 'Lore',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'description',
                'type'    => 'textarea',
                'options' => [
                    'label' => 'Description',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'price',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Price'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'dmgIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Dmg'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'strIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '<img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/icons/hero_strength.png">Strength',
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'agiIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '<img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/icons/hero_agility.png">Agility'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'intIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '<img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/icons/hero_intelligence.png">Intelligence'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'hpIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'HP'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'mpIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Mana'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'hpRegenIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'HP regen'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'mpRegenIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Mana regen'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'armorIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Armor'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'msIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Move speed'
                ],
                'attributes' => [
                    'value' => 0
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'image',
                'type'    => 'text',
                'options' => [
                    'label' => 'Image'
                ],
            ]
        );

        $typeField = new Select('type');
        $typeField->setLabel('Type');
        $typeField->setValueOptions(
            [
                [
                    'value'    => '',
                    'label'    => 'Choose',
                    'disabled' => true,
                    'selected' => true,
                ],
                [
                    'value' => Item::TYPE_BASIC,
                    'label' => 'Basic',
                ],
                [
                    'value' => Item::TYPE_UPGRADE,
                    'label' => 'Upgrade',
                ],
            ]
        );
        $this->add($typeField);

        $categoryField = new Select('category');
        $categoryField->setLabel('Category');
        $categoryField->setValueOptions(
            [
                [
                    'value'    => '',
                    'label'    => 'Choose',
                    'disabled' => true,
                    'selected' => true,
                ],
                [
                    'value' => Item::CATEGORY_CONSUMABLES,
                    'label' => 'Consumables',
                ],
                [
                    'value' => Item::CATEGORY_ATTRIBUTES,
                    'label' => 'Attributes',
                ],
                [
                    'value' => Item::CATEGORY_EQUIPMENT,
                    'label' => 'Equipment',
                ],
                [
                    'value' => Item::CATEGORY_MISCELLANEOUS,
                    'label' => 'Miscellaneous',
                ],
                [
                    'value' => Item::CATEGORY_SECRET_SHOP,
                    'label' => 'Secret Shop',
                ],
                [
                    'value' => Item::CATEGORY_ROSHAN_DROP,
                    'label' => 'Roshan Drop',
                ],
                [
                    'value' => Item::CATEGORY_ACCESSORIES,
                    'label' => 'Accesories',
                ],
                [
                    'value' => Item::CATEGORY_SUPPORT,
                    'label' => 'Support',
                ],
                [
                    'value' => Item::CATEGORY_MAGICAL,
                    'label' => 'Magical',
                ],
                [
                    'value' => Item::CATEGORY_ARMOR,
                    'label' => 'Armor',
                ],
                [
                    'value' => Item::CATEGORY_WEAPONS,
                    'label' => 'Weapons',
                ],
                [
                    'value' => Item::CATEGORY_ARTIFACTS,
                    'label' => 'Artifacts',
                ],
            ]
        );
        $this->add($categoryField);

        $this->add(
            [
                'type'       => Select::class,
                'attributes' => [
                    'multiple' => 'multiple',
                ],
                'name'       => 'buildsInto[]',
                'options'    => [
                    'label'         => 'Builds into',
                    'value_options' => $itemsArr,
                ],
            ]
        );

        $this->add(
            [
                'type'       => Checkbox::class,
                'name'       => 'isRecipeRequired',
                'options'    => [
                    'label'              => 'Recipe required',
                    'use_hidden_element' => true,
                    'checked_value'      => 1,
                    'unchecked_value'    => 0,
                ],
                'attributes' => [
                    'value' => 'yes',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => [
                    'value' => 'Save',
                    'id'    => 'submitbutton',
                    'class' => 'btn btn-primary',
                ],
            ]
        );

    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }
        $inputFilter = new InputFilter();
        $inputFilter->add(
            [
                'name'     => 'id',
                'required' => true,
                'filters'  => [
                    ['name' => ToInt::class],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'name',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'lore',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'description',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'price',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 10000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'dmgIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'strIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'agiIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'intIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'hpIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -10000,
                            'max' => 10000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'mpIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -10000,
                            'max' => 10000,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'hpRegenIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
                        ],
                    ],
                    [
                        'name'    => 'Regex',
                        'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'mpRegenIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
                        ],
                    ],
                    [
                        'name'    => 'Regex',
                        'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'armorIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'       => 'msIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                    ],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'     => 'image',
                'required' => true,
            ]
        );
        $inputFilter->add(
            [
                'name'     => 'type',
                'required' => true,
            ]
        );
        $inputFilter->add(
            [
                'name'     => 'category',
                'required' => true,
            ]
        );
        $inputFilter->add(
            [
                'name'              => 'buildsInto',
                'required'          => false,
                'continue_if_empty' => true,
                'filters'           => [
                    [
                        'name' => 'StringTrim'
                    ]
                ]
            ]
        );
        $inputFilter->add(
            [
                'name'              => 'isRecipeRequired',
                'required'          => false,
                'continue_if_empty' => true,
                'filters'           => []
            ]
        );

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}