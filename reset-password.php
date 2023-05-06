<?php require_once 'functions.php' ?>
<?php 
if(isLoggedIn()){
  $page = 'admin/dashboard.php';
  header('Location: '.$page);
}
if(isset($_GET['key'])){
    $decode = base64_decode($_GET['key']);
    $decode = explode('_', $decode);
    //[$str $email] = list($decode);
    
    $user = check($decode[1]);
    if(!$user){
        $wrongCredentials = 'Invalid entry';
    }else{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
            $errors = [];
            
            if(!required($_POST['password'])){
                $errors['password'] = 'The password field is required';
            }elseif(!password($_POST['password'])){
              $errors['password'] = 'Password must be minimum of 8 characters, atleast one upercase, digit, and one of !@#$%^&*';
            }else{
              $password = $_POST['password'];
            }
    
            if(!required($_POST['confirm_password'])){
                $errors['confirm_password'] = 'The confirm password field is required';
            }elseif($password != $_POST['confirm_password']){
                $errors['confirm_password'] = 'Password does not match';
            }else{
                $con_password = $_POST['confirm_password'];
            }
    
            if(empty($errors)){
              try {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = :password WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindvalue(':password', $password_hash);
                $stmt->bindvalue(':id', $user->id);
                $stmt->execute();
                if($stmt->rowCount() == 1){
                    setMessage('Password changed successfully, Please login');
                    header('Location: login.php');
                    
                }
                
              } catch (PDOException $e) {
                echo $e->getMessage();
              }
    
            }
        }
    }
    
}else{
    header('Location: index.php');
}

   
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Completer User Registration and Authentication System</title>
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
      <div class="col-md-10 mx-auto col-lg-7" method="post" action="">
      <?php setMessage(); ?>
      <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Reset Password</h1>
      <?php 

          if(isset($wrongCredentials)): ?>
            <div class="alert alert-danger"> <?= $wrongCredentials; ?> </div>
        <?php endif; ?>
        <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" action="" method="post">
          
          <div class="form-floating mb-3">
            <input type="password" value="<?= $password ?? '' ?>" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">New Password</label>
            <?php if(isset($errors['password'])): ?>
                <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
            <?php endif; ?>
          </div>

          <div class="form-floating mb-3">
            <input type="password" value="<?= $con_password ?? '' ?>" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Confirm Password</label>
            <?php if(isset($errors['confirm_password'])): ?>
                <div class="text-danger"><?= $errors['confirm_password'] ?? '' ?></div>
            <?php endif; ?>
          </div>
          
          <button class="w-100 btn btn-lg btn-primary" type="submit">Reset Password</button>
          <hr class="my-4">
          <small class="text-body-secondary"> <a href="forgotpass.php">Forgot Password</a></small>
          
          <hr class="my-4">
          <small class="text-body-secondary">Don't have an account? <a href="signup.php">Sign up</a></small>
          <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
        </form>
      </div>
    </div>
  </div>

  <!-- <div class="b-example-divider mb-0"></div> -->
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
      
  </body>
</html>
