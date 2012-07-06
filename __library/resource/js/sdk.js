var usbuilder = {
	getUrl : function(sClassName) {
           sUrl = '/resource.php?fetch=' + sClassName + '&type=api&ext=php&modules=' + includedModules;
           return sUrl;
	}
}