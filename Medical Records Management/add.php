<?php
session_start();
include('SQL/dbconnection.php');


$id = $Fname = $Mname = $Lname = $Address =  $age = $bDate = $Gender = $civil_status = $phone_num = $email = $med_history = $admission_type = $bed_number="";
$errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Fname = $_POST['Fname'];
    $Mname = $_POST['Mname'];
    $Lname = $_POST['Lname'];
    $Address= $_POST['Address'];
    $age = $_POST['age'];
    $bDate = $_POST['bDate'];
    $Gender = $_POST['Gender'];
    $civil_status= $_POST['civil_status'];
    $phone_num= $_POST['phone_num'];
    $email= $_POST['email'];
    $med_history= $_POST['med_history'];
    $admission_type= $_POST['admission_type'];
    $bed_number= $_POST['bed_number'];
    

    do {
        if (empty($Fname) || empty($Mname) || empty($Lname) || empty($phone_num)) {
            $errorMessage = "All the fields are required.";
            break;
        }

        // Insert personal info first
        $sql = "INSERT INTO patient (Fname, Mname, Lname, Address, age, bDate, Gender, civil_status, phone_num, email, med_history, admission_type, bed_number) 
                VALUES ('$Fname', '$Mname', '$Lname', '$Address', '$age', '$bDate' , '$Gender','$civil_status','$phone_num','$email','$med_history','$admission_type', '$bed_number')";
        
        if ($con->query($sql) === TRUE) {
            $id = $con->insert_id; // Get last inserted ID
                $successMessage = "Record added successfully!";
                header("Location: index.php");
                exit; 
            } else {
                $errorMessage = "Error: " . $con->error;
                break;
            }
        
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Add New Record</h2>

        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $successMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Fname" value="<?php echo $Fname; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Middle Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Mname" value="<?php echo $Mname; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Lname" value="<?php echo $Lname; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="age" value="<?php echo $age; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Birthday</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bDate" value="<?php echo $bDate; ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Gender" value="<?php echo $Gender; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Civil Status</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="civil_status" value="<?php echo $civil_status; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone_num" value="<?php echo $phone_num; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Medical History</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="med_history" value="<?php echo $med_history; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Admission Type</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="admission_type" value="<?php echo $admission_type; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Bed Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bed_number" value="<?php echo $bed_number; ?>">
                </div>
        </div>
        
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="index.php" class="btn btn-outline-primary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
