<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\DataRequestTransformer;

class BaseDataRequestTransformer implements DataRequestTransformerInterface
{
    public function __construct()
    {
    }

    public function transform($data)
    {
        return $data;
    }
}
