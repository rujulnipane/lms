<?php
session_start();
if (!file_exists("../config.php")) {
    header('Location: ' . "./adminReg.php");
    exit;
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

<?php include 'partials/_header.php' ?>

<body>

    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">

        <?php include 'partials/_alerts.php' ?>
        <h2 class="text-center text-dark my-4">Welcome to Learning Management System</h2>
        <div class="card bg-light h-75 w-75 bg-dark text-light">
            <article class="card-body mx-auto d-flex flex-column w-50 justify-content-center" style="width: 50%;">
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
                    <?php if (isset($error_message)) : ?>
                        <p class="text-center" style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Create Account </button>
                    </div> <!-- form-group// -->
                    <p class="text-center">Have an account? <a href="./Login.php">Log In</a> </p>
                </form>
            </article>
        </div>

    </div>

    <script src="../scripts/registration.js">

    </script>

    <?php include "partials/_footer.php"; ?>