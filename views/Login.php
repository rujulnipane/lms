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


<div class="container mt-3 vh-100">
    <div class="py-5 text-center">
        <!-- <img class="d-block mx-auto mb-4" src="/docs/4.3/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
        <h2>Welcome to Learning Management System</h2>
        <!-- <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p> -->
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7">
            <h4 class="mb-3 text-center">Enter User Details</h4>
            <?php if (isset($success)) : ?>
                    <p class="text-center" style="color: green;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
            <form id="loginform" class="" action="../controllers/LoginController.php" method="post">
                <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input name="username" id="username" type="text" class="form-control" placeholder="Enter Username" required value=<?php echo $userdetails['username']; ?>>
                        <div id="usernameError" class="invalid-feedback" style="width: 100%;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password">Password <span class="text-muted">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <input name="password" id="password" type="password" class="form-control" placeholder="Enter Password" required>
                        <div id="passwordError" class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <?php if (isset($error_message)) : ?>
                    <p class="text-center" style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                <p class="text-center">Don't have an account?<a href="registration.php">Register</a> </p>
            </form>
        </div>
    </div>
</div>


<script src="../scripts/login.js">

</script>

<?php include "partials/_footer.php"; ?>