/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    "jquery",    
    "jquery/ui",
    "jquery/jquery.mobile.custom",
], function ($) {
    'use strict';
   /* set Height for element */
    $.fn.equalElement = function(options){
        var defaultConf = {
            target: '.product-item-details'
        };
		var conf = $.extend({},defaultConf,options);
		
		this.each(function(){          
			var $_e = $(this);
			var maxHeight= 0;
			var $listItems = $_e.find(conf.target);
			var lenLi = $listItems.length;
			$listItems.css('height', '');
			if(lenLi > 1){
				/*for(var j=0;j<lenLi;j++){                
					$_maxHeight = Math.max($_maxHeight, $listItems.eq(j).outerHeight());
				}*/
				$listItems.each(function(){
					var $item = $(this);
					maxHeight = Math.max(maxHeight,$item.outerHeight());
				});
				$listItems.css('min-height', maxHeight + 'px');
			}
			
		});
		return this;
    }              
});

