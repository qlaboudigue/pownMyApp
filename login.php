<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Veuillez indiquer un identifiant";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // $token = filter_input(INPUT_POST, 'token');

    /**
     * // Check if CSRF is given
     * if (!$token || $token !== $_SESSION['token']) {
     *  $login_err = "Token does not match";
     *   exit;
     * } else {
     *   // Go on with request
     * }
     */
    
    

    $sql = "SELECT id, username FROM users WHERE username = '".$username."' AND password = '".$password."'";
    
    $result = mysqli_query($link, $sql);

    if($result != false) {

        if (mysqli_num_rows($result) > 0) {

            // prepare to stock username results
            $usernames = array();
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
            
                    array_push($usernames, $row["username"]);
                
            }
            // Store result
            $id = $row["id"];
            $username = $row["username"];
        
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["usernames"] = $usernames;                            
                            
            // Redirect user to welcome page
            header("location: welcome.php");
        
        } else {
            $login_err = "Identifiant ou mot de passe invalide";
        }
    } else {
        $login_err = "Requête non valide";
    }

} else {

    // Create CSRF token
    // $_SESSION['token'] = md5(uniqid(mt_rand(), true));

}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Se connecter</h2>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="form-group">
                <label>Identifiant</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <!--
            <div>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            </div>
            */
             -->
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>

    
</body>
</html>