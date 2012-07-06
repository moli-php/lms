var productClass = {
	discountList : [],
	arrayList : [],

	addClass : function(){
		var sUrl = common.getClassUrl("productClassAdd");
		location.href = sUrl;
	},
	
	validate : function(){
		var result = $("#productClassForm").validateForm();
	
		result = this.checkTime(result);

		$(".class_time").unbind("change").change(function(){
			productClass.checkTime(result);
		});	
		
		if (result === true){
			$("#productClassForm").ajaxSubmit({
				url : common.getClassUrl("productExecute"),
				dataType : "html",
				type : "post",
				data : {
					discountList : productClass.discountList
				},
				success : function(aData){
					if (aData == "1"){
						location.href = common.getClassUrl("productClass");
					} else {
						common.message('warning', "Saving failed!");
					}
				}
			});
		}
	},
	
	checkTime : function(result){
		var startHour = $("[name='starttime_hours']").val();
		var startMinute = $("[name='starttime_minutes']").val();
		var endHour = $("[name='endtime_hours']").val();
		var endMinute = $("[name='endtime_minutes']").val();
		var startTime = startHour + ":" + startMinute;
		var endTime = endHour + ":" + endMinute

		if (startTime >= endTime) {
			$(".class_time").addClass("error");
			result = false;
		} else {	
			$(".class_time").removeClass("error");
		}
		
		return result;
	},
	
	verifyDelete : function(){
		var count = 0;
        
        $("tbody input:checkbox").each(function(){
            if ($(this).is(":checked") === true){
                productClass.arrayList[count] = $(this).val();
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
							url : common.getClassUrl("productExecute"),
							dataType : "html",
							type : "post",
							data : {
								exec : "deleteClass",
								idxArrayList : productClass.arrayList
							},
							success : function(aData){
								location.href = common.getClassUrl("productClass");
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
	
	setRows : function(){
        var selected = 10;
        var sUrl = common.getClassUrl("productClass");
        
        switch ($("#show_rows option:selected").index()){
            case 1 : selected = 20; break;
            case 2 : selected = 50; break;
            default : selected = 10; break;
        }
        
        $.each(common.getUrlParameters(), function(key, val){
            if (key != "module" && key != "rows" && key != "page") sUrl += "&" + key + "=" + val;
        });
        
        if (selected == 10) location.href = sUrl;
        else location.href = sUrl + "&rows=" + selected;
    },

	checkAll : function(selector){
        if ($(selector).is(":checked") === true){
            $.browser.msie ? $("tbody:first input:checkbox").prop("checked", "checked") : $("tbody input:checkbox").attr("checked", "checked");
        }
        else {
            $.browser.msie ? $("tbody:first input:checkbox").removeProp("checked") : $("tbody input:checkbox").removeAttr("checked");
        }
    },
	
	searchData : function(){
		var days = $("[name='class_days']").val();
		var months = $("[name='class_months']").val();
		var country = $("[name='class_country']:checked").val();
		var type = $("[name='class_type']:checked").val();
		var keyword = $("#keyword").val();
        var sUrl = common.getClassUrl("productClass");
		
		if (months != undefined && months != "all")
			sUrl += "&months=" + months;
		if (days != undefined && days != "all")
			sUrl += "&days=" + days;
		if (type != undefined && type != "all")
			sUrl += "&type=" + type;
		if (country != undefined && country != "all")
			sUrl += "&country=" + country;
		
        location.href = sUrl + (keyword != "" ? ("&keyword=" + keyword) : "");
	}
};

$(document).ready(function(){
	$(".checkbox_list").shiftcheckbox();
	var count = 0;
	$(".discount_rule:checked").each(function(){
		productClass.discountList[count] = $(this).val();
		count++;
	});

	$("#search_button").click(function(){
		productClass.searchData();
	});
	
	$(".discount_rule").click(function(){
		var value = $(this).val();
		var newArray = productClass.discountList;
		if ($(this).is(":checked") === true){
			productClass.discountList.push(value);
		} else {
			productClass.discountList = [];
			count = 0;

			$.each(newArray, function(key, val){
				if (val != value) {
					productClass.discountList[count] = val;
					count++;
				}
			});	
		}
	});
	
	if ($.trim($(".menu_curpage_breadcrumb").text()) == ">"){
		var sClass = "productClass";
		var title = "Class" ;
		$("." + sClass).find("a").addClass("current");
		$(".menu_curpage_breadcrumb").html('> <a href="' + common.getClassUrl(sClass) + '">' + title + '</a>');
		$(".breadcrumb").append('<li>> ' + (common.getUrlParameter("action") == (sClass + "Add") ? "Add New" : "Edit") + ' ' + title + '</li>');
	}
});