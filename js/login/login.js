// Global variables
var gLogin	= {
	rootUrl: common.getBaseUrl()
}

$(function(){
	$('input[name="loginBtn"]').click(function(){
		var data		= $('form[name="loginForm"]').serialize();
		var validate	= $('form[name="loginForm"]').validateForm();
		
		if(validate == true){
			$.ajax({  
				type: "POST",
				url: gLogin.rootUrl+'/admin/login/controller/index.php',
				dataType: 'json',
				data: 'action=login&'+data,
				success: function(response){
					if(response[0] !== false){
						if(response[0]['grade_idx'] == 9 || response[0]['grade_idx'] == 8){
							 window.location.replace(gLogin.rootUrl+'/admin/dashboard'); 
						}else if(response[0]['grade_idx'] == 7 || response[0]['grade_idx'] == 6){
							window.location.replace(gLogin.rootUrl+'/admin/schedule'); 
						}
						
					}else{
						alert('User do not exist!');
					}				
				}
			});
		}		
		
		return false;
	});		
});