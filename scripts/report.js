$('#filterReportForm').on('submit', function (event) {
  event.preventDefault();
  console.log("fasdfsad");
  $.ajax({
    url: 'generateFPDF.php',
    method: 'POST',
    data: $('#filterReportForm').serialize()
  });
});


$("#datepicker").datepicker({
  format: "yyyy-mm",
  startView: "months",
  minViewMode: "months"
});


$('#generateReportForm').on('submit',function(event){
  event.preventDefault();
  console.log("aaaaaa");
  $.ajax({
       url:'reportTableGeneration.php',
       method: 'POST',
       data: $('#generateReportForm').serialize(),
       success:function(data){
          $('#reportTable').html(data);
       }
  });
});

$('#generateGraphForm').on('submit',function(event){
  event.preventDefault();
  console.log("fasdfsad");
  $.ajax({
       url:'reportGenerateGraph.php',
       method: 'POST',
       data: $('#generateGraphForm').serialize(),
       success:function(data){
          $('#graphicalReport').html(data);
          //Swal.fire("Updated!", "Service has been updated successfully!", "success");
       }
  });
});
