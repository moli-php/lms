<div class="topic_dialog" >	
	<div class="addTopic_dialog">
		<form name="addTopic_form" id="addTopic_form">
			<table style="">
				<colgroup>
					<col width="40px"  />
					<col />
					<col width="80px"  />
				</colgroup>
				<tbody>
					<tr style="height:30px">
						<td colspan="1" style="text-align:left"><label style="font-weight:bold">Title&#58;</label></td>
						<td colspan="2" style="text-align:left"><input type="text" name="title" style="width:300px;" validate="required" /></td>
					</tr>
					<tr style="height:30px">
						<td colspan="1" style="text-align:left"><label style="font-weight:bold">Row&#58;</label></td>
						<td colspan="2" style="text-align:left"><input type="text" name="row" style="width:300px;" validate="required" /></td>
					</tr>
					<tr>
						<td colspan="3">
							<!--<textarea  class="add_topic" id="add_topic_form" cols="63" rows="5" validate="required" ></textarea>-->
							<textarea  class="add_topic" id="add_topic_form" cols="63" rows="5" validate="required" ></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:left">
							<!--<img class="topic_file" src="/images/no_picture.png" alt="No Image" width="100px" />-->
							<!--<div style="display:inline-block;width:100px;height:100px;background:#777;text-align:center"></div>-->
						</td>
					</tr>
					<tr style="height:30px;">
						<td colspan="1" style="text-align:left"><label class="file_label" style="font-weight:bold">File&#58;</label></td>
						<td colspan="1" style="text-align:left; padding-bottom: 10px;">
							<a href="javascript:void(0)" class="btn_save thread_attach_file">Attach File</a>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height:100%;padding-left:35px;text-align:left;">
							<img class="uploaded_img" alt="image" style="display: none;">
							<div class="uploaded_filename" style="display:none;">
								<a class="file_btn" href="javascript:void(0)">file</a><a class="delete_uploaded" href="javascript:void(0)"></a>
							</div>
							<div class="uploaded_rename" style="display:none;">
								<input type="text" name="attach_file_name" style="width: 200px;" validate="required" value="file.jpg" />
								<input type="hidden" name="attach_file_ext" />
								<input type="hidden" name="nameid" />
								<a class="rename_btn" href="javascript:void(0)">Rename</a></a>
							</div>
						</td>
					</tr>
					<tr style="height=40px;">
						<!--<td style="text-align:left"><a href="javascript:void(0);" class="btn_save fr addTopicFile" title="File">Browse</a></td>-->
						<td colspan="3"><a href="javascript:void(0);" class="btn_save fr addTopicBtn" title="Add">Add</a></td>
					</tr>							
				</tbody>
			</table>			
		</form>		
		<iframe style="display: none; float: right; margin-right: 200px;" class="fileupload_iframe" /></iframe>
	</div>
</div>