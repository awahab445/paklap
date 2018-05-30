<?php

namespace Magecomp\Recaptcha\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CAPTCHA_ENABLE = 'recaptcha_Configuration/moduleoption/enable';
    const SECRET_KEY = 'recaptcha_Configuration/moduleoption/secretkey';
    const CUST_REG = 'recaptcha_Configuration/moduleoption/custreg';
    const REC_NEWSLETTER = 'recaptcha_Configuration/moduleoption/newsletter';
    const PROD_REVIEW = 'recaptcha_Configuration/moduleoption/prodreview';
    const FORGOTPASSWORD = 'recaptcha_Configuration/moduleoption/forgotpassword';
    const CHECKOUTREGISTER = 'recaptcha_Configuration/moduleoption/checkoutregister';
    const CONTACTUS = 'recaptcha_Configuration/moduleoption/contactus';


    protected $_modelStoreManagerInterface;
    protected $_frameworkRegistry;
    protected $filesystem;

    public function __construct(Context $context,
                                StoreManagerInterface $modelStoreManagerInterface
    )
    {
        $this->_modelStoreManagerInterface = $modelStoreManagerInterface;

        parent::__construct($context);
    }
    public function getSecretkey()
    {
        return $this->scopeConfig->getValue(self::SECRET_KEY, ScopeInterface::SCOPE_STORE);
    }
    public function IS_NEWSLETTER()
    {
        if ($this->IS_ENABLE()) {
            return (bool)$this->scopeConfig->getValue(self::REC_NEWSLETTER, ScopeInterface::SCOPE_STORE);
        } else {
            return false;
        }
    }

    public function IS_ENABLE()
    {
        return (bool)$this->scopeConfig->getValue(self::CAPTCHA_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    public function IS_CUSTREG()
    {
        if ($this->IS_ENABLE()) {
            return (bool)$this->scopeConfig->getValue(self::CUST_REG, ScopeInterface::SCOPE_STORE);
        } else {
            return false;
        }
    }

    public function IS_PRODREVIEW()
    {
        if ($this->IS_ENABLE()) {
            return (bool)$this->scopeConfig->getValue(self::PROD_REVIEW, ScopeInterface::SCOPE_STORE);
        } else {
            return false;
        }

    }

    public function IS_CHECKOUTREGISTER()
    {
        if ($this->IS_ENABLE()) {
            return (bool)$this->scopeConfig->getValue(self::CHECKOUTREGISTER, ScopeInterface::SCOPE_STORE);
        } else {
            return false;
        }
    }

    public function IS_CONTACTUS()
    {
        if ($this->IS_ENABLE()) {
            return (bool)$this->scopeConfig->getValue(self::CONTACTUS, ScopeInterface::SCOPE_STORE);
        } else {
            return false;
        }

    }

    public function IS_FORGOTPASSWORD()
    {
        if ($this->IS_ENABLE()) {
            return (bool)$this->scopeConfig->getValue(self::FORGOTPASSWORD, ScopeInterface::SCOPE_STORE);
        } else {
            return false;
        }
    }

    public function getCaptchaverify($data)
    {
        if ($data['g-recaptcha-response'] != "") {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $this->getSecretkey() . "&response=" . $data['g-recaptcha-response'] . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
            $googleobj = json_decode($response);
            $verified = $googleobj->success;
            return $verified;
        } else {
            return false;
        }
    }
}

