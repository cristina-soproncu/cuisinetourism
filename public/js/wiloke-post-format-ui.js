;(function($,window,document,undefined){"use strict";function pi_post_format_ui_tiled_gallery(){var $wilokeTiledGallery=$('.wiloke-tiled-gallery');if($wilokeTiledGallery.length)
{var _rowHeight='250px',windowWidth=$(window).width();if($('.blog-standard').length>0)
{_rowHeight='200px';}else{_rowHeight='150px';}
if(windowWidth>480&&windowWidth<=768)
{_rowHeight='150px';}else if(windowWidth<=480)
{_rowHeight='100px';}else{_rowHeight='200px';}
$wilokeTiledGallery.each(function(){$(this).wrap('<div class="tiled-gallery-row"></div>');$(this).justifiedGallery({'rowHeight':_rowHeight,lastRow:'justify'});});}}
function pi_post_format_ui_owl_carousel()
{var navslider=['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],$imgSlider=$('.wiloke-images-slider');if($imgSlider.length>0)
{$imgSlider.each(function()
{$(this).owlCarousel({autoPlay:20000,slideSpeed:300,navigation:true,pagination:true,items:1,itemsDesktop:false,itemsDesktopSmall:false,itemsTablet:false,itemsMobile:false,autoHeight:false,navigationText:navslider});});}}
function pi_post_format_ui_magnific_popup()
{if($(".pi-magnific-popup").length>0)
{$('.pi-magnific-popup').each(function()
{if($(this).hasClass('gallery-media')){$(this).magnificPopup({delegate:'a',type:'image',tLoading:'Loading image #%curr%...',mainClass:'mfp-img-mobile',gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]},image:{tError:'<a href="%url%">The image #%curr%</a> could not be loaded.',titleSrc:function(item){return item.el.attr('data-caption');}}});}
else if($(this).hasClass('gallery-instagram')){$('.item',this).each(function(){var $this=$(this);$(this).magnificPopup({ajax:{settings:{type:'POST',url:$this.data('wiloke-ajax'),data:{action:'detail_photo_instagram','source':$this.attr('href')}}},type:'ajax'})});}
else if($(this).hasClass('gallery-flickr')){$(this).magnificPopup({delegate:'a',type:'image',gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]},image:{markup:'<div class="mfp-figure">\
                                        <div class="mfp-close"></div>\
                                        <a href="">\
                                            <div class="mfp-img"></div>\
                                        </a>\
                                        <div class="mfp-bottom-bar">\
                                            <div class="mfp-title"></div>\
                                            <div class="mfp-counter"></div>\
                                        </div>\
                                    </div>',tError:'<a href="%url%">The image #%curr%</a> could not be loaded.',titleSrc:function(item){return item.el.attr('data-caption');}},});}})}
if($(".pi-magnific-iframe").length>0)
{$(".pi-magnific-iframe").magnificPopup({disableOn:700,type:'iframe',mainClass:'mfp-fade',removalDelay:160,preloader:false,fixedContentPos:false});}}
$(window).ready(function(){pi_post_format_ui_tiled_gallery();pi_post_format_ui_owl_carousel();pi_post_format_ui_magnific_popup();})})(jQuery,window,document)