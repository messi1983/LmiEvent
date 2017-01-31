<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Constants\Constants;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Lmi\CoreBundle\Outils\FormOutils;

class SearchAccommodationType extends AbstractType
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
        	->add('eventId', 'text', array('label' => ''))
        	->add('landlordInfos', new UserInfosType(), array('required' => false, 'label'  => ' '))
        	->add('region', 'choice', array('choices'  => FormOutils::getRegionsList(), 'attr' => array('style' => 'width : 150px')))
        	->add('villes', 'choice', array('choices'  => $villes, 'multiple' => true, 'attr' => array('style' => 'width : 150px')))
        	->add('types', 'choice', array('choices'  => FormOutils::getAccommodationTypesList(), 'multiple' => true, 'expanded' => true))
            ->add('nbPlacesDispo', 'integer', array('label'  => '', 'attr' => array('style' => 'width : 40px')))
			->add('periode', new PeriodeType(), array('required' => true))
// 			->add(Constants::FORM_INPUT_PUBLICATION, 'checkbox', array('required' => false, 'label' => 'form.field.publication', 'isPublishOption' => 'yes'))
        ;
    }

    public function getName()
    {
        return 'lmi_eventbundle_searchaccommodationtype';
    }
}

