<?php
session_start();
include('SQL/dbconnection.php');

//get id 
$id = $_GET['id'] ?? '';

if (!$id) {
    die("Error: case number is missing.");
}

//initialize test arrays
$tests = [
    'cbc' => null,
    'ctscan' => null,
    'urine' => null,
    'hiv' => null,
    'xray' => null,
    'ultrasound' => null
];

//prepare executing patient query
$Stmt = $con->prepare("SELECT * FROM patient WHERE id = ? ");
$Stmt->bind_param("i", $id);
$Stmt->execute();
$result = $Stmt->get_result();
$patient = $result->fetch_assoc();

//check if records exist
if (!$patient) {
die ("No records found for ID: " . htmlspecialchars($id));
}

//fetch all test result
try {
//cbc
$cbcStmt = $con->prepare ("SELECT * FROM cbc_test WHERE patient_id = ? ORDER BY test_date DESC LIMIT 1");
$cbcStmt->bind_param("i", $id);
if ($cbcStmt->execute()) {
$tests['cbc'] = $cbcStmt->get_result()->fetch_assoc();
}

//urine 
$urineStmt = $con->prepare ("SELECT * FROM urine_test WHERE patient_id = ? ORDER BY test_date DESC LIMIT 1");
$urineStmt->bind_param("i", $id);
if ($urineStmt->execute()) {
$tests ['urine']= $urineStmt->get_result()->fetch_assoc();
}

//hiv
$hivStmt = $con->prepare("SELECT * FROM hiv_test WHERE patient_id = ? ORDER BY test_date DESC LIMIT 1");
$hivStmt->bind_param("i", $id);
if ($hivStmt->execute()) {
$tests ['hiv'] = $hivStmt->get_result()->fetch_assoc();
}

//xray
$xrayStmt = $con->prepare("SELECT * FROM xray_test WHERE patient_id = ? ORDER BY test_date DESC LIMIT 1");
$xrayStmt->bind_param("i", $id);
if ($xrayStmt->execute()) {
$tests ['xray'] = $xrayStmt->get_result()->fetch_assoc();
}

//ultrasound
$ultrasoundStmt = $con->prepare("SELECT * FROM ultrasound_test WHERE patient_id = ? ORDER BY test_date DESC LIMIT 1");
$ultrasoundStmt->bind_param("i", $id);
if ($ultrasoundStmt->execute()) {
$tests ['ultrasound'] = $ultrasoundStmt->get_result()->fetch_assoc();
}

//ctscan
$ctScanStmt = $con->prepare("SELECT * FROM ct_scan_test WHERE patient_id = ? ORDER BY test_date DESC LIMIT 1");
$ctScanStmt->bind_param("i", $id);
if ($ctScanStmt->execute()) {
$tests ['ctScan'] = $ctScanStmt->get_result()->fetch_assoc();
}
} catch (Exception $e) 
{
    //handle db errors
    error_log("Database error: " . $e->getMessage());
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style> 
      .logo {
            width: 100px;
            height: auto;
        }
    /* Personal Info Table Styles */
    .patient-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .patient-info-table th {
            text-align: center;
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .patient-info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        .patient-info-table td:first-child {
            width: 30%;
            font-weight: bold;
        }
        
        /* Test Results Table Styles */
        .test-results-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .test-results-table th,
        .test-results-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .test-results-table th {
            background-color: #f2f2f2;
        }

        body {
            font-family: "Merriweather", serif;
            font-size:14px;
        }
        .certificate {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .assessment {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid#1C673B;
        }
        .signature {
            margin-top: 20px;
            text-align: right;
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
    /* Hide the Cancel button */
    .cancel-btn {
        display: none !important;
    }
    
    /* Hide the Print button (optional) */
    .print-btn {
        display: none !important;
    }
}
    </style>
</head>
<body>
    <!--header-->
    <div class="certificate">
        <div class="header">
            <img src="pics/logo.jpg" alt="Hospital logo" class="logo">
            <h1>SJDM Muzon Medical Center</h1>
            <h2>Medical Result</h2>
</div>

<!-- Personal Details Section -->
<table class="patient-info-table">
    <tr>
        <th colspan="2">Patient Information</th>
    </tr>
    <tr>
        <td>Full Name</td>
        <td><?php echo htmlspecialchars($patient['fname'] . ' ' . $patient['mname'] . ' ' . $patient['lname']); ?></td>
    </tr>
    <tr>
        <td>Age</td>
        <td><?php echo htmlspecialchars($patient['age'] ?? 'N/A'); ?></td>
    </tr>
    <tr>
        <td>Gender</td>
        <td><?php echo htmlspecialchars($patient['gender'] ?? 'N/A'); ?></td>
    </tr>
    <tr>
        <td>Birthday</td>
        <td><?php echo htmlspecialchars($patient['bdate'] ?? 'N/A'); ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?php echo htmlspecialchars($patient['address'] ?? 'N/A'); ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo htmlspecialchars($patient['email'] ?? 'N/A'); ?></td>
    </tr></table>

<!--results header-->
<table>
    <tr>
        <th>Test Type</th>
        <th>Test Date</th>
        <th>Results</th>
        </tr>
<!--cbc-->
    <?php if (!empty($tests['cbc'])): ?>
        <tr>
            <td>CBC</td>
            <td><?php echo htmlspecialchars($tests['cbc']['test_date'] ?? 'N/A'); ?></td>
            <td>
                RBC: <?php echo htmlspecialchars($tests['cbc']['red_blood_cells'] ?? 'N/A'); ?> <br>
                WBC: <?php echo htmlspecialchars($tests['cbc']['white_blood_cells'] ?? 'N/A'); ?> <br>
                HGB: <?php echo htmlspecialchars($tests['cbc']['hemoglobin'] ?? 'N/A'); ?> <br>
                PLT: <?php echo htmlspecialchars($tests['cbc']['platelets'] ?? 'N/A'); ?> 
            </td>
    </tr>
    <?php endif; ?>


<!--urine-->
     <?php if (!empty($tests['urine'])): ?>
        <tr>
            <td>Urinalysis</td>
            <td><?php echo htmlspecialchars($tests['urine']['test_date'] ?? 'N/A'); ?></td>
            <td>
                pH: <?php echo htmlspecialchars($tests['urine']['ph_level'] ?? 'N/A'); ?><br>
                Protein: <?php echo htmlspecialchars($tests['urine']['protein'] ?? 'N/A'); ?><br>
                Glucose: <?php echo htmlspecialchars($tests['urine']['glucose'] ?? 'N/A'); ?><br>
                Ketones: <?php echo htmlspecialchars($tests['urine']['ketones'] ?? 'N/A'); ?>
            </td>
     </tr>
     <?php endif; ?>

<!--hiv-->
    <?php if (!empty($tests['hiv'])): ?>
        <tr>
            <td>HIV Test</td>
            <td><?php echo htmlspecialchars($tests['hiv']['test_date'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($tests['hiv']['hiv_result'] ?? 'N/A'); ?></td>
        </tr>
        <?php endif; ?>
<!--xray-->        
        <?php if (!empty($tests['xray'])): ?>
        <tr>
            <td>X-ray</td>
            <td><?php echo htmlspecialchars($tests['xray']['test_date'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($tests['xray']['findings'] ?? 'N/A'); ?></td>
        </tr>
    <?php endif; ?>

<!--ultrasound-->
    <?php if (!empty($tests['ultrasound'])): ?>
        <tr>
            <td>Ultrasound</td>
            <td><?php echo htmlspecialchars($tests['ultrasound']['test_date'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($tests['ultrasound']['findings'] ?? 'N/A'); ?></td>
        </tr>
    <?php endif; ?>

<!--ctscan-->
    <?php if (!empty($tests['ctScan'])): ?>
        <tr>
            <td>CT Scan</td>
            <td><?php echo htmlspecialchars($tests['ctScan']['test_date'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($tests['ctScan']['findings'] ?? 'N/A'); ?></td>
        </tr>
        <?php endif; ?>
    </table>   
<!--assessment-->
<div class = "assessment">
    <strong>Assessment</strong>
    <?php
    $healthy = true;

    if (!empty($tests['hiv']) && strtolower($tests['hiv']['hiv_result'] ?? '') !== 'negative') 
    {
        $healthy = false;
    }

    if (!empty($tests['cbc'])) {
    $hemoglobin = $tests['cbc']['hemoglobin'] ?? 0;
    if ($hemoglobin <12 || $hemoglobin >16) {
        $healthy = false;
    }
}

echo $healthy ? "Good health condition" : "Requires for medical attention";
?>
</div>
<div class="signature">
    <p>_______________________________</p>
    <p>Certified by(Signature over printed name)</p>
    <p>SJDM Muzon Medical Center</p>
</div>

<div class="buttons">
    <button onclick="window.print()" class="print-btn">Print</button>
    <button onclick="window.location.href='patient_records.php?id=<?php echo $id; ?>';" class="cancel-btn">Cancel</button></div>  
</body>
</html>

