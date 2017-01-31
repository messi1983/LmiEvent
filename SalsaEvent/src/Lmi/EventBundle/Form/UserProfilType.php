<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Outils\FormOutils;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('lastname', 'text')
    		->add('firstname', 'text')
    		->add('sexe', 'choice', array('choices'  => FormOutils::getSexesList(), 'multiple' => false, 'expanded' => true))
    		->add('email', 'text')
    		->add('password', 'repeated', array('type' => 'password'))
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
