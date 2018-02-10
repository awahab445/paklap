<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class SocialLinks extends AbstractFieldArray
{

    /**
     * Render block.
     */
    protected function _prepareToRender()
    {
        $this->addColumn('url', ['label' => __('URL'),]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
