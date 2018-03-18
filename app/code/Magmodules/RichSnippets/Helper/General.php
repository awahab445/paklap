<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Directory\Model\CountryFactory;

class General extends AbstractHelper
{

    const MODULE_CODE = 'Magmodules_RichSnippets';
    const XML_PATH_EXTENSION_ENABLE = 'magmodules_richsnippets/general/enable';
    const XML_PATH_STORE_LOGO = 'magmodules_richsnippets/store/logo';

    protected $storeManager;
    protected $moduleList;
    protected $metadata;
    private $countryFactory;

    /**
     * General constructor.
     *
     * @param Context                  $context
     * @param StoreManagerInterface    $storeManager
     * @param ModuleListInterface      $moduleList
     * @param ProductMetadataInterface $metadata
     * @param CountryFactory           $countryFactory
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ModuleListInterface $moduleList,
        ProductMetadataInterface $metadata,
        CountryFactory $countryFactory
    ) {
        $this->storeManager = $storeManager;
        $this->moduleList = $moduleList;
        $this->metadata = $metadata;
        $this->countryFactory = $countryFactory;
        parent::__construct($context);
    }

    /**
     * Returns current version of the extension.
     *
     * @return mixed
     */
    public function getExtensionVersion()
    {
        $moduleInfo = $this->moduleList->getOne(self::MODULE_CODE);

        return $moduleInfo['setup_version'];
    }

    /**
     * Returns current version of Magento.
     *
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->metadata->getVersion();
    }

    /**
     * @param      $path
     * @param null $storeId
     * @param null $scope
     *
     * @return bool|mixed
     */
    public function getEnabled($path, $storeId = null, $scope = null)
    {
        if (!$this->getValue(self::XML_PATH_EXTENSION_ENABLE)) {
            return false;
        }
        if (empty($scope)) {
            $scope = ScopeInterface::SCOPE_STORE;
        }

        return $this->scopeConfig->getValue($path, $scope, $storeId);
    }

    /**
     * @param      $path
     * @param null $storeId
     * @param null $scope
     *
     * @return mixed
     */
    public function getValue($path, $storeId = null, $scope = null)
    {
        if (empty($scope)) {
            $scope = ScopeInterface::SCOPE_STORE;
        }

        return $this->scopeConfig->getValue($path, $scope, $storeId);
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrencyCode();
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * @return bool|mixed
     */
    public function getLogo()
    {
        if ($logo = $this->getValue(self::XML_PATH_STORE_LOGO)) {
            return $logo;
        } else {
            return false;
        }
    }

    /**
     * @param $countryCode
     *
     * @return string
     */
    public function getCountryname($countryCode)
    {
        $country = $this->countryFactory->create()->loadByCode($countryCode);
        if ($country) {
            return $country->getName();
        }
    }
}
