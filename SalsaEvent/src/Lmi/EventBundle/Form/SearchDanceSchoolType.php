<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Constants\Constants;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Lmi\CoreBundle\Outils\FormOutils;

class SearchDanceSchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder, $options);
		
		$villes = array(
				'empty_value' => '*Toutes*',
				'bordeaux' => 'Bordeaux'
		);
		
        $builder
            //->add('slug')
        	->add('nom', 'text', array('label' => 'form.field.name', 'attr' => array('style' => 'width : 300px; height: 15px')))
            ->add('region', 'choice', array('choices'  => FormOutils::getRegionsList()))
            ->add('villes', 'choice', array('choices'  => $villes, 'multiple' => true))
//          ->add('description', new TexteType(), array('required' => false, 'label' => 'form.field.description', 'attr' => array('class' => 'master')))
// 			->add('organisateurs', 'entity', array('class' => 'LmiEventBundle:DanceSchool', 'property' => 'nom', 'multiple' => true, 'empty_value' => '', 'required' => false))
			->add('ambiances', 'choice', array('choices'  => FormOutils::getDansesList(), 'multiple' => true, 'expanded' => true))
        ;
    }

    public function getName()
    {
        return 'lmi_eventbundle_searchdancedanceschooltype';
    }
}

