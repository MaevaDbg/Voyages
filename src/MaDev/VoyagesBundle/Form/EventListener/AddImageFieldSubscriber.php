<?php
namespace MaDev\VoyagesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddImageFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // check if the product object is "new"
        // If you didn't pass any data to the form, the data is "null".
        // This should be considered a new "Product"
        if (!$data || !$data->getId()) {
            $form->add('image', 'entity', array(
                'class' => 'MaDevUploadFileBundle:File',
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->leftJoin('f.city','c')
                        ->Where('c IS NULL');
                },
            ));
        }else{
            $form->add('image', 'entity', array(
                'class' => 'MaDevUploadFileBundle:File',
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
                'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('f')
                        ->leftJoin('f.city','c');
                    return $qb;
                },
            ));
        }
    }
}
?>
