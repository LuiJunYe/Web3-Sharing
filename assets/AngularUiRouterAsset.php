<?php

namespace app\assets;

use yii\web\AssetBundle;

class AngularUiRouterAsset extends AssetBundle
{
	public $sourcePath = '@npm/uirouter--angularjs/release';
	public $css = [
	];
	public $js = [
		'angular-ui-router.js',
	];
	public $depends = [
		'app\assets\AngularAsset'
	];
}
