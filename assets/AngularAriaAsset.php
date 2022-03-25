<?php

namespace app\assets;

use yii\web\AssetBundle;

class AngularAriaAsset extends AssetBundle
{
	public $sourcePath = '@npm/angular-aria';
	public $css = [
	];
	public $js = [
		'angular-aria.min.js'
	];
}
