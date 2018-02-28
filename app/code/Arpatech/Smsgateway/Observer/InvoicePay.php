<?php
/**
 * SMS Module module >> this file call when invoice is created for particuler order 
 * Company Arpatech 
 * Developer Abdul Wahab
 */
namespace Arpatech\Smsgateway\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer       as Observer;
use \Magento\Framework\View\Element\Context as Context;
use \Arpatech\Smsgateway\Helper\Data                 as Helper;
/**
 * Customer login observer
 */
class InvoicePay implements ObserverInterface
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

    /**
     * Username
     * @var $username
     */
    protected $username;
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

    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper _helper
     */
    public function __construct(
        Context $context,
        Helper $helper
    ) {
        $this->_helper  = $helper;
        $this->_request = $context->getRequest();
        $this->_layout  = $context->getLayout();
    }

    /**
     * The execute class
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /**
         * Getting Module Configuration from admin panel
         */

        //Getting Username
        $this->username = $this->_helper->getTextuallyApiUsername();

        //Getting Message
        $this->message  = $this->_helper->getCustomerMessageOnInvoiced();

        //Getting Url 
        $this->url = $this->_helper->getTextuallyApiUrl();

        //Getting Customer Notification value
        $this->enabled  = $this->_helper->isCustomerNotificationsEnabledOnInvoiced();

        //Checking if sms is enable or not
        if ($this->enabled == 1) {

                //Getting Order Details
                $invoice   = $observer->getInvoice();
                $order     = $invoice->getOrder($invoice);
                $orderData = [
                    'orderId'       => $order->getIncrementId(),
                    'firstname'     => $order->getCustomerFirstname()
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

                //Sending SMS to Admin
                if ($this->_helper->isAdminNotificationsEnabled() == 1) {
                    $this->destination = $this->_helper->getAdminSenderId();
                    $this->message = $this->_helper->getAdminMessageForInvoiced();
                    $this->message = $this->_helper->manipulateSMS($this->message, $orderData);
                    $this->_helper->sendSms(
                        $this->destination,
                        $this->message
                    );
                }
        }


    }
}