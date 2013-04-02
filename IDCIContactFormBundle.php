<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use IDCI\Bundle\ContactFormBundle\DependencyInjection\Compiler\ProviderCompilerPass;
use IDCI\Bundle\ContactFormBundle\DependencyInjection\Compiler\DataRequestTransformerCompilerPass;

class IDCIContactFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProviderCompilerPass());
        $container->addCompilerPass(new DataRequestTransformerCompilerPass());
    }
}
