<?php
/**
 * A Magento 2 module named JazzCash/JazzCashPayment
 * Copyright (C) 2017  JazzCash
 * 
 * This file is part of JazzCash/JazzCashPayment.
 * 
 * JazzCash/JazzCashPayment is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace JazzCash\JazzCashPayment\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
	public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {
		
		$setup->startSetup();
		
		if ( !$setup->getTableRow( $setup->getTable( 'sales_order_status' ), 'status', 'jazzcash_failed' ) ) {
			$data = [];
			$statuses = ['jazzcash_failed' => __('JazzCash Failed')];
			foreach ($statuses as $code => $info) {
				$data[] = ['status' => $code, 'label' => $info];
			}
			$setup->getConnection()->insertArray($setup->getTable('sales_order_status'), ['status', 'label'], $data);
		}
		
		$setup->endSetup();
	}
}
