<div id="sdk_message_box"></div>
<form name="googlemaproute_form" id="googlemaproute_form" class="googlemaproute_form" method="POST">
	<p class="require"><span class="neccesary">*</span> Required</p>
	<!-- input area -->
	<div id="pg_simplemap_wrap">
		<div id="pg_googlemapsimple_mapcontainer">
			<div id="map_canvas"></div>
		</div>
	</div>

	<table border="1" cellspacing="0" class="table_input_vr">
	<colgroup>
		<col width="115px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th><label for="module_label">Center Point</label><span class="neccesary">*</span></th>
		<td><span>
			<input id="pg_googlemaproute_center" name="pg_googlemaproute_center" type="text" fw-filter="isFill" fw-label="center"  value="<?php echo $sCenter; ?>" class="_validate fix" filter="fill[0]" />
			<input type="hidden" name="pg_m_coords" id="pg_m_coords" value="<?php echo $sCoordinates; ?>" />
			<input type="button" class="btn" value="Set Center" onclick="GooglemaproutesSettings.openPopupCenter();" />
		</span></td>
	</tr>
	<tr>
		<th class="padt1"><label for="show_html_value">Zoom</label></th>
		<td class="padt1">
			<select title="select rows" class="rows" name="map_zoom" id="map_zoom" onchange="GooglemaproutesSettings.mapZoom();">
			<?php for($i = 1; $i <= 21; $i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($iMapZoom == $i){ echo "selected"; }?>><?php echo $i; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="show_html_value">Map Type</label></th>
		<td>
			<select  name="google_map_type" id="google_map_type" onchange="GooglemaproutesSettings.changeMapTypeView();">
				<option value="0" <?php if($iMapType == 0){ echo "selected"; }?>>Normal</option>
				<option value="1" <?php if($iMapType == 1){ echo "selected"; }?>>Satellite</option>
				<option value="2" <?php if($iMapType == 2){ echo "selected"; }?>>Hybrid</option>
				<option value="3" <?php if($iMapType == 3){ echo "selected"; }?>>Terrain</option>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="module_label">Caption</label></th>
		<td>
			<span id="module_label_wrap">
				<input name="pg_googlemaproute_caption" id="pg_googlemaproute_caption" class="fix" type="text" value="<?php echo $sCaption; ?>" />
			</span>
		</td>
	</tr>

	</table>

	<div>
		<div class="route_details">
			<p>
				<span class="fl mod_title">Route</span>
				<span class="content">Add a route to your map.<br />Enter at least two addresses below to trace the route.
				<a href="javascript: GooglemaproutesSettings.addLocation();">Add another Location</a>
				</span>
			</p>
		</div>
		<ul class="module_list" id="module_list_route" style="margin-top:10px;margin-bottom:70px">
			<?php if($sAction == "New"){ ?>
			<li>
				<span class="mod_num">1</span>
				<input type="text" name="pg_route_location[]" class="_validate fix txt_style" filter="fill[0]"/>
				<input type="button" name="btn" value="Set Route" class="btn_route" onclick="GooglemaproutesSettings.setRoutePopup(this);"/>
				<a href="#" onclick="GooglemaproutesSettings.deleteLocation(this); return false;"><img src="/_sdk/img/googlemaproutes/u216_original.png" alt="" /></a>
			</li>
			<li>
				<span class="mod_num">2</span>
				<input type="text" name="pg_route_location[]" class="_validate fix txt_style" filter="fill[0]"/>
				<input type="button" name="btn" value="Set Route" class="btn_route" onclick="GooglemaproutesSettings.setRoutePopup(this);"/>
				<a href="#" onclick="GooglemaproutesSettings.deleteLocation(this);"><img src="/_sdk/img/googlemaproutes/u216_original.png" alt="" /></a>
			</li>
			<?php
			}
			else{
			    foreach($aRoute as $key => $route){
			?>
    			<li>
    				<span class="mod_num"><?php echo $key+1 ?></span>
    				<input type="text" name="pg_route_location[]" value="<?php echo $route['route']; ?>" class="_validate fix txt_style" filter="fill[0]"/>
    				<input type="button" name="btn" value="Set Route" class="btn_route" onclick="GooglemaproutesSettings.setRoutePopup(this);"/>
    				<a href="#" onclick="GooglemaproutesSettings.deleteLocation(this); return false;"><img src="/_sdk/img/googlemaproutes/u216_original.png" alt="" /></a>
    			</li>
			<?php
			    }
			}
			?>
		</ul>

	</div>
	<!--  Display option  -->
	<div>

		<div>
			<p>
				<span class="module_title" onclick="GooglemaproutesSettings.displayOption();">Display Options </span>
				<span id="pg_disqus_arrow" class="symb_style" onclick="GooglemaproutesSettings.displayOption();"><img src="/_sdk/img/googlemaproutes/<?php if($sDispOpt == 'no_disp'){ echo "arrow_down.png"; } else { echo "arrow_up.png"; }?>" /></span>
			</p>
		</div>
		<!-- visible if display option is selected -->
		<div id="pg_googlemaproute_option" <?php if($sDispOpt == "no_disp"){ echo "style=\"display:none\""; }?>>
		<table border="0" cellspacing="0" class="tbl_option">
			<tr>
				<td style="width:155px;">
				<input id="zoom_control" name="zoom_control" type="checkbox" onclick="GooglemaproutesSettings.optZoom()" <?php if($iZoomSize != ""){ echo "checked"; }?>/>
				<label for="zoom_control">Zoom Control</label></td>
				<td style="width:179px;">
					<label for="pg_googlemapsimple_zoomcontrolsize" class="fl lbl_style">Size</label>
					<select title="select rows" class="rows" name="zoom_size" id="zoom_size" <?php if($iZoomSize == ""){ echo "disabled"; }?> onchange="GooglemaproutesSettings.changeZoomCtrSize();">
						<option value="0" <?php if($iZoomSize == 0){ echo "selected"; }?>>Small</option>
						<option value="1" <?php if($iZoomSize == 1){ echo "selected"; }?>>Large</option>
					</select>

				</td>
				<td>
					<label for="pg_googlemapsimple_zoomcontrolposition" class="fl lbl_style">Position</label>
					<select title="select rows" class="rows" name="zoom_position" id="zoom_position" <?php if($iZoomPos == ""){ echo "disabled"; }?> onchange="GooglemaproutesSettings.changeZoomCtrPos();">
						<option value="0" <?php if($iZoomPos == 0){ echo "selected"; }?>>Top Left</option>
						<option value="1" <?php if($iZoomPos == 1){ echo "selected"; }?>>Top Right</option>
						<option value="2" <?php if($iZoomPos == 2){ echo "selected"; }?>>Top Center</option>
						<option value="3" <?php if($iZoomPos == 3){ echo "selected"; }?>>Left Top</option>
						<option value="4" <?php if($iZoomPos == 4){ echo "selected"; }?>>Left Center</option>
						<option value="5" <?php if($iZoomPos == 5){ echo "selected"; }?>>Left Bottom</option>
						<option value="6" <?php if($iZoomPos == 6){ echo "selected"; }?>>Right Top</option>
						<option value="7" <?php if($iZoomPos == 7){ echo "selected"; }?>>Right Center</option>
						<option value="8" <?php if($iZoomPos == 8){ echo "selected"; }?>>Right Bottom</option>
						<option value="9" <?php if($iZoomPos == 9){ echo "selected"; }?>>Bottom Left</option>
						<option value="10" <?php if($iZoomPos == 10){ echo "selected"; }?>>Bottom Right</option>
						<option value="11" <?php if($iZoomPos == 11){ echo "selected"; }?>>Bottom Center</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
				<input type="checkbox" name="map_type_control" id="map_type_control" <?php if($iMapTypeCtrl != ""){ echo "checked"; }?> onclick="GooglemaproutesSettings.optType();" />
				<label for="map_type_control">Map Type Control</label></td>
				<td>
					<label for="map_type" class="fl lbl_style">Type</label>
					<select title="select rows" name="map_type" id="map_type" <?php if($iMapTypeCtrl == ""){ echo "disabled"; }?> onchange="GooglemaproutesSettings.changeMapType();">
						<option value="0" <?php if($iMapTypeCtrl == 0){ echo "selected"; }?>>Bar</option>
						<option value="1" <?php if($iMapTypeCtrl == 1){ echo "selected"; }?>>Dropdown</option>
					</select>
				</td>
				<td>
					<label for="map_type_position" class="fl lbl_style">Position</label>
					<select title="select rows" name="map_type_position" id="map_type_position" <?php if($iMapTypeCtrlPos == ""){ echo "disabled"; }?> onchange="GooglemaproutesSettings.changeMapTypePosition();">
						<option value="0" <?php if($iMapTypeCtrlPos == 0){ echo "selected"; }?>>Top Left</option>
						<option value="1" <?php if($iMapTypeCtrlPos == 1){ echo "selected"; }?>>Top Right</option>
						<option value="2" <?php if($iMapTypeCtrlPos == 2){ echo "selected"; }?>>Top Center</option>
						<option value="3" <?php if($iMapTypeCtrlPos == 3){ echo "selected"; }?>>Left Top</option>
						<option value="4" <?php if($iMapTypeCtrlPos == 4){ echo "selected"; }?>>Left Center</option>
						<option value="5" <?php if($iMapTypeCtrlPos == 5){ echo "selected"; }?>>Left Bottom</option>
						<option value="6" <?php if($iMapTypeCtrlPos == 6 || $iMapTypeCtrlPos == ""){ echo "selected"; }?>>Right Top</option>
						<option value="7" <?php if($iMapTypeCtrlPos == 7){ echo "selected"; }?>>Right Center</option>
						<option value="8" <?php if($iMapTypeCtrlPos == 8){ echo "selected"; }?>>Right Bottom</option>
						<option value="9" <?php if($iMapTypeCtrlPos == 9){ echo "selected"; }?>>Bottom Left</option>
						<option value="10" <?php if($iMapTypeCtrlPos == 10){ echo "selected"; }?>>Bottom Right</option>
						<option value="11" <?php if($iMapTypeCtrlPos == 11){ echo "selected"; }?>>Bottom Center</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
				<input type="checkbox" name="scale_control" id="scale_control" <?php if($iScaleCtrlPos != ""){ echo "checked"; }?> onclick="GooglemaproutesSettings.optScale();"/>
				<label for="scale_control">Scale</label></td>
				<td colspan="2">
					<label for="scale_control_position" class="fl lbl_style">Position</label>
					<select title="select rows" class="rows" name="scale_control_position" id="scale_control_position" <?php if($iScaleCtrlPos == ""){ echo "disabled"; }?> onchange="GooglemaproutesSettings.changeScaleControlPosition();">
						<option value="0" <?php if($iScaleCtrlPos == 0){ echo "selected"; }?>>Top Left</option>
						<option value="1" <?php if($iScaleCtrlPos == 1){ echo "selected"; }?>>Top Right</option>
						<option value="2" <?php if($iScaleCtrlPos == 2){ echo "selected"; }?>>Top Center</option>
						<option value="3" <?php if($iScaleCtrlPos == 3){ echo "selected"; }?>>Left Top</option>
						<option value="4" <?php if($iScaleCtrlPos == 4){ echo "selected"; }?>>Left Center</option>
						<option value="5" <?php if($iScaleCtrlPos == 5){ echo "selected"; }?>>Left Bottom</option>
						<option value="6" <?php if($iScaleCtrlPos == 6){ echo "selected"; }?>>Right Top</option>
						<option value="7" <?php if($iScaleCtrlPos == 7){ echo "selected"; }?>>Right Center</option>
						<option value="8" <?php if($iScaleCtrlPos == 8){ echo "selected"; }?>>Right Bottom</option>
						<option value="9" <?php if($iScaleCtrlPos == 9){ echo "selected"; }?>>Bottom Left</option>
						<option value="10" <?php if($iScaleCtrlPos == 10){ echo "selected"; }?>>Bottom Right</option>
						<option value="11" <?php if($iScaleCtrlPos == 11 || $iScaleCtrlPos == ""){ echo "selected"; }?>>Bottom Center</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
				<input type="checkbox" name="street_view_control" id="street_view_control" <?php if($iStreetviewCtrlPos != ""){ echo "checked"; }?> onclick="GooglemaproutesSettings.optStreet();" />
				<label for="street_view_control">Street View Toggle</label></td>
				<td colspan="2">
					<label for="pg_googlemapsimple_streetviewposition" class="fl lbl_style">Position</label>
					<select title="select rows" class="rows" name="street_view_position" id="street_view_position" <?php if($iStreetviewCtrlPos == ""){ echo "disabled"; }?> onchange="GooglemaproutesSettings.changeStreetViewPosition();">
						<option value="0" <?php if($iStreetviewCtrlPos == 0 || $iStreetviewCtrlPos == ""){ echo"selected"; }?>>Top Left</option>
						<option value="1" <?php if($iStreetviewCtrlPos == 1){ echo"selected"; }?>>Top Right</option>
						<option value="2" <?php if($iStreetviewCtrlPos == 2){ echo"selected"; }?>>Top Center</option>
						<option value="3" <?php if($iStreetviewCtrlPos == 3){ echo"selected"; }?>>Left Top</option>
						<option value="4" <?php if($iStreetviewCtrlPos == 4){ echo"selected"; }?>>Left Center</option>
						<option value="5" <?php if($iStreetviewCtrlPos == 5){ echo"selected"; }?>>Left Bottom</option>
						<option value="6" <?php if($iStreetviewCtrlPos == 6){ echo"selected"; }?>>Right Top</option>
						<option value="7" <?php if($iStreetviewCtrlPos == 7){ echo"selected"; }?>>Right Center</option>
						<option value="8" <?php if($iStreetviewCtrlPos == 8){ echo"selected"; }?>>Right Bottom</option>
						<option value="9" <?php if($iStreetviewCtrlPos == 9){ echo"selected"; }?>>Bottom Left</option>
						<option value="10" <?php if($iStreetviewCtrlPos == 10){ echo"selected"; }?>>Bottom Right</option>
						<option value="11" <?php if($iStreetviewCtrlPos == 11){ echo"selected"; }?>>Bottom Center</option>
					</select>
				</td>
			</tr>
		</table>
		</div>
	</div>

	<div class="tbl_lb_wide_btn">
		<input type="button" class="btn_apply" value="Save" onclick="GooglemaproutesSettings.checkform()" />
		<a href="#" class="add_link" title="Reset to default" onclick="GooglemaproutesSettings.reset();return false;">Reset to Default</a>
	</div>
	<input type="hidden" id="pgdir" name="pgdir" value="<?php echo $sPgDir; ?>" />
	<input type="hidden" name="action" value="<?php echo $sAction; ?>" />
	<input type="hidden" name="mode" value="<?php echo $sMode; ?>" />
	<input type="hidden" name="id" value="<?php echo $iUserIdx; ?>" />
</form>


<!-- SET CENTER POPUP -->
<div id="google_map_center_list" style="width: 350px; z-index: 10002; left: 766px; top: 394px;display:none;"><h3 id="pop_header">Set Center</h3><div class="admin_popup_contents">
    <div class="input_area">
        <p>
            <label for="how">Address or Place</label>
            <input type="text" class="fix" value="" id="google_map_search_field">
            <a href="#" class="btn_nor_01 btn_width_st1" title="Set center" onclick="Googlemap.searchX();">Search</a>
        </p>
    </div>

    <div id="google_map_center_list_contents">
        <div id="address_list"><ul class="place_check_list"></ul></div>

        <div class="ly_cnt_btn"><a href="#" class="btn_ly" title="Set center" onclick="Googlemap._setCenter();">Set Center</a></div>
    </div>
</div><a href="#none" class="clse" title="popup close" onclick="popup.close('google_map_center_list', true)">X</a></div>

<!-- MARKER POPUP -->
<div id="google_map_marker_search" style="width: 650px; top: 409px; left: 627px; z-index: 10002;display:none;"><h3 id="pop_header">Insert Google Marker</h3><div class="admin_popup_contents">
    <p class="require"><span class="neccesary">*</span> Required</p>
    <form id="google_map_marker_search_form">
    <table border="1" cellspacing="0" class="table_input_vr tbl_zero">
    <colgroup>
        <col width="200px">
        <col width="*">
    </colgroup>
    <tbody><tr>
        <th>
            <ul class="marker_type">
                <li>
                    <label for="marker_01"><img src="/_sdk/img/googlemaproutes/icon_marker_01.png" alt="google marker 1"></label>
                    <input type="radio" name="marker_type" id="marker_01" class="input_rdo" checked="checked" value="1">
                </li>
                <li>
                    <label for="marker_02"><img src="/_sdk/img/googlemaproutes/icon_marker_02.png" alt="google marker 2"></label>
                    <input type="radio" name="marker_type" id="marker_02" class="input_rdo" value="2">
                </li>
                <li>
                    <label for="marker_03"><img src="/_sdk/img/googlemaproutes/icon_marker_03.png" alt="google marker 3"></label>
                    <input type="radio" name="marker_type" id="marker_03" class="input_rdo" value="3">
                </li>
                <li>
                    <label for="marker_04"><img src="/_sdk/img/googlemaproutes/icon_marker_04.png" alt="google marker 4"></label>
                    <input type="radio" name="marker_type" id="marker_04" class="input_rdo" value="4">
                </li>
                <li>
                    <label for="marker_05"><img src="/_sdk/img/googlemaproutes/icon_marker_05.png" alt="google marker 5"></label>
                    <input type="radio" name="marker_type" id="marker_05" class="input_rdo" value="5">
                </li>
            </ul>
            <span class="neccesary">*</span>
        </th>
        <td class="align_top">
            <span id="marker_wrap"><input type="text" id="google_map_marker_search_field" class="_validate" filter="fill[0]"></span>
            <span class="annonce_vr">Please enter Adress or Place.</span>
        </td>
    </tr>
    </tbody></table>
    </form>
    <div class="ly_cnt_btn"><a href="#" class="btn_ly" title="Add new marker" onclick="GooglemaproutesSettings.openPopupMarkerSearch();">Add New Marker</a></div>
</div><a href="#none" class="clse" title="popup close" onclick="popup.close('google_map_marker_search', true)">X</a></div>

<!-- MARKER SEARCH -->
<div id="google_map_marker_search_list" style="width: 350px; z-index: 10002; left: 766px; top: 394px;display:none;"><h3 id="pop_header">Search</h3><div class="admin_popup_contents">
    <div class="input_area">
        <p>
            <label for="how">Address or Place</label>
            <input type="text" class="_validate fix" value="" id="google_map_mark_search_field" filter="fill[0]">
            <a href="#" class="btn_nor_01 btn_width_st1" title="Set center" onclick="Googlemap.searchXMark();">Search</a>
        </p>
    </div>

    <div id="google_map_mark_search_list_contents">
        <div id="address_list_mark"><ul class="place_check_list"></ul></div>

        <div class="ly_cnt_btn"><a href="#" class="btn_ly" title="Add Marker" onclick="Googlemap._setMarker();">Add Marker</a></div>
    </div>
</div><a href="#none" class="clse" title="popup close" onclick="popup.close('google_map_center_list', true)">X</a></div>

<!-- SET ROUTE -->
<div id="google_map_route_search" class="ly_set ly_mod_wid" style="width: 350px; top: 339px; left: 777px; z-index: 10008;display:none;"><h3 id="pop_header">Set Route</h3><div class="admin_popup_contents">
    <div class="input_area">
        <p>
            <label for="how">Address or Place</label>
            <input type="text" class="fix" value="" id="google_map_route_search_field">
            <a href="#none" id="google_map_route_search_field_button" class="btn_nor_01 btn_width_st1" title="Set center" onclick="Googlemap.searchXRoute();">Search</a>
        </p>
    </div>

    <div id="route_list"><ul class="place_check_list"><li><label><input class="input_rdo" name="google_search_result" type="radio" checked="checked" value="15.4897222::::120.97055560000001">Cabanatuan City, Philippines</label></li><ul></ul></ul></div>

    <div class="ly_cnt_btn"><a href="#" class="btn_ly" title="Set route" onclick="Googlemap._setRoute();">Set Route</a></div>
</div><a href="#none" class="clse" title="popup close" onclick="popup.close('google_map_route_search', true)">X</a></div>
