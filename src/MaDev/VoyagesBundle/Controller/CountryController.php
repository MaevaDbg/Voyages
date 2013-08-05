<?php

namespace MaDev\VoyagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MaDev\VoyagesBundle\Form\CountryType;
use MaDev\VoyagesBundle\Entity\Country;

class CountryController extends Controller {

    public function indexAction() {
        
        $em = $this->getDoctrine()->getManager();
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();
            
            $this->get('voyages.message')->SuccessMessage('Votre pays a bien été ajouté');
            
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            $this->get('voyages.message')->SuccessMessage('Votre pays a bien été modifié');
            
            return $this->redirect($this->generateUrl('voyages_country_index'));
        }
        
        return $this->render('MaDevVoyagesBundle:Country:update.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function deleteAction(Country $country) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($country);
        $em->flush();
        
        $this->get('voyages.message')->SuccessMessage('Votre pays a bien été supprimé');
        
        return $this->redirect($this->generateUrl('voyages_country_index'));
    }

}
