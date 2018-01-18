/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/smart-keyboard-handler',
    'mage/mage',
	'matchMedia',
    'mage/ie-class-fixer',
    'mage/translate',
    'emCollapsible',
    'domReady!'
], function ($, keyboardHandler) {
    'use strict';

      /* sticky menu */
      if(EM.SETTING.STICKY_MENU == 1 && isMobile == 'false')
      {
             var $_e = $('.page-header');
              if ($_e.length) {            
                      var sticky_navigation = function() {
                          var wWindow = $(window).width();
                          var scroll_top = $(window).scrollTop();
                          var navpos = $('#header-position').offset().top;
                          if (wWindow > 767) {
                              if (scroll_top > navpos) {
                                  if (!$_e.hasClass('navbar-fixed-top')) {
                                      $_e.addClass('navbar-fixed-top');
                                  }
                              } else {
                                  if ($_e.hasClass('navbar-fixed-top')) { 
                                      $_e.removeClass('navbar-fixed-top');
                                    if($('.mobile-search-icon').hasClass('active'))
                                      $('.mobile-search-icon').click();

                                  }
                              }
                          } else {
                              if ($_e.hasClass('navbar-fixed-top')) {   
                                  $_e.removeClass('navbar-fixed-top');
                              }
                                  if($('.mobile-search-icon').hasClass('active'))
                                      $('.mobile-search-icon').click();

                          }
                      };
                      $(window).scroll(function() {
                          sticky_navigation();
                      });
                      sticky_navigation();
                            
              }
      }      
   
	
	/* retina images */
       if (window.devicePixelRatio > 1 ||
             (window.matchMedia && window.matchMedia("(-webkit-min-device-pixel-ratio: 1.5),(-moz-min-device-pixel-ratio: 1.5),(min-device-pixel-ratio: 1.5)").matches)) 
       {
	        var images = $('img.retina-img');
              var len = images.length;
              if(len){
                    /* loop through the images and make them hi-res */
		        for(var i = 0; i < len; i++) {    
			      /* create new image name */
			      var imageType = images[i].src.substr(-4);
			      var imageName = images[i].src.substr(0, images[i].src.length - 4);
			      imageName += "@2x" + imageType;

			      /* rename image */
			      images[i].src = imageName;
		        }
              }
       };
       
        /* collapse */
        var sCollap = $("[data-collapse-target]");            
        var len = sCollap.length;
		if(len){
		    sCollap.removeClass('em-collapsed non-collapsed').addClass('non-collapsed');
		    for(var i=0;i<len;i++){
		        var id = sCollap.eq(i).data('collapse-target');
		        var $id=$(id);
		        if($id.length){
		        	sCollap.eq(i).emcollapsible({
		        		collapseTarget: $id,
		        	})
		        }                    
		    }		  
		}
		
		var $topVerNavCont = $('#top-ver-navigation');
		var $topVerNav = $('.menuleft',$topVerNavCont);
		$topVerNav.hide();
		$topVerNavCont.hover(function(){
			$topVerNav.stop().fadeIn(300);
		},
		function(){
			$topVerNav.stop().fadeOut(300);
		});
		
		
		/* Scroll bar */
		$.fn.emScrollbar = function(){
			return this.each(function(){
				var $scrollbar = $(this), $win = $(window),
				$container = $('.em-main-top-right').first();
				var $scticky = $('.navbar-fixed-top').first();
				var timeout = false;			
				$win.on('scroll', function(){
					mediaCheck({
						media: '(min-width: 768px)',
						entry: function () {
							if(timeout){
								clearTimeout(timeout);
							}
							timeout = setTimeout(function(){
								var windTop = $win.scrollTop();
								var barTop = $scrollbar.offset().top;
								var winHeight = $win.height();
								var stickyHeight = $('.navbar-fixed-top').first().outerHeight();
								var needScroll = Math.max(0,windTop - barTop + stickyHeight);
								var conTop = $container.offset().top;
								var conHeight = $container.height();
								var threshold = conTop + conHeight;
								if( (windTop + winHeight) > (threshold) ){
									needScroll = conHeight - (barTop - conTop) - $('.em-scrollbar',$scrollbar).outerHeight(true)-20;
									needScroll = Math.max(0,needScroll);
								}
								$scrollbar.stop().animate({paddingTop:needScroll},500);
							},100);		
						},
						exit: function () {
							$scrollbar.css({paddingTop:''});
						}
					});
				});
			});
		}
		$('.scroll-wrapper').emScrollbar();
});

