<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Bannerslider
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Arpatech\CityDropdown\Model\ResourceModel\CityDropdown;
/**
 * CityDropdown Collection
 * @category Arpatech
 * @package  Arpatech_CityDropdown
 * @module   CityDropdown
 * @author   Arpatech Developer
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected $_idFieldName = 'id';

    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Arpatech\CityDropdown\Model\CityDropdown', 'Arpatech\CityDropdown\Model\ResourceModel\CityDropdown');
    }


}
