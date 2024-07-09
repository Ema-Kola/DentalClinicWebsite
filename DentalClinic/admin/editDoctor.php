<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include('connect-db.php');

function shfaqEditForm($doctorId, $doctorPhone, $doctorRole, $doctorStatus, $error = '')
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Record</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
   
    <div class="container">
        <h2>Edit Doctor</h2>
        <form action="" method="post" class="form-container">
            <input type="hidden" name="doctorId" value="<?php echo $doctorId; ?>"/>
            <div class="form-group">
                <label for="doctorPhone">Phone Number</label>
                <input type="text" class="form-control" id="doctorPhone" name="doctorPhone" value="<?php echo $doctorPhone; ?>"/>
            </div>
            <div class="form-group">
                <label for="doctorRole">Role</label>
                <input type="text" class="form-control" id="doctorRole" name="doctorRole" value="<?php echo $doctorRole; ?>"/>
            </div>
            <div class="form-group">
                <label for="doctorStatus">Status</label>
                <select class="form-control select2" id="doctorStatus" name="doctorStatus">
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

if (isset($_POST['submit'])) {
    $doctorId = $_POST['doctorId'];

    $doctorPhone = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorPhone']));
    $doctorRole = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorRole']));
    $doctorStatus = mysqli_real_escape_string($conn, htmlspecialchars($_POST['doctorStatus']));

    if (empty($doctorPhone) || empty($doctorRole)) {
        $error = 'ERROR: Please fill in all required fields!';
        shfaqEditForm($doctorId, $doctorPhone, $doctorRole, $doctorStatus, $error);
    } else {
        $query = "UPDATE doctors SET DoctorPhone='$doctorPhone', DoctorRole='$doctorRole', DoctorStatus='$doctorStatus' WHERE DoctorID=$doctorId";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
        header("Location: viewDoctor.php");
    }
} else {
    $doctorId = $_GET['id'] ?? '';
    if (!empty($doctorId)) {
        $result = mysqli_query($conn, "SELECT * FROM doctors WHERE DoctorID ='$doctorId'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);

        if ($row) {
            shfaqEditForm($row['DoctorID'], $row['DoctorPhone'], $row['DoctorRole'], $row['DoctorStatus']);
        } else {
            echo "No results!";
        }
    } else {
        echo 'Error!';
    }
}
?>
