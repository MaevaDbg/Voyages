<?php

namespace MaDev\UploadFileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                'required' => false,
                'mapped' => false
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
            'img_dir' => null
        ));
    }

    public function getName()
    {
        return 'madev_uploadfilebundle_filetype';
    }
}
