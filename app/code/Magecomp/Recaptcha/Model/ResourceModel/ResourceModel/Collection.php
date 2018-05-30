<?php
namespace Magecomp\Recaptcha\Model\ResourceModel\Recaptcha;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magecomp\Recaptcha\Model\Recaptcha', 'Magecomp\Recaptcha\Model\ResourceModel\Recaptcha');
    }
}
