Backbone.emulateHTTP = true;
Backbone.emulateJSON = true;

lmsForum.mainGlobal	= {
	categoryPageRow		: 3,
	categorySearch_globals:	{
								page: 	'',
								total:	''
							},
	tinyMce_image_display: 'image,',
	custom_tinyMCE_init:	{
		mode : 'specific_textareas',
		editor_selector : 'html_editor',
		theme : 'advanced',
		plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',

		theme_advanced_buttons1 : 'newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : ',search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,'+this.tinyMce_image_display+'cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
		
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : true
	}
};


lmsForum.backendForm = Backbone.Model.extend({
    initialize: function(x){},
    urlRoot: 'controller/forum_backend_form.php'
});

// Read/Get category data(model)
lmsForum.categoryBackend = Backbone.Model.extend({
    initialize: function(x){},
    urlRoot: 'controller/forum_category_backend.php'
});

// Read/Get topic list data(model)
lmsForum.topicBackend = Backbone.Model.extend({
    initialize: function(x){},
    urlRoot: 'controller/forum_topic_backend.php'
});

// Topic thread data(model)
lmsForum.threadBackend = Backbone.Model.extend({
    initialize: function(x){},
    urlRoot: 'controller/forum_topic_thread_backend.php'
});

lmsForum.imgLoader	= function(){
	$('.wrap').append('<div class="loader" style="top:45%; left:49%;"></div>');
}

// Category Router
lmsForum.categoryRouter	= Backbone.Router.extend({
	routes:{
			'':									'landingPage',
			'form/category/:action':			'formCategory',
			'category/page:id':					'categoryList',
			'category/search=:title/page:id':	'categorySearch',
			':404': 							'notFound',
			':404/:404': 						'notFound',
			':404/:404/:404': 					'notFound'
	},
	
	notFound:	function(){
		$('div#mainforum_container')
		.html('\
			<div class="error_page">\
			<img  class="error_image" src="'+common.getBaseUrl()+'/images/error404.png"  alt="ERROR 404" />\
			<h2 class="error404_title">error 404 - page not found</h2>\
			<a href="'+common.getBaseUrl()+'/admin/forum" class="forum_btns" title="Back">Back</a>\
			</div>\
		');
		
	},
	
	landingPage: function(){
		var curPage	= 1;
		
		new lmsForum.categoryRouter().categoryList(curPage);
		
		return false;
	},
	
	categoryList: function(p){
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}

		var curPage	= parseInt(p); 
		
		$('table.category_list_tbl tbody tr').remove();
		
		return new lmsForum.categoryBackend({id:'categorypager'+p+'_row'+lmsForum.mainGlobal.categoryPageRow}).fetch({
			error: function(model, response) {
				console.log('ERROR!!!!');
				console.log(response);
			},
			success: function(model, response)  {				
				$('div#mainforum_container').load('tpl/category_list.tpl', function(){
					$('div#mainforum_container')
					.css({'text-align': 'left', 'padding': '0'});
					
					var rowCntr	= 1;
					$('table.category_list_tbl tbody tr').remove();
					$.each(response.rows, function(k,v){
						if(rowCntr <= lmsForum.mainGlobal.categoryPageRow){
							var raw_date		= new Date(parseInt(v[3]) * 1000);
							var reg_date		= raw_date.getMonth() +'/'+ raw_date.getDate() +'/'+ raw_date.getFullYear();
							var fields			= {'fcid': v[0], 'name': v[1], 'style': v[2], 'regdate': reg_date, 'uid': v[4], 'session_uid': v.session.idx};

							$('table.category_list_tbl tbody').append(lmsForum.tmpl.categoryList(fields));
							$('tr#category-tr-id-'+fields['fcid']);
						}
						rowCntr++;
					});
					$('.wrap .loader').fadeOut();
					
					if(window.location.href.indexOf('#') !== -1){
						var pageMode	= window.location.href.split('#')[1].split('/')[1];//.split('=')[0];
						if(pageMode.indexOf('=') !== -1){
							var search	= window.location.href.split('#')[1].split('/')[1].split('=')[1];
							var uri		= 'category/search='+search+'/page';
							var total	= lmsForum.mainGlobal.categorySearch_globals.total;
							
							$('input[name="search_box"]').val(search);
						}else{
							var total	= response.total_rows;
							var uri		= 'category/page';
						}
					}else{
						var total	= response.total_rows;
						var uri		= 'category/page';
					}

					var _pager	= Math.ceil(total / lmsForum.mainGlobal.categoryPageRow);
					if(_pager > 1){
						$('div.pagination').remove();
						$('.bottom_2').append(lmsForum.tmpl.paginationTmpl(curPage,lmsForum.mainGlobal.categoryPageRow,total,uri)).hide().fadeIn();
					}
				});			
			}
		});		
	},
	
	formCategory: function(p){
		var data				= {};
		
		if(p === 'add'){
			// Add category
			data['crud']			= 'view_category_style_grade';
			data['forum_section']	= 'category';
			data['id']				= p;
			
			$('.menu_title_breadcrumb').html('Add New Category');
			$('div#mainforum_container').children().remove();
			
			var addCategory	= new lmsForum.categoryBackend(data);
			addCategory.save(null, {success: function(model, response){
				$('div#mainforum_container').load('tpl/category_form.tpl', function(){
					$('.category_form_btn').text('Add');
					// Style List
					$('select.style_list option').remove();
					$.each(response.style_list, function(k,v){
						$('select.style_list').append('<option value="'+v.fsid+'">'+v.name+'</option>').hide().fadeIn();
					});
					
					// Grade List
					$('select.grade_list option').remove();
					$.each(response.grade_list, function(k,v){
						$('select.grade_list').append('<option value="'+v.grade_num+'">'+v.grade_name+'</option>').hide().fadeIn();
					});
				}).hide().fadeIn();
			}});	
		}
		else{
			// Update category
			data['crud']			= 'r';
			data['forum_section']	= 'category';
			data['id']				= p;
			
			var updateCategory		= new lmsForum.categoryBackend(data);
			updateCategory.save(null, {success: function(model, response){
				$('.menu_title_breadcrumb').html('Update Category');
				$('div#mainforum_container').children().remove();
							
				$('div#mainforum_container').load('tpl/category_form.tpl', function(){
					$('form[name="category_form"] input[name="fcid"]').remove();
					$('form[name="category_form"]').append('<input type="hidden" name="fcid" value="'+data['id']+'" />').hide().fadeIn();
					$('.category_form_btn').text('Update');
					
					// Style List
					$('select.style_list option').remove();
					$.each(response.style_list, function(k,v){
						if(response.category_form.fsid === v.fsid){
							$('select.style_list').append('<option value="'+v.fsid+'" selected>'+v.name+'</option>').hide().fadeIn();
						}else{
							$('select.style_list').append('<option value="'+v.fsid+'">'+v.name+'</option>').hide().fadeIn();
						}
					});
					
					// Grade List
					$('select.grade_list option').remove();
					$.each(response.grade_list, function(k,v){
						// Read Authority
						if(response.category_form.read_auth === v.grade_num){
							$('select.grade_list[name="read_auth"]').append('<option value="'+v.grade_num+'" selected>'+v.grade_name+'</option>').hide().fadeIn();
						}else{
							$('select.grade_list[name="read_auth"]').append('<option value="'+v.grade_num+'">'+v.grade_name+'</option>').hide().fadeIn();
						}
						
						// Write Authority
						if(response.category_form.write_auth === v.grade_num){
							$('select.grade_list[name="write_auth"]').append('<option value="'+v.grade_num+'" selected>'+v.grade_name+'</option>').hide().fadeIn();
						}else{
							$('select.grade_list[name="write_auth"]').append('<option value="'+v.grade_num+'">'+v.grade_name+'</option>').hide().fadeIn();
						}
					});
					
					$('input[name="category_title"]').val(response.category_form.name);									// Category Title
					$('input[name="this_category_row"]').val(response.category_form.row);								// Category Row				
					$('input[name="attachment"]:eq('+response.category_form.file_attach+')').attr('checked', true);		// Allow File Attachment
					$('input[name="img_display"]:eq('+response.category_form.image_display+')').attr('checked', true);	// Allow Image Display
					$('input[name="allow_reply"]:eq('+response.category_form.allow_reply+')').attr('checked', true);	// Allow Reply
				}).hide().fadeIn();		
			}});						
		}
	},
	
	categorySearch:	function(title,page){
		$('#mainforum_container').css({'padding': '0'});
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}

		var data				= {};
		data['page']			= page;
		data['row_limit']		= lmsForum.mainGlobal.categoryPageRow;
		data['title']			= title;
		data['crud']			= 'search';
		data['forum_section']	= 'category';
		data['id']				= page;
		
		var _searchCategory	= new lmsForum.categoryBackend(data);
		_searchCategory.save(null, {success: function(model, response){
			$('div#mainforum_container').load('tpl/category_list.tpl', function(){
				$('.reset_searchBtn').show();
				if(response.total !== 0){
					$('input[name="search_box"]').val(title);
					$('table.category_list_tbl tbody tr').remove();
					$.each(response.rows, function(k,v){
							var fields	= {'fcid': v.fcid, 'name': v.category_name, 'style': v.style_name, 'regdate': v.regdate};
							$('table.category_list_tbl tbody').append(lmsForum.tmpl.categoryList(fields));
							$('tr#category-tr-id-'+fields['fcid']).fadeIn();
					});
					$('.wrap .loader').fadeOut().remove();
					var uri	= 'category/search='+title+'/page';
					$('div.pagination').remove();
					$('.bottom_2').append(lmsForum.tmpl.paginationTmpl(page,lmsForum.mainGlobal.categoryPageRow,response.total,uri)).hide().fadeIn();	
					lmsForum.mainGlobal.categorySearch_globals.page		= page;
					lmsForum.mainGlobal.categorySearch_globals.total	= response.total;
				}else{
					$('input[name="search_box"]').val(title);
					$('.changeRow, .delete_category, .show_rows').hide();
					$('table.category_list_tbl tbody').append('<tr><td colspan="6"><strong style="display: block;">No results found.</strong><span style="color: gray;">Check your spelling or try another term.</span></td></tr>');
				}
			});			
		}});
	}
});

