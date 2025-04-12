<?php
session_start();
include('SQL/dbconnection.php');

// Get case_no from URL
$id = $_GET['id'] ?? '';

if (!$id) {
    die("Error: Case number is missing.");
}

// Fetch patient records
$query = "
    SELECT * FROM patient p
    WHERE p.id = '$id'
";

// Execute Query
$result = mysqli_query($con, $query);

// Check for SQL errors
if (!$result) {
    die("SQL Error: " . mysqli_error($con));
}

// Fetch patient record
$patient = mysqli_fetch_assoc($result);

// Check if the record exists
if (!$patient) {
    die("No records found for ID: " . htmlspecialchars($id));
}
?>
<?php
$gender = $patient['gender']; // Assuming 'Gender' stores 'Male' or 'Female'
$pronoun = ($gender == 'Male') ? 'him' : 'her';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=" ">
    <title>Medical Certificate</title>
    <style>

body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            height: auto; 
            min-height: 100vh;
            padding-top: 5px;
            background-color: #f5f5f5;
        }

        .certificate {
            background-color: white;
            width: auto;
            max-width: 800px;
            padding: 50px;
            text-align: center;
            font-family: "Merriweather", serif;
            font-size: 16px;
            position: relative;
           
        }

        .hname {
            font-family: "Merriweather", serif;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .title {
            font-family: 'Roboto', sans-serif;
            font-size: 25px;
            font-weight: bold;
            color: #1C673B;
            margin: 15px 0;
        }

        .content {
            font-family: "Merriweather", serif;
            font-size: 16px;
            text-align: justify;
            line-height: 1.75;
            margin: 20px 0;
        }

        .signature {
            margin-top: 70px;
            text-align: right;
           
        }

        .by {
            margin-top: -15px;
            text-align: right;
            font-family: "Merriweather", serif;
            font-size: 16px;
        }

        .button-ngani {
            text-align: center;
            margin-top: 20px;
        }

        .print-btn, .cancel-btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        .print-btn, .cancel-btn {
            padding: 8px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-btn {
            background-color: #4CAF50;
            color: white;
        }
        .cancel-btn {
            background-color: #f44336;
            color: white;
        }

        @media print {
            .button-ngani,
            .print-btn, 
            .cancel-btn {
                display: none;
            }
        }
    </style>

</head>
<body>

<div class="certificate-border">
    <div class="certificate">
<!-- Logo at the top -->
<img src="pics/logo.jpg" alt="Hospital Logo" style="width: 100px; height: auto; display: block; margin: 0 auto 10px;">
<p class="hname">SJDM Muzon Medical Center</p>
<br><br>
    <h2 class="title">Medical Certificate</h2>

<div class="content">
<div class="content">
    <p><br><br>This is to certify that <strong><?php echo htmlspecialchars($patient['fname'] . " " . $patient['mname'] . " " . $patient['lname']); ?></strong>, 
    <?php echo $gender == 'Male' ? 'male' : 'female'; ?>, <?php echo $patient['age'] ?? 'N/A'; ?> years old,
    residing at <strong><?php echo htmlspecialchars($patient['address']); ?></strong>,
    has undergone a complete medical examination at our facility on <strong><?php echo date('F j, Y'); ?></strong>.</p>
    
    <p>Medical findings indicate the following condition(s):</p>
    <ul>
        <li><strong><?php echo htmlspecialchars($patient['diagnosis']); ?></strong></li>
    </ul>
    
    <p>The patient has been given appropriate medical treatment.</p>
    
    
   <br><p>This certification is valid for one month from the date of issue unless otherwise specified.</p>
</div>

<div class="signature">
        <p>____________________________________</p>
</div>

<div class="by">
        <p>Certified by(Signature over printed name)</p>
        <p>SJDM Muzon Medical Center</p>
</div>
</div>

<!-- Print and Cancel Buttons -->
<div class="button-ngani">
    <button onclick="window.print()" class="print-btn">Print Certificate</button>
    <button onclick="window.location.href='patient_records.php';" class="cancel-btn">Cancel</button>
    </div>

</body>
</html>
