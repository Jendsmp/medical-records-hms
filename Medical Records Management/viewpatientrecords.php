<?php
session_start();
include('SQL/dbconnection.php');
 
//fetch patient records
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
$id = $_GET['id'];

$stmt = $con->prepare("SELECT * FROM patient WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch CBC test results for the patient
$cbcStmt = $con->prepare("SELECT * FROM cbc_test WHERE patient_id = ? ORDER BY test_date DESC");
$cbcStmt->bind_param("i", $id);
$cbcStmt->execute();
$cbcResult = $cbcStmt->get_result();

// Fetch CT Scan test results for the patient
$ctScanStmt = $con->prepare("SELECT * FROM ct_scan_test WHERE patient_id = ? ORDER BY test_date DESC");
$ctScanStmt->bind_param("i", $id);
$ctScanStmt->execute();
$ctScanResult = $ctScanStmt->get_result();

//fetch urine
$urineStmt = $con->prepare("SELECT  * FROM urine_test WHERE patient_id = ? ORDER BY test_date DESC");
$urineStmt->bind_param("i", $id);
$urineStmt->execute();
$urineResult = $urineStmt->get_result();

//fetch hiv 
$hivStmt = $con->prepare("SELECT * FROM hiv_test WHERE patient_id = ? ORDER BY test_date DESC");
$hivStmt ->bind_param("i", $id);
$hivStmt->execute();
$hivResult = $hivStmt->get_result();

//xray
$xrayStmt = $con->prepare("SELECT * FROM xray_test WHERE patient_id = ? ORDER BY test_date DESC");
$xrayStmt->bind_param("i", $id);
$xrayStmt->execute();
$xrayResult=$xrayStmt->get_result();

//ultrsound
$ultrasoundStmt = $con->prepare("SELECT * FROM ultrasound_test WHERE patient_id = ? ORDER BY test_date DESC");
$ultrasoundStmt->bind_param("i", $id);
$ultrasoundStmt->execute();
$ultrasoundResult=$ultrasoundStmt->get_result();

//check if patient exist
if ($result->num_rows ==0) {
    die("Patient record not found.");
}
}
else {
    die("invalid request.");
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="icon" href="pics/logo.png" type="image/icon type">
  <link rel="stylesheet" href="CSS/viewpatientrecords.css">
  <title>BSIS 3201 Hospital</title>

  <style>
   
  </style>
</head>

<body>
    <div class="container" id="viewPatientRecords"> <!--wrap entire content-->
        <h2>Patient Records</h2>

        <?php while ($row = $result->fetch_assoc()) {
            ?>
            
<!-- Patient Details (always visible) -->
<div class="patient-details">
      <h3>Patient Information</h3>
      <table class="table table-bordered">
        <tr>
          <th>Name</th>
          <td><?php echo htmlspecialchars($row['fname'] . " " . $row['mname'] . " " . $row['lname']); ?></td>
        </tr>
        <tr>
          <th>ID</th>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
        </tr>
        <tr>
          <th>Address</th>
          <td><?php echo htmlspecialchars($row['address']); ?></td>
        </tr>
        <tr>
          <th>Age</th>
          <td><?php echo htmlspecialchars($row['age']); ?></td>
        </tr>
        <tr>
          <th>Birthday</th>
          <td><?php echo htmlspecialchars($row['bdate']); ?></td>
        </tr>
        <tr>
          <th>Gender</th>
          <td><?php echo htmlspecialchars($row['gender']); ?></td>
        </tr>
        <tr>
          <th>Civil Status</th>
          <td><?php echo htmlspecialchars($row['civil_status']); ?></td>
        </tr>
        <tr>
          <th>Phone number</th>
          <td><?php echo htmlspecialchars($row['phone_num']); ?></td>
        </tr>
        <tr>
          <th>Email</th>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
        </tr>
        <tr>
          <th>Admission Type</th>
          <td><?php echo htmlspecialchars($row['addmission_type'] ? $row['addmission_type'] : 'n/a'); ?></td>
        </tr>
        <tr>
          <th>Bed Number</th>
          <td><?php echo htmlspecialchars($row['bed_number'] ? $row['bed_number'] : 'n'); ?></td>
        </tr>
        <tr>
          <th>Diagnosis</th>
          <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
        </tr>
        <tr>
          <th>Allergies</th>
          <td><?php echo htmlspecialchars($row['allergies']); ?></td>
        </tr>
        <tr>
          <th>Surgeries</th>
          <td><?php echo htmlspecialchars($row['surgeries']); ?></td>
        </tr>
        <th>Date</th>
          <td><?php echo htmlspecialchars($row['date']); ?></td>
        </tr>
        <th>Chronic</th>
          <td><?php echo htmlspecialchars($row['chronic']); ?></td>
        </tr>
        <th>Family</th>
          <td><?php echo htmlspecialchars($row['family']); ?></td>
        </tr>
        <th>Vaccination</th>
          <td><?php echo htmlspecialchars($row['vaccination']); ?></td>
        </tr>
        <th>Information</th>
          <td><?php echo htmlspecialchars($row['information']); ?></td>
        </tr>
      </table>
    </div>
        
    <!-- Test Results Accordion -->
    <div class="accordion" id="testResultsAccordion">
      <!-- CBC Test Results -->
      <div class="accordion-item test-section">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cbcResults">
            CBC Test Results
          </button>
        </h2>
        <div id="cbcResults" class="accordion-collapse collapse" data-bs-parent="#testResultsAccordion">
          <div class="accordion-body">
            <?php if ($cbcResult->num_rows > 0): ?>
              <table class="table table-bordered">
                <tr>
                  <th>Test Date</th>
                  <th>Created At</th>
                  <th>Red Blood Cells</th>
                  <th>White Blood Cells</th>
                  <th>Hemoglobin</th>
                  <th>Platelets</th>
                </tr>
                <?php while ($cbcRow = $cbcResult->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($cbcRow['test_date']); ?></td>
                    <td><?php echo htmlspecialchars($cbcRow['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($cbcRow['red_blood_cells']); ?></td>
                    <td><?php echo htmlspecialchars($cbcRow['white_blood_cells']); ?></td>
                    <td><?php echo htmlspecialchars($cbcRow['hemoglobin']); ?></td>
                    <td><?php echo htmlspecialchars($cbcRow['platelets']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            <?php else: ?>
              <p class="no-results">No CBC test results available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- CT Scan Results -->
      <div class="accordion-item test-section">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ctScanResults">
            CT Scan Results
          </button>
        </h2>
        <div id="ctScanResults" class="accordion-collapse collapse" data-bs-parent="#testResultsAccordion">
          <div class="accordion-body">
            <?php if ($ctScanResult->num_rows > 0): ?>
              <table class="table table-bordered">
                <tr>
                  <th>Test Date</th>
                  <th>Created At</th>
                  <th>CT Scan Image</th>
                  <th>Findings</th>
                </tr>
                <?php while ($ctScanRow = $ctScanResult->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($ctScanRow['test_date']); ?></td>
                    <td><?php echo htmlspecialchars($ctScanRow['created_at']); ?></td>
                    <td>
                      <?php if (!empty($ctScanRow['ct_scan_image'])): ?>
                        <img src="<?php echo htmlspecialchars($ctScanRow['ct_scan_image']); ?>" alt="CT Scan" width="100">
                      <?php else: ?>
                        No Image
                      <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($ctScanRow['findings']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            <?php else: ?>
              <p class="no-results">No CT Scan test results available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Urine Test Results -->
      <div class="accordion-item test-section">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#urineResults">
            Urine Test Results
          </button>
        </h2>
        <div id="urineResults" class="accordion-collapse collapse" data-bs-parent="#testResultsAccordion">
          <div class="accordion-body">
            <?php if ($urineResult->num_rows > 0): ?>
              <table class="table table-bordered">
                <tr>
                  <th>Test Date</th>
                  <th>Created At</th>
                  <th>Ph level</th>
                  <th>Protein</th>
                  <th>Glucose</th>
                  <th>Ketones</th>
                </tr>
                <?php while ($urineRow = $urineResult->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($urineRow['test_date']); ?></td>
                    <td><?php echo htmlspecialchars($urineRow['created_at']);?></td>
                    <td><?php echo htmlspecialchars($urineRow['ph_level']); ?></td>
                    <td><?php echo htmlspecialchars($urineRow['protein']); ?></td>
                    <td><?php echo htmlspecialchars($urineRow['glucose']); ?></td>
                    <td><?php echo htmlspecialchars($urineRow['ketones']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            <?php else: ?>
              <p class="no-results">No Urine test results available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- HIV Test Results -->
      <div class="accordion-item test-section">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hivResults">
            HIV Test Results
          </button>
        </h2>
        <div id="hivResults" class="accordion-collapse collapse" data-bs-parent="#testResultsAccordion">
          <div class="accordion-body">
            <?php if ($hivResult->num_rows > 0): ?>
              <table class="table table-bordered">
                <tr>
                  <th>Test Date</th>
                  <th>Created At</th>
                  <th>HIV Result</th>
                </tr>
                <?php while ($hivRow = $hivResult->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($hivRow['test_date']); ?></td>
                    <td><?php echo htmlspecialchars($hivRow['created_at']);?></td>
                    <td><?php echo htmlspecialchars($hivRow['hiv_result']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            <?php else: ?>
              <p class="no-results">No HIV test results available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Xray Results -->
      <div class="accordion-item test-section">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#xrayResults">
            Xray Results
          </button>
        </h2>
        <div id="xrayResults" class="accordion-collapse collapse" data-bs-parent="#testResultsAccordion">
          <div class="accordion-body">
            <?php if ($xrayResult->num_rows > 0): ?>
              <table class="table table-bordered">
                <tr>
                  <th>Test Date</th>
                  <th>Created At</th>
                  <th>Xray Image</th>
                  <th>Findings</th>
                </tr>
                <?php while ($xrayRow = $xrayResult->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($xrayRow['test_date']); ?></td>
                    <td><?php echo htmlspecialchars($xrayRow['created_at']); ?></td>
                    <td>
                      <?php if (!empty($xrayRow['xray_image'])): ?>
                        <img src="<?php echo htmlspecialchars($xrayRow['xray_image']); ?>" alt="xray" width="100">
                      <?php else: ?>
                        No Image
                      <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($xrayRow['findings']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            <?php else: ?>
              <p class="no-results">No Xray test results available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Ultrasound Results -->
      <div class="accordion-item test-section">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ultrasoundResults">
            Ultrasound Results
          </button>
        </h2>
        <div id="ultrasoundResults" class="accordion-collapse collapse" data-bs-parent="#testResultsAccordion">
          <div class="accordion-body">
            <?php if ($ultrasoundResult->num_rows > 0): ?>
              <table class="table table-bordered">
                <tr>
                  <th>Test Date</th>
                  <th>Created At</th>
                  <th>Ultrasound Image</th>
                  <th>Findings</th>
                </tr>
                <?php while ($ultrasoundRow = $ultrasoundResult->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($ultrasoundRow['test_date']); ?></td>
                    <td><?php echo htmlspecialchars($ultrasoundRow['created_at']); ?></td>
                    <td>
                      <?php if (!empty($ultrasoundRow['ultrasound_image'])): ?>
                        <img src="<?php echo htmlspecialchars($ultrasoundRow['ultrasound_image']); ?>" alt="ultrasound" width="100">
                      <?php else: ?>
                        No Image
                      <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($ultrasoundRow['findings']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            <?php else: ?>
              <p class="no-results">No Ultrasound test results available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="buttons">
    <a class="btn btn-secondary back-btn" href="patient_records.php">Back</a>
  </div>
</div>
</body>
</html>