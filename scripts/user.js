
$('#addUserForm').on('submit',function(event){
    event.preventDefault();
  
    $.ajax({
         url:'userAdd.php',
         method: 'POST',
         data: $('#addUserForm').serialize(),
         success:function(data){
             $('#addUserModal').modal('hide');
             $('#userTable').html(data);
             $('#addUserForm')[0].reset();
             Swal.fire("Success!", "Successfully added a User!", "success");
         }
    });
 });

 
 $(document).on('click', '.deleteButton', function(){
     var userId = $(this).attr('userIdDelete');//pertains to the document, looks for attribute named (class)
     
     $.ajax({
         //note that colon represents an equal symbol in ajax
         url: 'userDelete.php',
         method: 'POST',
         data: {userId_js:userId},
 
         success:function(data){
             $('#userTable').html(data);
             Swal.fire("Deleted", "User has been deleted!", "error");
         }
     });
 });
 
 $(document).on('click', '.updateButton', function(){
     var userId = $(this).attr('userIdUpdate');
     console.log(userId);
 
     $.ajax({
         //note that colon represents an equal symbol in ajax
         url: 'userUpdate.php',
         method: 'POST',
         data: {userId_js:userId},
 
         success:function(data){
             $('#updateUserModal').modal('show');
             $('#showModalBodyFooter').html(data);
             
         }
     });
 });
 
 $('#updateUserForm').on('submit',function(event){
     event.preventDefault();
     $.ajax({
          url:'userUpdateSaveChanges.php',
          method: 'POST',
          data: $('#updateUserForm').serialize(),
          success:function(data){
             $('#updateUserModal').modal('hide');
             $('#updateUserForm')[0].reset();
             Swal.fire({
                toast: true,
                icon: 'success',
                title: 'Successfully updated user\'s account!',
                animation: false,
                position: 'center',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
             window.location.reload();
          }
     });
  });

  $('#searchUserForm').on('submit',function(event){
    event.preventDefault();
    console.log("adsfasd");
    $.ajax({
         url:'userSearch.php',
         method: 'POST',
         data: $('#searchUserForm').serialize(),
         success:function(data){
            $('#userTable').html(data);
            // $('#updateServiceForm')[0].reset();
            Swal.fire("Search", "Searched items", "info");
         }
    });
 });
 