<?php 
namespace Arpatech\Citydropdown\Controller\Adminhtml\Citydropdown;

class Delete extends \Magento\Backend\App\Action {
	
	/**
	 * {@inheritdoc}
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed("Arpatech_CityDropdown::item_delete");
	}
	
	/**
	 * Delete action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam("id");
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();
		if ($id) {
			try {
				$model = $this->_objectManager->create("Arpatech\CityDropdown\Model\CityDropdown");
				$model->load($id);
				$model->delete();
				$this->messageManager->addSuccess(__("The Item has been deleted."));
				return $resultRedirect->setPath("*/*/");
			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
				return $resultRedirect->setPath("*/*/edit", ["id" => $id]);
			}
		}
		$this->messageManager->addError(__("We can't find the item to delete."));
		return $resultRedirect->setPath("*/*/");
	}
}
?>