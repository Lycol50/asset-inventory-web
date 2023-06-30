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
    
    // check if new password is empty
    if (empty(trim($_POST["new_password"]))) {
        $password_err = "Please enter your new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["new_password"]);
    }
    
    // reset password with code
    if (empty(trim($_POST["password_reset"]))) {
        $password_reset_err = "Please enter your password reset code.";
    } else {
        $password_reset = trim($_POST["password_reset"]);
    }

    // validate credentials
    if (empty($username_err) && empty($password_err) && empty($password_reset_err)) {
        // prepare a select statement
        $sql = "SELECT id, username, password_reset_code FROM users WHERE username = ? AND password_reset_code = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password_reset);
            
            // set parameters
            $param_username = $username;
            $param_password_reset = $password_reset;
            
            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();
                
                
                // check if username exists, if yes then verify password reset code
                if ($stmt->num_rows == 1) {
                    // bind result variables
                    $stmt->bind_result($id, $username);
                    if ($stmt->fetch()) {
                        // password reset code is correct, so change the password in db
                        $sql = "UPDATE users SET pass_word = ? WHERE id = ?";

                        if ($stmt = $mysqli->prepare($sql)) {
                            // bind variables to the prepared statement as parameters
                            $stmt->bind_param("si", $param_password, $param_id);
                            
                            // set parameters
                            $param_password = password_hash($password, PASSWORD_DEFAULT);
                            $param_id = $id;
                            
                            // attempt to execute the prepared statement
                            if ($stmt->execute()) {
                                // password updated successfully. destroy the session, and redirect to login page
                                $password_recovered = "Password recovered successfully. Please login.";
                                header("location: login.php");
                                exit();
                            } else {
                                $password_reset_err = "Invalid Password Reset Code.";
                                exit();
                            }
                        }
                    }
                } else {
                    // display an error message if username doesn't exist
                    $password_reset_err = "No account found with that username and password reset code.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // close statement
        $stmt->close();
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
                <h1>Reset Password</h1>
                <p>Please fill in to reset password.</p>

                <?php
                if (isset($password_recovered)) {
                    echo '<div class="alert alert-success">' . $password_recovered . '</div>';
                }

                if (isset($password_reset_err)) {
                    echo '<div class="alert alert-danger">' . $password_reset_err . '</div>';
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    <label class="form-label">Password Reset Code</label>
                    <input type="password" name="password_reset" class="form-control">
                    <br>
                    <input type="submit" class="btn btn-primary mb-3" value="Reset Password">
                    <button type="button" class="btn btn-link mb-3" onclick="window.location.href='login.php';">Remember Password?</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>