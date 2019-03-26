$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $( ".btn-delete" ).click(function(e) {
      console.log("inside click handler");
      var resource = $(this).data('resource');
      var resource_id = $(this).data('resource_id');
      e.preventDefault();
      bootbox.confirm({
      title: "Delete " + resource + "?",
      message: "Are you sure you want to delete this " + resource + "? This cannot be undone.",
      buttons: {
          cancel: {
              label: '<i class="fa fa-times"></i> Cancel'
          },
          confirm: {
              label: '<i class="fa fa-check"></i> Confirm'
          }
      },
      callback: function (result) {
          if(result) {
              $.ajax({
                  url: '/' + resource + 's/' + resource_id,	
                  type: 'DELETE',
                  success: function(result) {
                  console.log(resource + " deleted? " + result);
                  }
              });
      };
      }
      });
  });
  
  $(document).ajaxStop(function(){
      window.location.reload();
  });
  
  
  