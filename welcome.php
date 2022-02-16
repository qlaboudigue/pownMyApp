<?php

// Init the session
session_start();

// Check if user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hello, <b><?php print_r ($_SESSION["usernames"]); ?></b>. Bienvenue sur notre site.</h1>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Se déconnecter</a>
    </p>
</body>
</html>