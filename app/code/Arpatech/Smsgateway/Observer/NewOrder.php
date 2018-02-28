<?php
/**
 * SMS Module module >> this file call when new order is placed
 * Company Arpatech 
 * Developer Abdul Wahab
 */
namespace Arpatech\Smsgateway\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer       as Observer;
use \Magento\Framework\View\Element\Context as Context;
use \Arpatech\Smsgateway\Helper\Data                 as Helper;
use PHPUnit\Framework\Exception;

/**
 * Customer login observer
 */
class NewOrder implements ObserverInterface
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

    protected $_logger;

    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper _helper
     */
    public function __construct(
        Context $context,
        Helper $helper,
        \Psr\Log\LoggerInterface $logger

    ) {
        $this->_helper  = $helper;
        $this->_request = $context->getRequest();
        $this->_layout  = $context->getLayout();
        $this->_logger = $logger;
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


        //Getting Message
        $this->message          = $this->_helper->getCustomerMessageOnOrder();

             //Getting Url 
        $this->url = $this->_helper->getTextuallyApiUrl();

        //Getting Customer Notification value
        $this->enabled          = $this->_helper->isCustomerNotificationsEnabledOnOrder();

        if ($this->enabled == 1) {

            try {
                //Getting Order Details


                $order = $order = $observer->getEvent()->getOrder();
                $orderData = [
                    'order_id' => $order->getIncrementId(),
                    'last_name' => $order->getBillingAddress()->getLastname()
                ];

                //Getting Telephone Number
                $this->destination = $order->getBillingAddress()->getTelephone();
                //Manipulating SMS
                $this->message = $this->_helper->manipulateSMS($this->message, $orderData);

                $session_Id = $this->_helper->getSessionId();

                /* Replace 0 With 92 for pakista number*/

                $destination_number  = (substr($this->destination,0,2) == '92') ?  $this->destination : '92'.ltrim($this->destination, '0');
                //Sending SMS
                $return_url = $this->_helper->sendSms(
                    $session_Id,
                    $destination_number,
                    $this->message
                );
                //$session_Id

                $this->_logger->addInfo('Order Message Successfully Sent on number = '.$destination_number);

                //Sending SMS to Admin
                if ($this->_helper->isAdminNotificationsEnabled() == 1) {
                    $this->destination = $this->_helper->getAdminSenderId();
                    $this->message = $this->_helper->getAdminMessageForNewOrder();
                    $this->message = $this->_helper->manipulateSMS($this->message, $orderData);
                    $this->_helper->sendSms(
                        $this->destination,
                        $this->message
                    );
                }
            }catch(Exception $e){

                $this->_logger->addInfo('SMS API Exception = ' . $e->getMessage());

            }
        }


    }
}