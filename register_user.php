<?php
include 'config.php';

session_start();
if ($_SESSION['account_type'] !== "superadmin") {
    header('Location: 404.php');
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$firstname = $lastname = $username = $password = $confirm_password = "";

$firstname_err = $lastname_err = $username_err = $password_err = $confirm_password_err = $account_type_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter your first name.";
    } else {
        $firstname = trim(test_input($_POST["firstname"]));
    }
    
    // validate lastname
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter your last name.";
    } else {
        $lastname = trim(test_input($_POST["lastname"]));
    }

    //validate account type
    if (empty(trim($_POST["account_type"]))) {
        $account_type_err = "Please select an account type.";
    } else {
        $account_type = trim(test_input($_POST["account_type"]));
    }

    // validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim(test_input($_POST["email"]));
    }
    
    // validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";
        
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
                    $username = trim(test_input($_POST["username"]));
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
    if (empty($firstname_err) && empty($lastname_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($account_type_err) && empty($email_err)) {
        
        // prepare an insert statement
        $sql = "INSERT INTO users (firstname, lastname, username, pass_word, account_type, email) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss", $param_firstname, $param_lastname, $param_username, $param_password, $param_account_type, $param_email);
            
            // set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // creates a password hash
            $param_account_type = $_POST["account_type"];

                
                // attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // insert password reset code into password_reset table
                    $sql2 = "INSERT INTO password_reset (password_reset_code, user_id) VALUES (?, ?)";
                    if ($stmt2 = $mysqli->prepare($sql2)) {
                        // bind variables to the prepared statement as parameters
                        $stmt2->bind_param("si", $param_password_reset_code, $param_user_id);
                        
                        // set parameters
                        $param_password_reset_code = substr(md5($username), 0, 13);
                        $param_user_id = $mysqli->insert_id;
                        
                        // attempt to execute the prepared statement
                        if ($stmt2->execute()) {
                            // do nothing
                        } else {
                            echo "<script>alert('Something went wrong. Please try again later.')</script>";
                        }
                    } 
                    // redirect to login page
                    echo "<script>alert('User $firstname $lastname has been registered.')</script>";
                    header("register_user.php");
                } else {
                    echo "<script>alert('Something went wrong. Please try again later.')</script>";
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
    <title>CCF Alabang Inventory System (Live Prod)</title>
    <link rel="stylesheet" href="style.css?v=1.1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="https://events.ccf.org.ph/assets/app/ccf-logos/ccf-logo-full-white-logo-size.png">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Register to the system</h1>
                <p>Please fill information.</p>

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
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" data-toggle="tooltip" data-placement="right" title="Password must have 6 Characters">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    <label class="form-label">User Type</label>
                    <select name="account_type" class="form-select">
                        <option value="">---Select---</option>
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