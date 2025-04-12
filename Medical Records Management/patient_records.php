<?php
session_start();
include('SQL/dbconnection.php');

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
  <link rel="stylesheet" href="CSS/patient_records.css">
  <title>BSIS 3201 Hospital</title>
</head>

<body>

  <div class="d-flex">
    <!----- Sidebar ----->
    <aside id="sidebar" class="sidebar-toggle">
      <div class="sidebar-logo">
        <img src="pics/logo.jpg" width="60px" height="60px">
        <br />
        <br />
        <a href="#">SJDM Muzon Medical Center</a>
      </div>

      <!----- Sidebar Navigation ----->
      <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="true" aria-controls="auth">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 18 18" style="margin-bottom: 5px;">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
          </svg>
          <span style="font-size: 18px;">Medical Records</span>
        </a>

        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
          <li class="sidebar-item">
            <a href="patient_records.php" class="sidebar-link">Patient Diagnosis and Laboratory Records</a>
          </li>
          <li class="sidebar-item">
            <a href="employee_records.php" class="sidebar-link">Employee Records</a>
          </li>
        </ul>
      </li>

      <div class="sidebar-footer">
        <a href="logout.php" class="sidebar-link">
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

        
      <div class="container my-5">
        <form method="post" class="search-section">
          <input type="text" placeholder="search patient" name="search" class="search-box">
          <button type="submit" class="btn btn-dark btn-sm button-search" name="submit">Search</button>

         <!-- <a href="add.php" class="button-add">Add New</a> -->
        </form>
      </div>

        <!-- ----- Logo ----- -->
        <div class="logo">
          <img src="pics/logo.jpg" alt="">
        </div>
      </div>



        <div class="container my-5">
          <table class="medicalRecords">
            <thead>
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
               <!-- <th>Phone Number</th>
                <th>Email</th> -->
                <th>Actions</th>
              </tr>
            </thead>
          <tbody id="medicalRecords">
          <?php

//pagination
$total_no_of_pages =1;
$page_no =1;

//check if the search form is submitted
if (isset($_POST['submit'])) {
    $search = $_POST['search'];

//if search is empty, fetch all data
if (empty($search)) {
   //get page no. of pagination
   $page_no = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
   //total row to display
   $total_records_per_page=10;
   //get the page offset for the limit query
   $offset=($page_no-1)* $total_records_per_page;
   //get prev page
   $previous_page=$page_no -1;
   //get next page
   $next_page=$page_no +1;
   //get the total count of records
   $result_count=mysqli_query($con, "SELECT COUNT(*)as total_records FROM patient") or die(mysqli_error($con));
   //total records
   $records=mysqli_fetch_array($result_count);
   //store total records 
   $total_records=$records['total_records'];
   //get total pages
   $total_no_of_pages=ceil($total_records/$total_records_per_page);


$sql = "SELECT * FROM patient p LIMIT $offset, $total_records_per_page";

} 
else {
    //search query with filtering
    $sql = "SELECT * FROM patient p
    WHERE p.id LIKE '%$search%'
    OR p.fname LIKE '%$search%'
    OR p.mname LIKE '%$search%'
    OR p.lname LIKE '%$search%'
    OR p.address LIKE '%$search%'
    OR p.age LIKE '%$search%'
    OR p.bdate LIKE '%$search%'
    OR p.gender LIKE '%$search%'
    OR p.civil_status LIKE '%$search%'
    OR p.phone_num LIKE '%$search%'
    OR p.email LIKE '%$search%'
    OR p.addmission_type LIKE '%$search%'
    OR p.bed_number LIKE '%$search%'
    OR p.diagnosis LIKE '%$search%'
    OR p.allergies LIKE '%$search%'
    OR p.surgeries LIKE '%$search%'
    OR p.date LIKE '%$search%'
    OR p.chronic LIKE '%$search%'
    OR p.family LIKE '%$search%'
    OR p.vaccination LIKE '%$search%'
    OR p.information LIKE '%$search%' ";

    //pagination for search result
    $result_count = mysqli_query($con, $sql);
    $total_records = mysqli_num_rows($result_count);
    $total_no_of_pages = ceil($total_records / 10);
    $page_no = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
    $offset = ($page_no -1) * 10;
    $sql = $sql . " LIMIT $offset, 10";
}
}
else {
    //fetch all patient data
    $page_no = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;

    //total row to display
    $total_records_per_page = 10;
    //get the page offset for the limit query
    $offset = ($page_no - 1)* $total_records_per_page;
    //get prev page
    $previous_page = $page_no - 1;
    //get next page
    $next_page = $page_no +1;
    //get the total count of records
    $result_count = mysqli_query($con, "SELECT COUNT(*) as total_records FROM patient") or die (mysqli_error($con));
    //total records
    $records = mysqli_fetch_array($result_count);
    //store total records
    $total_records = $records['total_records'];
    //get total of pages
    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $sql = "SELECT * FROM patient p LIMIT $offset, $total_records_per_page";
  
}

$result = mysqli_query($con, $sql) or die (mysqli_error($con));

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
            <td>{$row['id']}</td>
            <td>{$row['fname']}</td>
            <td>{$row['mname']}</td>
            <td>{$row['lname']}</td>
            <td>{$row['age']}</td>
            <td>{$row['gender']}</td>
            <!-- <td>{$row['phone_num']}</td>
            <td>{$row['email']}</td> -->
            <td>
            <a class='btn btn-primary btn-sm' href='viewpatientrecords.php?id={$row['id']}'>View</a>
           <!-- <a class='btn btn-secondary btn-sm' href='edit.php?id={$row['id']}'>Edit</a> -->
             <!-- Generate Medical Certificate Button -->
           <!-- Certificate Dropdown Button -->
                    <div class='dropdown d-inline-block ms-1'>
                        <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='certDropdown{$row['id']}' data-bs-toggle='dropdown' aria-expanded='false'>
                            Certificate
                        </button>
                        <ul class='dropdown-menu' aria-labelledby='certDropdown{$row['id']}'>
                            <li><a class='dropdown-item' href='medcertpatient.php?id={$row['id']}'>Medical Certificate</a></li>
                            <li><a class='dropdown-item' href='patientcertresult.php?id={$row['id']}'>Results Certificate</a></li>
                    </div>
                </td>
            </tr>";
        }
    } 
    else {
        echo "<tr><td colspan='9'>No records found</td></tr>";    
    }
}
else {
    echo "<tr><td colspan='9'>Error in query execution: " . mysqli_error($con) . "</td></tr>";  
}
?>
</tbody>
</table>

<nav aria-label="Page navigation">
    <ul class="pagination">
      <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disabled'
       : ''; ?> " <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page: ''; ?>>Previous</a></li>

  <?php for ($counter= 1; $counter <= $total_no_of_pages; $counter++) { ?>
   
   <?php if ($page_no !== $counter) { ?>
  <li class="page-item"><a class="page-link" href="?page_no=<?=$counter; ?>"><?= $counter; ?></a></li>
<?php } else { ?>
  <li class="page-item"><a class="page_link active"><?= $counter; ?></a></li>
  <?php } ?>
  <?php } ?>

  <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages) ?
   'disabled' : ''; ?>" <?= ($page_no <$total_no_of_pages) ? 'href=?page_no=' . $next_page : ''; ?>>Next</a></li></ul>
</nav>
<div class="p-10">
  <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
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