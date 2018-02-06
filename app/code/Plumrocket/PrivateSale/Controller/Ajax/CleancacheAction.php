<?php
/**
 * Plumrocket Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket Private Sales and Flash Sales v4.x.x
 * @copyright   Copyright (c) 2016 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

namespace Plumrocket\PrivateSale\Controller\Ajax;

use Magento\Framework\Controller\ResultFactory;

/**
 * Cleancache action
 */
class CleancacheAction extends \Magento\Framework\App\Action\Action
{
    /**
     * Cache Type List
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $cacheType;

    /**
     * Cleancache constructor.
     *
     * @param \Magento\Framework\App\Action\Context    $context
     * @param \Magento\PageCache\Model\Cache\Type      $cacheType
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\PageCache\Model\Cache\Type $cacheType
    ) {
        $this->cacheType = $cacheType;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            if ($categoryId = $request->getParam('categoryId')) {
                $tags = [
                    'catalog_category_view_id_' . $categoryId,
                    'catalog_category_' . $categoryId,
                    'cat_c_' . $categoryId
                ];

                $this->cacheType->clean(\Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG, $tags);

                $response = ['success' => true];
            } else {
                $response = ['success' =>  false, 'message' => 'Category id is empty'];
            }
            return $resultJson->setData($response);
        }
    }
}
