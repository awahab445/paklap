<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ConditionType implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $condition = [];
        $condition[] = ['value' => '', 'label' => __('No')];
        $condition[] = ['value' => '1', 'label' => __('Yes, same for all')];
        $condition[] = ['value' => '2', 'label' => __('Yes, use attribute')];

        return $condition;
    }
}
