
<?php
/* 
 EDIT.PHP
 Edit specific data of a row
*/
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Function to display the edit form
function showEditForm($id, $PatientName, $PatientSurname, $PatientBirthdate, $PatientPhoneNumber, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title>Edit Patient Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Edit Patient Details</h2>
    <?php 
    // Display errors if any
    if ($error != '') {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
    ?> 
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>

        <div class="form-group">
            <label for="PatientName">Patient Name</label>
            <input type="text" name="PatientName" class="form-control" id="PatientName" placeholder="Patient Name" value="<?php echo $PatientName; ?>">
        </div>

        <div class="form-group">
            <label for="PatientSurname">Patient Surname</label>
            <input type="text" name="PatientSurname" class="form-control" id="PatientSurname" placeholder="Patient Surname" value="<?php echo $PatientSurname; ?>">
        </div>

        <div class="form-group">
            <label for="PatientBirthdate">Patient Birth Date</label>
            <input type="date" name="PatientBirthdate" class="form-control" id="PatientBirthdate" placeholder="Patient Birth Date" value="<?php echo $PatientBirthdate; ?>">
        </div>

        <div class="form-group">
            <label for="PatientPhoneNumber">Patient Phone Number</label>
            <input type="number" max="0699999999" name="PatientPhoneNumber" class="form-control" id="PatientPhoneNumber" placeholder="Patient Phone Number" value="<?php echo $PatientPhoneNumber; ?>">
        </div>
   
        <button type="submit" class="btn btn-primary" name="submit">Edit Patient Detail</button>
    </form>
</div>
</body>
</html> 
<?php
}

// Database connection
include('connect-db.php');

// Check if form is submitted
if (isset($_POST['submit'])) { 
    // Check if 'id' is numeric
    if (is_numeric($_POST['id'])) {
        // Get form values and validate
        $id = $_POST['id'];
        $PatientName = $_POST['PatientName'];
        $PatientSurname = $_POST['PatientSurname'];
        $PatientBirthdate = $_POST['PatientBirthdate'];
        $PatientPhoneNumber = $_POST['PatientPhoneNumber'];

        // Update data in database
        mysqli_query($conn, "UPDATE patient SET PatientName='$PatientName', PatientSurname='$PatientSurname', PatientBirthdate='$PatientBirthdate', PatientPhoneNumber='$PatientPhoneNumber' WHERE PatientID='$id'")
            or die(mysqli_error($conn));

        // Redirect to view page after update
        header("Location: viewPatients1.php"); 
    } else {
        // If 'id' is not valid, show error
        echo 'Error!';
    }
} else {
    // If form is not submitted, get data from database
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        // Fetch data from database based on 'id'
        $id = $_GET['id'];
        $result = mysqli_query($conn, "SELECT * FROM patient WHERE PatientID=$id")
            or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);
        // Check if 'id' matches with any row in database
        if ($row) {
            // Get data from database
            $PatientName = $row['PatientName'];
            $PatientSurname = $row['PatientSurname'];
            $PatientBirthdate = $row['PatientBirthdate'];
            $PatientPhoneNumber = $row['PatientPhoneNumber'];
            // Show form
            showEditForm($id, $PatientName, $PatientSurname, $PatientBirthdate, $PatientPhoneNumber, '');
        } else {
            // If no match found, display message
            echo "No patient records found!";
        }
    } else {
        // If 'id' is not valid or not provided in URL, show error
        echo 'Error!';
    }
}
?>
