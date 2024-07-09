<?php
session_start();
if (isset($_GET['token']) && $_GET['token'] === $_SESSION['logout_token']) {
    session_destroy();
    header("Location: ../index.php");
    exit();
} else {
    // Handle invalid logout token (potential CSRF attack)
    echo "Invalid logout request logout.";
    exit();
}
?>
