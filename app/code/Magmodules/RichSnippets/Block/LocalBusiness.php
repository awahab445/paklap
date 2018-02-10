<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magmodules\RichSnippets\Helper\LocalBusiness as LocalBusinessHelper;

class LocalBusiness extends Template
{

    protected $business;

    /**
     * LocalBusiness constructor.
     *
     * @param Context             $context
     * @param LocalBusinessHelper $localBusinessHelper
     * @param array               $data
     */
    public function __construct(
        Context $context,
        LocalBusinessHelper $localBusinessHelper,
        array $data = []
    ) {
        $this->business = $localBusinessHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return array|bool
     */
    public function getSnippets()
    {
        return $this->business->getSnippets();
    }
}
