<?php
use yii\web\View;

$this->title = 'Sharing';
?>

<!-- change according to logic -->
<!--TICKETS-->
<div id="tickets-wrap">
	<section id="tickets">
		<h2><span><?= Yii::t('app', 'Purchase') ?></span></h2>
		<hr>

		<div ng-controller="WalletCtrl" ng-cloak>
			<div ng-controller="MainCtrl" ng-cloak>
				<div class="tickets-col">
					<div class="action-btn">
						<a href="#" class="button black"><?= Yii::t('app','Balance') ?>: {{ bnb_bal | number:8 }} BNB</a>
					</div>
					<h6>
						<?php if ($show_purchase): ?>
							<div ng-if="showPurchase">
								<div>
									<h6 style="padding: 0px;">
										Price : {{ bnb_price}} BNB
									</h6>
								</div>
								<form id="com-form" style="padding-top: 10px;" data-ng-init="model.receiverAddr = selectedAcc">
									<div style="display: flex; flex-wrap: wrap;">
										<div>
											<input type="radio" id="bnb" name="currency" value="bnb" ng-model="model.purchaseMethod" ng-init="model.purchaseMethod = 'bnb'">
												<span style="padding-right: 20px"><?= Yii::t('app','BNB') ?></span>
											</input>
										</div>

										<input id="address" placeholder="<?= Yii::t('app','Your BSC wallet address') ?>" type="text" class="input-group" ng-model="model.receiverAddr">
										<div>
											<input id="checkAddr" type="checkbox" name="address" ng-model="receiverClick" ng-change="setReceiverAddr(receiverClick)">
												<span><?= Yii::t('app','My BSC address is same as current address') ?></span>
											</input>
										</div>

										<!-- purchase button -->
										<div ng-if="model.purchaseMethod">
											<div ng-if="!lock_purchase">
												<a href="#" class="button ruby" ng-click="purchase($event)">
													<?= Yii::t('app','Purchase Now') ?>
												</a>
											</div>
											<div ng-if="lock_purchase">
												<a href="#" class="button ruby" ng-click="">
													<?= Yii::t('app','Purchasing') ?> <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
												</a>
											</div>
										</div>
										<!-- purchase button -->

										<div ng-if="tx_id && is_confirm && !lock_purchase" style="padding-top: 5px;">
											<small style="word-break: break-all;color: green;">
												<?= Yii::t('app','Purchase successfully') ?>
											</small><br>
											<small style="word-break: break-all;">
												<?= Yii::t('app','Transaction ID') ?>
											</small><br>
											<small style="word-break: break-all;font-size: 12px">
												{{ tx_id }}
											</small>
											<br>
											<small>
												<a style="line-height: 0; display: contents;" href="{{ bsc_purchase }}" target="_blank"> <?= Yii::t('app','View transaction on bscscan') ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
											</small>
										</div>
									</div>
									<!-- purchase input -->
								</form>
							</div>
						<?php endif; ?>
					</h6>
				</div>
			</div>

			<div class="tickets-col">
				<div class="wallet-container">
					<div class="action-btn" ng-if="showConnect">
						<a href="#" class="button ruby" ng-click='connectWallet()'>
							<?= Yii::t('app','Connect Wallet') ?>
						</a>
					</div>
					<div class="action-btn" ng-if="!showConnect">
						<div style="color: black;">
							{{ selectedAcc | truncate:8:8 }}
							<br>
							<span id="network-name"></span>
						</div><br>
						<a href="#" class="button ruby" ng-click='disconnect()'>
							<?= Yii::t('app','Disconnect Wallet') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="cleaner"></div>
	</section>
</div>
<!--/TICKETS-->
