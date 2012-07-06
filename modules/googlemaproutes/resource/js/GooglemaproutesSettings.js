$(document).ready( function(){
    Googlemap.initialize();
    $('#google_map_search_field').live('keyup', function(e){
        var code = e.keyCode ? e.keyCode : e.which;
        
        if(code == 13) Googlemap.searchX();
    });

    $('#google_map_route_search_field').live('keyup', function(e){
        var code = e.keyCode ? e.keyCode : e.which;
        
        if(code == 13) Googlemap.searchXRoute();
    });
});

var route_type;
var curr_sel;
var p_inp1;
var p_inp2;
var p_inp3;
var geo_loc;
var markersArray = [];

var GooglemaproutesSettings = {
	valid : null,
	isHide : 0,
	isCanvass : 1,
	displayOption : function(){
		var pgdir = $('#pgdir').val();
		var selector = $("#pg_googlemaproute_option");
		//GooglemaproutesSettings.changeIframe("auto", null, 200);
		
		this.isHide = (this.isHide==0) ? 1 : 0;
		
		if(this.isHide==1){
			$(selector).slideDown("fast");
			$('#pg_disqus_arrow img').attr('src', '/_sdk/img/googlemaproutes/arrow_up.png');	
		}else{
			$(selector).slideUp("fast");
			$('#pg_disqus_arrow img').attr('src', '/_sdk/img/googlemaproutes/arrow_down.png');
		}
		// if($(selector).is(":hidden")){
			// $(selector).slideDown("fast")
			// $('#pg_disqus_arrow img').attr('src', pgdir + '/images/arrow_up.png');
			// parent.iframeHeight(parent.document.getElementById('plugin_contents'), '200'); 
		// } else {
			// $(selector).slideUp("fast");
			// $('#pg_disqus_arrow img').attr('src', pgdir + '/images/arrow_down.png');
			// parent.iframeHeight(parent.document.getElementById('plugin_contents'), '-200'); 
		// }
	},

	openCenterPopup : function()
	{
		var center = $.trim($('#pg_googlemaproute_center').val());

		if(center.length == 0) return false;

		$('#pg_googlemapmark_popup_center').dialog( { width:381, resizable:false } );
		$('#google_map_search_field').val(center);

		Googlemap.search(center);
	},
	
	optZoom : function()
	{
		var chk = $('#zoom_control').attr('checked');

		if(chk) {
			Googlemap.zoomFlag = true;
			$('#zoom_size').attr('disabled', false);
			$('#zoom_position').attr('disabled', false);
		} else {
			Googlemap.zoomFlag = false;
			$('#zoom_size').attr('disabled', true);
			$('#zoom_position').attr('disabled', true);
		
		}

		Googlemap.setZoomControl();
	},

	changeZoomCtrPos : function()
	{
		Googlemap.setZoomControl();
	},
	
	changeZoomCtrSize : function()
	{
		Googlemap.setZoomControl();
	},

	optType : function()
	{
		var chk = $('#map_type_control').attr('checked');

		if(chk) {
			Googlemap.typeFlag = true;
			$('#map_type').attr('disabled', false);
			$('#map_type_position').attr('disabled', false);
		} else {
			Googlemap.typeFlag = false;
			$('#map_type').attr('disabled', true);
			$('#map_type_position').attr('disabled', true);
		
		}

		Googlemap.setMapTypeControl();
	},
	
	changeMapType : function()
	{
		Googlemap.setMapTypeControl();
	},
	
	changeMapTypePosition : function()
	{
		Googlemap.setMapTypeControl();
	},
	
	optScale : function()
	{
		var chk = $('#scale_control').attr('checked');

		if(chk) {
			Googlemap.scaleFlag = true;
			$('#scale_control_position').attr('disabled', false);
		} else {
			Googlemap.scaleFlag = false;
			$('#scale_control_position').attr('disabled', true);		
		}

		Googlemap.setScaleControl();
	},
	
	changeScaleControlPosition : function()
	{
		Googlemap.setScaleControl();
	},
	
	optStreet : function()
	{
		var chk = $('#street_view_control').attr('checked');

		if(chk) {
			Googlemap.streetFlag = true;
			$('#street_view_position').attr('disabled', false);
		} else {
			Googlemap.streetFlag = false;
			$('#street_view_position').attr('disabled', true);
		
		}

		Googlemap.setStreetViewControl();
	},

	changeStreetViewPosition : function()
	{
		Googlemap.setStreetViewControl();
	},
	
	mapZoom : function()
	{
		var siz = $('#map_zoom').val();
		Googlemap.zoomMap(siz);
	},
	
	changeMapTypeView : function()
	{
		var typ = $('#google_map_type').val();
		var typ_id = "";

		switch (typ){
			case '1':
				typ_id = google.maps.MapTypeId.SATELLITE;
				break;
			case '2':
				typ_id = google.maps.MapTypeId.HYBRID;
				break;
			case '3':
				typ_id = google.maps.MapTypeId.TERRAIN;
				break;
			default:
				typ_id = google.maps.MapTypeId.ROADMAP;
		
		}
		Googlemap.setMapType(typ_id);
	},
	
	changeMapTypeInit : function()
	{
		var typ = $('#google_map_type').val();
		var typ_id = "";

		switch (typ){
			case '1':
				typ_id = google.maps.MapTypeId.SATELLITE;
				break;
			case '2':
				typ_id = google.maps.MapTypeId.HYBRID;
				break;
			case '3':
				typ_id = google.maps.MapTypeId.TERRAIN;
				break;
			default:
				typ_id = google.maps.MapTypeId.ROADMAP;
		
		}
		return typ_id;
	},

	resizeMap : function()
	{
			$('#map_canvas').css('width', '100%');
			$('#map_canvas').css('height', '100%');
			$('.map_custom_wrap').css('display', 'none');
			$('#prev_btn').css('display', 'none');
			$('#pg_googlemaproute_displaysize').css('display', 'none');

		Googlemap.resize();
		Googlemap.setCenter();
	},
	
	previewWidthCustom : function()
	{
		var width = $.trim($('#map_custom_width').val());
		var height = $.trim($('#map_custom_height').val());

		if(parseInt(width) < 1 || !GooglemaproutesSettings.isNumeric(width))  width = 640;
		if(parseInt(height) < 1|| !GooglemaproutesSettings.isNumeric(height)) height = 480;
		if(parseInt(width) > 1000) width = 1000;
		if(parseInt(height) > 1000 ) height = 1000;

		var _width = width > 640 ? 640 : width;
		var _height = height > 480 ? 480 : height;

		$('#map_canvas').css('width', '100%');
		$('#map_canvas').css('height', '100%');

		Googlemap.resize();
		Googlemap.setCenter();
	},

	isNumeric : function (input)
	{
		return (input - 0) == input && input.length > 0;
	},
	
	checkform : function()
    {
        if(!oValidator.formName.getMessage('googlemaproute_form')){
            oValidator.generalPurpose.getMessage(false, "Fill all required fields.");
            $('#pg_googlemaproute_center').css('border', '2px solid #dc4e22');
        }
        else{
            var msize = $('[class^=mod_num]').size();

            if(msize < 2) {
                oValidator.generalPurpose.getMessage(false, 'You are required to set at least two (2) routes. Please click the "Add another Location" link.');
            }
            else{
                GooglemaproutesSettings.checkRoute();
            }
        }
    },

	checkRoute : function()
	{
		var directionsService = new google.maps.DirectionsService();
		var start = "";
		var end = "";
		var waypts = [];
		var sel = $("input[name='pg_route_location[]']");
		var siz = sel.size();

		$(sel).each(function(k, v){
			var address = $(this).val();
//alert(address);
			if(k == 0) start = address;
			else if(k == siz - 1) end = address;
			else waypts.push({location:address,stopover:false});
		});
		
		var request = {
			origin: start, 
			destination: end,
			waypoints: waypts,
			travelMode: google.maps.DirectionsTravelMode.DRIVING,
			optimizeWaypoints: true,
			avoidHighways: true,
			avoidTolls: true
		};

		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				$('#googlemaproute_form').submit();
			} else {
			    oValidator.generalPurpose.getMessage(false, 'Route service is not yet available for the address(es) you entered. Please choose another address.');
			}
		});
	},
	
	cssMapSize : function()
	{
		$('#map_canvas').css('width', '100%');
		$('#map_canvas').css('height', '100%');
	},

	openPopupCenter : function()
	{
		var center = $.trim($('#pg_googlemaproute_center').val());

		if(center.length == 0) {
			$('#pg_googlemaproute_center').css('border', '2px solid #dc4e22');
			return false;
		} else {
			$('#pg_googlemaproute_center').css('border', '1px solid silver');
		}

		popup.load('google_map_center_list').skin('admin').layer({
            'title' : 'Set Center',
			'width' : 350,
            'classname': 'ly_set ly_editor'
        });

		
		$('#google_map_search_field').val(center);
		Googlemap.search(center);
	},
	
	setRoutePopup : function(sel, meth)
	{
		route_type = meth;
		curr_sel = sel;
		var selector = $(sel).parent('li').children('input:eq(0)');
		var val = $.trim(selector.val());
		
		if(val.length == 0) {
			selector.css('border', '2px solid #dc4e22');
			return false;
		} else {
			selector.css('border', '1px solid silver');
		}

		popup.load('google_map_route_search').skin('admin').layer({
            'title' : 'Set Route',
            'width': 350,
            'classname': 'ly_set ly_mod_wid'
        });

		$('#google_map_route_search_field').val(val);
		Googlemap.searchRoute(val);
	},
	
	deleteMark : function(sel)
	{
		$(sel).parent('div').remove();

		Googlemap.mapGeocoderMark();
	},
	
	editMarkPopup : function(sel)
	{
		p_inp1 = $(sel).parent('div').children('input:eq(0)');
		p_inp2 = $(sel).parent('div').children('input:eq(1)');
		p_inp3 = $(sel).parent('div').children('input:eq(2)');

		GooglemaproutesSettings.openPopupMarker('edit');
	},
	
	addLocation : function()
	{
		var siz = $('.module_list li').size();
		var content = '<li><span class="mod_num"></span>';

		content += '<input type="text" name="pg_route_location[]" class="_validate fix txt_style" filter="fill[0]"/> ';
		content += '<input type="button" name="btn" value="Set Route" class="btn_route" onclick="GooglemaproutesSettings.setRoutePopup(this);"/> ';
		content += '<a href="#" onclick="GooglemaproutesSettings.deleteLocation(this);"><img src="/_sdk/img/googlemaproutes/u216_original.png" alt="" /></a></li>';			
				
			
		$('.module_list').append(content);
		GooglemaproutesSettings.locNum();

	},
	
	locNum : function()
	{
		$('.module_list li').each(function(k,v){
			$('.mod_num:eq('+k+')').html(k+1);
		});
	},
	
	deleteLocation : function(sel)
	{
		$(sel).parent('li').remove();
		Googlemap.mapGeocoderRoute();
		GooglemaproutesSettings.locNum();
	},
	
	reset : function()
	{
		var pgdir = $('#pgdir').val();

		$('#pg_googlemaproute_center').val('');
		$('#map_size').val('640x480');
		$('#map_zoom').val('8');
		$('#google_map_type').val('0');
		$('#pg_googlemaproute_caption').val('');
		$('#zoom_control').attr('checked', false);
		$('#zoom_size').attr('disabled', true);
		$('#zoom_size').val('0');
		$('#zoom_position').attr('disabled', true);
		$('#zoom_position').val('0');
		$('#map_type_control').attr('checked', false);
		$('#map_type').attr('disabled', true);
		$('#map_type').val('0');
		$('#map_type_position').attr('disabled', true);
		$('#map_type_position').val('6');
		$('#scale_control').attr('checked', false);
		$('#scale_control_position').attr('disabled', true);
		$('#scale_control_position').val('11');
		$('#street_view_control').attr('checked', false);
		$('#street_view_position').attr('disabled', true);
		$('#street_view_position').val('0');
		$('#pg_googlemaproute_option').css('display', 'none');
		$('#pg_disqus_arrow img').attr('src', "/_sdk/img/googlemaproutes/arrow_down.png");

		GooglemaproutesSettings.resizeMap();
		GooglemaproutesSettings.mapZoom();
		GooglemaproutesSettings.changeMapTypeView();
		Googlemap.setZoomControl();
		GooglemaproutesSettings.optType();
		GooglemaproutesSettings.optScale();
		GooglemaproutesSettings.optStreet();
		GooglemaproutesSettings.defRoute();
		Googlemap.deleteOverlays();
		// $.ajax({
		   // type : "POST",
		   // url : pgdir+'/setup.php',
		   // data : {
				// action : 'reset'
		   // },
		   // success : function(requestContent){
				// window.location.href='setup.php?status=reset';
		   // }
		// });

	},
	
	defRoute : function()
	{
		$('.module_list li').remove();

		for(var i=0; i<2; i++) {
			GooglemaproutesSettings.addLocation();
		}
	}
};

