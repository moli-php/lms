var classLevelTest = {
	currentDate : "",
	arrayList : [],
	
	mostAction : function(){
		location.href = common.getClassUrl("classLevelTestAdd");
	},
	
	validate : function(){
		var result = $("#classLevelForm").validateForm();
		
		var startDate = new Date(classLevelTest.currentDate);
		var endDate = new Date($("#desired_period").val());
		if (startDate >= endDate){
			result = false;
			$("#desired_period").addClass("error");
		} else
			$("#desired_period").removeClass("error");

		if (result === true){
			$("#classLevelForm").ajaxSubmit({
				url : common.getClassUrl("classExecute"),
				dataType : "html",
				success : function(aData){
					if (aData == 1)
						location.href = common.getClassUrl("classLevelTest");
					else
						location.href = common.getCurrentUrl();
				}
			});
		}
	},
	
	checkAll : function(selector){
        if ($(selector).is(":checked") === true){
            $.browser.msie ? $("tbody:first input:checkbox").prop("checked", "checked") : $("tbody input:checkbox").attr("checked", "checked");
        }
        else {
            $.browser.msie ? $("tbody:first input:checkbox").removeProp("checked") : $("tbody input:checkbox").removeAttr("checked");
        }
    },
	
	verifyDelete : function(){
		var count = 0;
        
        $("tbody input:checkbox").each(function(){
            if ($(this).is(":checked") === true){
                classLevelTest.arrayList[count] = $(this).val();
                count++;
            }
        });
        if (count > 0){
            common.createDialog("verifyDelete", "Are you sure you wan't to delete this " + count + " item(s)?")
			
			$("#verifyDelete").dialog({
				modal: common.dialogModal,
				resizable: common.dialogResizable,
				draggable: common.dialogDraggable,
				closeOnEscape: common.dialogCloseOnEscape,
				buttons : {
					Yes : function(){
						$.ajax({
							url : common.getClassUrl("classExecute"),
							dataType : "html",
							type : "post",
							data : {
								exec : "deleteLevelTest",
								idxArrayList : classLevelTest.arrayList
							},
							success : function(aData){
								alert(aData);
								// location.href = common.getClassUrl("classLevelTest");
							}
						});
					},
					No : function(){
						$(this).dialog("close");
					}
				}
			})
        }
        else {
            common.message('warning', "Please make a selection from the list.");
        }
	},
	
	search : function(){
		var sUrl = common.getClassUrl("classLevelTest");
		var count = 0;
		
		$.each(common.getUrlParameters(), function(key, val){
            if (key != "action" && key != "rows" && key != "page" && key != "name" && key != "startdate" && key != "enddate" && key != "teacheridx" && key != "keyword") sUrl += "&" + key + "=" + val;
        });
		
		if ($("#start_period").val() != ""){
			sUrl += "&startdate=" + $("#start_period").val();
			count++;
		}	
		if ($("#end_period").val() != ""){
			sUrl += "&enddate=" + $("#end_period").val();
			count++;
		}
		if ($("#teacher_option").val() != "Teacher"){
			sUrl += "&teacheridx=" + $("#teacher_option").val();
			count++;
		}
		if ($("#user_name").val() != ""){
			sUrl += "&keyword=" + $("#user_name").val();
			count++;
		}
		
		if (count != 0)
			location.href = sUrl;
	},
	
	setRows : function(){
        var selected = 10;
        var sUrl = common.getClassUrl("classLevelTest");
        
        switch ($("#show_rows option:selected").index()){
            case 1 : selected = 20; break;
            case 2 : selected = 50; break;
            default : selected = 10; break;
        }
        
        $.each(common.getUrlParameters(), function(key, val){
            if (key != "row" && key != "page") sUrl += "&" + key + "=" + val;
        });
        
        if (selected == 10) location.href = sUrl;
        else location.href = sUrl + "&row=" + selected;
    },
};

$(document).ready(function(){
	classLevelTest.currentDate = $("#current_date").val();
	$("#current_date").remove();
	
	$(".verify_popup_btn").click(function(){
		$("#verify_popup_window").dialog({
			modal: common.dialogModal,
			resizable: common.dialogResizable,
			draggable: common.dialogDraggable,
			closeOnEscape: common.dialogCloseOnEscape,
			title : "Verify ID",
			buttons : {
				Submit : function(){
					var value = $.trim($("#verify_popup_text").val());
					$.ajax({
						url : common.getClassUrl("classExecute"),
						dataType : "json",
						data : {
							exec : "getUserData",
							search : value
						},
						success : function(aData){
							if (aData != false){
								$("#verify_popup_window").dialog("close");
								$("#verify_popup_text").val("");
								$(".user_id").text(aData.name);
								$("#verify_popup_result").dialog({
									modal: common.dialogModal,
									resizable: common.dialogResizable,
									draggable: common.dialogDraggable,
									closeOnEscape: common.dialogCloseOnEscape,
									title : "Verify ID",
									buttons : {
										Submit : function(){
											$("[name='studentidx']").val(aData.idx);
											$("#userID").val(value);
											$(this).dialog("close");
										}
									}
								});
							}
						}
					});
				}
			}
		});
	});
	
	$("#desired_period, #start_period, #end_period").datepicker({
		dateFormat : 'yy-mm-dd',
		constrainInput: true,
        showOn: 'button',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'
	}).click(function(){
		$(this).datepicker("show");
	});
	
	if ($.trim($(".menu_curpage_breadcrumb").text()) == ">"){
		var sClass = "classLevelTest";
		var title = "Level Test" ;
		$("." + sClass).find("a").addClass("current");
		$(".menu_curpage_breadcrumb").html('> <a href="' + common.getClassUrl(sClass) + '">' + title + '</a>');
		$(".breadcrumb").append('<li>> ' + (common.getUrlParameter("action") == (sClass + "Add") ? "Add New" : "Edit") + ' ' + title + '</li>');
	}
});