// Topic router
lmsForum.topicRouter	= Backbone.Router.extend({
	routes:{
			'topic/list/:topic/:id/page:pager': 				'topicList',
			'topic/thread/:topic/:id/pager:pager':				'topicThread',
			'topic/list/:topic/:id/search=:title/page:pager':	'searchTopicRouter',
			':404/:404/:404/:404/:404/:404':					'notFound',
			':404/:404/:404/:404/:404': 						'notFound'
	},
	
	notFound:	function(){
		$('div#mainforum_container')
		.html('\
			<div class="error_page">\
			<img  class="error_image" src="'+common.getBaseUrl()+'/images/error404.png"  alt="ERROR 404" />\
			<h2 class="error404_title">error 404 - page not found</h2>\
			<a href="'+common.getBaseUrl()+'/admin/forum" class="forum_btns" title="Back">Back</a>\
			</div>\
		');
	},
	
	topicList:	function(topic,fcid,pager){
		// Delete validation message if there's any
		$('#message_wrap_con #message_con').remove();
		$('#mainforum_container').css({'padding': '0'});
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}
		
		var fcid				= fcid;
		var topicpager			= pager;
		var data				= {};
		
		data['crud']			= 'topic_row';
		data['forum_section']	= 'topic';
		data['fcid']			= fcid;
		data['id']				= fcid;

		var getTopicRow			= new lmsForum.topicBackend(data);
		
		getTopicRow.save(null, {success: function(model, response){
			var topicrow			= response.row;

			$('div#mainforum_container, div#category_hidden').children().remove();
			$('div#mainforum_container').load('tpl/topic_list.tpl', function(){
				$('.forum_child_container').fadeIn();
				return new lmsForum.topicBackend({id: 'pager'+topicpager+'_row'+topicrow+'_fcid'+fcid}).fetch({
					error: function(model, response) {
						console.log('ERROR!!!!');
						console.log(response);
					},
					success: function(model, response)  {
						// Allow image display?
						if(parseInt(response.category[0].image_display) === 0){
							lmsForum.mainGlobal.tinyMce_image_display	= '';
						}else{
							lmsForum.mainGlobal.tinyMce_image_display	= 'image,';
						}
						
						tinyMCE.init({
							mode : 'specific_textareas',
							editor_selector : 'html_editor',
							theme : 'advanced',
							plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',

							theme_advanced_buttons1 : 'newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
							theme_advanced_buttons2 : ',search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,'+lmsForum.mainGlobal.tinyMce_image_display+'cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
							theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
							
							theme_advanced_toolbar_location : 'top',
							theme_advanced_toolbar_align : 'left',
							theme_advanced_statusbar_location : 'bottom',
							theme_advanced_resizing : true
						});
						
						$('div.forum_style1').attr('class', 'forum_style'+response.style);
						$('.forum_category').text(topic);
						if(response.category[0].logo !== ''){
							$('.forum_header').append('<img class="category_img" src="'+common.getBaseUrl()+'/uploads/forum/category/'+response.category[0].logo+'" />');
						}

						$('table.topic_list_tbl tbody tr').remove();
						
						if(response.rows.length > 0){
							$.each(response, function(k,v){
								if(k !== 'style' && k !== 'total_rows' && k !== 'category' && k !== 'session'){
									$.each(v, function(k,v){
										var post_date		= new Date(parseInt(v.post_date) * 1000);
										var posted_date		= post_date.getMonth() +'/'+ post_date.getDate() +'/'+ post_date.getFullYear();
										var fields			= {'fpid': v.fpid, 'uid': v.uid, 'title': v.title, 'post_date': posted_date, 'username': v.user_id, 'session_uid': response.session.idx};
										
										$('table.topic_list_tbl tbody').append(lmsForum.tmpl.topicList(fields));
										$('tr#post-tr-id-'+fields['fpid']).fadeIn();
									});
								}
							});
						}else{
							var td	= '<td colspan="6"><strong>There is no post in this category, you can start a discussion by adding a new topic.</strong></td>';
							$('table.topic_list_tbl tbody').append('<tr>'+td+'</tr>');
						}
						
						$('.wrap .loader').fadeOut();
						
						var elmTopic	= '<input type="hidden" name="topic" value="'+topic+'" />';
						var elmFcid		= '<input type="hidden" name="fcid" value="'+fcid+'" />';
						var elmPager	= '<input type="hidden" name="pager" value="'+pager+'" />';
						
						$('div#mainforum_container').append('<div id="category_hidden">'+elmTopic+elmFcid+elmPager+'</div>');
						
						
						var _pager	= Math.ceil(response.total_rows / topicrow);
						if(_pager > 1){
							var uri	= 'topic/list/'+response.category[0].name+'/'+fcid+'/page';

							$('div.pagination').remove();
							$('.forum_bottom2').append(lmsForum.tmpl.paginationTmpl(topicpager,topicrow,response.total_rows,uri)).hide().fadeIn();			
						}

						if($('.file_attach_stat').is(':visible') !== true){
							$('#mainforum_container').append('<input type="hidden" name="file_attach_stat" class="file_attach_stat" value="'+response.category[0].file_attach+'" />');
						}
					}
				});
			});
		}});		
	},
	
	topicThread:	function(topic,fpid,pager){
		$('#mainforum_container').css({'padding': '0'});
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}
		
		var topic	= topic;
		var fpid	= fpid;
		var pager	= pager;
		
		$('div#mainforum_container, div#category_hidden').children().remove();
		$('div#mainforum_container').load('tpl/topic_thread.tpl', function(){
			var data				= {};
			
			data['pager']			= pager;
			data['crud']			= 'r';
			data['forum_section']	= 'thread';
			data['id']				= fpid;
			data['fpid']			= data['id'];
			var viewThread			= new lmsForum.threadBackend(data);
			
			viewThread.save(null, {success: function(model, response){	
				// Allow image display?
				if(parseInt(response.image_display) === 0){
					lmsForum.mainGlobal.tinyMce_image_display	= '';
				}else{
					lmsForum.mainGlobal.tinyMce_image_display	= 'image,';
				}
				
				tinyMCE.init({
					mode : 'specific_textareas',
					editor_selector : 'html_editor',
					theme : 'advanced',
					plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',

					theme_advanced_buttons1 : 'newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
					theme_advanced_buttons2 : ',search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,'+lmsForum.mainGlobal.tinyMce_image_display+'cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
					theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
					
					theme_advanced_toolbar_location : 'top',
					theme_advanced_toolbar_align : 'left',
					theme_advanced_statusbar_location : 'bottom',
					theme_advanced_resizing : true
				});
			
				$('div.forum_style1').attr('class', 'forum_style'+response.style);
				
				if(parseInt(pager) === 1){
					if(response.orig_post[0].modified_date === ''){
						var post_date		= new Date(parseInt(response.orig_post[0].post_date) * 1000);
						var orig_post_date	= post_date.getMonth() +'/'+ post_date.getDate() +'/'+ post_date.getFullYear();
						$('.orig_post_date').html('&nbsp;Posted : ['+orig_post_date+']');
					}else{
						var modified_date		= new Date(parseInt(response.orig_post[0].modified_date) * 1000);
						var orig_modified_date	= modified_date.getMonth() +'/'+ modified_date.getDate() +'/'+ modified_date.getFullYear();
						$('.orig_post_date').html('&nbsp;Modified : ['+orig_modified_date+']');
					}
					
					$('.orig_post').show();
					
					var mainPostContent = response.orig_post[0].title+'<br /><br />'+response.orig_post[0].content;
					$('.orig_post_content').html(mainPostContent);
					$('a.orig_post_author').html(response.orig_post[0].user_id);
					
					// File attach download
					if(response.orig_post[0].attach_file_detail !== undefined && parseInt(response.allow_file_attach) !== 0){
						$('.orig_post_content').append('<br /><a class="file_btn" href="'+common.getBaseUrl()+'/admin/forum/controller/downloader.php?file='+response.orig_post[0].attach_file_detail.nameid+'">'+response.orig_post[0].attach_file_detail.name+'</a>');
					}
					
					var date_reg		= new Date(parseInt(response.orig_post[0].date_reg) * 1000);
					var member_since	= date_reg.getMonth() +'/'+ date_reg.getDate() +'/'+ date_reg.getFullYear();
					$('p.orig_author_member_since').html('Member Since['+member_since+']');
					
					// Profile Picture
					$('.orig_author_profile')
					.attr('src', common.getBaseUrl()+'/uploads/'+response.orig_post[0].profile_img)
					.css({'height': '100px'});
					
					if(response.orig_post[0].uid === response.session.idx){
						$('.thread_edit_btn, .thread_delete_btn').show();
					}					
					
					if(parseInt(response.allow_reply) === 0){
						var li	= '	<li class="rows">\
										<table border="0" cellspacing="0" cellpadding="0" class="postbody">\
											<colgroup>\
												<col width="*"/>\
												<col/>\
											</colgroup>\
											<tr>\
												<td style="text-align: center;" colspan="2" class="postcontent comment_post_content">Comment is disabled. Please contact your administrator to start a discussion.</td>\
											</tr>\
										</table>\
									</li>\
									';
						
						$('div.thread_container ul.posts').append(li);
					}else{
						$('.thread_reply_btn, .thread_quote_btn, .reply').show();
					}
				}
				
				$('div.thread_container ul.posts li.comment_rows').remove();
				$.each(response.replies, function(k,v){
					var _reply_date;
					if(v.modified_date === ''){
						var raw_reply_date		= new Date(parseInt(v.reply_date) * 1000);
						_reply_date	= '&nbsp;Posted: ['+raw_reply_date.getMonth() +'/'+ raw_reply_date.getDate() +'/'+ raw_reply_date.getFullYear()+']';
					}else{
						var raw_modified_date		= new Date(parseInt(v.modified_date) * 1000);
						_reply_date	= '&nbsp;Modified: ['+raw_modified_date.getMonth() +'/'+ raw_modified_date.getDate() +'/'+ raw_modified_date.getFullYear()+']';
					}
					
					var fields	= {	
									'fpcid': 		v.fpcid, 
									'comment': 		v.comment, 
									'author': 		v.user_id, 
									'profile_img': 	common.getBaseUrl()+'/uploads/'+v.profile_img,
									'member_since':	new Date(parseInt(v.date_reg) * 1000).getMonth() +'/'+ new Date(parseInt(v.date_reg) * 1000).getDate() +'/'+ new Date(parseInt(v.date_reg) * 1000).getFullYear(),
									'reply_date':	_reply_date,
									'uid':			v.uid,
									'session_uid':	response.session.idx
								};
					
					if(parseInt(response.allow_reply) === 0){
						var li	= '	<li class="rows comment_rows">\
										<table border="0" cellspacing="0" cellpadding="0" class="postbody">\
											<colgroup>\
												<col width="*"/>\
												<col/>\
											</colgroup>\
											<tr>\
												<td style="text-align: center;" colspan="2" class="postcontent comment_post_content">Comment is disabled. Please contact your administrator to start a discussion.</td>\
											</tr>\
										</table>\
									</li>\
									';
						if(k === 0){
							$('div.thread_container ul.posts').append(li);
						}
					}else{
						$('.thread_reply_btn, .thread_quote_btn, .reply').show();
						$('div.thread_container ul.posts').append(lmsForum.tmpl.commentList(fields));
						$('li#comment-id-'+fields.fpcid).fadeIn();
						
						var _pager	= Math.ceil((parseInt(response.total_rows[0].total) + 1) / response.orig_post[0].row);

						if(_pager > 1){
							var uri	= 'topic/thread/'+topic+'/'+fpid+'/pager';
							$('div.pagination').remove();
							$('.forum_bottom2').append(lmsForum.tmpl.paginationTmpl(pager,response.orig_post[0].row,(parseInt(response.total_rows[0].total) + 1),uri)).hide().fadeIn();
						}
					}
				});													
			}});
		}).hide().fadeIn();
		$('.wrap .loader').fadeOut();
		return false;
	},
	
	searchTopicRouter:	function(category,fcid,search,pager){
		$('#mainforum_container').css({'padding': '0'});
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}

		var data				= {};
		data['title']			= search;
		data['fcid']			= fcid;
		data['page']			= pager;
		data['crud']			= 'search';
		data['forum_section']	= 'topic';
		data['id']				= data['fcid'];
		
		var _searchTopic		= new lmsForum.topicBackend(data);
		_searchTopic.save(null, {success: function(model, response){
			$('.wrap .loader').fadeOut().remove();
			if($('.forum_child_container').is(':visible') === false){
				$('div#mainforum_container, div#category_hidden').children().remove();
				$('div#mainforum_container').load('tpl/topic_list.tpl', function(){
					$('.reset_searchTopicBtn').show();
					$('input[name="search_box"]').val(search);
					$('.forum_child_container').fadeIn();
					$('div.forum_style1').attr('class', 'forum_style'+response.style);
					$('.forum_category').text(category);
					$('table.topic_list_tbl tbody tr').remove();
					$.each(response, function(k,v){
						if(k !== 'style' && k !== 'total_rows' && k !== 'session' && k !== 'category'){
							$.each(v, function(k,v){
								var post_date		= new Date(parseInt(v.post_date) * 1000);
								var posted_date		= post_date.getMonth() +'/'+ post_date.getDate() +'/'+ post_date.getFullYear();
								var fields			= {'fpid': v.fpid, 'uid': v.uid, 'title': v.title, 'post_date': posted_date, 'username': v.user_id};
								
								$('table.topic_list_tbl tbody').append(lmsForum.tmpl.topicList(fields));
								$('tr#post-tr-id-'+fields['fpid']).fadeIn();
							});
						}
					});
					
					var category	= window.location.href.split('#')[1].split('/')[2];
					var uri			= 'topic/list/'+category+'/'+data['fcid']+'/search='+data['title']+'/page';
					
					var _pager	= Math.ceil(response.total_rows / 3);
					if(_pager > 1){
						$('div.pagination').remove();
						$('.forum_bottom2').append(lmsForum.tmpl.paginationTmpl(pager,3,response.total_rows,uri)).hide().fadeIn();
					}					
				});
			}else{
				$('input[name="search_box"]').val(search);
				$('table.topic_list_tbl tbody tr').remove();
				$.each(response, function(k,v){
					if(k !== 'style' && k !== 'total_rows'){
						$.each(v, function(k,v){
							var post_date		= new Date(parseInt(v.post_date) * 1000);
							var posted_date		= post_date.getMonth() +'/'+ post_date.getDate() +'/'+ post_date.getFullYear();
							var fields			= {'fpid': v.fpid, 'uid': v.uid, 'title': v.title, 'post_date': posted_date, 'username': v.user_id};
							
							$('table.topic_list_tbl tbody').append(lmsForum.tmpl.topicList(fields));
							$('tr#post-tr-id-'+fields['fpid']).fadeIn();
						});
					}
				});
				
				
				var category	= window.location.href.split('#')[1].split('/')[2];
				var uri			= 'topic/list/'+category+'/'+data['fcid']+'/search='+data['title']+'/page';
				
				$('div.pagination').remove();
				$('.forum_bottom2').append(lmsForum.tmpl.paginationTmpl(pager,3,response.total_rows,uri)).hide().fadeIn();
			}
		}});
	}
});

