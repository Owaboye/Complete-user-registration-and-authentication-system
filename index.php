<?php require_once 'functions.php' ?>
<?php 
if(isLoggedIn()){
  $page = 'admin/dashboard.php';
  header('Location: '.$page);
}

?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete User Registration & Authentication System</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->

    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Favicons -->
    <meta name="theme-color" content="#712cf9">
  </head>
  <body>

<main>
<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="admin/assets/images/hero.svg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Registration & Authentication System</h1>
        <p class="lead">Complete user registration and authentication system is built using PHP, MYSQL, and Bootstrap.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <a href="login.php" class="btn btn-primary btn-lg px-4 me-md-2">Login</a>
          <a href="signup.php" class="btn btn-outline-secondary btn-lg px-4">Sign Up</a>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="b-example-divider mb-0"></div> -->
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
      
  </body>
</html>
