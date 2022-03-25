<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\View;
use app\assets\UserAsset;

UserAsset::register($this);

$base_url    = Yii::$app->request->baseUrl;
$bsc_cashier = Yii::$app->params['bscCashierContract'];
$bsc_domain  = 'https://testnet.bscscan.com';
$bsc_rpc     = 'https://data-seed-prebsc-1-s1.binance.org:8545/';

$this->registerJs('
  angular.module("defi")
  .value("base_url", "'.$base_url.'")
  .value("cashier_addr", "'.$bsc_cashier.'")
  .value("bsc_explorer", "'.$bsc_domain.'")
  .value("bsc_rpc", "'.$bsc_rpc.'")
  .config(function (messageProvider) {
    messageProvider.msg.notice = "'.Yii::t('app','Notice').'";
    messageProvider.msg.cancel = "'.Yii::t('app','Cancel').'";
    messageProvider.msg.error2 = "'.Yii::t('app','Please connect wallet to continue').'";
    messageProvider.msg.error4 = "'.Yii::t('app','Select a payment method to continue').'";
    messageProvider.msg.error5 = "'.Yii::t('app','Enter BSC wallet address to continue').'";
    messageProvider.msg.error6 = "'.Yii::t('app','Transaction rejected').'";
    messageProvider.msg.error8 = "'.Yii::t('app','Cancel switch wallet request').'";
    messageProvider.msg.error9 = "'.Yii::t('app','Transaction failed. Please refer to Bscscan for more transaction details.').'";
    messageProvider.msg.confirm1 = "'.Yii::t('app','Spending Confirmation').'";
  });
',View::POS_END);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="dark" ng-app="defi" ng-cloak>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
