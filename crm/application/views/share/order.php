<?php $rebrand = load_config(); ?>
<?php $appconfig = get_appconfig(); ?>
<!-- new design -->
<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>

<body ng-controller="Orders_Controller" class="view-order-top">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis-app.css'); ?>" type="text/css" />
	<?php include_once(APPPATH . 'views/inc/widgets/order_view_sidebar.php'); ?>
	<div class="main-content container-fluid col-md-9 borderten">
		<div class="col-md-12 md-pr-0 mt-10">
			<div class="proposal panel borderten" style="padding-top: 20px;padding-right: 0px;">
				<md-toolbar class="toolbar-white">
					<!--<div class="md-toolbar-tools">-->
					<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true" ng-cloak>
						<md-icon><i class="ico-ciuis-proposals text-warning"></i></md-icon>
					</md-button>
					<!--</div>-->
				</md-toolbar>
				<md-content class="bg-white">
					<md-tabs md-dynamic-height md-border-bottom>
						<md-content class="md-padding bg-white">
							<div class="proposal">
								<main>
									<div id="details" class="clearfix">
										<div id="client">
											<h2 flex md-truncate><?php echo $orders['subject']; ?></h2>
											<div class="date text-bold"><?php echo lang('dateofissuance') ?>:
												<?php echo date(get_dateFormat(), strtotime($orders['date'])) ?>
											</div>
											<div class="date text-bold"><?php echo lang('opentill') ?>:
												<?php echo date(get_dateFormat(), strtotime($orders['opentill'])) ?>
											</div>
										</div>
										<div class="pull-right"><?php if ($orders['status_id'] == 1) {
																	echo '<span class="label label-default p-s-lab p-s-v pull-left">' . lang('draft') . '</span>';
																}  ?><?php if ($orders['status_id'] == 2) {
																			echo '<span class="label label-default p-s-lab p-s-v pull-left">' . lang('sent') . '</span>';
																		}  ?><?php if ($orders['status_id'] == 3) {
																					echo '<span class="label label-default p-s-lab p-s-v pull-left">' . lang('open') . '</span>';
																				}  ?><?php if ($orders['status_id'] == 4) {
																							echo '<span class="label label-default p-s-lab p-s-v pull-left">' . lang('revised') . '</span>';
																						}  ?><?php if ($orders['status_id'] == 5) {
																									echo '<span class="label label-default p-s-lab p-s-v pull-left">' . lang('declined') . '</span>';
																								}  ?><?php if ($orders['status_id'] == 6) {
																												echo '<span class="label label-default p-s-lab p-s-v pull-left">' . lang('accepted') . '</span>';
																											}  ?></div>
									</div>
								
										<div class="col-md-12">
											<?php echo nl2br($orders['content']); ?>
										</div>
									
									<table border="0" cellspacing="0" cellpadding="0">
										<thead>
											<tr>
												<th class="desc"><?php echo lang('description') ?></th>
												<th class="qty text-right"><?php echo lang('quantity') ?></th>
												<th class="qty text-right"><?php echo lang('unit') ?></th>
												<th class="unit text-right"><?php echo lang('price') ?></th>
												<th class="discount text-right"><?php echo lang('discount') ?></th>
												<th class="tax text-right"><?php echo $appconfig['tax_label'] ?></th>
												<th class="total text-right"><?php echo lang('total') ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($items as $item) {
											?>
												<tr>
													<td class="desc">
														<h3><?php echo $item['name']
															?><br></h3><?php echo nl2br($item['description']);
																		?>
													</td>
													<td class="qty"><?php echo '' . amount_format($item['quantity']) . ''
																	?></td>
													<td class="qty text-right"><?= $item['unit'] ?></td>
													<td class="unit"><span class="money-area"><?php echo '' . amount_format($item['price']) . '';
																								?></span></td>
													<td class="discount"><?php echo '' . amount_format($item['discount']) . '%';
																			?></td>
													<td class="tax"><?php echo '' . amount_format($item['tax']) . '%';
																	?></td>
													<td class="total"><span class="money-area"><?php echo '' . amount_format($item['total']) . '';
																								?></span></td>
												</tr>
											<?php }
											?>
										</tbody>
									</table>
									<div class="col-md-12 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
										<div class="col-md-10">
											<div class="text-right text-uppercase text-muted"><?php echo lang('sub_total'); ?>:</div>
											<div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount'); ?>:</div>
											<div ng-show="totaltax() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total') . ' ' . $appconfig['tax_label']; ?>:</div>
											<div class="text-right text-uppercase text-black"><?php echo lang('grand_total'); ?>:</div>
										</div>
										<div class="col-md-2">
											<div class="text-left"><?php echo '' . amount_format($orders['sub_total'], true) . '' ?></div>
											<div class="text-left"> <?php echo '' . amount_format($orders['total_discount'], true) . '' ?></div>
											<div class="text-left"> <?php echo '' . amount_format($orders['total_tax'], true) . '' ?></div>
											<div class="text-left"><?php echo '' . amount_format($orders['total'], true) . '' ?> </div>
										</div>
									</div>


								</main>
							</div>
						</md-content>
						</md-tab>
					</md-tabs>
			</div>
		</div>
		</md-content>
	</div>

	<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
	<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/lib/jquery.gritter/js/jquery.gritter.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-resource.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-route.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-loader.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-cookies.min.js'); ?>"></script>
	
<script>
let actionB = document.getElementById("actionButton")

$(".accept-order").click( function () {
	var base_url = "<?php echo base_url();?>"
	var order = $( this ).data( 'order' );
	var statusna = "<?php echo lang('accepted'); ?>";
	$.ajax( {
		type: "POST",
		url: base_url + "share/markasorder",
		data: {
			status_id: 6,
			order_id: order,
		},
		dataType: "text",
		cache: false,
		success: function ( data ) {
			$.gritter.add( {
				title: '<b><?php echo lang('notification')?></b>',
				text: '<b><?php echo lang('invoiceorder')." ".lang('markas'); ?> '+statusna+'</b>',
				class_name: 'color success'
			} );
			actionB.style.display = "none"
			$( ".p-s-lab" ).text(statusna);

		}
	} );
	return false;
});
$(".decline-order").click( function () {
var base_url = "<?php echo base_url();?>"
var order = $( this ).data( 'order' );
var statusna = "<?php echo lang('declined') ?>";
$.ajax( {
	type: "POST",
	url: base_url + "share/markasorder",
	data: {
		status_id: 5,
		order_id: order,
	},
	dataType: "text",
	cache: false,
	success: function ( data ) {
		$.gritter.add( {
			title: '<b><?php echo lang('notification'); ?></b>',
			text: '<b><?php echo lang('invoiceorder')." ".lang('markas'); ?> '+statusna+'</b>',
			class_name: 'color danger'
		} );
		actionB.style.display = "none"
		$( ".p-s-lab" ).text(statusna);
	}
} );
return false;
});
</script>