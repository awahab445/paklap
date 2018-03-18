<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magmodules\RichSnippets\Helper\Website as WebsiteHelper;

class Website extends Template
{

    protected $website;

    /**
     * Website constructor.
     *
     * @param Context       $context
     * @param WebsiteHelper $website
     * @param array         $data
     */
    public function __construct(
        Context $context,
        WebsiteHelper $website,
        array $data = []
    ) {
        $this->website = $website;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getSnippets()
    {
        return $this->website->getSnippets();
    }
}
