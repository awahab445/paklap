<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field\Renderer;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magmodules\RichSnippets\Model\System\Config\Source\ContactType as ContactTypeSource;

class ContactType extends Select
{

    protected $type = [];
    protected $typeSource;

    /**
     * ContactType constructor.
     *
     * @param Context           $context
     * @param ContactTypeSource $typeSource
     * @param array             $data
     */
    public function __construct(
        Context $context,
        ContactTypeSource $typeSource,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->typeSource = $typeSource;
    }

    /**
     * Render block HTML.
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->getTypeSource() as $type) {
                $this->addOption($type['value'], $type['label']);
            }
        }

        return parent::_toHtml();
    }

    /**
     * Get all groups.
     *
     * @return array
     */
    protected function getTypeSource()
    {
        if (!$this->type) {
            $this->type = $this->typeSource->toOptionArray();
        }

        return $this->type;
    }

    /**
     * Sets name for input element.
     *
     * @param $value
     *
     * @return mixed
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}
