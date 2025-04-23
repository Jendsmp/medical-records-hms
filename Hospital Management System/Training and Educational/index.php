<?php
session_start();
include('../SQL/dbconnection.php');
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'Pharmacist') {
  header('Location: ../index.php');
  exit;
}

$doctorQuery = "SELECT COUNT(*) AS total FROM employees WHERE profession = 'Doctor' AND status = 'Active'";
$doctorResult = mysqli_query($con, $doctorQuery);
$doctorRow = mysqli_fetch_assoc($doctorResult);
$totalDoctors = $doctorRow['total'];

$nurseQuery = "SELECT COUNT(*) AS total FROM employees WHERE profession = 'Nurse' AND status = 'Active'";
$nurseResult = mysqli_query($con, $nurseQuery);
$nurseRow = mysqli_fetch_assoc($nurseResult);
$totalNurses = $nurseRow['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="icon" href="pics/logo.png" type="image/icon type">
  <link rel="stylesheet" href="css/index.css">
  <title>BSIS 3201 Hospital</title>
</head>

<body>

  <div class="d-flex">
    <!----- Sidebar ----->
    <aside id="sidebar" class="sidebar-toggle">
      <div class="sidebar-logo">
        <img src="../pics/logo.png" width="60px" height="60px">
        <br />
        <br />
        <a href="#">BSIS 3201 Hospital</a>
      </div>

      <!----- Sidebar Navigation ----->
      <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="true" aria-controls="auth">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 18 18" style="margin-bottom: 5px;">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
          </svg>
          <span style="font-size: 18px;">HR Recruitment</span>
        </a>

        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Job Management</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Applicant Tracking</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Employee Onboarding</a>
          </li>
        </ul>
      </li>

      <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#gerald" aria-expanded="true" aria-controls="auth">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16" style="margin-bottom: 6px;">
            <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
            <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
          </svg>
          <span style="font-size: 18px;">Employees</span>
        </a>

        <ul id="gerald" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
          <li class="sidebar-item">
            <a href="HR PAYROLL/Employee/doctor.php" class="sidebar-link">Doctors</a>
          </li>
          <li class="sidebar-item">
            <a href="HR PAYROLL/Employee/nurse.php" class="sidebar-link">Nurses</a>
          </li>
          <li class="sidebar-item">
            <a href="HR PAYROLL/Employee/admin.php" class="sidebar-link">Other Staff</a>
          </li>
        </ul>
      </li>

      <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#axl" aria-expanded="true" aria-controls="auth">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16" style="margin-bottom: 7px;">
            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
            <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
          </svg>
          <span style="font-size: 18px;">Workforce</span>
        </a>

        <ul id="axl" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
          <li class="sidebar-item">
            <a href="HR PAYROLL/Human Resource/attendance.php" class="sidebar-link">Attendance</a>
          </li>
          <li class="sidebar-item">
            <a href="HR PAYROLL/Human Resource/leave.php" class="sidebar-link">Leave</a>
          </li>
          <li class="sidebar-item">
            <a href="HR PAYROLL/Human Resource/payroll.php" class="sidebar-link">Payroll</a>
          </li>
        </ul>
      </li>

      <div class="sidebar-footer">
        <a href="../logout.php" class="sidebar-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 18 18">
            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
          </svg>
          <span style="font-size: 18px;">Log Out</span>
        </a>
      </div>
    </aside>

    <!-- ----- Main ----- -->
    <div class="main">

      <!-- ----- TopBar ----- -->
      <div class="topbar">

        <!-- ----- Toggle ----- -->
        <div class="toggle">
          <button class="toggler-btn" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
            </svg>
          </button>
        </div>

        <!-- ----- Logo ----- -->
        <div class="logo">
          <img src="pics/logo.png" alt="">
        </div>
      </div>

      <!-- ----- Card-List of Employees ----- -->
      <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Doctors</h5>
              <p class="card-text">There are currently <strong><?php echo $totalDoctors; ?></strong> active doctors registered.</p>
              <a href="HR PAYROLL/Employee/doctor.php" class="list">List Of Doctors...</a>
            </div>
          </div>
        </div>
        <h1>Doctor and Training educational</h1>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Nurses</h5>
              <p class="card-text">There are currently <strong><?php echo $totalNurses; ?></strong> active nurses registered.</p>
              <a href="HR PAYROLL/Employee/nurse.php" class="list">List Of Nurses...</a>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
  <script>
    const toggler = document.querySelector(".toggler-btn");
    toggler.addEventListener("click", function() {
      document.querySelector("#sidebar").classList.toggle("collapsed");
    });
  </script>
  <script src="../Bootstrap/all.min.js"></script>
  <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
  <script src="../Bootstrap/bootstrap.min.css"></script>
  <script src="../Bootstrap/fontawesome.min.js"></script>
</body>

</html>