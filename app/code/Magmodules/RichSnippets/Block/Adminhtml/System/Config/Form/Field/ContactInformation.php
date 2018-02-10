<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ContactInformation extends AbstractFieldArray
{

    protected $columns = [];
    protected $contactTypeRenderer;

    /**
     * Render block.
     */
    protected function _prepareToRender()
    {
        $this->addColumn('telephone', [
            'label' => __('Telephone'),
        ]);
        $this->addColumn('contact_type', [
            'label'    => __('Contact Type'),
            'renderer' => $this->getContactTypeRenderer()
        ]);
        $this->addColumn('contact_option', [
            'label' => __('Contact Option'),
        ]);
        $this->addColumn('area', [
            'label' => __('Area Code'),
        ]);
        $this->addColumn('languages', [
            'label' => __('Languages'),
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Returns render of stores.
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function getContactTypeRenderer()
    {
        if (!$this->contactTypeRenderer) {
            $this->contactTypeRenderer = $this->getLayout()->createBlock(
                '\Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field\Renderer\ContactType',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->contactTypeRenderer;
    }

    /**
     * Prepare existing row data object.
     *
     * @param DataObject $row
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $type = $row->getContactType();
        $options = [];
        if ($type) {
            $options['option_' . $this->getContactTypeRenderer()->calcOptionHash($type)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}
