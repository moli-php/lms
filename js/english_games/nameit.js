var nameit = function()
{
	var choices_array = [];
	function _add()
	{
		choices_array.splice(0,choices_array.length);
		$('.add-choices').show();
		$(".existing-choice").hide();
		$(".choices-box").css({"border":"solid 1px #CCC"}).val('')
		$(".choices-list").html('<span style="color:#DC4E22;text-align:center;display:block">-No Choices-</span>');
		$(".add-dialog").dialog({
			title :  "Add Question &raquo;",
			width : 650,
			modal : true
		})
	}
	
	function _save()
	{
		var picture = $("#picture");
		var question = $("#question");		
	}
	
	function _preview()
	{
		var question = $("#question").val();
		var shtml = "";
		$(".prev-question-title").html(question);
		if(choices_array.length > 0 )
		{		
			$.each(choices_array,function(index,value){
				shtml += '<li><input type="radio" />' + value + '</li>';
			});			
		}
		$(".prev-choice-list").html(shtml);
		$(".preview-dialog").dialog({
			title : "Question Preview &raquo;",
			width : 700
		});

	}
	
	function _delete_choices(element)
	{
		var choice_value = $(element).parent().parent().find("input[type='radio']").val();
		var position;
		
		$.each(choices_array,function(index,value){
			if(choice_value==value) position = index;
		});
		
		choices_array.splice(position,1);
		
		if(choices_array.length<5) $('.add-choices').show()
		
		$(element).parent().parent().remove();
		
		if(choices_array.length == 0 ) $(".choices-list").html('<span style="color:#DC4E22;text-align:center;display:block">-No Choices-</span>');	 
		
	}
	
	function _add_choices(element)
	{
		var choices_box = $(".choices-box");
		
		var shtml = "";
		choices_box.css({"border":"solid 1px #ccc"});
		$(".existing-choice").hide();
		
		if($.trim(choices_box.val())==""){choices_box.css({"border":"solid 1px #DC4E22"}); return false;}
		
		$.each(choices_array,function(index,value){
			if(choices_box.val() == value)
			{
				$(".existing-choice").show();
				exit()
			}
		});	
		
		if(choices_array.length < 5 ) choices_array.push(choices_box.val());
		
		if(choices_array.length > 4 ) $(element).hide();
		
		if(choices_array.length > 0 )
		{		
			
			$.each(choices_array,function(index,value){
				shtml += '<span class="nameit-choices"><input type="radio" name="choices" value="' + value + '"/> <label for="choices" class="choice-label">'+ value +' | <a href="javascript:void(0)" class="choices-link">delete</a></label></span>';
			});			
			
		}
		choices_box.val('').focus();
		$(".choices-list").html(shtml)
	}
	
	function load_events()
	{
		$(".save-btn").click(function(){
			_save();
		});
		
		$(".add-choices").click(function(){			
			_add_choices(this);
		});
		
		$(".choices-link").live('click',function(){
			_delete_choices(this);
		});
		
		$(".preview-btn").click(function(){
			_preview();
		});
	}
	
	function close_dialog(element)
	{
		element.dialog("close");
	}
	return{
		load_events : load_events,
		close_dialog : close_dialog,
		add : _add
	}	
}();

jQuery(document).ready(function($){
	nameit.load_events();
});