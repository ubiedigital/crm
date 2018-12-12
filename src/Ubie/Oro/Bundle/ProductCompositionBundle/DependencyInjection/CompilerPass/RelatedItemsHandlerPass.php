<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RelatedItemsHandlerPass
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\CompilerPass
 */
class RelatedItemsHandlerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $handlerDefinition = $container->getDefinition('oro_product.service.related_items_handler');
        $handlerDefinition->addMethodCall(
            'addAssigner',
            [
                'componentProducts',
                $container->getDefinition('oro_product.related_item.component_product.assigner_strategy')
            ]
        );
    }
}
