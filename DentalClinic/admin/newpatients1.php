<?php
/* 
 NEW.PHP
 Add a new patient
*/
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Function to display the patient form
function shfaqPatient($PatientName, $PatientSurname, $PatientPhoneNumber, $PatientBirthdate, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title>Add Patient</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            /* background-color: rgb(72, 121, 228); */
        }
        .container {
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control.custom-color {
            /* background-color: #4a90e2; */
            border: 1px solid #1e7ec8;
            /* color: #fff; */
        }
        .form-control.custom-color::placeholder {
            color: black;
        }
        .btn-primary {
            margin-top: 15px;
        }
        .error {
            padding: 4px;
            border: 1px solid red;
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add Patient Information</h2>
    <?php
    if ($error != '') {
        echo '<div class="error">'.$error.'</div>';
    }
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="PatientName">Patient Name</label>
            <input type="text" class="form-control custom-color" name="PatientName" id="PatientName" placeholder="Patient Name" value="<?php echo $PatientName; ?>">
        </div>
        <div class="form-group">
            <label for="PatientSurname">Patient Surname</label>
            <input type="text" class="form-control custom-color" name="PatientSurname" id="PatientSurname" placeholder="Patient Surname" value="<?php echo $PatientSurname; ?>">
        </div>
        <div class="form-group">
            <label for="PatientPhoneNumber">Patient Phone Number</label>
            <input type="number" max="0699999999" class="form-control custom-color" name="PatientPhoneNumber" id="PatientPhoneNumber" placeholder="Patient Phone Number" value="<?php echo $PatientPhoneNumber; ?>">
        </div>
        <div class="form-group">
            <label for="PatientBirthdate">Patient Birthdate</label>
            <input type="date" class="form-control custom-color" name="PatientBirthdate" id="PatientBirthdate" placeholder="Patient Birthdate" value="<?php echo $PatientBirthdate; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add Patient</button>
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
    // Get form values and sanitize
    $PatientName = mysqli_real_escape_string($conn, htmlspecialchars($_POST['PatientName']));
    $PatientSurname = mysqli_real_escape_string($conn, htmlspecialchars($_POST['PatientSurname']));
    $PatientPhoneNumber = $_POST['PatientPhoneNumber'];
    $PatientBirthdate = $_POST['PatientBirthdate'];

    // Check if all fields are filled
    if ($PatientName == '' || $PatientSurname == '' || empty($PatientPhoneNumber) || empty($PatientBirthdate)) {
        $error = 'Complete all fields!';
        // Show form again with error
        shfaqPatient($PatientName, $PatientSurname, $PatientPhoneNumber, $PatientBirthdate, $error);
    } else {
        // Insert data into database
        mysqli_query($conn, "INSERT INTO patient SET PatientName='$PatientName', PatientSurname='$PatientSurname', PatientPhoneNumber='$PatientPhoneNumber', PatientBirthdate='$PatientBirthdate'")
            or die(mysqli_error($conn));
        // Redirect to view page after insert
        header("Location: viewPatients1.php");
    }
} else {
    // Show empty form for first time
    shfaqPatient('', '', '', '', '');
}
?>
