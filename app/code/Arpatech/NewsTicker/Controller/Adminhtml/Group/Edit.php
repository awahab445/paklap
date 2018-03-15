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
namespace Arpatech\NewsTicker\Controller\Adminhtml\Group;

use Arpatech\NewsTicker\Controller\Adminhtml\Group as GroupController;
use Magento\Framework\Controller\ResultFactory;

class Edit extends GroupController
{
    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $_backendSession;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Arpatech\NewsTicker\Model\GroupFactory
     */
    protected $_group;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Arpatech\NewsTicker\Model\GroupFactory $group
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Arpatech\NewsTicker\Model\GroupFactory $group
    ) {
        $this->_backendSession = $context->getSession();
        $this->_registry = $registry;
        $this->_group = $group;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $group = $this->_group->create();
        if ($this->getRequest()->getParam('id')) {
            $group->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $group->setData($data);
        }
        $this->_registry->register('newsticker_group', $group);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Group'));
        $resultPage->getConfig()->getTitle()->prepend(
            $group->getId() ? $group->getTitle() : __('New Group')
        );
        $block = 'Arpatech\NewsTicker\Block\Adminhtml\Group\Edit';
        $content = $resultPage->getLayout()->createBlock($block);
        $resultPage->addContent($content);
        $block = 'Arpatech\NewsTicker\Block\Adminhtml\Group\Edit\Tabs';
        $left = $resultPage->getLayout()->createBlock($block);
        $resultPage->addLeft($left);
        return $resultPage;
    }
}
