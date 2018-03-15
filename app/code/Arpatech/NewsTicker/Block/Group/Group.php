<?php
/**
 * Arpatech Software.
 *
 * @category  Arpatech
 * @package   Arpatech_NewsTicker
 * @author    Arpatech
 * @copyright Copyright (c) 2010-2016
 * @license
 */
namespace Arpatech\NewsTicker\Block\Group;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;

class Group extends \Magento\Framework\View\Element\Template
{
   /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;
    /**
     * @var \Arpatech\NewsTicker\Model\ResourceModel\Group\CollectionFactory
     */
    protected $_newsCollection;

    /**
     * @var \Arpatech\NewsTicker\Model\ResourceModel\Group\CollectionFactory
     */

    protected $_groupCollection;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Arpatech\NewsTicker\Model\ResourceModel\News\CollectionFactory $newsCollection
     * @param \Arpatech\NewsTicker\Model\ResourceModel\Group\CollectionFactory $groupCollection
     * @param \Magento\Framework\Image\AdapterFactory $imageFactory
     * @param array $data
     */

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Arpatech\NewsTicker\Model\ResourceModel\News\CollectionFactory $newsCollection,
        \Arpatech\NewsTicker\Model\ResourceModel\Group\CollectionFactory $groupCollection,
        array $data = []
    ) {
        $this->_request = $context->getRequest();
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_storeManager = $context->getStoreManager();
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_filesystem = $context->getFilesystem();
        $this->_newsCollection = $newsCollection;
        $this->_groupCollection = $groupCollection;
        parent::__construct($context, $data);
        $this->_values = $this->getValues();
    }
    public function getGroupCollection()
    {
        $collection = $this->_groupCollection->create();
        $collection->addFieldToFilter('status', 1);
        return $collection;
    }
    public function getNewsCollection()
    {
        $collection = $this->_newsCollection->create();
        $collection->addFieldToFilter('status', 1);
        return $collection;
    }
    public function getNewsIdsFromGroupCode($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        $newsIds = '';
        foreach ($groupCollection as $group) {
            $newsIds = $group->getNewsIds();
            break;
        }
        if ($newsIds != '') {
            if (strpos($newsIds, ',') !== false) {
                return explode(',', $newsIds);
            } else {
                return $newsIds;
            }
        } else {
            return '';
        }
    }
    public function getNewsContent($id)
    {
        $newsCollection = $this->getNewsCollection();
        $newsCollection->addFieldToFilter('id', $id);
        return $newsCollection;
    }
    public function getSpeed($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        foreach ($groupCollection as $value) {
            $speed=$value->getSpeed();
            return $speed;
        }
    }
    public function getDisplayType($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        foreach ($groupCollection as $value) {
            $type=$value->getDisplayType();
            return $type;
        }
    }
    public function getDirection($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        foreach ($groupCollection as $value) {
            $direction=$value->getDirection();
            return $direction;
        }
    }
    public function getFadeInSpeed($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        foreach ($groupCollection as $value) {
            $FadeInSpeed=$value->getFadeInSpeed();
            return $FadeInSpeed;
        }
    }
    public function getFadeOutSpeed($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        foreach ($groupCollection as $value) {
            $FadeOutSpeed=$value->getFadeOutSpeed();
            return $FadeOutSpeed;
        }
    }
    public function getWidth($groupCode)
    {
        $groupCollection = $this->getGroupCollection();
        $groupCollection->addFieldToFilter('code', $groupCode);
        foreach ($groupCollection as $value) {
            $width=$value->getWidth();
            return $width;
        }
    }
}
