angular.module("myapp", [])
	.controller("MyController", function($scope, $http, $interval) {
	
		$scope.orderComponentsByField = 'CO_VC_STATUS';
	   	$scope.orderResourcesByField = 'RSC_VC_STATUS';
	   	$scope.orderTestCasesByField = 'TS_VC_STATUS';
	   	
	    $scope.Components = {};
	    $scope.Resources  = {};
	    $scope.TestCases  = {};
	    
	    $scope.componentsFilled = false;
	    
	    $scope.getComponents = function() {
	    	
	    	var url = "api/components/";
	    	
	    	if ($scope.noOfDays !== undefined && $scope.noOfDays !== null){
	    		url += "days/" + $scope.noOfDays;
	    	}
	    	
	    	console.log(url);
	    	
	    	if (isEmpty($scope.Components)) {
		    	$scope.Components = [{"CO_NAME": "Loading..."}];
		    	$scope.Components.reverseSort = false;
	    	}
	    	
	        $http.get(url)
	        	.success(function(data, status, headers, config) {
	        		$scope.Components = data;
	        		$scope.componentsFilled = true;
	        		console.log("Components updated at " + Date.now());
	        	})
	        	.error(function(data, status, headers, config) {
	        		colsole.log("AJAX failed!" + config.url);
	        	}
	        );
	    };
	    
		$scope.getResources = function(item, event) {
			
			var url = "api/resources/";
	    	
	    	if ($scope.noOfDays !== undefined && $scope.noOfDays !== null){
	    		url += "days/" + $scope.noOfDays;
	    	}
	    	
	    	console.log(url);
	    	
			if (isEmpty($scope.Resources)){
				$scope.Resources.reverseSort  = false;
				$scope.Resources = [{"RSC_NAME": "Loading..."}];
			} 
			
			$http.get(url)
	        	.success(function(data, status, headers, config) {
	        		$scope.Resources = data;
	        		console.log("Resources updated at " + Date.now());
	        	})
	        	.error(function(data, status, headers, config) {
	        		console.log("AJAX failed!" + config.url);
	        	}
	        );
	    };
		
		
		$scope.getTestCases = function(item, event) {
	    	
			var url = "api/testCases";
	    	
	    	console.log(url);
	    	
			if (isEmpty($scope.TestCases)){
				$scope.TestCases.reverseSort  = false;
				$scope.TestCases = [{"TS_NAME": "Loading..."}];
			}
			
			$scope.TestCases = [{"TS_NAME": "Loading..."}];
	        $http.get(url)
	        	.success(function(data, status, headers, config) {
	        		$scope.TestCases = data;
	        		console.log("TestCases updated at " + Date.now());
	        	})
	        	.error(function(data, status, headers, config) {
	        		console.log("AJAX failed!" + config.url);
	        	}
	        );
	    };
	    
	    
	    // update all sections every so many seconds
	    setInterval(function() {
	    	if ($scope.autoUpdate){
	    		$scope.getComponents();
	    		$scope.getResources();
	    		$scope.getTestCases();
	    	}
    	}, 9000);
        
	    // load all components at document load
	    $scope.init = function () {
	    	$scope.getComponents();
		    $scope.getResources();
		    $scope.getTestCases();
	    }
	    
	
	}  // end controller
	
);


function isEmpty(obj) {
    return Object.keys(obj).length === 0;
}