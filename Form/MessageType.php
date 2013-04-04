<?php

namespace IDCI\Bundle\ContactFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('source')
            ->add('provider', 'provider_choice')
            ->add('data')
            ->add('ip')
            ->add('userAgent')
            ->add('header')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IDCI\Bundle\ContactFormBundle\Entity\Message'
        ));
    }

    public function getName()
    {
        return 'idci_bundle_contactformbundle_messagetype';
    }
}
