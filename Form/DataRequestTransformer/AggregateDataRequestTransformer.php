<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\DataRequestTransformer;

class AggregateDataRequestTransformer implements DataRequestTransformerInterface
{
    public function __construct()
    {
    }

    public function transform($data)
    {
        $transformedData = array_values($data);

        return $transformedData[0];
    }
}
