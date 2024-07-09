<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <title>View Patients</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    body {
      padding-top: 20px;
    }
    .search-container {
      margin-bottom: 20px;
    }
    .search-container input, .search-container select {
      display: inline-block;
      width: auto;
      margin-right: 10px;
    }
  </style>
</head>
<body>


<div class="container">
  <h2>View Patients</h2>
  <div class="button-container">
    <a href="index.php" class="btn btn-dark">Dashboard</a>
  </div>
  <div class="search-container">
    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for patients...">
    <select id="filterCol" class="form-control" onchange="myFunction()">
      <option value="1">Name</option>
      <option value="2">Surname</option>
      <option value="3">Phone Number</option>
      <option value="4">Birthdate</option>
    </select>
  </div>
  <table id="patients" class="table table-hover">
    <thead>
      <tr>
        <th>PatientID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Phone Number</th>
        <th>Birthdate</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Connect to the database
       
        include('connect-db.php');
    

        // Retrieve results from the database
        $result = mysqli_query($conn, "SELECT * FROM patient") or die(mysqli_error($conn));

        while($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo '<td>' . $row['PatientID'] . '</td>';
          echo '<td>' . $row['PatientName'] . '</td>';
          echo '<td>' . $row['PatientSurname'] . '</td>';
          echo '<td>' . $row['PatientPhoneNumber'] . '</td>';
          echo '<td>' . $row['PatientBirthdate'] . '</td>';
          echo '<td><a href="editPatients1.php?id=' . $row['PatientID'] . '" class="btn btn-primary btn-sm">Edit</a></td>';
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
  <p><a href="newPatients1.php" class="btn btn-success">Add new patient</a></p>
</div>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue, f;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("patients");
  tr = table.getElementsByTagName("tr");
  f = document.getElementById("filterCol").value;

  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[f];
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