var Googlemap = {

	map : '',
	lat: 37.09024,
	lng: -95.712891,
	center : '',
	address : "USA",
	geocoder : '',
	zoomFlag: '',
	typeFlag: '',
	scaleFlag: '',
	streetFlag: '',
	zoom : '',
	geo_loc : '',
	latlng : '',

	initialize : function()
	{
		GooglemaproutesSettings.cssMapSize();

		var address = $('#pg_googlemaproute_center').val();
		var maptype = GooglemaproutesSettings.changeMapTypeInit();
		//var fUi = $('#pg_googlemapmark_option').is(':hidden') ? true : false;
		var zoomctrl = Googlemap.setZoomControlInit();
		var maptypectrl = Googlemap.setMapTypeControlInit();
		var scalectrl = Googlemap.setScaleControlInit();
		var strtctrl = Googlemap.setStreetViewControlInit();
		var capt = $.trim($('#pg_googlemaproute_caption').val());

		Googlemap.zoom = parseInt($('#map_zoom').val());

		if(address != "") {
			var sCoords = $('#pg_m_coords').val();
			var aCoords = sCoords.split(',');
			
			Googlemap.address = address;
			Googlemap.lat = parseFloat(aCoords[0]);
			Googlemap.lng = parseFloat(aCoords[1]);
		}

		var myOptions = {
			disableDefaultUI: false,
			zoom: Googlemap.zoom,
			panControl: zoomctrl.panControl,
			zoomControl: zoomctrl.zoomControl,
			zoomControlOptions: zoomctrl.zoomControlOptions,
			mapTypeControl: maptypectrl.mapTypeControl,
			mapTypeControlOptions: maptypectrl.mapTypeControlOptions,
			scaleControl: scalectrl.scaleControl,
			scaleControlOptions: scalectrl.scaleControlOptions,
			streetViewControl: strtctrl.streetViewControl,
			streetViewControlOptions: strtctrl.streetViewControlOptions,
			mapTypeId: maptype,
			center: new google.maps.LatLng(Googlemap.lat, Googlemap.lng)
		}

		Googlemap.map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		Googlemap.geocoder = new google.maps.Geocoder();
		Googlemap.geocoder.geocode( { 'address': Googlemap.address}, function(results, status) {
      
			if (status == google.maps.GeocoderStatus.OK) {
				var loc = results[0].geometry.location;		
				Googlemap.map.setCenter(loc);
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});

		Googlemap.mapGeocoderRoute();

		google.maps.event.addListener(Googlemap.map, 'zoom_changed', function() {
			var zoom_lvl = Googlemap.map.getZoom();
			$('#map_zoom').val(zoom_lvl);
		});
	},
	
	search : function(sAddress)
    {  
		$('#address_list .place_check_list').html(''); 

		var str = '';
        Googlemap.geocoder.geocode({'address':sAddress}, function(results, status) {
            if(status=='ZERO_RESULTS'){
                str = '<li>Results not found. Please try a different search.</li>';
            }else{
                for(var i = 0; i < results.length; i++) {
					var chkd = i == 0 ? "checked" : "";
					var latlng = results[i].geometry.location.lat()+','+results[i].geometry.location.lng();
					str += '<li><input type="radio" name="place_group" value="'+latlng+'" id="place_group_'+i+'" title="'+results[i].formatted_address+'" class="input_rdo" '+chkd+'/><label for="place_group_'+i+'">' + results[i].formatted_address + '</label></li>';
				}
                
            }
            $('#address_list .place_check_list').html(str);            
        });            
    },

	searchRoute : function(sAddress)
    {  
		$('#route_list .place_check_list').html(''); 

		var str = '';
        Googlemap.geocoder.geocode({'address':sAddress}, function(results, status) {
            if(status=='ZERO_RESULTS'){
                str = '<li>Results not found. Please try a different search.</li>';
            }else{
                for(var i = 0; i < results.length; i++) {
					var chkd = i == 0 ? "checked" : "";
					var latlng = results[i].geometry.location.lat()+','+results[i].geometry.location.lng();
					str += '<li><input type="radio" name="place_group" value="'+latlng+'" id="place_group_'+i+'" title="'+results[i].formatted_address+'" class="input_rdo" '+chkd+'/><label for="place_group_'+i+'">' + results[i].formatted_address + '</label></li>';
				}
                
            }
            $('#route_list .place_check_list').html(str);            
        });            
    },
	
	searchX : function()
	{
		var address = $.trim($('#google_map_search_field').val());

		if(address.length == 0)  return false;

		Googlemap.search(address);
	},
	
	searchXRoute : function()
	{
		var address = $.trim($('#google_map_route_search_field').val());

		if(address.length == 0)  return false;

		Googlemap.searchRoute(address);
	},
	
	_setCenter : function()
	{
		var address = $("#address_list input[name='place_group']:checked").attr('title');
		var coordinates = $("#address_list input[name='place_group']:checked").val();

		if(!coordinates) return false;

		$('#pg_googlemaproute_center').val(address);
		$('#pg_m_coords').val(coordinates);

		var aCoor = coordinates.split(',');
		Googlemap.address = address;
		Googlemap.lat = aCoor[0];
		Googlemap.lng = aCoor[1];

		Googlemap.setCenter();

		//$('#pg_googlemapmark_popup_center').dialog('close');
		popup.close('google_map_center_list', true);
	},

	_setRoute : function()
	{
		var pg_dir = $('#pgdir').val();
		var address = $("#route_list input[name='place_group']:checked").attr('title');
		var coordinates = $("#route_list input[name='place_group']:checked").val();
		var inp = $(curr_sel).parent('li').children('input:eq(0)');

		if(!coordinates) return false;

		inp.val(address);

		popup.close('google_map_route_search', true);

		Googlemap.mapGeocoderRoute();
	},

	setCenter : function()
	{
		var latLng = new google.maps.LatLng(Googlemap.lat, Googlemap.lng);   
		Googlemap.map.panTo(latLng);
	},
	
	mapGeocoderRoute : function()
	{
		Googlemap.deleteOverlays();
				
		$('[class^=module_list] li').each(function(k, i){
			var addr = $.trim($(this).children('input:eq(0)').val());

			if(addr.length > 0) {
				Googlemap.geocoder.geocode( { 'address': addr}, function(results, status) {

					if (status == google.maps.GeocoderStatus.OK) {

						var position = results[0].geometry.location;
						var ic = "http://www.google.com/mapfiles/marker"+String.fromCharCode(k+65)+".png"
						var addr = results[0].formatted_address;

						var contentString = '<div id="content">'+
												'<div id="siteNotice"></div>'+
												'<div id="bodyContent">'+
												'<p>'+addr+'</p></div></div>';

						var infowindow = new google.maps.InfoWindow({
							content: contentString
						});

						var marker = new google.maps.Marker({map: Googlemap.map, position: position, icon: ic});
						markersArray.push(marker);
						marker.setMap(Googlemap.map);  
						google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(Googlemap.map,marker);
						});
					}
				});
			}
		});
	},

	deleteOverlays : function() 
	{
		if (markersArray) {
			for (i in markersArray) {
			  markersArray[i].setMap(null);
			}
			markersArray.length = 0;
		}
	}, 

	setZoomControl : function()
    {
		var zPos = $('#zoom_position').val();
		var pos = Googlemap.ctrlPosition(zPos);
		var zSize = $('#zoom_size').val();
		Googlemap.zoomFlag = $('#zoom_control').is(':checked') ? true : false;
		
		if(zSize == "0") {
			var zcOpt = { style: google.maps.ZoomControlStyle.SMALL, position: pos};
		} else {
			var zcOpt = { style: google.maps.ZoomControlStyle.LARGE, position: pos };
		}

        var options = {
				panControl : Googlemap.zoomFlag,
                zoomControl : Googlemap.zoomFlag,
				zoomControlOptions: zcOpt
        };
        
        Googlemap.map.setOptions(options);
    },
	
	setZoomControlInit : function()
    {
		var zPos = $('#zoom_position').val();
		var pos = Googlemap.ctrlPosition(zPos);
		var zSize = $('#zoom_size').val();

		if($('#zoom_control').is(':checked')){
			fpan = true;
			fzoom = true;
		} else {
			fpan = false;
			fzoom = false;
		}

		if(zSize == "0") {
			var zcOpt = { style: google.maps.ZoomControlStyle.SMALL, position: pos};
		} else {
			var zcOpt = { style: google.maps.ZoomControlStyle.LARGE, position: pos };
		}

        var opt = {
				panControl : fpan,
                zoomControl : fzoom,
				zoomControlOptions: zcOpt
        };
        
        return opt;
    },
	
	setMapTypeControl : function()
	{
		var mPos = $('#map_type_position').val();
		var pos = Googlemap.ctrlPosition(mPos);
		var mType = $('#map_type').val();
		Googlemap.typeFlag = $('#map_type_control').is(':checked') ? true : false;

		if(mType == "0") {
			var mtOpt = { style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR, position: pos};
		} else {
			var mtOpt = { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, position: pos };
		}

		var options = {
				mapTypeControl: Googlemap.typeFlag,
                mapTypeControlOptions: mtOpt
        };
        
        Googlemap.map.setOptions(options);
	},

	setMapTypeControlInit : function()
	{
		var mPos = $('#map_type_position').val();
		var pos = Googlemap.ctrlPosition(mPos);
		var mType = $('#map_type').val();
		var fmaptype = $('#map_type_control').is(':checked') ? true : false;

		if(mType == "0") {
			var mtOpt = { style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR, position: pos};
		} else {
			var mtOpt = { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, position: pos };
		}

		var opt = {
				mapTypeControl: fmaptype,
                mapTypeControlOptions: mtOpt
        };
        
        return opt;
	},
	
	ctrlPosition : function(val)
	{
		switch(val) {
			case '1':
				pos = google.maps.ControlPosition.TOP_RIGHT;
				break;
			case '2':
				pos = google.maps.ControlPosition.TOP_CENTER;
				break;
			case '3':
				pos = google.maps.ControlPosition.LEFT_TOP;
				break;
			case '4':
				pos = google.maps.ControlPosition.LEFT_CENTER;
				break;
			case '5':
				pos = google.maps.ControlPosition.LEFT_BOTTOM;
				break;
			case '6':
				pos = google.maps.ControlPosition.RIGHT_TOP;
				break;
			case '7':
				pos = google.maps.ControlPosition.RIGHT_CENTER;
				break;
			case '8':
				pos = google.maps.ControlPosition.RIGHT_BOTTOM;
				break;
			case '9':
				pos = google.maps.ControlPosition.BOTTOM_LEFT;
				break;
			case '10':
				pos = google.maps.ControlPosition.BOTTOM_RIGHT;
				break;
			case '11':
				pos = google.maps.ControlPosition.BOTTOM_CENTER;
				break;
			default:
				pos = google.maps.ControlPosition.TOP_LEFT;	
		}
		
		return pos;
	},
	
	setScaleControl : function()
	{
		var sPos = $('#scale_control_position').val();
		var pos = Googlemap.ctrlPosition(sPos);
		Googlemap.scaleFlag = $('#scale_control').is(':checked') ? true : false;

		var options = {
				scaleControl: Googlemap.scaleFlag,
                scaleControlOptions: { position: pos }
        };
        
        Googlemap.map.setOptions(options);
	},
	
	setScaleControlInit : function()
	{
		var sPos = $('#scale_control_position').val();
		var pos = Googlemap.ctrlPosition(sPos);
		var fscale = $('#scale_control').is(':checked') ? true : false;

		var opt = {
				scaleControl: fscale,
                scaleControlOptions: { position: pos }
        };
        
        return opt;
	},

	setStreetViewControl : function()
	{
		var stPos = $('#street_view_position').val();
		var pos = Googlemap.ctrlPosition(stPos);
		Googlemap.streetFlag = $('#street_view_control').is(':checked') ? true : false;

		var options = {
				streetViewControl: Googlemap.streetFlag,
                streetViewControlOptions: { position: pos }
        };
        
        Googlemap.map.setOptions(options);
	},

	setStreetViewControlInit : function()
	{
		var stPos = $('#street_view_position').val();
		var pos = Googlemap.ctrlPosition(stPos);
		var fstreet = $('#street_view_control').is(':checked') ? true : false;

		var opt = {
				streetViewControl: fstreet,
                streetViewControlOptions: { position: pos }
        };
        
        return opt;
	},
	
	zoomMap : function(val)
	{
		var lvl = parseInt(val);

		Googlemap.map.setZoom(lvl);
	},

	setMapType : function(val)
	{
		var options = {
				mapTypeId: val
        };
		
		Googlemap.map.setOptions(options);
	},
	
	resize : function()
	{
		google.maps.event.trigger(Googlemap.map, 'resize');
	},
	
	setCaption : function(loc, text)
	{
		var contentString = '<div id="content">'+
										'<div id="siteNotice"></div>'+
									    '<div id="bodyContent">'+
									    '<p>'+text+'</p></div></div>';

		var infowindow = new google.maps.InfoWindow({ 
			content : contentString,
			position : loc
		});

		infowindow.open(Googlemap.map);	
		
	}
};

