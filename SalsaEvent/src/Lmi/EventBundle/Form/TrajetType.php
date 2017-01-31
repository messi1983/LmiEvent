<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\EventBundle\Constants\Constants;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('villeDepart', 'text', array('label' => '', 'attr' => array('style' => 'width : 120px')))
    		->add('villeArrivee', 'text', array('label' => '', 'attr' => array('style' => 'width : 120px')))
    	;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\EventBundle\Entity\Trajet'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_trajettype';
    }
}
