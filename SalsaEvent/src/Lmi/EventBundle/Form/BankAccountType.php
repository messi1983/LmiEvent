<?php

namespace Lmi\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lmi\CoreBundle\Outils\FormOutils;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Bank account type
 * @author Messi
 *
 */
class BankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('holder', 'text')
    		->add('iBAN', 'text')
    		->add('bIC', 'text')
    	;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lmi\CoreBundle\Entity\BankAccount'
        ));
    }

    public function getName()
    {
        return 'lmi_eventbundle_bankaccounttype';
    }
}
