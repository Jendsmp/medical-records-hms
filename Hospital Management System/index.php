<?php
  require_once 'SQL/config.php';

  $loginMessage = "";
  $showPopup = false;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $showPopup = true;

    if ($stmt = $con->prepare('SELECT username, password, name FROM users WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username, $hashed_password, $name);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                session_start();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = htmlspecialchars($username);
                $_SESSION['name'] = htmlspecialchars($name);

                switch ($name) {
                  case 'Admin':
                    // PROPERTY AND SUPPLY HERE KA MUNA
                    // PURCHASING DITO KA MUNA
                      header('Location: Admin (Kian Only)/index.php');
                      break;
                  case 'Doctor':
                    // TRAINING DITO KA MUNA
                      header('Location: Doctor Staffing/index.php');
                      break;
                  case 'Nurse':
                    // MEDICAL DITO KA MUNA DI KA NNURSE
                      header('Location: Medical Records Management/index.php'); 
                      break;
                  case 'Pharmacist':
                      header('Location: Pharmacy Management System/index.php');
                      break;
                  case 'Laboratorist':
                      header('Location: Labaratory and Diagnostic Management/index.php');
                      break;
                  case 'Receptionist':
                    // EVENNT DITO KA MUNA
                    // OUTPATIENT DITO KA MUNA
                      header('Location: Event Management System/index.php');
                      break;
                  case 'Accountant':
                    // BILLING MAKI GAMIT KA MUNA FOLDER
                      header('Location: Accounting Management/index.php');
                      break;
                  case 'HR':
                      header('Location: Human Resources/index.php');
                      break;
                  case 'IT':
                      header('Location: MIS/index.php');
                      break;
                  case 'Engineer':
                      header('Location: Engineering Equipment Management/index.php');
                      break;   
                }
                exit();
            }
        }
        $stmt->close();
    } else {
        die("MySQL Error: " . $con->error);
    }

    if ($stmt = $con->prepare('SELECT username, password, profession FROM employees WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username, $hashed_password, $profession);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) { 
                session_start();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = htmlspecialchars($username);
                $_SESSION['profession'] = htmlspecialchars($profession);

                if ($profession == 'Doctor') {
                    header('Location: user_doctor.php');
                    exit();
                } elseif ($profession == 'Nurse') {
                    header('Location: user_nurse.php');
                    exit();
                }
            }
        }
        $stmt->close();
    } else {
        die("MySQL Error: " . $con->error);
    }

    $loginMessage = "<div class='error-message'>Incorrect username or password.</div>";
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
  <link rel="stylesheet" href="CSS/index.css">
  <title>BSIS 3201 Hospital</title>
</head>

<body class="vh-100 overflow-hidden">

  <!-- ----- Navigation Bar ----- -->
  <nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
    <div class="container-fluid">

      <!-- ----- Logo ----- -->
      <div class="logo">
        <img src="pics/logo.png" alt="">
      </div>
      &nbsp&nbsp
      <a class="navbar-brand me-auto" href="#">BSIS 3201 Hospital</a>
    
      <!-- ----- Top/Side Bar ----- -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      
        <!-- ----- Top/Side Bar ----- -->
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- ----- Top/Side Bar Body ----- -->
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center fs-6 flex-grow-1 pe-4">
            <li class="nav-item mx-2">
              <a class="nav-link" href="#Home" aria-current="page">Home</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="#About">About</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="#Job">Job Vaccance</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="#Contact">Contact</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="#List">List</a> 
          </ul>
        </div>
      </div>

      <button class="btn" type="button" onclick="openForm()">Log In</button>
      &nbsp&nbsp&nbsp
      <!-- ----- Toggle ----- -->
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- ----- Pop-Up Form ----- -->
  <div id="popupForm" class="popup-form" style="display: <?php echo $showPopup ? 'flex' : 'none'; ?>;">
    <div class="form-container">
      <bttn class="close-btn" onclick="closeForm()">X</bttn>
      <center>
        <h4 style="font-weight: bold;">Log In Account</h4>
      </center>
      <?php echo $loginMessage; ?>
      <form action=" " method="POST">
        <div class="input-container">
          <input class="input-field" type="text" placeholder="Username" name="username" required>
        </div>           
        <div class="input-container">
          <input class="input-field" type="password" placeholder="Password" name="password" required>
        </div>
        <br />
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

<script>
  function openForm() {
    document.getElementById("popupForm").style.display = "flex";
  }

  function closeForm() {
    document.getElementById("popupForm").style.display = "none";
  }
</script>
<script src="Bootstrap/all.min.js"></script>
<script src="Bootstrap/bootstrap.bundle.min.js"></script>
<script src="Bootstrap/bootstrap.min.css"></script>
<script src="Bootstrap/fontawesome.min.js"></script>
</body>
</html>