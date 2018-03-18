<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magmodules\RichSnippets\Helper\General as GeneralHelper;

class Organization extends AbstractHelper
{

    const XML_PATH_ORGANIZATION_ENABLE = 'magmodules_richsnippets/organization/enable';
    const XML_PATH_ORGANIZATION_CONTACT_INFORMATION = 'magmodules_richsnippets/organization/contact_information';
    const XML_PATH_ORGANIZATION_SOCIAL_LINKS = 'magmodules_richsnippets/organization/social_links';

    protected $general;

    /**
     * Organization constructor.
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
        if (!$this->general->getEnabled(self::XML_PATH_ORGANIZATION_ENABLE)) {
            return false;
        }

        return [$this->getOrganizationSchema()];
    }

    /**
     * @return array
     */
    public function getOrganizationSchema()
    {
        $organizationSnippets = [];
        $organizationSnippets['@context'] = 'http://schema.org';
        $organizationSnippets['@type'] = 'Organization';
        $organizationSnippets['url'] = $this->general->getBaseUrl();
        if ($logo = $this->general->getLogo()) {
            $organizationSnippets['logo'] = $logo;
        }
        if ($contactSchema = $this->getContactInformationSchema()) {
            $organizationSnippets['contactPoint'] = $contactSchema;
        }
        if ($socialSchema = $this->getSocialLinksSchema()) {
            $organizationSnippets['sameAs'] = $socialSchema;
        }

        return $organizationSnippets;
    }

    /**
     * @return array
     */
    public function getContactInformationSchema()
    {
        $contactSchema = [];
        if ($contactInformation = $this->general->getValue(self::XML_PATH_ORGANIZATION_CONTACT_INFORMATION)) {
            $contactInformation = @unserialize($contactInformation);
            if (!is_array($contactInformation)) {
                return $contactSchema;
            }
            foreach ($contactInformation as $info) {
                $contact = [];
                if (!empty($info['telephone'])) {
                    $contact['@type'] = 'ContactPoint';
                    $contact['telephone'] = $info['telephone'];
                    if (!empty($info['contact_type'])) {
                        $contact['contactType'] = $info['contact_type'];
                    }
                    if (!empty($info['contact_option'])) {
                        if (strpos($info['contact_option'], ',') !== false) {
                            $contact['contactOption'] = explode(',', $info['contact_option']);
                        } else {
                            $contact['contactOption'] = $info['contact_option'];
                        }
                    }
                    if (!empty($info['area'])) {
                        if (strpos($info['area'], ',') !== false) {
                            $contact['areaServed'] = explode(',', $info['area']);
                        } else {
                            $contact['areaServed'] = $info['area'];
                        }
                    }
                    if (!empty($info['languages'])) {
                        if (strpos($info['languages'], ',') !== false) {
                            $contact['availableLanguage'] = explode(',', $info['languages']);
                        } else {
                            $contact['availableLanguage'] = $info['languages'];
                        }
                    }
                }
                if (!empty($contact)) {
                    $contactSchema[] = $contact;
                    unset($contact);
                }
            }
        }

        return $contactSchema;
    }

    /**
     * @return array
     */
    public function getSocialLinksSchema()
    {
        $socialSchema = [];
        if ($socialLinks = $this->general->getValue(self::XML_PATH_ORGANIZATION_SOCIAL_LINKS)) {
            $socialLinks = @unserialize($socialLinks);
            if (!is_array($socialLinks)) {
                return $socialSchema;
            }
            foreach ($socialLinks as $link) {
                $socialSchema[] = $link['url'];
            }
        }

        return $socialSchema;
    }
}
