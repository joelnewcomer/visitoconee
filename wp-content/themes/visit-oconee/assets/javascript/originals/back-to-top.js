/**
 * Back To Top - CodyHouse
 * http://codyhouse.co/gem/back-to-top/
 */
jQuery(document).ready(function($){var offset=300,offset_opacity=1200,scroll_top_duration=700,$back_to_top=jQuery('.cd-top');jQuery(window).scroll(function(){(jQuery(this).scrollTop()>offset)?$back_to_top.addClass('cd-is-visible'):$back_to_top.removeClass('cd-is-visible cd-fade-out');if(jQuery(this).scrollTop()>offset_opacity){$back_to_top.addClass('cd-fade-out')}});$back_to_top.on('click',function(event){event.preventDefault();jQuery('body,html').animate({scrollTop:0,},scroll_top_duration)})});
