<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ThemeSettings\App\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

class ScopePool
{
    const CACHE_TAG = 'config_scopes';

    /**
     * @var \Magento\Framework\App\Config\Scope\ReaderPoolInterface
     */
    protected $_readerPool;

    /**
     * @var DataFactory
     */
    protected $_dataFactory;

    /**
     * @var \Magento\Framework\Cache\FrontendInterface
     */
    protected $_cache;

    /**
     * @var string
     */
    protected $_cacheId;

    /**
     * @var DataInterface[]
     */
    protected $_scopes = [];

    /**
     * @var \Magento\Framework\App\ScopeResolverPool
     */
    protected $_scopeResolverPool;

    protected $serialize;

    /**
     * @param \Magento\Framework\App\Config\Scope\ReaderPoolInterface $readerPool
     * @param DataFactory $dataFactory
     * @param \Magento\Framework\Cache\FrontendInterface $cache
     * @param \Magento\Framework\App\ScopeResolverPool $scopeResolverPool
     * @param JsonSerializer $serialize
     * @param string $cacheId
     */
    public function __construct(
        \Emthemes\ThemeSettings\App\Config\Scope\ReaderPoolInterface $readerPool,
        \Magento\Framework\App\Config\DataFactory $dataFactory,
        \Magento\Framework\Cache\FrontendInterface $cache,
        \Magento\Framework\App\ScopeResolverPool $scopeResolverPool,
        \Magento\Framework\App\Config $scopeConfig,
        \Magento\Theme\Model\Design $design,
        JsonSerializer $serialize,
        $cacheId = 'emthemes_config_cache'

    ) {
        $this->_readerPool = $readerPool;
        $this->_dataFactory = $dataFactory;
        $this->_cache = $cache;
        $this->_cacheId = $cacheId;
        $this->_scopeResolverPool = $scopeResolverPool;
        $this->themeId = $scopeConfig->getValue('design/theme/theme_id',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->design = $design;
        if($design->getDesign()){
	        $this->themeId = $design->getDesign();
	    }
        $this->serialize = $serialize;
    }

    /**
     * Retrieve config section
     *
     * @param string $scopeType
     * @param string|\Magento\Framework\DataObject|null $scopeCode
     * @return \Magento\Framework\App\Config\DataInterface
     */
    public function getScope($scopeType, $scopeCode = null)
    {
        $scopeCode = $this->_getScopeCode($scopeType, $scopeCode);
        $code = $scopeType . '|' . $scopeCode . '|' . $this->themeId;
        if (!isset($this->_scopes[$code])) {
            $cacheKey = $this->_cacheId . '|' . $code;
            $data = $this->_cache->load($cacheKey);
            if ($data) {
                $data = $this->serialize->unserialize($data);
            } else {
                $reader = $this->_readerPool->getReader($scopeType);
                if ($scopeType === ScopeConfigInterface::SCOPE_TYPE_DEFAULT) {
                    $data = $reader->read();
                } else {
                    $data = $reader->read($scopeCode);
                }
                $this->_cache->save($this->serialize->serialize($data), $cacheKey, [self::CACHE_TAG]);
            }
            $this->_scopes[$code] = $this->_dataFactory->create(['data' => $data]);
        }
//        var_dump($this->_scopes[$code]);
        return $this->_scopes[$code];
    }

    /**
     * Clear cache of all scopes
     *
     * @return void
     */
    public function clean()
    {
        $this->_scopes = [];
        $this->_cache->clean(\Zend_Cache::CLEANING_MODE_MATCHING_TAG, [self::CACHE_TAG]);
    }

    /**
     * Retrieve scope code value
     *
     * @param string $scopeType
     * @param string|\Magento\Framework\DataObject|null $scopeCode
     * @return string
     */
    protected function _getScopeCode($scopeType, $scopeCode)
    {
        if (($scopeCode === null || is_numeric($scopeCode))
            && $scopeType !== ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        ) {
            $scopeResolver = $this->_scopeResolverPool->get($scopeType);
            $scopeCode = $scopeResolver->getScope($scopeCode);
        }

        if ($scopeCode instanceof \Magento\Framework\App\ScopeInterface) {
            $scopeCode = $scopeCode->getCode();
        }

        return $scopeCode;
    }
}
