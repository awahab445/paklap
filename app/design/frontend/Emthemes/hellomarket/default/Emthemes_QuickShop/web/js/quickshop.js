(function (factory) {
    if (typeof define === "function" && define.amd) {
        define([
            "jquery",
            "jquery/ui",
			'Magento_Ui/js/modal/modal'
        ], factory);
    } else {
        factory(jQuery);
    }
}(function ($) {
	"use strict";
	$.widget('custom.EmthemesQuickShop', {
		options: {
			handlerClass: 'qs-button',
			modalId: 'quickshop',
			autoAddButtons: true,
			target: '.product-item-info',
		},
		 _create: function(){
			this._buildQuickShop(this.options);
			var self = this;
			var config = self.options;
			self.element.on('click',function(){
				window.qsUrl = self.element.data('href');
				var $modal = $('#'+config.modalId);
				$modal.modal('openModal');		
			});
		 },
		_buildQuickShop: function(config){
			var $modal = $('#'+config.modalId);
			if(typeof window.qsModal == 'undefined'){
				window.qsModal = $modal.modal({				
					innerScroll: true,
					title: '',
					wrapperClass: 'qs-modal',
					buttons: [],
					opened: function(){
						$('body').addClass('em-quickview');
						var $loader = $modal.find('.qs-loading-wrap');
						var $content = $modal.find('.qs-content');
						$loader.show(); $content.hide();
						$.ajax({
							url: window.qsUrl,
							type: 'POST',
							cache:false,
							success: function(res){
								$content.html(res).trigger('contentUpdated');
								$content.show();
								//If product type is bundle
								if($content.find('#bundle-slide').length > 0){
									var $bundleBtn = $content.find('#bundle-slide');
									var $bundleTabLink = $('#tab-label-quickshop-product-bundle-title');
									$bundleTabLink.parent().hide();
									$bundleBtn.unbind('click').click(function(e){
										e.preventDefault();
										$bundleTabLink.parent().show();
										$bundleTabLink.click();
										return false;
									});
								}
								//If use reviews
								if($content.find('#tab-label-quickshop-reviews-title').length > 0){
									var $reviewsTabLink = $content.find('#tab-label-quickshop-reviews-title');
									$content.find('.reviews-actions .action.view').click(function(){
										$reviewsTabLink.click();
									});
									$content.find('.reviews-actions .action.add').click(function(){
										$reviewsTabLink.click();
										$content.find('#nickname_field').focus();	
									})
								}
							}
						}).always(function(){$loader.hide();});
					},
					closed: function(){
						$modal.find('.qs-content').html('');
						$('body').removeClass('em-quickview');
					}
				});
			}
		}
	});
	return $.custom.EmthemesQuickShop;
}));
