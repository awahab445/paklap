<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\Ajaxblock\Controller\Index;

use Magento\Framework\App\Action\Context;


/**
 * Class Widget
 */
class Index extends \Magento\Framework\App\Action\Action
{
	public function execute()
	{     			
		$this->_view->loadLayout();

		$data = $this->getRequest()->getParam('data');
		$data = base64_decode($data);
		$data = json_decode($data);
		$result = array();
		if($data){
			foreach($data as $key => $value)
			{
			    $result[$key] = $value;
			}
			$block = $this->_view->getLayout()->createBlock($result['type']);
			$block->setData('current_url',$data->current_url);
			if(!$this->_view->getLayout()->getBlock('formkey')){
				$this->_view->getLayout()->createBlock('Magento\Framework\View\Element\FormKey','formkey');
			}
			//echo "<pre>";echo $block->toHtml();die;	
			$block->setData($result);	
			$block->setData('uniqueId',uniqid());
			$this->getResponse()->setBody($block->toHtml());
		}
	}
}
