<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class RatingMetric implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $metric = [];
        $metric[] = ['value' => '5', 'label' => __('out of 5')];
        $metric[] = ['value' => '100', 'label' => __('out of 100')];

        return $metric;
    }
}
