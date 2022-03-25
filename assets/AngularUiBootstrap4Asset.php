<?php

namespace app\assets;

use yii\web\AssetBundle;

class AngularUiBootstrap4Asset extends AssetBundle
{
	public $sourcePath = '@npm/ui-bootstrap4/dist';
	public $css = [
		'ui-bootstrap-csp.css',
	];
	public $js = [
		'ui-bootstrap-tpls.js',
	];
}
