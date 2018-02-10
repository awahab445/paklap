<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magmodules\RichSnippets\Helper\General as GeneralHelper;

class Website extends AbstractHelper
{

    const XML_PATH_WEBSITE_SITENAME = 'magmodules_richsnippets/website/sitename';
    const XML_PATH_WEBSITE_SITESEARCH = 'magmodules_richsnippets/website/sitesearch';
    const XML_PATH_WEBSITE_NAME = 'magmodules_richsnippets/store/name';
    const XML_PATH_WEBSITE_ALTERNATENAME = 'magmodules_richsnippets/store/alternate_name';
    const XML_PATH_WEBSITE_LOGO = 'magmodules_richsnippets/store/logo';

    protected $general;

    /**
     * Website constructor.
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
     * @return array
     */
    public function getSnippets()
    {

        return $this->getWebSiteSchema();
    }

    /**
     * @return array
     */
    public function getWebSiteSchema()
    {
        $sitenameSnippets = [];
        $name = '';
        $alternateName = '';

        if ($this->general->getEnabled(self::XML_PATH_WEBSITE_SITENAME)) {
            $name = $this->general->getValue(self::XML_PATH_WEBSITE_NAME);
            $alternateName = $this->general->getValue(self::XML_PATH_WEBSITE_ALTERNATENAME);
        }
        $search = $this->getSiteLinkSearch();

        if (!empty($name) || !empty($search)) {
            $sitenameSnippets['@context'] = 'http://schema.org';
            $sitenameSnippets['@type'] = 'WebSite';
            $sitenameSnippets['url'] = $this->general->getBaseUrl();
            if (!empty($name)) {
                $sitenameSnippets['name'] = $name;
            }
            if (!empty($alternateName)) {
                $sitenameSnippets['alternateName'] = $alternateName;
            }
            if ($search = $this->getSiteLinkSearch()) {
                $sitenameSnippets['potentialAction'] = $search;
            }
        }

        return [$sitenameSnippets];
    }

    /**
     * @return array
     */
    public function getSiteLinkSearch()
    {
        $searchSnippets = [];
        if ($this->general->getEnabled(self::XML_PATH_WEBSITE_SITESEARCH)) {
            $searchSnippets['@type'] = 'SearchAction';
            $searchSnippets['target'] = $this->general->getBaseUrl() . 'catalogsearch/result/?q={search_term_string}';
            $searchSnippets['query-input'] = 'required name=search_term_string';
        }

        return $searchSnippets;
    }
}
