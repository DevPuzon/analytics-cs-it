 
function calc (){
    // let datasets = [];
    // let datalabels = [];
    // for(let i = 50; i < 101 ;i++){
    // 	let a = [];
    // 	for(let x = 10 ; x < 100; x++){
    // 		a.push(parseFloat(`${i}.${x}`));
    // 	}
    // 	datasets.push(a);
    // 	datalabels.push(i);
    // } 
    
    return new Promise(async (resolve)=>{
        const res = await fetch("assets/model.json", {
        "headers": {
            "accept": "*/*", 
            "x-requested-with": "XMLHttpRequest"
        }, 
        "method": "POST" 
        });
        let data = JSON.parse(await res.text());
        resolve({datasets:data.datasets,labels:data.labels});
    }) 
}

let k = 1;
async function generate(){ 
    let {datasets,labels} = await calc();
    let data = [];
    console.log(datasets,labels);
    var i =0;
    for(let label of labels){
        console.log(label,i);
        for(let set of datasets[i]){
            data.push({
                x: label,
                y: set
            })
        }
        i++
    }
    console.log(data);
    let datasets1 =  [
        {
            label: 'Scatter Dataset',
            data: data,
            backgroundColor: '#DD1C5E'
        }
    ]
    let test_dataset=[]; 
    let in_test_datasets = document.getElementById("test_datasets").value;
    if(in_test_datasets){  
        test_dataset = in_test_datasets.trim().replace(" ","").split(",");
        test_dataset = test_dataset.map((el)=>{
            return parseFloat(el);
        })
    }
    
    let set_k_val = document.getElementById("set_k").value;
    if(set_k_val){
        set_k_val = parseInt(set_k_val);
        k = set_k_val;
        var accuracy_list = []; 
        for(let i = 1 ; i < 100 ; i ++){
            let pred_b = await predictOutput([i],k); 
            let pred_c = (100/pred_b)*i;
            let accuracy = pred_c;
            if(pred_c > 100){
                accuracy = 100-(pred_c-100);
            }else
            console.log('accuracy',accuracy,pred_c);
            if(isFinite(accuracy)){ 
                accuracy_list.push(accuracy); 
            }
        }
        console.log('accuracy_list',accuracy_list);
        let k_accuracy = document.getElementById("k_accuracy");
        k_accuracy.innerText ="Accuracy: "+ accuracy_list.reduce((a, b) => a + b, 0) / accuracy_list.length +"%";
    }

    if(test_dataset.length > 0){
        let data1 = [];
        for(let set of test_dataset){
            data1.push({
                x: set,
                y: await predictOutput([set],k)
            })
        }
        datasets1.push(
            {
                label: 'Test Dataset',
                data: data1,
                backgroundColor: '#1F8EE7'
            }
        ) 
        let pred = await predictOutput(test_dataset,k);
        document.getElementById("predict-output").innerText = "Predicted: "+pred;
    } 
    let ctxid = makeid();
    $("#canvas_container").html(`<canvas id="${ctxid}" style=" height: 70vh; "></canvas>`);
    new Chart(ctxid, {
        type: 'scatter',
        data: {
            datasets:datasets1,
        },
        // options: {
        // scales: {
        //     x: {
        //     type: 'linear',
        //     position: 'bottom'
        //     }
        //     }
        // }
        options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Dashboard Model'
              }
            }
          }
    })  
}

generate();





function makeid(length=3) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}