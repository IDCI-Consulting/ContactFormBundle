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
use IDCI\Bundle\ContactFormBundle\Form\DataTransformer\ArrayToStringTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextComaSeparatedValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ArrayToStringTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'text_coma_separated_values';
    }
}
