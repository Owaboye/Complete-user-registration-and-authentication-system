<?php 
require_once 'partials/header.php'; 
$id = $_SESSION['id'];
$user = find('users', 'id', $id);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
        // dd($_POST);
        // die();
    $errors = [];
    
    if(!required($_POST['name'])){
        $errors['name'] = 'The name field is required';
    }else{
      $name = postVal($_POST['name']);
    }

    if(!required($_POST['date_of_birth'])){
        $errors['date_of_birth'] = 'The date of birth field is required';
    }else{
        $dob = $_POST['date_of_birth']; //date('Y m j', strtotime($_POST['date_of_birth']));
    }

    if(!required($_POST['email'])){
        $errors['email'] = 'The email field is required';
    }elseif(!email($_POST['email'])){
        $errors['email'] = 'The invalid email '.$_POST['email'];
    }else{
      $email = postVal($_POST['email']);
    }

    if(empty($errors)){
      try {
        $sql = "UPDATE users SET name = :name, email = :email, dob = :dob WHERE id = :id";
        $stmt = $db->prepare($sql);
        // $stmt->bindvalue(':name' => $name);
        // $stmt->bindvalue(':email', $email);
        // $stmt->bindvalue(':dob', $dob);
        // $stmt->bindvalue(':id', $user->id);
        $stmt->execute([':name' => $name, ':email' => $email, ':dob' => $dob, ':id' => $id]);
        if($stmt->rowCount() == 1){
            setMessage('Record updated successfully');
            header('Location: profile.php');
            
        }else{
            $msg = 'No change was made';
        }
        
      } catch (PDOException $e) {
        echo $e->getMessage();
      }

    }
}

if(isset($_POST['upload'])){
    $path = 'assets/images/';
    $errors = [];
    $tmpName = $_FILES['file']['tmp_name'];
    $file = pathinfo($_FILES['file']['name']);
    $ext = ['jpg', 'jpeg', 'png',];
    if(empty($tmpName)){
        $errors['file'] = 'This field is empty';
    }elseif(!in_array($file['extension'], $ext)){
        $errors['file'] = 'Invalid file uploaded';
    }else{
        $img = date('Ymd').'_'.$file['basename'];
        if(!move_uploaded_file($tmpName, $path.$img)){
            $errors['file'] = 'IUplod faied. Try again';
        }
    }
    if(empty($errors)){
       
        $sql = "UPDATE users SET img = :img WHERE id = :id";
        $stmt = $db->prepare($sql);
        
        $stmt->execute([':img' => $img, ':id' => $id]);
        if($stmt->rowCount() == 1){
            setMessage('Record updated successfully');
            header('Location: profile.php');
            
        }else{
            $msg = 'No change was made';
        }
       
    //$fileType = $file);
    }
}

?>
 <main>
    <div class="container-fluid px-4">
       
        <div class="row justify-content-center">
        <div class="col-lg-3">
        <?php
            setMessage();

            if(isset($msg)): 
        ?>
            <div class="alert alert-danger"> <?= $msg ?? ''; ?> </div>
            <?php endif;
            ?>
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Profile Pic</h3></div>
                <div class="card-body text-center">
                    <img style="width: 70px; heght: 70px; border-radius: 50%;" src="assets/images/<?= $user->img ?? 'user.png' ?>" alt="">
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="card-footer text-center py-3">
                <div class="form-group mb-3 mb-md-0">
                    <input type="file" class="form-control" name="file"  id="file" type="text" />
                    
                </div>
                    <div class="small mt-3"><button name="upload" type="submit" class="btn btn-primary">Upload</button></div>
                </div>
                </form>
            </div>
            </div>
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Profile</h3></div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" name="name" value="<?= $user->name ?? '' ?>" id="inputFirstName" type="text" placeholder="Enter your first name" />
                                        <label for="inputFirstName">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" name="date_of_birth" value="<?= date('j M Y', strtotime($user->dob)) ?? '' ?>" id="date_of_birth" type="text" />
                                        <label for="inputLastName">Date of Birth</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="email"  value="<?= $user->email ?? "" ?>" id="inputEmail" type="email" placeholder="name@example.com" />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <!-- <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" />
                                        <label for="inputPassword">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" />
                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button name="update" class="btn btn-primary btn-block" type="submit">Update</button></div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="card-footer text-center py-3">
                        <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    
</main>

<?php 
require_once 'partials/footer.php'; 
?>