// Test View
lmsForum.categoryList	= Backbone.View.extend({
	initialize:	function(){},
	
	el: 'div#mainforum_container',

	events: {
		'click .back_to_category_list': 						'_categoryList',
		'click .category_form_btn':								'categoryForm',
		'click .delete_category':								'deleteCategory',
		'click input[name="category_list_checkbox_header"]':	'selectAllCheckbox',
		'change .changeRow':									'changeRow',
		'click .searchBtn_category':							'searchCategory',
		'click .reset_searchBtn':								'resetSearchCategory',
		'click .delete_category_topic':							'deleteCategoryTopic',
		'click .addCategory':									'addCategory',
		'click .modify_category':								'modifyCategory'		
	},
	
	_categoryList:	function(){		
		window.history.back();
		
		return false;
	},
	
	categoryForm: function(e){
		var clickedEl 	= $(e.currentTarget);
		var method 		= clickedEl.text();
		var data		= {};
		
		$.each($('form[name="category_form"]').serialize().split('&'), function(k, v){
			data[v.split('=')[0]]	= v.split('=')[1];
		});
		
		var valid	= $('form[name="category_form"]').validateForm();
		
		if(valid === true){
			if(method === 'Update'){			
				data['crud']			= 'u';
				data['forum_section']	= 'category';
				data['id']				= data['fcid'];
				
				var updateCategory	= new lmsForum.categoryBackend(data);
				updateCategory.save(null, {success: function(model, response){
					if(response[0] !== false){
						Menu.message("success","Update Successful!");
						setTimeout(function(){
							window.history.back();
						}, 4500);
					}else{
						Menu.message('warning','Update Error!');
					}					
				}});
			}
			else if(method === 'Add'){
				data['crud']			= 'c';
				data['forum_section']	= 'category';
				data['id']				= data['fcid'];
				
				var addCategory	= new lmsForum.categoryBackend(data);
				addCategory.save(null, {success: function(model, response){
					if(response.stat !== false){
						Menu.message("success","Update Successful!");

						setTimeout(function(){
							var curPage		= Math.ceil(response.total_rows / lmsForum.mainGlobal.categoryPageRow);
							var router		= new lmsForum.categoryRouter();

							var newPager	= 'category/page'+curPage;
							router.navigate(newPager);
							router.categoryList(curPage);
						}, 4500);
					}else{
						Menu.message('warning','Update Error!');
					}
				}});
			}			
		}
		
		return false;
	},
	
	deleteCategory: function(){	
		var validateDelete	= $('input[name="category_checkbox[]"]:checked').length;
		if(validateDelete === 0){			
			var label	= 'Select at least one category to delete!';
			$('#message_wrap_con').html('<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-error ui-corner-all" style="padding: 7px;text-align:center;">  <p style="display:inline-block;"><span class="ui-icon ui-icon-alert" style="float: left;margin-right:5px;"></span>'+label+'</p></div></div>').hide().fadeIn();
		}
		else{
			var dialogWrapper	= 'dialog_wrapper';

			$('.'+dialogWrapper).remove();
			$('div#mainforum_container').append('<div class="'+dialogWrapper+'">Are you sure you want to delete the selected category/ies?</div>');

			$('div.'+dialogWrapper).dialog({
				width: 500,
				title: 'Delete Category',
				modal: true,
				open : function(){

				},
				close : function(){
					$(this).dialog('destroy');
					$('div#mainforum_container div.'+dialogWrapper).remove();					
				},
				buttons: {
					Delete: function() {
						var data	= {};
						$('#message_wrap_con').children().remove();
						
						var ids	= [];
						$.each($('input[name="category_checkbox[]"]:checked'), function(k,v){
							ids.push($(this).val());
						})			
						
						data['crud']			= 'd';
						data['forum_section']	= 'category';
						data['id']				= ids;
						data['row_limit']		= lmsForum.mainGlobal.categoryPageRow;
						
						var deleteCategory	= new lmsForum.categoryBackend(data);
						deleteCategory.save(null, {success: function(model, response){
							if(response.status !== false){
								Menu.message('success','Categories are successfully deleted!');
								var router		= new lmsForum.categoryRouter();
								
								router.navigate('category/page'+response.page);
								router.categoryList(parseInt(response.page));
								$('div.'+dialogWrapper).dialog('destroy');
								$('div#mainforum_container div.'+dialogWrapper).remove();
							}else{
								Menu.message('warning','Error!');
							}
						}});
					},
					Cancel: function() {
						$(this).dialog('destroy');
						$('div#mainforum_container div.'+dialogWrapper).remove();	
					}
				}
			});		
		}
	},
	
	selectAllCheckbox:	function(){
		if($('input[name="category_list_checkbox_header"]').is(':checked') === true){
			$('input[name="category_checkbox[]"]').prop("checked", true);
		}else{
			$('input[name="category_checkbox[]"]').prop("checked", false);
		}
	},
	
	changeRow:	function(e){
		lmsForum.mainGlobal.categoryPageRow	= $(e.currentTarget).val();

		if(window.location.href.indexOf('#') !== -1){
			var pageMode	= window.location.href.split('#')[1].split('/')[1];//.split('=')[0];
			if(pageMode.indexOf('=') !== -1){
				var curPage	= parseInt(window.location.href.split('#')[1].split('/')[2].replace('page',''));
				var result	= new lmsForum.categoryRouter().categoryList(curPage);
				var search	= window.location.href.split('#')[1].split('/')[1].split('=')[1];
				var uri		= 'category/search='+search+'/page';

				$('div.pagination').remove();
				$('.forum_bottom').append(lmsForum.tmpl.paginationTmpl(parseInt(lmsForum.mainGlobal.categorySearch_globals.page),lmsForum.mainGlobal.categoryPageRow,parseInt(lmsForum.mainGlobal.categorySearch_globals.total),uri)).hide().fadeIn();
			}else{
				var curPage	= parseInt(window.location.href.split('#')[1].split('/')[1].replace('page',''));
				var result	= new lmsForum.categoryRouter().categoryList(curPage);
			}
		}else{
			var result	= new lmsForum.categoryRouter().categoryList(1);
		}
	},

	searchCategory:	function(){
		var data		= {};
		var title		= $('input[name="search_box"]').val();
		var router		= new lmsForum.categoryRouter();
		var validate	= $("form.searchForm").validateForm();
		
		if(validate !== false){
			router.navigate('category/search='+title+'/page1');
			router.categorySearch(title,1);
		}
	},
	
	resetSearchCategory:	function(){
		$('.reset_searchBtn').hide();
		new lmsForum.categoryRouter().categoryList(1);				
		new lmsForum.categoryRouter().navigate('category/page1');
	},
	
	deleteCategoryTopic:	function(e){
		var fcid 			= parseInt($(e.currentTarget).parent().prev().children().attr('id').replace('category-id-',''));
		var category		= $(e.currentTarget).parent().parent().parent().prev().prev().prev().children().text();
		var dialogWrapper	= 'dialog_wrapper';

		$('.'+dialogWrapper).remove();
		$('div#mainforum_container').append('<div class="'+dialogWrapper+'">Are you sure you want to delete <br /> all the topics that belongs to <strong>'+category+'</strong> category?</div>');

		$('div.'+dialogWrapper).dialog({
			width: 500,
			title: 'Delete Topics',
			modal: true,
			open : function(){

			},
			close : function(){
				$(this).dialog('destroy');
				$('div#mainforum_container div.'+dialogWrapper).remove();					
			},
			buttons: {
				"YES": function() {
					// Delete all topics
					var data				= {};
					data['crud']			= 'delete_alltopic';
					data['forum_section']	= 'topic';
					data['fcid']			= fcid;
					data['id']				= fcid;

					var deleteAllTopics		= new lmsForum.topicBackend(data);
					
					deleteAllTopics.save(null, {success: function(model, response){
						if(response.stat !== false){
							if(response.stat === 0){
								var message	= 'There are no topic to delete in <strong>'+category+'</strong> category.';
							}else{
								var message	= 'All topics in <strong>'+category+'</strong>  category has been deleted!';
							}
							$('div.'+dialogWrapper).html(message).hide().fadeIn(4000, function(){
								$(this).fadeTo('slow', 0, function() {
									$(this).dialog('close');
								});
							});
						}
					}});
					
				},
				NO: function() {
					$(this).dialog( "close" );
				}
			}
		});
	},
	
	addCategory:	function(e){
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}
		
		var action			= $(e.currentTarget).attr('class').split(' ')[1];
		var dialogWrapper	= 'dialog_wrapper';

		
		var data	= {};

		// Add category
		data['crud']			= 'view_category_style_grade';
		data['forum_section']	= 'category';
		data['id']				= 'add';
		
		var addCategory			= new lmsForum.categoryBackend(data);
		addCategory.save(null, {success: function(model, response){
			$('.wrap .loader').fadeOut();
			$('.'+dialogWrapper).remove();
			$('div#mainforum_container').append('<div class="'+dialogWrapper+'"></div>');
			
			$('div.dialog_wrapper').load('tpl/category_form.tpl', function(){
				$('form[name="category_form"]').dialog({
					width:660,
					title : 'Add Topic',
					modal: true,
					open: function(){
						if($.browser.msie){
							$('form[name="category_form"] iframe').show().css({'height': '40px'}).attr({'scrolling': 'no', 'frameBorder': '0'});
							$('.attach_file').hide();
						}
						$('iframe.fileupload_iframe')
						.attr('src', common.getBaseUrl()+'/admin/forum/tpl/file_upload.php')
						.one('load', function(){
							$('iframe.fileupload_iframe').contents().find('form').attr('action', common.getBaseUrl()+'/admin/forum/controller/forum_file_upload_back.php');
						});													
					},
					close : function(){
						$(this).dialog('destroy');
						$('div#mainforum_container div.'+dialogWrapper+', form[name="category_form"]').remove();				
					},
					buttons: {
								// Add
								'Add':	function(){
									var data	= {};
									$.each($('form[name="category_form"]').serialize().split('&'), function(k, v){
										data[v.split('=')[0]]	= v.split('=')[1];
									});
									
									var filename		= Math.floor((Math.random()*9999)+1);
									var _file			= $('iframe.fileupload_iframe').contents().find('input[type="file"]').val();
									
									if(_file === '' || typeof _file === 'undefined'){
										data['filename']	= null;
									}else{
										var ext				= $('iframe').contents().find('input[type="file"]').val().split('.');
										data['filename']	= filename+'.'+ext[ext.length - 1];
										$('iframe').contents().find('#filename').val(filename);
									}
									
									var validate	= $('form[name="category_form"]').validateForm();
									if(validate === true){
										data['crud']			= 'c';
										data['forum_section']	= 'category';
										data['id']				= 'insert';
										

										if(_file !== '' || typeof _file !== 'undefined'){
											$('iframe.fileupload_iframe').contents().find('form').submit();
										}
										
										var addCategory	= new lmsForum.categoryBackend(data);
										addCategory.save(null, {success: function(model, response){
											if(response.stat !== false){
												$('form[name="category_form"], .ui-dialog').fadeTo('fast', 0, function() {
													var curPage		= Math.ceil(response.total_rows / lmsForum.mainGlobal.categoryPageRow);
													var router		= new lmsForum.categoryRouter();

													var newPager	= 'category/page'+curPage;
													router.navigate(newPager);
													router.categoryList(curPage);
													$('form[name="category_form"]').dialog('destroy');
													$('div#mainforum_container div.'+dialogWrapper+', form[name="category_form"]').remove();
													setTimeout(function(){
														Menu.message("success","Added New Category!");
													},100);
												});
											}else{
												Menu.message('warning','Update Error!');
											}
										}});
									}
								},
								'Cancel':	function(){
									$(this).dialog('destroy');
									$('div#mainforum_container div.'+dialogWrapper+', form[name="category_form"]').remove();
								}
							}
				});
				
				// Style List
				$('select.style_list option').remove();
				$.each(response.style_list, function(k,v){
					$('select.style_list').append('<option value="'+v.fsid+'">'+v.name+'</option>');
				});
				
				// Grade List
				$('select.grade_list option').remove();
				$.each(response.grade_list, function(k,v){
					$('select.grade_list').append('<option value="'+v.grade_num+'">'+v.grade_name+'</option>');
				});
				
				new lmsForum.uiDialog();
			});
		}});
	},
	
	modifyCategory:	function(e){
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}
		
		var fcid				= parseInt($(e.currentTarget).attr('id').replace('category-id-', ''));
		var dialogWrapper		= 'dialog_wrapper';
		var data				= {};
		data['crud']			= 'r';
		data['forum_section']	= 'category';
		data['id']				= fcid;
		
		var setUpdateCategory	= new lmsForum.categoryBackend(data);
		setUpdateCategory.save(null, {success: function(model, response){	
			$('.'+dialogWrapper).remove();
			$('div#mainforum_container').append('<div class="'+dialogWrapper+'"></div>');
			
			$('div.dialog_wrapper').load('tpl/category_form.tpl', function(){
				$('form[name="category_form"]').append('<input type="hidden" name="fcid" value="'+data['id']+'" />');
				// Style List
				$('select.style_list option').remove();
				$.each(response.style_list, function(k,v){
					if(response.category_form.fsid === v.fsid){
						$('select.style_list').append('<option value="'+v.fsid+'" selected>'+v.name+'</option>');
					}else{
						$('select.style_list').append('<option value="'+v.fsid+'">'+v.name+'</option>');
					}
				});
				
				// Grade List
				$('select.grade_list option').remove();
				$.each(response.grade_list, function(k,v){
					// Read Authority
					if(response.category_form.read_auth === v.grade_num){
						$('select.grade_list[name="read_auth"]').append('<option value="'+v.grade_num+'" selected>'+v.grade_name+'</option>');
					}else{
						$('select.grade_list[name="read_auth"]').append('<option value="'+v.grade_num+'">'+v.grade_name+'</option>');
					}
					
					// Write Authority
					if(response.category_form.write_auth === v.grade_num){
						$('select.grade_list[name="write_auth"]').append('<option value="'+v.grade_num+'" selected>'+v.grade_name+'</option>');
					}else{
						$('select.grade_list[name="write_auth"]').append('<option value="'+v.grade_num+'">'+v.grade_name+'</option>');
					}
				});
				
				$('input[name="category_title"]').val(response.category_form.name);									// Category Title
				$('input[name="this_category_row"]').val(response.category_form.row);								// Category Row				
				$('input[name="attachment"]:eq('+response.category_form.file_attach+')').attr('checked', true);		// Allow File Attachment
				$('input[name="img_display"]:eq('+response.category_form.image_display+')').attr('checked', true);	// Allow Image Display
				$('input[name="allow_reply"]:eq('+response.category_form.allow_reply+')').attr('checked', true);	// Allow Reply
				
				$('form[name="category_form"]').dialog({
					width:660,
					title : 'Update Category',
					modal: true,
					open: function(){
						$('.wrap .loader').fadeOut();
						if($.browser.msie){
							$('form[name="category_form"] iframe').show().css({'height': '40px'}).attr({'scrolling': 'no', 'frameBorder': '0'});
							$('.attach_file').hide();
						}
						
						$('iframe.fileupload_iframe')
						.attr('src', common.getBaseUrl()+'/admin/forum/tpl/file_upload.php')
						.one('load', function(){
							$('iframe.fileupload_iframe').contents().find('form').attr('action', common.getBaseUrl()+'/admin/forum/controller/forum_file_upload_back.php');
						});
						
						if(response.category_form.logo !== ''){							
							$('form[name="category_form"] img').show();
							$('.attach_file').text('Change');
							$('img.icon').attr('src', common.getBaseUrl()+'/uploads/forum/category/'+response.category_form.logo).css({'marginTop': '10px', 'height': '100px'});
							$('.fileupload_label').css({'height': $('img.icon').height() + 25});						
						}
					},
					close : function(){
						$(this).dialog('destroy');
						$('div#mainforum_container div.'+dialogWrapper+', form[name="category_form"]').remove();				
					},
					buttons: {
						// Update
						'Update':	function(){
							var validate	= $('form[name="category_form"]').validateForm();
							$.each($('form[name="category_form"]').serialize().split('&'), function(k, v){
								data[v.split('=')[0]]	= v.split('=')[1];
							});
							
							var filename		= Math.floor((Math.random()*9999)+1);
							var ext				= $('iframe').contents().find('input[type="file"]').val();
							if(ext === '' || typeof ext === 'undefined'){
								data['filename']	= response.category_form.logo;
							}else{
								var _ext			= $('iframe').contents().find('input[type="file"]').val().split('.');
								data['filename']	= filename+'.'+ _ext[_ext.length - 1];
								$('iframe').contents().find('#filename').val(filename);
							}
							
							if(response.category_form.logo !== ''){
								data['file_exist']	= response.category_form.logo;
							}else{
								data['file_exist']	= null;
							}
							
							
							
							var style	= $('select.style_list option[value="'+data['forum_style']+'"]').text();

							if(validate === true){
								data['crud']			= 'u';
								data['forum_section']	= 'category';
								data['id']				= fcid;
								
								if(ext !== '' || typeof ext === 'undefined'){
									$('iframe').contents().find('form').submit();
								}
								
								var updateCategory	= new lmsForum.categoryBackend(data);
								updateCategory.save(null, {success: function(model, response){
									if(response[0] !== false){
										$('form[name="category_form"]').dialog('destroy');
										$('div#mainforum_container div.'+dialogWrapper+', form[name="category_form"]').remove();
										setTimeout(function(){
											// Update real-time
											$(e.currentTarget).parent().parent().parent().prev().prev().text(style);									// Style
											$(e.currentTarget).parent().parent().parent().prev().prev().prev().children().text(data['category_title']);	// Category

											Menu.message("success","Category has been updated!");
										},100);
									}else{
										Menu.message('warning','Update Error!');
									}		
								}});
							}							
						},
						'Cancel':	function(){
							$(this).dialog('destroy');
							$('div#mainforum_container div.'+dialogWrapper+', form[name="category_form"]').remove();
						}
					}
				});	
				
				new lmsForum.uiDialog();
			});
		}});
	}
});

