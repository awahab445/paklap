<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magmodules\RichSnippets\Helper\Product as ProductHelper;

class Product extends Template
{

    protected $product;
    protected $registry;

    /**
     * Product constructor.
     *
     * @param Context       $context
     * @param Registry      $registry
     * @param ProductHelper $product
     * @param array         $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ProductHelper $product,
        array $data = []
    ) {
        $this->product = $product;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return array|bool
     */
    public function getSnippets()
    {
        $product = $this->getCurrentProduct();

        return $this->product->getSnippets($product);
    }

    /**
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
}
