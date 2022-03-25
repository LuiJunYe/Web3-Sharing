<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\web\View;

AppAsset::register($this);

$base_url = Yii::$app->request->baseUrl;

$this->registerJs('
    angular.module("all")
    .value("base_url", "'.$base_url.'")
',View::POS_END);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="content-wrapper">
    <section class="content">
        <?= $content ?>
    </section>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
