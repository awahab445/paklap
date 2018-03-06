<?php 
namespace Arpatech\CityDropdown\Controller\Adminhtml\Citydropdown;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;
	
	/**
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	){
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}
	
	public function execute()
	{
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu("Arpatech_CityDropdown::citydropdown");
		$resultPage->addBreadcrumb(__("City Dropdown"), __("City Dropdown"));
		$resultPage->addBreadcrumb(__("Manage City Dropdown"), __("Manage City Dropdown"));
		$resultPage->getConfig()->getTitle()->prepend(__("City Dropdown"));
		
		$dataPersistor = $this->_objectManager->get("Magento\Framework\App\Request\DataPersistorInterface");
		$dataPersistor->clear("citydropdown");
		
		return $resultPage;
	}
} 
?>