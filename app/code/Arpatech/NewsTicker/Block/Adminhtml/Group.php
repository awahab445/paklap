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
namespace Arpatech\NewsTicker\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Group extends Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_group';
        $this->_blockGroup = 'Arpatech_NewsTicker';
        $this->_headerText = __('Manage Group');
        parent::_construct();
        $this->buttonList->update('add', 'label', __('Add New Group'));
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
