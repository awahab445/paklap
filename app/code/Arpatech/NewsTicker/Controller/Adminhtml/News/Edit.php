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
namespace Arpatech\NewsTicker\Controller\Adminhtml\News;

use Arpatech\NewsTicker\Controller\Adminhtml\News as NewsController;
use Magento\Framework\Controller\ResultFactory;

class Edit extends NewsController
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
     * @var \Arpatech\NewsTicker\Model\NewsFactory
     */
    protected $_news;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Arpatech\NewsTicker\Model\NewsFactory $news
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Arpatech\NewsTicker\Model\NewsFactory $news
    ) {
        $this->_backendSession = $context->getSession();
        $this->_registry = $registry;
        $this->_news = $news;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $news = $this->_news->create();
        if ($this->getRequest()->getParam('id')) {
            $news->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $news->setData($data);
        }
        $this->_registry->register('newsticker_news', $news);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('News'));
        $resultPage->getConfig()->getTitle()->prepend(
            $news->getId() ? $news->getTitle() : __('New News')
        );
        $block = 'Arpatech\NewsTicker\Block\Adminhtml\News\Edit';
        $content = $resultPage->getLayout()->createBlock($block);
        $resultPage->addContent($content);
        return $resultPage;
    }
}
