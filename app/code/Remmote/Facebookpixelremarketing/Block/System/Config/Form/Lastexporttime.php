<?php
/**
 * @extension   Remmote_Facebookpixelremarketing
 * @author      Remmote
 * @copyright   2017 - Remmote.com
 * @descripion  Facebook Scheduled Recurring Uploads - Last Export Time
 */
namespace Remmote\Facebookpixelremarketing\Block\System\Config\Form;

class Lastexporttime extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Override _renderInheritCheckbox function. Don't return anything to delete 'use default' checkbox
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function _renderInheritCheckbox(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        
    }

}
