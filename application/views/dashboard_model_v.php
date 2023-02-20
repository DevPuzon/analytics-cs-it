
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<script src="assets/plugins/chartjs.js/chartjs.js"></script> 
<script src="assets/js/knn-library.js"></script> 
<div class="row">
	<div class="col-md-12" >

		<div class="card" >
			<div class="card-header">

				<div class="d-flex justify-content-between"> 
	            </div>
	        </div>
	 		<div class="card-body">
				<div style="margin-bottom:15px"> 	
					<input type="text" id="set_k">
					<button onclick="generate()">Set K</button> 
					<h4 id="k_accuracy"></h4>
				</div>
				<div style="margin-bottom:15px"> 	
					<input type="text" id="test_datasets">
					<button onclick="generate()">Predict Grade</button>
					<h4 id="predict-output"></h4>
				</div>
				<div id="canvas_container"> 
					
				</div>
	        </div>
	    </div>
	</div>
	 
</div> 
  

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/model_dashboard.js"></script>