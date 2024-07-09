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
    <title>Doctor Data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


<?php

    include('connect-db.php');



    // Fetch results from the table
    $result = mysqli_query($conn, "SELECT DoctorId, DoctorName, DoctorSurname, DoctorBirthday,DoctorPhone, DoctorRole, DoctorStatus FROM doctors") or die(mysqli_error($conn));
?>


<div class="container">
    <h2>Doctor Information</h2>
    <div class="button-container">
    <a href="index.php" class="btn btn-dark">Dashboard</a>
  </div>
    <input type="text" id="searchInput" onkeyup="myFunction()" placeholder="Search for names" class="form-control" style="margin-bottom: 10px;">
    <table class="table table-hover" id="doctorTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Birthdate</th>
                <th>Phone Number</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['DoctorId'] . "</td>";
                echo "<td>" . $row['DoctorName'] . "</td>";
                echo "<td>" . $row['DoctorSurname'] . "</td>";
                echo "<td>" . $row['DoctorBirthday'] . "</td>";
                echo "<td>" . $row['DoctorPhone'] . "</td>";
                echo "<td>" . $row['DoctorRole'] . "</td>";
                echo "<td>" . $row['DoctorStatus'] . "</td>";
                echo "<td><a href='editDoctor.php?id=" . $row['DoctorId'] . "'>Edit</a></td>";
                echo "</tr>";
            }
        ?>
    </table>
    <p><a href="addDoctor.php">Add new doctor.</a></p>
</div>


<script>
function myFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("doctorTable");
    tr = table.getElementsByTagName("tr");


    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) { // Start from i = 1 to skip the table header row
        td = tr[i].getElementsByTagName("td")[1]; // Assuming search by name, adjust index as needed
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