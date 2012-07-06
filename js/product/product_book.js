var productBook = {
	addBook : function(){
		var sUrl = common.getClassUrl("productBookAdd");
		location.href = sUrl;
	},
	
	validate : function(){
		var result = $("#productBookForm").validateForm();

		if (result === true){
			$("#productBookForm").ajaxSubmit({
				url : common.getClassUrl("productExecute"),
				dataType : "html",
				type : "post",
				data : {
					exec : "saveBook"
				},
				success : function(aData){
					location.href = common.getClassUrl("productBook");
				}
			});
		}
	}
};

$(document).ready(function(){
	$("#image_upload, #file_upload").click(function(){
		var name = $(this).attr("id");
		$("[name='" + name + "']").click().unbind("change").change(function(){
			if ($(this).attr("name") == "image_upload"){
				$("#productBookForm").ajaxSubmit({
					url : common.getClassUrl("productExecute"),
					dataType : "json",
					type : "post",
					data : {
						exec : "uploadImage"
					},
					success : function(aData){
						if (aData.result == "success") {
							$("#display_image").attr("src", common.getBaseUrl() + "/image.php?h=300&cr=8:10&path=" + aData.data);
							$("[name='image_path']").val(aData.data);
						} else {
							alert("Failed to upload");
						}
					}
				});
			}
		});
	});
});