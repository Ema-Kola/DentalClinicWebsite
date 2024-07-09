<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>
<?php
 function shfaqDoktorin($doctorName, $doctorSurname,$doctorBirthday, $doctorPhone, $doctorRole, $doctorStatus, $error)
 {
 ?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
 <html>
 <head>
 <title>Add Doctor</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 </head>
 <body>
 <div class="container">
 <?php
 if ($error != '') {
     echo '<div class="error">'.$error.'</div>';
 }
 ?>
 <form action="" method="post">
 <h2>Add Doctor Information</h2>
    <div class="form-group">
      <label for="doctorName">Name</label>
      <input type="text" class="form-control custom-color" name="doctorName" id="doctorName" placeholder="Doctor Name" value="<?php echo $doctorName; ?>" >
    </div>
    <div class="form-group">
      <label for="doctorSurname">Surname</label>
      <input type="text" class="form-control custom-color" name="doctorSurname" id="doctorSurname" placeholder="Doctor Surname" value="<?php echo $doctorSurname; ?>">
    </div>
    <div class="form-group">
      <label for="doctorDate">Birthdate</label>
      <input type="date" class="form-control custom-color" name="doctorBirthday" id="doctorBirthday" placeholder="Birthdate" value="<?php echo $doctorBirthday; ?>">
    </div>
    <div class="form-group">
      <label for="doctorPhone">Phone Number</label>
      <input type="text" class="form-control custom-color" name="doctorPhone" id="doctorPhone" placeholder="Phone Number" value="<?php echo $doctorPhone; ?>">
    </div>
    <div class="form-group">
      <label for="doctorRole">Role</label>
      <input type="text" class="form-control custom-color" name="doctorRole" id="doctorRole" placeholder="Doctor Role" value="<?php echo $doctorRole; ?>">
    </div>
    <div class="form-group">
      <label for="doctorStatus">Status</label>
      <select name="doctorStatus" class="form-control custom-color" id="doctorStatus">
        <option value="Active" <?php if ($doctorStatus == 'Active') echo 'selected'; ?>>Active</option>
        <option value="Inactive" <?php if ($doctorStatus == 'Inactive') echo 'selected'; ?>>Inactive</option>
        <option value="On Leave" <?php if ($doctorStatus == 'On Leave') echo 'selected'; ?>>On Leave</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
 </form>
 </div>
 </body>
 </html>
 <?php
 }

 
 include('connect-db.php');
 if (isset($_POST['submit'])) {
     $doctorName = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorName']));
     $doctorSurname = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorSurname']));
     $doctorBirthday= mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorBirthday']));
     $doctorPhone = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorPhone']));
     $doctorRole = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorRole']));
     $doctorStatus = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorStatus']));
     
     if ($doctorName == '' || $doctorSurname == '' || empty($doctorPhone) || $doctorRole == '') {
         $error = 'Complete all fields!';
         shfaqDoktorin($doctorName, $doctorSurname,$doctorBirthday, $doctorPhone, $doctorRole, $doctorStatus, $error);
     } else {
         mysqli_query($conn, "INSERT INTO doctors SET DoctorName='$doctorName', DoctorSurname='$doctorSurname', DoctorBirthday = '$doctorBirthday',DoctorPhone='$doctorPhone', DoctorRole='$doctorRole', DoctorStatus='$doctorStatus'")
         or die(mysqli_error($conn));


         header("Location: viewDoctor.php");
     }
 } else {
     shfaqDoktorin('', '', '', '', '', '','');
 }
?>
