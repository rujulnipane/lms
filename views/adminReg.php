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


<?php include 'partials/_header.php'?>
<body class="container">

  <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>


<div class="card bg-light vh-100 d-flex align-items-center">
            <article class="card-body mx-auto" style="width: 50%;">
                <h4 class="card-title mt-3 text-center">Installation</h4>
                <p class="text-center">Welcome to the LMS Platform</p>
                <form id="registrationForm" action="../controllers/installation.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" id="name" class="form-control" placeholder="Enter User Name" type="text" required value="<?php echo $userdetails['username']; ?>">
                        <div id="nameError" class="invalid-feedback"></div>
                    </div> 
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" id="email" class="form-control" placeholder="Email address" type="email" required value="<?php echo $userdetails['email']; ?>">
                        <div id="emailError" class="invalid-feedback"></div>
                    </div> 

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="password" id="password" class="form-control" placeholder="Create password" type="password" required>
                        <div id="passwordError" class="invalid-feedback"></div>
                    </div> 
                    
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="dbuser" id="dbuser" class="form-control" placeholder="Enter Datbase User Name" type="text" required>
                        <div id="dbuserErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="dbpass" id="dbpass" class="form-control" placeholder="Enter Database password" type="password" required>
                        <div id="dbpasswordError" class="invalid-feedback"></div>
                    </div> 
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-database"></i> </span>
                        </div>
                        <input name="dbname" id="dbname" class="form-control" placeholder="Enter Datbase Name" type="text" required>
                        <div id="dbuserErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Proceed </button>
                    </div> 
                </form>
            </article>
        </div>
  

        <script>
  // Function to validate username
  document.getElementById("name").addEventListener("keyup", validateUsername);

  function validateUsername() {
    var username = document.getElementById("name").value;
    var usernameError = document.getElementById("nameError");
    if (/[^a-zA-Z0-9]/.test(username)) {
      usernameError.textContent = "Username should only contain letters and digits";
      usernameError.style.display = "block";
    } else {
      usernameError.style.display = "none";
    }
  }

  // Function to validate email
  document.getElementById("email").addEventListener("keyup", validateEmail);

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

  // Function to validate password
  document.getElementById("password").addEventListener("keyup", validatePassword);

  function validatePassword() {
    var password = document.getElementById("password").value;
    var passwordError = document.getElementById("passwordError");
    if (password.length < 5) {
      passwordError.textContent = "Password must be at least 6 characters long";
      passwordError.style.display = "block";
    } else {
      passwordError.style.display = "none";
    }
  }

  // Function to validate database username
  document.getElementById("dbuser").addEventListener("keyup", validateDBUsername);

  function validateDBUsername() {
    var dbuser = document.getElementById("dbuser").value;
    var dbuserError = document.getElementById("dbuserErr");
    if (!dbuser) {
      dbuserError.textContent = "Database username is required";
      dbuserError.style.display = "block";
    } else {
      dbuserError.style.display = "none";
    }
  }

  // Function to validate database password
  document.getElementById("dbpass").addEventListener("keyup", validateDBPassword);

  function validateDBPassword() {
    var dbpass = document.getElementById("dbpass").value;
    var dbpassError = document.getElementById("dbpasswordError");
    if (!dbpass) {
      dbpassError.textContent = "Database password is required";
      dbpassError.style.display = "block";
    } else {
      dbpassError.style.display = "none";
    }
  }

  // Function to validate database name
  document.getElementById("dbname").addEventListener("keyup", validateDBName);

  function validateDBName() {
    var dbname = document.getElementById("dbname").value;
    var dbnameError = document.getElementById("dbnameErr");
    if (!dbname) {
      dbnameError.textContent = "Database name is required";
      dbnameError.style.display = "block";
    } else {
      dbnameError.style.display = "none";
    }
  }

  function validateForm() {
    validateUsername();
    validateEmail();
    validatePassword();
    validateDBUsername();
    validateDBPassword();
    validateDBName();

    var errors = document.querySelectorAll('.invalid-feedback');
    for (var i = 0; i < errors.length; i++) {
      if (errors[i].textContent) {
        return false;
      }
    }
    return true;
  }
</script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>