<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
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
        return $data;
    }
}