<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Days implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $days = [];
        $days[] = ['value' => 'Monday', 'label' => __('Monday')];
        $days[] = ['value' => 'Tuesday', 'label' => __('Tuesday')];
        $days[] = ['value' => 'Wednesday', 'label' => __('Wednesday')];
        $days[] = ['value' => 'Thursday', 'label' => __('Thursday')];
        $days[] = ['value' => 'Friday', 'label' => __('Friday')];
        $days[] = ['value' => 'Saturday', 'label' => __('Saturday')];
        $days[] = ['value' => 'Sunday', 'label' => __('Sunday')];

        return $days;
    }
}
