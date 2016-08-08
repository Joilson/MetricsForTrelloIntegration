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
        $cards      = $this->getCardsOpenByList($listId);
        $movedCards = [];

        foreach ($cards as $card) {

            $action = $this->trelloApiClient->api('card')->actions()->all($card['id'], [
                'filter' => 'updateCard',
            ]);

            if ($action[0]['data']['listAfter']['id'] == $listId) {

                $action[0]['date'] = $this->parseTimezoneForDate($action[0]['date']);

                $movedCards[$card['id']]['card']   = $card;
                $movedCards[$card['id']]['action'] = $action[0];
            }
        }

        return $movedCards;
    }

    private function parseTimezoneForDate($oldDate)
    {
        $date = new DateTime($oldDate);
        date_sub($date, date_interval_create_from_date_string('3 hours'));
        return $date;
    }

    public function registerNewCardMoved($card)
    {
        print_r($card);
    }

}
