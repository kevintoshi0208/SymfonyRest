<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProgrammerController extends Controller
{
    /**
     * @Route("/api/programmers")
     * @Method("POST")
     */
    public function newAction()
    {
        return new Response('Let\'s do this!');
    }
}
