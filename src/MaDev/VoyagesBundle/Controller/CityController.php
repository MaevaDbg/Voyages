<?php

namespace MaDev\VoyagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MaDev\VoyagesBundle\Form\CityType;
use MaDev\VoyagesBundle\Entity\City;

class CityController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MaDevVoyagesBundle:City');
        $cities = $repo->findAll();

        return $this->render('MaDevVoyagesBundle:City:index.html.twig', array(
                    'cities' => $cities
                ));
    }

    public function createAction(Request $request) {
        $form = $this->createForm(new CityType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $city = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();
            
            $this->get('voyages.message')->SuccessMessage('Votre ville a bien été ajouté');
            
            return $this->redirect($this->generateUrl('voyages_city_index'));
        }

        return $this->render('MaDevVoyagesBundle:City:create.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function updateAction(City $city, Request $request) {
        $form = $this->createForm(new CityType(), $city);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $city = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();
            
            $this->get('voyages.message')->SuccessMessage('Votre ville a bien été modifié');

            return $this->redirect($this->generateUrl('voyages_city_index'));
        }

        return $this->render('MaDevVoyagesBundle:City:update.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function deleteAction(City $city) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($city);
        $em->flush();
        
        $this->get('voyages.message')->SuccessMessage('Votre ville a bien été supprimé');
        
        return $this->redirect($this->generateUrl('voyages_city_index'));
    }

}
