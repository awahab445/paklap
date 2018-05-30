<?php
namespace Magecomp\Recaptcha\Block;
class Recaptcha extends \Magento\Framework\View\Element\Template
{
	protected $_objectManager;
    protected $_recaptchalib;
    protected $messageManager;
	protected $_store;
	public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager,\Magecomp\Recaptcha\Model\Recaptchalib $recaptchalib,\Magento\Backend\Block\Template\Context $context,\Magento\Framework\Message\ManagerInterface $messageManager
	){
		$this->_objectManager = $objectManager;
		$this->_recaptchalib = $recaptchalib;
		$this->messageManager = $messageManager;
		parent::__construct($context);
	}
	
	public function contactSuccessMsg()
	{
		$this->messageManager->addSuccess('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.');
	}
	
	public function contactFailMsg()
	{
        $this->messageManager->addError('We can\'t process your request right now. Sorry, that\'s all we know.');
	}
	
	public function contactInvalidCaptchaMsg()
	{
            $this->messageManager->addError('Please Enter Valid Captcha.');
	}
	
	public function insertItem($cname,$cemail,$cmob,$comment)
	{
		$model = $this->_objectManager->create('Magecomp\Recaptcha\Model\Recaptcha');
		$model->setCname($cname);
		$model->setCemail($cemail);
		$model->setCmobno($cmob);
		$model->setCcomment($comment);
		$model->save();
	}
	public function isEnable()
	{
        return $this->_scopeConfig->getValue('recaptcha_Configuration/moduleoption/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
	public function getNewsletter()
	{
	    if($this->isEnable()) {
            return $this->_scopeConfig->getValue('recaptcha_Configuration/moduleoption/newsletter', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }else{
	        return false;
        }
	}
	
	public function getSiteKey()
	{
		return $this->_scopeConfig->getValue('recaptcha_Configuration/moduleoption/sitekey',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
	
	public function getThemeOption()
	{
		return $this->_scopeConfig->getValue('recaptcha_Configuration/moduleoption/theme',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
}