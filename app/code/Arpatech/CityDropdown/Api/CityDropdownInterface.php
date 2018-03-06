<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Arpatech\CityDropdown\Api;

/**
 * Interface AttributeSetFinderInterface
 * @api
 */
interface CityDropdownInterface
{
    const ID 		= "id";
    const NAME 	    = "city_name";
    const CITYCODE 	= "city_code";


    /**
     * Get ID
     *
     * @param int $id
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */

    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */

    public function setId($id);

    /**
     * Get City Name
     *
     * @param string $name
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */

    public function getCityName();

    /**
     * Get City Name
     *
     * @param string $name
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */

    public function setCityName($name);

    /**
     * Get City Code
     *
     * @param string $citycode
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */

    public function getCityCode();

    /**
     * Set City Code
     *
     * @param string $catcode
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */

    public function setCityCode($citycode);

}
