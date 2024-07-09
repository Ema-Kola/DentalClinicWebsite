<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Treatments</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>
  
<script>
function ConfirmDelete()
{
 return confirm("DELETE TREATMENT?”);
}
</script>

</head>
<body>


<?php

   include('connect-db.php');
   $result = mysqli_query($conn,"SELECT * FROM treatment")
       or die(mysqli_error($conn)); 
?>
   <div class='container'>
  <h2>Dental Treatments</h2>
  <div class="button-container">
    <a href="index.php" class="btn btn-dark">Dashboard</a>
  </div>
  <input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search for treatments...'>
  <br>
  <table id = 'myTable' class='table table-bordered table-striped'>
  <thead>
  <tr>
     <th>TreatmentName</th>
     <th>Price(ALL)</th>
   </tr>
 </thead>
    <tbody ><?php
    while($row = mysqli_fetch_array( $result )) {
      
       echo "<tr>";
       echo '<td>' . $row['TreatmentName'] . '</td>';
       echo '<td>' . $row['Price'] . '</td>';
       echo '<td><a href="editTreatment.php?id=' . $row['TreatmentID'] . '">Edit</a></td>';
       ?>
       <td><form name='delete' action='deleteTreatment.php?id=<?php echo $row['TreatmentID'];?> ' method='post'>
<input type="submit" value="Delete" Onclick="return ConfirmDelete()" />

</form></td>
       <?php
       echo "</tr>";
   }
   echo "</table>";
?>
<p><a href="addTreatment.php">Add new Treatment</a></p>
</div>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>
