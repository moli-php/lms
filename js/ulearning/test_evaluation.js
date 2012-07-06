$('.check_all').click(function(){
	if($('.check_all').attr("checked"))
		$('.check').attr("checked","checked");
});
	
$('.page_rows').change(function(){
	window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_eval&page_rows="+$('.page_rows').val();
});

var test_evaluation = {
	back_to_list:function(){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_eval";
	},
	search:function(){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_eval&id="+$('#search_id').val()+"&course="+$('.course').val()+"&status="+$('.status').val();
	},
	manage:function(eid){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_eval&inner=eval_manage&eval_id="+eid;
	}
}