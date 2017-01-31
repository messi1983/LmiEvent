<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarPoolingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('slug')
//         	->add('eventId', 'text', array('label' => ''))
            ->add('nbPlaces', 'integer', array('label'  => '', 'attr' => array('style' => 'width : 40px')))
//             ->add('driverInfos', new UserInfosType(), array('required' => false, 'label'  => ' '))
			->add('trajet', new TrajetType(), array('required' => true, 'label'  => ' '))
// 			->add('periode', new PeriodeType(), array('required' => true))
// 			->add(Constants::FORM_INPUT_PUBLICATION, 'checkbox', array('required' => false, 'label' => 'form.field.publication', 'isPublishOption' => 'yes'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\EventBundle\Entity\CarPooling'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_carpoolingtype';
    }
}
