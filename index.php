<?php 
include 'database.php';
                  $sql = "SELECT * FROM crud";
                  $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>View Ajax</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   </head>
   <body>
      <div class="container">
         <h2>View data</h2>
         <table class="table table-bordered table-sm" >
            <thead>
               <tr>
                  <th><input type="checkbox" id="select_all"> Select </th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>City</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  
                  if ($result->num_rows > 0) {
                  	while($row = $result->fetch_assoc()) {
                  ?>	
               <tr id="<?php echo $row["id"]; ?>">
                  <td><input type="checkbox" class="ven_checkbox" data-emp-id="<?php echo $row["id"]; ?>"></td>
                  <td><?=$row['name'];?></td>
                  <td><?=$row['email'];?></td>
                  <td><?=$row['phone'];?></td>
                  <td><?=$row['city'];?></td>
                  <td><button type="button" class="btn btn-success btn-sm delete" data-id="<?=$row['id'];?>">Delete</button></td>
               </tr>
               <?php	
                  }
                  }
                  else {
                  echo "<tr >
                  <td colspan='5'>No Result found !</td>
                  </tr>";
                  }
                  //mysqli_close($conn);
                  ?>
            </tbody>
         </table>
         <div class="row">
            <div class="col-md-2 well">
               <span class="rows_selected" id="select_count">0 Selected</span>
               <a type="button" id="delete_records" class="btn btn-primary pull-right">Delete</a>
            </div>
         </div>
      </div>
      <script>
         $(document).ready(function() {
         	/* delete selected records*/
         	$('#delete_records').on('click', function(e) {
         		var vendor = [];
         		$(".ven_checkbox:checked").each(function() {
         			vendor.push($(this).data('emp-id'));
         		});
         		if(vendor.length <=0) {
         			alert("Please select records."); 
         		} 
         		else { 
         			WRN_PROFILE_DELETE = "Are you sure you want to delete "+(vendor.length>1?"these":"this")+" row?";
         			var checked = confirm(WRN_PROFILE_DELETE);
         			if(checked == true) {
         				var selected_values = vendor.join(",");
         				$.ajax({
         					type: "POST",
         					url: "delete_ajax.php",
         					cache:false,
         					data: 'id='+selected_values,
         					success: function(response) {
         						/* remove deleted vendor rows*/
         						var ids = response.split(",");
         						for (var i=0; i < ids.length; i++ ) {	
         							$("#"+ids[i]).remove(); 
         						}	
         					} 
         				});
         			} 
         		} 
         	});
         });	
         $(document).on('click', '#select_all', function() {
         	$(".ven_checkbox").prop("checked", this.checked);
         	$("#select_count").html($("input.ven_checkbox:checked").length+" Selected");
         });
         $(document).on('click', '.ven_checkbox', function() {
         	if ($('.ven_checkbox:checked').length == $('.ven_checkbox').length) {
         	$('#select_all').prop('checked', true);
         	} else {
         	$('#select_all').prop('checked', false);
         	}
         	$("#select_count").html($("input.ven_checkbox:checked").length+" Selected");
         });
      </script>
   </body>
</html>