<?php

namespace MaDev\VoyagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MaDevVoyagesBundle:Default:index.html.twig', array('name' => $name));
    }
}
