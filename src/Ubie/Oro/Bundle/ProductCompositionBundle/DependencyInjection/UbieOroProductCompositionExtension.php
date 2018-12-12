<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class UbieOroProductCompositionExtension
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection
 */
class UbieOroProductCompositionExtension extends Extension
{
    const ALIAS = 'ubie_oro_product_composition';

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('services_api.yml');
        $loader->load('related_items.yml');

        $container->prependExtensionConfig($this->getAlias(), $config);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return self::ALIAS;
    }
}
