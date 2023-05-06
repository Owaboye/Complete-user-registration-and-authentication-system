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

        if(!required($_POST['password'])){
            $errors['password'] = 'The password field is required';
        }elseif(!password($_POST['password'])){
          $errors['password'] = 'Password must be minimum of 8 characters, atleast one upercase, digit, and one of !@#$%^&*';
        }else{
          $password = $_POST['password'];
        }

        

        if(empty($errors)){
          try {
            if(login($email, $password)){
              
              header('Location: admin/dashboard.php');
              
            }else{
              $wrongCredentials = "Wrong crendentials";
              //dd(check($email));
            }
            
          } catch (PDOException $e) {
            echo $e->getMessage();
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
  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
   
     
      <div class="col-md-10 mx-auto col-lg-8">
      
      <?php setMessage(); ?>
        <h1 class="display-5 fw-bold text-body-emphasis mb-3">Sign in</h1>
       
      
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
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
            <?php if(isset($errors['password'])): ?>
                <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
            <?php endif; ?>
          </div>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
          <hr class="my-4">
          <small class="text-body-secondary"> <a href="forgotpass.php">Forgot Password</a></small>
          
          <hr class="my-4">
          <small class="text-body-secondary">Don't have an account? <a href="signup.php">Sign up</a></small>
          | <small class="text-body-secondary">Back? <a href="index.php">Home</a></small>
        </form>
      </div>
    </div>
  </div>

  <!-- <div class="b-example-divider mb-0"></div> -->
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
      
  </body>
</html>
