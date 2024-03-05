<?php
$file = "../config.php";
if(file_exists($file)){
    // header('Location: '. "./Login.php");  
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


<div class="card bg-dark text-light vh-100 d-flex align-items-center">
            <article class="card-body mx-auto" style="width: 50%;">
                <h4 class="card-title mt-3 text-center">Installation</h4>
                <p class="text-center">Welcome to the LMS Platform</p>
                <p class="text-center">Fill the Admin and Database Details to Get Started</p>
                <form id="registrationForm" action="../controllers/installation.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" id="name" class="form-control" placeholder="Enter Admin User Name" type="text" required value="<?php echo $userdetails['username']; ?>">
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
                        <input name="dbuser" id="dbuser" class="form-control" placeholder="Enter Database User Name" type="text" required>
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
                        <input name="dbname" id="dbname" class="form-control" placeholder="Enter Database Name" type="text" required>
                        <div id="dbuserErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Proceed </button>
                    </div> 
                </form>
            </article>
        </div>
  

        <script src="../scripts/admin.js">
  
</script>

<?php include "partials/_footer.php";?>