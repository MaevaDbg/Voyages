<?php

namespace MaDev\UploadFileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use MaDev\UploadFileBundle\Entity\File;

/**
 * File controller.
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
     * Upload multiple files
     */
    public function uploadAction(Request $request) {
        $img_path = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/';

        //Je récupère la liste des sous dossiers de upload
        $finder = new Finder();
        $finder->directories()->in($img_path);
        if ($finder->count() == 0) {
            $img_dirs[] = 'No directory yet';
        } else {
            foreach ($finder as $dir) {
                $img_dirs[$dir->getRelativePathname()] = $dir->getRelativePathname();
            }
        }

        //Upload form
        $form = $this->createFormBuilder()
                ->add('directory', 'choice', array(
                    'choices' => $img_dirs,
                    'required' => false,
                    'expanded' => false,
                    'empty_value' => 'Choose a directory',
                ))
                ->add('dir_name', 'text', array(
                    'required' => false
                ))
                ->add('files', 'file', array('mapped' => false))
                ->add('submit', 'submit')
                ->getForm();


        $form->handleRequest($request);

        //Traitement du formulaire
        if ($form->isValid()) {
            $data = $form->getData();

            //Define image directory
            if (isset($data['dir_name'])) {
                $img_dir_name = $data['dir_name'];
            } elseif ($data['directory'] != null) {
                $img_dir_name = $data['directory'];
            } else {
                $img_dir_name = 'divers';
            }

            $files = $form['files']->getData();
            $em = $this->getDoctrine()->getManager();
            foreach ($files as $file) {
                $file->move(__DIR__ . '/../../../../web/uploads/' . $img_dir_name, $file->getClientOriginalName());
                $new_file = new File;
                $new_file->setName($file->getClientOriginalName());
                $new_file->setPath('uploads/' . $img_dir_name);
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

}

?>
