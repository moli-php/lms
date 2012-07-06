$(document).ready(function() {
    $("#accordion").accordion();
});
  
  
var movie_category = {
	open:function(){
		$('.depth1').find('option:first').attr('selected', 'selected').parent('select');
		$('.add_material').fadeIn();

	},
	close:function(){
		$('.add_material').fadeOut();
	},
	depth1:function(me){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'depth1',fcategory_id:$(me).val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth2').empty();
				$.each(obj, function(k,v){
					$('.depth2').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	},
	save:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'addMaterial',fcategory_id:$('.depth2').val(),ftitle:$('.material_title').val()},
			type : "GET",
			success : function(data){
				window.location.reload(true);
				v
			}
		});
	}
}