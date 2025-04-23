<?php
session_start();
include('../SQL/dbconnection.php');

//get employee id
$employee_id=$_GET['employee_id'] ?? '' ;

if (!$employee_id) {
    die("Error: case number is missing.");
}

//initialize arrays
$tests = [
    'employee_cbc' => null,
    'employee_urine' => null,
    'employee_hiv' => null
];

//prepare executing employee query
$Stmt = $con->prepare("SELECT * FROM employees WHERE employee_id = ? ");
$Stmt ->bind_param("i", $employee_id);
$Stmt->execute();
$result = $Stmt->get_result();
$employees = $result->fetch_assoc();

//check if employee exist
if (!$employees) {
    die ("No records found for employee ID: " . htmlspecialchars($employee_id));
}

//fetch all test results
try {
    //cbc
    $employee_cbcStmt = $con->prepare ("SELECT * FROM employee_cbc WHERE employee_id = ? ORDER BY test_date DESC LIMIT 1");
    $employee_cbcStmt->bind_param("i", $employee_id);
    if ($employee_cbcStmt->execute()) {
        $tests['employee_cbc'] = $employee_cbcStmt->get_result()->fetch_assoc();
    }

    //urine
    $employee_urineStmt = $con->prepare ("SELECT * FROM employee_urine WHERE employee_id = ? ORDER BY test_date DESC LIMIT 1");
    $employee_urineStmt->bind_param("i", $employee_id);
    if ($employee_urineStmt->execute()) {
        $tests['employee_urine'] = $employee_urineStmt->get_result()->fetch_assoc();
    }

    //hiv
    $employee_hivStmt = $con->prepare("SELECT * FROM employee_hiv_test WHERE employee_id = ? ORDER BY test_date DESC LIMIT 1");
    $employee_hivStmt->bind_param("i", $employee_id);
    if ($employee_hivStmt->execute()) {
        $tests['employee_hiv'] = $employee_hivStmt->get_result()->fetch_assoc();
    }

} catch (Exception $e)
{
    //handle db errors
    error_log("Database error: " . $e->getMessage());
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style> 
      .logo {
      width:100px;
      height:auto;
}

/*personal details table*/
        .employees-info-table {
         width:100%;
         border-collapse: collapse;
         margin-bottom: 15px;
         }

        .employees-info-table th {
            text-align: center;
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .employees-info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        .employees-info-table td:first-child {
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


<body>
    <!--header-->
    <div class="certificate">
        <div class="header">
            <img src="pics/logo.png" alt="hospital logo" class="logo">
            <h1>SJDM Muzon Medical Center</h1>
            <h2>Medical Result</h2>
</div>

<!--personal details-->
<table class="employees-info-table">
    <tr>
        <th colspan="2">Employees Information</th>
</tr>

<tr>
    <td>Full Name</td>
    <td><?php echo htmlspecialchars($employees['first_name'] . ' ' . $employees['middle_name'] . ' ' . $employees['last_name']); ?></td>
</tr>

<tr>
    <td>Employee ID</td>
    <td><?php echo htmlspecialchars($employees['employee_id']); ?></td>
</tr>

<tr>
    <td>Role</td>
    <td><?php echo htmlspecialchars($employees['role']); ?></td>
</tr>
</table>

<!--header for results-->
<table>
    <tr>
        <th>Test Type</th>
        <th>Test Date</th>
        <th>Results</th>
</tr>

<!--cbc-->
<?php if (!empty($tests['employee_cbc'])): ?>
    <tr>
        <td>CBC</td>
        <td><?php echo htmlspecialchars($tests['employee_cbc']['test_date'] ?? 'N/A'); ?></td>
        <td> RBC: <?php echo htmlspecialchars($tests['employee_cbc']['red_blood_cells'] ?? 'N/A'); ?> <br>
                WBC: <?php echo htmlspecialchars($tests['employee_cbc']['white_blood_cells'] ?? 'N/A'); ?> <br>
                HGB: <?php echo htmlspecialchars($tests['employee_cbc']['hemoglobin'] ?? 'N/A'); ?> <br>
                PLT: <?php echo htmlspecialchars($tests['employee_cbc']['platelets'] ?? 'N/A'); ?> </td>
</tr>
<?php endif; ?>

<!--urine-->
<?php if (!empty($tests['employee_urine'])): ?>
        <tr>
            <td>Urinalysis</td>
            <td><?php echo htmlspecialchars($tests['employee_urine']['test_date'] ?? 'N/A'); ?></td>
            <td>
                pH: <?php echo htmlspecialchars($tests['employee_urine']['ph_level'] ?? 'N/A'); ?><br>
                Protein: <?php echo htmlspecialchars($tests['employee_urine']['protein'] ?? 'N/A'); ?><br>
                Glucose: <?php echo htmlspecialchars($tests['employee_urine']['glucose'] ?? 'N/A'); ?><br>
                Ketones: <?php echo htmlspecialchars($tests['employee_urine']['ketones'] ?? 'N/A'); ?>
            </td>
     </tr>
     <?php endif; ?>

<!--hiv-->
<?php if (!empty($tests['employee_hiv'])): ?>
        <tr>
            <td>HIV Test</td>
            <td><?php echo htmlspecialchars($tests['employee_hiv']['test_date'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($tests['employee_hiv']['employee_hiv_result'] ?? 'N/A'); ?></td>
        </tr>
        <?php endif; ?> </table>

<!--assessement-->
<div class="assessment">
    <strong>Assessment</strong>
    <?php 
    $healthy = true;
    if (!empty($tests['employee_hiv']) && strtolower($tests['employee_hiv']['employee_hiv_result'] ?? '') !== 'negative') 
    {
        $healthy = false;
    }

    if (!empty($tests['employee_cbc'])) {
    $hemoglobin = $tests['employee_cbc']['hemoglobin'] ?? 0;
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
    <button onclick="window.location.href='employee_records.php?employee_id=<?php echo $employee_id; ?>';" class="cancel-btn">Cancel</button></div>  
</body>
</html>


 
</body>
</html>