<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <h1>Dental Clinic</h1>
        <div class="button-container">
    <a href="index.php" class="btn btn-dark">Dashboard</a>
  </div>
        <?php
            // Connect to the database
            include("connect-db.php");

            // Fetch data from generalData table
            $result = mysqli_query($conn, "SELECT phone, email, aboutUs FROM generalData LIMIT 1");
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }

            // Fetch the single row of data
            $data = mysqli_fetch_assoc($result);
        ?>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($data['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
        <h2>About Us</h2>
        <p><?php echo htmlspecialchars($data['aboutUs']); ?></p>

        <!-- Button to navigate to the changeData.php page -->
        <a href="editGeneralData.php" class="btn btn-primary">Change General Data</a>
    </div>
</body>
</html>