
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
 

<script src="assets/js/knn-library.js"></script> 
<script>
// function calc (){
// 	let a = []; 
// 	for(let i = 50; i <65;i++ ){
// 		a.push(i);
// 	}
// 	let b = []; 
// 	for(let i = 65; i <70;i++ ){
// 		b.push(i);
// 	}
// 	let c = []; 
// 	for(let i = 70; i <80;i++ ){
// 		c.push(i);
// 	}
// 	let d = []; 
// 	for(let i = 80; i <100;i++ ){
// 		d.push(i);
// 	}
// 	return {datasets:[a,b,c,d],labels:[4,3,2,1]};
// }

// function calc (){
// 	// let datasets = [];
// 	// let datalabels = [];
// 	// for(let i = 50; i < 101 ;i++){
// 	// 	let a = [];
// 	// 	for(let x = 10 ; x < 100; x++){
// 	// 		a.push(parseFloat(`${i}.${x}`));
// 	// 	}
// 	// 	datasets.push(a);
// 	// 	datalabels.push(i);
// 	// } 
	
// 	return new Promise(async (resolve)=>{
// 		const res = await fetch("assets/model.json", {
// 		"headers": {
// 			"accept": "*/*", 
// 			"x-requested-with": "XMLHttpRequest"
// 		}, 
// 		"method": "POST" 
// 		});
// 		let data = JSON.parse(await res.text());
// 		console.log(data);
// 		resolve({datasets:data.datasets,labels:data.labels});
// 	}) 
// }

// async function predictOutput(prod_datasets){
	
// 	var {datasets,labels} = await calc(); 
// 	var knn = new KNN(datasets, labels, { k: 1 } ) 

// 	// var test_dataset = [
// 	// [75]
// 	// ];

//     console.log("predictOutput",prod_datasets);
// 	return await knn.predict(prod_datasets); 
// }  
// console.log(predictOutput([75,57,90,100]));
</script>
<script src="assets/plugins/chartjs.js/chartjs.js"></script> 
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script> -->
<div class="row">
	<div class="col-md-5" id="main-list"> 

		<div class="card">
			<div class="card-header">

				<div class="d-flex justify-content-between">
	                <h3 class="card-title"><i class="fa fa-list"></i> List</h3> 
	            </div>
	        </div>
	 		<div class="card-body">
	    		<div class="row">
					
					<div class="col-md-2">
						<div class="form-group">
							<label for="">Course</label>
							<select class="form-control form-control-sm" id="txtCourseType">
								<option value = ''>All</option> 
								<option value = 'cs'>CS</option> 
								<option value = 'it'>IT</option> 
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label for="">Year Level</label>
							<select class="form-control form-control-sm" id="selYear">
								<option value = ''></option>
								<?php
									foreach(YEARLEVEL as $level => $year) {
								?>
										<option value = "<?=$level;?>"><?=$year;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label for="">Semester</label>
							<select class="form-control form-control-sm" id="selSem">
								<option value=''></option>
								<option value='sem_one'>1st Semester</option>
								<option value='sem_two'>2nd Semester</option>
							</select>
						</div>
					</div>


					<div class="col-md-2">
						<div class="form-group">
							<label for="">Section</label>
							<select class="form-control form-control-sm" id="selSection">
								<option value=''></option>
								<option value='A'>A</option>
								<option value='B'>B</option>
								<option value='C'>C</option>
								<option value='D'>D</option>
								<option value='E'>E</option>	
							</select>
						</div>
					</div>


					<div class="col-md-2">
						<div class="form-group">
							<label for="">Status</label>
							
							<select class="form-control form-control-sm" data="req" id="selStatus">
								<option value = ''></option>
								<?php
									foreach(STUDENTSTAT as $stat => $status) {
								?>
										<option value = "<?=$stat;?>"><?=$status;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Academic Year</label>
                            
							<select class="form-control form-control-sm" data="req" id="AcademicYear">
								<option value = ''></option>
							
								<option value = '2020-2021'>2020-2021</option> 
								<option value = '2021-2022'>2021-2022</option> 
								<option value = '2022-2023'>2022-2023</option> 
								<option value = '2023-2024'>2023-2024</option> 
								<option value = '2024-2025'>2024-2025</option> 
								<option value = '2025-2026'>2025-2026</option> 
								<option value = '2026-2027'>2026-2027</option> 
							</select>
                        </div>
                    </div>
                    <div class="col-md-3"> 
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="show-prediction"
								
							onchange="_studentAnalytics()">
							<label class="form-check-label" for="show-prediction" >Show Prediction</label>
						</div>
                    </div> 

					<div class="col-md-12 mb-3">
						<div class="row">
							<div class="col-auto">
								<button type="button" class="btn btn-sm btn-outline-primary" data-trigger="filter" >
									<i class="fas fa-filter"></i> Filter
								</button>
							</div>
							<div class="col-auto">
								<button type="button" class="btn btn-sm btn-outline-primary" data-trigger="print" >
									<i class="fas fa-print"></i> Print
								</button>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" id="divData"></div>
	        	</div>
	        </div>
	    </div>
	</div>
	
	<div class="col-md-7"> 
		<div id="student_info">  
		</div>  
		<div id="accordion-dashboard-top-performer-students">  
		</div>  
		<div id="accordion-dashboard-students">  
		</div>  
 	</div>
	 
</div> 
  

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/dashboard-top-performer-students.js"></script>