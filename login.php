<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from users where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{
                        
						$_SESSION['user_id'] = $user_data['user_id'];
                        if($user_data['role']=="admin")
                        {
                            header("Location: index.php");
						    die;
                        }
                        else
                        {
                            header("Location: frutika-master/index.html");
						    die;
                        }
						
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Log In | ADOPTH</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-start">
                                <span><img src="assets/images/logo-dark.png" alt="" height="18"></span>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0">Sign In</h4>
                        <p class="text-muted mb-4">Enter your username and password to access account.</p>

                        <!-- form -->
                        <form method="post">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Username</label>
                                <input class="form-control" type="text" id="emailaddress" required="" name="user_name" placeholder="Enter your username">
                            </div>
                            <div class="mb-3">
                                <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Forgot your password?</small></a>
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                            </div>
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In </button>
                            </div>
                            <!-- social-->
                            <div class="text-center mt-4">
                                <p class="text-muted font-16">Find us on</p>
                                <ul class="social-list list-inline mt-3">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">
                            <p class="text-muted">Don't have an account? <a href="signup.php" class="text-muted ms-1"><b>Sign Up</b></a></p>
                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <h2 class="mb-3">Get your pet now!</h2>
                    <p class="lead"><i class="mdi mdi-format-quote-open"></i> Save animals. Save the environment. <i class="mdi mdi-format-quote-close"></i>
                    </p>
                    <p>
                        - By ADOPTH
                    </p>
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>

    </body>

</html>