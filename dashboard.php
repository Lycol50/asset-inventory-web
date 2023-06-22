<?php
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

