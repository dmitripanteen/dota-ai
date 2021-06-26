<?php

namespace DaItem\Form;

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

class NeutralItemForm extends Form
    implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * NeutralItemForm constructor.
     */
    public function __construct()
    {
        parent::__construct('neutral_item');

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
                'attributes' => [
                    'class' => 'form-control',
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
                'attributes' => [
                    'class' => 'form-control',
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
                    'label' => 'Dmg'
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
                    'label' => '<img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/icons/hero_strength.png" width="20" height="20">Strength',
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
                    'label' => '<img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/icons/hero_agility.png" width="20" height="20">Agility'
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
                    'label' => '<img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/icons/hero_intelligence.png" width="20" height="20">Intelligence'
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
                    'label' => 'HP'
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
                    'label' => 'Mana'
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
                    'label' => 'HP regen'
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
                    'label' => 'Mana regen'
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
                    'label' => 'Armor'
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
                    'label' => 'Move speed'
                ],
                'attributes' => [
                    'value' => 0,
                    'class' => 'form-control',
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
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $tierField = new Select('tier');
        $tierField->setLabel('Tier');
        $tierField->setAttribute('class', 'form-control');
        $tierField->setValueOptions(
            [
                [
                    'value'    => '',
                    'label'    => 'Choose',
                    'disabled' => true,
                    'selected' => true,
                ],
                [
                    'value' => 1,
                    'label' => 1,
                ],
                [
                    'value' => 2,
                    'label' => 2,
                ],
                [
                    'value' => 3,
                    'label' => 3,
                ],
                [
                    'value' => 4,
                    'label' => 4,
                ],
                [
                    'value' => 5,
                    'label' => 5,
                ],
            ]
        );
        $this->add($tierField);

        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => [
                    'value' => 'Save',
                    'id'    => 'submitbutton',
                    'class' => 'btn btn-outline-primary pl-4 pr-4',
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
                'name'       => 'dmgIncrease',
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                        'name'    => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10,
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
                'name'     => 'tier',
                'required' => true,
            ]
        );

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}