<?php

namespace app\assets;

use yii\web\AssetBundle;

class AngularMaterialAsset extends AssetBundle
{
	public $sourcePath = '@npm/angular-material';
	public $css = [
		'angular-material.css'
	];
	public $js = [
		'angular-material.min.js'
	];
}
