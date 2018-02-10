<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class LocalBusiness implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $type = [];
        $type[] = ['value' => 'Store', 'label' => 'Store (general)'];
        $type[] = ['value' => 'BikeStore', 'label' => 'BikeStore'];
        $type[] = ['value' => 'BookStore', 'label' => 'BookStore'];
        $type[] = ['value' => 'ClothingStore', 'label' => 'ClothingStore'];
        $type[] = ['value' => 'ComputerStore', 'label' => 'ComputerStore'];
        $type[] = ['value' => 'ConvenienceStore', 'label' => 'ConvenienceStore'];
        $type[] = ['value' => 'DepartmentStore', 'label' => 'DepartmentStore'];
        $type[] = ['value' => 'ElectronicsStore', 'label' => 'ElectronicsStore'];
        $type[] = ['value' => 'Florist', 'label' => 'Florist'];
        $type[] = ['value' => 'FurnitureStore', 'label' => 'FurnitureStore'];
        $type[] = ['value' => 'GardenStore', 'label' => 'GardenStore'];
        $type[] = ['value' => 'GardenStore', 'label' => 'GardenStore'];
        $type[] = ['value' => 'HardwareStore', 'label' => 'HardwareStore'];
        $type[] = ['value' => 'HobbyShop', 'label' => 'HobbyShop'];
        $type[] = ['value' => 'HomeGoodsStore', 'label' => 'HomeGoodsStore'];
        $type[] = ['value' => 'JewelryStore', 'label' => 'JewelryStore'];
        $type[] = ['value' => 'LiquorStore', 'label' => 'LiquorStore'];
        $type[] = ['value' => 'MensClothingStore', 'label' => 'MensClothingStore'];
        $type[] = ['value' => 'MobilePhoneStore', 'label' => 'MobilePhoneStore'];
        $type[] = ['value' => 'MovieRentalStore', 'label' => 'MovieRentalStore'];
        $type[] = ['value' => 'MusicStore', 'label' => 'MusicStore'];
        $type[] = ['value' => 'OfficeEquipmentStore', 'label' => 'OfficeEquipmentStore'];
        $type[] = ['value' => 'OutletStore', 'label' => 'OutletStore'];
        $type[] = ['value' => 'PawnShop', 'label' => 'PawnShop'];
        $type[] = ['value' => 'PetStore', 'label' => 'PetStore'];
        $type[] = ['value' => 'ShoeStore', 'label' => 'ShoeStore'];
        $type[] = ['value' => 'SportingGoodsStore', 'label' => 'SportingGoodsStore'];
        $type[] = ['value' => 'TireShop', 'label' => 'TireShop'];
        $type[] = ['value' => 'ToyStore', 'label' => 'ToyStore'];
        $type[] = ['value' => 'WholesaleStore', 'label' => 'WholesaleStore'];

        return $type;
    }
}
