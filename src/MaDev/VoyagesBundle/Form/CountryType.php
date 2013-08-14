<?php

namespace MaDev\VoyagesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true
            ))
            ->add('description')
            ->add('visite_date', 'date', array(
                'widget' => 'single_text',
                'required' => true
            ))
            ->add('status', 'checkbox', array(
                'required' => false
            ))
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MaDev\VoyagesBundle\Entity\Country'
        ));
    }

    public function getName()
    {
        return 'voyagesbundle_countrytype';
    }
}
