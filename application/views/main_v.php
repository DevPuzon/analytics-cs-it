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

  	<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  	<!-- iCheck -->
  	<link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  	
  	<!-- Theme style -->
  	<link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  	<link rel="stylesheet" href="assets/css/main.min.css">
	<link rel="stylesheet" href="assets/plugins/confirm/css/jquery-confirm.css"/>


	<title>EARIST | <?=$title;?></title>

</head>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open" style="height: auto;">

	<div class="wrapper">

		<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
			
			<ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		      </li>

		      
		    </ul>

		    <ul class="navbar-nav ml-auto">
		    	
		      	<li class="nav-item d-none d-sm-inline-block pull-right">

		        	<a href="logout" class="nav-link">Log Out</a>
		      	</li>	

		    </ul>

		</nav>

		<aside class="main-sidebar elevation-4 sidebar-light-danger">
	    <!-- Brand Logo -->
		    <a href="/" class="brand-link navbar-danger">
		      <img src="assets/images/earist-logo-circle.png" alt="EARIST Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		      <span class="brand-text font-weight-light">EARIST</span>
		    </a>

		    <div class="sidebar">
	      <!-- Sidebar user panel (optional) -->
		      	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		        	<!-- <div class="image">
		          		<img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
		        	</div> -->
		        	<div class="info">
		          		<a href="#" class="d-block">User Logged In</a>
		        	</div>
		        </div>

	        	<nav class="mt-2">
			        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			          
			          	<li class="nav-item">
			            	<a href="dashboard" class="nav-link">
			              		<i class="nav-icon fas fa-tachometer-alt"></i>
				              	<p> Analytics Dashboard </p>
			            	</a>
			        
				        </li>

				        <li class="nav-item has-treeview">
			            	<a href="#" class="nav-link">
			              		<i class="nav-icon fas fa-users"></i>
				              	<p>
									Students
				                	<i class="right fas fa-angle-left"></i>
				              	</p>
			            	</a>
			            
				            <ul class="nav nav-treeview">
				              <li class="nav-item">
				                <a href="comscie" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>ComScie List</p>
				                </a>
				              </li>
				              <li class="nav-item">
				                <a href="it" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p> I.T. List</p>
				                </a>
				              </li>
				              
				            </ul>
				        </li>

				        <li class="nav-item has-treeview" hidden>
			            	<a href="#" class="nav-link">
			              		<i class="nav-icon fas fa-user-tag"></i>
				              	<p>
				                	Grade
				                	<i class="right fas fa-angle-left"></i>
				              	</p>
			            	</a>
			            
				            <ul class="nav nav-treeview">
				              <li class="nav-item">
				                <a href="performer" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>Top Performer</p>
				                </a>
				              </li>

				             
							  <li class="nav-item">
				                <a href="incomplete" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>Incomplete</p>
				                </a>
				              </li>
							  <li class="nav-item">
				                <a href="failed" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>Failed</p>
				                </a>
				              </li>
				            </ul>
				        </li>

                        <li class="nav-item has-treeview">
			            	<a href="#" class="nav-link">
			              		<i class="nav-icon fas fa-cog"></i>
				              	<p>
				                	Maintenance
				                	<i class="right fas fa-angle-left"></i>
				              	</p>
			            	</a>
			            
				            <ul class="nav nav-treeview">
				              <li class="nav-item">
				                <a href="accounts" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>Accounts</p>
				                </a>
				              </li>

				              <li class="nav-item" hidden>
				                <a href="students" class="nav-link">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>Students</p>
				                </a>
				              </li>
				            </ul>
				        </li>
			        </ul>
			    </nav>

		    </div>
		</aside>

		<div class="content-wrapper" style="min-height: 1416.81px;">
    
		    <section class="content-header">
		      	<div class="container-fluid">
		        	<div class="row mb-2">
		          		<div class="col-sm-12">
		            		<h1><?=$title;?></h1>
		          		</div>
		        	</div>
		      	</div>
		    </section>

    		<section class="content">

      			<div class="container-fluid">
	        		<?=$module;?>
      			</div>

    		</section>

  		</div>

      	<footer class="main-footer">
		    <strong>EARIST &copy; 2022
		    All rights reserved.
		    <div class="float-right d-none d-sm-inline-block">
		      <b>Version</b> 1.0
		    </div>
		</footer>

	</div>
</body>
</html>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->

<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>


<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/datatables/jquery.dataTables.js"></script>

<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/confirm/js/jquery-confirm.js"></script>    

<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="assets/dist/js/adminlte.js"></script>
<script src="assets/js/scripts.js"></script>

 