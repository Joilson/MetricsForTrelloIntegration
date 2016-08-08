<?php

namespace TrelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('TrelloBundle:Default:index.html.twig');
    }

}
