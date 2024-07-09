<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
 function showEditForm($TreatmentName, $Price, $error)
 {
 ?>
 
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
 <html>
 <head>
 <title>Edit Treatment Price</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	
 </head>
 <body>
 <?php 
 // nqs ka gabime shfaqi ato
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
 
 <form action="" method="post">
 <input type="hidden" name="name" value="<?php echo $TreatmentName; ?>"/>
 <h2> <?php echo $TreatmentName; ?> </h2>
 <div class="form-group">
    <label for="title">Price</label>
    <input type="number" min="0" class="form-control" id="price" name = 'price' placeholder="Price" value= "<?php echo $Price; ?>">
  </div>

  <button type="submit" class="btn btn-primary" name = "submit"> Edit Price</button>
</form>

 
 </body>
 </html> 
 <?php
 }



 include('connect-db.php');
 
 if (isset($_POST['submit'])){ 
    $name = mysqli_real_escape_string($conn,htmlspecialchars($_POST['name']));
    $price = $_POST['price'];
    if (empty($price)){
        $error = 'ERROR: Complete all fields!';
        showEditForm($name, $price, $error);
    }
    else{
        mysqli_query($conn,"UPDATE treatment SET Price='$price' WHERE TreatmentName='$name'")
        or die(mysqli_error($conn)); 
        header("Location: viewTreatments.php"); 
    }
 }
 else{
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = mysqli_query($conn,"SELECT * FROM treatment WHERE TreatmentID = '$id'")
        or die(mysqli_error($conn)); 
        $row = mysqli_fetch_array($result);
        if($row){
            $name = $row['TreatmentName'];
            $price = $row['Price'];
            showEditForm($name, $price, '');
        }
        else{
            echo "No results!";
        }
    }
    else
     {
        echo 'Error!';
     }
 }
?>
