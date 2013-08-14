<?php

namespace MaDev\VoyagesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MaDev\VoyagesBundle\Form\EventListener\AddImageFieldSubscriber;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array(
                'required' => true
            ))
            ->add('description')
            ->add('visite_date','date', array(
                'required' => true,
                'widget' => 'single_text'
            ))
            ->add('status', 'checkbox', array(
                'required' => false
            ))
            ->add('country', 'entity', array(
                'class' => 'MaDevVoyagesBundle:Country',
                'property' => 'name',
                'expanded' => false,
                'multiple' => false
            ))
            ->addEventSubscriber(new AddImageFieldSubscriber())
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MaDev\VoyagesBundle\Entity\City'
        ));
    }

    public function getName()
    {
        return 'voyagesbundle_citytype';
    }
}
