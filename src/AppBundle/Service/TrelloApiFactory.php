<?php

namespace AppBundle\Service;

use Trello\Client;

class TrelloApiFactory
{

    /**
     *
     * @var Client
     */
    private $trelloClient;

    /**
     *
     * @var string
     */
    private $token;

    /**
     *
     * @var string
     */
    private $secret;

    function __construct($token, $secret)
    {
        $this->trelloClient = new Client();
        $this->token        = $token;
        $this->secret       = $secret;
    }

    public function factory()
    {
        $this->trelloClient->authenticate($this->token, $this->secret, Client::AUTH_URL_CLIENT_ID);
        return $this->trelloClient;
    }

}
