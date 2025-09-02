<?php
error_reporting(1);
session_start();
include("dbcon.php");

// Check if the user is already logged in and check the role
if (isset($_SESSION['user_session']) && isset($_SESSION['user_role'])) {
    $invoice_number = generate_unique_invoice_number($con);
    $role = $_SESSION['user_role'];
    
    if ($role === 'admin') {
        header("location:adminDashboard.php?invoice_number=$invoice_number");
    } elseif ($role === 'cashier') {
        header("location:cashierPOS.php?invoice_number=$invoice_number");
    } else {
        header("location:othersDashboard.php?invoice_number=$invoice_number");
    }
    exit(); // Make sure to exit after redirection
}

if (isset($_POST['submit'])) {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement using prepared statement to select only the user with the provided username
    $select_sql = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
    $stmt = $con->prepare($select_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $s_username = $row['user_name'];
        $s_password = $row['password'];
        $role = $row['role'];

        if (password_verify($password, $s_password)) {
            // Set session immediately after successful authentication
            $_SESSION['user_session'] = $username;
            $_SESSION['user_role'] = $role; // Store the role in session
            $_SESSION['store_id'] = $row['store_id'];  // ✅ Correct way


            // Redirect based on user role
            $invoice_number = generate_unique_invoice_number($con);
            if ($role === 'admin') {
                header("location:adminDashboard.php?invoice_number=$invoice_number");
            } elseif ($role === 'cashier') {
                header("location:cashierPOS.php?invoice_number=$invoice_number");
            } else {
                header("location:othersDashboard.php?invoice_number=$invoice_number");
            }
            exit(); // Make sure to exit after redirection
        } else {
            $error_msg = "<center><font color='red'>Tafadhari andika kwa usahihi Neno Sili</font></center>";
        }
    } else {
        $error_msg = "<center><font color='red'>Hakuna mtumiaji kama huyo</font></center>";
    }
}

function generate_unique_invoice_number($con) {
    do {
        $chars = "09302909209300923";
        srand((double)microtime() * 1000000);
        $i = 1;
        $pass = '';

        while ($i <= 7) {
            $num  = rand() % 10;
            $tmp  = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        $invoice_number = "CA-" . $pass;

        // Check both 'sales' and 'on_hold' tables for existing invoice number
        $check_sql = "SELECT invoice_number FROM sales WHERE invoice_number = ? UNION SELECT invoice_number FROM on_hold WHERE invoice_number = ?";
        $stmt = $con->prepare($check_sql);
        $stmt->bind_param("ss", $invoice_number, $invoice_number);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    
    return $invoice_number;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>MauzoApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: auto;
      padding: 20px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .login-container h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      font-weight: bold;
    }
    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus {
      border-color: #80bdff;
      outline: 0;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .btn-login {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      background-color: #007bff;
      border: none;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.15s ease-in-out;
    }
    .btn-login:hover {
      background-color: #0056b3;
    }
    .error-msg {
      color: red;
      text-align: center;
    }
    .company-logo {
      text-align: center;
      margin-bottom: 20px;
      margin-top: 5px;
    }
    .company-logo img {
      max-width: 140px;
      border-radius: 50%;
    }
    .loading {
      display: none;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="login-container">
        <div class="company-logo">
          <img src="images/logo.png" alt="logos">
        </div>
        <!-- div> <center> <H2>PP TIMBER</H2> </center> </div -->
        <form method="POST" onsubmit="return validateForm()">
          <div class="form-group">
            <input type="text" id="username" name="username" class="form-control" placeholder="Jina la mtumiaji" required>
          </div>
          <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Neno la siri" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-login" value="Ingia">
            <div class="loading" id="loading">
              <h3 style="color:green"><b>Tafadhari subiri...</b></h3>
            </div>
          </div>
          <div id="error-msg" class="error-msg">
            <?php echo isset($error_msg) ? $error_msg : ''; ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function validateForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var errorMsg = document.getElementById("error-msg");

    if (username === "" && password === "") {
      errorMsg.innerHTML = "Tafadhari jaza jina la mtumiaji na neno la siri.";
      return false;
    } else if (username === "") {
      errorMsg.innerHTML = "Tafadhari jaza jina la mtumiaji.";
      return false;
    } else if (password === "") {
      errorMsg.innerHTML = "Tafadhari jaza neno la siri.";
      return false;
    }

    // Show loading animation
    document.getElementById("loading").style.display = "block";
    return true;
  }
</script>
</body>
</html>
