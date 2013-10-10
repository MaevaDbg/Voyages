<?php

namespace MaDev\UploadFileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use MaDev\UploadFileBundle\Entity\File;
use MaDev\UploadFileBundle\Form\Type\FileUploadType;
use MaDev\UploadFileBundle\Form\Type\FileType;
use Imagine\Gd\Imagine;
use Imagine\Filter\Transformation;
use Imagine\Image\Box;

/**
 * File controller
 *
 */
class FileController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MaDevUploadFileBundle:File');
        $files = $repo->findAll();

        return $this->render('MaDevUploadFileBundle:File:index.html.twig', array(
                    'files' => $files
                ));
    }
    
    /**
     * Update
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MaDevUploadFileBundle:File');
        $image = $repo->find($id);
        
        if (!$image) {
            throw $this->createNotFoundException('Cette image n\'existe pas');
        }
        
        $form = $this->createForm(new FileType(),$image);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $image = $form->getData();
            $em->persist($image);
            $em->flush();
            
            $this->get('voyages.message')->SuccessMessage('Votre image a bien été modifié');
            return $this->redirect($this->generateUrl('uploadfile_file_index'));
        }
        
        return $this->render('MaDevUploadFileBundle:File:edit.html.twig', array(
                'image' => $image,
                'form' => $form->createView()
            ));
    }

    /**
     * Upload multiple files
     */
    public function uploadAction(Request $request) {
        
        //Chemin vers mon dossier ou seront stockés les images
        $upload_path = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/';

        //Liste des sous dossiers de mon dossier upload
        $finder = new Finder();
        $finder->directories()->in($upload_path);
        $directories = array();
        if ($finder->count() > 0) {
            foreach ($finder as $dir) {
                $directories[$dir->getRelativePathname()] = $dir->getRelativePathname();
            }
        } 
        
        $options = array('directories' => $directories);
        $form = $this->createForm(new FileUploadType(), null, $options);
        $form->handleRequest($request);

        //Traitement du formulaire
        if ($form->isValid()) {
            $data = $form->getData();
            
            //Definition du dossier d'upload
            $dir = $data->getDirectory();
            $new_dir = $form->get('new_directory')->getData();
            if (isset($new_dir)) {
                $img_dir_name = $this->normalise($new_dir);
                mkdir(__DIR__ . '/../../../../web/uploads/' . $img_dir_name);
            } 
            if ($dir != null) {
                $img_dir_name = $dir;
            }
            
            $files = $form->get('files')->getData();
            $em = $this->getDoctrine()->getManager();

            $imagine = new Imagine();
            foreach ($files as $file) {
                //J'upload mes images dans le dossier choisi et je créé un thumbnail
                $file_info = pathinfo($file);
                $path = __DIR__ . '/../../../../web/uploads/' . $img_dir_name . '/';
                $img_path = $path.$file->getClientOriginalName();
                $thumb_path = $path.'thumb_'.$file->getClientOriginalName();
                $image = $imagine->open($file_info['dirname']."/".$file_info['basename']);
                $image->save($img_path, array('quality' => 100));
                $transformation = new Transformation();
                $transformation->thumbnail(new Box(150,150),'outbound')->save($thumb_path, array('quality' => 100));
                $transformation->apply($image);
                //Je persiste les données de mon image en BDD
                $new_file = new File;
                $new_file->setName($file->getClientOriginalName());
                $new_file->setDirectory($img_dir_name);
                $em->persist($new_file);
            }
            $em->flush();

            $this->get('voyages.message')->SuccessMessage('Vos fichiers ont bien été uploadé');
            return $this->redirect($this->generateUrl('uploadfile_file_index'));
        }

        return $this->render('MaDevUploadFileBundle:File:form_upload.html.twig', array(
                    'form' => $form->createView()
                ));
    }

   
    /**
    * Normalise la chaine de caractères.
    *
    * @param string $str Chaine de caractères à normaliser.
    * @return string Chaine de caractères normalisée.
    */
    private function normalise($str) {
        $table = array(
          'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
          'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
          'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
          'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
          'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
          'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
          'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
          'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', ' ' => '-', '\'' => '-'
        );

        $str = strtr($str, $table);
        return strtolower($str);
    }

}

?>
