angular.module("httpApp", ['httpService'])
	.controller('TaskCtrl', function($scope, task, $modal) {
		
		$scope.init = function() {
			$scope.orderComponentsByField = 'CO_VC_STATUS';
		   	$scope.orderResourcesByField = 'RSC_VC_STATUS';
		   	$scope.orderTestCasesByField = 'TS_VC_STATUS';
		   	
		    $scope.Components = {};
		    $scope.Resources  = {};
		    $scope.TestCases  = {};
		};
		
		$scope.getAll = function() {
			task.getAllTasks();
		};
		
		$scope.init();
	});