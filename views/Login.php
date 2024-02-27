
<?php
session_start();
include("../controllers/Auth.php");

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); 
}

if(Auth::isLogin()){
    header('Location: '. "./Courses.php");
}

if (isset($_SESSION['details'])) {
    $userdetails = $_SESSION['details'];
    unset($_SESSION['details']); 
}

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']); 
}

?>

<?php include 'partials/_header.php'?>

<body>

    <div class="container flex-column justify-content-center vh-100">
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <?php include "partials/_alerts.php" ?>
        <h1 class="text-center text-info my-4">Welcome to Learning Management System</h1>
        <div class="card bg-light h-75">
            <article class="card-body mx-auto h-100 d-flex-column justify-content-around w-50" >
                <h4 class="card-title mt-3 text-center">Log in to Account</h4>
                <!-- <p class="text-center">Get started with your account</p> -->

                <form id="loginform" class="mt-5" action="../controllers/LoginController.php" method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" id="username" class="form-control" placeholder="Enter Username" type="text" required value="<?php echo $userdetails['username']; ?>">
                        <div id="usernameError" class="invalid-feedback"></div>
                    </div> 

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="password" id="password" class="form-control" placeholder="Enter password" type="password" required>
                        <div id="passwordError" class="invalid-feedback"></div>
                    </div> 

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Login </button>
                    </div> 
                    <p class="text-center">Don't have an account?<a href="/views/Registration.php">Register</a> </p>
                </form>
            </article>
        </div> 

    </div>
    
    <script> 
        
        document.getElementById("username").addEventListener("keyup", validateUsername);
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

<?php include "partials/_footer.php";?>