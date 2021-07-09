<?php
session_start();
$priv  = $_SESSION['role']=="ADMIN"?"ADMIN":$_SESSION['userid'];
?>

<h4>Report</h4>

<div class="card">
 
  <!-- /.card-header -->
  <div class="card-body">
    <br><br>
    <table id="report" class="table table-bordered table-hover" style="width:100%">
      <thead>
        <tr>
          <th>Username</th>
          <th>Checktime</th>          
        </tr>
      </thead>
    </table>


    
  </div>
</div>

<script>

$(document).ready(function(){
    var date = new Date().toISOString().split('T')[0];
    var priv = "<?=$priv?>";
    var table = $('#report').DataTable({
      ajax: "api.php?op=get_absensi&date="+date+"&priv="+priv,
      columns: [
        {
          data: "fullname"
        },
        {
          data: "checktime"
        }
      ],
      fnCreatedRow: function (nRow, aData, iDataIndex,cells) {        
      },
      buttons: ["copy", "csv", "excel", "pdf"],
      responsive: true, 
      autoWidth: false,
      initComplete: function() {
          table.buttons().container().appendTo('#report_wrapper .col-md-6:eq(0)');
          $("#report").show();
      }
      
    });

    table.buttons().container()
        .appendTo( '#report .col-md-6:eq(0)' );
});

</script>