<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Outils\FormOutils;

/**
 * User infos type
 * @author Messi
 *
 */
class UserInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('username', 'text', array('label' => 'form.field.name', 'attr' => array('style' => 'width : 200px')))
    		->add('sexe', 'choice', array('choices'  => FormOutils::getSexesList(), 'label'  => ' ', 'multiple' => true, 'expanded' => true))
    	;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\EventBundle\Entity\UserInfos'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_userinfostype';
    }
}
