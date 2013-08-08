<?php

namespace MaDev\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MaDevUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
