<?php
session_start();
include('../SQL/dbconnection.php');

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
  
      <div class="container my-5">
        <form method="post" class="search-section">
          <input type="text" placeholder="search patient" name="search" class="search-box">
          <button type="submit" class="btn btn-dark btn-sm button-search" name="submit">Search</button>

         <!-- <a href="add.php" class="button-add">Add New</a> -->
        </form>
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

</body>

</html>