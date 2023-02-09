<input type="hidden" data-key="NoCs" value="<?=(isset($counts['cs']) ? $counts['cs'] : 0);?>">
<input type="hidden" data-key="NoIt" value="<?=(isset($counts['it']) ? $counts['it'] : 0);?>">
<div class="row">
    <div class="col-lg-6 col-6">
        <img class="img-fluid img-circle" src="assets/images/cas-logo.png" alt="CAS Logo" style="height: 80px; width: 80px;">
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-6">&nbsp;</div>
</div>
<div class="row"> 
    <div class="col-lg-6 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?=(isset($counts['cs']) ? $counts['cs'] : 0);?></h3>
                <p>Number of Students in Computer Science</p>
            </div>
            <div class="icon">
                <i class="ion ion-users"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?=(isset($counts['it']) ? $counts['it'] : 0);?></h3>
                <p>Number of Students in Information Technology</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <a href="<?php echo base_url()."dashboard-subjects";?>"
                style="text-decoration:none;color: #000;">
                    <div class="card card-hover"> 
                        <div class="card-body"  >
                            Subject Analytics
                        </div>  
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-12">
                <a href="<?php echo base_url()."dashboard-students";?>"
                style="text-decoration:none;color: #000;">
                    <div class="card card-hover"> 
                        <div class="card-body"  >
                            Student Analytics
                        </div>  
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-12">
                <a href="<?php echo base_url()."dashboard-top-performer-students";?>"
                style="text-decoration:none;color: #000;">
                    <div class="card card-hover"> 
                        <div class="card-body"  >
                            Top Performer Students Analytics
                        </div>  
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-12">
                <a href="<?php echo base_url()."dashboard-failed-students";?>"
                style="text-decoration:none;color: #000;">
                    <div class="card card-hover"> 
                        <div class="card-body"  >
                            Failed Students Analytics
                        </div>  
                    </div>
                </a>
            </div> 
            <div class="col-md-3 col-sm-12">
                <a href="<?php echo base_url()."dashboard-inc-students";?>"
                style="text-decoration:none;color: #000;">
                    <div class="card card-hover"> 
                        <div class="card-body"  >
                        Incomplete Grades Student Analytics
                        </div>  
                    </div>
                </a>
            </div>  
        </div>
    </div>
    <div class="col-12"> 
        <div class="row" id="home-dashboard"> 
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-6 col-6">

        <div class="card card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title"><i class="far fa-graph"></i> Analytics of Passing Grades - Computer Science</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span>Analytics of Passing Grades Computer Science</span>
                    </p>
                </div>

                <div class="position-relative mb-4">
                    <canvas id="passing-chart-cs" height="200"></canvas>
                </div>

                <div class="d-flex flex-row">
                    <span class="mr-2">
                    <i class="fas fa-square text-success"></i> First Semester
                    </span>

                    <span>
                    <i class="fas fa-square text-teal"></i> Second Semester
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-6">
        <div class="card card-success">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title"><i class="far fa-graph"></i> Analytics of Passing Grades - Information Technology</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span>Analytics of Passing Grades Information Technology</span>
                        </p>
                    </div>

                    <div class="position-relative mb-4">
                        <canvas id="passing-chart-it" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row">
                        <span class="mr-2">
                        <i class="fas fa-square text-success"></i> First Semester
                        </span>

                        <span>
                        <i class="fas fa-square text-teal"></i> Second Semester
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-6">

        <div class="card card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title"><i class="far fa-graph"></i> Analytics of Failing Grades - Computer Science</h3>
                </div>
            </div>
            <div class="card-body">

                <div class="position-relative mb-4">
                    <canvas id="failing-chart-cs" height="200"></canvas>
                </div>

                <div class="d-flex flex-row">
                    <span class="mr-2">
                    <i class="fas fa-square text-success"></i> First Semester
                    </span>

                    <span>
                    <i class="fas fa-square text-teal"></i> Second Semester
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-6">

        <div class="card card-success">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title"><i class="far fa-graph"></i> Analytics of Failing Grades - Information Technology</h3>
                </div>
            </div>
            <div class="card-body">

                <div class="position-relative mb-4">
                    <canvas id="failing-chart-it" height="200"></canvas>
                </div>

                <div class="d-flex flex-row">
                    <span class="mr-2">
                    <i class="fas fa-square text-success"></i> First Semester
                    </span>

                    <span>
                    <i class="fas fa-square text-teal"></i> Second Semester
                    </span>
                </div>
            </div>
        </div>
    </div>

</div> -->

<script src="assets/plugins/jquery/jquery.min.3.6.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- <script src="assets/plugins/chart.js/Chart.min.js"></script> -->
<script src="assets/plugins/chartjs.js/chartjs.js"></script> 
<script src="assets/plugins/chartjs.js/chatjs-plugins-labels.js"></script>  
<script src="assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>

<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>

<script src="assets/js/home.js"></script>
<style>
    .card-hover:hover{
        background: #007BFF;
        color:#fff;
    } 
</style>
<script>
 

</script>