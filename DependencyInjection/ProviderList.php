<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\DependencyInjection;

class ProviderList
{
    private $providers;

    public function __construct()
    {
        $this->providers = array();
    }

    public function addProvider($id, $provider)
    {
        $this->providers[$id] = $provider;
    }

    public function all()
    {
        return $this->providers;
    }

    public function choices()
    {
        $choices = array();
        foreach($this->all() as $id => $provider) {
            $choices[$id] = $id;
        }

        return $choices;
    }
}
