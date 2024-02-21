<?php
$file = "../config.php";
if(file_exists($file)){
    header('Location: '. "./Login.php");  
    echo "file exists";
}
session_start();
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Details</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="container">
  <!-- <form class="container" id="adminForm" method="post" action="../controllers/installation.php">
  <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Name" required>
      <div id="usernameError" class="invalid-feedback"></div>
    </div>
    <div class="form-group">
      <label for="email">User Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
      <div id="emailError" class="invalid-feedback"></div>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
      <div id="passwordError" class="invalid-feedback"></div>
    </div>
    <div class="form-group">
      <label for="dbName">Database Name</label>
      <input type="text" class="form-control" id="dbName" name="dbName" placeholder="Enter Database Name" required>
      <div id="dbNameError" class="invalid-feedback"></div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form> -->
<section class="d-flex w-100 justify-content-center align-items-center vh-100">


  <form>
  <!-- Email input -->
  <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="form2Example1" class="form-control" />
    <label class="form-label" for="form2Example1">User Name</label>
  </div>

  <div data-mdb-input-init class="form-outline mb-4">
    <input type="email" id="form2Example1" class="form-control" />
    <label class="form-label" for="form2Example1">Email address</label>
  </div>
  <!-- Password input -->
  <div data-mdb-input-init class="form-outline mb-4">
    <input type="password" id="form2Example2" class="form-control" />
    <label class="form-label" for="form2Example2">User Password</label>
  </div>

  <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="form2Example1" class="form-control" />
    <label class="form-label" for="form2Example1">Database Name</label>
  </div>
  <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="form2Example1" class="form-control" />
    <label class="form-label" for="form2Example1">Database User Name</label>
  </div>

  <div data-mdb-input-init class="form-outline mb-4">
    <input type="password" id="form2Example2" class="form-control" />
    <label class="form-label" for="form2Example2">Database Password</label>
  </div>

  <button data-mdb-ripple-init type="button" class="btn btn-primary btn-block mb-4">Install</button>

  
</form>
</section>
  <script>
    document.getElementById("username").addEventListener("keyup", validateUsername);
    document.getElementById("email").addEventListener("keyup", validateEmail);
    document.getElementById("password").addEventListener("keyup", validatePassword);
    document.getElementById("dbName").addEventListener("keyup", validateDbName);

    function validateUsername() {
      var username = document.getElementById("username").value;
      var usernameError = document.getElementById("usernameError");
      if (/[^a-zA-Z0-9\.]/.test(username)) {
        usernameError.textContent = "Username should only contain letters and digits";
        usernameError.style.display = "block";
      } else {
        usernameError.style.display = "none";
      }
    }

    function validateEmail() {
      var email = document.getElementById("email").value;
      var emailError = document.getElementById("emailError");
      if (!/^\S+@\S+\.\S+$/.test(email)) {
        emailError.textContent = "Invalid email format";
        emailError.style.display = "block";
      } else {
        emailError.style.display = "none";
      }
    }

    function validatePassword() {
      var password = document.getElementById("password").value;
      var passwordError = document.getElementById("passwordError");
      if (password === "") {
        passwordError.textContent = "Password is required";
        passwordError.style.display = "block";
      } else {
        passwordError.style.display = "none";
      }
    }

    function validateDbName() {
      var dbName = document.getElementById("dbName").value;
      var dbNameError = document.getElementById("dbNameError");
      if (/[^a-zA-Z]/.test(dbName)) {
        dbNameError.textContent = "Enter valid database name";
        dbNameError.style.display = "block";
      } else {
        dbNameError.style.display = "none";
      }
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>