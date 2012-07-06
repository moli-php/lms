$(function(){
	// Global variables
	var gBranch	= {
		rootUrl: document.URL.split('?')[0]
	}
	
	// Show popup
	$('.manage-branch').live('click', function(){
		$('.popup_window').fadeIn();
		$('form#popup input[name="uid"]').remove();
		$('input[name="point"],input[name="referrer"]').val('');
		$('textarea[name="description"]').text('');
		
		var uid	= parseInt($(this).closest('td').attr('id').replace('uid-',''));
		$('form#popup').append('<input type="hidden" name="uid" value="'+uid+'" />');
		
		$.ajax({  
			url: gBranch.rootUrl+'controller/branch_model.php',
			dataType: 'json',
			data: 'display=display&uid='+uid,
			success: function(data){
				if(data.length > 0){
					$('input[name="active"]:eq('+data[0]['active']+')').attr('checked', true);
					$('input[name="point"]').val(data[0]['points']);
					$('input[name="referrer"]').val(data[0]['referrer']);
					$('textarea[name="description"]').text(data[0]['description']);
				}else{
					$('input[name="active"]:eq(0)').attr('checked', true);
				}
			}
		});
		
		return false;
	});
	
	// Hide popup
	$('div.btn_close a.btn_apply').click(function(){
		$('.popup_window').fadeOut();
		$('input, textarea').removeClass('error');
		return false;
	});
	
	// Submit popup
	$('.btn_save').click(function(){
		var result = $('form#popup').validateForm();
		
		if(result === true){
			var sData	= $('form#popup').serialize();
			var thisId	= sData.split('&')[4].replace('uid=','');
			
			$.ajax({  
				url: gBranch.rootUrl+'controller/branch_model.php',
				data: 'cu=cu&'+sData,
				success: function(data){
					if(data !== ''){
						var newPoint	= sData.split('&')[1].replace('point=','');
						var newActive	= (sData.split('&')[0].replace('active=','') == 1) ? 'Active' : 'Deactivated';
						
						$('td#uid-'+thisId).prev().prev().text(newPoint);
						$('td#uid-'+thisId).prev().text(newActive);
						
						$('.popup_window').fadeOut();
					}else{ 			
						console.log('Error');
					}
				}
			});
		}

		return false;
	});
	
	// Search
	$('#search').click(function(){
		// $('.post_table tbody tr').remove();
		// var username	= $('.username').val();
		
		// $.ajax({  
			// url: gBranch.rootUrl+'branch_model.php',
			// data: 'search=username&user_id='+username,
			// dataType: 'json',
			// success: function(data){
				// var dataLen	= data.length - 1;
				// for(var acntr=0; acntr<=dataLen; acntr++){
					// var html	= '<tr>';
						// html	+= '<td>'+data[acntr]['idx']+'</td>';
						// html	+= '<td>'+data[acntr]['user_id']+'</td>';
						// html	+= '<td>Name</td>';
						// html	+= '<td># of Students</td>';
						
						// if(data[acntr]['points'] === null){
							// var point	= 'N/A';
						// }else{
							// var point	= data[acntr]['points'];
						// }
						// html	+= '<td>'+point+'</td>';
						
						// html	+= '<td>'+data[acntr]['stat']+'</td>';
						// html	+= '<td id="uid-'+data[acntr]['idx']+'" class="manage-branch"><a class="btn_management" href="#none">M</a></td>';
						// html	+= '</tr>';
					// $('.post_table tbody').append(html);
				// }
			// }
		// });
		
		// return false;
		var result = $('form[name="search-form"]').validateForm();
		if(result === true){
			window.location.replace(gBranch.rootUrl+'?search='+$('.username').val()); 
		}
		else{
			return false;
		}
	});
	
	// Change row display
	$('.change-rows').change(function(){
		window.location.replace(gBranch.rootUrl+'?rows='+$(this).val());  
	});
	
	$('div.top').append('<a href="http://lms.dev.com/admin/user/" class="new_post">Add New Branch</a>');
});













