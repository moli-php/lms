var productDiscount  = {
	arrayList : [],

	addDiscount : function(){
		var sUrl = common.getClassUrl("productDiscountRulesAdd");
		location.href = sUrl;
	},
	
	validate : function(){
		var result = $("#discount_form").validateForm();	
		
		if (result === true) {
			$("#discount_form").ajaxSubmit({
				url : common.getClassUrl("productExecute"),
				dataType : "html",
				success : function(aData){
					if (aData == 1)
						location.href = common.getClassUrl("productDiscountRules");
					else
						location.href = common.getCurrentUrl();
				}
			});
		}
	},
	
	verifyDelete : function(){
		var count = 0;
        
        $("tbody input:checkbox").each(function(){
            if ($(this).is(":checked") === true){
                productDiscount.arrayList[count] = $(this).val();
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
								exec : "deleteDiscount",
								idxArrayList : productDiscount.arrayList
							},
							success : function(aData){
								location.href = common.getClassUrl("productDiscountRules");
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
	
	checkAll : function(selector){
        if ($(selector).is(":checked") === true){
            $.browser.msie ? $("tbody:first input:checkbox").prop("checked", "checked") : $("tbody input:checkbox").attr("checked", "checked");
        }
        else {
            $.browser.msie ? $("tbody:first input:checkbox").removeProp("checked") : $("tbody input:checkbox").removeAttr("checked");
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
	
	confirmDelete : function(){
		var count = 0;
        
        $("tbody:first input:checkbox").each(function(){
            if ($(this).is(":checked") === true){
                adminPageContents.arrayList[count] = $(this).val();
                count++;
            }
        });

        if (count > 0){
            $(".totalDelete").text(count);
			
			$("#discount_dialog").dialog({
			
			});       
        }
	}
};

$(document).ready(function(){
	if ($.trim($(".menu_curpage_breadcrumb").text()) == ">"){
		var sClass = "productDiscountRules";
		var title = "Discount Rules" ;
		$("." + sClass).find("a").addClass("current");
		$(".menu_curpage_breadcrumb").html('> <a href="' + common.getClassUrl(sClass) + '">' + title + '</a>');
		$(".breadcrumb").append('<li>> ' + (common.getUrlParameter("action") == (sClass + "Add") ? "Add New" : "Edit") + ' ' + title + '</li>');
	}
});