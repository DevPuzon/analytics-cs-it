function squaredEuclidean(p, q) {
    let d = 0;
    for (let i = 0; i < p.length; i++) {
        d += (p[i] - q[i]) * (p[i] - q[i]);
    }
    return d;
}

function euclideanDistance(p, q) {
    return Math.sqrt(squaredEuclidean(p, q));
}

class Node {
    constructor(obj, dimension, parent) {
        this.obj = obj;
        this.left = null;
        this.right = null;
        this.parent = parent;
        this.dimension = dimension;
    }
}

class KDTree {
    constructor(points, metric) {
        // If points is not an array, assume we're loading a pre-built tree
        if (!Array.isArray(points)) {
            this.dimensions = points.dimensions;
            this.root = points;
            restoreParent(this.root);
        } else {
            this.dimensions = new Array(points[0].length);
            for (let i = 0; i < this.dimensions.length; i++) {
                this.dimensions[i] = i;
            }
            this.root = buildTree(points, 0, null, this.dimensions);
        }
        this.metric = metric;
    }

    // Convert to a JSON serializable structure; this just requires removing
    // the `parent` property
    toJSON() {
        const result = toJSONImpl(this.root, true);
        result.dimensions = this.dimensions;
        return result;
    }

    nearest(point, maxNodes, maxDistance) {
        const metric = this.metric;
        const dimensions = this.dimensions;
        let i;

        const bestNodes = new BinaryHeap((e) => -e[1]);

        function nearestSearch(node) {
            const dimension = dimensions[node.dimension];
            const ownDistance = metric(point, node.obj);
            const linearPoint = {};
            let bestChild, linearDistance, otherChild, i;

            function saveNode(node, distance) {
                bestNodes.push([node, distance]);
                if (bestNodes.size() > maxNodes) {
                    bestNodes.pop();
                }
            }

            for (i = 0; i < dimensions.length; i += 1) {
                if (i === node.dimension) {
                    linearPoint[dimensions[i]] = point[dimensions[i]];
                } else {
                    linearPoint[dimensions[i]] = node.obj[dimensions[i]];
                }
            }

            linearDistance = metric(linearPoint, node.obj);

            if (node.right === null && node.left === null) {
                if (bestNodes.size() < maxNodes || ownDistance < bestNodes.peek()[1]) {
                    saveNode(node, ownDistance);
                }
                return;
            }

            if (node.right === null) {
                bestChild = node.left;
            } else if (node.left === null) {
                bestChild = node.right;
            } else {
                if (point[dimension] < node.obj[dimension]) {
                    bestChild = node.left;
                } else {
                    bestChild = node.right;
                }
            }

            nearestSearch(bestChild);

            if (bestNodes.size() < maxNodes || ownDistance < bestNodes.peek()[1]) {
                saveNode(node, ownDistance);
            }

            if (
                bestNodes.size() < maxNodes ||
                Math.abs(linearDistance) < bestNodes.peek()[1]
            ) {
                if (bestChild === node.left) {
                    otherChild = node.right;
                } else {
                    otherChild = node.left;
                }
                if (otherChild !== null) {
                    nearestSearch(otherChild);
                }
            }
        }

        if (maxDistance) {
            for (i = 0; i < maxNodes; i += 1) {
                bestNodes.push([null, maxDistance]);
            }
        }

        if (this.root) {
            nearestSearch(this.root);
        }

        const result = [];
        for (i = 0; i < Math.min(maxNodes, bestNodes.content.length); i += 1) {
            if (bestNodes.content[i][0]) {
                result.push([bestNodes.content[i][0].obj, bestNodes.content[i][1]]);
            }
        }
        return result;
    }
}

function toJSONImpl(src) {
    const dest = new Node(src.obj, src.dimension, null);
    if (src.left) dest.left = toJSONImpl(src.left);
    if (src.right) dest.right = toJSONImpl(src.right);
    return dest;
}

