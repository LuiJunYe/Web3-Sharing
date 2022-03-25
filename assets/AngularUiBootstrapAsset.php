<?php

namespace app\assets;

use yii\web\AssetBundle;

class AngularUiBootstrapAsset extends AssetBundle
{
	public $sourcePath = '@npm/angular-ui-bootstrap/dist';
	public $css = [
		'ui-bootstrap-csp.css',
	];
	public $js = [
		'ui-bootstrap-tpls.js',
	];
}
