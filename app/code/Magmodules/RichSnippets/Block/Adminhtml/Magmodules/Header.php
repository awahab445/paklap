<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\Magmodules;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magmodules\RichSnippets\Helper\General as GeneralHelper;
use Magento\Backend\Block\Template\Context;

class Header extends Field
{

    /** Module and support code for loading image */
    const MODULE_CODE = 'richsnippets-magento2';

    /** Support and contact link */
    const MODULE_SUPPORT_LINK = 'https://www.magmodules.eu/help/' . self::MODULE_CODE;
    const MODULE_CONTACT_LINK = 'https://www.magmodules.eu/support.html?ext=' . self::MODULE_CODE;
    protected $_template = 'Magmodules_RichSnippets::system/config/fieldset/header.phtml';
    private $general;

    /**
     * Header constructor.
     *
     * @param Context       $context
     * @param GeneralHelper $general
     */
    public function __construct(
        Context $context,
        GeneralHelper $general
    ) {
        $this->general = $general;
        parent::__construct($context);
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->addClass('magmodules');

        return $this->toHtml();
    }

    /**
     * Image with extension and magento version.
     *
     * @return string
     */
    public function getImage()
    {
        $extVersion = $this->general->getExtensionVersion();
        $magVersion = $this->general->getMagentoVersion();

        return sprintf('https://www.magmodules.eu/logo/%s/%s/%s/logo.png', self::MODULE_CODE, $extVersion, $magVersion);
    }

    /**
     * Contact link for extension.
     *
     * @return string
     */
    public function getContactLink()
    {
        return self::MODULE_CONTACT_LINK;
    }

    /**
     * Support link for extension.
     *
     * @return string
     */
    public function getSupportLink()
    {
        return self::MODULE_SUPPORT_LINK;
    }
}
