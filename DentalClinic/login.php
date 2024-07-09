<?php
session_start();
require_once('admin/connect-db.php');

// Check if the user is already logged in
if (isset($_SESSION["username"])) {
    header("Location: admin/index.php");
    exit();
}

    $username = $_POST['username'];
    $password = $_POST['password'];
    $salt = "3P0K4!@##@!_7!r4n3";

    #Concatenate password with salt.
    $password .= $salt;

    #Encrypt password + hash
    $password = md5($password);

    $ret = mysqli_query($conn, "SELECT * FROM users WHERE Username = '$username' AND Password = '$password'")
    or die(mysqli_error()); 
    $result= mysqli_num_rows($ret);

    if ($result == 1) {
        
        $_SESSION["username"] = $username;
        $_SESSION["logout_token"] = bin2hex(random_bytes(32));
        header("Location: ./admin/index.php");
        exit();

    } else {
        echo "Invalid username or password. Please try again."; 
    }

    $conn->close();


?>
