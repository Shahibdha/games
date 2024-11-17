<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center py-5">
                    <div class="pb-5 pt-5 text-center">
                        <h6 class="mb-0 pb-3"><span>Log In</span><span>Sign Up</span></h6>
                        <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
                        <label for="reg-log"></label>
                        <div class="card-3d-wrap mx-auto">
                            <div class="card-3d-wrapper">
                                
                                <!-- PHP Code for Login and Sign Up -->
                                <?php 
                                session_start();
                                $con = mysqli_connect("localhost", "root", "", "game");

                                // Handle Login Form Submission
                                if(isset($_POST["login_submit"])) {
                                    $userName = $_POST["logemail"];
                                    $password = $_POST["logpass"];
                                    
                                    $sql = "SELECT * FROM `user` WHERE `email`='$userName' AND `pass`='$password'";
                                    $results = mysqli_query($con, $sql);

                                    if(mysqli_num_rows($results) > 0) {
                                        $_SESSION["emailid"] = $userName;
                                        header("Location: level.php"); // Redirect after successful login
                                        exit;
                                    } else {
                                        echo "<script>alert('Invalid login credentials');</script>";
                                    }
                                }

                                // Handle Sign Up Form Submission
                                if(isset($_POST["signup_submit"])) {
                                    $username = $_POST["regname"];
                                    $emailid = $_POST["regemail"];
                                    $passid = $_POST["regpass"];

                                    $sql = "INSERT INTO `user`(`name`, `email`, `pass`) VALUES ('$username', '$emailid', '$passid')";
                                    
                                    if(mysqli_query($con, $sql)) {
                                        echo "<script>alert('Registration successful! Please log in.');</script>";
                                    } else {
                                        die("Error: " . mysqli_error($con));
                                    }
                                }
                                ?>

                                <!-- Login Card -->
                                <div class="card-front">
                                    <div class="center-wrap">
                                        <form method="POST" action="">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Log In</h4>
                                                <div class="form-group">
                                                    <input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off" required>
                                                    <i class="input-icon fas fa-at"></i>
                                                </div>    
                                                <div class="form-group mt-2">
                                                    <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off" required>
                                                    <i class="input-icon fas fa-lock"></i>
                                                </div>
                                                <button type="submit" name="login_submit" class="btn btn-primary mt-4">Log In</button>
                                                <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Sign Up Card -->
                                <div class="card-back">
                                    <div class="center-wrap">
                                        <form method="POST" action="">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Sign Up</h4>
                                                <div class="form-group">
                                                    <input type="text" name="regname" class="form-style" placeholder="Your Full Name" id="regname" autocomplete="off" required>
                                                    <i class="input-icon fas fa-user"></i>
                                                </div>    
                                                <div class="form-group mt-2">
                                                    <input type="email" name="regemail" class="form-style" placeholder="Your Email" id="regemail" autocomplete="off" required>
                                                    <i class="input-icon fas fa-at"></i>
                                                </div>    
                                                <div class="form-group mt-2">
                                                    <input type="password" name="regpass" class="form-style" placeholder="Your Password" id="regpass" autocomplete="off" required>
                                                    <i class="input-icon fas fa-lock"></i>
                                                </div>
                                                <button type="submit" name="signup_submit" class="btn btn-primary mt-4">Sign Up</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
