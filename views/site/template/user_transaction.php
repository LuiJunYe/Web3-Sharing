<div>
	<md-dialog aria-label="User Transactions" style="max-width: none;">
		<form class="center-container" ng-cloak>
			<md-dialog-content>
				<h6>
					<?= Yii::t('app','Transactions Submitted') ?>
					<hr>
				</h6>
				<div class="md-dialog-content">
					<div>
						<h6>
							<?= Yii::t('app','BNB payment has been submitted. Please wait for the confirmation.') ?>
						</h6>
					</div><br>
					<img class="tick-img center-tx" src="<?= Yii::getAlias('@web').'/images/Flat_tick_icon.png' ?>">
					<div>
						<a href="{{ bsc_link }}" target="_blank"> <?= Yii::t('app','View transaction on bscscan') ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
					</div>
				</div>
			</md-dialog-content>

			<div class="action-btn btn-center">
				<a href="#" class="button ruby" ng-click="cancel()">
					<?= Yii::t('app','Close') ?>
				</a>
			</div>
		</form>
	</md-dialog>
</div>

