<?php

namespace MatierBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MatierBundle:Default:index.html.twig');
    }
}
