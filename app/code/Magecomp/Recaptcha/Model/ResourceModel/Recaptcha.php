<?php
namespace Magecomp\Recaptcha\Model\ResourceModel;
class Recaptcha extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
	{
		$this->_init('recaptcha', 'contact_id');
    }
}