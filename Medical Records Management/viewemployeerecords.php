<?php
session_start();
include('SQL/dbconnection.php');

// Check if employee_id is set and valid
if (isset($_GET['employee_id']) && is_numeric($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    $stmt = $con->prepare("SELECT * FROM employees WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch CBC test
$employee_cbcStmt = $con->prepare("SELECT * FROM employee_cbc WHERE employee_id = ? ORDER BY test_date DESC");
$employee_cbcStmt->bind_param("i", $employee_id);
$employee_cbcStmt->execute();
$employee_cbcResult = $employee_cbcStmt->get_result();


  //fetch urine test
  $employee_urineStmt = $con->prepare("SELECT * FROM employee_urine WHERE employee_id = ? ORDER BY test_date DESC");
$employee_urineStmt->bind_param("i", $employee_id);
$employee_urineStmt->execute();
$employee_urineResult = $employee_urineStmt->get_result();

//fetch hiv 
$employee_hivStmt = $con->prepare("SELECT * FROM employee_hiv_test WHERE employee_id = ? ORDER BY test_date DESC");
$employee_hivStmt ->bind_param("i", $employee_id);
$employee_hivStmt->execute();
$employee_hivResult = $employee_hivStmt->get_result();
    
    // Store the result for later use
    $employee_data = $result->fetch_assoc();
    
    // Close statement
    $stmt->close();
} else {
    echo "Employee ID not set or invalid!";
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Your HTML content here -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="icon" href="pics/logo.png" type="image/icon type">
  <link rel="stylesheet" href="CSS/viewemployeerecords.css">
  <title>BSIS 3201 Hospital</title>

  <style>
  </style>
</head>
<body>
<div class="container" id="viewEmployeesRecords">
  <h2>Employees Records</h2>
  
  <?php if (isset($employee_data) && !empty($employee_data)) { ?>
    <!-- Employee Details (always visible) -->
    <div class="employee-details">
      <h3>Employee Information</h3>
      <table class="table table-bordered">
        <tr>
          <th>Name</th>
          <td><?php echo htmlspecialchars($employee_data['first_name'] . " " . $employee_data['middle_name'] . " " . $employee_data['last_name']); ?></td>
        </tr>
        <tr>
          <th>ID</th>
          <td><?php echo htmlspecialchars($employee_data['employee_id']); ?></td>
        </tr>
        <tr>
          <th>Role</th>
          <td><?php echo htmlspecialchars($employee_data['role']); ?></td>
        </tr>
      </table>
    </div>

            <!-- Test Results Accordion -->
            <div class="accordion" id="employeeTestResultsAccordion">
                <!-- CBC Test Results -->
                <div class="accordion-item test-section">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#employeeCbcResults">
                            CBC Test Results
                        </button>
                    </h2>
                    <div id="employeeCbcResults" class="accordion-collapse collapse" data-bs-parent="#employeeTestResultsAccordion">
                        <div class="accordion-body">
                            <?php if ($employee_cbcResult->num_rows > 0): ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Test Date</th>
                                        <th>Red Blood Cells</th>
                                        <th>White Blood Cells</th>
                                        <th>Hemoglobin</th>
                                        <th>Platelets</th>
                                    </tr>
                                    <?php while ($employee_cbcRow = $employee_cbcResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($employee_cbcRow['test_date']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_cbcRow['red_blood_cells']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_cbcRow['white_blood_cells']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_cbcRow['hemoglobin']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_cbcRow['platelets']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </table>
                            <?php else: ?>
                                <p class="no-results">No CBC test results available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Urine Test Results -->
                <div class="accordion-item test-section">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#employeeUrineResults">
                            Urine Test Results
                        </button>
                    </h2>
                    <div id="employeeUrineResults" class="accordion-collapse collapse" data-bs-parent="#employeeTestResultsAccordion">
                        <div class="accordion-body">
                            <?php if ($employee_urineResult->num_rows > 0): ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Test Date</th>
                                        <th>Ph level</th>
                                        <th>Protein</th>
                                        <th>Glucose</th>
                                        <th>Ketones</th>
                                    </tr>
                                    <?php while ($employee_urineRow = $employee_urineResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($employee_urineRow['test_date']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_urineRow['ph_level']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_urineRow['protein']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_urineRow['glucose']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_urineRow['ketones']); ?></td>
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
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#employeeHivResults">
                            HIV Test Results
                        </button>
                    </h2>
                    <div id="employeeHivResults" class="accordion-collapse collapse" data-bs-parent="#employeeTestResultsAccordion">
                        <div class="accordion-body">
                            <?php if ($employee_hivResult->num_rows > 0): ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Test Date</th>
                                        <th>HIV Result</th>
                                    </tr>
                                    <?php while ($employee_hivRow = $employee_hivResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($employee_hivRow['test_date']); ?></td>
                                            <td><?php echo htmlspecialchars($employee_hivRow['hiv_result']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </table>
                            <?php else: ?>
                                <p class="no-results">No HIV test results available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <p>No employee data found.</p>
        <?php } ?>

        <div class="buttons">
            <a class="btn btn-secondary back-btn" href="employee_records.php">Back</a>
        </div>
    </div>
</body>
</html>