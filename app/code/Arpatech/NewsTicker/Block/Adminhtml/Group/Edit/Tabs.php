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
namespace Arpatech\NewsTicker\Block\Adminhtml\Group\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('group_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Group Information'));
    }

    /**
    * Prepare Layout
    *
    * @return $this
    */
    protected function _prepareLayout()
    {
        $block = 'Arpatech\NewsTicker\Block\Adminhtml\Group\Edit\Tab\Group';
        $this->addTab(
            'group',
            [
                'label' => __('Group'),
                'content' => $this->getLayout()->createBlock($block, 'group')->toHtml(),
            ]
        );
        $this->addTab(
            'news',
            [
                'label' => __('Group News'),
                'url' => $this->getUrl('newsticker/*/news', ['_current' => true]),
                'class' => 'ajax'
            ]
        );
        return parent::_prepareLayout();
    }
}
