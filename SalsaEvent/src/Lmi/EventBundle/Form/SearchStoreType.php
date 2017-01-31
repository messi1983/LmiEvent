<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Constants\Constants;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchStoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder, $options);
		
		$domaines = array(
				'salsa'    => 'Salsa',
				'kizomba'  => 'Kizomba',
				'bachata'  => 'Bachata'
		);
		
		$equipements = array(
				'chaussure'    => 'Chaussure',
				'vetement'   => 'Vetement'
		);
		
		$regions = array(
				'empty_value' => '*Toutes*',
				'aquitaine' => 'Aquitaine'
		);
		
		$villes = array(
				'empty_value' => '*Toutes*',
				'bordeaux' => 'Bordeaux'
		);
		
        $builder
            //->add('slug')
            ->add('region', 'choice', array('choices'  => $regions))
            ->add('villes', 'choice', array('choices'  => $villes, 'multiple' => true))
			->add('domaines', 'choice', array('choices'  => $domaines, 'multiple' => true, 'expanded' => true))
			->add('equipements', 'choice', array('choices'  => $equipements, 'multiple' => true, 'expanded' => true))
// 			->add(Constants::FORM_INPUT_PUBLICATION, 'checkbox', array('required' => false, 'label' => 'form.field.publication', 'isPublishOption' => 'yes'))
        ;
    }

    public function getName()
    {
        return 'lmi_eventbundle_searchstoretype';
    }
}

