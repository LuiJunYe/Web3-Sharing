angular.module('defi',['ui.router','ui.bootstrap','ngMaterial'])
.value('base_url','')
.value('cashier_addr','')
.value('bsc_explorer', '')
.value('bsc_rpc', '')
.service('httpInterceptor',["$q","$window","base_url", function ($q,$window,base_url) {
	return {
		request : function (config) {
			if (config.url.substr(0, 4) !== 'http' && config.url.substr(0, 3) !== 'uib') {
				config.url = [base_url, config.url].join('/');
			}
			return config;
		},
		response : function (resp) {
			if (resp.status > 299 || resp.data.error) {
				return resp;
			}
			return resp;
		},
		responseError : function(rejection) {
			var resp     = {};
			resp.code    = -1;
			resp.error   = true;
			resp.message = "Service unavailable at the moment";
			resp.data    = false;

			rejection.data = resp;
			return rejection;
		}
	}
}])
.filter('truncate', function () {
	return function (input,front,back) {
		if (!input) return '';

		front = parseInt(front,10);

		if (!front) return input; // did not put specific length
		if (input.length <= front) return input; // if input is less than the length specify

		var start = input.substr(0,front);

		if (!back) return start + '....'; // if not specify decimal then direct return front + ...

		var end = input.substr(-back);

		return start + '....' + end;
	}
})
.component('userTransaction',{
	templateUrl : 'site/template?view=user_transaction',
	bindings    : {
		resolve : '<',
		close   : '&',
		dismiss : '&',
	},
	controller : ['$scope','$rootScope', function($scope,$rootScope) {
		var $ctrl = this;

		$scope.cancel = cancel;

		function cancel() {
			$ctrl.dismiss();
		}
	}]
})
.provider('message', function () {
	var that  = this;
	this.msg  = {};
	this.$get = ["$interpolate", function ($interpolate) {
		return function (key, data) {
			data = data || {};
			if (key in that.msg) {
				return $interpolate(that.msg[key]).call(null, data);
			}
			return key;
		}
	}];
})
.provider('jsonApi', function () {
	var that  = this;
	this.$get = function ($http) {
		return {
			cashierAbi : cashierAbi
		}

		function cashierAbi() {
			url = ["json/cashier.json?v=202106021703"].join("/");
			return $http.get(url, {
				params : {
				}
			})
			.then(function (resp) {
				var respData = resp.data;
				return respData;
			}, function (err) {
				// alert(err);
			});
		}
	}
})
.controller('ModalCtrl', ['$scope','$rootScope','$mdDialog','tx_id','bsc_explorer', function($scope,$rootScope,$mdDialog,tx_id,bsc_explorer) {
	$scope.tx_id            = tx_id;
	$scope.bsc_link         = bsc_explorer + '/tx/' + $scope.tx_id;
	$rootScope.bsc_purchase = $scope.bsc_link;

	$scope.cancel = function () {
		$mdDialog.cancel();
	};
}])
.controller('WalletCtrl',['$scope','$rootScope','message', function ($scope,$rootScope,message) {
	var $ctrl                   = this;
	const Web3Modal             = window.Web3Modal.default;
	const WalletConnectProvider = window.WalletConnectProvider.default;
	const evmChains             = window.evmChains;

	// Web3modal instance
	var web3Modal;

	// global used variable
	$rootScope.provider    = "";
	$rootScope.selectedAcc = "";

	$scope.showConnect   = true;
	$scope.connectWallet = connectWallet;
	$scope.disconnect    = disconnect;

	$ctrl.$onInit = function () {
		initWalletProvider();
	}

	function initWalletProvider() {
		var walletOptions = {
			rpc: {
				56: 'https://bsc-dataseed1.ninicoin.io/',
				97: 'https://data-seed-prebsc-2-s1.binance.org:8545/',
			},
		}

		const providerOptions = {
			walletconnect: {
			package: WalletConnectProvider,
				options: walletOptions
			},
		};

		var web3Options = {
			cacheProvider: false,
			providerOptions,
			disableInjectedProvider: false,
			network: 'binance'
		};

		web3Modal = new Web3Modal(web3Options);
	}

	async function refreshAccountData() {
		$scope.$apply(function () {
			$scope.showConnect = false;
		});

		await fetchAccountData($rootScope.provider);
	}

	async function fetchAccountData() {
		const web3 = new Web3($rootScope.provider);

		// Get list of accounts of the connected wallet
		const accounts  = await web3.eth.getAccounts();

		$scope.$apply(function () {
			$rootScope.selectedAcc = accounts[0];
		});

		const chainId = await web3.eth.getChainId();

		// Load chain information over an HTTP API
		const chainData = evmChains.getChain(chainId);
		document.querySelector("#network-name").textContent = chainData.chain + ' (' + _.startCase(chainData.network) + ')';

		$scope.$apply(function () {
			$scope.showConnect = false;
		});
	}

	async function connectWallet() {
		try {
			initWalletProvider();
			$rootScope.provider = await web3Modal.connect();
		} catch(e) {
			return;
		}

		// Subscribe to accounts change
		$rootScope.provider.on("accountsChanged", (accounts) => {
			fetchAccountData();
		});

		$rootScope.provider.on("chainChanged", (chainId) => {
			fetchAccountData();
		});

		await refreshAccountData();
	}

	async function disconnect() {
		web3Modal.clearCachedProvider();
		$scope.showConnect  = true;
		$rootScope.provider = null;
		window.location.reload();
	}
}])
.controller('MainCtrl', ['$scope', 'jsonApi', '$timeout', '$rootScope', '$mdDialog', 'message', 'cashier_addr', 'bsc_explorer', 'bsc_rpc', function ($scope, jsonApi, $timeout, $rootScope, $mdDialog, message, cashier_addr, bsc_explorer, bsc_rpc) {
	var $ctrl = this;

	// global used variable
	$scope.showPurchase = false;
	$scope.model        = {};
	$scope.bnb_price    = 0;
	$scope.tx_id        = "";
	$scope.is_confirm = false;

	$rootScope.bnb_bal = 0;
	$rootScope.lock_purchase = false;

	$ctrl.$onInit = function () {
		checkWalletConnection();
		getCashierAbi();
		getBnbBalance();
		getBnbPrice();
	}

	$scope.setReceiverAddr = function (receiverClick) {
		if (receiverClick) {
			$scope.model.receiverAddr = $rootScope.selectedAcc;
		} else {
			$scope.model.receiverAddr = '';
		}
	}

	$scope.purchase = async function (ev) {
		if (_.isEmpty($rootScope.provider)) {
			alertify.error(message('error2'));
			return true;
		}

		if (_.isEmpty($scope.model.purchaseMethod)) {
			alertify.error(message('error4'));
			return true;
		}

		if (_.isEmpty($scope.model.receiverAddr)) {
			alertify.error(message('error5'));
			return true;
		}

		var web3        = web3Asset();
		var cashier_crt = new web3.eth.Contract($rootScope.cashier_abi, cashier_addr);
		var gas_price   = await web3.eth.getGasPrice();
		var price       = await cashier_crt.methods.price().call();

		var purchase = await cashier_crt.methods.purchase().send({
			from     : $rootScope.selectedAcc,
			gasPrice : gas_price,
			value    : price
		}).on('transactionHash', function (transactionHash) {
			$scope.$apply(function () {
				$rootScope.lock_purchase = true;
				$scope.tx_id             = transactionHash;
			});

			$mdDialog.show({
				controller: 'ModalCtrl',
				templateUrl: 'site/template?view=user_transaction',
				parent: angular.element(document.body),
				targetEvent: ev,
				escapeToClose: false,
				locals: { tx_id: $scope.tx_id },
				fullscreen: true
			});

			getTransactionReceipt();
		}).on('error',function (error) {})
		.catch(function (err) {
			alertify.error(message('error6'));
			return true;
		});
	}

	function checkWalletConnection() {
		if (_.isEmpty($rootScope.provider)) {
			$scope.showPurchase = false;
		} else {
			$scope.showPurchase = true;
		}

		$timeout(function () {
			checkWalletConnection();
		}, 1000);
	}

	function getCashierAbi() {
		return jsonApi.cashierAbi()
		.then(function (data) {
			$rootScope.cashier_abi = data;
			return $rootScope.cashier_abi;
		}, function (err) {
		});
	}

	async function getTransactionReceipt() {
		var web3        = web3Asset();
		var transaction = await web3.eth.getTransaction($scope.tx_id);

		if (transaction.blockNumber) {
			$scope.$apply(function () {
				$rootScope.lock_purchase = false;
			});

			var receipt = await web3.eth.getTransactionReceipt($scope.tx_id);

			if (receipt.status) {
				$scope.$apply(function () {
					$scope.is_confirm = true;
				});
			} else {
				alertify.error(message('error9'));
			}
		} else {
			$timeout(getTransactionReceipt, 2000);
		}
	}

	async function getBnbPrice() {
		if (!_.isEmpty($rootScope.provider)) {
			var web3 = web3Asset();
			var cashier_crt = new web3.eth.Contract($rootScope.cashier_abi, cashier_addr);
			var price = await cashier_crt.methods.price().call();

			$scope.$apply(function () {
				$scope.bnb_price = price / Math.pow(10,18);
			});
		}

		$timeout(getBnbPrice, 2000);
	}

	async function getBnbBalance() {
		if (!_.isEmpty($rootScope.provider)) {
			var web3 = web3Asset();
			var balance = await web3.eth.getBalance($rootScope.selectedAcc);

			$scope.$apply(function () {
				$rootScope.bnb_bal = balance / Math.pow(10,18);
			});
		}

		$timeout(getBnbBalance, 2000);
	}

	function web3Asset() {
		let new_web3 = new Web3($rootScope.provider);
		return new_web3;
	}
}])
