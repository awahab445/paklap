<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Arpatech\CityDropdown\Observer;

use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class PaymentMethodAvailable implements ObserverInterface
{

    protected $_logger;
    protected $scopeConfig;

    /**
     * Global configuration storage.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $globalConfig;

    protected $_storeManager;
    protected $_objectManager;
    protected $messageManager;
    protected $_responseFactory;
    protected $_url;
    protected $redirectFactory;
    /**
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface; $inlineTranslation
     * @param \Psr\Log\LoggerInterface $_logger
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param  \Magento\Store\Model\StoreManagerInterface $storeManager
     * @para  \Magento\Catalog\Model\ProductRepository $productRepositorym
     * @param \Magento\Framework\ObjectManagerInterface $_objectManager
     */
    public function __construct(
        LoggerInterface $_logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\ObjectManagerInterface $_objectManager,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Checkout\Model\Cart $cart
    ) {
        $this->_logger = $_logger;
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_objectManager = $_objectManager;
        $this->productRepository =    $productRepository;
        $this->_cart = $cart;
    }

    /**
     * @param EventObserver $observer
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(EventObserver $observer)
    {

        $cart = $this->_cart;
        // get cart items
        $items = $cart->getItems();
        // get custom options value of cart items

        $is_product_on_cod = false;
        foreach($items as $quote_item){

            $_prodcut_info = $this->productRepository->get($quote_item->getSku());

            if( $_prodcut_info->getAttributeText('is_on_cod') == 'Yes'){
                $is_product_on_cod = true;
                break;
            }
        }

        if($observer->getEvent()->getMethodInstance()->getCode()=="cashondelivery" && !$is_product_on_cod){
            $checkResult = $observer->getEvent()->getResult();
            //echo $observer->getEvent()->getOrder()->getId();exit;
            $checkResult->setData('is_available', false); //this is disabling the payment method at checkout page
        }

    }
}
