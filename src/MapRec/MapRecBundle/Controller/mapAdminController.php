<?php
/**
 * Created by PhpStorm.
 * User: kendal
 * Date: 12/8/16
 * Time: 2:03 PM
 */

namespace MapRec\MapRecBundle\Controller;

use maprec\maprec\Map;
use maprec\maprec\MapQuery;
use MapRec\MapRecBundle\Form\MapType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


require_once '../generated-conf/config.php';

class mapAdminController extends Controller
{
    /**
     * @Route("/mapAdmin")
     */
    public function loadMapAdmin()
    {


        $mapForm = $this->createFormBuilder(new Map())
            ->add('maps', 'collection', array (
                'type' => new MapType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

            ))
        -> getForm();

        return $this->render('MapRecBundle:mapadmin:mapAdmin.html.twig', array(
            'maps' => $maps,
            'form' => $mapForm->createView(),
        ));

    }

}