<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\CompilerPass\RelatedItemConfigProviderPass;
use Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\CompilerPass\RelatedItemsHandlerPass;

/**
 * Class UbieOroProductCompositionBundle
 * @package Ubie\Oro\Bundle\ProductBundle
 */
class UbieOroProductCompositionBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new RelatedItemConfigProviderPass())
            ->addCompilerPass(new RelatedItemsHandlerPass())
        ;
    }
}
