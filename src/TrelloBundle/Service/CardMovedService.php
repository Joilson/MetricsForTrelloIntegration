<?php

namespace TrelloBundle\Service;

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

            if ($action[0]) {
                $movedCards[] = $card;
            }
        }

        return $movedCards;
    }

    public function registerNewCardMoved($card)
    {
        print_r($card);
    }

}
