$('#addServiceForm').on('submit',function(event){
    event.preventDefault();
    $.ajax({
         url:'serviceAdd.php',
         method: 'POST',
         data: $('#addServiceForm').serialize(),
         success:function(data){
             $('#addServiceModal').modal('hide');
             $('#serviceTable').html(data);
             $('#addServiceForm')[0].reset();
             Swal.fire("Success!", "Successfully added a Service!", "success");
         },fail:function(){
            Swal.fire("Error!", "User cannot be added!", "error");
         }
    });
 });
 
 $(document).on('click', '.deleteButton', function(){
    var serviceId = $(this).attr('serviceIdDelete');//pertains to the document, looks for attribute named (class)
    console.log(serviceId);
    Swal.fire({
        title: "Are you sure  to delete this Service?",
        text: "Deleted items cannot be retrieved!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete It",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                //note that colon represents an equal symbol in ajax
                url: 'serviceDelete.php',
                method: 'POST',
                data: {serviceId_js:serviceId},
                success:function(data){
                    $('#serviceTable').html(data);
                    Swal.fire("Deleted", "Service has been deleted!", "success");
                }
            });
        }
    });    
});


 $(document).on('click', '.updateButton', function(){
     var serviceId = $(this).attr('serviceIdUpdate');
     console.log(serviceId);
     $.ajax({
         //note that colon represents an equal symbol in ajax
         url: 'serviceUpdate.php',
         method: 'POST',
         data: {serviceId_js:serviceId},
         success:function(data){
             $('#updateServiceModal').modal('show');
             $('#showModalBodyFooter').html(data);
         }
     });
 });
 
 $('#updateServiceForm').on('submit',function(event){
     event.preventDefault();
     $.ajax({
          url:'serviceUpdateSaveChanges.php',
          method: 'POST',
          data: $('#updateServiceForm').serialize(),
          success:function(data){
             $('#updateServiceModal').modal('hide');
             $('#serviceTable').html(data);
             $('#updateServiceForm')[0].reset();
             Swal.fire("Updated!", "Service has been updated successfully!", "success");
          }
     });
  });

$('#searchServiceForm').on('submit',function(event){
    console.log("dadada");
    event.preventDefault();
    $.ajax({
         url:'serviceSearch.php',
         method: 'POST',
         data: $('#searchServiceForm').serialize(),
         success:function(data){
            $('#serviceTable').html(data);
            $('#searchServiceForm')[0].reset();
            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'Search Success',
                animation: false,
                position: 'center',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              });
         }
    });
 });
 