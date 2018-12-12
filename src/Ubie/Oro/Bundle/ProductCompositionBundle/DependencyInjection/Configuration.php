<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Oro\Bundle\CurrencyBundle\Rounding\RoundingServiceInterface;
use Oro\Bundle\ProductBundle\DependencyInjection\OroProductExtension;
use Oro\Bundle\ProductBundle\Entity\Product;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT_NODE = UbieOroProductCompositionExtension::ALIAS;
    const COMPONENT_PRODUCTS_ENABLED = 'component_products_enabled';
    const COMPONENT_PRODUCTS_BIDIRECTIONAL = 'component_products_bidirectional';
    const MAX_NUMBER_OF_COMPONENT_PRODUCTS = 'max_number_of_component_products';
    const MAX_NUMBER_OF_COMPONENT_PRODUCTS_COUNT = 1000;
    const COMPONENT_PRODUCTS_MAX_ITEMS = 'component_products_max_items';
    const COMPONENT_PRODUCTS_MAX_ITEMS_COUNT = 1000;
    const COMPONENT_PRODUCTS_MIN_ITEMS = 'component_products_min_items';
    const COMPONENT_PRODUCTS_MIN_ITEMS_COUNT = 1;
    const COMPONENT_PRODUCTS_SHOW_ADD_BUTTON = 'component_products_show_add_button';
    const COMPONENT_PRODUCTS_USE_SLIDER_ON_MOBILE = 'component_products_use_slider_on_mobile';

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root(static::ROOT_NODE);

        SettingsBuilder::append(
            $rootNode,
            [
                static::COMPONENT_PRODUCTS_ENABLED => ['value' => true],
                static::COMPONENT_PRODUCTS_BIDIRECTIONAL => ['value' => false],
                static::MAX_NUMBER_OF_COMPONENT_PRODUCTS => [
                    'value' => static::MAX_NUMBER_OF_COMPONENT_PRODUCTS_COUNT,
                ],
                static::COMPONENT_PRODUCTS_MAX_ITEMS => [
                    'value' => static::COMPONENT_PRODUCTS_MAX_ITEMS_COUNT,
                ],
                static::COMPONENT_PRODUCTS_MIN_ITEMS => [
                    'value' => static::COMPONENT_PRODUCTS_MIN_ITEMS_COUNT,
                ],
                static::COMPONENT_PRODUCTS_SHOW_ADD_BUTTON => ['value' => true],
                static::COMPONENT_PRODUCTS_USE_SLIDER_ON_MOBILE => ['value' => false],
            ]
        );

        return $treeBuilder;
    }


    /**
     * @param string $key
     * @return string
     */
    public static function getConfigKeyByName($key)
    {
        return implode(ConfigManager::SECTION_MODEL_SEPARATOR, [static::ROOT_NODE, $key]);
    }
}
