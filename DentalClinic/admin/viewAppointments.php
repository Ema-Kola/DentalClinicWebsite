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
  <title>View Appointments</title>
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
  <h2>Appointments</h2>
  <div class="button-container">
    <a href="index.php" class="btn btn-dark">Dashboard</a>
  </div>
  <div class="search-container">
    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for ...">
    <select id="filterCol" class="form-control" onchange="myFunction()">
      <option value="1">Date</option>
      <option value="2">Time</option>
      <option value="3">Patient</option>
      <option value="4">Doctor</option>
      <option value="5">Description</option>
      <option value="6">Status</option>
    </select>
  </div>
  <table id="appts" class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Patient</th>
        <th>Doctor</th>
        <th>Description</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
     
        // Connect to the database
        include('connect-db.php');
  

        // Retrieve results from the database
        $result = mysqli_query($conn, "SELECT * FROM appointments") or die(mysqli_error($conn));

        while($row = mysqli_fetch_array($result)) {
          $patientID = $row['patientID'];
          $doctorID = $row['doctorID'];

          // Fetch patient name
          $patient_query = "SELECT * FROM patient WHERE PatientID = '$patientID'";
          $patient_result = mysqli_query($conn, $patient_query);
          $patient_data = mysqli_fetch_array($patient_result);

          // Fetch doctor name
          $doctor_query = "SELECT * FROM doctors WHERE DoctorID = '$doctorID'";
          $doctor_result = mysqli_query($conn, $doctor_query);
          $doctor_data = mysqli_fetch_array($doctor_result);

          echo "<tr>";
          echo '<td>' . $row['appointmentID'] . '</td>';
          echo '<td>' . $row['date'] . '</td>';
          echo '<td>' . $row['time'] . '</td>';
          echo '<td>' . $patient_data['PatientName'] . ' ' . $patient_data['PatientSurname'] . '</td>';
          echo '<td>' . $doctor_data['DoctorName'] . ' ' . $doctor_data['DoctorSurname'] . '</td>';
          echo '<td>' . $row['description'] . '</td>';
          echo '<td>' . $row['status'] . '</td>';
          echo '<td><a href="editAppointment.php?id=' . $row['appointmentID'] . '" class="btn btn-primary btn-sm">Edit</a></td>';
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
  <p><a href="newAppointment.php" class="btn btn-success">Add new appointment</a></p>
</div>

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue, f;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("appts");
  tr = table.getElementsByTagName("tr");
  f = document.getElementById("filterCol").value;

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 1; i < tr.length; i++) { // start from 1 to skip the header row
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
