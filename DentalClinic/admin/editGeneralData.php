<?php

include('connect-db.php');

// Function to display the edit form
function showEditForm($id, $phoneNumber, $email, $aboutUs, $error)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title>Edit General Data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #add8e6;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit General Data</h2>
    <?php 
    // Display errors if any
    if ($error != '') {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
    ?> 
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="number" name="phoneNumber" class="form-control" id="phoneNumber" placeholder="Phone Number" value="<?php echo $phoneNumber; ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $email; ?>">
        </div>

        <div class="form-group">
            <label for="aboutUs">About Us</label>
            <textarea name="aboutUs" class="form-control" id="aboutUs" placeholder="About Us" rows="4"><?php echo $aboutUs; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>
</body>
</html> 
<?php
}

// Check if form is submitted
if (isset($_POST['submit'])) { 
    // Check if 'id' is numeric
    if (is_numeric($_POST['id'])) {
        // Get form values and validate
        $id = $_POST['id'];
        $phoneNumber = $_POST['phoneNumber'];
        $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
        $aboutUs = mysqli_real_escape_string($conn, htmlspecialchars($_POST['aboutUs']));

        // Update data in database
        mysqli_query($conn, "UPDATE generaldata SET phone='$phoneNumber', email='$email', aboutUs='$aboutUs' WHERE id='$id'")
            or die(mysqli_error($conn));

        // Redirect to index page after update
        header("Location: viewGeneralData.php"); 
    } else {
        // If 'id' is not valid, show error
        echo 'Error!';
    }
} else {
    // Fetch data from database based on 'id'
    $result = mysqli_query($conn, "SELECT * FROM generaldata LIMIT 1")
        or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    // Check if 'id' matches with any row in database
    if ($row) {
        // Get data from database
        $phoneNumber = $row['phone'];
        $email = $row['email'];
        $aboutUs = $row['aboutUs'];
        // Show form
        showEditForm($row['id'], $phoneNumber, $email, $aboutUs, '');
    } else {
        // If no match found, display message
        echo "No general data found!";
    }
}
?>