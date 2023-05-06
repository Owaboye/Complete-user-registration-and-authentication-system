<?php require_once 'functions.php' ?>
<?php 
if(isLoggedIn()){
  $page = 'admin/dashboard.php';
  header('Location: '.$page);
}

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $errors = [];
        if(!required($_POST['email'])){
            $errors['email'] = 'The email field is required';
        }elseif(!email($_POST['email'])){
            $errors['email'] = 'The invalid email '.$_POST['email'];
        }else{
          $email = postVal($_POST['email']);
        }

        if(empty($errors)){
            $user = check($email);
            if($user){
                //To do
                //Send email to reset password
                setMessage('Please, reset your password');
                $encrypt_key = base64_encode('P!@#$_'.$user->email);
                header('Location: reset-password.php?key='.$encrypt_key);
            //   dd($user);
            }else{
              $wrongCredentials = "Record not found";
            }
            
          
        }
    }
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Birthday Reminder</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->

    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Favicons -->
    <meta name="theme-color" content="#712cf9">
  </head>
  <body>

<main>

  <!-- <div class="b-example-divider"></div> -->

  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <?php setMessage(); ?>
        <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Password Recovery</h1>
        <p class="col-lg-10 fs-4">Enter your email address and we will send you a link to reset your password.</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5" method="post" action="">
      <?php 
          if(isset($wrongCredentials)): ?>
            <div class="alert alert-danger"> <?= $wrongCredentials; ?> </div>
        <?php endif; ?>
        <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" action="" method="post">
          <div class="form-floating mb-3">
            <input type="email" name="email" value="<?= $email ?? '' ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
            <?php if(isset($errors['email'])): ?>
                <small class="text-danger"><?= $errors['email'] ?? '' ?></small>
            <?php endif; ?>
          </div>
          
          <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="index.php">Return to login</a>
                <button type="submit" class="btn btn-primary">Reset Password</button>
          </div>
        
        </form>
      </div>
    </div>
  </div>

  <!-- <div class="b-example-divider mb-0"></div> -->
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
      
  </body>
</html>
