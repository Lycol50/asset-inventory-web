<?php
include 'config.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

// insert variables for asset
$brand = $model = $serial_number = $status = $equipment_name = $location = $price_value = $date_acquired = $remarks = "";

$brand_err = $model_err = $serial_number_err = $status_err = $equipment_name_err = $location_err = $price_value_err = $date_acquired_err = $remarks_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check if brand is empty
    if (empty(trim($_POST["brand"]))) {
        $brand_err = "Please enter brand.";
    } else {
        $brand = trim($_POST["brand"]);
    }

    // check if model is empty
    if (empty(trim($_POST["model"]))) {
        $model_err = "Please enter model.";
    } else {
        $model = trim($_POST["model"]);
    }

    // check if serial number is empty
    if (empty(trim($_POST["serial_number"]))) {
        $serial_number_err = "Please enter serial number.";
    } else {
        $serial_number = trim($_POST["serial_number"]);
    }

    // check if status is empty
    if (empty(trim($_POST["status"]))) {
        $status_err = "Please enter status.";
    } else {
        $status = trim($_POST["status"]);
    }

    // check if equipment name is empty
    if (empty(trim($_POST["equipment_name"]))) {
        $equipment_name_err = "Please enter equipment name.";
    } else {
        $equipment_name = trim($_POST["equipment_name"]);
    }

    // check if location is empty
    if (empty(trim($_POST["location"]))) {
        $equipment_name_err = "Please enter location.";
    } else {
        $location = trim($_POST["location"]);
    }

    // check if price value is empty
    if (empty(trim($_POST["price_value"]))) {
        $price_value_err = "Please enter price value.";
    } else {
        $price_value = trim($_POST["price_value"]);
    }

    // check if date acquired is empty
    if (empty(trim($_POST["date_acquired"]))) {
        $date_acquired_err = "Please enter date acquired.";
    } else {
        $date_acquired = trim($_POST["date_acquired"]);
    }
    
    function generateRandomLetter($length = 1) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $asset_number = "ICNG-" . substr($date_acquired, 0, 4) . "-" . substr(md5($serial_number), 0, 4) . generateRandomLetter();

    // submit everything to db
    if (empty($brand_err) && empty($model_err) && empty($serial_number_err) && empty($status_err) && empty($equipment_name_err) && empty($location_err) && empty($price_value_err) && empty($date_acquired_err)) {
        // prepare an insert statement
        $sql = "INSERT INTO assets (brand, model, serial_number, status, equipment_name, location, price_value, date_acquired, remarks, asset_tag) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssssss", $param_brand, $param_model, $param_serial_number, $param_status, $param_equipment_name, $param_location, $param_price_value, $param_date_acquired, $param_remarks, $param_asset_tag);

            // set parameters
            $param_brand = $brand;
            $param_model = $model;
            $param_serial_number = $serial_number;
            $param_status = $status;
            $param_equipment_name = $equipment_name;
            $param_location = $location;
            $param_price_value = $price_value;
            $param_date_acquired = $date_acquired;
            $param_remarks = $remarks;
            $param_asset_tag = $asset_number;

            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                // redirect to dashboard
                echo '<script>alert("Asset added successfully.");</script>';
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // close statement
        $stmt->close();
    }

    // close connection
    $mysqli->close();
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
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Add Asset</h1>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $brand; ?>">
                    <span class="invalid-feedback"><?php echo $brand_err; ?></span>
                    <br>
                    <label for="model">Model</label>
                    <input type="text" name="model" id="model" class="form-control <?php echo (!empty($model_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $model; ?>">
                    <span class="invalid-feedback"><?php echo $model_err; ?></span>
                    <br>
                    <label for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" class="form-control <?php echo (!empty($serial_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $serial_number; ?>">
                    <span class="invalid-feedback"><?php echo $serial_number_err; ?></span>
                    <br>
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
                        <option value="Available">Available</option>
                        <option value="In Use">In Use</option>
                        <option value="For Repair">For Repair</option>
                        <option value="For Disposal">For Disposal</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $status_err; ?></span>
                    <br>
                    <label for="equipment_name">Equipment Name</label>
                    <input type="text" name="equipment_name" id="equipment_name" class="form-control <?php echo (!empty($equipment_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $equipment_name; ?>">
                    <span class="invalid-feedback"><?php echo $equipment_name_err; ?></span>
                    <br>
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $location; ?>">
                    <label for="price_value">Price Value</label>
                    <input type="text" name="price_value" id="price_value" class="form-control <?php echo (!empty($price_value_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price_value; ?>">
                    <span class="invalid-feedback"><?php echo $price_value_err; ?></span>
                    <br>
                    <label for="date_acquired">Date Acquired</label>
                    <input type="date" name="date_acquired" id="date_acquired" class="form-control <?php echo (!empty($date_acquired_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_acquired; ?>">
                    <span class="invalid-feedback"><?php echo $date_acquired_err; ?></span>
                    <br>
                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" id="remarks" class="form-control <?php echo (!empty($remarks_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $remarks; ?>">
                    <span class="invalid-feedback"><?php echo $remarks_err; ?></span>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>