lmsForum.topicList	= Backbone.View.extend({
	initialize:	function(){},
	
	el: 'div#mainforum_container',

	events: {
		'click .add_topic_btn': 							'addTopicDialog',
		'click .back_topic_list':							'backTopicList',
		'click .delete_topic':								'deleteTopic',
		'click .modify-post':								'setModifyPost',
		'click	input[name="topic_list_checkbox_header"]':	'selectAllCheckbox',
		'click .searchBtn':									'searchTopic',
		'click .reset_searchTopicBtn':						'resetSearchTopic',
		'click .backto_categories':							'backToCategoryList'
	},
	
	addTopicDialog:	function(){				
		var topicFormId		=	'add_topic_form';
		var topicFormDialog	= 'addTopic_dialog';
		
		
		var category		= window.location.href.split('#')[1].split('/')[2];
		var fcid			= parseInt(window.location.href.split('#')[1].split('/')[3]);
		var page			= parseInt(window.location.href.split('#')[1].split('/')[4].replace('page',''));
		var _width, _height;
		
		if($.browser.msie){
			_width	= 680;
			_height	= 400;
		}else{
			_width	= 660;
			_height	= 400;				
		}
		
		$('div.dialog_wrapper').remove();
		$('div#mainforum_container').append('<div class="dialog_wrapper"></div>').hide().fadeIn();
		$('div.dialog_wrapper').load('tpl/topic_form.tpl .topic_dialog', function(){
			$('.'+topicFormDialog).dialog({
				width:	_width,
				height: _height,
				title : 'Add Topic',
				modal: true,
				open : function(){
					if($.browser.msie){
						$('div.addTopic_dialog iframe').show().css({'height': '40px', 'margin-top': '-73px', 'margin-right': '310px'}).attr({'scrolling': 'no', 'frameBorder': '0'});
						$('.thread_attach_file').hide();
					}
						
					$('iframe.fileupload_iframe')
					.attr('src', common.getBaseUrl()+'/admin/forum/tpl/file_upload.php')
					.one('load', function(){
						$('iframe.fileupload_iframe').contents().find('form').attr('action', common.getBaseUrl()+'/admin/forum/controller/forum_file_upload_back.php');
						$('iframe.fileupload_iframe').contents().find('input[name="forum_section"]').val('topic');
					});					
					
					new lmsForum.topicRouter().topicList(category,fcid,page);
					
					setTimeout(function(){
						tinyMCE.execCommand('mceAddControl', true, topicFormId);						
					},400);				

					if(parseInt($('.file_attach_stat').val()) === 0){
						$('.thread_attach_file, .file_label').hide();
					}
				},
				close : function(){
					if (tinyMCE.getInstanceById(topicFormId)){
						tinyMCE.execCommand('mceFocus', false, topicFormId); 
						tinyMCE.execCommand('mceRemoveControl', false, topicFormId);
					} 
					$(this).dialog('destroy');
					$('div#mainforum_container div.dialog_wrapper, div.'+topicFormDialog).remove();
				}
			});
			
			new lmsForum.uiDialog();
		}).hide().fadeIn();
		
		return false;
	},
	
	backTopicList:	function(){
		window.history.back();
		
		return false;
	},
	
	deleteTopic:	function(){
		var validateDelete	= $('input[name="topic_list_checkbox[]"]:checked').length;
		if(validateDelete === 0){			
			var label	= 'Select at least one topic to deleted!';
			$('#message_wrap_con').html('<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-error ui-corner-all" style="padding: 7px;text-align:center;">  <p style="display:inline-block;"><span class="ui-icon ui-icon-alert" style="float: left;margin-right:5px;"></span>'+label+'</p></div></div>');
		}
		else{
			var dialogWrapper	= 'dialog_wrapper';

			$('.'+dialogWrapper).remove();
			$('div#mainforum_container').append('<div class="'+dialogWrapper+'">Are you sure you want to delete the selected Topic/s?</div>');

			$('div.'+dialogWrapper).dialog({
				width: 500,
				title: 'Delete Topic',
				modal: true,
				open : function(){

				},
				close : function(){
					$(this).dialog('destroy');
					$('div#mainforum_container div.'+dialogWrapper).remove();					
				},
				buttons: {
					Delete: function() {
						var data	= {};
						$('#message_wrap_con').children().remove();
						
						var ids	= [];
						$.each($('input[name="topic_list_checkbox[]"]:checked'), function(k,v){
							ids.push($(this).val());
						})			
						
						data['crud']			= 'd';
						data['forum_section']	= 'topic';
						data['id']				= ids;

						var deleteTopic			= new lmsForum.topicBackend(data);
						
						deleteTopic.save(null, {success: function(model, response){
							if(response.stat != false)
							{
								Menu.message('success','Categories are successfully deleted!');
								var topic	= $('input[name="topic"]').val();
								var fcid	= $('input[name="fcid"]').val();
								var pager	= $('input[name="pager"]').val();
								var router	= new lmsForum.topicRouter();
								
								router.navigate('topic/list/'+topic+'/'+fcid+'/page'+response.page);
								router.topicList(topic,fcid,response.page);
								$('div.'+dialogWrapper).dialog('destroy');
								$('div#mainforum_container div.'+dialogWrapper).remove();								
							}
							else
							{
								Menu.message('warning','Error! Unable to delete this topic.');
							}
						}});
					},
					Cancel: function() {
						$(this).dialog('destroy');
						$('div#mainforum_container div.'+dialogWrapper).remove();	
					}
				}
			});			
		}
	},
	
	setModifyPost:	function(e){
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}
		if(typeof e !== 'undefined'){
			var fpid 		= parseInt($(e.currentTarget).attr('id').replace('post-id-',''));
			var dialogTitle	= 'Add Topic';
		}else{
			var fpid		= parseInt(window.location.href.split('#')[1].split('/')[3]);
			var dialogTitle	= 'Modify Topic';
		}
		
		var data				= {};
		data['crud']			= 'v';
		data['forum_section']	= 'topic';
		data['id']				= fpid;

		var setModifyTopic		= new lmsForum.topicBackend(data);
		
		setModifyTopic.save(null, {success: function(model, response){
			tinyMCE.triggerSave();
			var title			= response[0].title;
			var row				= response[0].row;
			var content			= response[0].content;
			var topicFormId		= 'add_topic_form';
			var topicFormDialog	= 'addTopic_dialog';
			var attachedFile	= response[0].attach_file;
			if(attachedFile !== ''){
				var attachedNameid	= response[0].attached[0];
				var attachedName	= response[0].attached[1];
				var attachedExt		= response[0].attached[2];
				var attachedUfid	= response[0].attached[3];
			}
			
			$('div#mainforum_container').append('<div class="dialog_wrapper"></div>').hide().fadeIn();
			$('div.dialog_wrapper').load('tpl/topic_form.tpl .topic_dialog', function(){
				$('.addTopicBtn').removeClass('addTopicBtn').attr('class', 'updateTopicBtn btn_save fr');
				$('.updateTopicBtn').attr('title', 'Update').text('Update');
				$('form[name="addTopic_form"]').append('<input type="hidden" name="fpid" value="'+fpid+'" />').hide().fadeIn();
				$('form[name="addTopic_form"]').append('<input type="hidden" name="ufid" value="'+attachedUfid+'" />');
				$('input[name="title"]').val(title);
				$('input[name="row"]').val(row);
				$('#add_topic_form').val(content);
				
				if($.browser.msie){
					_width	= 680;
					_height	= 400;
				}else{
					_width	= 660;
					_height	= 400;				
				}
				
				$('.'+topicFormDialog).dialog({
					width: 	_width,
					height:	_height,
					title : dialogTitle,
					modal: true,
					open : function(){
						$('.wrap .loader').fadeOut();
						
						$('iframe.fileupload_iframe')
						.attr('src', common.getBaseUrl()+'/admin/forum/tpl/file_upload.php')
						.one('load', function(){
							$('iframe.fileupload_iframe').contents().find('form').attr('action', common.getBaseUrl()+'/admin/forum/controller/forum_file_upload_back.php');
							$('iframe.fileupload_iframe').contents().find('input[name="forum_section"]').val('topic');
						});
						
						tinyMCE.execCommand('mceAddControl', true, topicFormId);
						if(attachedFile !== ''){
							var dialogHeight	= 400 + 30; // $('.ui-dialog').height() + 30

							$('.ui-dialog, .addTopic_dialog').css({'height': dialogHeight});
							$('input[name="nameid"]').val(attachedNameid);
							$('iframe').contents().find('#filename').val(attachedName);
							$('input[name="attach_file_ext"]').val(attachedExt);

							$('div.uploaded_filename').show();
							$('a.file_btn').text(attachedName);
						}
						
						if(parseInt($('.file_attach_stat').val()) === 0){
							$('.thread_attach_file, div.uploaded_filename, .file_label').hide();
						}
						
						if($.browser.msie){
							$('div.addTopic_dialog iframe').show().css({'height': '40px', 'margin-top': '-97px', 'margin-right': '320px'}).attr({'scrolling': 'no', 'frameBorder': '0'});
							$('.thread_attach_file').hide();
							// $('a.file_btn').removeClass();
							$('a.delete_uploaded').remove();
						}
					},
					close : function(){
						if (tinyMCE.getInstanceById(topicFormId)){
							tinyMCE.execCommand('mceFocus', false, topicFormId); 
							tinyMCE.execCommand('mceRemoveControl', false, topicFormId);
						} 
						$(this).dialog('destroy');
						$('div#mainforum_container div.dialog_wrapper, div.'+topicFormDialog).remove();
					}
				});
				
				
				new lmsForum.uiDialog();
			}).hide().fadeIn();
		}});
		
		return false;
	},
	
	selectAllCheckbox:	function(){
		if($('input[name="topic_list_checkbox_header"]').is(':checked') === true){
			$('input[name="topic_list_checkbox[]"]').prop("checked", true);
		}else{
			$('input[name="topic_list_checkbox[]"]').prop("checked", false);
		}
	},
	
	searchTopic:	function(){
		var validate			= $('form.searchForm').validateForm();
		var data				= {};
		
		if(validate !== false){
			data['title']			= $('input[name="search_box"]').val();
			data['fcid']			= parseInt(window.location.href.split('#')[1].split('/')[3]);
			data['crud']			= 'search';
			data['forum_section']	= 'topic';
			data['id']				= data['fcid'];
			
			var _searchTopic		= new lmsForum.topicBackend(data);
			_searchTopic.save(null, {success: function(model, response){
				$('.reset_searchTopicBtn').show();
				$('table.topic_list_tbl tbody tr').remove();
				if(response.rows.length > 0){				
					$.each(response, function(k,v){
						if(k !== 'style' && k !== 'total_rows' && k !== 'category' && k !== 'session'){
							$.each(v, function(k,v){
								var post_date		= new Date(parseInt(v.post_date) * 1000);
								var posted_date		= post_date.getMonth() +'/'+ post_date.getDate() +'/'+ post_date.getFullYear();
								var fields			= {'fpid': v.fpid, 'uid': v.uid, 'title': v.title, 'post_date': posted_date, 'username': v.user_id};
								
								$('table.topic_list_tbl tbody').append(lmsForum.tmpl.topicList(fields));
								$('tr#post-tr-id-'+fields['fpid']);
							});
						}
					});
					
					
					var category	= window.location.href.split('#')[1].split('/')[2];
					var uri			= 'topic/list/'+category+'/'+data['fcid']+'/search='+data['title']+'/page';
					
					
					var _pager	= Math.ceil(response.total_rows / 3);
					if(_pager > 1){
						$('div.pagination').remove();
						$('.forum_bottom2').append(lmsForum.tmpl.paginationTmpl(1,3,response.total_rows,uri)).hide().fadeIn();	
					}
					
					var router	= new lmsForum.topicRouter();
					router.navigate(uri+1);
				}else{
					$('.delete_topic, .add_topic_btn').hide();
					$('table.topic_list_tbl tbody').append('<tr><td colspan="6"><strong style="display: block;">No results found.</strong><span style="color: gray;">Check your spelling or try another term.</span></td></tr>');
					$('div.pagination').remove();
				}
			}});
		}
	},
	
	resetSearchTopic:	function(){
		$('.reset_searchTopicBtn').hide();
		var hashURL	= window.location.href.split('#')[1];
		var topic	= hashURL.split('/')[2];
		var fcid	= parseInt(hashURL.split('/')[3]);

		new lmsForum.topicRouter().navigate('topic/list/'+topic+'/'+fcid+'/page1');
		new lmsForum.topicRouter().topicList(topic,fcid,1);
	},
	
	backToCategoryList:	function(){
		var fcid				= parseInt(window.location.href.split('#')[1].split('/')[3]);
		var data				= {};
		
		
		data['fcid']			= fcid;
		data['row']				= lmsForum.mainGlobal.categoryPageRow;
		data['crud']			= 'back_to_category';
		data['forum_section']	= 'topic';
		data['id']				= data['fcid'];
		
		var toCategory			= new lmsForum.topicBackend(data);
		toCategory.save(null, {success: function(model, response){
			// $.ajaxSetup({ cache: false });
			var router	= new lmsForum.categoryRouter();
			router.categoryList(response.page);
			router.navigate('category/page'+response.page);
		}});
	}
});

