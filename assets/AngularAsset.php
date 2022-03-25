<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AngularAsset extends AssetBundle
{
	public $sourcePath = '@bower/angular';
	public $baseUrl    = '@web';
	public $css = [
	];
	public $js = [
		'angular.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
		// 'app\assets\JqueryAsset',
	];
}
