<?php

namespace MapRec\MapRecBundle\Model;

use MapRec\MapRecBundle\Model\Base\Card as BaseCard;

require_once '../generated-conf/config.php';

/**
 * Skeleton subclass for representing a row from the 'card' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Card extends BaseCard
{
    public $cardToMapRels = [];

    public function getMapRels() {
        return array($this->cardToMapRels);
    }

    public function getMapChoices() {
        return MapQuery::create()->
            select(array('map_id','map_name'))->
            orderBy('map_name')->
            find()->
            toKeyValue('map_id','map_name')
            ;
    }

    public function getCardChoices() {

        $cardChoices = [];
        $allCards = CardQuery::create()->find();

        foreach($allCards as $currentCard) {
            $cardChoiceKey = $currentCard->getCardId();
            $cardChoiceValue = $currentCard->getCardName();

            $cardChoices[$cardChoiceKey] = $cardChoiceValue;
        }

        return $cardChoices;
    }

    public function saveWithMapRels($cardId)
    {
        $this->save();

        if ($cardId) {
            // Delete Old Map Rels if not new
            CardToMapQuery::create()
                ->filterByCardId($cardId)
                ->delete();
        }

        //Add New Map Rels
        foreach($this->cardToMapRels as $mapKey=>$mapValue) {
            $currentCardToMap = new CardToMap();
            $currentCardToMap->setCardId($this->card_id);
            $currentCardToMap->setMapId($mapValue);
            $currentCardToMap->save();
        }
    }

    public static function getById($cardId) {

        $targetCard = CardQuery::create()->findByCardId($cardId)[0];
        $targetCard->cardToMapRels = CardToMapQuery::create()
            ->filterByCardId($cardId)
            ->find();

        return $targetCard;

    }
}
