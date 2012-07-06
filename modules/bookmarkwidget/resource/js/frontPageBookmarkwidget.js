$float_speed=1500; //milliseconds
$float_easing="easeOutQuint";
$menu_fade_speed=500; //milliseconds
$closed_menu_opacity=0.6;

//cache vars
$fl_slider_wrap_con=$("#fl_slider_wrap_con");
$fl_slider_wrap_con_slider=$("#fl_slider");



$(document).ready(function(){
    frontPageBookmarkwidget.FloatMenu();
	frontPageBookmarkwidget.getBookmark();
	menuPosition=50;
	$fl_slider_wrap_con.fadeTo($menu_fade_speed, $closed_menu_opacity);
	//$fl_slider_wrap_con_slider.height(364);
});

$('#bookmarkwidget_name').keyup( function() {
    var $this = $(this);
    if($this.val().length > 15)
        $this.val($this.val().substr(0, 15));           
}).keydown( function() {
    var $this = $(this);
    if($this.val().length > 15)
        $this.val($this.val().substr(0, 15));           
});

$("#fl_slider_wrap_con").hover(
	function(){ //mouse over
		$fl_slider_wrap_con.fadeTo($menu_fade_speed, 1);
	},
	function(){ //mouse out
		$fl_slider_wrap_con.fadeTo($menu_fade_speed, $closed_menu_opacity);
	}
);

$("#bookmarkwidget_list").hover(function(){
    $(this).find('li').hover(
            function(){
                $(this).find(".close_btn").show();
            },
            function(){
                $(this).find(".close_btn").hide();
            }
    );
});

$("#bookmark_nav").click(function(){
	if($("#bookmark_main").css("display") == "none"){
		$("#bookmark_main").show();
		//$("#bookmark_main").css("display", "block");
	}
	else{
		$("#bookmark_main").hide();
//		/$("#bookmark_main").css("display", "none");
	}
});

$(window).scroll(function () {
	frontPageBookmarkwidget.FloatMenu();
});

$("#bookmarkwidget_url").click(function(){
	if($("#bookmarkwidget_url").val() == 'URL here')
		$("#bookmarkwidget_url").val('http://');
});

$("#bookmarkwidget_name").click(function(){
	if($("#bookmarkwidget_name").val() == 'Name here')
		$("#bookmarkwidget_name").val('');
});

$("#bookmarkwidget_search").click(function(){
	if($("#bookmarkwidget_search").val() == 'Search..')
		$("#bookmarkwidget_search").val('');
});

$("#bookmarkwidget_button").click(function(){
	frontPageBookmarkwidget.addBookmark();
});

$("#bookmarkwidget_search").keyup(function(){
	bookmark_keyword = $("#bookmarkwidget_search").val();
	if(bookmark_keyword != ''){
		$("#bookmarkwidget_list").find("li").hide();
		bookmark_results = $("#bookmarkwidget_list").find("li a span:contains('" + bookmark_keyword + "')"); 
		offs = bookmark_results.length;
		if(offs != null && offs != undefined){
		    $("#bookmarkwidget_list").find("li:contains('" + bookmark_keyword + "')").show();
			$("#bookmarkwidget_list").scrollTop(offs.top + 1);
			$("#bookmarkwidget_list").find("li.errormessage").hide();
		}
		else
			$("#bookmarkwidget_list").find("li.errormessage").show();
	}
	else{
		$("#bookmarkwidget_list").find("li").show();
		$("#bookmarkwidget_list").find("li.errormessage").hide();
	}
});

var frontPageBookmarkwidget = {
	addBookmark : function(){
		if($("#bookmarkwidget_url").val() != '' || $("#bookmarkwidget_name").val() != ''){
			var urlregex = new RegExp("^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$");
			if(urlregex.test($("#bookmarkwidget_url").val())){ 
				$.ajax({ 
	                type: "post",  
	                url: usbuilder.getUrl("apiAddBookmark"),  
	                data: {"url" : $("#bookmarkwidget_url").val(), "name" : $("#bookmarkwidget_name").val()},
	                dataType: 'json'
	            }).done(function(bookmarks) {
		            if(bookmarks.Data == false)
		            	alert("already saved");
		            $("#bookmarkwidget_url").val('');
		            $("#bookmarkwidget_name").val('');
		            frontPageBookmarkwidget.getBookmark();
	            });
			} else { 
			    alert("invalid URL"); 
			} 
		}
		else{
			alert("Fill all fields");
		}
	},
	
	getBookmark : function(){
		var bookmark_list = '';
		$.ajax({ 
            type: "post",  
            url: usbuilder.getUrl("apiGetBookmark"),  
            data: {"get" : "all"},
            dataType: 'json',
			success : function(bookmarks){
				if(bookmarks.Data != null && bookmarks.Data != undefined){
					$.each(bookmarks.Data, function(i, v){
						bookmark_list += "<li><p><span class='close_btn'><a href='javascript: void(0);' onclick='javascript: frontPageBookmarkwidget.delBookmark(" + v['idx'] + ");'><img src='[IMG]/close_icon.gif'></a></span><a href='" + v['url'] + "' class='bookmark_links' target='_blank'>" + v['name'] + "</a></p><a href='" + v['url'] + "' class='big_icon big_icon_" + v['title'] + "' target='_blank'><span>" + v['title'] + "</span></a></li>";
					});
					bookmark_list += "<li class='errormessage' style='display: none;text-align: center;'>No Result</li>";
					$("#bookmarkwidget_list").html(bookmark_list);
				}
			}
		});
	},
	
	searchBookmark : function(){
		if($("#bookmarkwidget_search").val() != ''){
			
		}
		else{
			alert("empty");
		}
	},
	
	delBookmark : function(idx){
	    if(confirm("Are you sure you want to delete this bookmark?")){
            $.ajax({ 
                type: "post",  
                url: usbuilder.getUrl("apiDelBookmark"),  
                data: {"idx" : idx},
                dataType: 'json'
            }).done(function(bookmarks){
                frontPageBookmarkwidget.getBookmark();
            });
	    }
	},
	
	FloatMenu : function(){
		$fl_slider_wrap_con_slider.stop().animate({top: 50}, $float_speed, $float_easing);
	}
}