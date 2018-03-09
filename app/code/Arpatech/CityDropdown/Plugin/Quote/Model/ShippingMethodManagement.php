<?php
namespace Arpatech\CityDropdown\Plugin\Quote\Model;


class ShippingMethodManagement
{


    /**
     * @param \Magento\Quote\Model\ShippingMethodManagement $subject
     * @param callable|\Closure $proceed
     * @param  mixed $cartId
     * @param \Magento\Quote\Api\Data\AddressInterface $address
     *
     **/
    public function aroundEstimateByExtendedAddress(
        \Magento\Quote\Model\ShippingMethodManagement $subject,
        \Closure $proceed,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address
    )
    {
        $returnValue = $proceed($cartId, $address);
        $output = [];
        foreach ($returnValue as $carrierData) {
            if ($carrierData->getCarrierCode() == 'tablerate' && strtolower($address->getCity()) == 'karachi') {
                continue;
            } elseif ($carrierData->getCarrierCode() == 'freeshipping' && strtolower($address->getCity()) != 'karachi') {
                continue;
            }

            $output[] = $carrierData;
        }
        return $output;

    }

}