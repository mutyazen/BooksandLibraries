$(function(){
	// $("#default-form").ajaxForm({
	// 	dataType: "json",
	// 	beforeSubmit: function(){
	// 		$('#btn-submit').prop('disabled', true);
	// 	},
	// 	success: function(data){
	// 		var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
 //            var sa_type = (data.type == 'done') ? "success" : "warning";
 //            Swal.fire({ title:sa_title, icon:sa_type, html:data.msg }).then(function(){ 
 //                if (data.type == 'done') window.location.reload(); 
 //            });
	// 	},
	// 	error: function(){
	// 		alertify.error('Error Occurred, Please refresh your browser.');
	// 	},
	// 	complete: function(){
	// 		$('#btn-submit').prop('disabled', false);
	// 	}
	// });
	$('#default-btn-modal').on('click', function(){
		$("#id").val("");
        $("#type").val("");
		var mod = $('#default-modal');
        mod.find('#modal-type').text( 'New Entry' );
	});
	$( '#default-form' ).on( 'submit', function(e) {
        e.preventDefault();
        var req_name 	= $("#library-name").val(),
        	req_id		= $("#id").val(),
        	req_type	= $("#type").val();
        $.ajax({
        	url: "/library/save",
        	data: { 'name' : req_name, 'id' : req_id, 'type' : req_type },
			type: 'POST',
            dataType: 'json',
            beforeSend: function(){
                $('#btn-submit').prop('disabled', true);
            },
            success: function(data){
                var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
                var sa_type = (data.type == 'done') ? "success" : "warning";
                Swal.fire({ title:sa_title, icon:sa_type, html:data.msg }).then(function(){ 
                    if (data.type == 'done') window.location.reload(); 
                });
            },
            error : function(){
                Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error" );
            },
            complete: function(){
                $('#btn-submit').prop('disabled', false);
            }

        
        });

    });

    $('#dt').on('click', '.btn-detail', function(){
		var row_id = $(this).data('id'),
			uri = $(this).data("uri");
		$.ajax({
			url: uri,
			type: 'post',
			data: { 'key' : row_id },
			dataType: 'json',
			
			beforeSend: function(){
			},
			success: function(data){
				if (data.type != 'done'){
					Swal.fire ( "Failed!", data.msg, "error" );
				}
				else {
                    $("#library-name").val(data.msg.name);
                    $('#library-name').attr('readonly', true);
                    $('#btn-submit').hide();
                    var mod = $('#default-modal');
                    mod.find('#modal-type').text( 'Detail' );
					mod.modal('show');
				}
			},
			error : function(){
				Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error" );
			},
			complete: function(){
			}
		});
	});

	$('#dt').on('click', '.btn-edit', function(){
		var row_id = $(this).data('id'),
			uri = $(this).data("uri");
		$.ajax({
			url: uri,
			type: 'post',
			data: { 'key' : row_id },
			dataType: 'json',
			
			beforeSend: function(){
			},
			success: function(data){
				if (data.type != 'done'){
					Swal.fire ( "Failed!", data.msg, "error" );
				}
				else {
                    $("#library-name").val(data.msg.name);
                    $("#id").val(data.msg.id);
                    $("#type").val("update");
                    $('#library-name').attr('readonly', false);
                    $('#btn-submit').show();
                    var mod = $('#default-modal');
                    mod.find('#modal-type').text( 'Edit' );
					mod.modal('show');
				}
			},
			error : function(){
				Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error" );
			},
			complete: function(){
			}
		});
	});

	$('#dt').on('click', '.btn-delete', function(){
		var row_id = $(this).data('id'),
			uri = $(this).data("uri"),
			row_name = $(this).data("title");
		
		Swal.fire({
			title: 'Delete data !',
			icon: 'warning',
			html: '<span class="italic">Are you sure to delete "<strong>' + row_name + '</strong>" ?</span>',
			showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
			confirmButtonColor: '#d33',
			cancelButtonColor: 'grey',
			showLoaderOnConfirm: true,
		}).then((result) => {
		  	if (result.value) {
		    	$.ajax({
		        	url: uri,
		        	data: { 'key' : row_id },
					type: 'POST',
		            dataType: 'json',
		            success: function(data){
		                var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
		                var sa_type = (data.type == 'done') ? "success" : "warning";
		                Swal.fire({ title:sa_title, icon:sa_type, html:data.msg }).then(function(){ 
		                    if (data.type == 'done') window.location.reload(); 
		                });
		            }
		        });
		  	}
		});
	});
});