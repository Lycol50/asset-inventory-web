<?php
include 'config.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

if ($_SESSION['account_type'] !== "admin" && $_SESSION['account_type'] !== "superadmin") {
    header('Location: 404.php');
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


// insert variables for asset
$asset_tag_number = $status = $category = $description = $asset_type = $serial_number = $number_of_units = $asset_cost = $level = $location_unit = $remarks = "";
$filename_array = array();
$asset_tag_number_err = $status_err = $category_err = $description_err = $assettype_err = $serial_number_err = $number_of_units_err = $asset_cost_err = $level_err = $location_unit_err = $remarks_err = $physical_proof_err = "";
$warning = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //check if inputs are empty then trim with test_input function
    if (empty($_POST["asset_tag_number"])) {
        $asset_tag_number_err = "Please enter asset tag number.";
    } else {
        $asset_tag_number = trim(test_input($_POST["asset_tag_number"]));
    }

    if (empty($_POST["status"])) {
        $status_err = "Please select status.";
    } else {
        $status = trim(test_input($_POST["status"]));
    }

    if (empty($_POST["category"])) {
        $category_err = "Please select category.";
    } else {
        $category = trim(test_input($_POST["category"]));
    }

    if (empty($_POST["description"])) {
        $description_err = "Please enter description.";
    } else {
        $description = trim(test_input($_POST["description"]));
    }

    if (empty($_POST["asset_type"])) {
        $assettype_err = "Please enter asset type.";
    } else {
        $asset_type = trim(test_input($_POST["asset_type"]));
    }

    if (empty($_POST["serial_number"])) {
        $serial_number_err = "Please enter serial number.";
    } else {
        $serial_number = trim(test_input($_POST["serial_number"]));
    }

    if (empty($_POST["number_of_units"])) {
        $number_of_units_err = "Please enter number of units.";
    } else {
        $number_of_units = trim(test_input($_POST["number_of_units"]));
    }

    if (empty($_POST["asset_cost"])) {
        $asset_cost_err = "Please enter asset cost.";
    } else {
        $asset_cost = trim(test_input($_POST["asset_cost"]));
    }

    if (empty($_POST["level"])) {
        $level_err = "Please enter level.";
    } else {
        $level = trim(test_input($_POST["level"]));
    }

    if (empty($_POST["location_unit"])) {
        $location_unit_err = "Please enter location.";
    } else {
        $level = trim(test_input($_POST["location_unit"]));
    }

    if (empty($_POST["remarks"])) {
        $remarks_err = "Please enter remarks.";
    } else {
        $remarks = trim(test_input($_POST["remarks"]));
    }

    $remarks = trim(test_input($_POST["remarks"]));

    // check if date placed is empty
    if (empty($_POST["date_placed"])) {
        $date_placed_err = "Please enter date placed.";
    } else {
        $date_placed = trim(test_input($_POST["date_placed"]));
    }
    
    
    /* function generateRandomLetter($length = 1) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $asset_number = "ICNG-" . substr($date_acquired, 0, 4) . "-" . substr(md5($serial_number), 0, 4) . generateRandomLetter(); */
    
    $countfiles = count($_FILES['physical_proof']['name']);
    $totalFileUploaded = 0;
    $filename_array = array();
    $asset_tag_number = $_POST['asset_tag_number'];

    for ($i = 0; $i < $countfiles; $i++) {
        $filename = time() . "_" . $_FILES['physical_proof']['name'][$i];
        $directory = "uploads/" . $asset_tag_number;
    
        // Check if the directory exists, and create it if not
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); // Recursive directory creation
            chmod($directory, 0777);
        }
    
        // Location of the uploaded file
        $location = $directory . "/" . $filename;
        $extension = pathinfo($location, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
    
        // Valid file extensions
        $valid_extensions = array("jpg", "jpeg", "png", "pdf", "docx");
    
        // Check file extension
        if (in_array(strtolower($extension), $valid_extensions)) {
            // Upload file
            if (move_uploaded_file($_FILES['physical_proof']['tmp_name'][$i], $location)) {
                array_push($filename_array, $filename);
                $totalFileUploaded++;
            }
        }
    }
    
    // submit everything to db
    /* if (empty($brand_err) && empty($model_err) && empty($serial_number_err) && empty($status_err) && empty($equipment_name_err) && empty($location_err) && empty($price_value_err) && empty($date_acquired_err) && empty($assettype_err)) {
        // prepare an insert statement
        $sql = "INSERT INTO assets (brand, model, serial_number, status, equipment_name, location_asset, price_value, date_acquired, remarks, asset_tag, asset_type, documents, user_id, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssisssssis", $param_brand, $param_model, $param_serial_number, $param_status, $param_equipment_name, $param_location, $param_price_value, $param_date_acquired, $param_remarks, $param_asset_tag, $param_asset_type, $param_documents, $param_user_id, $param_updated_at);

            // set parameters
            $param_documents = implode(",", $filename_array);
            $param_asset_type = $asset_type;
            $param_brand = $brand;
            $param_model = $model;
            $param_serial_number = $serial_number;
            $param_status = $status;
            $param_equipment_name = $equipment_name;
            $param_location = $location_asset;
            $param_price_value = $price_value;
            $param_date_acquired = $date_acquired;
            $param_remarks = $remarks;
            $param_asset_tag = $asset_number;
            $param_user_id = $_SESSION['id'];
            $param_updated_at = date("Y-m-d H:i:s");

            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo '<script>alert("Asset added successfully\nTotal File uploaded : ' . $totalFileUploaded . '");</script>';

            } else {
                echo '<script>alert("Something went wrong.");</script>';
            }
        }

        // close statement
        $stmt->close();
    } */

    //revised insert
    if (empty($asset_tag_number_err) && empty($status_err) && empty($category_err) && empty($description_err) && empty($assettype_err) && empty($serial_number_err) && empty($number_of_units_err) && empty($asset_cost_err) && empty($level_err) && empty($location_err) && empty($remarks_err) && empty($physical_proof_err) && empty($date_placed_err)) {
        // prepare an insert statement
        $sql = "INSERT INTO assets (asset_tag_number, status, category, description, asset_type, serial_number, number_of_units, asset_cost, level, location_unit, remarks, physical_proof, user_id, date_placed) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssiissssss", $param_asset_tag_number, $param_status, $param_category, $param_description, $param_asset_type, $param_serial_number, $param_number_of_units, $param_asset_cost, $param_level, $param_location, $param_remarks, $param_physical_proof, $param_user_id, $param_date_placed);

            // set parameters
            $param_asset_tag_number = $asset_tag_number;
            $param_status = $status;
            $param_category = $category;
            $param_description = $description;
            $param_asset_type = $asset_type;
            $param_serial_number = $serial_number;
            $param_number_of_units = $number_of_units;
            $param_asset_cost = $asset_cost;
            $param_level = $level;
            $param_location = $location_unit;
            $param_remarks = $remarks;
            $param_physical_proof = implode(",", $filename_array);
            $param_user_id = $_SESSION['id'];
            $param_date_placed = $date_placed;

            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo '<script>alert("Asset added successfully\nTotal File uploaded : ' . $totalFileUploaded . '");</script>';

            } else {
                $warning = "Something went wrong, please try again.";
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
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Add Asset</h1>

                <?php

                if (!empty($warning)) {
                    echo '<div class="alert alert-danger">' . $warning . '</div>';
                }

                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off"
                    enctype='multipart/form-data'>
                    <label for="asset_tag_number">Asset Tag Number</label>
                    <input type="text" name="asset_tag_number" id="asset_tag_number"
                        class="form-control <?php echo (!empty($asset_tag_number_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $asset_tag_number; ?>">
                    <span class="invalid-feedback"><?php echo $asset_tag_number_err; ?></span>
                    <br>
                    <label for="status">Status</label>
                    <select name="status" id="status"
                        class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $status; ?>">
                        <option value="">---Select Status---</option>
                        <option value="Operational">Operational</option>
                        <option value="Idle">Idle</option>
                        <option value="For repair">For Repair</option>
                        <option value="For disposal">For Disposal</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $status_err; ?></span>
                    <br>
                    <label for="category">Category</label>
                    <select name="category" id="category"
                        class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $category; ?>">
                        <option value="">---Select Category---</option>
                        <option value="AUDIO_AND_SOUND_5_YEARS">Audio and Sound - 5 Years</option>
                        <option value="AUDIO_AND_SOUND_3_YEARS">Audio and Sound - 3 Years</option>
                        <option value="VIDEO_TV_AND_CAMERA_5_YEARS">Video TV and Camera - 5 Years</option>
                        <option value="VIDEO_TV_AND_CAMERA_3_YEARS">Video TV and Camera - 3 Years</option>
                        <option value="LIGHTING_THEATRICAL_5_YEARS">Lighting Theatrical - 5 Years</option>
                        <option value="LIGHTING_THEATRICAL_3_YEARS">Lighting Theatrical - 3 Years</option>
                        <option value="AUDIO_VIDEO_ACCESSORY_5_YEARS">Audio-Video Accessories - 5 Years</option>
                        <option value="AUDIO_VIDEO_ACCESSORY_3_YEARS">Audio-Video Accessories - 3 Years</option>
                        <option value="COMPUTER_PERIPHERAL_5_YEARS">Computer Peripheral - 5 Years</option>
                        <option value="COMPUTER_PERIPHERAL_3_YEARS">Computer Peripheral - 3 Years</option>
                        <option value="DESKTOP_5_YEARS">Desktop - 5 Years</option>.
                        <option value="DESKTOP_3_YEARS">Desktop - 3 Years</option>
                        <option value="LAPTOP_5_YEARS">Laptop - 5 Years</option>
                        <option value="LAPTOP_3_YEARS">Laptop - 3 Years</option>
                        <option value="COMMUNICATIONS_5_YEARS">Communications - 5 Year</option>
                        <option value="COMMUNICATIONS_3_YEARS">Communications - 3 Year</option>
                        <option value="OTHER_EQUIP_AND_SUPP_5_YEARS">Other Equipment and Supplies- 5 Year</option>
                        <option value="OTHER_EQUIP_AND_SUPP_3_YEARS">Other Equipment and Supplies- 3 Year</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $category_err; ?></span>
                    <br>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description"
                        class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $description; ?>">
                    <span class="invalid-feedback"><?php echo $description_err; ?></span>
                    <br>
                    <label for="asset_type">Asset Type</label>
                    <input type="text" name="asset_type" id="asset_type"
                        class="form-control <?php echo (!empty($assettype_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $asset_type; ?>">
                    <span class="invalid-feedback"><?php echo $assettype_err; ?></span>
                    <br>
                    <label for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number"
                        class="form-control <?php echo (!empty($serial_number_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $serial_number; ?>">
                    <span class="invalid-feedback"><?php echo $serial_number_err; ?></span>
                    <br>
                    <label for="number_of_units">Number of Units</label>
                    <input type="number" name="number_of_units" id="number_of_units"
                        class="form-control <?php echo (!empty($number_of_units_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $number_of_units; ?>">
                    <span class="invalid-feedback"><?php echo $number_of_units_err; ?></span>
                    <br>
                    <label for="asset_cost">Asset Cost</label>
                    <input type="number" step="0.01" name="asset_cost" id="asset_cost"
                        class="form-control <?php echo (!empty($asset_cost_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $asset_cost; ?>">
                    <span class="invalid-feedback"><?php echo $asset_cost_err; ?></span>
                    <br>
                    <label for="level">Level</label>
                    <input type="text" name="level" id="level"
                        class="form-control <?php echo (!empty($level_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $level; ?>">
                    <span class="invalid-feedback"><?php echo $level_err; ?></span>
                    <br>
                    <label for="location">Location</label>
                    <input type="text" name="location_unit" id="location_unit"
                        class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $location_unit; ?>">
                    <span class="invalid-feedback"><?php echo $location_unit_err; ?></span>
                    <br>
                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" id="remarks"
                        class="form-control <?php echo (!empty($remarks_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $remarks; ?>">
                    <br>
                    <label for="date_placed">Date Placed</label>
                    <input type="date" name="date_placed" id="date_placed"
                        class="form-control <?php echo (!empty($date_placed_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $date_places; ?>">
                    <br>
                    <label for="physical_proof">Physical Proof</label>
                    <input type="file" name="physical_proof[]" id="physical_proof"
                        class="form-control <?php echo (!empty($physical_proof_err)) ? 'is-invalid' : ''; ?>" multiple>
                    <span class="invalid-feedback"><?php echo $physical_proof_err; ?></span>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Submit"
                        onClick="return confirm('Confirm to Register this Asset?')">
                    <a href="dashboard.php" class="btn btn-secondary ml-2"
                        onClick="return confirm('Do you want to go back? All inserted data here before submitting will be gone!')">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>