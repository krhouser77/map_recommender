<?php

namespace MapRec\MapRecBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MapType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'MapRec\MapRecBundle\Model\Map',
        'name'       => 'map',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mapName');
        $builder->add('mapLevel');
        $builder->add('mapTier');
        $builder->add('mapLayout');
        $builder->add('mapDifficulty');
        $builder->add('mapTileset');
        $builder->add('mapDescription');
        $builder->add('mapNumBosses');
    }
}
