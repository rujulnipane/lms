<?php
session_start();
if (!file_exists("../config.php")) {
    header('Location: ' . "./adminReg.php");
    echo "file exists";
}

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION['details'])) {
    $userdetails = $_SESSION['details'];
    unset($_SESSION['details']);
}
?>

<?php include 'partials/_header.php'?>
<body>

    <div class="container">
        <?php if (isset($error_message)) : ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php include 'partials/_alerts.php'?>
        <div class="card bg-light">
            <article class="card-body mx-auto" style="width: 50%;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <p class="text-center">Get started with your account</p>
                <form id="registrationForm" action="../controllers/RegistrationController.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" id="name" class="form-control" placeholder="Enter Username" type="text" required value="<?php echo $userdetails['username']; ?>">
                        <div id="nameError" class="invalid-feedback"></div>
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" id="email" class="form-control" placeholder="Email address" type="email" required value="<?php echo $userdetails['email']; ?>">
                        <div id="emailError" class="invalid-feedback"></div>
                    </div> <!-- form-group// -->

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="password" id="password" class="form-control" placeholder="Create password" type="password" required>
                        <div id="passwordError" class="invalid-feedback"></div>
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="cpassword" id="cpassword" class="form-control" placeholder="Repeat password" type="password" required>
                        <div id="cpasswordError" class="invalid-feedback"></div>
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Create Account </button>
                    </div> <!-- form-group// -->
                    <p class="text-center">Have an account? <a href="./Login.php">Log In</a> </p>
                </form>
            </article>
        </div>

    </div>

    <script>
        document.getElementById("name").addEventListener("keyup", validateName);
        document.getElementById("email").addEventListener("keyup", validateEmail);
        document.getElementById("password").addEventListener("keyup", validatePassword);
        document.getElementById("cpassword").addEventListener("keyup", validateConfirmPassword);

        function validateForm() {
            var isValid = true;
            isValid = isValid && validateName();
            isValid = isValid && validateEmail();
            isValid = isValid && validatePassword();
            isValid = isValid && validateConfirmPassword();
            return isValid;
        }

        function validateName() {
            var name = document.getElementById("name").value.trim();
            var nameError = document.getElementById("nameError");

            if (/[^a-zA-Z0-9]/.test(name)) {
                nameError.textContent = "Username should only contain letters";
                nameError.style.display = "block";
            } else {
                nameError.style.display = "none";
            }
        }

        function validateEmail() {
            var email = document.getElementById("email").value.trim();
            var emailError = document.getElementById("emailError");
            if (email === '') {
                emailError.textContent = "Email is required";
                emailError.style.display = "block";
                return false;
            } else if (!isValidEmail(email)) {
                emailError.textContent = "Invalid email format";
                emailError.style.display = "block";
                return false;
            } else {
                emailError.style.display = "none";
                return true;
            }
        }

        function validatePassword() {
            var password = document.getElementById("password").value.trim();
            var passwordError = document.getElementById("passwordError");
            if (password === '') {
                passwordError.textContent = "Password is required";
                passwordError.style.display = "block";
                return false;
            } else if (password.length < 5) {
                passwordError.textContent = "Password must be at least 5 characters long";
                passwordError.style.display = "block";
                return false;
            } else {
                passwordError.style.display = "none";
                return true;
            }
        }


        function validateConfirmPassword() {
            var password = document.getElementById("password").value.trim();
            var cpassword = document.getElementById("cpassword").value.trim();
            var cpasswordError = document.getElementById("cpasswordError");
            if (cpassword === '') {
                cpasswordError.textContent = "Please repeat the password";
                cpasswordError.style.display = "block";
                return false;
            } else if (password !== cpassword) {
                cpasswordError.textContent = "Passwords do not match";
                cpasswordError.style.display = "block";
                return false;
            } else {
                cpasswordError.style.display = "none";
                return true;
            }
        }

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

<?php include "partials/_footer.php";?>