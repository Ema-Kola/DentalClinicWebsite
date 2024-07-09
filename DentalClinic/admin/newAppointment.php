<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}


function shfaqForm($date, $time, $patientID, $status, $doctorID, $description, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
 <title>Add Appointment</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
 <h2 class="mt-4 mb-4">Schedule new appointment</h2>
 <?php
 // shfaq nqs ka gabime
 if ($error != '') {
   echo '<div class="alert alert-danger">'.$error.'</div>';
 }
 include('connect-db.php');
 $doctors = mysqli_query($conn,"SELECT * FROM doctors") or die(mysqli_error($conn));
 $patients = mysqli_query($conn,"SELECT * FROM patient") or die(mysqli_error($conn));
 ?>
 <form action="" method="post">
   <div class="form-group">
     <label for="date">Date</label>
     <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo $date; ?>" required>
   </div>
   <div class="form-group">
     <label for="time">Time</label>
     <input type="time" min="09:00" max="17:00" class="form-control" name="time" id="time" placeholder="Time" value="<?php echo $time; ?>" required>
   </div>
   <div class="form-group">
     <label for="doctorID">Doctor</label>
     <select class="form-control select2" name="doctorID" id="doctorID" required>
       <?php
       while ($row = mysqli_fetch_array($doctors)) {
         echo "<option value='". $row['DoctorID'] . "'>" .$row['DoctorName']. " " .$row['DoctorSurname']."</option>";
       }
       ?>
     </select>
   </div>
   <div class="form-group">
     <label for="patientID">Patient</label>
     <div class="input-group">
       <select class="form-control select2" name="patientID" id="patientID" required>
         <?php
         while ($row = mysqli_fetch_array($patients)) {
           echo "<option value='". $row['PatientID'] . "'>" .$row['PatientName']. " " .$row['PatientSurname']."</option>";
         }
         ?>
       </select>
      
     </div>
   </div>
   <div class="form-group">
     <label for="description">Description</label>
     <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $description; ?>">
   </div>
   <div class="form-group">
     <label for="status">Status</label>
     <select id="status" name="status" class="form-control">
       <option value="Booked" <?php if ($status == 'Booked') echo 'selected'; ?>>Booked</option>
       <option value="Cancelled" <?php if ($status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
       <option value="Done" <?php if ($status == 'Done') echo 'selected'; ?>>Done</option>
     </select>
   </div>
   <button type="submit" class="btn btn-primary" name="submit">Submit</button>
 </form>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
 $(document).ready(function() {
   $('.select2').select2();
 });
</script>
</body>
</html>
<?php
}


include('connect-db.php');
// kontrollo nqs eshte klikuar butoni , dhe fut te dhenat ne databaze nqs ehste klikuar
if (isset($_POST['submit'])) {
 // merr te dhenat dhe sigurohu qe jane te pastra
 $description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['description']));
 $time = $_POST['time'];
 $date = $_POST['date'];
 $patient = $_POST['patientID'];
 $doctor = $_POST['doctorID'];
 $status = $_POST['status'];
 // kontrollo qe jane mbushur
 if ($description == '' || empty($patient) || empty($doctor) || empty($status) || empty($time) || empty($date)) {
   // nqs nuk jane mbushur jep mesazh
   $error = 'Complete all fields!';
   // nqs  ka ndodh gabim, pra nje fushe eshte bosh shfaqia fformen perseri qe ta mbushi
   shfaqForm($date, $time, $patient, $status, $doctor, $description, $error);
 } else {
   // check for overlapping appointments
   $check_overlap_query = "SELECT * FROM appointments WHERE doctorID = '$doctor' AND date = '$date' AND time = '$time' AND status='Booked'";
   $check_overlap_result = mysqli_query($conn, $check_overlap_query);


   if (mysqli_num_rows($check_overlap_result) > 0) {
     $error = 'The selected doctor already has an appointment at this time.';
     shfaqForm($date, $time, $patient, $status, $doctor, $description, $error);
   } else {
     // kontrollo nqs pacienti ekziston ne databaze, nese jo, shtoje
     $check_patient_query = "SELECT * FROM patient WHERE PatientID = '$patient'";
     $check_patient_result = mysqli_query($conn, $check_patient_query);

     if (mysqli_num_rows($check_patient_result) == 0) {
       // pacienti nuk ekziston, shtoje ne databaze
       $new_patient_name = mysqli_real_escape_string($conn, $_POST['new_patient']);
       $insert_new_patient_query = "INSERT INTO patient (PatientName) VALUES ('$new_patient_name')";
       mysqli_query($conn, $insert_new_patient_query);
       $patient = mysqli_insert_id($conn);
     }


     // shtoji te dhenat ne databaze ne tabelen "appointments"
     $query = "INSERT INTO appointments (description, date, time, doctorID, status, patientID) VALUES ('$description', '$date', '$time', '$doctor', '$status', '$patient')";
     mysqli_query($conn, $query) or die(mysqli_error($conn));
     // pasi te dhenat shtohen coje tek shfaqia e te dhenave qe ta shohi
     header("Location: viewAppointments.php");
   }
 }
} else {
 // kjo shfaq formen per here te pare bosh
 shfaqForm('', '', '', 'Booked', '', '', '');
}
?>
