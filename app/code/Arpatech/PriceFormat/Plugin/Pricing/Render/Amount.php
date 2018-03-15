<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Arpatech\PriceFormat\Plugin\Pricing\Render;


class Amount
{

    /**
     * @param \Magento\Framework\Pricing\Render\Amount $subject
     * @param callable|\Closure $proceed
     *  @param float $amount
     * @param bool $includeContainer
     * @param int $precision
     * @return float
     *
     **/
    public function aroundFormatCurrency(
        \Magento\Framework\Pricing\Render\Amount $subject,
        \Closure $proceed,
        $amount,
        $includeContainer = true,
        $precision = 0
    )
    {
        $returnValue = $proceed($amount,$includeContainer,$precision);

        return $returnValue;

    }
}
