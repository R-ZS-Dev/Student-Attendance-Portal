<?php
require 'include/db_con.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $phn_num = $_POST['phn_num'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the insert statement
    $sql = "INSERT INTO registration (f_name, l_name, email, phn_num, password, address) 
            VALUES ('$f_name', '$l_name', '$email', '$phn_num', '$hashed_password', '$address')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "New record created successfully";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <!-- Bootstrap CSS -->
  	<link rel="stylesheet" type="text/css" href="include/css/bootstrap.css">
</head>
<body>
  <div class="container mt-5">
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <h3 class="text-center">Fill Registration Form</h3>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3>Registration Form</h3>
          </div>
          <div class="card-body">
            <form id="registrationForm" action="" method="POST" onsubmit="return validateForm()">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="f_name">First Name</label>
                  <input type="text" class="form-control" id="f_name" name="f_name" placeholder="Enter your first name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="l_name">Last Name</label>
                  <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Enter your last name" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="phn_num">Phone Number</label>
                  <input type="tel" class="form-control" id="phn_num" name="phn_num" placeholder="Enter your phone number" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="address">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your address" required></textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Register</button>
            </form>
              <p class="text-center">or <a class="text-decoration-none" href="index.php">Login</a></p>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Custom JS for form validation -->
  <script>
    function validateForm() {
      var password = document.getElementById('password').value;
      var confirmPassword = document.getElementById('confirm_password').value;

      if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
