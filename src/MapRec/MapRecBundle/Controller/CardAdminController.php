<?php
/**
 * Created by PhpStorm.
 * User: kendal
 * Date: 12/9/16
 * Time: 2:10 PM
 */

namespace MapRec\MapRecBundle\Controller;

use MapRec\MapRecBundle\Model\Card;
use MapRec\MapRecBundle\Form\Type\CardType;
use MapRec\MapRecBundle\Model\CardQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CardAdminController extends Controller
{
    /**
     * @Route("/addCard", name="addCard")
     */
    public function addCardAction(Request $request)
    {
        $card = new Card();
        $form = $this->createForm(new CardType(), $card);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->getData();
            $card->saveWithMapRels(false);
            $uri = $this->get('router')->generate('listCard');
            return $this->redirect($uri);
        }

        return $this->render('MapRecBundle:admin:newCard.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/listCard", name="listCard")
     */
    public function listCardAction(Request $request)
    {
        $cards = [];

        $form = $this->createForm(new CardType(), $cards, array(
            'listMode' => true,
            'data_class' => null
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('editButton')->isClicked()) {
                $cardId = $form->get("cardChoices")->getData();
                $uri = $this->get('router')->generate('editCard', array(
                    'cardId' => $cardId));
                return $this->redirect($uri);
            }
            elseif ($form->get('addButton')->isClicked()) {
                $cardId = $form->get("cardChoices")->getData();
                $uri = $this->get('router')->generate('addCard');
                return $this->redirect($uri);
            }
        }

        return $this->render('MapRecBundle:admin:listCard.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/editCard/{cardId}", name="editCard", requirements={"cardId":"\d+"})
     */
    public function editCardAction($cardId, Request $request)
    {

        $card = Card::getById($cardId);
        $form = $this->createForm(new CardType(), $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->getData();
            $card->saveWithMapRels($card->getCardId());
            $uri = $this->get('router')->generate('listCard');
            return $this->redirect($uri);
        }

        return $this->render('MapRecBundle:admin:editCard.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}