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

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Arpatech\NewsTicker\Model\GalleryFactory
     */
    protected $_group;

    /**
     * @param Action\Context $context
     * @param \Arpatech\NewsTicker\Model\groupFactory $group
     */
    public function __construct(Action\Context $context, \Arpatech\NewsTicker\Model\GroupFactory $group)
    {
        $this->_group = $group;
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
     * Save action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $flag = false;
        $reserveId = 0;
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $model = $this->_group->create();
        $collection = $model->getCollection();
        $collection->addFieldToFilter('code', $data['code']);
        $id = $this->getRequest()->getParam('group_id');
        unset($data['id']);
        if ($data['news_ids']=='') {
            unset($data['news_ids']);
        }
        foreach ($collection as $item) {
            if ($item->getId()) {
                $flag = true;
                $reserveId = $item->getId();
                break;
            }
        }
        if (!empty($data)) {
            $error = 'Gallery code already exist';
            if ($id) {
                if ($id != $reserveId) {
                    if ($flag) {
                        $this->messageManager
                            ->addError(__($error));
                        $params = ['id' => $id, '_current' => true];
                        return $resultRedirect->setPath('*/*/edit', $params);
                    }
                }
                $model->addData($data)->setId($id)->save();
            } else {
                if ($flag) {
                    $this->messageManager->addError(__($error));
                    return $resultRedirect->setPath('*/*/');
                }
                $model->setData($data)->save();
            }
        }
        $this->messageManager->addSuccess(__('Group saved successfully'));
        return $resultRedirect->setPath('*/*/');
    }
}
