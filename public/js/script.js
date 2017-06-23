(function($){"use strict";var isMobile={Android:function(){return navigator.userAgent.match(/Android/i);},BlackBerry:function(){return navigator.userAgent.match(/BlackBerry/i);},iOS:function(){return navigator.userAgent.match(/iPhone|iPad|iPod/i);},Opera:function(){return navigator.userAgent.match(/Opera Mini/i);},Windows:function(){return navigator.userAgent.match(/IEMobile/i);},any:function(){return(isMobile.Android()||isMobile.BlackBerry()||isMobile.iOS()||isMobile.Opera()||isMobile.Windows());}}
$.fn.imageCover=function(){$(this).each(function(){var self=this;cover(self);$(this).data('isCover')
$(window).resize(function(){cover(self);});});function cover(el){var self=$(el),image=self.find('img');if(image.length){var naturalHeight=image[0].naturalHeight,naturalWidth=image[0].naturalWidth,heightWrap=self.outerHeight(),widthWrap=self.outerWidth();if((widthWrap/heightWrap)<(naturalWidth/naturalHeight)){image.css({'height':'100%','width':'auto','max-width':'initial'});}
else{image.css({'height':'','width':'','max-width':''});}}}}
$.fn.numberLine=function(opts){$(this).each(function(){var el=$(this),defaults={numberLine:0},data=el.data(),dataTemp=$.extend(defaults,opts),options=$.extend(dataTemp,data);if(!options.numberLine){return false;}
el.bind('customResize',function(event){event.stopPropagation();reInit();}).trigger('customResize');$(window).resize(function(){el.trigger('customResize');});function reInit(){var fontSize=parseInt(el.css('font-size')),lineHeight=parseInt(el.css('line-height')),overflow=fontSize*(lineHeight/fontSize)*options.numberLine;el.css({'display':'block','max-height':overflow,'overflow':'hidden'});}});}
$.fn.KSetHeight=function(){var $self=$(this),w=window.innerWidth;$self.each(function(index,el){var $this=$(this),wb=$this.data('break'),h=$this.innerHeight(),el=$this.data('getHeight');if(typeof el!=='undefined'&&$('[data-set-height="'+ el+'"]').length){var $el=$('[data-set-height="'+ el+'"]');if(typeof wb==='undefined'||isNaN(wb)){wb=0;}
if(w>wb){$el.css('min-height',h+'px');}else{$el.css('min-height','');}}});}
function k_preloader(){$('.preloader').fadeOut();}
function k_menu_sticky(){if($('#k-header.k-sticky').length){var $this=$('#k-header.k-sticky'),h=$this.innerHeight();$this.before('<div class="clearfix" style="height: '+ h+'px"></div>');}
function k_menu_sticky_scroll(){if($('#k-header.k-sticky').length){var scroll_top=$(window).scrollTop(),h_window=$(window).innerHeight(),h=$this.innerHeight();if(scroll_top>=h){$('#k-header.k-sticky').addClass('sticky');if($('.k-bar-widget').length){$('.k-bar-widget').css('max-height',h_window- h+'px');}}else{$('#k-header.k-sticky').removeClass('sticky');$('.k-bar-widget').css('max-height','');}}}
$(window).scroll(function(event){k_menu_sticky_scroll();});}
function k_menu_resize(){var $this=$('#k-header'),w=window.innerWidth,ws=$this.data('mobile');if(isNaN(ws)){ws=991;}
if(w<=ws){$('nav',$this).removeClass('k-navigation').addClass('k-navigation-mobile');$('.k-bar-menu',$this).css('display','block');$('.k-bar',$this).css('display','none');}else{$('nav',$this).removeClass('k-navigation-mobile').addClass('k-navigation');$('.k-bar',$this).css('display','');$('.k-bar-menu',$this).css('display','').removeClass('active');$('#page-wrap').removeClass('active-menu-mobile');}}
function k_menu_mobile(){if($('#k-header nav').length){var $nav=$('#k-header nav');$('.sub-menu').prepend('<li class="back-sub-menu"><a href="#">Back</a><li>');}
$(document).on('click','.k-navigation-mobile .menu-item-has-children > a',function(event){event.preventDefault();var $this=$(this),$wrap=$this.closest('.kratos-menu'),$parent=$this.closest('li'),$sub=$('> .sub-menu',$parent);$sub.addClass('active');});$(document).on('click','.k-navigation-mobile .back-sub-menu a',function(event){event.preventDefault();var $this=$(this);$this.closest('.sub-menu').removeClass('active');});$(document).on('click','#k-header .k-bar-menu',function(event){event.preventDefault();$(this).toggleClass('active');$('#page-wrap').toggleClass('active-menu-mobile');});}
function k_font_size(){var $iconFont=$('.k-icon-font');if(!window.localStorage.fontSizeBody){window.localStorage.fontSizeBody='14px';}
$iconFont.find('.active').removeClass('active');$('span[data-size="'+ window.localStorage.fontSizeBody+'"]').addClass('active');$('.k-icon-font').on('click',function(event){event.preventDefault();var $self=$(this),$active=$('.active',$self),indexActive=$active.index(),$newActive,newIndexActive;if(indexActive>=($('span',$self).length- 1)){newIndexActive=0;}
else{newIndexActive=indexActive+ 1}
$('span',$self).eq(newIndexActive).addClass('active');$active.removeClass('active');window.localStorage.fontSizeBody=$('.active',$self).data('size');$iconFont.trigger('change');}).change(function(){$('body').css({'font-size':window.localStorage.fontSizeBody})});$iconFont.trigger('change');}
function k_bar_widget_show(){$('.k-bar').on('click','.k-icon-bar',function(event){event.preventDefault();$(this).parent().toggleClass('active');});$('a[href="#search"]').on('click',function(event){event.preventDefault();$('.k-bar .k-icon-bar').trigger('click');setTimeout(function(){var el=$('.k-bar .widget_search .search_field').get(0);if(el){var elemLen=el.value.length;el.selectionStart=elemLen;el.selectionEnd=elemLen;el.focus();}},50);});}
function k_random_post_info(){$('.widget_random_post h4 span').on('click',function(event){event.preventDefault();var $this=$(this),$wrap=$this.closest('ul'),$parent=$this.closest('li'),$el=$('.post-meta',$parent);if($parent.hasClass('active')){$el.slideUp(300);$parent.removeClass('active');}else{$('.post-meta',$wrap).slideUp(300);$('li',$wrap).removeClass('active');$el.slideDown(300);$parent.addClass('active');}});}
function k_widget_recent_post_masonry(){if($('.widget_recent_thumbnail').length){$('.widget_recent_thumbnail').masonry({itemSelector:'li',});}}
function k_widget_instagram_masonry(){if($('.widgetinstagram').length){$('.widgetinstagram').masonry({itemSelector:'li',});}}
function k_blog_masonry(){if($('.blog-masonry').length){$('.blog-masonry').masonry({itemSelector:'.grid-item',columnWidth:'.grid-size'});}
if($('.blog-grid').length){$('.blog-grid').masonry({itemSelector:'.grid-item',columnWidth:'.grid-size'});}}
function k_post_related_slider(){if($('.related-slider').length){$('.related-slider').owlCarousel({items:1,autoHeight:true,pagination:false,navigation:true,navigationText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']});}}
function k_post_content_grid(){$('.blog-grid').on('click','.more-excerpt',function(event){event.preventDefault();var $this=$(this),$wrap=$this.closest('.blog-grid'),$post=$this.closest('.post'),$posts=$('.post',$wrap),$active=$('.k-active',$wrap),$disable=$('.k-disable',$wrap);if($post.hasClass('k-active')){$post.removeClass('k-active');$disable.removeClass('k-disable');}else{$posts.addClass('k-disable');if($post.hasClass('k-disable')){$post.removeClass('k-disable');}
$post.addClass('k-active');}});}
function k_featured_slider(){if($('.featured-slider').length){$('.featured-slider').each(function(){var $self=$(this);$('.post-featured',$self).each(function(){$(this).attr('data-index',$(this).index());});$self.owlCarousel({loop:true,items:1,pagination:false,navigation:true,navigationText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],afterInit:function(){var curent=this.currentItem+ 1,count=this.$owlItems.length;if(curent<10){curent='0'+ curent;}
if(count){count='0'+ count;}
$('.owl-buttons',$self).prepend('<span class="pagination-owl"><span class="current">'+ curent+'</span> / <span class="total">'+ count+'</span></span>');$self.on('roseChange',function(){var curent=$('.owl-item.active',$self).find('.post-featured').data('index')+ 1;if(curent<10){curent='0'+ curent;}
$('.current',$self).html(curent);});},afterAction:function(){var curent=this.currentItem+ 1;if(curent<10){curent='0'+ curent;}
$('.current',$self).html(curent);}});});}}
function k_post_slider(){if($('.post-slider').length){$('.post-featured').each(function(){var $this=$(this),src=$('img',$this).attr('src');if(typeof src!='undefined'){$this.css('background-image','url('+ src+')');}});$('.post-slider').owlCarousel({items:1,autoHeight:true,pagination:false,navigation:true,navigationText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']})}}
function k_tooltip(){$('[data-toggle="tooltip"]').tooltip({container:'body',});}
function k_pagination(){if($('.pagination .prev').length){var $prev=$('.pagination .prev'),$wrap=$prev.closest('.nav-links'),$next=$('.next',$wrap);if($next.length){$next.before($prev);}else{$wrap.append($prev);}}}
function k_cover_image(){$('.k-bar-widget .widget_about .img, \
            .widgetinstagram li .img, \
            .post-author-content .img, \
            .blog-grid .post .post-media .img, \
            .blog-grid-large .post .post-media .img, \
            .k-about .about-img, \
            .blog-list .post-media .img, \
            .blog-list .post-media .post-slider .item, \
            .commentlist li .avatar, \
            .gallery-instagram .instagram-item .img, \
            .instagram-popup .instagram-popup-media, \
            .instagram-popup .instagram-popup-info .instagram-info-header .instagram-avarta, \
            .related-item .img').imageCover();}
function k_full_height_screen(){var h=window.innerHeight,w=window.innerWidth;$('[data-full-screen="true"]').each(function(index,el){var $this=$(this),ignore_array=$this.data('ignore'),wb=$this.data('break'),ignore_height=$this.data('ignoreHeight'),mheight=0;if(typeof ignore_array!='undefined'&&ignore_array!=''){if(typeof wb==='undefined'||isNaN(wb)){wb=0;}
if(w>wb){ignore_array=ignore_array.split(',');if(typeof ignore_height==='undefined'||isNaN(ignore_height)){ignore_height=0;}
for(var i=ignore_array.length- 1;i>=0;i--){if($(ignore_array[i]).length){ignore_height+=$(ignore_array[i]).innerHeight();}}
mheight=h- ignore_height;if(mheight>0){$this.css('min-height',mheight+'px');}}else{$this.css('min-height','');}}});}
function k_set_height(){$('[data-get-height]').KSetHeight();}
function k_contact_map(){if($('#maps').length){var $this=$('#maps'),location=$this.data().latlng;if(location){var latlng=new google.maps.LatLng(location[0],location[1]);var options={zoom:16,center:latlng,scrollwheel:false,};var map=new google.maps.Map($this[0],options);google.maps.event.addDomListener(window,'resize',function(){map.setCenter(latlng);});var marker=new google.maps.Marker({position:latlng,map:map,zIndex:1,icon:"../"});marker.setMap(map);}}}
function k_scroll_top(){$('.scroll-top').on('click',function(event){event.preventDefault();$('body').stop().animate({scrollTop:0},600);});}
function k_remove_all_active(){$(document).on('click',function(event){if($(event.target).closest('.k-bar').length||$(event.target).attr('href')=='#search'){return;}else{$('.k-bar').removeClass('active');}
if($(event.target).closest('.k-active').length){return;}else{$('.blog-grid .post').removeClass('k-disable k-active');}});}
function k_sticky_sidebar(){if($('.k-sidebar').length>0){var margin_top=0;if($('#k-header').hasClass('k-sticky')){margin_top=60;}
$('.k-sidebar').parent().theiaStickySidebar({updateSidebarHeight:true,additionalMarginTop:margin_top});}
if($('.k-comment .comment-respond').length>0){$('.k-comment .comment-respond').parent().theiaStickySidebar({updateSidebarHeight:true,additionalMarginTop:margin_top});}}
function k_category_post_count(){var moveOut=function($element){$('li',$element).each(function(index,el){var $el=$(el),$children=$(el).children(),$context=$('<div></div>').append($children),text=$(el).text();$(el).html('').append($context.html());$('>a',this).text($('>a',$el).text()+ text);if($('ul',$el).length){moveOut($('ul',$el));}
return;});}
$('.widget_categories').each(function(){var $self=$(this);moveOut($self);});}
function k_set_hegiht_related(){function init(){var w=window.innerWidth;if(w>1199){if($('.post-related').length){var $this=$('.post-related'),padding_top=parseInt($this.css('paddingTop')),padding_bottom=parseInt($this.css('paddingBottom')),height=parseInt($this.css('minHeight'));$('.related-item').height(height- padding_top- padding_bottom)}}else{$('.related-item').css('height','');}}
init();$(window).resize(function(){init();});}
$(document).ready(function(){k_menu_sticky();k_bar_widget_show();k_random_post_info();k_post_related_slider();k_pagination();k_featured_slider();k_post_content_grid();k_tooltip();k_menu_mobile();k_font_size();k_contact_map();k_scroll_top();k_remove_all_active();k_sticky_sidebar();k_category_post_count();k_set_hegiht_related();});$(window).load(function(){k_widget_recent_post_masonry();k_widget_instagram_masonry();k_blog_masonry();k_post_slider();k_cover_image();k_preloader();k_set_height();});$(window).resize(function(event){k_menu_resize();k_full_height_screen();k_set_height();}).trigger('resize');$(window).scroll(function(event){});})(jQuery);