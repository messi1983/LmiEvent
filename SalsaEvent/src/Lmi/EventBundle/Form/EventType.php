<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\EventBundle\Constants\Constants;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('label' => 'form.field.name'))
			->add('description', new TexteType(), array('required' => false, 'label' => 'form.field.description', 'attr' => array('class' => 'master')))
			->add('periode', new PeriodeType(Constants::CLASS_EVENT), array('required' => false, 'label' => ' '))
            ->add('adresse',  new AdresseType(), array('label' => 'form.field.address', 'attr' => array('class' => 'master')))
            ->add('link', 'text', array('required' => false, 'label' => 'form.field.link', 'attr' => array('class' => 'lien')))
            ->add('tel', 'text', array('required' => false, 'label' => 'form.field.phone.number'))
            ->add('logo', new ImageType(false), array('required' => false, 'label' => 'form.field.logo', 'attr' => array('class' => 'subContent')))
			->add(Constants::FORM_INPUT_PUBLICATION, 'checkbox', array('required' => false, 'label' => 'form.field.publication', 'isPublishOption' => 'yes'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\EventBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_eventtype';
    }
}