lmsForum.threadList	= Backbone.View.extend({
	initialize:	function(){},
	
	el: 'div#mainforum_container',

	events: {
		'click .thread_reply_btn':	'addThreadComment',
		'click .thread_edit_btn':	'setModifyComment',
		'click .thread_delete_btn':	'deleteComment',
		'click .thread_quote_btn':	'setThreadQuote',
		'click .back':				'backBtn'
	},
	
	addThreadComment:	function(e){
		var reply_textarea	= 'reply_textarea';
		var replyFormDialog	= 'reply_dialog';
		var dialogWrapper	= 'dialog_wrapper';
		var topic			= window.location.href.split('#')[1].split('/')[2];
		var fpid			= parseInt(window.location.href.split('#')[1].split('/')[3]);
		var pager			= parseInt(window.location.href.split('#')[1].split('/')[4].replace('pager',''));
		var _width, _height;
		
		if($.browser.msie){
			_width	= 680;
			_height	= 300;
		}else{
			_width	= 660;
			_height	= 300;				
		}
		
		$('div.'+dialogWrapper).remove();
		$('div#mainforum_container').append('<div class="'+dialogWrapper+'"></div>');
		$('div.'+dialogWrapper).load('tpl/reply_form.tpl .'+replyFormDialog, function(){
			$('div.'+dialogWrapper).dialog({
				width: 	_width,
				height:	_height,
				title: 'Add Reply',
				modal: true,
				open : function(){
					new lmsForum.topicRouter().topicThread(topic,fpid,pager);
					setTimeout(function(){
						tinyMCE.execCommand('mceAddControl', true, reply_textarea);
					}, 400);
				},
				close : function(){
					if (tinyMCE.getInstanceById(reply_textarea)){
						tinyMCE.execCommand('mceFocus', false, reply_textarea);
						tinyMCE.execCommand('mceRemoveControl', false, reply_textarea);						
					} 
					$('div#mainforum_container div.'+dialogWrapper+', div.'+replyFormDialog).remove();		
					$(this).dialog('destroy');
				}
			});
			
			new lmsForum.uiDialog();
		});
		
		return false;
	},
	
	setModifyComment:	function(e){
		if($('.wrap .loader').is(':visible') === true){
			$('.wrap .loader').fadeIn();
		}else{
			$('.wrap').append('<div class="loader" style="top:45%; left:49%; display: none;"></div>');
			$('.wrap .loader').fadeIn();
		}
		
		var topic			= window.location.href.split('#')[1].split('/')[2];
		var fpid			= parseInt(window.location.href.split('#')[1].split('/')[3]);
		var pager			= parseInt(window.location.href.split('#')[1].split('/')[4].replace('pager',''));

		if($(e.currentTarget).parent().parent().closest('li').attr('id') !== undefined){
			var commentID 			= parseInt($(e.currentTarget).parent().parent().closest('li').attr('id').replace('comment-id-',''));
			var data				= {};
			
			data['crud']			= 'set_modify';
			data['forum_section']	= 'thread';
			data['fpcid']			= commentID;
			data['id']				= data['fpcid'];

			var _setModifyComment	= new lmsForum.threadBackend(data);
			
			_setModifyComment.save(null, {success: function(model, response){
				var reply_textarea	= 'reply_textarea';
				var replyFormDialog	= 'reply_dialog';
				var dialogWrapper	= 'dialog_wrapper';
				if($.browser.msie){
					_width	= 680;
					_height	= 300;
				}else{
					_width	= 660;
					_height	= 300;				
				}
				
				$('.'+dialogWrapper).remove();
				$('div#mainforum_container').append('<div class="'+dialogWrapper+'"></div>');
				$('div.'+dialogWrapper).load('tpl/reply_form.tpl .'+replyFormDialog, function(){
					$('#reply_textarea').val(response.comment);
					$('form#reply_form').append('<input type="hidden" name="fpcid" value="'+commentID+'" />');
					
					$('div.'+dialogWrapper).dialog({
						width: 	_width,
						height:	_height,
						title: 'Add Reply',
						modal: true,
						open : function(){
							$('.wrap .loader').fadeOut();
							
							new lmsForum.topicRouter().topicThread(topic,fpid,pager);
							setTimeout(function(){
								tinyMCE.execCommand('mceAddControl', true, reply_textarea);
							}, 400);
						},
						close : function(){
							if (tinyMCE.getInstanceById(reply_textarea)){
								tinyMCE.execCommand('mceFocus', false, reply_textarea);
								tinyMCE.execCommand('mceRemoveControl', false, reply_textarea);
							} 
							$(this).dialog('destroy');
							$('div#mainforum_container div.'+dialogWrapper+', div.'+replyFormDialog).remove();
						}
					});
					$('a.replyBtn').text('Update').attr({'title': 'Update', 'class': 'btn_save fr replyActionBtn'});
					
					new lmsForum.uiDialog();
				});
			}});
		}
		else{
			var mainThreadComment	= new lmsForum.topicList();
			mainThreadComment.setModifyPost();
		}
		
		return false;
	},
	
	deleteComment:	function(e){
		if($(e.currentTarget).parent().parent().closest('li').attr('id') !== undefined){
			var dialogWrapper	= 'dialog_wrapper';

			$('.'+dialogWrapper).remove();
			$('div#mainforum_container').append('<div class="'+dialogWrapper+'">Are you sure you want to delete this comment?</div>');

			$('div.'+dialogWrapper).dialog({
				width: 500,
				title: 'Delete Comment',
				modal: true,
				open : function(){

				},
				close : function(){
					$(this).dialog('destroy');
					$('div#mainforum_container div.'+dialogWrapper).remove();					
				},
				buttons: {
					Delete: function() {
						var data				= {};
						var commentID			= parseInt($(e.currentTarget).parent().parent().closest('li').attr('id').replace('comment-id-',''));	
						
						var topic				= window.location.href.split('#')[1].split('/')[2];
						var fpid				= window.location.href.split('#')[1].split('/')[3];

						data['crud']			= 'd';
						data['forum_section']	= 'thread';
						data['fpcid']			= commentID;
						data['id']				= data['fpcid'];
						
						var _deleteComment		= new lmsForum.threadBackend(data);
						
						_deleteComment.save(null, {success: function(model, response){
							var router		= new lmsForum.topicRouter();
							var totalRows	= parseInt(response.total_rows) + 1;
							var pager		= Math.ceil(totalRows / parseInt(response.topic_row_limit));
							
							router.navigate('topic/thread/'+topic+'/'+fpid+'/pager'+pager);
							router.topicThread(topic,fpid,pager);
							$('div.'+dialogWrapper).dialog('destroy');
							$('div#mainforum_container div.'+dialogWrapper).remove();
						}});
					},
					Cancel: function() {
						$(this).dialog('destroy');
						$('div#mainforum_container div.'+dialogWrapper).remove();	
					}
				}
			});				
		}
	},
	
	setThreadQuote:	function(e){
		var data			= {};
		var rawCommentID	= $(e.currentTarget).parent().parent().closest('li').attr('id');
		var commentID;
		var quoteType		= '';
		var topic			= window.location.href.split('#')[1].split('/')[2];
		
		var fpid			= parseInt(window.location.href.split('#')[1].split('/')[3]);
		var pager			= parseInt(window.location.href.split('#')[1].split('/')[4].replace('pager',''));
		
		if(typeof rawCommentID !== 'undefined'){
			// Sub comments
			commentID	= parseInt($(e.currentTarget).parent().parent().closest('li').attr('id').replace('comment-id-',''));
			quoteType	= 'comment';
		}else{
			// Thread main topic
			commentID	= parseInt(window.location.href.split('#')[1].split('/')[3]);
			quoteType	= 'topic';
		}
		
		data['crud']			= 'quote_view';
		data['forum_section']	= 'thread';
		data['quoteId']			= commentID;
		data['quoteType']		= quoteType;
		data['id']				= data['quoteId'];
		
		var setQuote			= new lmsForum.threadBackend(data);

		setQuote.save(null, {success: function(model, response){
			var quoteContent	= ''
			if(response.quoteType == 'topic'){
				quoteContent	= response.content;
			}else{
				quoteContent	= response.comment;
			}
		
			var reply_textarea	= 'reply_textarea';
			var replyFormDialog	= 'reply_dialog';
			var dialogWrapper	= 'dialog_wrapper';
			var _width, _height;
			
			if($.browser.msie){
				_width	= 680;
				_height	= 300;
			}else{
				_width	= 660;
				_height	= 300;				
			}
			
			$('.'+dialogWrapper).remove();
			$('div#mainforum_container').append('<div class="'+dialogWrapper+'"><div class="quote_reply">'+quoteContent+'</div></div>');
			$('div.'+dialogWrapper).load('tpl/reply_form.tpl .'+replyFormDialog, function(){
				$('div.'+dialogWrapper).dialog({
					width: 	_width,
					height:	_height,
					title: 'Add Reply',
					modal: true,
					open : function(){
						new lmsForum.topicRouter().topicThread(topic,fpid,pager);
						setTimeout(function(){
							tinyMCE.execCommand('mceAddControl', true, reply_textarea);
						}, 400);
					},
					close : function(){
						if (tinyMCE.getInstanceById(reply_textarea)){
							tinyMCE.execCommand('mceFocus', false, reply_textarea);
							tinyMCE.execCommand('mceRemoveControl', false, reply_textarea);						
						} 
						$(this).dialog('destroy');
						$('div#mainforum_container div.'+dialogWrapper+', div.'+replyFormDialog).remove();					
					}
				});
				$('div.'+dialogWrapper).before('<span style="display: block; float: left; margin-left: 12px;">Quote:</span><div class="quote_reply"><div class="quote" style="width: 90%; text-align: left;">'+quoteContent+'</div></div>');
				
				new lmsForum.uiDialog();
			});
		}});
		
		return false;
	},
	
	backBtn:	function(e){
		var data		= {};
		var backType	= $(e.currentTarget).attr('class').split(' ')[2];
		
		if(backType === 'to_topics'){
			var topicID = parseInt(window.location.href.split('#')[1].split('/')[3]);
			
			data['crud']			= 'back_topiclist';
			data['forum_section']	= 'thread';
			data['fpid']			= topicID;
			data['id']				= data['fpid'];
			
			var backTopicList		= new lmsForum.threadBackend(data);

			backTopicList.save(null, {success: function(model, response){
				var category	= response.category[0].name;
				var fcid		= response.category[0].fcid;
				var pager		= parseInt(response.pager);
				
				// Back to topic list
				var router	= new lmsForum.topicRouter();
				
				router.navigate('topic/list/'+category+'/'+fcid+'/page'+pager);
				router.topicList(category,fcid,pager);
			}});
		}
		
		return false;
	}
});

