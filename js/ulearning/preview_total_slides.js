var preview_total_slides = {
	view_slides:function(id,offset){
		window.open(common.getBaseUrl()+"/admin/ulearning/?action=preview_total_slides&unit_id="+id+"&offset="+offset,"mywindow","width=1000,height=700,resizable=no,scrollbars=no");
	},
	next_slide:function(id,offset){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=preview_total_slides&unit_id="+id+"&offset="+offset;
	}
}