<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Outils\FormOutils;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Car infos type
 * @author Messi
 *
 */
class CarInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('designation', 'text')
    		->add('nbPlaces', 'integer')
    	;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\CoreBundle\Entity\CarInfos'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_carinfostype';
    }
}
