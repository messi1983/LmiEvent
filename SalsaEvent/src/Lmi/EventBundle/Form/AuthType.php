<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Outils\FormOutils;

class AuthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('username', 'text', array('label' => ' ', 'attr' => array('style' => 'height: 15px', 'placeholder' => 'Identifiant')))
    		->add('password', 'text', array('label' => ' ', 'attr' => array('style' => 'height: 15px', 'placeholder' => 'mot de passe')))
    	;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\CoreBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_usertype';
    }
}
