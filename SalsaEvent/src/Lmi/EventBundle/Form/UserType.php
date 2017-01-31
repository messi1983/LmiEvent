<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Outils\FormOutils;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('lastname', 'text', array('label' => ' ', 'attr' => array('style' => 'width : 300px; height: 15px', 'placeholder' => 'Nom')))
    		->add('firstname', 'text', array('label' => ' ', 'attr' => array('style' => 'width : 300px; height: 15px', 'placeholder' => 'Prénom')))
    		->add('sexe', 'choice', array('choices'  => FormOutils::getSexesList(), 'label'  => ' ', 'multiple' => false, 'expanded' => true))
    		->add('email', 'text', array('label' => ' ', 'attr' => array('style' => 'width : 300px; height: 15px', 'placeholder' => 'E-mail')))
    		->add('password', 'text', array('label' => ' ', 'attr' => array('style' => 'width : 300px; height: 15px', 'placeholder' => 'Mot de passe')))
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
