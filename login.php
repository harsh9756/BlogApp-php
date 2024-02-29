<?php include "assets/header.php" ?>
<?php include "config/database.php" ?>
<?php 
session_start();
    $msg=false;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $btn=$_POST['button'];
        if($btn=='login'){
            $name=$_POST['username'];
            $pass=$_POST['password'];
            $check=mysqli_query($conn,"select * from user where username='$name' and password ='$pass'");
            $rows=mysqli_num_rows($check);
            $res=mysqli_fetch_assoc($check);
            if($rows){
                $_SESSION['user_id']=$res['user_id'];
                header("Location:profile.php");
            }
            else{
                $msg="<p class='bg-danger text-light p-2'>Invalid Username or Password </p>";
            }
        }
        else{
            $name=$_POST['name'];
            $email=$_POST['email'];
            $username=$_POST['username'];
            $pass=$_POST['password'];
            $confpassword=$_POST['confpassword'];
            if($pass==$confpassword){
                mysqli_query($conn,"insert into user(name, email, username, password) VALUES ('$name','$email','$username','$pass')");
                header("Location:profile.php?data=$name");
            }
            else{
                $msg="<p class='bg-danger text-light p-2'>Password does not match! </p>";

            }
        }
    }
?>
<div class="container mt-5">
    <?php echo $msg?$msg:" ";
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#login" data-bs-toggle="tab">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#signup" data-bs-toggle="tab">Signup</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input required type="text" autocomplete="off" class="form-control" name="username">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input required type="password" autocomplete="off" class="form-control" name="password" >
                                </div>
                                <button name="button" value="login" type="submit" class="btn btn-primary">Login</button>
                                <br>
                                <a href="/resetPass/">Forgot Password? Reset</a>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="signup">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input required type="text" autocomplete="off" class="form-control" name="name" >
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input required type="email" autocomplete="off" class="form-control" name="email" aria-describedby="email-help"
                                        >
                                    <div class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input required type="text" autocomplete="off" class="form-control" name="username" >
                                </div>
                                <div class="mb-3">
                                    <label for="new-password" class="form-label">Password</label>
                                    <input required type="password" autocomplete="off" class="form-control" name="password" >
                                </div>
                                <div class="mb-3">
                                    <label for="confpassword" class="form-label">Confirm Password</label>
                                    <input required type="password" autocomplete="off" class="form-control" name="confpassword" >
                                </div>
                                <button name="button" value="signup" type="submit" class="btn btn-primary">Sign UP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "assets/footer.php" ?>
