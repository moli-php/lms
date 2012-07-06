var productCourse = {
    addCourse : function(){
        var sUrl = common.getClassUrl("productCourseAdd");
        location.href = sUrl;
    },
    
    backToCourse : function(){
        var sUrl = common.getClassUrl("productCourse")+"&page="+$('#curr_page').val();
        location.href = sUrl;
    },
    
    deleteCourse : function(){
        var has_check = $("input[name=checkbox_course]");
        var check_box =has_check.filter(':checked').length;
        
        if(check_box <=0){
            Menu.message('warning', 'Please select the course(s) you want to delete.');
        } else {
            $('#popup_delete').fadeIn();
        }
    },
    
    saveCourse : function(){
        var result = $("#form_course").validateForm();
        if (result === true){
            var sUrl = common.getClassUrl("productExecute");
            var name = $('#name').val();
            var desc = $('#description').val();
            var idx = $('#idx').val() != "" ? $('#idx').val() : "none";
  
            $.ajax({
                url : sUrl,
                type : "GET",
                dataType : "JSON",
                data : "exec=saveCourse&name="+name+"&description="+desc+"&idx="+idx,
                success : function(response){
                    if(response !=0){
                        $("#form_course").resetForm();
                        if(idx== "none"){
                            Menu.message('success', "Successfully Saved");
                        } else {
                            Menu.message('success', "Course has been updated");
                        }
                        setTimeout(function(){
                            productCourse.backToCourse();
                        }, 500);
                    }
                }
            });
        } else {
			Menu.message('warning', "Please fill out the required fields");
		}
    },
    
    searchCourse : function(){
        var keyword = $("input[name='search_course']").val();
        var sUrl = common.getClassUrl("productCourse"); 
        window.location.href = sUrl+"&keyword="+keyword; 
    },
    
    execDelete : function(){
        var sUrl = common.getClassUrl("productExecute");
        var iNum = 0;            
        var iIdx = new Array();
        $("input[name='checkbox_course']:checked").each(function(){
            iIdx[iNum] = $(this).val();
            iNum++;
        });
        
        $.ajax({
            url : sUrl,
            type : "GET",
            dataType : "JSON",
            data : "exec=deleteCourse&idx="+iIdx,
            success : function(response){
                if(response !=0){                        
                    Menu.message('success', "Deleted Successfully");
                    $('#popup_delete').fadeOut();
                    setTimeout(function(){
                        window.location.href = window.location.href;
                    },500);                        
                }
           }
        });        
    },
    
    closePopup : function(){
        $('#popup_delete').fadeOut();
        $("input[name='checkbox_course']").each(function(){
            $(this).attr('checked', false)
        });
        $('#check_all').attr('checked', false);
    }
    
};

$(document).ready(function(){
    $('#btn_search_course').click(function(){
        productCourse.searchCourse();
    });
    
    $('#btn_course').click(function(){
        productCourse.saveCourse();
    });
    
    $('#btn_back').click(function(){
        productCourse.backToCourse();
    });   
    
    $('#cancel_del').click(function(){
        productCourse.closePopup();
    });  
    
    $('.popup_close').click(function(){
        productCourse.closePopup();
    });  
    
    $('#delete_del').click(function(){
        productCourse.execDelete();
    });  
});
