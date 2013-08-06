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
class FileController extends Controller
{
    /**
     * Upload multiple files
     */
    public function uploadAction(Request $request)
    {
        $img_path = $this->container->getParameter('kernel.root_dir').'/../web/images/';
        
        $finder = new Finder();
        $finder->directories()->in($img_path);
        
        foreach($finder as $dir){
            $img_dirs[$dir->getRelativePathname()] = $dir->getRelativePathname();
        }
        
        if(empty($img_dirs)){
            $img_dirs[] = 'No directory yet';
        }
        
        //Upload form
        $form = $this->createFormBuilder()
                ->add('directory', 'choice', array(
                    'choices' => $img_dirs,
                    'required' => false,
                    'expanded' => false,
                    'empty_value' => 'Choose a directory',
                ))
                ->add('name', 'text', array(
                    'required' => false
                ))
                ->add('img_name', 'text', array(
                    'required' => true
                ))
                ->add('files', 'file', array('mapped' => false ))
                ->getForm();
        
        
        if($request->isMethod('POST')){
            $form->bind($request);
            
            if($form->isValid()){
                $data = $form->getData();
                
                //Define image directory
                if(isset($data['name'])){
                    $img_dir_name = $data['name'];
                }elseif($data['directory'] != null){
                    $img_dir_name = $data['directory'];
                }else{
                    $img_dir_name = 'upload';
                }
                
                $files = $form['files']->getData();
                
                $i=0;
                foreach ($files as $file) {
                    $new_name = $data['img_name'].$i.'.'.$file->getClientOriginalExtension();
                    $newfile = $file->move(__DIR__.'/../../../../web/images/'.$img_dir_name, $new_name);
                    $new_file = new File;
                    $new_file->setName($new_name);
                    $new_file->setPath('images/'.$img_dir_name);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($new_file);
                    ++$i;
                }
                $em->flush();
            }
        }
        
        
        return $this->render('MaDevUploadFileBundle:File:form_upload.html.twig', array(
            'form'   => $form->createView()
        ));
    }
}
?>
