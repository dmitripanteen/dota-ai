<?php

namespace DaHero\Form;

use DaHero\Entity\Hero;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class HeroTalentsForm extends Form
    implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * HeroTalentsForm constructor.
     *
     * @param Hero $hero
     */
    public function __construct($hero = null)
    {
        parent::__construct('hero_talent');

        $this->add(
            [
                'name' => 'id',
                'type' => 'hidden',
            ]
        );
        $this->add(
            [
                'name'       => 'hero_id',
                'type'       => 'hidden',
                'attributes' => [
                    'value' => $hero->getId(),
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'type'    => 'Laminas\Form\Element\Select',
                'name'    => 'level',
                'options' => [
                    'label'         => 'Level',
                    'value_options' => [
                        '10' => '10',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'description',
                'type'    => 'text',
                'options' => [
                    'label' => 'Description'
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'dmgIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+Dmg',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'armorIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+Armor',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'msIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+MS',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'strIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+Str',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'agiIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+Agi',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'intIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+Int',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'hpIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+HP',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'mpIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+MP',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'hpRegenIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+HpRegen',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'mpRegenIncrease',
                'type'       => 'text',
                'options'    => [
                    'label' => '+MpRegen',
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
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
                    'class' => 'btn btn-outline-primary pl-5 pr-5',
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
                'name'     => 'hero_id',
                'required' => true,
                'filters'  => [
                    ['name' => ToInt::class],
                ],
            ]
        );
        $inputFilter->add(
            [
                'name'     => 'level',
                'required' => true,
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
                'name'       => 'dmgIncrease',
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
                        ],
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 50,
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 50,
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
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
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
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
                    ['name' => StringTrim::class]
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
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
                    ['name' => StringTrim::class]
                ],
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 500,
                        ],
                    ],
                    [
                        'name'    => 'Regex',
                        'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                    ],
                ],
            ]
        );

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}