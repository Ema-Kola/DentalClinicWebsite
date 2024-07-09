<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
function showEditForm($appointmentID, $date, $time, $status, $doctorID, $description, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title>Edit Record</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 600px;
        }
        .error {
            padding: 4px;
            border: 1px solid red;
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
if ($error != '') {
    echo '<div class="error">'.$error.'</div>';
}


include('connect-db.php');
$doctors = mysqli_query($conn, "SELECT * FROM doctors") or die(mysqli_error($conn));
$patients = mysqli_query($conn, "SELECT * FROM patient") or die(mysqli_error($conn));
?>
<div class="container">
    <h2>Edit Appointment</h2>
    <form action="" method="post">
        <input type="hidden" class="form-control" name="appointmentID" value="<?php echo $appointmentID; ?>">

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo $date; ?>">
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" min="09:00" max="17:00" class="form-control" name="time" id="time" placeholder="Time" value="<?php echo $time; ?>">
        </div>

        <div class="form-group">
            <label for="doctorID">Doctor</label>
            <select class="form-control select2" name="doctorID" id="doctorID">
                <?php
                while ($row = mysqli_fetch_array($doctors)) {
                    $selected = $row['DoctorID'] == $doctorID ? 'selected' : '';
                    echo "<option value='". $row['DoctorID'] ."' $selected>" . $row['DoctorName'] . " " . $row['DoctorSurname'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $description; ?>">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="Cancelled" <?php if ($status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                <option value="Done" <?php if ($status == 'Done') echo 'selected'; ?>>Done</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>


</body>
</html>
<?php
}

// Connection to DB
include('connect-db.php');

// Check if form is submitted
if (isset($_POST['submit'])) {
    $description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['description']));
    $appointmentID = mysqli_real_escape_string($conn, htmlspecialchars($_POST['appointmentID']));
    $time = $_POST['time'];
    $date = $_POST['date'];
    $doctorID = $_POST['doctorID'];
    $status = $_POST['status'];

    // Validate form fields
    if (empty($description) || empty($doctorID) || empty($status) || empty($time) || empty($date)) {
        $error = 'ERROR: Complete all fields!';
        showEditForm($appointmentID, $date, $time, $patientID, $status, $doctorID, $description, $error);
    } else {
        // Update the database
        mysqli_query($conn, "UPDATE appointments SET description='$description', status='$status', date='$date', time='$time', doctorID='$doctorID' WHERE appointmentID='$appointmentID'") or die(mysqli_error($conn));

        // Redirect to the listing page
        header("Location: viewAppointments.php");
    }
} else {
    // Check if 'id' value exists in the URL and is valid
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
        $result = mysqli_query($conn, "SELECT * FROM appointments WHERE appointmentID=$id") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);

        // If the row exists, show the form with the data
        if ($row) {
            $description = mysqli_real_escape_string($conn, htmlspecialchars($row['description']));
            $time = $row['time'];
            $date = $row['date'];
            $doctorID = $row['doctorID'];
            $status = $row['status'];
            showEditForm($id, $date, $time, $status, $doctorID, $description, "");
        } else {
            echo "No results!";
        }
    } else {
        echo 'Error!';
    }
}
?>
