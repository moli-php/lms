var lmsForum	= {};

require({
	baseUrl:	'/js/forum/',
	// priority: ['https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js']
	priority: ['http://lms.dev.com/js/jquery.js']
}, ['order!underscore', 'order!backbone', 'order!jquery-ui-1.8.20.custom.min', 'order!app/forum_fn_helper', 'order!app/forum_tmpl', 'order!app/forum_main_app', 'order!app/jquery.validate']);