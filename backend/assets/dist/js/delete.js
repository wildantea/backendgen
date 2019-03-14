$(function(){

   $(".table").on('click','.hapus_dtb_notif',function(event) {
  
    event.stopPropagation();
    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id');
    dtb = currentBtn.attr('data-dtb');
    dtb_var = currentBtn.attr('data-variable');


    $('#modal-confirm-delete')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

        $.ajax({
          type: "POST",
          dataType: 'json',
          error: function(data ) { 
              $('#loadnya').hide();
              console.log(data); 
              $('.selected-data').html('');
              $('#bulk_delete').hide();
             $('.isi_warning_delete').html(data.responseText);
             $('.error_data_delete').fadeIn();
             $('html, body').animate({
                scrollTop: ($('.error_data_delete').first().offset().top)
            },500);
          },
          url: uri+"?act=delete",
          data : {id:id},
             success: function(responseText) {
                  $("#loadnya").hide();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                          console.log(responseText[index].status);
                          if (responseText[index].status=='die') {
                            $("#informasi").modal("show");
                          } else if(responseText[index].status=='error') {
                             $('.isi_warning_delete').text(responseText[index].error_message);
                             $('.error_data_delete').fadeIn();
                             $('html, body').animate({
                                scrollTop: ($('.error_data_delete').first().offset().top)
                            },500);
                          } else if(responseText[index].status=='good') {
                            $('.selected-data').html('');
                            $('#bulk_delete').hide();
                            $('.error_data_delete').hide();
                            $("#line_"+id).fadeOut("slow");
                             window[dtb_var].draw(false);
                          }
                    });
                }
          });
          $('#modal-confirm-delete').modal('hide');

        });
  });
   

    var DtableManual = $("#dtb_manual").DataTable();
   $(".table").on('click','.hapus',function(event) {
  //  $('.hapus').click(function(){

    event.preventDefault();
    var currentBtn = $(this);

		uri = currentBtn.attr('data-uri');
		id = currentBtn.attr('data-id');
    dtb = currentBtn.attr('data-dtb');


    $('#modal-confirm-delete')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
			    type: "POST",
			    url: uri+"?act=delete",
          data : {id:id},
			    success: function(data){
              $("#line_"+id).addClass('deleted');
              DtableManual.row('.deleted').remove().draw( false );
			    }
			    });
          $('#modal-confirm-delete').modal('hide');

        });



  });


       $(".table").on('click','.hapus_manual',function(event) {

    event.stopPropagation();
    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id');
    dtb = currentBtn.attr('data-dtb');


    $('#modal-confirm-delete')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=delete",
          data : {id:id},
          success: function(data){

              $("#line_"+id).fadeOut("slow");

          }
          });
          $('#modal-confirm-delete').modal('hide');

        });



  });

  


   $(".table").on('click','.hapus_dtb',function(event) {

    event.stopPropagation();
    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id');
    dtb = currentBtn.attr('data-dtb');


    $('#modal-confirm-delete')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=delete&id="+id,
          success: function(data){

              $("#line_"+id).fadeOut("slow");

             dataTable.draw(false);
          }
          });
          $('#modal-confirm-delete').modal('hide');

        });
  });


$('body').on('click', '.hapus_foto', function(event) {

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id');

    $('#modal-confirm-delete')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=hapus_foto&id="+id,
          success: function(data){
            console.log(data);


              $("#foto_"+id).remove();
          }
          });
          $('#modal-confirm-delete').modal('hide');
          //location.reload();
        });



  });

$('body').on('click', '.hapus_album', function(event) {

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    gallery_uri = currentBtn.attr('data-gallery');
    id = currentBtn.attr('data-id');

    $('#modal-confirm-delete')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=hapus_album&id="+id,
          success: function(data){
            console.log(data);
          }
          });
          $('#modal-confirm-delete').modal('hide');
         window.location=gallery_uri;
        });



  });

 $('.alert').on('click','.hide_alert_notif',function(){
        $(this).closest('.alert').slideUp();
   });
});
