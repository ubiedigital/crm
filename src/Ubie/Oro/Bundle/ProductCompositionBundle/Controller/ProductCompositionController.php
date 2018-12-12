<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\Controller;

use Oro\Bundle\ProductBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductCompositionController
 * @package Ubie\Oro\Bundle\ProductCompositionBundle\Controller
 */
class ProductCompositionController extends Controller
{
    /**
     * @Route(
     *     "/get-possible-products-for-component-products/{id}",
     *     name="oro_product_possible_products_for_component_products",
     *     requirements={"id"="\d+"}
     * )
     * @Template(template="UbieOroProductCompositionBundle:Product:selectComponentProducts.html.twig")
     *
     * @param Product $product
     * @return array
     */
    public function getPossibleProductsForComponentProductsAction(Product $product)
    {
        return ['product' => $product];
    }
}
