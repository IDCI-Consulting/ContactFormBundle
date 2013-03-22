<?php

namespace IDCI\Bundle\ContactFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isEnabled', null, array('required' => false))
            ->add('apiToken')
            ->add('domainList', 'text_coma_separated_values', array('required' => false))
            ->add('ipWhiteList', 'text_coma_separated_values', array('required' => false))
            ->add('ipBlackList', 'text_coma_separated_values', array('required' => false))
            ->add('httpsOnly', null, array('required' => false))
            ->add('httpMethod')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IDCI\Bundle\ContactFormBundle\Entity\Source'
        ));
    }

    public function getName()
    {
        return 'idci_bundle_contactformbundle_sourcetype';
    }
}
