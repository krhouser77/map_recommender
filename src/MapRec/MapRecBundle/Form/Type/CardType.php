<?php

namespace MapRec\MapRecBundle\Form\Type;

use MapRec\MapRecBundle\Model\Card;
use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CardType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'MapRec\MapRecBundle\Model\Card',
        'name'       => 'card',
        'listMode'   => false
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->listMode = $options['listMode'];

        if ($this->listMode == false) {

            $this->buildEditForm($builder, $options) ;
        }
        else {
            $this->buildListForm($builder, $options) ;

        }
    }

    public function buildEditForm(FormBuilderInterface $builder, array $options) {

        $mapchoices = Card::getMapChoices();

        $chosenCard = $builder->getData();

        $mapRelValueArray = [];
        foreach ($chosenCard->cardToMapRels as $currentMapRel)
        {
            $mapRelValueArray[] = $currentMapRel->getMapId();
        }

        $builder->add('cardName', 'text', array(
            'label' => 'Card Name',
            'attr' => array('class'=>'singleLineInput')
        ));
        $builder->add('requiredCount', 'number', array(
            'label' => 'Number Required',
            'attr' => array('class'=>'singleLineInput')
        ));
        $builder->add('cardToMapRels', 'choice', array(
            'choices' =>  $mapchoices,
            'data' => $mapRelValueArray,
            'multiple' => true,
            'expanded' => true,
            'label' => 'Select all drop locations for this card:',
            'attr' => array('class'=>'mapTable')
        ));
        $builder->add('save','submit', array('label' => 'Save Card Data'));
    }

    public function buildListForm(FormBuilderInterface $builder, array $options) {

        $cardChoices = Card::getCardChoices();

        $builder->add('cardChoices', 'choice', array(
            'choices' =>  $cardChoices,
            'multiple' => false,
            'expanded' => true,
            'label' => 'Select a card to edit:',
            'attr' => array('class'=>'cardChoice')
        ));
        $builder->add('addButton','submit', array(
            'label' => 'Add New Card',
            'attr' => array('formnovalidate'=>'formnovalidate'),
            'validation_groups' => false));
        $builder->add('editButton','submit', array('label' => 'Edit Selected Card'));
    }


}
