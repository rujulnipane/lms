<?php

if(isset($_SESSION['error'])){
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if(isset($_SESSION['success'])){
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

?>
<?php if (isset($error)) : ?>
  <div class="container d-flex justify-content-center mt-4">
    <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
        <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($success)) : ?>
  <div class="container d-flex justify-content-center mt-4">
    <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
        <?php echo htmlspecialchars($success); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

