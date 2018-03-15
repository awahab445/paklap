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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Arpatech\NewsTicker\Model\NewsFactory
     */
    protected $_news;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader
     * @param \Arpatech\NewsTicker\Model\NewsFactory $news
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader,
        \Arpatech\NewsTicker\Model\NewsFactory $news
    ) {
        $this->_fileSystem = $fileSystem;
        $this->_uploader = $fileUploader;
        $this->_news = $news;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Arpatech_NewsTicker::news');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $error = false;
        $data = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            $id = (int) $this->getRequest()->getParam('id');
            $this->setNewsData($data);
            $this->messageManager->addSuccess(__('News saved succesfully'));
        } else {
            $this->messageManager->addError(__("Something went wrong"));
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Save News Data
     *
     * @param array $data
     */
    public function setNewsData($data)
    {
        $model = $this->_news->create();
        if (array_key_exists("id", $data)) {
            $model->addData($data)->setId($data['id'])->save();
        } else {
            $model->setData($data)->save();
        }
    }
}
