<?php
session_start();
include("../controllers/Auth.php");

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (Auth::isLogin()) {
    header('Location: ' . "./Courses.php");
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

<?php include 'partials/_header.php' ?>

<body>
    <div class="container d-flex flex-column justify-content-center align-items-center" >
        <?php include "partials/_alerts.php" ?>
        <h2 class="text-center text-dark my-4">Welcome to Learning Management System</h2>
        <div class="card bg-light h-75 w-75 bg-dark text-light">
            <article class="card-body mx-auto d-flex flex-column w-50 justify-content-center">
                <h4 class="card-title mt-3 text-center">Log in to Account</h4>

                <?php if (isset($success)) : ?>
                    <p class="text-center" style="color: green;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>

                <form id="loginform" class="" action="../controllers/LoginController.php" method="post">
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
                    <?php if (isset($error_message)) : ?>
                        <p class="text-center" style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Login </button>
                    </div>
                    <p class="text-center">Don't have an account?<a href="/views/Registration.php">Register</a> </p>
                </form>
            </article>
        </div>
    </div>


    <script src="../scripts/login.js">
       
    </script>

    <?php include "partials/_footer.php"; ?>