lmsForum.uiDialog	= Backbone.View.extend({
	initialize:	function(){
		
	},
	
	el: 'body',

	events: {
		// Topic
		'click .addTopicBtn':		'addTopic',
		'click .updateTopicBtn':	'updateTopic',
		
		// Reply
		'click .replyBtn':				'addReply',
		'click .replyActionBtn':		'updateCommentThread',
		'click .thread_attach_file':	'threadAttachFile',
		'click .file_btn':				'renameFile',
		'click .rename_btn':			'renameFileExc',
		'click .delete_uploaded':		'deleteAttachFile',
		
		// Category
		'click .attach_file':		'attachFile'
	},
	
	addTopic: function(){
		tinyMCE.triggerSave();
		
		// Validations
		var result1 		= $('form#addTopic_form').validateForm();
		var textArea		= 'add_topic_form';
		var result2 		= $("#addTopic_form").validateForm();
		var content 		= tinymce.get(textArea).getContent();
		
		if ($.trim(content) == ""){
			$("#add_topic_form_ifr").css({"border" : "1px solid #ce1f1f"});			
			result = false;
		}
		
		$("#"+textArea+"_ifr").contents().find(".mceContentBody").unbind("keyup");
		
		$("#"+textArea+"_ifr").contents().find(".mceContentBody").keyup(function(){
			if(tinymce.get(textArea).getContent() == ""){
				$("#"+textArea+"_tbl").css({"border" : "1px solid #ce1f1f"});
				result2 = false;
			}
			else{
				$("#add_topic_form_ifr").css({
					"border" : "1px solid #bbb",
					"border-bottom" : "none",
					"border-top" : "none"
				});
				
				result2 = true;
			}
		});
		
		// If no validation error
		if(result1 !== false && result2 !== false){
			var data				= {};
			data['fcid']			= $('input[name="fcid"]').val();
			data['title']			= $('input[name="title"]').val();
			data['content']			= $('#add_topic_form').val();
			data['row']				= $('input[name="row"]').val();	
			
			var filename			= $('a.file_btn').text();
			var _file				= $('iframe.fileupload_iframe').contents().find('input[type="file"]').val();
			if(_file === '' || typeof _file === 'undefined'){
				data['nameid']		= null;	
				data['name']		= null;	
				data['ext']			= null;	

			}else{				
				if($.browser.msie){
					var filename	= Math.floor((Math.random()*9999)+1);
					var ext			= $('iframe').contents().find('input[type="file"]').val().split('.');
					var file		= filename+'.'+ ext[ext.length - 1];
					ext				= ext[ext.length - 1];
					
					$('input[name="attach_file_ext"]').val(ext);
					$('input[name="nameid"]').val(file);
					$('iframe').contents().find('#filename').val(file);
					
					data['nameid']	= $('input[name="nameid"]').val();
					data['name']	= $('input[name="nameid"]').val();
					data['ext']		= $('input[name="attach_file_ext"]').val();
				}else{
					data['nameid']	= $('input[name="nameid"]').val();	
					data['name']	= filename;	
					data['ext']		= $('input[name="attach_file_ext"]').val();	
				}
				
				$('iframe.fileupload_iframe').contents().find('form').submit();				
			}			
			
			data['crud']			= 'c';
			data['forum_section']	= 'topic';
			data['id']				= 'create';
			
			var addTopic			= new lmsForum.topicBackend(data);
			
			addTopic.save(null, {success: function(model, response){
				if(response.stat != false){
					$('.ui-icon-closethick').trigger('click');	
					
					var category 	= window.location.href.split('#')[1].split('/')[2];
					var fcid 		= parseInt(window.location.href.split('#')[1].split('/')[3]);
					var router		= new lmsForum.topicRouter();
					var pager		= Math.ceil(response.total_rows / parseInt(response.limit_row));
					
					router.navigate('topic/list/'+category+'/'+fcid+'/page'+pager);
					router.topicList(category,fcid,pager);
				}
				else{
					Menu.message('warning','Error! Unable to delete this topic.');
				}		
			}});
		}

		this.model.destroy();
		return false;
	},
	
	updateTopic:	function(){
		tinyMCE.triggerSave();
		// Validations
		var result1 		= $('form#addTopic_form').validateForm();
		var textArea		= 'add_topic_form';
		var result2 		= $("#addTopic_form").validateForm();
		var content 		= tinymce.get(textArea).getContent();
		
		if ($.trim(content) == ""){
			$("#add_topic_form_ifr").css({"border" : "1px solid #ce1f1f"});			
			result = false;
		}
		
		$("#"+textArea+"_ifr").contents().find(".mceContentBody").unbind("keyup");
		
		$("#"+textArea+"_ifr").contents().find(".mceContentBody").keyup(function(){
			if(tinymce.get(textArea).getContent() == ""){
				$("#"+textArea+"_tbl").css({"border" : "1px solid #ce1f1f"});
				result2 = false;
			}
			else{
				$("#add_topic_form_ifr").css({
					"border" : "1px solid #bbb",
					"border-bottom" : "none",
					"border-top" : "none"
				});
				
				result2 = true;
			}
		});
		
		// If no validation error
		if(result1 !== false && result2 !== false){
			var data				= {};
			data['title']			= $('input[name="title"]').val();
			data['content']			= $('#add_topic_form').val();
			data['row']				= $('input[name="row"]').val();
			data['crud']			= 'u';
			data['forum_section']	= 'topic';
			data['id']				= $('input[name="fpid"]').val();
			data['fpid']			= data['id'];
			var _file				= $('iframe.fileupload_iframe').contents().find('input[type="file"]').val();
			
			if(_file === '' || typeof _file === 'undefined'){
				if($('.uploaded_filename').is(':visible') !== true){					
					data['nameid']	= null;	
					data['name']	= null;	
					data['ext']		= null;	
				}else{
					data['nameid']	= $('input[name="nameid"]').val();	
					data['name']	= $('.file_btn').text();	
					data['ext']		= $('input[name="attach_file_ext"]').val();	
				}	
			}else{
				if($.browser.msie){
					var filename	= Math.floor((Math.random()*9999)+1);
					var ext			= $('iframe').contents().find('input[type="file"]').val().split('.');
					var file		= filename+'.'+ ext[ext.length - 1];
					ext				= ext[ext.length - 1];
					
					$('input[name="attach_file_ext"]').val(ext);
					$('input[name="nameid"]').val(file);
					$('iframe').contents().find('#filename').val(file);
					
					data['nameid']	= $('input[name="nameid"]').val();
					data['name']	= $('input[name="nameid"]').val();
					data['ext']		= $('input[name="attach_file_ext"]').val();
				}else{
					data['nameid']	= $('input[name="nameid"]').val();	
					data['name']	= $('.file_btn').text();	
					data['ext']		= $('input[name="attach_file_ext"]').val();	
				}
				
				$('iframe.fileupload_iframe').contents().find('form').submit();
			}
			
			data['ufid']		= $('input[name="ufid"]').val();
			var udpateTopic		= new lmsForum.topicBackend(data);
			
			udpateTopic.save(null, {success: function(model, response){
				if(response[0] !== false){
					$('.ui-icon-closethick').trigger('click');	
					setTimeout(function(){
						Menu.message('success','Success.');
					}, 500);				
					
					var topicCurPage = window.location.href.split('#')[1].split('/')[1];
					if(topicCurPage === 'list'){
						// Update topic list title
						$('#post-id-'+data['fpid']).before().parent().prev().prev().html('<a href="#topic/thread/'+data['title']+'/'+data['fpid']+'/pager1">'+data['title']+'</a>');
					}else{
						// Update thread's main post
						$('div.thread_container .orig_post_content').html(data['title']+'<br /><br />'+data['content']);
					}
				}else{
					Menu.message('warning','Error! Unable to delete this topic.');
				}
			}});
		}
	
		return false;
	},
	
	addReply:	function(){
		tinyMCE.triggerSave();
		
		var result;
		var textArea	= 'reply_textarea';
		var content 	= tinymce.get(textArea).getContent();
		
		if ($.trim(content) == ''){
			$('#'+textArea+'_ifr').css({'border' : '1px solid #ce1f1f'});			
			result = false;
		}
		
		$('#'+textArea+'_ifr').contents().find(".mceContentBody").unbind("keyup");
		
		$('#'+textArea+'_ifr').contents().find('.mceContentBody').keyup(function(){
			if(tinymce.get(textArea).getContent() == ''){
				$('#'+textArea+'_tbl').css({'border' : '1px solid #ce1f1f'});
				result = false;
			}
			else{
				$('#'+textArea+'_ifr').css({
					'border' : '1px solid #bbb',
					'border-bottom' : 'none',
					'border-top' : 'none'
				});
				
				result = true;
			}
		});
		
		if(result !== false){
			var data				= {};
			var topic				= window.location.href.split('#')[1].split('/')[2];
			data['fpid']			= window.location.href.split('#')[1].split('/')[3];
			var fpid				= data['fpid'];
			
			if($('.ui-dialog div.quote_reply').is(':visible') === true){
				data['comment']		= '<div class="quote_reply">'+$('.ui-dialog div.quote_reply').html()+'</div>'+$('#reply_textarea').val();
			}else{
				data['comment']		= $('#reply_textarea').val();
			}

			data['crud']			= 'c';
			data['forum_section']	= 'thread';
			data['id']				= data['fpid'];

			var addThread			= new lmsForum.threadBackend(data);
			
			addThread.save(null, {success: function(model, response){
				if(response['stat'] != false){					
					$('.ui-icon-closethick').trigger('click');	
					setTimeout(function(){
						Menu.message('success','Comment successful!');
					}, 500);
					
					var router		= new lmsForum.topicRouter();
					var totalRows	= parseInt(response.total_rows[0].total) + 1;
					var pager		= Math.ceil(totalRows / response.topic_row_limit);
					
					router.navigate('topic/thread/'+topic+'/'+fpid+'/pager'+pager);
					router.topicThread(topic,fpid,pager);
				}
				else{
					Menu.message('warning','Error! Unable to delete this topic.');
				}		
			}});
		}
		
		this.model.destroy();
		return false;
	},
	
	updateCommentThread:	function(){
		tinyMCE.triggerSave();
		var data		= {};
		data['comment']	= $('#reply_textarea').val();
		data['fpcid']	= $('input[name="fpcid"]').val();
		// if quote exist
		
		data['crud']			= 'u';
		data['forum_section']	= 'thread';
		data['id']				= data['fpid'];

		var updateThread			= new lmsForum.threadBackend(data);
		
		updateThread.save(null, {success: function(model, response){
			if(response.stat !== false){
				$('.ui-icon-closethick').trigger('click');	
				setTimeout(function(){
					Menu.message('success','Comment updated.');
				}, 500);				
				
				// Update topic list title
				$('#comment-id-'+data['fpcid']+' table tbody td.comment_post_content').html(data['comment']);
			}else{
				Menu.message('warning','Error! Unable to update this topic.');
			}		
		}});
		
		return false;
	},
	
	attachFile:	function(e){		
		if($.browser.msie){
			// $('iframe.fileupload_iframe').contents().find('input[name="file"]').trigger('click');
			// $('iframe.fileupload_iframe').contents().find('input[name="file"]').click(function(){
				// setTimeout(function(){
					// this.blur();
					// this.focus();
					// alert(123);				
				// }, 0)
			// });
			// $('form[name="category_form"] iframe').show();
			// $('.attach_file').hide();
			// alert(123);
		}else{
			$('form[name="category_form"] img').show();
			$('iframe.fileupload_iframe').contents().find('input[name="file"]')
			.trigger('click')
			.change(function(){	
				$(e.currentTarget).text('Change');
				if (this.files && this.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('img.icon').attr('src', e.target.result).css({'marginTop': '10px', 'height': '100px'});
						$('.fileupload_label').css({'height': $('img.icon').height() + 25});
					};
					reader.readAsDataURL(this.files[0]);
				}
			});
		}		
	},
	
	threadAttachFile:	function(e){
		if($.browser.msie){
			// $('iframe.fileupload_iframe').contents().find('input[name="file"]').trigger('click');
			// $('iframe.fileupload_iframe').contents().find('input[name="file"]').click(function(){
				// setTimeout(function(){
					// this.blur();
					// this.focus();
					// alert(123);				
				// }, 0)
			// });
			// $('form[name="category_form"] iframe').show();
			// $('.attach_file').hide();
			// alert(123);
		}else{
			$('iframe.fileupload_iframe').contents().find('input[name="file"]')
			.trigger('click')
			.change(function(){	
				// $(e.currentTarget).text('Change');
				// if (this.files && this.files[0]) {
					// var reader = new FileReader();
					// reader.onload = function (e) {
						// var dialogHeight	= 400 + 130; // $('.ui-dialog').height()
						// $('.uploaded_img').show()
						// .attr('src', e.target.result)
						// .css({
							// 'margin-bottom': 	'4px', 
							// 'height': 			'100px',
							// 'margin-left': 		'5px'
						// });
						
						// $('.ui-dialog, .addTopic_dialog').css({'height': dialogHeight});
					// };
					// reader.readAsDataURL(this.files[0]);
				// }
				var dialogHeight	= 400 + 30; // $('.ui-dialog').height() | 400
				var filename		= Math.floor((Math.random()*9999)+1);
				var ext				= $('iframe').contents().find('input[type="file"]').val().split('.');
				var file			= filename+'.'+ ext[ext.length - 1];
				
				$('.ui-dialog, .addTopic_dialog').css({'height': dialogHeight});
				$('input[name="nameid"]').val(file);
				$('iframe').contents().find('#filename').val(file);
				$('input[name="attach_file_ext"]').val(ext);
				
				$('div.uploaded_filename').show();
				$('a.file_btn').text(file);
			});
		}
	},
	
	renameFile:	function(e){
		if($.browser.msie !== true){
			$('div.uploaded_filename').hide();
			$('div.uploaded_rename').show();
			var file	= $(e.currentTarget).text().split('.')[0];
			var ext		= $(e.currentTarget).text().split('.')[1];
			$('input[name="attach_file_name"]').val(file);
			$('input[name="attach_file_ext"]').val(ext);
		}
	},
	
	renameFileExc:	function(){
		$('div.uploaded_filename').show();
		$('div.uploaded_rename').hide();
		var file	= $('input[name="attach_file_name"]').val();
		var ext		= $('input[name="attach_file_ext"]').val();
		$('a.file_btn').text(file+'.'+ext);
	},
	
	deleteAttachFile:	function(){
		$('div.uploaded_filename').hide();
		$('div.uploaded_rename').hide();
		$('iframe').contents().find('input[type="file"]').val('');
		$('.uploaded_img')
		.removeAttr('src')
		.css({'display': 'none'});
		
		var dialogHeight = $('.ui-dialog').height() - 40;
		$('.ui-dialog, .addTopic_dialog').css({'height': '400px'});
	}
});



// $(function(){
$(document).ready(function() {
	// Router
	new lmsForum.categoryRouter(); 		
	new lmsForum.topicRouter();
	
	// View
	new lmsForum.categoryList();
	new lmsForum.topicList();	
	new lmsForum.threadList();
	
	// setTimeout(function(){
		// tinyMCE.init({
		// mode : 'specific_textareas',
		// editor_selector : 'html_editor',
		// theme : 'advanced',
		// plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',

		// theme_advanced_buttons1 : 'newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		// theme_advanced_buttons2 : ',search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,'+lmsForum.mainGlobal.tinyMce_image_display+'cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		// theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
		
		// theme_advanced_toolbar_location : 'top',
		// theme_advanced_toolbar_align : 'left',
		// theme_advanced_statusbar_location : 'bottom',
		// theme_advanced_resizing : true
	// });
	// },1000);
	
	Backbone.history.start();
}); 