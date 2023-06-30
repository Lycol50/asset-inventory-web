<?php
include 'config.php';
session_start();

if (isset($_SESSION['loggedin'])) {
    header("location: dashboard.php");
    exit;
}

// processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // check if password is empty
    if (empty(trim($_POST["pass_word"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["pass_word"]);
    }
    
    // validate credentials
    if (empty($username_err) && empty($password_err)) {
        // prepare a select statement
        $sql = "SELECT id, username, firstname, lastname, pass_word FROM users WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // set parameters
            $param_username = $username;
            
            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();
                
                // check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // bind result variables
                    $stmt->bind_result($id, $username, $firstname, $lastname, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // password is correct, so start a new session
                            session_start();

                            $sql2 = "SELECT account_type FROM users WHERE username = ?";
                            
                            // store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["firstname"] = $firstname;
                            $_SESSION["lastname"] = $lastname;
                            $_SESSION["account"] = $account_type;
                            
                            // redirect user to welcome page
                            header("location: dashboard.php");
                        } else {
                            // display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // close statement
            mysqli->close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Asset Management System</title>
    <link rel="stylesheet" href="style.css?v=1.1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="white.png">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Login to the system</h1>
                <p>Please fill in your code to login.</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    <label class="form-label">Password</label>
                    <input type="password" name="pass_word" class="form-control">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span><br>
                    <input type="submit" class="btn btn-primary mb-3" value="Login">
                    <button type="button" class="btn btn-link mb-3" onclick="">Forgot Password?</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>