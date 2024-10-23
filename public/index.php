<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo 'User is logged in';
    header('Location: ../views/tasks.php'); 
} else {
    echo 'Redirecting to login...';
    header('Location: ../views/login.php'); 
}
exit();

?>
