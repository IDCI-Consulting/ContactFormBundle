<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\DataRequestTransformer;

class BasicDataRequestTransformer implements DataRequestTransformerInterface
{
    public function __construct()
    {
    }

    public function transform($data)
    {
        return $data;
    }
}
