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
 
namespace JazzCash\JazzCashPayment\Model;

/**
 * Pay In Store payment method model
 */
class JazzCashPaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'jazzcashpaymentmethod';

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

}
