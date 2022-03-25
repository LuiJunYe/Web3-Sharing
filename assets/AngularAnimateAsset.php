<?php

namespace app\assets;

use yii\web\AssetBundle;

class AngularAnimateAsset extends AssetBundle
{
	public $sourcePath = '@npm/angular-animate';
	public $css = [
	];
	public $js = [
		'angular-animate.min.js'
	];
}
