<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\DependencyInjection;

class DataRequestTransformerList
{
    private $dataRequestTransformers;

    public function __construct()
    {
        $this->dataRequestTransformers = array();
    }

    public function addDataRequestTransformer($id, $data_request_transformer)
    {
        $this->dataRequestTransformers[$id] = $data_request_transformer;
    }

    public function all()
    {
        return $this->dataRequestTransformers;
    }

    public function choices()
    {
        $choices = array();
        foreach($this->all() as $id => $transformer) {
            $choices[$id] = $id;
        }

        return $choices;
    }
}
