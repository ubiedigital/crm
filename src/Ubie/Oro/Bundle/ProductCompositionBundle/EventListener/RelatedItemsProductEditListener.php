<?php

namespace Ubie\Oro\Bundle\ProductCompositionBundle\EventListener;

use Oro\Bundle\FormBundle\Event\FormHandler\AfterFormProcessEvent;
use Oro\Bundle\FormBundle\Event\FormHandler\FormProcessEvent;
use Oro\Bundle\FormBundle\Form\Type\EntityIdentifierType;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\Form\Handler\ProductUpdateHandler;
use Oro\Bundle\ProductBundle\Form\Handler\RelatedItemsHandler;
use Oro\Bundle\ProductBundle\RelatedItem\Helper\RelatedItemConfigHelper;
use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\UIBundle\View\ScrollData;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class RelatedItemsProductEditListener
{
    const BLOCK_ID = 'productComposition';

    /** @var int */
    const BLOCK_PRIORITY = 10;

    /** @var TranslatorInterface */
    private $translator;

    /** @var RelatedItemConfigHelper */
    private $relatedItemConfigHelper;

    /** @var AuthorizationCheckerInterface */
    private $authorizationChecker;

    /**
     * @var RelatedItemsHandler
     */
    private $relatedItemsHandler;

    /**
     * RelatedItemsProductEditListener constructor.
     * @param TranslatorInterface $translator
     * @param RelatedItemConfigHelper $relatedItemConfigHelper
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param RelatedItemsHandler $relatedItemsHandler
     */
    public function __construct(
        TranslatorInterface $translator,
        RelatedItemConfigHelper $relatedItemConfigHelper,
        AuthorizationCheckerInterface $authorizationChecker,
        RelatedItemsHandler $relatedItemsHandler
    ) {
        $this->translator = $translator;
        $this->relatedItemConfigHelper = $relatedItemConfigHelper;
        $this->authorizationChecker = $authorizationChecker;
        $this->relatedItemsHandler = $relatedItemsHandler;
    }


    /**
     * @param string $name
     * @return \Oro\Bundle\ProductBundle\RelatedItem\AbstractRelatedItemConfigProvider
     */
    protected function getConfigProvider($name)
    {
        return $this->relatedItemConfigHelper->getConfigProvider($name);
    }

    /**
     * @param BeforeListRenderEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onProductEdit(BeforeListRenderEvent $event)
    {
        $twigEnv = $event->getEnvironment();
        $grids = [];

        if ($this->getConfigProvider('component_products')->isEnabled()
            && $this->authorizationChecker->isGranted('oro_component_products_edit')
        ) {
            $grids[] = $this->getComponentProductsEditBlock($event, $twigEnv);

            $this->addEditPageBlock($event->getScrollData(), $grids);
        }
    }

    /**
     * @param FormProcessEvent $event
     */
    public function onFormDataSet(FormProcessEvent $event)
    {
        if ($this->authorizationChecker->isGranted('oro_component_products_edit')) {
            $event->getForm()->add(
                'appendComponent',
                EntityIdentifierType::class,
                [
                    'class' => Product::class,
                    'required' => false,
                    'mapped' => false,
                    'multiple' => true,
                ]
            );
            $event->getForm()->add(
                'removeComponent',
                EntityIdentifierType::class,
                [
                    'class' => Product::class,
                    'required' => false,
                    'mapped' => false,
                    'multiple' => true,
                ]
            );
        } else {
            $event->getForm()->remove('appendComponent');
            $event->getForm()->remove('removeComponent');
        }
    }

    /**
     * @param AfterFormProcessEvent $event
     */
    public function onFormAfterEntityFlush(AfterFormProcessEvent $event)
    {
        $form = $event->getForm();
        $entity = $event->getData();

        if (!$form->has('appendComponent') && !$form->has('removeComponent')) {
            return;
        }

        $this->relatedItemsHandler->process(
            'componentProducts',
            $entity,
            $form->get('appendComponent'),
            $form->get('removeComponent')
        );
    }

    /**
     * @param ScrollData $scrollData
     * @param string[] $htmlBlocks
     */
    private function addEditPageBlock(ScrollData $scrollData, array $htmlBlocks)
    {
        $scrollData->addNamedBlock(
            self::BLOCK_ID,
            $this->translator->trans('ubie.oro.product_composition.label'),
            self::BLOCK_PRIORITY
        );

        $subBlock = $scrollData->addSubBlock(self::BLOCK_ID);
        $scrollData->addSubBlockData(
            self::BLOCK_ID,
            $subBlock,
            implode('', $htmlBlocks),
            self::BLOCK_ID
        );
    }

    /**
     * @param BeforeListRenderEvent $event
     * @param \Twig_Environment $twigEnv
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private function getComponentProductsEditBlock(BeforeListRenderEvent $event, \Twig_Environment $twigEnv)
    {
        return $twigEnv->render(
            '@UbieOroProductComposition/Product/RelatedItems/componentProducts.html.twig',
            [
                'form' => $event->getFormView(),
                'entity' => $event->getEntity(),
                'componentProductsLimit' => $this->getConfigProvider('component_products')->getLimit()
            ]
        );
    }
}
