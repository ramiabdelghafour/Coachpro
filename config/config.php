<?php
session_start();

$servername = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'coachpro';

try {
    $conn = new mysqli($servername, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}


// Fonctions 

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: ../auth/login.php");
        exit();
    }
}

function isSportif()
{
    return isset($_SESSION['role']) && $_SESSION['role'] == 'sportif';
}

function isCoach()
{
    return isset($_SESSION['role']) && $_SESSION['role'] == 'coach';
}

function redirectToDashboard()
{
    if (isSportif()) {
        header("Location: ../sportif/dashboard.php");
    } elseif (isCoach()) {
        header("Location: ../coach/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
    exit();
}
