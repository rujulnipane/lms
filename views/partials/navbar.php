<?php
session_start();
$user = $_SESSION["username"];
?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-space-between">
      <a class="navbar-brand" href="Courses.php">LMS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">Welcome <?=$user?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../controllers/Logout.php">Logout</a>
          </li>
        </ul>
      </div>
      <!-- <form class="d-flex">
        <input class="form-control me-2 mx-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    </div>
  </nav>
