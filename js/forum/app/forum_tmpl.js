lmsForum.tmpl	= {
	categoryForm: function(){
		var elem	= 	'<table>\
							<tbody>\
							<tr>\
								<td>Username</td>\
								<td><input type="text" name="username" /></td>\
							</tr>\
							</tbody>\
							</table>\
						';
		return elem;
	},
	
	categoryList:	function(fields){
		var modify_delete	= '';
		if(parseInt(fields['uid']) === parseInt(fields['session_uid'])){
			modify_delete	= 	'<td class="category_last">\
									<ul class="forum_btns">\
										<li><a class="btn_management modify_category" id="category-id-'+fields['fcid']+'" href="javascript:void(0)" title="Modify">M</a></li>\
										<li class="last"><a class="btn_management delete_category_topic" href="javascript:void(0)" title="Delete">C</a></li>\
									</ul>\
								</td>\
								';
		}else{
			modify_delete	= '<td class="category_last"></td>';
		}
		var elem	=	'<tr id="category-tr-id-'+fields['fcid']+'">\
							<td><input type="checkbox" value="'+fields['fcid']+'" name="category_checkbox[]" /></td>\
							<td>'+fields['fcid']+'</td>\
							<td><a href="#topic/list/'+fields['name']+'/'+fields['fcid']+'/page1">'+fields['name']+'</a></td>\
							<td>'+fields['style']+'</td>\
							<td>'+fields['regdate']+'</td>\
							'+modify_delete+'\
							</tr>\
						';
		return elem;
	},

	topicList:	function(fields){
		var modify_delete	= '';
		if(parseInt(fields['uid']) === parseInt(fields['session_uid'])){
			modify_delete	= '<td class="forum_last"><a class="btn_management modify-post" id="post-id-'+fields['fpid']+'" href="javascript:void(0)" title="Modify">M</a></td>';
		}else{
			modify_delete	= '<td class="forum_last"></td>';
		}
		var elem	=	'<tr id="post-tr-id-'+fields['fpid']+'">\
							<td><input type="checkbox" value="'+fields['fpid']+'" name="topic_list_checkbox[]"  /></td>\
							<td>'+fields['fpid']+'</td>\
							<td><a href="javascript:void(0)">'+fields['username']+'</a></td>\
							<td><a href="#topic/thread/'+fields['title']+'/'+fields['fpid']+'/pager1">'+fields['title']+'</a></td>\
							<td>'+fields['post_date']+'</td>\
							'+modify_delete+'\
							</tr>\
						';
		return elem;
	},
	
	commentList:	function(fields){
		var modify_delete	= '';
		if(parseInt(fields['uid']) === parseInt(fields['session_uid'])){
			modify_delete	= '	<li><a href="javascript:void(0)" class="forum_btns thread_reply_btn" title="Reply">Reply</a></li>\
								<li><a href="javascript:void(0)" class="forum_btns thread_edit_btn" title="Edit">Edit</a></li>\
								<li><a href="javascript:void(0)" class="forum_btns thread_quote_btn" title="Quote">Quote Reply</a></li>\
								<li><a href="javascript:void(0)" class="forum_btns thread_delete_btn" title="Delete">Delete</a></li>\
							';
		}else{
			modify_delete	= '	<li><a href="javascript:void(0)" class="forum_btns thread_reply_btn" title="Reply">Reply</a></li>\
								<li><a href="javascript:void(0)" class="forum_btns thread_quote_btn" title="Quote">Quote Reply</a></li>\
							';
		}
		var elem	= '<li class="rows comment_rows" id="comment-id-'+fields['fpcid']+'" style="display: none;">\
						<div class="posthead">\
							<p>'+fields['reply_date']+'</p>\
						</div>\
						<table border="0" cellspacing="0" cellpadding="0" class="postbody">\
							<colgroup>\
								<col width="250" />\
								<col />\
							</colgroup>\
							<tr>\
								<td class="userinfo">\
									<p class="name"><a href="javascript:void(0)" class="comment_post_author">'+fields['author']+'</a></p>\
									<img class="comment_author_profile" alt="User Image" src="'+fields['profile_img']+'" style="height: 100px;" />\
									<p class="member">Member Since ['+fields['member_since']+']</p>\
								</td>\
								<td class="postcontent comment_post_content">'+fields['comment']+'</td>\
							</tr>\
						</table>\
						<div class="post_btns">\
							<ul>'+modify_delete+'</ul>\
						</div>\
					</li>\
					';
		return elem;
	},
	
	paginationTmpl: function(curPage,rowsPerPage,totalRows,uri){
		var pageRows	= Math.ceil(totalRows / rowsPerPage);
		var rowTmpl		= '';
		var prev, next, totalpage, pagerMode;
		curPage			= parseInt(curPage);
		
		for(var acntr=1; acntr<=pageRows; acntr++){
			if(acntr === curPage){
				rowTmpl	+=	'<li><a class="current" href="#'+uri+''+acntr+'">'+acntr+'</a></li>';
			}else{
				if(acntr < curPage){
					// Left side
					if((curPage - 3) > 1){
						// With dots
						if(acntr < curPage && acntr >= (curPage - 2)){
							if(acntr === (curPage - 2)){
								rowTmpl	+=	'<li><a class="num" href="#'+uri+'1">1</a></li>';
								rowTmpl	+=	'<li><span>...</span></li>';
							}
							rowTmpl	+=	'<li><a class="num" href="#'+uri+''+acntr+'">'+acntr+'</a></li>';
						}
					}else{
						rowTmpl	+=	'<li><a class="num" href="#'+uri+''+acntr+'">'+acntr+'</a></li>';
					}
				}else{
					// Right side
					if((curPage + 3) < pageRows){
						if(acntr > curPage && acntr <= (curPage + 2)){
							rowTmpl	+=	'<li><a class="num" href="#'+uri+''+acntr+'">'+acntr+'</a></li>';
							if(acntr === (curPage + 2)){
								rowTmpl	+=	'<li><span>...</span></li>';
								rowTmpl	+=	'<li><a class="num" href="#'+uri+''+pageRows+'">'+pageRows+'</a></li>';
							}
						}
					}else{
						rowTmpl	+=	'<li><a class="num" href="#'+uri+''+acntr+'">'+acntr+'</a></li>';
					}
				}
			}
		}
		
		
		// Previous
		if(curPage > 1){
			prev	= curPage - 1;
		}else{
			prev	= 1;
		}
		// Next
		if(curPage < pageRows){
			next	= curPage + 1;
		}else{
			next	= pageRows;
		}
		
		var elem	=	'<div class="pagination">\
							<ul>\
								<li><a href="#'+uri+''+prev+'" class="next">prev</a></li>'+rowTmpl+'<li class="next"><a href="#'+uri+''+next+'" class="next">next</a></li>\
							</ul>\
						</div>\
						';
							
		return elem;
	}
};