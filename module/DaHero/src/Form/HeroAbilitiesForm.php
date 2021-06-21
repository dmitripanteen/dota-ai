<?php

namespace DaHero\Form;

use DaHero\Entity\Hero;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class HeroAbilitiesForm extends Form
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
        parent::__construct('hero_ability');

        $this->add(
            [
                'name' => 'id',
                'type' => 'hidden',
            ]
        );
        $this->add(
            [
                'name'       => 'heroId',
                'type'       => 'hidden',
                'attributes' => [
                    'value' => $hero->getId(),
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'abilityName',
                'type'    => 'text',
                'options' => [
                    'label' => 'Ability Name'
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
                'name'       => 'abilityNumber',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Ability Number'
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
                    'label' => 'Icon (link)'
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'video',
                'type'    => 'text',
                'options' => [
                    'label' => 'Video (link)'
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'type'       => Element\Checkbox::class,
                'name'       => 'isUltimateAbility',
                'options'    => [
                    'label'              => 'Ultimate ability',
                    'use_hidden_element' => true,
                    'checked_value'      => 1,
                    'unchecked_value'    => 0,
                ],
                'attributes' => [
                    'value' => 'yes',
                    'class' => 'form-check-input',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => [
                    'value' => 'Save & add new',
                    'id'    => 'submitbutton',
                    'class' => 'btn btn-outline-primary pl-4 pr-4',
                ],
            ]
        );
        $this->add(
            [
                'name'       => 'finish',
                'type'       => 'submit',
                'attributes' => [
                    'value' => 'Finish',
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
                'name'     => 'heroId',
                'required' => true,
                'filters'  => [
                    ['name' => ToInt::class],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'abilityName',
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
                'name'       => 'abilityNumber',
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
                            'max' => 20,
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'image',
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
                'name'       => 'video',
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

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}