<?php

/**
 * Arpatech
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Arpatech.com license that is
 * available through the world-wide-web at this URL:
 * http://www.Arpatech.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Arpatech
 * @package     Arpatech_Webapi
 * @copyright   Copyright (c) 2012 Arpatech (http://www.Arpatech.com/)
 * @license     http://www.Arpatech.com/license-agreement.html
 */

namespace Arpatech\CityDropdown\Controller\Adminhtml\CityDropdown;

use Magento\Framework\Controller\ResultFactory;
/**
 * Edit grid container.
 * @category Arpatech
 * @package  Arpatech_CityDropdown
 * @module   Webapi
 * @author   Arpatech Developer
 */
class Edit extends \Magento\Backend\App\Action
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ){
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("ArpatechWeb_CityDropdown::item")
            ->addBreadcrumb(__("Cities"), __("Cities"))
            ->addBreadcrumb(__("Manage Cities"), __("Manage Cities"));
        return $resultPage;

    }
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */

    public function execute()
    {
        $id = $this->getRequest()->getParam("id");
        $model = $this->_objectManager->create("Arpatech\CityDropdown\Model\CityDropdown");
        if ($id)
        {
            $model->load($id);
            if (!$model->getId())
            {
                $this->messageManager->addError(__("This item  no longer exists."));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath("*/*/");
            }
        }
        $data = $this->_objectManager->get("Magento\Backend\Model\Session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __("Edit City") : __("New City"),
            $id ? __("Edit City") : __("New City")
        );
        $resultPage->getConfig()->getTitle()->prepend(__("City"));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __("New City"));
        return $resultPage;
    }

}
