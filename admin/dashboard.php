<?php 
require_once 'partials/header.php'; 
?>
 <main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Welcome <strong><?= $_SESSION['role'] ?></strong></li>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <li class="breadcrumb-item active">View Your <a href="profile.php">Profile </a></li>
            <?php endif; ?>
        </ol>
        <?php 
         
         if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): 
            $users = all();
          require_once 'member.php';
          ?>
        <?php else: 
           $id = $_SESSION['id'];
           $user = find('users', 'id', $id); 
        ?>
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
                <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                <div class="card-footer text-center py-3">
                <!-- <div class="form-group mb-3 mb-md-0"> -->
                    <!-- <input type="file" class="form-control" name="file"  id="file" type="text" /> -->
                    
                <!-- </div> -->
                    <div class="small mt-1"><a href="profile.php" class="btn btn-primary">Edit</a></div>
                </div>
                <!-- </form> -->
            </div>
            </div>
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Profile</h3></div>
                    <div class="card-body">
                        
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" disabled name="name" value="<?= $user->name ?? '' ?>" id="inputFirstName" type="text" placeholder="Enter your first name" />
                                        <label for="inputFirstName">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" disabled name="date_of_birth" value="<?= date('j M Y', strtotime($user->dob)) ?? '' ?>" id="date_of_birth" type="text" />
                                        <label for="inputLastName">Date of Birth</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="email" disabled  value="<?= $user->email ?? "" ?>" id="inputEmail" type="email" placeholder="name@example.com" />
                                <label for="inputEmail">Email address</label>
                            </div>
                           
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><a href="profile.php" class="btn btn-primary btn-block" >Edit</a></div>
                            </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php 
require_once 'partials/footer.php'; 
?>

