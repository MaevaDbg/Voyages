<?php

namespace MaDev\UploadFileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use MaDev\UploadFileBundle\Entity\File;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('directory', 'choice', array(
                'choices' => $options['img_dir'],
                'required' => false,
                'expanded' => false,
                'empty_value' => 'Choose a directory',
            ))
            ->add('new_directory', 'text', array(
                'required' => false
            ))
            ->add('files', 'file', array(
                'mapped' => false
            ))
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MaDev\UploadFileBundle\Entity\File',
            'img_dir' => null,
            'constraints' => array(new Assert\Callback(array(array($this, 'validateDirectory'))))
        ));
    }
    
    public function validateDirectory(File $file, ExecutionContextInterface $context)
    {
        $dir = $file->getDirectory();
        $new_dir = $file->getNewDirectory();
        if(empty($dir) && empty($new_dir)){
            $context->addViolationAt(
                'directory',
                'il faut définir un dossier pour y stocker les images'
            );
        }
    }

    public function getName()
    {
        return 'madev_uploadfilebundle_filetype';
    }
}
