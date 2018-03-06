<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Arpatech\CityDropdown\Controller\Adminhtml\Citydropdown;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $_resourceConfig;

    const DS = DIRECTORY_SEPARATOR;
    /**
     * @param Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        DirectoryList $directory_list,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($context);
        $this->directory_list = $directory_list;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed("Arpatech_CityDropdown::save");
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $pagedata = $this->getRequest()->getPostValue();

        if ($pagedata) {
            /** @var \Arpatech\CityDropdown\Model\CityDropdown $model */
            $model = $this->_objectManager->create("Arpatech\CityDropdown\Model\CityDropdown");
            $id = $this->getRequest()->getParam("id");

            if ($id) {
                $model->load($id);
            }

            if (empty($pagedata['id'])) {
                $pagedata ['id'] = null;
            }


             $model->setData($pagedata );

            try{
                $model->save();
                $this->messageManager->addSuccess(__("Item was successfully saved."));
                $this->_objectManager->get("Magento\Backend\Model\Session")->setFormData(false);
                return $resultRedirect->setPath("*/citydropdown/edit", ["id" => $model->getId(), "_current" => true]);

            }
            catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __("Something went wrong while saving the media content."));
            }


            return $resultRedirect->setPath("*/citydropdown/edit", ["id" => $this->getRequest()->getParam("id")]);
        }
        return $resultRedirect->setPath("*/*/");
    }



}
