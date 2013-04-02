<?php

namespace IDCI\Bundle\ContactFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SourceProviderParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key')
            ->add('value')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IDCI\Bundle\ContactFormBundle\Entity\SourceProviderParameter'
        ));
    }

    public function getName()
    {
        return 'idci_bundle_contactformbundle_sourceproviderparametertype';
    }
}