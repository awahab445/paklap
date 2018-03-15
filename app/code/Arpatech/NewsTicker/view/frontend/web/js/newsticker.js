define([
"jquery",
"jquery/ui",
], function ($) {
    'use strict';
    $.widget('newsticker.newsticker', {
        options: {},
        _create: function () {
            var self = this;
            $(document).ready(function () {
                var i;
                var x;
                var fadeoutspeed = self.options.fadeoutspeed;
                var fadeinspeed = self.options.fadeinspeed;
                var direction = self.options.direction;
                var speed = self.options.speed;
                var displaytype = self.options.displaytype;
                var allpara = $('#wk_nt_news li ').length;
                var l=allpara-1;
                var pause=false;
                var current = 0;
                var token=1;
                var li_width=$('#wk_nt_news ul li').outerWidth();
                var all_list_Width=getAlllistWidth(allpara);
                    $('#wk_nt_news ul').width(all_list_Width);
                    $('#play').click(function () {
                        if (pause==false) {
                            stop();
                        } else {
                            newsAnimate();
                        }
                    })
                    $('#wk_nt_news ul')
                    .mouseover(function () {
                        $('#wk_nt_news ul').clearQueue().stop();
                    })
                    .mouseout(function () {
                        if (direction=='right') {
                            var px=0;
                        } else {
                            x=li_width+15;
                            var px = x*l*-1;
                        }
                        $('#wk_nt_news ul').animate({
                            left: px
                        },+speed,''+displaytype+'',function () {
                            newsAnimate();
                        });
                    })
                    function setPosition(pos)
                    {
                        x=li_width;
                        var px = x*pos*-1;
                        $('#wk_nt_news ul').fadeOut('+fadeoutspeed+').animate({
                            left: px
                        }, 300).fadeIn('+fadeinspeed+');
                    }
                    function newsAnimate()
                    {
                        if (direction=='right') {
                            var px=0;
                            var px_left=parseInt($('#wk_nt_news ul').css("left"));
                            if (token==1||px_left=='0') {
                                setPosition(allpara-1);
                            }
                            token++;
                        } else {
                            x=li_width+15;
                            var px = x*l*-1;
                            var px_left=parseInt($('#wk_nt_news ul').css("left"));
                            if (px_left == px) {
                                setPosition(0);
                            }
                        }
                        $('#wk_nt_news ul').animate({
                            left: px
                        },+speed,''+displaytype+'',function () {
                            newsAnimate();
                        });
                    }
                    function stop()
                    {
                        $('#wk_nt_news ul').stop().css('display','none');
                    }
                    function check()
                    {
                        var x=0;
                        var px_left=parseInt($('#wk_nt_news ul').css("left"));
                        x1=li_width;
                        for (i=1; i<=allpara; i++) {
                            if (px_left*-1>=i*x1) {
                                x++;
                            }
                        }
                        return x;
                    }
                    function getAlllistWidth(x)
                    {
                        var allwidth=0;
                        for (i=1; i<=x; i++) {
                            if (i==1) {
                                allwidth+=$('#wk_nt_news ul li:first').outerWidth();
                            } else if (i==allpara) {
                                allwidth+=$('#wk_nt_news ul li:last').outerWidth();
                            } else {
                                allwidth+=$('#wk_nt_news ul li:nth-child('+i+')').outerWidth();
                            }
                        }
                        return allwidth+(15*x)+1;
                    }
                    newsAnimate();
            });
        }
    });
    return $.newsticker.newsticker;
});
