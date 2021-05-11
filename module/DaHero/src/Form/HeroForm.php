<?php

namespace DaHero\Form;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Select;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class HeroForm extends Form
    implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function __construct($name = null)
    {
        parent::__construct('hero');

        $this->add([
                       'name' => 'id',
                       'type' => 'hidden',
                   ]);

        $this->add([
                       'name' => 'name',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Name'
                       ],
                   ]);

        $this->add([
                       'name' => 'lore',
                       'type' => 'textarea',
                       'options' => [
                           'label' => 'Lore',
                       ],
                   ]);

        $select = new Select('mainAttr');
        $select->setLabel('Main attribute');
        $select->setValueOptions([
                                     [
                                         'value' => '',
                                         'label' => 'Choose',
                                         'disabled' => true,
                                         'selected' => true,
                                     ],
                                     [
                                         'value' => '1',
                                         'label' => 'Strength',
                                     ],
                                     [
                                         'value' => '2',
                                         'label' => 'Agility',
                                     ],
                                     [
                                         'value' => '2',
                                         'label' => 'Intelligence',
                                     ],
                                 ]);
        $this->add($select);

        $this->add([
                       'name' => 'baseStr',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base strength',
                       ],
                   ]);

        $this->add([
                       'name' => 'strGain',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Strength gain per level',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseAgi',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base agility',
                       ],
                   ]);

        $this->add([
                       'name' => 'agiGain',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Agility gain per level',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseInt',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base intelligence',
                       ],
                   ]);

        $this->add([
                       'name' => 'intGain',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Intelligence gain per level',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseDamageMin',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base damage (min)',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseDamageMax',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base damage (max)',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseHp',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base HP',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseArmor',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base Armor',
                       ],
                   ]);

        $this->add([
                       'name' => 'baseMoveSpeed',
                       'type' => 'text',
                       'options' => [
                           'label' => 'Base move speed',
                       ],
                   ]);

        $this->add([
                       'name' => 'submit',
                       'type' => 'submit',
                       'attributes' => [
                           'value' => 'Save',
                           'id'    => 'submitbutton',
                           'class' => 'btn btn-primary',
                       ],
                   ]);

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
        $inputFilter->add([
                              'name' => 'id',
                              'required' => true,
                              'filters' => [
                                  ['name' => ToInt::class],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'name',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 100,
                                      ],
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'lore',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 1000,
                                      ],
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'mainAttr',
                              'required' => true,
                          ]);
        $inputFilter->add([
                              'name' => 'baseStr',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 4,
                                      ],
                                  ],
                                  [
                                      'name' => 'Regex',
                                      'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'strGain',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 4,
                                      ],
                                  ],
                                  [
                                      'name' => 'Regex',
                                      'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseAgi',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 4,
                                      ],
                                  ],
                                  [
                                      'name' => 'Regex',
                                      'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'agiGain',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 4,
                                      ],
                                  ],
                                  [
                                      'name' => 'Regex',
                                      'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseInt',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 4,
                                      ],
                                  ],
                                  [
                                      'name' => 'Regex',
                                      'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'intGain',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => StringLength::class,
                                      'options' => [
                                          'encoding' => 'UTF-8',
                                          'min' => 1,
                                          'max' => 4,
                                      ],
                                  ],
                                  [
                                      'name' => 'Regex',
                                      'options' => ['pattern' => '/([0-9]*[.])?[0-9]+/']
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseDamageMin',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => 'Between',
                                      'options' => [
                                          'min' => 0,
                                          'max' => 100,
                                      ],
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseDamageMax',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => 'Between',
                                      'options' => [
                                          'min' => 0,
                                          'max' => 100,
                                      ],
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseHp',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => 'Between',
                                      'options' => [
                                          'min' => 0,
                                          'max' => 1000,
                                      ],
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseArmor',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => 'Between',
                                      'options' => [
                                          'min' => -10,
                                          'max' => 10,
                                      ],
                                  ],
                              ],
                          ]);
        $inputFilter->add([
                              'name' => 'baseMoveSpeed',
                              'required' => true,
                              'filters' => [
                                  ['name' => StripTags::class],
                                  ['name' => StringTrim::class],
                              ],
                              'validators' => [
                                  [
                                      'name' => 'Between',
                                      'options' => [
                                          'min' => 0,
                                          'max' => 400,
                                      ],
                                  ],
                              ],
                          ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}