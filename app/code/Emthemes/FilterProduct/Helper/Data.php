<?php
/**
 * Copyright © 2015 Emthemes . All rights reserved.
 */
namespace Emthemes\FilterProduct\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $date;
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Stdlib\DateTime\Timezone $date
		       
	) {
		parent::__construct($context);	
		$this->date = $date;
		
	}

	public function getCountdownStartDate($product){
		if($product->getSpecialFromDate()!=null)
        	return $product->getSpecialFromDate();
        return false;
    }

    public function getCountdownEndDate($product){    	    	
    	if($product->getSpecialToDate()!=null){
    		$endDate = str_replace("00:00:00","23:59:59",$product->getSpecialToDate());
        	return  $endDate;
        }
        return false;
    }
    
      public function getCurrentDate(){
        $currentDate = $this->date->date('now');
        $currentDate = $currentDate->format('Y/m/d H:i:s');          
        return $currentDate;
    }    
    
    public function getPriceCountDown($product){       
    	if($product->getSpecialPrice() != 0 || $product->getSpecialPrice()) {
	        $currentDate = (new \DateTime())->setTime(0, 0, 0);            	        
            if($product->getSpecialToDate() != null) {
                if($currentDate->format('Y-m-d h:i:s') <= $product->getSpecialToDate() && $product->getSpecialFromDate() <= $currentDate->format('Y-m-d h:i:s')){
                    return true;
                }   
            }
        }
        
        return false;
    }
	
	

	
}
