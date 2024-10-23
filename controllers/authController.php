<?php
// controllers/authController.php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if none is active
    
}


require_once '../models/user.php';

class AuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function register($username, $password)
    {
        return $this->userModel->register($username, $password);
    }

    public function login($username, $password)
    {
        return $this->userModel->login($username, $password);
    }

    public function logout()
    {

        session_unset();
        session_destroy();

        header('Location: ../views/login.php');
        exit();
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $authController = new AuthController($connection);
    $authController->logout();
    exit();
}



?>