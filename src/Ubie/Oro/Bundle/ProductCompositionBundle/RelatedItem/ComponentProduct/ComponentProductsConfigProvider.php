<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\RelatedItem\ComponentProduct;

use Ubie\Oro\Bundle\ProductCompositionBundle\DependencyInjection\Configuration;
use Oro\Bundle\ProductBundle\RelatedItem\AbstractRelatedItemConfigProvider;

/**
 * Class ComponentProductsConfigProvider
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\RelatedItem\ComponentProduct
 */
class ComponentProductsConfigProvider extends AbstractRelatedItemConfigProvider
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::COMPONENT_PRODUCTS_ENABLED));
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::MAX_NUMBER_OF_COMPONENT_PRODUCTS));
    }

    /**
     * {@inheritdoc}
     */
    public function isBidirectional()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::COMPONENT_PRODUCTS_BIDIRECTIONAL));
    }

    /**
     * {@inheritdoc}
     */
    public function getMinimumItems()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::COMPONENT_PRODUCTS_MIN_ITEMS));
    }

    /**
     * {@inheritdoc}
     */
    public function getMaximumItems()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::COMPONENT_PRODUCTS_MAX_ITEMS));
    }

    /**
     * {@inheritdoc}
     */
    public function isSliderEnabledOnMobile()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::COMPONENT_PRODUCTS_USE_SLIDER_ON_MOBILE));
    }

    /**
     * {@inheritdoc}
     */
    public function isAddButtonVisible()
    {
        return $this->configManager
            ->get(sprintf('%s.%s', Configuration::ROOT_NODE, Configuration::COMPONENT_PRODUCTS_SHOW_ADD_BUTTON));
    }
}
