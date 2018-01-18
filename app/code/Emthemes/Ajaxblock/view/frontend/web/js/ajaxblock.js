define(['jquery','emslider'],
function($){
	$.widget('custom.EmthemesAjaxblock', {
		options:{
			url: '',
			data: {}
		},
		_create: function(){
			var self = this;
			var $this = self.element;
			if($this.parents('.tab-content').length > 0){
				var $tabContent = $this.parents('.tab-content').first();
				self._getTabTrigger($tabContent).each(function(){
					var $tabTrigger = $(this);
					var $li = $tabTrigger.parent('li');
					if($li.length){
						var loadContent = function(){
							$li.parent().find('li').removeClass('active');
							$this.parents('.em-tabs-widget').first().find('.tab-content').removeClass('active').hide();
							$li.addClass('active');
							$tabContent.addClass('active').show();
							if(!$tabTrigger.hasClass("loaded")){
								$.ajax({
									url: self.options.url,
									method: 'POST',
									data: {data: self.options.data},
									success: function(data){
										$this.html(data).trigger("contentUpdated");
										$tabTrigger.addClass("loaded");
										$this.removeClass('emtabs-ajaxblock-loading').addClass('emtabs-ajaxblock-loaded');	
									}
								});
							}	
						}
						if($li.hasClass('active')){
							$tabContent.show();
							loadContent();
						}else{
							$tabContent.hide();
						}
						
						$tabTrigger.on('click',function(e){
							e.preventDefault();
							loadContent();
						});
					}
				});
			}else{
				$.ajax({
					url: self.options.url,
					method: 'POST',
					data: {data: self.options.data},
					success: function(data){
						$this.html(data).trigger("contentUpdated");
						$this.removeClass('emtabs-ajaxblock-loading').addClass('emtabs-ajaxblock-loaded');	
					}
				});
			}
		},
		_getTabTrigger: function($tabContent){
			var self = this;
			var tabId = $tabContent.attr('id');
			return $('a[href="#'+tabId+'"]');
		}
	});
	return $.custom.EmthemesAjaxblock;
});