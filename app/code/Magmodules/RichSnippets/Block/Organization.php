<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magmodules\RichSnippets\Helper\Organization as OrganizationHelper;

class Organization extends Template
{

    protected $website;
    protected $organization;

    /**
     * Organization constructor.
     *
     * @param Context            $context
     * @param OrganizationHelper $organizationHelper
     * @param array              $data
     */
    public function __construct(
        Context $context,
        OrganizationHelper $organizationHelper,
        array $data = []
    ) {
        $this->organization = $organizationHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return array|bool
     */
    public function getSnippets()
    {
        return $this->organization->getSnippets();
    }
}
