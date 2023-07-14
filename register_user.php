<?php
include 'config.php';

session_start();
if ($_SESSION['account_type'] !== "superadmin") {
    echo '<script type="text/javascript">alert("You do not have permission to access this page.")</script>';
    sleep(2);
    header('Location: dashboard.php');
}

$firstname = $lastname = $username = $password = $confirm_password = "";

$firstname_err = $lastname_err = $username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter your first name.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }
    
    // validate lastname
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter your last name.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }
    
    // validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // set parameters
            $param_username = trim($_POST["username"]);
            
            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // close statement
        $stmt->close();
    }
    
    // validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // check input errors before inserting in database
    if (empty($firstname_err) && empty($lastname_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // prepare an insert statement
        $sql = "INSERT INTO users (firstname, lastname, username, pass_word, password_reset_code, account_type) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss", $param_firstname, $param_lastname, $param_username, $param_password, $param_password_reset_code, $param_account_type);
            
            // set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // creates a password hash
            $param_password_reset_code = substr(md5($username), 0, 13);
            $param_account_type = $_POST["account_type"];
            
            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                // redirect to login page
                echo "<script>alert('User $firstname $lastname has been registered.')</script>";
                header("register_user.php");
            } else {
                echo "Something went wrong. Please try again later.";
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
                <h1>Register to the system</h1>
                <p>Please fill to register user.</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control">
                    <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control">
                    <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span><br>
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span><br>
                    <label class="form-label">User Type</label>
                    <select name="account_type" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select><br>
                    <input type="submit" class="btn btn-primary mb-3" value="Register">
                    <input type="reset" class="btn btn-secondary mb-3" value="Reset">
                    <a href="dashboard.php" class="btn btn-secondary mb-3">Go to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>