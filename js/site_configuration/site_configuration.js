var sCity = "";
var sArea = "";
var iDate = new Date();
var iSec_char_max = 100;
var iUrl_char_max = 500;
var iOwner_char_max = 100;
var iCompanyn_char_max = 100;
var iCompanyr_char_max = 100;
var iFileName = iDate.getTime();

var site_configuration = {
		
		save : function(){
			var sNumber = $("[name=fphone_number]").val();
			var regex = /^\d{3}[-]\d{4}[-]\d{4}$/g;
			var result = $("[name=userAddForm]").validateForm();
			
			if(result == true && sNumber.match(regex)){
				$("[name=userAddForm]").ajaxSubmit({
					url :  "site_configuration/index.php?exec=saveConfig",
					dataType : "html",
					type : "POST",
					success : function(info){
						if(info){
							Menu.message("success", "Saved successfully");
							window.loaction.reload();
						}
					}
				});
			}
		},
		
		choose_address : function(){
			if($("#find_address_input").val() == ""){
				$("#find_address_input").css("border", "1px solid #FF0000");
			}else{
				var sKeyword = $("#find_address_input").val();
				var sHtml = "";
				$("#find_address_input").css("border", "1px solid #CCCCCC");
				$.ajax({
					url : "site_configuration/index.php",
					dataType : "json",
					data : "keyword=" + sKeyword + "&exec=find_address",
					type : "GET",
					success : function(info){
						if(info == ""){
							$(".error_msg").html("No results found.");
							$("#find_address_input").val("");
						}else{
							$(".error_msg").html("");
							$.each(info, function(key, val){
								sHtml += "<a id = '" + val.idx + "' style = 'width:190px'>" + val.fcity + " - " + val.farea + "</a>";
							});
							
							$("#sc_address_list").empty().append(sHtml);
							$("#find_address").fadeOut();
							$("#choose_address").fadeIn();
						}
						
					}
				});
			}
		},
		
		rest_address : function(){
			if(sCity == "" && sArea == ""){
				$(".error_msg").html("Please choose an address.");
			}else{
				$("#choose_address").fadeOut();
				$("#rest_address").fadeIn();
			}
		},
		
		final_address : function(){
			if($("#rest_address_input").val() == ""){
				$("#rest_address_input").css("border", "1px solid #FF0000");
			}else{
				$("#rest_address_input").css("border", "1px solid #CCCCCC");
				$("[name=faddress]").val($("#rest_address_input").val() + " " + sArea + ", " + sCity);
				$("#rest_address").fadeOut();
			}
		},
		
		uploadFile : function(){
			$("[name=userAddForm]").ajaxSubmit({
				url :  "site_configuration/upload.php",
				dataType : "html",
				type : "POST",
				success : function(info){
					if(info == "Invalid file type."){
						$("#ffile").val("");
						$(".sc_error").html(info);
					}else{
						$('#temp_img').val(info);
						$("#sc_img_prev").html("<img src = '"+common.getBaseUrl() +"/image.php?h=100&cr=4:1.60&path="+info+"' />");
						$(".sc_error").html("");
					}
				}
			});
		},
		
		validateNumber : function(){
			var sNumber = $("[name=fphone_number]").val();
			var regex = /^\d{3}[-]\d{4}[-]\d{4}$/g;
			if(!sNumber.match(regex)){
				$(".sc_num_error").html("Invalid phone number.");
				$("[name=fphone_number]").css("border", "1px solid #FF0000");
			}else{
				$(".sc_num_error").html("");
				$("[name=fphone_number]").css("border", "1px solid #CCCCCC");
			}
		}
}
//EVENT FUNCTIONS

$(".btn_find").click(function(){$("#find_address").fadeIn();});
$("#ffile").change(function(){site_configuration.uploadFile();});
$("#sc_form_submit").click(function(){site_configuration.save();});
$("#rest_address_submit").click(function(){site_configuration.final_address();});
$("[name=fphone_number]").blur(function(){site_configuration.validateNumber();});
$("#find_address_submit").click(function(){site_configuration.choose_address();});
$("#choose_address_submit").click(function(){site_configuration.rest_address();});
$("#find_address_cancel").click(function(){$("#find_address").fadeOut();})
$("#choose_address_cancel").click(function(){$("#choose_address").fadeOut();})
$("#rest_address_cancel").click(function(){$("#rest_address").fadeOut();})

$("#resetToDefault").click(function(){
	$("[name=fsite_url]").val("");
	$("[name=fsite_owner]").val("");
	$("[name=fcompany_name]").val("");
	$("[name=fcompany_reg_number]").val("");
	$("[name=fsecurity_manager]").val("");
	$("[name=fadmin_email]").val("");
	$("[name=faddress]").val("");
	$("[name=fphone_number]").val("");
	$("[name=finformation]").val("");
	$("[name=ftime_zone]").val("");
	$("[name=fpolicy]").val("");
});

