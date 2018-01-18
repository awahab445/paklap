/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery'
], function ($) {
    'use strict';

    function processReviews(url, fromPages) {
        $.ajax({
            url: url,
            cache: true,
            dataType: 'html'
        }).done(function (data) {
            $('#product-review-container').html(data);
            $('[data-role="product-review"] .pages a').each(function (index, element) {
                $(element).click(function (event) {
                    processReviews($(element).attr('href'), true);
                    event.preventDefault();
                });
            });
        }).complete(function () {
            if (fromPages == true) {
                $('html, body').animate({
                    scrollTop: $('#reviews').offset().top - 50
                }, 300);
            }
        });
    }

    return function (config, element) {
        processReviews(config.productReviewUrl);
        $(function () {
            $('.product-info-main .reviews-actions a').click(function (event) {
                event.preventDefault();
                var acnchor = 'product-review-container';//$(this).attr('href').replace(/^.*?(#|$)/, '');
	            $('html, body').animate({
					scrollTop: $('#' + acnchor).offset().top - 50
				}, 300);
            });
        });
    };
});