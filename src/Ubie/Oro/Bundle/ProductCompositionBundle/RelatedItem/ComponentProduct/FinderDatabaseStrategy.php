<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\RelatedItem\ComponentProduct;

use Doctrine\ORM\EntityRepository;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\RelatedItem\AbstractRelatedItemConfigProvider;
use Oro\Bundle\ProductBundle\RelatedItem\FinderStrategyInterface;
use Ubie\Oro\Bundle\ProductCompositionBundle\Entity\RelatedItem\ComponentProduct;
use Ubie\Oro\Bundle\ProductCompositionBundle\Entity\Repository\RelatedItem\ComponentProductRepository;

/**
 * Class FinderDatabaseStrategy
 * @package Oro\Bundle\ProductBundle\RelatedItem\ComponentProduct
 */
class FinderDatabaseStrategy implements FinderStrategyInterface
{
    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;

    /**
     * @var AbstractRelatedItemConfigProvider
     */
    private $configProvider;

    /**
     * @param DoctrineHelper                    $doctrineHelper
     * @param AbstractRelatedItemConfigProvider $configProvider
     */
    public function __construct(DoctrineHelper $doctrineHelper, AbstractRelatedItemConfigProvider $configProvider)
    {
        $this->doctrineHelper = $doctrineHelper;
        $this->configProvider = $configProvider;
    }

    /**
     * {@inheritdoc}
     * If parameters `bidirectional` and `limit` are not passed - default values from configuration will be used
     */
    public function find(Product $product, $bidirectional = false, $limit = null)
    {
        if (!$this->configProvider->isEnabled()) {
            return [];
        }

        return $this->getComponentProductsRepository()
            ->findRelated(
                $product->getId(),
                $bidirectional,
                $limit
            );
    }

    /**
     * @return ComponentProductRepository|EntityRepository
     */
    private function getComponentProductsRepository()
    {
        return $this->doctrineHelper->getEntityRepository(ComponentProduct::class);
    }
}
