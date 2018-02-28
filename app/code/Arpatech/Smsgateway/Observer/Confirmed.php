<?php
/**
 * SMS Module module >> this file call when invoice is created for particuler order
 * Company Arpatech
 * Developer Abdul Wahab
 */

namespace Arpatech\Smsgateway\Observer;

use \Magento\Framework\App\ObjectManager as ObjectManager;
use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer as Observer;
use \Magento\Framework\View\Element\Context as Context;
use \Arpatech\Smsgateway\Helper\Data as Helper;
use Psr\Log\LoggerInterface as Logger;
/**
 * Customer login observer
 */
class Confirmed implements ObserverInterface
{
    /**
     * Message manager
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    const AJAX_PARAM_NAME = 'infscroll';
    /**
     *
     */
    const AJAX_HANDLE_NAME = 'infscroll_ajax_request';

    /**
     * Https request
     *
     * @var \Zend\Http\Request
     */
    protected $_request;

    /**
     * Layout Interface
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    /**
     * Cache
     * @var $_cache
     */
    protected $_cache;


    protected $_helper;

    /**
     * Message Manager
     * @var $messageManager
     */
    protected $messageManager;


    protected $url;

    /**
     * Sender ID
     * @var $senderId
     */
    protected $senderId;

    /**
     * Destination
     * @var $destination
     */
    protected $destination;

    /**
     * Message
     * @var $message
     */
    protected $message;

    /**
     * Whether Enabled or not
     * @var $enabled
     */
    protected $enabled;

    protected $logger;
    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper _helper
     */
    public function __construct(
        Context $context,
        Helper $helper,
        Logger $logger
    )
    {
        $this->_helper = $helper;
        $this->_request = $context->getRequest();
        $this->_layout = $context->getLayout();
        $this->logger = $logger;
    }

    /**
     * The execute class
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        //$this->logger->info('start confrim message');

        //Getting Url
        $this->url = $this->_helper->getTextuallyApiUrl();

        //Getting Message
        $this->message = $this->_helper->getCustomerMessageOnConfirmed();

        //Getting Customer Notification value
        $this->enabled = $this->_helper->isCustomerNotificationsEnabledOnConfirmed();


        if ($this->enabled == 1) {

            /* EOC */

            /* Custom Work for getting Order Detail from History Event */
            $order = $observer->getEvent()->getOrder();


            $customerName = ($order->getCustomerFirstname()) ? $order->getCustomerFirstname() : $order->getCustomerEmail();


            $orderData = [
                'orderId' => $order->getIncrementId(),
                'firstname' => $customerName
            ];


            //Getting Telephone Number
           $this->destination = $order->getBillingAddress()->getTelephone();

            //Manipulating SMS
           $this->message = $this->_helper->manipulateSMS($this->message, $orderData);

            //Sending SMS
           $this->_helper->sendSms(
               $this->destination,
               $this->message
           );

            $this->logger->info($this->message);
            //Sending SMS to Admin
           if ($this->_helper->isAdminNotificationsEnabled() == 1) {
               $this->destination = $this->_helper->getAdminSenderId();
               $this->message = $this->_helper->getAdminMessageForOrderCancelled();
               $this->message = $this->_helper->manipulateSMS($this->message, $orderData);
               $this->_helper->sendSms(
                   $this->destination,
                   $this->message
               );
           }
        }
    }
}
