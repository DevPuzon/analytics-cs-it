<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge"><meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="icon" href="assets/images/earist_icon_32x32.png" type="image/png" sizes="32x32">

  	<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  	<!-- Tempusdominus Bbootstrap 4 -->
  	<link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  	<!-- iCheck -->
  	<link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  	<link rel="stylesheet" href="assets/css/main.min.css">

</head>
<body class="hold-transition login-page" style="overflow: hidden;">

	<div class="login-box">
      	<div class="login-logo">
        	<a href="/">
        		<img src="assets/images/earist-logo-circle.png" alt="AdminLTE Logo" class="brand-image elevation-3 img-circle" style="opacity: .8">
        	</a>
      	</div>
      <!-- /.login-logo -->
      	<div class="card">
        	<div class="card-body login-card-body">
    	      	<p class="login-box-msg">Sign in to start your session</p>

    	      	<form>
    	        	<div class="input-group mb-3">
    	      			<input type="text" class="form-control" placeholder="Username" data-key='UserUname'>
    	      			<div class="input-group-append">
    	        			<div class="input-group-text">
    	          				<span class="fas fa-user"></span>
    	        			</div>
    	      			</div>
    	    		</div>
    	    		<div class="input-group mb-3">

          				<input type="password" class="form-control" placeholder="Password" data-key='UserPword'>
          				<div class="input-group-append">
            				<div class="input-group-text">
              					<span class="fas fa-lock"></span>
            				</div>
          				</div>
    				</div>
                    <button class="btn btn-primary" style="width: 100%;" data-action="login">Login</button>
    	    	</form>
      		</div>
    	</div>
    </div>
</body>
</html>


<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->

<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/dist/js/adminlte.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/login.js"></script>