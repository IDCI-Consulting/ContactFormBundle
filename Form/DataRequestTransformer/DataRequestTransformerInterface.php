<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Form\DataRequestTransformer;

interface DataRequestTransformerInterface
{
    public function transform($data);
}
