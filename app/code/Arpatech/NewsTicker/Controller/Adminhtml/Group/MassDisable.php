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

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Arpatech\NewsTicker\Model\ResourceModel\Group\CollectionFactory;

class MassDisable extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
    * {@inheritdoc}
    */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Arpatech_NewsTicker::group');
    }

    /**
    * @return \Magento\Framework\Controller\ResultInterface
    */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        foreach ($collection as $group) {
            $group->setStatus(0);
            $group->save();
        }
        $this->messageManager->addSuccess(__('Group(S) disabled succesfully'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
