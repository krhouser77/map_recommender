<?php

namespace MapRec\MapRecBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CardToMapType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'MapRec\MapRecBundle\Model\CardToMap',
        'name'       => 'cardtomap',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cardId');
        $builder->add('mapId');
    }
}
