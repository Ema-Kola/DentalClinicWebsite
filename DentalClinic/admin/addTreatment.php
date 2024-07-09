<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

 function shfaqForm($name, $price, $error)
 {
 ?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
 <html>
 <head>
 <title>Add Treatment</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
  .form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    align-content: center;
    padding: 10px;
  }

  .form-col {
    max-width: 300px; /* Adjust the width as needed */
    width: 100%;
    margin-bottom: 15px;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
     margin-top: 10px;

  }
</style>
 </head>
 <body>
 
 <form action="" method="post">
 
  <div class="form-container">
      <?php 
     if ($error != '')
     {
     echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
     }
     ?> 
  <div class="form-col">
    <div class="form-group">
      <label for="name">Treatment Name</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Treatment Name" value="<?php echo $name; ?>">
    </div>
  </div>
  <div class="form-col">
    <div class="form-group">
      <label for="price">Treatment Price in ALL</label>
      <input type="number" min="0" name="price" class="form-control" id="price" placeholder="Treatment Price" value="<?php echo $price; ?>">
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name = "submit">Add New Treatment</button>
</div>
</form>

 <?php 
 }

include('connect-db.php');
 
 if (isset($_POST['submit']))
 { 
 $name = mysqli_real_escape_string($conn,htmlspecialchars($_POST['name']));
 $price = $_POST['price'];
 
if ($name == '' || $price == '')
 {
    $error = 'Complete all fields!';
    shfaqForm($name, $price, $error);
 }
 else
 {
    $result = mysqli_query($conn, "Select * from treatment WHERE TreatmentName='$name'")
    or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    if($row){
        $error = 'Treatment already exists!';
        shfaqForm($name, $price, $error);
    }
    else{
         mysqli_query($conn,"INSERT treatment SET TreatmentName='$name', Price='$price'")
         or die(mysqli_error($conn)); 
         header("Location: viewTreatments.php"); 
    }

 
 }
 }
 else
 {
 shfaqForm('','','',);
 }
?>
