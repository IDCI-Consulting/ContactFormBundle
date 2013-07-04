<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProviderChoiceType extends AbstractType
{
    protected $providerList;

    public function __construct($provider_list)
    {
        $this->providerList = $provider_list;
    }

    public function getProviderList()
    {
        return $this->providerList;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getProviderList()->choices()
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'provider_choice';
    }
}
