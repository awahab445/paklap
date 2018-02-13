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

namespace JazzCash\JazzCashPayment\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    
    protected $resultPageFactory;
    private $_orderFactory;
    protected $_checkoutSession;
    protected $scopeConfig;
    protected $_coreRegistry = null;
	
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context, 
    \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
    \Magento\Sales\Model\Order $salesOrderFactory, 
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
    \Magento\Checkout\Model\Session $checkoutSession, 
    \Magento\Framework\Registry $coreRegistry)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_checkoutSession  = $checkoutSession;
        $this->_orderFactory     = $salesOrderFactory;
        $this->scopeConfig       = $scopeConfig;
        $this->_coreRegistry     = $coreRegistry;
        
        parent::__construct($context);
    }
    
    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $orderId    = $this->_checkoutSession->getLastOrderId();
        $order      = $this->_orderFactory->load($orderId);
        $orderItems = $order->getdata();
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        
        $_ActionURL     = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/actionurl', $storeScope);
        $_MerchantID    = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/merchantid', $storeScope);
        $_Password      = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/password', $storeScope);
        $_ReturnURL     = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/returnurl', $storeScope);
        $_IntegritySalt = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/integritysalt', $storeScope);
        $_ExpiryHours   = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/expiryhours', $storeScope);
        
        foreach ($order->getAllItems() as $item) {
            $ProdustIds[] = $item->getProductId();
            $proName[]    = $item->getName(); // product name
        }
        
        
        $_Language      = 'EN';
        $_Version       = '1.1';
        $_Currency      = 'PKR'; //$orderItems['base_currency_code'];
        $_Description   = implode(",", $proName);
        $_BillReference = $orderItems['increment_id'];
        
        $Amount           = $orderItems['grand_total'];
        $AmountTmp        = $Amount * 100;
        $AmtSplitArray    = explode('.', $AmountTmp);
        $_FormattedAmount = $AmtSplitArray[0];
        
        date_default_timezone_set("Asia/karachi");
        $DateTime       = (new \DateTime());
        $_TxnRefNumber  = "T" . $DateTime->format('YmdHis');
        $_TxnDateTime   = $DateTime->format('YmdHis');
        $ExpiryDateTime = $DateTime;
        $ExpiryDateTime->modify("+" . $_ExpiryHours . ' hours');
        $_ExpiryDateTime = $ExpiryDateTime->format('YmdHis');
        
        $ppmpf1 = '1';
        $ppmpf2 = '2';
        $ppmpf3 = '3';
        $ppmpf4 = '4';
        $ppmpf5 = '5';
        
        // Populating Sorted Array
        $SortedArrayOld = $_IntegritySalt . '&' . $_FormattedAmount . '&' . $_BillReference . '&' . $_Description . '&' . $_Language . '&' . $_MerchantID . '&' . $_Password;
        $SortedArrayOld = $SortedArrayOld . '&' . $_ReturnURL . '&' . $_Currency . '&' . $_TxnDateTime . '&' . $_ExpiryDateTime . '&' . $_TxnRefNumber . '&' . $_Version;
        $SortedArrayOld = $SortedArrayOld . '&' . $ppmpf1 . '&' . $ppmpf2 . '&' . $ppmpf3 . '&' . $ppmpf4 . '&' . $ppmpf5;
        
        //Calculating Hash
        $_Securehash = hash_hmac('sha256', $SortedArrayOld, $_IntegritySalt);
        
        
        $RequestLog = "JazzCashPayment.Controller.Index.Index -> JazzCash request: ";
        $RequestData = array();
        $RequestData['pp_Version'] = $_Version;
        $RequestData['pp_TxnType'] = "";
        $RequestData['pp_Language'] = $_Language;
        $RequestData['pp_MerchantID'] = $_MerchantID;
        $RequestData['pp_SubMerchantID'] = "";
        $RequestData['pp_Password'] = $_Password;
        $RequestData['pp_BankID'] = "";
        $RequestData['pp_ProductID']  = "";
        $RequestData['pp_TxnRefNo'] = $_TxnRefNumber;
        $RequestData['pp_Amount'] = $_FormattedAmount;
        $RequestData['pp_TxnCurrency'] = $_Currency;
        $RequestData['pp_TxnDateTime'] = $_TxnDateTime;
        $RequestData['pp_BillReference'] = $_BillReference;
        $RequestData['pp_Description'] = $_Description;
        $RequestData['pp_TxnExpiryDateTime'] = $_ExpiryDateTime;
        $RequestData['pp_ReturnURL'] = $_ReturnURL;
        $RequestData['pp_SecureHash'] = $_Securehash;
        $RequestData['ppmpf1'] = $ppmpf1;
        $RequestData['ppmpf2'] = $ppmpf2;
        $RequestData['ppmpf3'] = $ppmpf3;
        $RequestData['ppmpf4'] = $ppmpf4;
        $RequestData['ppmpf5'] = $ppmpf5;

        foreach ($RequestData as $key => $val) {
            $RequestLog .= $key . "[" . $val . "], ";
        }

        $this->_objectManager->get('Psr\Log\LoggerInterface')->addDebug($RequestLog);
        
        // Setting value in registry for passing to Block class    
        $this->_coreRegistry->register('pp_ActionUrl', $_ActionURL);
        $this->_coreRegistry->register('pp_Version', $_Version);
        $this->_coreRegistry->register('pp_Language', $_Language);
        $this->_coreRegistry->register('pp_MerchantID', $_MerchantID);
        $this->_coreRegistry->register('pp_SubMerchantID', '');
        $this->_coreRegistry->register('pp_Password', $_Password);
        $this->_coreRegistry->register('pp_TxnRefNo', $_TxnRefNumber);
        $this->_coreRegistry->register('pp_Amount', $_FormattedAmount);
        $this->_coreRegistry->register('pp_TxnCurrency', $_Currency);
        $this->_coreRegistry->register('pp_TxnDateTime', $_TxnDateTime);
        $this->_coreRegistry->register('pp_BillReference', $_BillReference);
        $this->_coreRegistry->register('pp_Description', $_Description);
        $this->_coreRegistry->register('pp_TxnExpiryDateTime', $_ExpiryDateTime);
        $this->_coreRegistry->register('pp_ReturnURL', $_ReturnURL);
        $this->_coreRegistry->register('pp_SecureHash', $_Securehash);
        
        $this->_coreRegistry->register('ppmpf1', $ppmpf1);
        $this->_coreRegistry->register('ppmpf2', $ppmpf2);
        $this->_coreRegistry->register('ppmpf3', $ppmpf3);
        $this->_coreRegistry->register('ppmpf4', $ppmpf4);
        $this->_coreRegistry->register('ppmpf5', $ppmpf5);
        
        $this->_coreRegistry->register('pp_TxnType', '');
        $this->_coreRegistry->register('pp_BankID', '');
        $this->_coreRegistry->register('pp_ProductID', '');
        
        return $this->resultPageFactory->create();
        
    }
}
