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

class News extends \Arpatech\NewsTicker\Controller\Adminhtml\Group
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
     * @var \Arpatech\NewsTicker\Model\GalleryFactory
     */
    protected $_group;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Arpatech\NewsTicker\Model\GalleryFactory $gallery
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Arpatech\NewsTicker\Model\GroupFactory $group,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        $this->_backendSession = $context->getSession();
        $this->_registry = $registry;
        $this->_group = $group;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $group= $this->_group->create();
        if ($this->getRequest()->getParam('id')) {
            $group->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $group->setData($data);
        }
        $this->_registry->register('newsticker_group', $group);
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()
                    ->getBlock('newsticker.group.edit.tab.news');
        return $resultLayout;
    }
}