function buildTree(points, depth, parent, dimensions) {
    const dim = depth % dimensions.length;

    if (points.length === 0) {
        return null;
    }
    if (points.length === 1) {
        return new Node(points[0], dim, parent);
    }

    points.sort((a, b) => a[dimensions[dim]] - b[dimensions[dim]]);

    const median = Math.floor(points.length / 2);
    const node = new Node(points[median], dim, parent);
    node.left = buildTree(points.slice(0, median), depth + 1, node, dimensions);
    node.right = buildTree(points.slice(median + 1), depth + 1, node, dimensions);

    return node;
}

function restoreParent(root) {
    if (root.left) {
        root.left.parent = root;
        restoreParent(root.left);
    }

    if (root.right) {
        root.right.parent = root;
        restoreParent(root.right);
    }
}

// Binary heap implementation from:
// http://eloquentjavascript.net/appendix2.html
class BinaryHeap {
    constructor(scoreFunction) {
        this.content = [];
        this.scoreFunction = scoreFunction;
    }

    push(element) {
        // Add the new element to the end of the array.
        this.content.push(element);
        // Allow it to bubble up.
        this.bubbleUp(this.content.length - 1);
    }

    pop() {
        // Store the first element so we can return it later.
        let result = this.content[0];
        // Get the element at the end of the array.
        let end = this.content.pop();
        // If there are any elements left, put the end element at the
        // start, and let it sink down.
        if (this.content.length > 0) {
            this.content[0] = end;
            this.sinkDown(0);
        }
        return result;
    }

    peek() {
        return this.content[0];
    }

    size() {
        return this.content.length;
    }

    bubbleUp(n) {
        // Fetch the element that has to be moved.
        let element = this.content[n];
        // When at 0, an element can not go up any further.
        while (n > 0) {
            // Compute the parent element's index, and fetch it.
            const parentN = Math.floor((n + 1) / 2) - 1;
            const parent = this.content[parentN];
            // Swap the elements if the parent is greater.
            if (this.scoreFunction(element) < this.scoreFunction(parent)) {
                this.content[parentN] = element;
                this.content[n] = parent;
                // Update 'n' to continue at the new position.
                n = parentN;
            } else {
                // Found a parent that is less, no need to move it further.
                break;
            }
        }
    }

    sinkDown(n) {
        // Look up the target element and its score.
        const length = this.content.length;
        const element = this.content[n];
        const elemScore = this.scoreFunction(element);

        while (true) {
            let child1Score;
            // Compute the indices of the child elements.
            const child2N = (n + 1) * 2;
            const child1N = child2N - 1;
            // This is used to store the new position of the element,
            // if any.
            let swap = null;
            // If the first child exists (is inside the array)...
            if (child1N < length) {
                // Look it up and compute its score.
                const child1 = this.content[child1N];
                child1Score = this.scoreFunction(child1);
                // If the score is less than our element's, we need to swap.
                if (child1Score < elemScore) {
                    swap = child1N;
                }
            }
            // Do the same checks for the other child.
            if (child2N < length) {
                const child2 = this.content[child2N];
                const child2Score = this.scoreFunction(child2);
                if (child2Score < (swap === null ? elemScore : child1Score)) {
                    swap = child2N;
                }
            }

            // If the element needs to be moved, swap it, and continue.
            if (swap !== null) {
                this.content[n] = this.content[swap];
                this.content[swap] = element;
                n = swap;
            } else {
                // Otherwise, we are done.
                break;
            }
        }
    }
}

