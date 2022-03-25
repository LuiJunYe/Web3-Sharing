<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LodashAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl  = '@web';
	public $js = [
		'js/lodash.min.js',
	];
}
