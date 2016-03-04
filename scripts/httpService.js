angular.module('httpService')
	.service('task', function task($http, $rootScope) {
		
		var task = this;
		
		task.getComponents = function() {
	    	
	    	if (isEmpty($scope.Components)) {
		    	$scope.Components = [{"CO_NAME": "Loading..."}];
		    	$scope.Components.reverseSort = false;
	    	}
	    	
	        $http.get("api/components")
	        	.success(function(data, status, headers, config) {
	        		$scope.Components = data;
	        		console.log("Components updated at " + Date.now());
	        	})
	        	.error(function(data, status, headers, config) {
	        		colsole.log("AJAX failed!" + config.url);
	        	}
	        );
	    };
	    
		task.getResources = function(item, event) {
	    	
			if (isEmpty($scope.Resources)){
				$scope.Resources.reverseSort  = false;
				$scope.Resources = [{"RSC_NAME": "Loading..."}];
			} 
			
			$http.get("api/resources")
	        	.success(function(data, status, headers, config) {
	        		$scope.Resources = data;
	        		console.log("Resources updated at " + Date.now());
	        	})
	        	.error(function(data, status, headers, config) {
	        		console.log("AJAX failed!" + config.url);
	        	}
	        );
	    };
		
		
		task.getTestCases = function(item, event) {
	    	
			if (isEmpty($scope.TestCases)){
				$scope.TestCases.reverseSort  = false;
				$scope.TestCases = [{"TS_NAME": "Loading..."}];
			}
			
			$scope.TestCases = [{"TS_NAME": "Loading..."}];
	        $http.get("api/testCases")
	        	.success(function(data, status, headers, config) {
	        		$scope.TestCases = data;
	        		console.log("TestCases updated at " + Date.now());
	        	})
	        	.error(function(data, status, headers, config) {
	        		console.log("AJAX failed!" + config.url);
	        	}
	        );
	    };
	    
	    
	});