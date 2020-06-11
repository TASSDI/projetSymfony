<?php

namespace MonLivreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MonLivreBundle:Default:index.html.twig');
    }
}
