<?php

namespace TrelloBundle\Service;

use DateTime;
use Trello\Client;

class CardMovedService
{

    /**
     *
     * @var Client
     */
    private $trelloApiClient;

    function __construct(Client $trelloApiClient)
    {
        $this->trelloApiClient = $trelloApiClient;
    }

    public function getCardsOpenByList($listId)
    {
        return $this->trelloApiClient->api('lists')->cards()->filter($listId, 'open');
    }

    public function getMovedCardsByList($listId)
    {
        $cards = $this->getCardsOpenByList($listId);
        $movedCards = [];


        foreach ($cards as $card) {

            $action = $this->trelloApiClient->api('card')->actions()->all($card['id'], [
                'filter' => 'updateCard',
            ]);

            $lastListId = isset($action[0]['data']['listAfter']['id']) ? $action[0]['data']['listAfter']['id'] : $action[0]['data']['list']['id'];

            if ($lastListId == $listId) {

                $action[0]['date'] = $this->parseTimezoneForDate($action[0]['date']);

                if ($this->isNewCard($listId, $action[0]['date'])) {

                    $movedCards[$card['id']]['card'] = $card;
                    $movedCards[$card['id']]['action'] = $action[0];
                }
            }
        }

        return $movedCards;
    }

    private function getLastSyncForList($listId)
    {
        $lastSync['56cde648b6815a552e5f9065'] = "2016-08-08 17:18:10";
        $lastSync['57a8e8aa51c27ef632a540f8'] = "2016-08-08 17:17:10";

        return isset($lastSync[$listId]) ? $lastSync[$listId] : null;
    }

    private function isNewCard($listId, $dateForAction)
    {
        if (strtotime($this->getLastSyncForList($listId)) < strtotime($dateForAction)) {
            return true;
        }

        return false;
    }

    private function parseTimezoneForDate($oldDate)
    {
        $date = new DateTime($oldDate);
        date_sub($date, date_interval_create_from_date_string('3 hours'));
        return $date->format('Y-m-d H:i:s');
    }

    public function registerNewCardMoved($card)
    {
        print_r($card);
    }

}
