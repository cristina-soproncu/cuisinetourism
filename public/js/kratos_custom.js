;(function($){"use strict";if(typeof wilokeInitPhotoSwipeFromDOM=='undefined')
{window.wilokeInitPhotoSwipeFromDOM=function(gallerySelector){var parseThumbnailElements=function(el){var thumbElements=el.childNodes,numNodes=thumbElements.length,items=[],linkEl,size,item;for(var i=0;i<numNodes;i++){if(thumbElements[i].tagName.toUpperCase()==='A'){linkEl=thumbElements[i];if(linkEl.nodeType!==1){continue;}
size=linkEl.getAttribute('data-size').split('x');item={src:linkEl.getAttribute('href'),w:parseInt(size[0],10),h:parseInt(size[1],10)};if(linkEl.getAttribute('data-caption')){item.title=linkEl.getAttribute('data-caption');}
if(linkEl.children.length>0){item.msrc=linkEl.children[0].getAttribute('src');}
item.el=linkEl;items.push(item);}}
return items;};var closest=function closest(el,fn){return el&&(fn(el)?el:closest(el.parentNode,fn));};var onThumbnailsClick=function(e){e=e||window.event;e.preventDefault?e.preventDefault():e.returnValue=false;var eTarget=e.target||e.srcElement;var clickedListItem=closest(eTarget,function(el){return(el.tagName&&el.tagName.toUpperCase()==='A');});if(!clickedListItem){return;}
var clickedGallery=clickedListItem.parentNode,childNodes=clickedListItem.parentNode.childNodes,numChildNodes=childNodes.length,nodeIndex=0,index;for(var i=0;i<numChildNodes;i++){if(childNodes[i].nodeType!==1){continue;}
if(childNodes[i]===clickedListItem){index=nodeIndex;break;}
nodeIndex++;}
if(index>=0){openPhotoSwipe(index,clickedGallery);}
return false;};var photoswipeParseHash=function(){var hash=window.location.hash.substring(1),params={};if(hash.length<5){return params;}
var vars=hash.split('&');for(var i=0;i<vars.length;i++){if(!vars[i]){continue;}
var pair=vars[i].split('=');if(pair.length<2){continue;}
params[pair[0]]=pair[1];}
if(params.gid){params.gid=parseInt(params.gid,10);}
return params;};var openPhotoSwipe=function(index,galleryElement,disableAnimation,fromURL){var pswpElement=document.querySelectorAll('.wiloke-pswp-ui')[0],gallery,options,items;items=parseThumbnailElements(galleryElement);options={galleryUID:galleryElement.getAttribute('data-pswp-uid'),getThumbBoundsFn:function(index){var thumbnail=items[index].el.getElementsByTagName('img')[0],pageYScroll=window.pageYOffset||document.documentElement.scrollTop,rect=thumbnail.getBoundingClientRect();return{x:rect.left,y:rect.top+ pageYScroll,w:rect.width};}};if(fromURL){if(options.galleryPIDs){for(var j=0;j<items.length;j++){if(items[j].pid==index){options.index=j;break;}}}else{options.index=parseInt(index,10)- 1;}}else{options.index=parseInt(index,10);}
if(isNaN(options.index)){return;}
if(disableAnimation){options.showAnimationDuration=0;}
gallery=new PhotoSwipe(pswpElement,PhotoSwipeUI_Default,items,options);gallery.init();};var galleryElements=document.querySelectorAll(gallerySelector);for(var i=0,l=galleryElements.length;i<l;i++){galleryElements[i].setAttribute('data-pswp-uid',i+ 1);galleryElements[i].onclick=onThumbnailsClick;}
var hashData=photoswipeParseHash();if(hashData.pid&&hashData.gid){openPhotoSwipe(hashData.pid,galleryElements[hashData.gid- 1],true,true);}};}
$.fn.WilokeInstagramTemplate=function(){var $self=$(this),$loadmore=$('#k-loadmore'),_oInfo=$self.data('info'),_accessToken=$self.data('accesstoken'),_template='<div class="just-appended grid-item"><div class="instagram-item"><a class="img" href="{{link}}"><img src="{{image}}" /></a><span class="instagram-inner"><span class="box"><a href="'+PI_OB.ajaxurl+'?action=instagrampopup&amp;id={{id}}&amp;access_token='+_accessToken+'&amp;user_id='+_oInfo.user_id+'" class="view-more item"><i class="fa fa-search"></i></a><a href="{{link}}" class="view-link" target="_blank"><i class="fa fa-link"></i></a></span></span></div></div>',_owilokeInstagram={};$loadmore.on('click',function(event){event.preventDefault();feed.next();});var feed=new Instafeed({get:_oInfo.type,accessToken:_accessToken,userId:_oInfo.user_id,resolution:'standard_resolution',tagName:_oInfo.tagname,locationId:_oInfo.locationid,template:_template,after:function(a){$('.instagram-item .img').each(function(){var $this=$(this),src=$('img',this).attr('src'),image=new Image();image.src=src;image.onload=function(){if(!$this.data('isCover')){$this.imageCover();}};});$('.grid-item').removeClass('just-appended');if(!this.hasNext()){$loadmore.remove();}
if(!$loadmore.length)
return;var inview=new Waypoint.Inview({element:$loadmore[0],enter:function(direction){if(!$loadmore.data('disable'))
{$loadmore.trigger('click');$loadmore.data('disable',true);}},entered:function(direction){},exit:function(direction){$loadmore.data('disable',false);},exited:function(direction){}});$("#instafeed .view-more").magnificPopup({type:'ajax',callbacks:{ajaxContentAdded:function(){var $popup=$('.instagram-popup'),$image=$('.instagram-popup-media',$popup),src=$('img',$image).attr('src'),image=new Image();image.src=src;image.onload=function(){$image.imageCover();}}}});}});feed.run();};function wilokeInstagramPopup()
{$(".pi-magnific-popup.gallery-instagram a.item").magnificPopup({type:'ajax',callbacks:{ajaxContentAdded:function(){var $popup=$('.instagram-popup'),$image=$('.instagram-popup-media',$popup),src=$('img',$image).attr('src'),image=new Image();image.src=src;image.onload=function(){$image.imageCover();}}}});}
function wilokeThemeAjaxMagnific()
{$('.wiloke-magnific-ajax').magnificPopup({type:'ajax',callbacks:{ajaxContentAdded:function(){if($(this.content).find('.wiloke-tiled-gallery').length>0)
{var $kratosGallery=$(this.content).find('.wiloke-tiled-gallery');$kratosGallery.wrap('<div class="tiled-gallery-row"></div>');$kratosGallery.imagesLoaded(function(){$kratosGallery.justifiedGallery({rowHeight:'150px',lastRow:'justify',margins:0});});}else{var $kratosSlider=$(this.content).find('.post-slider');$kratosSlider.imagesLoaded(function(){$kratosSlider.owlCarousel({items:1,autoHeight:true,pagination:false,navigation:true,navigationText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']});});}}}});}
$(document).ready(function(){if($('.pswp.wiloke-is-theme').length)
{wilokeInitPhotoSwipeFromDOM('.pi-pswp');}
if($("#instafeed").length)
{$('#instafeed').WilokeInstagramTemplate();}
wilokeInstagramPopup();wilokeThemeAjaxMagnific();})})(jQuery);