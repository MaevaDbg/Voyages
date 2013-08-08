<?php
namespace MaDev\VoyagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        
        $repo_country = $em->getRepository('MaDevVoyagesBundle:Country');
        $nb_countries = $repo_country->countAll();
        $repo_city = $em->getRepository('MaDevVoyagesBundle:City');
        $nb_cities = $repo_city->countAll();
        $repo_file = $em->getRepository('MaDevUploadFileBundle:File');
        $nb_files = $repo_file->countAll();
        
        return $this->render('MaDevVoyagesBundle:Admin:index.html.twig', array(
            'nb_countries' => $nb_countries,
            'nb_cities' => $nb_cities,
            'nb_files' => $nb_files
        ));
    }
}
?>
