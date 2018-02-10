<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ProductAttributes extends AbstractFieldArray
{

    protected $columns = [];
    protected $typeRenderer;
    protected $attributeRenderer;

    /**
     * Render block.
     */
    protected function _prepareToRender()
    {
        $this->addColumn('type', [
            'label'    => __('Type'),
            'renderer' => $this->getTypeRenderer()
        ]);
        $this->addColumn('attribute', [
            'label'    => __('Attribute'),
            'renderer' => $this->getAttributeRenderer()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Returns render of stores.
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function getTypeRenderer()
    {
        if (!$this->typeRenderer) {
            $this->typeRenderer = $this->getLayout()->createBlock(
                '\Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field\Renderer\AttributeType',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->typeRenderer;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function getAttributeRenderer()
    {
        if (!$this->attributeRenderer) {
            $this->attributeRenderer = $this->getLayout()->createBlock(
                '\Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field\Renderer\Attributes',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->attributeRenderer;
    }

    /**
     * Prepare existing row data object.
     *
     * @param DataObject $row
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $type = $row->getType();
        $attribute = $row->getAttribute();
        $options = [];
        if ($type) {
            $options['option_' . $this->getTypeRenderer()->calcOptionHash($type)] = 'selected="selected"';
        }
        if ($attribute) {
            $options['option_' . $this->getAttributeRenderer()->calcOptionHash($attribute)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}
