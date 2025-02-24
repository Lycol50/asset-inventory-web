<?php
//include config
require_once('config.php');
session_start();

//check if already logged in
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

// check if user has permission to view only admin or superadmin can view this page
if ($_SESSION['account_type'] !== "admin" && $_SESSION['account_type'] !== "superadmin") {
    header('Location: 404.php');
    exit;
}

// delete the the asset id from database using the url parameter
if (isset($_GET['asset_tag'])) {
    $id = $_GET['asset_tag'];
    $sql = "DELETE FROM assets WHERE asset_tag_number = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            header('Location: assets.php');
            echo "<script>alert('The Asset has been sucessfully removed.')</script>";
        } else {
            header('Location: assets.php');
            echo "<script>alert('Something went wrong. Please try again!')</script>";
        }
    }
    $stmt->close();
}

