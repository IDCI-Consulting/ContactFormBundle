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
            ->add('isEnabled')
            ->add('apiToken')
            ->add('domainList')
            ->add('ipWhiteList')
            ->add('ipBlackList')
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
