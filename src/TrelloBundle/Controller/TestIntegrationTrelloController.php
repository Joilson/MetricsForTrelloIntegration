<?php

namespace TrelloBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Trello\Client;

/**
 * @Route("/test")
 */
class TestIntegrationTrelloController extends Controller
{

    /**
     * @Route("/exec.json")
     */
    public function run()
    {
        /* @var $client Client */
        $client = $this->get('trello.client.api');

        $cardsOpenFromHomolog = $client->api('lists')->cards()->filter('56cde648b6815a552e5f9065', 'open');

        foreach ($cardsOpenFromHomolog as $card) {

            $action = $client->api('card')->actions()->all($card['id'], [
                'filter' => 'updateCard',
            ]);

            die(var_dump($action[0]));
        }

        var_dump($cardsOpenFromHomolog);

        return [];
        
    }

}
