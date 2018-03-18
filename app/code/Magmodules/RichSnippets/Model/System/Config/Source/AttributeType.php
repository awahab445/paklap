<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class AttributeType implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $type = [];
        $type[] = ['value' => 'description', 'label' => __('Description')];
        $type[] = ['value' => 'brand', 'label' => __('Brand')];
        $type[] = ['value' => 'model', 'label' => __('Model')];
        $type[] = ['value' => 'sku', 'label' => __('SKU')];
        $type[] = ['value' => 'gtin8', 'label' => __('Gtin8')];
        $type[] = ['value' => 'gtin12', 'label' => __('Gtin12')];
        $type[] = ['value' => 'gtin13', 'label' => __('Gtin13')];
        $type[] = ['value' => 'gtin14', 'label' => __('Gtin14')];
        $type[] = ['value' => 'mpn', 'label' => __('Mpn')];
        $type[] = ['value' => 'isbn', 'label' => __('Isbn')];

        return $type;
    }
}
