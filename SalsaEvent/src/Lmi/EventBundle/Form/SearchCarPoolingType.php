<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\EventBundle\Constants\Constants;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchCarPoolingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder, $options);
		
        $builder
            //->add('slug')
        	->add('eventId', 'text', array('label' => ''))
            ->add('nbPlacesDispo', 'integer', array('label'  => '', 'attr' => array('style' => 'width : 40px')))
            ->add('driverInfos', new UserInfosType(), array('required' => false, 'label'  => ' '))
			->add('trajet', new TrajetType(), array('required' => true, 'label'  => ' '))
			->add('periode', new PeriodeType(), array('required' => true))
// 			->add(Constants::FORM_INPUT_PUBLICATION, 'checkbox', array('required' => false, 'label' => 'form.field.publication', 'isPublishOption' => 'yes'))
        ;
    }

    public function getName()
    {
        return 'lmi_eventbundle_searchcarpoolingtype';
    }
}

