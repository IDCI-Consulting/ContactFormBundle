<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class DataRequestTransformerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('idci_contactform.data_request_transformer_list')) {
            return;
        }

        $definition = $container->getDefinition(
            'idci_contactform.data_request_transformer_list'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'idci_contactform.data_request_transformer'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addDataRequestTransformer',
                array($id, new Reference($id))
            );
        }
    }
}
