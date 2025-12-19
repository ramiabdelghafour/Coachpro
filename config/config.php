<?php
session_start();

$servername = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'coachpro';

try {
    $conn = new mysqli($servername, $user, $pass, $dbname);
    
    if($conn->connect_error){
        die("Erreur de connexion : " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Require login
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../auth/login.php");
        exit();
    }
}

// Check if user is sportif
function isSportif() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'sportif';
}

// Check if user is coach
function isCoach() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'coach';
}

// Redirect to appropriate dashboard
function redirectToDashboard() {
    if (isSportif()) {
        header("Location: ../sportif/dashboard.php");
    } elseif (isCoach()) {
        header("Location: ../coach/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
    exit();
}

// Escape output (XSS protection)
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>