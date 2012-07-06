$(function(){ 
	/*get action*/
	var menu_action = $("#menu_action").val();
	
	if(menu_action){
		$("."+menu_action+" a").addClass("current");
		$(".menu_curpage_breadcrumb").html("&gt;&nbsp;<a href='"+$(".side_menu .current").attr('href')+"' >"+$(".side_menu .current").text()+'</a>');
		$(".menu_title_breadcrumb").html($(".side_menu .current").text());
	}else{
		$(".side_menu").find("li a:first").addClass("current");
		$(".menu_curpage_breadcrumb").html("&gt;&nbsp;<a href='"+$(".side_menu").find("li a:first").attr('href')+"' >"+$(".side_menu").find("li a:first").text()+'</a>');
		//$(".menu_curpage_breadcrumb").html("&gt;&nbsp;"+$(".side_menu").find("li a:first").text());
		$(".menu_title_breadcrumb").html($(".side_menu").find("li a:first").text());
	}
	
	/*side bar*/
	$(".side_opener").click(function(){
		$(".side_opener").css("display","none");
		$(".side_opener2").css({"display":"block","left":"3px"});
		$(".wrap").css("width","97%");
		$(".aside").css("margin-left","-175px");
		return false;
	});
	$(".side_opener2").click(function(){
		$(".side_opener2").css("display","none");
		$(".side_opener").css({"display":"block","left":"178px"});
		$(".wrap").css("width","85%");
		$(".aside").css("margin-left","0");
		return false;
	});
	
	$(window).bind("resize.footer", function(){
		$("#footer").css("width",$(".container_wrap").width());
	});

	$("#container").css({"min-height":$(window).height() - 141});
	$(".aside").css({"height":$("#container").height()}); //controls height of sideba

	
	
	//check all for delete
	$(".check_all").click(function(){
		var checked_all = $("input[type='checkbox']");
		if($('.check_all').attr('checked')) {
            checked_all.attr('checked', true);
        } else {
            checked_all.attr('checked', false);
        }
	});
});


var Menu = {
	/*capitalized first letter*/
	ucwords: function (str) {
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
			return $1.toUpperCase();
		});
	},
	
	/*message*/
	message: function(data,label, reload){
		if(data == 'success')	
			var mess = '<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center;"> <p style="display:inline-block;"><span class="ui-icon ui-icon-info" style="float: left;margin-right:5px;"></span>'+label+'.</p></div></div>';
		if(data == 'warning')	
			var mess = '<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-error ui-corner-all" style="padding: 7px;text-align:center;">  <p style="display:inline-block;"><span class="ui-icon ui-icon-alert" style="float: left;margin-right:5px;"></span>'+label+'</p></div></div>';
		$('#message_wrap_con').html(mess);
		Menu.animateMessage(reload);
	},
	
	animateMessage: function(reload)
	{
		if($('#message_wrap_con').html() != '')
		{
			$("#message_con").fadeOut(4000);
			if(reload != undefined)
				setTimeout("window.location.href = (\'"+reload+"\');", 4000);
		}
	}
};

