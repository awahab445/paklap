<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class OpeningHours extends AbstractFieldArray
{

    protected $columns = [];
    protected $daysRenderer;

    /**
     * Render block.
     */
    protected function _prepareToRender()
    {
        $this->addColumn('day', [
            'label'    => __('Day'),
            'renderer' => $this->getDaysRenderer()
        ]);
        $this->addColumn('time_open', [
            'label' => __('Open')
        ]);
        $this->addColumn('time_close', [
            'label' => __('Close'),
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Returns render of stores.
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function getDaysRenderer()
    {
        if (!$this->daysRenderer) {
            $this->daysRenderer = $this->getLayout()->createBlock(
                '\Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field\Renderer\Days',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->daysRenderer;
    }

    /**
     * Prepare existing row data object.
     *
     * @param DataObject $row
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $day = $row->getDay();
        $options = [];
        if ($day) {
            $options['option_' . $this->getDaysRenderer()->calcOptionHash($day)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}