$("#sc_address_list a").live("click", function(){
	$(".error_msg").html("");
	var sAddress = $(this).html();
	var aAddress = sAddress.split(" - ");
	$("#sc_address_list a").css({
		"background-color" : "",
		"color" : "#535353"
	});
	
	$(this).css({
		"background-color" : "#3399FF",
		"color" : "#FFFFFF"
	});
	sCity = aAddress[0];
	sArea = aAddress[1];
});


$("[name=fsite_url]").keyup(function(){
	var iMaxLimit = iUrl_char_max;
	var iChar = $("[name=fsite_url]").val().length;
	var iCharLeft = iMaxLimit - iChar;
	var url_pattern = new RegExp("((http|https)(:\/\/))?([a-zA-Z0-9]+[.]{1}){2}[a-zA-z0-9]+(\/{1}[a-zA-Z0-9]+)*\/?", "i");
	
	if(!$("[name=fsite_url]").val().match(url_pattern)){
		$("[name=fsite_url]").css("border", "1px solid #FF0000");
	}else{
		$("[name=fsite_url]").css("border", "1px solid #CCCCCC");
	}
	
	$("#url_char_max").html(iCharLeft);
}).blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=fsite_owner]").keyup(function(){
	var iMaxLimit = iOwner_char_max;
	var iChar = $("[name=fsite_owner]").val().length;
	var iCharLeft = iMaxLimit - iChar;
	var pattern = /^[a-zA-Z]+$/g;

	if(!$("[name=fsite_owner]").val().match(pattern)){
		$("[name=fsite_owner]").css("border", "1px solid #FF0000");
	}else{
		$("[name=fsite_owner]").css("border", "1px solid #CCCCCC");
	}
	$("#owner_char_max").html(iCharLeft);
}).blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=fcompany_name]").keyup(function(){
	var iMaxLimit = iCompanyn_char_max;
	var iChar = $("[name=fcompany_name]").val().length;
	var iCharLeft = iMaxLimit - iChar;
	
	$("#companyn_char_max").html(iCharLeft);
}).blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=fcompany_reg_number]").keyup(function(){
	var iMaxLimit = iCompanyr_char_max;
	var iChar = $("[name=fcompany_reg_number]").val().length;
	var iCharLeft = iMaxLimit - iChar;
	
	$("#companyr_char_max").html(iCharLeft);
}).blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=fsecurity_manager]").keyup(function(){
	var iMaxLimit = iSec_char_max;
	var iChar = $("[name=fsecurity_manager]").val().length;
	var iCharLeft = iMaxLimit - iChar;
	
	$("#sec_char_max").html(iCharLeft);
}).blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=fadmin_email]").blur(function(){
	var pattern = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
	
	if($(this).val() == "" || !$("[name=fadmin_email]").val().match(pattern)){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=faddress]").blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=finformation]").blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});

$("[name=ffile]").blur(function(){
	if($(this).val() == ""){$(this).html("No file is uploaded.");}
	else{$(this).html("");}
});

$("[name=fpolicy]").blur(function(){
	if($(this).val() == ""){$(this).css("border", "1px solid #FF0000");}
	else{$(this).css("border", "1px solid #CCCCCC");}
});


$(document).ready(function(){
	
	$('#temp_img').val("");
	$(".sc_error").html("");
	$("#find_address_input").val("");
	
	$.ajax({
		url : "site_configuration/index.php?exec=getSavedConfig",
		dataType : "json",
		data : "id=" + $("[name=sess_idx]").val(),
		type : "POST",
		success : function(info){
			$("[name=fsite_url]").val(info.fsite_url);
			$("[name=fsite_owner]").val(info.fsite_owner);
			$("[name=fcompany_name]").val(info.fcompany_name);
			$("[name=fcompany_reg_number]").val(info.fcompany_reg_number);
			$("[name=fsecurity_manager]").val(info.fsecurity_manager);
			$("[name=fadmin_email]").val(info.fadmin_email);
			$("[name=faddress]").val(info.faddress);
			$("[name=fphone_number]").val(info.fphone_number);
			$("[name=finformation]").val(info.finformation);
			$("[name=ftime_zone]").val(info.ftime_zone);
			$("[name=fpolicy]").val(info.fpolicy);
			$("#sc_img_prev").html("<img src = '"+common.getBaseUrl() +"/image.php?h=100&cr=4:1.60&path=" + info.ffile + "' />");
			
			$("#sec_char_max").html(iSec_char_max - info.fsecurity_manager.length);
			$("#url_char_max").html(iUrl_char_max - info.fsite_url.length);
			$("[name=globalFileName]").val(iFileName);
			$("#owner_char_max").html(iOwner_char_max - info.fsite_owner.length);
			$("#companyn_char_max").html(iCompanyn_char_max - info.fcompany_name.length);
			$("#companyr_char_max").html(iCompanyr_char_max - info.fcompany_reg_number.length);
		}
	});
	
	
	
	
});
