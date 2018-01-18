/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/translate',
    'countdownTimer'
], function($,$t){
    return function (config, element) {  
        if($(element).length) {                               
            $(element).countdowntimer(
              startDate : "<?php echo date('Y/m/d H:i:s'); ?>",
              dateAndTime : "<?php echo str_replace('-','/',$_filterProductHelper->getCountdownEndDate($_product)); ?>",
              size : "lg",
              regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
              regexpReplaceWith: "$1<sup>"+$t("days")+"</sup> / $2<sup>"+$t("hours")+"</sup> / $3<sup>"+$t("minutes")+"</sup> / $4<sup>"+$t("seconds")+"</sup>"
              );
        }
    }
});

