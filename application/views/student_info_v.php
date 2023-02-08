<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
?>  
<div class="card">
    <div class="card-header">
        <input type="hidden" data-key="UniqueId" value="<?=$info['id'];?>">
        <input type="hidden" data-key="UniqueStudentNo" value="<?=$info['student_no'];?>">
        <input type="hidden" data-key="Course" value="<?=$info['course'];?>">
        <div class="d-flex justify-content-between">
            <h3 class="card-title"><i class="fa fa-user-edit"></i> Student Information</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <dl>
                    <dt>Student No</dt>
                    <dd><?=$info['student_no'];?></dd>
                </dl>
            </div>
            <div class="col-md-3">
                <dl>
                    <dt>Course</dt>
                    <dd> <?php echo $info['course'] == "cs" ? "Computer Science" : "Information Technology"?></dd>
                </dl>
            </div>

            <div class="col-md-3">
                <dl>
                    <dt>Year & Section</dt>
                    <dd>  <?=YEARLEVEL[$info["year_level"]];?> / <?=$info['section'];?></dd>
                </dl>
            </div>

            <div class="col-md-3">
                <dl>
                    <dt>Status</dt>
                    <dd> <?=($info['status'] != "" ? STUDENTSTAT[$info['status']] : "-");?> </dd>
                </dl>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <dl>
                    <dt>Name</dt>
                    <dd> <?php echo ucwords(strtolower($info['last_name'].", ".$info['first_name']." ".$info['middle_name']));?></dd>
                </dl>
            </div>
            <div class="col-md-3">
                <dl>
                    <dt>Email</dt>
                    <dd> <?=$info['email'];?></dd>
                </dl>
            </div>
        </div>
    </div> 
</div>