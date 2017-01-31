<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Constants\Constants;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Lmi\CoreBundle\Outils\FormOutils;

class SearchEventType extends AbstractType
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
        	->add('identification', 'text', array('label' => 'form.field.name', 'attr' => array('style' => 'width : 300px')))
            ->add('region', 'choice', array('choices'  => FormOutils::getRegionsList(), 'multiple' => false, 'attr' => array('style' => 'width : 150px')))
            ->add('villes', 'choice', array('choices'  => $villes, 'multiple' => true, 'attr' => array('style' => 'width : 150px')))
//          ->add('description', new TexteType(), array('required' => false, 'label' => 'form.field.description', 'attr' => array('class' => 'master')))
// 			->add('organisateurs', 'entity', array('class' => 'LmiEventBundle:DanceSchool', 'property' => 'nom', 'multiple' => true, 'empty_value' => '', 'required' => false))
			->add('periode', new PeriodeType(), array('required' => false))
			->add('ambiances', 'choice', array('choices'  => FormOutils::getDansesList(), 'multiple' => true, 'expanded' => true))
			->add('types', 'choice', array('choices'  => FormOutils::getEventTypesList(), 'multiple' => true, 'expanded' => true))
// 			->add(Constants::FORM_INPUT_PUBLICATION, 'checkbox', array('required' => false, 'label' => 'form.field.publication', 'isPublishOption' => 'yes'))
        ;
    }

    public function getName()
    {
        return 'lmi_eventbundle_searcheventtype';
    }
}

