<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RelatedItemConfigProviderPass
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\CompilerPass
 */
class RelatedItemConfigProviderPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $handlerDefinition = $container->getDefinition('oro_product.related_item.helper.config_helper');
        $handlerDefinition->addMethodCall(
            'addConfigProvider',
            [
                'component_products',
                $container->getDefinition('oro_product.related_item.component_product.config_provider')
            ]
        );
    }
}
