var admin_visitor = function()
{
	var visitor_url = $("#visitor_url").val();
	
	function search()
	{
		var branch = $("#branch");
		var start_date = $("#start_date");
		var end_date = $("#end_date");
		var bvalidate = $(".search_form").validateForm();
		var  branch_qry = (branch.val()) ? '&b=' + branch.val() : "";
		
		var month_range = (monthNumRange(start_date.val(),end_date.val()));
		$('.error_range').hide();
		if(month_range>=3)
		{
			$('.error_range').show();
		}

		if(bvalidate===true && month_range<=2)
		{
			window.location.href = visitor_url + branch_qry + "&start_date=" + start_date.val() + "&end_date=" + end_date.val();
		}		 
	}
	
	function load_events()
	{
		$(".start_date,.end_date").datepicker();	

		$('.search_btn').click(function(){
			search();
		});		
	}
	
	function monthNumRange(firstDate, secondDate) {
		var firstDate = new Date(firstDate);
		var secondDate = new Date(secondDate);
		var fm = firstDate.getMonth();
		var fy = firstDate.getFullYear();
		var sm = secondDate.getMonth();
		var sy = secondDate.getFullYear();
		var months = Math.abs(((fy - sy) * 12) + fm - sm);
		var firstBefore = firstDate > secondDate;
		firstDate.setFullYear(sy);
		firstDate.setMonth(sm);
		firstBefore ? firstDate < secondDate ? months-- : "" : secondDate < firstDate ? months-- : "";
		return months;
	}
	
	
	return{
		load_events : load_events
	}
}();

jQuery(document).ready(function(){
	admin_visitor.load_events();
});