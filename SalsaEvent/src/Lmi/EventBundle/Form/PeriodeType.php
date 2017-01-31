<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\EventBundle\Constants\Constants;

class PeriodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('dateDebut', 'date', array('label' => 'form.field.date.start', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'datepicker', 'style' => 'width : 100px')))
    		->add('dateFin', 'date', array('label' => 'form.field.date.end', 'required' => false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'datepicker', 'style' => 'width : 100px')))
    	;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\EventBundle\Entity\Periode'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_periodetype';
    }
}
