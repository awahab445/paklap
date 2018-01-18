<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\FilterProduct\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;


/**
 * Class Widget
 */
class Index extends \Magento\Framework\App\Action\Action
{
	protected $serialize;

	public function __construct(Context $context,JsonSerializer $serialize)
	{
		$this->serialize = $serialize;
		parent::__construct($context);
	}

	public function execute()
	{     	
		$this->_view->loadLayout();
		$params = $this->serialize->unserialize(base64_decode($this->getRequest()->getParam('params')));
		$_ajaxFilterProduct = $this->_view->getLayout()->createBlock('Emthemes\FilterProduct\Block\Product\AjaxProductsList')->setData($params);		
		$this->getResponse()->setBody($_ajaxFilterProduct->toHtml());
	}
}
