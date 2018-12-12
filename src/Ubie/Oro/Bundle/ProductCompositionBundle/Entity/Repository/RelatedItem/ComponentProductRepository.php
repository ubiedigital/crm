<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\Entity\Repository\RelatedItem;

use Doctrine\ORM\EntityRepository;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\RelatedItem\AbstractAssignerRepositoryInterface;
use Ubie\Oro\Bundle\ProductCompositionBundle\Entity\RelatedItem\ComponentProduct;

/**
 * Class ComponentProductRepository
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\Entity\Repository\RelatedItem
 */
class ComponentProductRepository extends EntityRepository implements AbstractAssignerRepositoryInterface
{
    /**
     * @param Product|int $productFrom
     * @param Product|int $productTo
     * @return bool
     */
    public function exists($productFrom, $productTo)
    {
        return null !== $this->findOneBy(['product' => $productFrom, 'relatedItem' => $productTo]);
    }

    /**
     * @param int $id
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countRelationsForProduct($id)
    {
        return (int) $this->createQueryBuilder('component_products')
            ->select('COUNT(component_products.id)')
            ->where('component_products.product = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $id
     * @param bool $bidirectional
     * @param int|null $limit
     * @return Product[]
     */
    public function findRelated($id, $bidirectional, $limit = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('DISTINCT IDENTITY(cp.relatedItem) as id')
            ->from(ComponentProduct::class, 'cp')
            ->where('cp.product = :id')
            ->setParameter(':id', $id)
            ->orderBy('cp.relatedItem');
        if ($limit) {
            $qb->setMaxResults($limit);
        }
        $productIds = $qb->getQuery()->getArrayResult();
        $productIds = array_column($productIds, 'id');
        $products = [];
        if ($bidirectional) {
            if ($limit === null || count($productIds) < $limit) {
                $qb = $this->getEntityManager()->createQueryBuilder()
                    ->select('DISTINCT IDENTITY(cp.product) as id')
                    ->from(ComponentProduct::class, 'cp')
                    ->where('cp.relatedItem = :id')
                    ->setParameter(':id', $id)
                    ->orderBy('cp.product');
                if ($limit) {
                    $qb->setMaxResults($limit);
                }
                $biProductIds = $qb->getQuery()->getArrayResult();
                $biProductIds = array_column($biProductIds, 'id');
                $productIds = array_merge($productIds, $biProductIds);
            }
        }

        if ($productIds) {
            $products = $this->getEntityManager()
                ->getRepository(Product::class)
                ->findBy(['id' => $productIds], ['id' => 'ASC'], $limit);
        }

        return $products;
    }
}
