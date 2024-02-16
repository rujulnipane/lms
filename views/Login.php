
<?php
session_start();
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); 
}

if (isset($_SESSION['successmsg'])) {
    $success = $_SESSION['successmsg'];
    unset($_SESSION['successmsg']); 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>

<body>

    <div class="container">
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
        <div class="card bg-light">
            <article class="card-body mx-auto" style="width: 50%;">
                <h4 class="card-title mt-3 text-center">Log in to Account</h4>
                <p class="text-center">Get started with your account</p>

                <form id="loginform" action="../controllers/LoginController.php" method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" id="username" class="form-control" placeholder="Enter Username" type="text" required>
                        <div id="usernameError" class="invalid-feedback"></div>
                    </div> <!-- form-group// -->

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="password" id="password" class="form-control" placeholder="Enter password" type="password" required>
                        <div id="passwordError" class="invalid-feedback"></div>
                    </div> <!-- form-group// -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Login </button>
                    </div> <!-- form-group// -->
                    <p class="text-center">Don't have an account?<a href="/views/Registration.php">Register</a> </p>
                </form>
            </article>
        </div> <!-- card.// -->

    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>

        document.getElementById("username").addEventListener("keyup", validateUsername);
        document.getElementById("email").addEventListener("keyup", validateEmail);
        document.getElementById("password").addEventListener("keyup", validatePassword);

        function validateUsername() {
            var username = document.getElementById("username").value.trim();
            var usernameError = document.getElementById("usernameError");
            if (/[^a-zA-Z]/.test(username)) {
                usernameError.textContent = "Username should only contain letters";
                usernameError.style.display = "block";
            } else {
                usernameError.style.display = "none";
            }

        }

        function validatePassword() {
            var password = document.getElementById("password").value.trim();
            var passwordError = document.getElementById("passwordError");
            if (password === '') {
                passwordError.textContent = "Password is required";
                passwordError.style.display = "block";
            } else {
                passwordError.style.display = "none";
            }
        }

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>

</html>