<?php
/**
 * SMS Module helper file  
 * Company Arpatech 
 * Developer Abdul Wahab
 * Conatins all config getter functions
 */
namespace Arpatech\Smsgateway\Helper;

use \Magento\Framework\App\ObjectManager as ObjectManager;
use \Magento\Framework\Event\Observer as Observer;
use \Magento\Store\Model\ScopeInterface as ScopeInterface;
use \Magento\Framework\App\Helper\AbstractHelper as AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * To be used by the API
     * @var string
     */
    protected $_host             = '';
    //protected $_host             = 'http://pkapi.eocean.us:24555/';

    /**
     * Getting Basic Configuration
     * These functions are used to get the api username and password
     */

    public function getTextuallyApiUsername()
    {
        return $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_username');
    }

    public function getTextuallyApiUrl()
    {
        return $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_url');
    }

    /**
     * Checking Admin SMS is enabled or not
     * @return string
     */
    public function isAdminNotificationsEnabled()
    {
        return $this->getConfig('arpatech_smsgateway_admins/admin_configuration/smsgateway_admin_enabled');
    }

    /**
     * Getting Admin Mobile Number
     * @return string
     */
    public function getAdminSenderId()
    {
        return $this->getConfig('arpatech_smsgateway_admins/admin_configuration/smsgateway_admin_mobile');
    }

    /**
     * Getting admin message for new order
     * @return string
     */
    public function getAdminMessageForNewOrder()
    {
        return $this->getConfig('arpatech_smsgateway_admins/admin_configuration/smsgateway_new_order_admin_message');
    }

    /**
     * Getting Admin message for order cancelled
     * @return string
     */
    public function getAdminMessageForOrderCancelled()
    {
        return $this->getConfig('arpatech_smsgateway_admins/admin_configuration/smsgateway_cancelled_admin_message');
    }

    /**
     * Getting Admin message for Invoiced
     * @return string
     */
    public function getAdminMessageForInvoiced()
    {
        return $this->getConfig('arpatech_smsgateway_admins/admin_configuration/smsgateway_invoiced_admin_message');
    }


    /**
     * Getting Admin message for Sign up
     * @return string
     */
    public function getAdminMessageForRegister()
    {
        return $this->getConfig('arpatech_smsgateway_admins/admin_configuration/smsgateway_register_admin_message');
    }


    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when new order is placed
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnOrder()
    {
        return $this->getConfig('arpatech_smsgateway_orders/new_order/smsgateway_new_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnOrder()
    {
        return $this->getConfig('arpatech_smsgateway_orders/new_order/smsgateway_new_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is Cancelled
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnCancelled()
    {
        return $this->getConfig('arpatech_smsgateway_orders/cancelled_order/smsgateway_cancelled_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnCancelled()
    {
        return $this->getConfig('arpatech_smsgateway_orders/cancelled_order/smsgateway_cancelled_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when invoice is created
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnInvoiced()
    {
        return $this->getConfig('arpatech_smsgateway_orders/invoiced_order/smsgateway_invoiced_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnInvoiced()
    {
        return $this->getConfig('arpatech_smsgateway_orders/invoiced_order/smsgateway_invoiced_order_message');
    }


    public function isCustomerNotificationsEnabledOnShipment()
    {
        return $this->getConfig('arpatech_smsgateway_orders/shipment_order/smsgateway_shipment_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnShipment()
    {
        return $this->getConfig('arpatech_smsgateway_orders/shipment_order/smsgateway_shipment_order_message');
    }


    public function isCustomerNotificationsEnabledOnConfirmed()
    {
        return $this->getConfig('arpatech_smsgateway_orders/confirmed_order/smsgateway_confirmed_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnConfirmed()
    {
        return $this->getConfig('arpatech_smsgateway_orders/confirmed_order/smsgateway_confirmed_order_message');
    }


    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Sending SMS
     * @param @var $username
     * @param @var $password
     * @param @var $senderID
     * @param @var $destination
     * @param @var $message
     * @return void
     */

    public function curl($url)
    {
        return file_get_contents($url);
    }


    /**
     * Get Session Id
     */
    public function getSessionId()
    {
        $_host = $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_hostname');
        $_username = $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_username');
        $_password = $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_password');
        //$path       = 'https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=923403331323&password=fahad12345';
        //api?action=sendmessage&username=j._api&password=P225588&recipient=923403331689&originator=J.&messagedata=Test
        $path       = 'auth.jsp?msisdn='.urlencode($_username).'&password='.urlencode($_password);
        $url        = $_host.$path;

        $curl_repsonse = $this->curl($url);

        $response = simplexml_load_string($curl_repsonse);
        if($response->response == 'OK'){
            return $response->data;
        }
        return false;

    }
    /**
     * Send sms
     */
    public function sendSms($session_id,$destination, $message)
    {
        $_host = $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_hostname');
        $_sender = $this->getConfig('arpatech_smsgateway_configuration/basic_configuration/textually_sender');
//        'https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id=xxxx&to=923xxxxxxxxx,923xx
//xxxxxxx,923xxxxxxxxx&text=xxxx&mask=xxxx'
        //$path       = 'api.php?key='.$_api_key.'&sender='.urlencode($_sender);
        $path = 'sendsms.jsp?session_id='.urlencode($session_id);
        $data       = '&to='.urlencode($destination).'&text='.urlencode($message).'&mask='.urlencode($_sender);
        $url        = $_host.$path.$data;
        $this->curl($url);
    }

    /**
     * Get {params} from admin config and chnage with data
     */
    public function manipulateSMS($message, $data)
    {
        $keywords   = [
        '{order_id}',
        '{lastname}',
        '{tracking_number}'
        ];
        $message         = str_replace($keywords, $data, $message);
        return $message;
    }

    /**
     * Getting Products
     * @param Observer $observer
     * @return string
     */
    public function getProduct(Observer $observer)
    {
        $productId          = $observer->getProduct()->getId();
        $objectManager      = ObjectManager::getInstance();
        $product            = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
        return $product;
    }

    /**
     * Getting Order Details
     * @param Observer $observer
     * @return string
     */
    public function getOrder(Observer $observer)
    {
        $order              = $observer->getOrder();
        $orderId            = $order->getIncrementId();
        $objectManager      = ObjectManager::getInstance();
        $order              = $objectManager->get('Magento\Sales\Model\Order');
        $orderInformation   = $order->loadByIncrementId($orderId);
        return $orderInformation;
    }
}
