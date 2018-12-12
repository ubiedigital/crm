<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\Twig;

use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\RelatedItem\FinderStrategyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ProductCompositionExtension
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\Twig
 */
class ProductCompositionExtension extends \Twig_Extension
{
    const NAME = 'oro_product_composition';

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'get_component_products_ids',
                [$this, 'getComponentProductsIds']
            ),
        ];
    }

    /**
     * @param Product $product
     * @return int[]
     */
    public function getComponentProductsIds(Product $product)
    {
        return $this->getRelatedItemsIds(
            $product,
            $this->container->get('oro_product.related_item.component_product.finder_strategy')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param Product $product
     * @param FinderStrategyInterface $finderStrategy
     * @return \int[]
     */
    private function getRelatedItemsIds(Product $product, FinderStrategyInterface $finderStrategy)
    {
        /** @var Product[] $related */
        $related = $finderStrategy->find($product, false, null);

        return $this->getIdsFromProducts($related);
    }

    /**
     * @param Product[] $products
     * @return int[]
     */
    private function getIdsFromProducts(array $products)
    {
        $ids = [];

        foreach ($products as $product) {
            $ids[] = $product->getId();
        }

        return $ids;
    }
}
