<?php
//include config
require_once('config.php');
session_start();

//check if already logged in
if (!$user->is_logged_in()) {
    header('Location: login.php');
}

// check if user has permission to view only admin or superadmin can view this page
if ($_SESSION['account_type'] !== "admin" || $_SESSION['account_type'] !== "superadmin") {
    header('Location: assets.php');
}

// delete the the asset id from database using the url parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM assets WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('The Asset has been sucessfully removed.')</script>";
            header('Location: assets.php');
        } else {
            echo "<script>alert('Something went wrong. Please try again!')</script>";
            header('Location: assets.php');
        }
    }
    $stmt->close();
}

