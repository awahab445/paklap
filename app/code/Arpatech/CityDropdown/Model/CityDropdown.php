<?php
namespace Arpatech\CityDropdown\Model;

use Arpatech\CityDropdown\Api\CityDropdownInterface;
use Magento\Framework\DataObject\IdentityInterface;

class CityDropdown extends \Magento\Framework\Model\AbstractModel implements CityDropdownInterface,IdentityInterface
{
    const CACHE_TAG = 'arpatech_city';

    protected $_cacheTag = 'arpatech_city';

    protected $_eventPrefix = 'arpatech_city';

    protected function _construct()
    {
        $this->_init('Arpatech\CityDropdown\Model\ResourceModel\CityDropdown');
    }


    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }


    /**
     * Get City Name
     *
     * @return string|null
     */
    public function getCityName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get City Code
     *
     * @return string|null
     */
    public function getCityCode()
    {
        return $this->getData(self::CITYCODE);
    }



    /**
     * Set ID
     *
     * @param int $id
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }


    /**
     * Set City Name
     *
     * @param string $name
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */
    public function setCityName($name)
    {
       $this->setData(self::NAME, $name);
    }

    /**
     * Set City Code
     *
     * @param string $code
     * @return \Arpatech\CityDropdown\Api\CityDropdownInterface
     */
    public function setCityCode($code)
    {
        $this->setData(self::CODE, $code);
    }


}