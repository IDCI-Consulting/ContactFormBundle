<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataRequestTransformerChoiceType extends AbstractType
{
    protected $dataRequestTransformerList;

    public function __construct($dataRequestTransformerList)
    {
        $this->dataRequestTransformerList = $dataRequestTransformerList;
    }

    public function getDataRequestTransformerList()
    {
        return $this->dataRequestTransformerList;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getDataRequestTransformerList()->choices()
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'data_request_transformer_choice';
    }
}
