<?php

namespace MaDev\UploadFileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use MaDev\UploadFileBundle\Entity\File;
use MaDev\UploadFileBundle\Form\Type\FileType;

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
        
        //Chemin vers mon dossier ou seront stockés les images
        $img_path = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/';

        //Je récupère la liste des sous dossiers de mon dossier upload
        $finder = new Finder();
        $finder->directories()->in($img_path);
        if ($finder->count() == 0) {
            $img_dirs[] = 'No directory yet';
        } else {
            foreach ($finder as $dir) {
                $img_dirs[$dir->getRelativePathname()] = $dir->getRelativePathname();
            }
        }
        $options = array('img_dir' => $img_dirs);
        
        $form = $this->createForm(new FileType(), null, $options);
        $form->handleRequest($request);

        //Traitement du formulaire
        if ($form->isValid()) {
            $data = $form->getData();
            
            //Define image directory
            $dir = $data->getDirectory();
            $new_dir = $form->get('new_directory')->getData();
            if (isset($new_dir)) {
                $img_dir_name = $this->normalise($new_dir);
            } 
            if ($dir != null) {
                $img_dir_name = $dir;
            }
            
            $files = $form->get('files')->getData();
            $em = $this->getDoctrine()->getManager();

            foreach ($files as $file) {

                $file_upload = $file->move(__DIR__ . '/../../../../web/uploads/' . $img_dir_name, $file->getClientOriginalName());
                
                $new_file = new File;
                $new_file->setName($file->getClientOriginalName());
                $new_file->setDirectory($img_dir_name);
                
                //Je fais une miniature
                list($orig_w, $orig_h) = getimagesize($file_upload);
                $dims = $this->image_resize_dimensions($orig_w, $orig_h, '150', '150', true);
                list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = $dims;
                $thumb = imagecreatetruecolor($dst_w, $dst_h);
                $image = imagecreatefromjpeg($file_upload);

                imagecopyresampled($thumb, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
                $thumb_name = 'thumb_'.$file->getClientOriginalName();
                imagejpeg($thumb, __DIR__ . '/../../../../web/uploads/' . $img_dir_name . '/'.$thumb_name,90);


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
     * FONCTION WORDPRESS 
     * Retrieve calculated resized dimensions for use in imagecopyresampled().
     *
     * Calculate dimensions and coordinates for a resized image that fits within a
     * specified width and height. If $crop is true, the largest matching central
     * portion of the image will be cropped out and resized to the required size.
     *
     * @since 2.5.0
     *
     * @param int $orig_w Original width.
     * @param int $orig_h Original height.
     * @param int $dest_w New width.
     * @param int $dest_h New height.
     * @param bool $crop Optional, default is false. Whether to crop image or resize.
     * @return bool|array False, on failure. Returned array matches parameters for imagecopyresampled() PHP function.
     */
    private function image_resize_dimensions($orig_w, $orig_h, $dest_w, $dest_h, $crop = false) {

        if ($orig_w <= 0 || $orig_h <= 0)
            return false;
        // at least one of dest_w or dest_h must be specific
        if ($dest_w <= 0 && $dest_h <= 0)
            return false;

        if ($crop) {
            // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
            $aspect_ratio = $orig_w / $orig_h;
            $new_w = min($dest_w, $orig_w);
            $new_h = min($dest_h, $orig_h);

            if (!$new_w) {
                $new_w = intval($new_h * $aspect_ratio);
            }

            if (!$new_h) {
                $new_h = intval($new_w / $aspect_ratio);
            }

            $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

            $crop_w = round($new_w / $size_ratio);
            $crop_h = round($new_h / $size_ratio);

            $s_x = floor(($orig_w - $crop_w) / 2);
            $s_y = floor(($orig_h - $crop_h) / 2);
        } else {
            // don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
            $crop_w = $orig_w;
            $crop_h = $orig_h;

            $s_x = 0;
            $s_y = 0;

            list( $new_w, $new_h ) = wp_constrain_dimensions($orig_w, $orig_h, $dest_w, $dest_h);
        }

        // if the resulting image would be the same size or larger we don't want to resize it
        if ($new_w >= $orig_w && $new_h >= $orig_h)
            return false;

        // the return array matches the parameters to imagecopyresampled()
        // int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
        return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
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
