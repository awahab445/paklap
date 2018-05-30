<?php
namespace Magecomp\Recaptcha\Model;
class Recaptcha extends \Magento\Framework\Model\AbstractModel
{
	public function _construct()
	{
      $this->_init('Magecomp\Recaptcha\Model\ResourceModel\Recaptcha');
   }
}