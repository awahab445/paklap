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

namespace JazzCash\JazzCashPayment\Controller\Response;

// return URL like www.yourwebsite.com\jazzcash\response\jazzcashresponse.
class JazzCashResponse extends \Magento\Framework\App\Action\Action
{
    protected $_orderFactory;
    protected $_checkoutSession;
    protected $scopeConfig;
    protected $_order;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context, 
    \Magento\Sales\Model\Order $salesOrderFactory, 
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
    \Magento\Checkout\Model\Session $checkoutSession, 
    \Magento\Sales\Api\Data\OrderInterface $order)
    {
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory    = $salesOrderFactory;
        $this->scopeConfig      = $scopeConfig;
        $this->_order           = $order;
		
        parent::__construct($context);
    }
    
    public function execute()
    {
        $comment             = "";
        $request             = $_POST;
        $errorMsg            = '';
        $successFlag         = false;
        $returnUrl           = 'checkout/onepage/success';
        $sortedResponseArray = array();
        if (!empty($_POST)) {
            foreach ($_POST as $key => $val) {
                $comment .= $key . "[" . $val . "],<br/>";
                $sortedResponseArray[$key] = $val;
            }
        }
        
        $storeScope   = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $isResponseOk = false;
        
        $_MerchantID    = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/merchantid', $storeScope);
        $_Password      = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/password', $storeScope);
        $_IntegritySalt = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/integritysalt', $storeScope);
        $_ValidateHash  = $this->scopeConfig->getValue('payment/jazzcashpaymentmethod/validatehash', $storeScope);
        
        $_ResponseMessage = $this->getEmptyIfNullFromPOST('pp_ResponseMessage');
        $_ResponseCode    = $this->getEmptyIfNullFromPOST('pp_ResponseCode');
        $_TxnRefNo        = $this->getEmptyIfNullFromPOST('pp_TxnRefNo');
        $_BillReference   = $this->getEmptyIfNullFromPOST('pp_BillReference');
        $_SecureHash      = $this->getEmptyIfNullFromPOST('pp_SecureHash');
        
        if ($_ValidateHash) {
            
            if (!$this->isNullOrEmptyString($_SecureHash)) {
                //removing pp_SecureHash key
                unset($sortedResponseArray['pp_SecureHash']);
                //sorting array w.r.t key
                ksort($sortedResponseArray);
				$sortedResponseValuesArray = array();
                //Populating Sorted Array
				array_push($sortedResponseValuesArray, $_IntegritySalt);
                
                foreach ($sortedResponseArray as $key => $val) {
                    if (!$this->isNullOrEmptyString($val)) {
                        array_push($sortedResponseValuesArray, $val);
                    }
                }
                
                //joining array of sorted response values 
                $sortedResponseValuesForHash = implode('&', $sortedResponseValuesArray);
                //Calculating Hash
                $CalSecureHash               = hash_hmac('sha256', $sortedResponseValuesForHash, $_IntegritySalt);
                
                if (strtolower($CalSecureHash) == strtolower($_SecureHash)) {
                    $isResponseOk = true;
                } else {
                    $isResponseOk = false;
                    $errorMsg     = 'JazzCash: Secure Hash mismatched!';
                    $comment .= "Secure Hash mismatched.";
                }
            } else {
                $isResponseOk = false;
                $errorMsg     = 'JazzCash: Secure Hash is empty!';
                $comment .= "Secure Hash is empty.";
            }
        } else {
            $isResponseOk = true;
        }
		
		$order          = $this->_order->loadByIncrementId($_BillReference);
		
		$orderItems 	= $order->getdata();
		$orderAmount 	= $orderItems['grand_total'];
		$orderAmount    = $orderAmount * 100;
        $AmtSplitArray  = explode('.', $orderAmount);
		$orderAmount 	= $AmtSplitArray[0];
		
		if($isResponseOk) {
			if(strtolower(($_MerchantID) == strtolower($this->getEmptyIfNull($sortedResponseArray['pp_MerchantID']))) &&
			($orderAmount == $this->getEmptyIfNull($sortedResponseArray['pp_Amount']))) {
				$isResponseOk = true;
			}
			else {
				$isResponseOk = false;
				$comment .= "Response integrity violated. Response values are not same as Request.";
			}
		}
        
        //$order                 = $this->_order->loadByIncrementId($_BillReference);
        $payment_success_codes = array(
            "000"
        );
        
        $payment_success_pending = array(
            "124"
        );
        
        if ($isResponseOk) {
            if (in_array($_ResponseCode, $payment_success_codes)) {
                $successFlag = true;
                $order->setStatus('complete');
                $order->setExtOrderId($_TxnRefNo);
                $returnUrl = 'checkout/onepage/success';
                
            } else if (in_array($_ResponseCode, $payment_success_pending)) {
                $successFlag = true;
                $order->setStatus('pending_payment');
                $order->setExtOrderId($_TxnRefNo);
                $returnUrl = 'checkout/onepage/success';
            } else {
                $successFlag = false;
                $order->setStatus('jazzcash_failed');
                $order->setExtOrderId($_TxnRefNo);
                $returnUrl = 'checkout/onepage/failure';
            }
        } else {
            $order->setStatus('fraud');
            $returnUrl = 'checkout/onepage/failure';
        }
        
        $order->addStatusToHistory($order->getStatus(), '' /*$comment*/, false);
        $order->save();
        
        if ($successFlag) {
            $this->messageManager->addSuccess(__($_ResponseMessage));
        } else {
            $this->messageManager->addError(__($errorMsg));
        }
        $this->_redirect($returnUrl);
    }
    
    protected function isNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }
    
    protected function getEmptyIfNullFromPOST($key)
    {
        if (!isset($_POST[$key]) || trim($_POST[$key]) == "") {
            return "";
        } else {
            return $_POST[$key];
        }
    }

    protected function getEmptyIfNull($key)
    {
        if (!isset($key) || trim($key) == "") {
            return "";
        } else {
            return $key;
        }
    }
}
