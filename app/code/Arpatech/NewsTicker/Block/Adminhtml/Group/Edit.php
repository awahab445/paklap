<?php
/**
 * Arpatech Software.
 *
 * @category  Arpatech
 * @package   Arpatech_NewsTicker
 * @author    Arpatech
 * @copyright Copyright (c) 2010-2016
 * @license
 */
namespace Arpatech\NewsTicker\Block\Adminhtml\Group;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Initialize NewsTicker Group Edit Block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'group_id';
        $this->_blockGroup = 'Arpatech_NewsTicker';
        $this->_controller = 'adminhtml_group';
        parent::_construct();
        if ($this->_isAllowedAction('Arpatech_NewsTicker::group')) {
            $this->buttonList->update('save', 'label', __('Save Group'));
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * Retrieve text for header element depending on loaded Group
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('newsticker_group')->getId()) {
            $title = $this->_coreRegistry->registry('newsticker_group')->getTitle();
            $title = $this->escapeHtml($title);
            return __("Edit Group '%'", $title);
        } else {
            return __('New Group');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
