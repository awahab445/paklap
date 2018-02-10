<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magmodules\RichSnippets\Helper\General as GeneralHelper;

class LocalBusiness extends AbstractHelper
{

    const XML_PATH_LOCALBUSINESS_ENABLE = 'magmodules_richsnippets/localbusiness/enable';
    const XML_PATH_LOCALBUSINESS_TYPE = 'magmodules_richsnippets/localbusiness/type';
    const XML_PATH_LOCALBUSINESS_NAME = 'magmodules_richsnippets/localbusiness/name';
    const XML_PATH_LOCALBUSINESS_ADDRESS = 'magmodules_richsnippets/localbusiness/address';
    const XML_PATH_LOCALBUSINESS_CITY = 'magmodules_richsnippets/localbusiness/city';
    const XML_PATH_LOCALBUSINESS_POSTALCODE = 'magmodules_richsnippets/localbusiness/postalcode';
    const XML_PATH_LOCALBUSINESS_REGION = 'magmodules_richsnippets/localbusiness/region';
    const XML_PATH_LOCALBUSINESS_COUNTRY = 'magmodules_richsnippets/localbusiness/country';
    const XML_PATH_LOCALBUSINESS_TELEPHONE = 'magmodules_richsnippets/localbusiness/telehone';
    const XML_PATH_LOCALBUSINESS_LATITUDE = 'magmodules_richsnippets/localbusiness/latitude';
    const XML_PATH_LOCALBUSINESS_LONGITUDE = 'magmodules_richsnippets/localbusiness/longitude';
    const XML_PATH_LOCALBUSINESS_PRICERANGE = 'magmodules_richsnippets/localbusiness/pricerange';
    const XML_PATH_LOCALBUSINESS_OPENING_HOURS = 'magmodules_richsnippets/localbusiness/opening_hours';

    protected $general;

    /**
     * LocalBusiness constructor.
     *
     * @param Context $context
     * @param General $generalHelper
     */
    public function __construct(
        Context $context,
        GeneralHelper $generalHelper
    ) {
        $this->general = $generalHelper;
        parent::__construct($context);
    }

    /**
     * @return array|bool
     */
    public function getSnippets()
    {
        if (!$this->general->getEnabled(self::XML_PATH_LOCALBUSINESS_ENABLE)) {
            return false;
        }
        if ($snippets = $this->getLocalBusinessSchema()) {
            return [$snippets];
        }

        return false;
    }

    /**
     * @return array
     */
    public function getLocalBusinessSchema()
    {
        $businessSnippets = [];
        $businessSnippets['@context'] = 'http://schema.org';
        $businessSnippets['@type'] = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_TYPE);
        $businessSnippets['@id'] = $this->general->getBaseUrl();
        if ($name = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_NAME)) {
            $businessSnippets['name'] = $name;
        }
        if ($telephone = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_TELEPHONE)) {
            $businessSnippets['telephone'] = $telephone;
        }
        if ($logo = $this->general->getLogo()) {
            $businessSnippets['image'] = $logo;
        }
        if ($pricerange = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_PRICERANGE)) {
            $businessSnippets['priceRange'] = $pricerange;
        }
        if ($address = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_ADDRESS)) {
            $businessSnippets['address']['@type'] = 'PostalAddress';
            $businessSnippets['address']['streetAddress'] = $address;
            if ($city = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_CITY)) {
                $businessSnippets['address']['addressLocality'] = $city;
            }
            if ($region = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_REGION)) {
                $businessSnippets['address']['addressRegion'] = $region;
            }
            if ($postalcode = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_POSTALCODE)) {
                $businessSnippets['address']['postalCode'] = $postalcode;
            }
            if ($countyCode = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_COUNTRY)) {
                if ($country = $this->general->getCountryname($countyCode)) {
                    $businessSnippets['address']['addressCountry'] = $country;
                }
            }
            $latitude = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_LATITUDE);
            $longitude = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_LONGITUDE);
            if (!empty($latitude) && !empty($longitude)) {
                $businessSnippets['geo']['@type'] = 'GeoCoordinates';
                $businessSnippets['geo']['latitude'] = $latitude;
                $businessSnippets['geo']['longitude'] = $longitude;
            }
        }
        if ($openingHours = $this->general->getValue(self::XML_PATH_LOCALBUSINESS_OPENING_HOURS)) {
            $openingHours = @unserialize($openingHours);
            if (is_array($openingHours)) {
                foreach ($openingHours as $open) {
                    $openingArr = [];
                    $openingArr['@type'] = 'OpeningHoursSpecification';
                    $openingArr['dayOfWeek'] = $open['day'];
                    $openingArr['opens'] = $open['time_open'];
                    $openingArr['closes'] = $open['time_close'];
                    $businessSnippets['openingHoursSpecification'][] = $openingArr;
                    unset($openingArr);
                }
            }
        }

        return $businessSnippets;
    }
}
