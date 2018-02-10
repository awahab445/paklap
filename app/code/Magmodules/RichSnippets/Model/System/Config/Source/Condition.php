<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Condition implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $condition = [];
        $condition[] = ['value' => 'new', 'label' => __('New')];
        $condition[] = ['value' => 'refurbished', 'label' => __('Refurbished')];
        $condition[] = ['value' => 'used', 'label' => __('Used')];
        $condition[] = ['value' => 'damaged', 'label' => __('Damaged')];

        return $condition;
    }
}
