<?php

namespace MaDev\VoyagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MaDev\VoyagesBundle\Form\CountryType;
use MaDev\VoyagesBundle\Entity\Country;

class CountryController extends Controller {

    public function indexAction() {
        
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MaDevVoyagesBundle:Country');
        $countries = $repo->findAll();
        
        return $this->render('MaDevVoyagesBundle:Country:index.html.twig',array(
            'countries' => $countries
        ));
    }

    public function createAction(Request $request) {

        $form = $this->createForm(new CountryType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $country = $form->getData();
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($country);
            $em->flush();

            return $this->redirect($this->generateUrl('voyages_country_index'));
        }

        return $this->render('MaDevVoyagesBundle:Country:create.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function updateAction(Country $country, Request $request) {
        $form = $this->createForm(new CountryType, $country);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $country = $form->getData();
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($country);
            $em->flush();

            return $this->redirect($this->generateUrl('voyages_country_index'));
        }
        
        return $this->render('MaDevVoyagesBundle:Country:update.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function deleteAction(Country $country) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($country);
        $em->flush();
        
        return $this->redirect($this->generateUrl('voyages_country_index'));
    }

}