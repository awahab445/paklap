<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ContactType implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $type = [];
        $type[] = ['value' => 'customer service', 'label' => 'customer service'];
        $type[] = ['value' => 'technical support', 'label' => 'technical support'];
        $type[] = ['value' => 'billing support', 'label' => 'billing support'];
        $type[] = ['value' => 'bill payment', 'label' => 'bill payment'];
        $type[] = ['value' => 'sales', 'label' => 'sales'];
        $type[] = ['value' => 'reservations', 'label' => 'reservations'];
        $type[] = ['value' => 'credit card support', 'label' => 'credit card support'];
        $type[] = ['value' => 'emergency', 'label' => 'emergency'];
        $type[] = ['value' => 'baggage tracking', 'label' => 'baggage tracking'];
        $type[] = ['value' => 'roadside assistance', 'label' => 'roadside assistance'];
        $type[] = ['value' => 'package tracking', 'label' => 'package tracking'];

        return $type;
    }
}
