<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\RelatedItem\ComponentProduct;

use Ubie\Oro\Bundle\ProductCompositionBundle\Entity\RelatedItem\ComponentProduct;
use Oro\Bundle\ProductBundle\RelatedItem\AbstractAssignerDatabaseStrategy;

/**
 * Class AssignerDatabaseStrategy
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\RelatedItem\ComponentProduct
 */
class AssignerDatabaseStrategy extends AbstractAssignerDatabaseStrategy
{
    /**
     * {@inheritDoc}
     */
    protected function createNewRelation()
    {
        return new ComponentProduct();
    }

    /**
     * {@inheritDoc}
     */
    protected function getEntityManager()
    {
        return $this->doctrineHelper->getEntityManager(ComponentProduct::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function getRepository()
    {
        return $this->doctrineHelper->getEntityRepository(ComponentProduct::class);
    }
}
