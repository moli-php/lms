$(document).ready(function(){
    PLUGIN_Flickr_admin.change_display();
});

var PLUGIN_Flickr_admin = {
	
	initialize : function()
	{
		var mode = $('#flickr_page_mode').val();

		if(mode == "") $('#flickr_key').focus();	
	},
	
	CheckForm : function()
	{
	    if(!oValidator.formName.getMessage('flickr_setup_form'))
            oValidator.generalPurpose.getMessage(false, "Fill all required fields.");
        else
            document.flickr_setup_form.submit();
	},
	
	is_numeric : function (input)
	{
		return (input - 0) == input && input.length > 0;
	},
	
	reset : function()
	{
		$('#flickr_template_0').attr('checked', true);
		$('#flickr_target_0').attr('checked', true);
		$('#flickr_disp_type_0').attr('checked', true);
		$('#flickr_photo_num').val(5);
		PLUGIN_Flickr_admin.change_display();
	},

	change_display : function()
	{
	    attr = $('#flickr_disp_type_1').is(':checked') ? 'none' : '';
	    $('.tr_flickr_dispnum').css('display', attr);
	}
};