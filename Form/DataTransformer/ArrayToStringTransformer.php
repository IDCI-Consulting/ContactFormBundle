<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;

class ArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * @param array $array
     * @return string
     *
     * @throws UnexpectedTypeException if the given value is not an array
     */
    public function transform($array)
    {
        if (null === $array) {
            return null;
        }

        if (!is_array($array)) {
            throw new UnexpectedTypeException($array, 'array');
        }

        return implode(',', $array);
    }

    /**
     * @param string $string
     * @return array
     */
    public function reverseTransform($string)
    {
        if (null === $string) {
            return null;
        }

        return explode(',', $string);
    }
}