class KNN {
    /**
     * @param {Array} dataset
     * @param {Array} labels
     * @param {object} options
     * @param {number} [options.k=numberOfClasses + 1] - Number of neighbors to classify.
     * @param {function} [options.distance=euclideanDistance] - Distance function that takes two parameters.
     */
    constructor(dataset, labels, options = {}) {
        if (dataset === true) {
            const model = labels;
            this.kdTree = new KDTree(model.kdTree, options);
            this.k = model.k;
            this.classes = new Set(model.classes);
            this.isEuclidean = model.isEuclidean;
            return;
        }

        const classes = new Set(labels);

        const {
            distance = euclideanDistance, k = classes.size + 1
        } = options;

        const points = new Array(dataset.length);
        for (let i = 0; i < points.length; ++i) {
            points[i] = dataset[i].slice();
        }

        for (let i = 0; i < labels.length; ++i) {
            points[i].push(labels[i]);
        }

        this.kdTree = new KDTree(points, distance);
        this.k = k;
        this.classes = classes;
        this.isEuclidean = distance === euclideanDistance;
    }

    /**
     * Create a new KNN instance with the given model.
     * @param {object} model
     * @param {function} distance=euclideanDistance - distance function must be provided if the model wasn't trained with euclidean distance.
     * @return {KNN}
     */
    static load(model, distance = euclideanDistance) {
        if (model.name !== 'KNN') {
            throw new Error(`invalid model: ${model.name}`);
        }
        if (!model.isEuclidean && distance === euclideanDistance) {
            throw new Error(
                'a custom distance function was used to create the model. Please provide it again',
            );
        }
        if (model.isEuclidean && distance !== euclideanDistance) {
            throw new Error(
                'the model was created with the default distance function. Do not load it with another one',
            );
        }
        return new KNN(true, model, distance);
    }

    /**
     * Return a JSON containing the kd-tree model.
     * @return {object} JSON KNN model.
     */
    toJSON() {
        return {
            name: 'KNN',
            kdTree: this.kdTree,
            k: this.k,
            classes: Array.from(this.classes),
            isEuclidean: this.isEuclidean,
        };
    }

    /**
     * Predicts the output given the matrix to predict.
     * @param {Array} dataset
     * @return {Array} predictions
     */
    predict(dataset) {
        if (Array.isArray(dataset)) {
            if (typeof dataset[0] === 'number') {
                return getSinglePrediction(this, dataset);
            } else if (
                Array.isArray(dataset[0]) &&
                typeof dataset[0][0] === 'number'
            ) {
                const predictions = new Array(dataset.length);
                for (let i = 0; i < dataset.length; i++) {
                    predictions[i] = getSinglePrediction(this, dataset[i]);
                }
                return predictions;
            }
        }
        throw new TypeError('dataset to predict must be an array or a matrix');
    }

    
    static staticPredict(dataset) {
        if (Array.isArray(dataset)) {
            if (typeof dataset[0] === 'number') {
                return getSinglePrediction(this, dataset);
            } else if (
                Array.isArray(dataset[0]) &&
                typeof dataset[0][0] === 'number'
            ) {
                const predictions = new Array(dataset.length);
                for (let i = 0; i < dataset.length; i++) {
                    predictions[i] = getSinglePrediction(this, dataset[i]);
                }
                return predictions;
            }
        }
        throw new TypeError('dataset to predict must be an array or a matrix');
    }
}

function getSinglePrediction(knn, currentCase) {
    let nearestPoints = knn.kdTree.nearest(currentCase, knn.k);
    let pointsPerClass = {};
    let predictedClass = -1;
    let maxPoints = -1;
    let lastElement = nearestPoints[0][0].length - 1;

    for (let element of knn.classes) {
        pointsPerClass[element] = 0;
    }

    for (let i = 0; i < nearestPoints.length; ++i) {
        let currentClass = nearestPoints[i][0][lastElement];
        let currentPoints = ++pointsPerClass[currentClass];
        if (currentPoints > maxPoints) {
            predictedClass = currentClass;
            maxPoints = currentPoints;
        }
    }

    return predictedClass;
}



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
async function predictOutput(prod_datasets,k=1){
	
	var {datasets,labels} = await calc(); 
	var knn = new KNN(datasets, labels, { k: k } ) 

	// var test_dataset = [
	// [75]
	// ];
    console.log("predictOutput",prod_datasets,k);
	return await knn.predict(prod_datasets); 
} 