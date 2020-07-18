$(function(){
	$('#library').on('click', '.btn-modal', function(){
		var row_id = $(this).data('id'),
			row_name = $(this).data("name");
		$("#id").val(row_id);
        $("#type").val("");
        $("#id-trans").val("");
		var mod = $('#default-modal');
        mod.find('#modal-type').text( 'New Entry ' );
        mod.find('#book-form').text( 'Book Name ' );
        mod.find('#modal-library').text(row_name);
        mod.modal('show');
	});

	$( '#default-form' ).on( 'submit', function(e) {
        e.preventDefault();
        var req_name 	= $('#book-id').find(":selected").val(),
        	req_id		= $("#id").val(),
        	req_type	= $("#type").val(),
        	req_idtrans	= $("#id-trans").val();
        $.ajax({
        	url: "/home/save",
        	data: { 'name' : req_name, 'id' : req_id, 'type' : req_type, 'id_trans' : req_idtrans },
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

    $('#library').on('click', '.btn-book', function(){
		var row_idbook 	= $(this).data("idbook"),
			row_idtrans	= $(this).data("idtrans"),
			row_name	= $(this).data("name"),
			row_namelib	= $(this).data("namelib");

			$('#btn-edit-book').data('idtrans',row_idtrans);
			$('#btn-edit-book').data('idbook',row_idbook);

			$('#btn-delete-book').data('idtrans',row_idtrans);
			$('#btn-delete-book').data('idbook',row_idbook);
			$('#btn-delete-book').data('name',row_name);


			var mod = $('#default-modal-book');
	        mod.find('#modal-library').text(row_namelib);
	        mod.find('#modal-book').text(row_name);
	        mod.modal('show');
	});

	$('#btn-delete-book').on('click', function(){
		var row_idtrans = $(this).data('idtrans'),
			row_name = $(this).data("name");
		
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
		        	url: "/home/delete",
		        	data: { 'key' : row_idtrans },
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

	$('#btn-edit-book').on('click', function(){
		var row_idbook 	= $(this).data('idbook'),
			row_idtrans = $(this).data('idtrans');
		
		$.ajax({
			url: "home/detail",
			type: 'post',
			data: { 'key' : row_idbook },
			dataType: 'json',
			
			beforeSend: function(){
			},
			success: function(data){
				if (data.type != 'done'){
					Swal.fire ( "Failed!", data.msg, "error" );
				}
				else {
                    $('#book-form').html( 'Change <strong>' + data.msg.name + '</strong> to:' );

                    $("#id-trans").val(row_idtrans);
                    $("#type").val("update");

                    var mod = $('#default-modal');
                    mod.find('#modal-type').text( 'Edit ' );
					mod.modal('show');

			        $('#default-modal-book').modal('hide');
				}
			},
			error : function(){
				Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error" );
			},
			complete: function(){
			}
		});
	});

});