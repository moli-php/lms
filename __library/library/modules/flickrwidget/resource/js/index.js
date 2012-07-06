//jQuery.noConflict();
$(document).ready(function(){
	var tgt = $('#flickr_disp_target_hidden').val();
	var typ = $('#flickr_disp_type_hidden').val();
var pg_base = $('#flickr_plugin_dir_hidden2').val();

	if(tgt == 1) {
		$(function() {
			$('#pg_flickr_wrap1 a').lightBox();
		});
		//$("#pg_flickr_wrap1 a").fancybox();
	}

	if(typ == 1) {
		$(".pg_images_holder").jCarouselLite({
			btnNext: ".flickrwidget_next",
			btnPrev: ".flickrwidget_prev"
		});
	}
});

