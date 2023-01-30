$('#addRequestForm').on('submit',function(event){
    event.preventDefault();
    $.ajax({
         url:'requestAdd.php',
         method: 'POST',
         data: $('#addRequestForm').serialize(),
         success:function(data){
            $('#addRequestForm')[0].reset();
            Swal.fire("Requested!", "Request have been submitted!", "success");
         }
    });
 });

 $(document).on('click', '.deleteButton', function(){
   var requestId = $(this).attr('requestIdDelete');//pertains to the document, looks for attribute named (class)
   console.log(requestId);
   Swal.fire({
       title: "Are you sure  to delete this Request?",
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
               url: 'requestDelete.php',
               method: 'POST',
               data: {requestId_js:requestId},
               success:function(data){
                   $('#requestsTable').html(data);
                   Swal.fire("Deleted", "Request has been deleted!", "success");
               }
           });
       }
   });    
});
 
 $(document).on('click', '.checkButton', function(){
   var requestId = $(this).attr('requestIdCheck');
   console.log(requestId);
   $.ajax({
       //note that colon represents an equal symbol in ajax
       url: 'requestCheck.php',
       method: 'POST',
       data: {requestId_js:requestId},
       success:function(data){
           $('#checkRequestModal').modal('show');
           $('#showModalBodyFooter').html(data);        
       }
   });
});



$(document).on('click', '.cancelRequestButton', function(){
    var requestId = $(this).attr('requestIdCheck');//pertains to the document, looks for attribute named (class)
    var requestStatus = $(this).attr('requestStatusId');//pertains to the document, looks for attribute named (class)
    //console.log(requestId);
    console.log(requestStatus);
    Swal.fire({
        title: "Are you sure you want to cancel this Request?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "No, I changed my mind",
        confirmButtonText: "Yes, Cancel It",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                //note that colon represents an equal symbol in ajax
                url: 'requestUpdate.php',
                method: 'POST',
                data: {requestId_js:requestId,requestStatus_js:requestStatus},
                success:function(data){
                    $('#clientRequests').html(data);
                    Swal.fire("Cancelled", "Request has been cancelled but may appear in other locations.", "success");
                }
            });
        }
    });    
 });




 
 $(document).on('click', '.finishServiceButton', function(){
    var requestId = $(this).attr('requestIdCheck');//pertains to the document, looks for attribute named (class)
    var requestStatus = $(this).attr('requestStatusId');//pertains to the document, looks for attribute named (class)
    //console.log(requestId);
    console.log(requestStatus);
    Swal.fire({
        title: "Concluding the Service",
        text: "By clicking yes, you agree that this service is complete.",
        icon: "info",
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonText: "Yes",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                //note that colon represents an equal symbol in ajax
                url: 'requestUpdate.php',
                method: 'POST',
                data: {requestId_js:requestId,requestStatus_js:requestStatus},
                success:function(data){
                    $('#clientRequests').html(data);
                    Swal.fire("Service Completed!", "Thank you for choosing Handy Homes Services.", "success");
                }
            });
        }
    });    
 });




$('#checkRequestForm').on('submit',function(event){
   event.preventDefault();
   $.ajax({
        url:'requestSaveChanges.php',
        method: 'POST',
        data: $('#checkRequestForm').serialize(),
        success:function(data){
           $('#checkRequestModal').modal('hide');
           $('#requestsTable').html(data);
           $('#checkRequestForm')[0].reset();
           Swal.fire("Modified!", "Request have been Modified!", "success"); 
        }    
   });
});