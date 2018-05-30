<?php
namespace Magecomp\Recaptcha\Plugin;
use Magento\Framework\Controller\ResultFactory;

class ReviewPlugin
{
    protected $request;
    protected $redirect;
    protected $resultFactory;
    protected $messageManager;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        ResultFactory $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager

    ) {
        $this->request = $request;
        $this->redirect = $redirect;
        $this->resultFactory=$resultFactory;
        $this->messageManager = $messageManager;
    }

    public function aroundExecute(\Magento\Review\Controller\Product\Post $subject, \Closure $proceed)
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->redirect->getRefererUrl());
        $helper = \Magento\Framework\App\ObjectManager::getInstance()->get('Magecomp\Recaptcha\Helper\Data');
        try {
            $data = $this->request->getParams();
            if ($helper->IS_PRODREVIEW()) {
                if ($helper->getCaptchaverify($data) === true) {
                    return $proceed();
                } else {
                    $this->messageManager->addErrorMessage('Invalid Recaptcha');
                    return $resultRedirect;
                }
            }
            else
            {
                return $proceed();
            }
        }
        catch (\Exception $e)
        {
            $this->messageManager->addErrorMessage('Invalid Recaptcha');
            return $resultRedirect;
        }
    }


}
