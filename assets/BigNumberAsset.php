<?php

namespace app\assets;

use yii\web\AssetBundle;

class BigNumberAsset extends AssetBundle
{
	public $sourcePath = '@npm/bignumber.js';
	public $css = [
	];
	public $js = [
		'bignumber.min.js'
	];
}
