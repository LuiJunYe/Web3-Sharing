angular.module('all.config', [''])
.config(["$httpProvider", "$locationProvider", function ($httpProvider, $locationProvider) {
	$httpProvider.interceptors.push('httpInterceptor');
	$locationProvider.html5Mode({
		enabled      : true,
		requireBase  : false,
		rewriteLinks : false
	})
}]);
