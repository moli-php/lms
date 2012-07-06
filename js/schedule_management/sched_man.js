$(document).ready(function(){
	$(".calendar_icon, .choosedate").datepicker({
		showOn: "both",
		buttonImage: "/images/icons/calendar-day.png",
		buttonImageOnly: true
	});
	
	
	// $("#previous_btn").change(function(){
	
		 // $("#date_picker").datepicker( 'setDate' , "-1 day" );

		 // var date = new Date( Date.parse( this.value ) );
		 // date.setDate( date.getDate() + 1 );
		 // $("#date_picker").val(date.getDate()+'/'date.getMonth()+'/'+date.getFullYear()); 
	// }).datepicker();
	// $("#date_picker").datepicker();
});

var LMS = {
	goTo : function(){
		// var a = $("#date_picker").val();
		// $(".date").html(a);
		var date = new Date( Date.parse( this.value ) );
	alert(date.getDate()); 
	}
}