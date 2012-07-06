var admin_sales = function()
{
	var sales_url = $("#sales_url").val();
	
	function search()
	{
		var branch = $("#branch");
		var start_date = $("#start_date");
		var end_date = $("#end_date");
		var bvalidate = $(".search_form").validateForm();
		var  branch_qry = (branch.val()) ? '&b=' + branch.val() : "";

		if(bvalidate===true)
		{
			window.location.href = sales_url + branch_qry + "&start_date=" + start_date.val() + "&end_date=" + end_date.val();
		}		 
	}
	
	function load_events()
	{
		$(".start_date,.end_date").datepicker();
		
		
		$('.test_dialog').click(function(){
			var shtml = '<div class="d">asdsadasd</div>';
			$('.area').html(shtml);
			
			$('.d').dialog();
		});
		
		$('.search_btn').click(function(){
			search();
		});
	}
	
	return{
		load_events : load_events
	}
}();

jQuery(document).ready(function(){
	admin_sales.load_events();
	common.adviseMessage($('.test_link'));
});