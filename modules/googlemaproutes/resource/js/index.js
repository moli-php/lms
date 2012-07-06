$(document).ready(function(){
    GooglemaproutesIndex.initialize();

    var parentWidth = $("#googlemaproute_canvas").parents().width();
    var mapWidth = $("#googlemaproute_canvas").width();
    
    if (mapWidth > parentWidth){
         $("#googlemaproute_canvas").css("width", "100%");
         $("#googlemaproute_caption_cont").css("width", "100%");
    }
    else {
        $("#googlemaproute_caption_cont").css("width", mapWidth);
    }
    
});

var mapRoute;

var GooglemaproutesIndex = {

	initialize : function()
	{
		GooglemaproutesIndex.cssMapSize();

		var addressRoute = $('#pg_googlemaproute_center').val() != "" ? $('#pg_googlemaproute_center').val() : "USA";
		var zoom = parseInt($('#pg_googlemaproute_zoom').val());
		var maptype = GooglemaproutesIndex.mapType();
		var zoomsize = $('#pg_googlemaproute_zoomsize').val();
		var zoomctrl = zoomsize ? true : false;
		var zoomctrlpos = GooglemaproutesIndex.ctrlPosition($('#pg_googlemaproute_zoompos').val());
		var panctrl = zoomctrl;
		var zoomctrlopt;
		var typectrlval = $('#pg_googlemaproute_typectrl').val();
		var typectrl = typectrlval ? true : false;
		var typectrlpos = GooglemaproutesIndex.ctrlPosition($('#pg_googlemaproute_typectrlpos').val());
		var typectrlopt;
		var scalectrlval = $('#pg_googlemaproute_scalectrlpos').val();
		var scalectrl = scalectrlval ? true : false;
		var scalectropt = scalectrl ? { position: GooglemaproutesIndex.ctrlPosition(scalectrlval) } : null;
		var strtctrlval = $('#pg_googlemaproute_strtviewctrlpos').val();
		var strtctrl = strtctrlval ? true : false;
		var strtctrlopt = strtctrl ? { position: GooglemaproutesIndex.ctrlPosition(strtctrlval) } : null;
		var route_str = $('#pg_googlemaproute_route').val();

		if(zoomsize == "0") zoomctrlopt = { style: google.maps.ZoomControlStyle.SMALL, position: zoomctrlpos};
		else if(zoomsize == "1") zoomctrlopt = { style: google.maps.ZoomControlStyle.LARGE, position: zoomctrlpos};
		else zoomctrlopt = null;

		if(typectrlval == "0") typectrlopt = { style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR, position: typectrlpos};
		else if(typectrlval == "1") typectrlopt = { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, position: typectrlpos};
		else typectrlopt = null;

		var directionsDisplay = new google.maps.DirectionsRenderer();
		var directionsService = new google.maps.DirectionsService();

		var myOptions = {
			disableDefaultUI: false,
			zoom: zoom,
			panControl: panctrl,
			zoomControl: zoomctrl,
			zoomControlOptions: zoomctrl ? zoomctrlopt : null,
			mapTypeControl: typectrl,
			mapTypeControlOptions: typectrl ? typectrlopt : null,
			scaleControl: scalectrl,
			scaleControlOptions: scalectropt,
			streetViewControl: strtctrl,
			streetViewControlOptions: strtctrlopt,
			mapTypeId: maptype
		}
		
		mapRoute = new google.maps.Map(document.getElementById("googlemaproute_canvas"), myOptions);
		directionsDisplay.setMap(mapRoute);

		geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': addressRoute}, function(results, status) {

			if (status == google.maps.GeocoderStatus.OK) {
				mapRoute.setCenter(results[0].geometry.location);
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
		
		if(route_str != "") {
		
			var aLoc = route_str.split("|");
			var start = "";
			var end = "";
			var waypts = [];

			$.each(aLoc, function(k,v){
				
					if(k == 0) start = v;
					else if(k == aLoc.length - 1) end = v;
					else waypts.push({location:v,stopover:true});
			});

			var request = {
				origin: start, 
				destination: end,
				waypoints: waypts,
				travelMode: google.maps.DirectionsTravelMode.DRIVING,
				avoidTolls: true,
				optimizeWaypoints: true
			};
			
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				}
			});
		}

		//caption
		var caption = $('#pg_googlemaproute_caption').val();
		$('#googlemaproute_text').html(caption);

	},

	cssMapSize : function()
	{
		$('#googlemaproute_canvas').css('width', '100%');
		$('#googlemaproute_canvas').css('height', '100%');

		$('#googlemaproute_caption_cont').width();
	},

	mapType : function()
	{
		var typ = $('#pg_googlemaproute_type').val();
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
	}
};