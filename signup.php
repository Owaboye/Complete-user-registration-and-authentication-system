<?php require_once 'db.php' ?>
<?php require_once 'functions.php' ?>
<?php 
if(isLoggedIn()){
  $page = 'admin/dashboard.php';
  header('Location: '.$page);
}

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $errors = [];
        if(!required($_POST['name'])){
            $errors['name'] = 'The name field is required';
        }else{
          $name = postVal($_POST['name']);
        }

        $check = check($_POST['email']);

        if(!required($_POST['email'])){
            $errors['email'] = 'The email field is required';
        }elseif(!email($_POST['email'])){
            $errors['email'] = 'The invalid email '.$_POST['email'];
        }elseif ($check) {
          $errors['email'] = 'User already exist ';
        }else{
          $email = postVal($_POST['email']);
        }

        if(!required($_POST['password'])){
            $errors['password'] = 'The password field is required';
        }elseif(!password($_POST['password'])){
          $errors['password'] = 'Password must be minimum of 8 characters, atleast one upercase, digit, and one of !@#$%^&*';
        }else{
          $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if(!required($_POST['date_of_birth'])){
            $errors['date_of_birth'] = 'The date of birth field is required';
        }else{
            $dob = $_POST['date_of_birth'];
        }

        if(empty($errors)){
          try {
            $sql = "INSERT INTO users (name, email, password, dob) VALUES(:name, :email, :password, :dob)";
            $stmt = $db->prepare($sql);
            $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, ':dob' => $dob]);
            if($db->lastInsertId()){
              setMessage('Registration was successful. Please, login');
              header('Location: login.php');
            }
          } catch (PDOException $e) {
            echo $e->getMessage();
          }

        }
    }
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Birthday Reminder</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->

    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Favicons -->
    <meta name="theme-color" content="#712cf9">
   
    <!-- Custom styles for this template -->
    <link href="heroes.css" rel="stylesheet">
  </head>
  <body>

<main>

  <!-- <div class="b-example-divider"></div> -->

  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <!-- <div class="col-lg-7 text-center text-lg-start">
       
      </div> -->
      <div class="col-md-10 mx-auto col-lg-8">
        <h1 class="display-5 fw-bold lh-1 text-body-emphasis mb-3">Signup</h1>
        <p class="col-lg-10 fs-4">Please, fill all the information as required</p>
        <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" action="" method="post">
         <div class="form-floating mb-3">
            <input type="text" name="name" value="<?= $name ?? '' ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Your Name</label>
            <?php if(isset($errors['name'])): ?>
                <div class="text-danger"><?= $errors['name'] ?? '' ?></div>
            <?php endif; ?>
          </div> 
          <div class="form-floating mb-3">
            <input type="date" name="date_of_birth" value="<?= $dob ?? '' ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Date of Birth</label>
            <?php if(isset($errors['date_of_birth'])): ?>
                <small class="text-danger"><?= $errors['date_of_birth'] ?? '' ?></small>
            <?php endif; ?>
          </div> 
          <div class="form-floating mb-3">
            <input type="email" name="email" value="<?= $email ?? '' ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
            <?php if(isset($errors['email'])): ?>
                <div class="text-danger"><?= $errors['email'] ?? '' ?></div>
            <?php endif; ?>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
            <?php if(isset($errors['password'])): ?>
                <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
            <?php endif; ?>
          </div>
          <!-- <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div> -->
          <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
          <hr class="my-4">
          <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
          <hr class="my-4">
          <small class="text-body-secondary">Already have an account? <a href="login.php">Sign in</a></small>
         | <small class="text-body-secondary">Back? <a href="index.php">Home</a></small>
        </form>
        
      </div>
    </div>
  </div>

  <!-- <div class="b-example-divider mb-0"></div> -->
</main>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script> -->
      
  </body>
</html>
