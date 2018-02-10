<?php
/**
 * A Magento 2 module named JazzCash/JazzCashPayment
 * Copyright (C) 2017  JazzCash
 * 
 * This file is part of JazzCash/JazzCashPayment.
 * 
 * JazzCash/JazzCashPayment is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace JazzCash\JazzCashPayment\Block\Index;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_coreRegistry = null;
    
    
    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Registry $registry)
    {
        $this->_coreRegistry = $registry;
        
        parent::__construct($context);
    }
    
    
    public function get_ActionUrl()
    {
        return $this->_coreRegistry->registry('pp_ActionUrl');
    }
    
    public function get_Version()
    {
        return $this->_coreRegistry->registry('pp_Version');
    }
    
    public function get_Language()
    {
        return $this->_coreRegistry->registry('pp_Language');
        ;
    }
    
    public function get_MerchantID()
    {
        return $this->_coreRegistry->registry('pp_MerchantID');
    }
    
    public function get_SubMerchantID()
    {
        return $this->_coreRegistry->registry('pp_SubMerchantID');
    }
    
    public function get_Password()
    {
        return $this->_coreRegistry->registry('pp_Password');
    }
    
    public function get_TxnRefNo()
    {
        return $this->_coreRegistry->registry('pp_TxnRefNo');
    }
    
    public function get_Amount()
    {
        return $this->_coreRegistry->registry('pp_Amount');
    }
    
    public function get_TxnCurrency()
    {
        return $this->_coreRegistry->registry('pp_TxnCurrency');
    }
    
    public function get_TxnDateTime()
    {
        return $this->_coreRegistry->registry('pp_TxnDateTime');
    }
    
    public function get_BillReference()
    {
        return $this->_coreRegistry->registry('pp_BillReference');
    }
    
    public function get_Description()
    {
        return $this->_coreRegistry->registry('pp_Description');
    }
    
    public function get_TxnExpiryDateTime()
    {
        return $this->_coreRegistry->registry('pp_TxnExpiryDateTime');
    }
    
    public function get_ReturnURL()
    {
        return $this->_coreRegistry->registry('pp_ReturnURL');
    }
    
    public function get_TxnType()
    {
        return $this->_coreRegistry->registry('pp_TxnType');
    }
    
    public function get_BankID()
    {
        return $this->_coreRegistry->registry('pp_BankID');
    }
    
    public function get_ProductID()
    {
        return $this->_coreRegistry->registry('pp_ProductID');
    }
    
    public function get_SecureHash()
    {
        return $this->_coreRegistry->registry('pp_SecureHash');
    }
    
    public function get_ppmpf1()
    {
        return $this->_coreRegistry->registry('ppmpf1');
    }
    
    public function get_ppmpf2()
    {
        return $this->_coreRegistry->registry('ppmpf2');
    }
    
    public function get_ppmpf3()
    {
        return $this->_coreRegistry->registry('ppmpf3');
    }
    
    public function get_ppmpf4()
    {
        return $this->_coreRegistry->registry('ppmpf4');
    }
    
    public function get_ppmpf5()
    {
        return $this->_coreRegistry->registry('ppmpf5');
    }
}
