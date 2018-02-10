<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field\Renderer;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magmodules\RichSnippets\Model\System\Config\Source\Days as DaysSource;

class Days extends Select
{

    protected $days = [];
    protected $daysSource;

    /**
     * Days constructor.
     *
     * @param Context    $context
     * @param DaysSource $daysSource
     * @param array      $data
     */
    public function __construct(
        Context $context,
        DaysSource $daysSource,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->daysSource = $daysSource;
    }

    /**
     * Render block HTML.
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->getDaysSource() as $day) {
                $this->addOption($day['value'], $day['label']);
            }
        }

        return parent::_toHtml();
    }

    /**
     * Get all groups.
     *
     * @return array
     */
    protected function getDaysSource()
    {
        if (!$this->days) {
            $this->days = $this->daysSource->toOptionArray();
        }

        return $this->days;
    }

    /**
     * Sets name for input element
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