;(function($){
	$.fn.menuAnimate = function(object, callback){
		var settings = {
			delay : 0,
			prev : ".btn_prev .btn_nav",
			next : ".btn_next .btn_nav"
		}
	
		if (typeof object == "object") settings = $.extend(settings, object);
	
		var TopMenu = {
			_aItems : $("._tmenuitem_lv1"),
			_iIndexFirst : 0,
			_iSize : 0,
			_bOnSliding : false,
			ITEM_WIDTH : 185,
			KEEPER_COOKIE_KEY : "top_menu_keeper",

			init : function() {
				var self = this;
				// set first-index if saved index is exist
				var iSavedIndexFirst = $.cookie(TopMenu.KEEPER_COOKIE_KEY);
				if(iSavedIndexFirst) {
					iSavedIndexFirst = parseInt(iSavedIndexFirst);
					TopMenu._iIndexFirst = iSavedIndexFirst;
					$("._tmenuarea_lv1").css({
						marginLeft : TopMenu._getSliderLeft(iSavedIndexFirst)
					});
				}
				
				// set fold effect on menus
				//TopMenu.setFoldEffect();
				
				// set slide effect on buttons
				TopMenu.setSlideEffect();
				
				// set resize
				TopMenu.resize(true);
				$(window).resize(function() {
					self._setShowMenuDefault('', true);
					
					TopMenu.resize(false);
				});
			},

			resize : function(bSkipAnimation) {
				if(TopMenu._bOnSliding) return;  // skip onresize process if on sliding
				
				// set item count
				TopMenu._iSize = TopMenu._getAvailableItemCount();
				
				// set display
				//TopMenu.setItemDisplay(bSkipAnimation);
				
				
			},

			setItemDisplay : function(bSkipAnimation) {
				
				// get index of last element on current page
				var iIndexLast = TopMenu._iIndexFirst + TopMenu._iSize;
			   
				var bNoMoreLeft = (TopMenu._iIndexFirst == 0);
				var bNoMoreRight = (iIndexLast >= TopMenu._aItems.size());
				
				if(bNoMoreRight) iIndexLast = TopMenu._aItems.size()-1;
				
				this._bindMouseOver(TopMenu._iIndexFirst, iIndexLast);
				
				this.foldMenu(iIndexLast, bSkipAnimation);
				
				// set slide button hover
				TopMenu.setSlideButtonHover(bNoMoreLeft, bNoMoreRight);
				
		        if(TopMenu._iIndexFirst != iIndexLast){
					if($('._last_menu_item').hasClass('_selected')){
						this.showPrevOrNextItem(false, 'Right', 1);
						this._setShowMenuDefault('Right', true);
					}
		        }
			   
			},

			foldMenu : function(iIndexLast, bSkipAnimation) {
			  // get item elements
			  iCount = this._getAvailableItemCount();

			  var eLastItem = TopMenu._aItems.eq(iIndexLast);
			  var ePrevItems = eLastItem.prevAll("._tmenuitem_lv1").addClass('_prev_all');
			  var eNextItems = eLastItem.nextAll("._tmenuitem_lv1");

			  // set display
			  if(bSkipAnimation) {
				  eLastItem.show();
				  ePrevItems.show();  // show all items on left side & current
				  eNextItems.hide();  // hide all items on right side
			  }
			  else {
				  eLastItem.fadeIn("normal");
				  ePrevItems.fadeIn("normal");  // show all items on left side & current
				  eNextItems.fadeOut("normal");  // hide all items on right side
			  }
			},

			_sShowMenu : 'Left',
			_bMoveBoth : false,
			_setShowMenuDefault : function(sMenu, bMove){
				if(!sMenu){
					sMenu = 'Left';
				}
				
				this._bMoveBoth = bMove;        
				this._sShowMenu = sMenu;
			},
			
			_bFirst : true,
			_bMouseOver : false,
			_bindMouseOver : function(iFirstIdx, iLastIdx) {
				var self = this;

				iNextItemCount = TopMenu._aItems.size() - TopMenu._iIndexFirst - this._getAvailableItemCount();
				
				oFirst = $('._first_menu_item');
				oFirst.unbind('mouseover').removeClass('_first_menu_item');
				olast = $('._last_menu_item');
				olast.unbind('mouseover').removeClass('_last_menu_item');

				oFirst.unbind('mouseenter').unbind('mouseleave');
				olast.unbind('mouseenter').unbind('mouseleave');

				oFirst.bind('mouseenter', oFirst.data("function_mouse_enter")).bind('mouseleave', oFirst.data("function_mouse_leave"));
				olast.bind('mouseenter', olast.data("function_mouse_enter")).bind('mouseleave', olast.data("function_mouse_leave"));
				
				TopMenu._aItems.eq(iFirstIdx).addClass('_first_menu_item');
				TopMenu._aItems.eq(iLastIdx).addClass('_last_menu_item');
		   
				$('._first_menu_item').bind('mouseover', function(){
					self_bMouseOver = true;
					self._mouseoverCallback('Left', this);
				});
				$('._first_menu_item').bind('mouseleave', function(){
					self_bMouseOver = false;            
				});
				
				if(iNextItemCount > 0){
					$('._last_menu_item').bind('mouseover', function(){
						self_bMouseOver = true;
						self._mouseoverCallback('Right', this);
					});
					$('._last_menu_item').bind('mouseleave', function(){
						self_bMouseOver = false;
					
					});
				}		
			},

			_mouseoverCallback : function(sPosition, target) {
				if (this._bMoveBoth) {
					this.showPrevOrNextItem(target, sPosition);
					this._bMoveBoth = false;
					this._sShowMenu = sPosition;
					return ;
				}
				
				if (this._sShowMenu != sPosition) {
					this.showPrevOrNextItem(target, sPosition);                
					this._sShowMenu = sPosition;
				}
			},

			setFoldEffect : function() {
				// set effect on 1depth
				for(i=0; i<TopMenu._aItems.size(); i++) {
					TopMenu._bindOn1Depth(
							TopMenu._aItems.eq(i));
				}
				
				// set effect on 2depth
				$("._tmenuitem_lv2_btn").click(function() {
					$(this).parents("._tmenuitem_lv2").find("._tmenuarea_lv3").toggle();
				});
				
				// set effect on 3depth
				$("._tmenuitem_lv3").mouseenter(function() {
					var i2DepthAreaWidth = $(this).parents("._tmenuarea_lv2").width();
					$(this).find("._wrap_for_ie7").css("width", $(this).width());  // for ie7
					$(this).find("._tmenuarea_lv4")
						.css("margin-left", i2DepthAreaWidth)
						.show();
				});
				$("._tmenuitem_lv3").mouseleave(function() {
					$(this).find("._tmenuarea_lv4").hide();
				});
				
			},
			
			_bindOn1Depth : function(e1DepthItem) {
				var iRef = e1DepthItem.find("._ref").val();
				var e2DepthArea = $("._tmenuarea_lv2._ref-" + iRef);
				
				var bIsSelected = e1DepthItem.hasClass("_selected");
				
				var fEnter = function() {
					// set over effect on un selected menu only
					if(!bIsSelected) {
						// set 1 depth over effect
						e1DepthItem.addClass("hover");

						// set 1 depth group over effect (not seleced menu only)
						if (/^group/i.test(e1DepthItem.attr('class'))) e1DepthItem.addClass("group_hover");
					}       
					
					// set 2 depth display effect
					e2DepthArea.css("left", e1DepthItem.offset().left);
					e2DepthArea.show();
				};
				var fLeave = function() {
					
					// set over effect on un selected menu only
					if(!bIsSelected) {
						// set 1 depth over effect (not seleced menu only)
						e1DepthItem.removeClass("hover");
			
						// set 1 depth group over effect (not seleced menu only)
						if (/^group/i.test(e1DepthItem.attr('class'))) e1DepthItem.removeClass("group_hover");
					}
					
					// set 2 depth display effect
					e2DepthArea.hide();
				};
				
				// bind
				e1DepthItem.unbind('mouseenter').unbind('mouseleave');
				e2DepthArea.unbind('mouseenter').unbind('mouseleave');
				
				e1DepthItem.bind('mouseenter', fEnter).bind('mouseleave', fLeave);
				e2DepthArea.bind('mouseenter', fEnter).bind('mouseleave', fLeave);        

				e1DepthItem.data("function_mouse_enter", fEnter);
				e1DepthItem.data("function_mouse_leave", fLeave);
						
				// set link on margin space of menu item
				e1DepthItem.click(function() {
					var href = $(this).find("._tmenuitem_lv1_btn").attr("href");
					location.href = href;
				});
			},

			setSlideEffect : function() {
				$(settings.prev).click(function() {
					TopMenu._slide(- TopMenu._iSize);
				});
				$(settings.next).click(function() {
					TopMenu._slide(TopMenu._iSize);
				});
			},

			setSlideButtonHover : function(bNoMoreLeft, bNoMoreRight) {       
				var eLeftBtn = $(settings.prev);
				var eRightBtn = $(settings.next);
				
				iNextItemCount = TopMenu._aItems.size() - TopMenu._iIndexFirst - this._getAvailableItemCount();

				if(TopMenu._iIndexFirst <= 0){
					iLeft = '';
					eLeftBtn.parent().removeClass('scroll_left');
					eLeftBtn.parent().addClass('scroll_left_none');

				}else{
					iLeft = TopMenu._iIndexFirst;
					eLeftBtn.parent().removeClass('scroll_left_none');
					eLeftBtn.parent().addClass('scroll_left');
				}

				if(iNextItemCount <= 0){
					iRight = '';
					eRightBtn.removeClass('scroll_num');
					eRightBtn.addClass('scroll_num_none');
				}else{
					iRight = iNextItemCount;
					eRightBtn.removeClass('scroll_num_none');
					eRightBtn.addClass('scroll_num');
				}
			},

			_slide : function(iMove) {
				this._setShowMenuDefault('', false);
				
				// lock resizing
				TopMenu._bOnSliding = true;
				
				// if new first-index is overflow to left, set to 0
				// else if overflow to right, keep original first-index
				var iNewIndexFirst = TopMenu._iIndexFirst + iMove;
				if(iNewIndexFirst < 0) iNewIndexFirst = 0;
				else if(iNewIndexFirst > TopMenu._aItems.size() - 1) iNewIndexFirst = TopMenu._iIndexFirst;
				
				// do slide (animation)
				var iMarginLeft = TopMenu._getSliderLeft(iNewIndexFirst);
				this._startAnimate(iMarginLeft);
						
				// change first index & save on cookie
				TopMenu._iIndexFirst = iNewIndexFirst;
				
				$.cookie(TopMenu.KEEPER_COOKIE_KEY, TopMenu._iIndexFirst, {path : '/'});
		//      $.cookie(TopMenu.KEEPER_COOKIE_KEY, null);  // remove
				
				// set item display
				//TopMenu.setItemDisplay();
			},

			_startAnimate : function(iMarginLeft, iSpeed) {
				var self = this;
				if(!iSpeed){
					iSpeed = 500;
				}
				$("._tmenuarea_lv1").animate(
				   {marginLeft : iMarginLeft},
				   iSpeed,
				   "easein",
				   function() {
					   TopMenu._bOnSliding = false;
					   self._animateCallback();               
					   self._animateCallback = function(){};
				   }
			   );
			},

			_animateCallback : function(){},

			showPrevOrNextItem: function(oObj, sPosition, iSpeed){
				if(oObj){
					this._show2DepthItem(oObj);    
				}
				
				if(!iSpeed){
					iSpeed = 200
				}

				if (sPosition != 'Left') {
					margin = this._lastItemWidth();
					iMarginLeft = this._getSliderLeft(TopMenu._iIndexFirst, +(margin));
				} else {
					iMarginLeft = this._getSliderLeft(TopMenu._iIndexFirst);
				}
				this._startAnimate(iMarginLeft, iSpeed);
			},

			_show2DepthItem : function(oObj){
				var self = this;
				
				iRef = $(oObj).find('._ref').val();
				e2DepthArea = $("._tmenuarea_lv2._ref-" + iRef);
				e2DepthArea.hide();
				
				self._animateCallback = function(){
					iLeft = $(oObj).offset().left;
					
					e2DepthArea.css('left', iLeft);
					
					if(self_bMouseOver){
						e2DepthArea.show();    
					}
				}
				
			},

			_getSliderLeft : function(iIndexFirst, margin) {
				iLastItem = this._lastItemWidth();
				if(!margin){
					margin = 0;
				}

				return - iIndexFirst * (TopMenu.ITEM_WIDTH - -1) + (-margin);  // correction '1';
			},

			_getItemWidth : function(){
				var iWidth;

				if(TopMenu._aItems.size() - TopMenu._iIndexFirst < this._getAvailableItemCount()){
					iWidth =  TopMenu._aItems.size() - TopMenu._iIndexFirst;
				} else {
					iWidth = this._getAvailableItemCount();
				}
				
				return iWidth * TopMenu.ITEM_WIDTH;	
			},

			_lastItemWidth : function() {
				iWrap = this._getWrapWidth();
				iItem = this._getItemWidth();
				// alert(iWrap +">"+ (iItem + TopMenu.ITEM_WIDTH));
				if(iWrap > iItem + TopMenu.ITEM_WIDTH) return 0;

				iWidth = TopMenu.ITEM_WIDTH - (iWrap - iItem);

				return iWidth + 50;        
			},
			
			_getAvailableItemCount : function() {
				var iWrapWidth = TopMenu._getWrapWidth();
				
				
				trunc = parseInt(iWrapWidth / TopMenu.ITEM_WIDTH);
				
				// var iTotal = $("._tmenuarea_lv1 ").find("li._tmenuitem_lv1").filter(":visible").size();
				
				// alert(iTotal);
				// return iTotal;

				return trunc;
			},

			setLastPageIndexFirst : function() {
				var iAvailableItemCount =TopMenu._getAvailableItemCount() ;
				//iNextItemCount = parseInt((TopMenu._aItems.size() - TopMenu._iIndexFirst) / iAvailableItemCount) * iAvailableItemCount;
				var iLastPageIndexFirst = parseInt(TopMenu._aItems.size() / iAvailableItemCount) * iAvailableItemCount;
				$.cookie(TopMenu.KEEPER_COOKIE_KEY, iLastPageIndexFirst, {path : '/'});
			},
			
			_getWrapWidth : function() {
				return $("._tmenuwrap").width()+(TopMenu.ITEM_WIDTH/10);
			}
		};
		
		TopMenu.init();
		
		/*$(this).find("li ul").each(function(){
			$(this).prev("a").append('<span class="sf-sub-indicator">&nbsp;</span>');
		});*/
	};
})(jQuery);

