<?php
namespace app\assets;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl  = '@web';
	public $css = [
		'css/font-awesome.min.css',
		'css/alertify.min.css',
		'css/default.min.css',
		'css/magnific-popup.css',
		'css/style.css?v=202108121510',
		'css/xmcountdown.css'
	];
	public $js = [
		// main logic
		'js/defi.js?v=202203251219',

		// plugin
		'js/wallet-connect.min.js',
		'js/web3modal.js',
		'js/evm-chains.js',
		'js/moment.min.js',
		'js/alertify.min.js',
		'js/jquery.bxslider.min.js',
		'js/jquery.xmcountdown.min.js',
		'js/jquery.xmaccordion.min.js',
		'js/jquery.xmtab.min.js',
	];
	public $depends = [
		'app\assets\AngularAsset',
		'app\assets\AngularUiBootstrap4Asset',
		'app\assets\AngularUiRouterAsset',
		'app\assets\AngularAnimateAsset',
		'app\assets\AngularAriaAsset',
		'app\assets\AngularMaterialAsset',
		'app\assets\LodashAsset',
		'app\assets\Web3Asset',
		'app\assets\BigNumberAsset'
	];
}