jQuery.extend(jQuery.easing, {
	easein: function(x, t, b, c, d) {
		return c*(t/=d)*t + b; // in
	},
	easeinout: function(x, t, b, c, d) {
		if (t < d/2) return 2*c*t*t/(d*d) + b;
		var ts = t - d/2;
		return -2*c*ts*ts/(d*d) + 2*c*ts/d + c/2 + b;
	},
	easeout: function(x, t, b, c, d) {
		return -c*t*t/(d*d) + 2*c*t/d + b;
	},
	expoin: function(x, t, b, c, d) {
		var flip = 1;
		if (c < 0) {
			flip *= -1;
			c *= -1;
		}
		return flip * (Math.exp(Math.log(c)/d * t)) + b;
	},
	expoout: function(x, t, b, c, d) {
		var flip = 1;
		if (c < 0) {
			flip *= -1;
			c *= -1;
		}
		return flip * (-Math.exp(-Math.log(c)/d * (t-d)) + c + 1) + b;
	},
	expoinout: function(x, t, b, c, d) {
		var flip = 1;
		if (c < 0) {
			flip *= -1;
			c *= -1;
		}
		if (t < d/2) return flip * (Math.exp(Math.log(c/2)/(d/2) * t)) + b;
		return flip * (-Math.exp(-2*Math.log(c/2)/d * (t-d)) + c + 1) + b;
	},
	bouncein: function(x, t, b, c, d) {
		return c - jQuery.easing['bounceout'](x, d-t, 0, c, d) + b;
	},
	bounceout: function(x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	bounceinout: function(x, t, b, c, d) {
		if (t < d/2) return jQuery.easing['bouncein'] (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing['bounceout'] (x, t*2-d,0, c, d) * .5 + c*.5 + b;
	},
	elasin: function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	elasout: function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	elasinout: function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	backin: function(x, t, b, c, d) {
		var s=1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	backout: function(x, t, b, c, d) {
		var s=1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	backinout: function(x, t, b, c, d) {
		var s=1.70158;
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	}
});


$(document).ready(function(){
	$("#main_nav").menuAnimate();
	Menu.animateMessage();
});
