<?php $appconfig = get_appconfig(); ?>
<?php $staff_number = get_number('staff', $payslip['payslip_relation_id'], 'staff', 'staff'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Encoding utf8 chartset for the pdf -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Bootstrap CSS file link -->
	<link rel="stylesheet prefetch" href="<?php echo base_url('assets/lib/bootstrap/dist/css/bootstrap.min.css'); ?>">

	<style>
		.list-group-item.active,
		.list-group-item.active:focus,
		.list-group-item.active:hover {
			z-index: 2;
			color: #fff;
			background-color: #555;
			border-color: #555;
		}

		.font {
			font-family: DejaVu Sans sans-serif;
		}

		table {
			/* Note: Without this table border does not works with Dompdf */
			border-collapse: separate;
		}

		.table-border {
			border: 1px solid;
			padding: 5px;
			margin: auto;
		}

		/*.thead-dark {
			border-bottom: 5px solid black;
		}*/
		/*Custom CSS write/paste here*/
	</style>
</head>
<?php
// Invoice logo
$logo =  file_exists(FCPATH . 'uploads/ciuis_settings/' . $settings['app_logo']);
if (file_exists(FCPATH . 'uploads/ciuis_settings/' . $settings['app_logo'])) {
	$logo = FCPATH . 'uploads/ciuis_settings/' . $settings['app_logo'];
} else {
	$logo = FCPATH . 'uploads/ciuis_settings/' . $settings['logo']; // Use app logo, if invoice logo is not found
}
?>

<body>
	<div class="container">
		<div class="row">
			<div class="page-header">
				<img height="90px" src="<?= $logo ?>" alt="">
				<small class="pull-right" style="position:relative;top:20px;right:20px;">
					<strong class="font">
						<span class="text-uppercase font"><?= lang('payslip') ?></span> <br><!--  Invoice Title in your language -->
						#<?= '' . $payslip['payslip_number'] . '' ?><br> <!-- Invoice number -->
						<span class="font"><?= lang('date') . ': ' . //Date label 
												date(get_dateFormat(), strtotime($payslip['payslip_start_date'])) ?></span>
					</strong>
				</small>
			</div>
			<div class="col-md-12 nav panel" style="padding-bottom: 20px">

				<div class="col-md-6 col-sm-6 col-xs-6 font" style="padding: 0">
					<small>
						<strong><?= ($settings['company']) ? $settings['company'] : ""; ?></strong> <!-- Company Name from app settings -->
					</small>
					<br>
					<small>
						<!-- Company Address -->
						<?= '' . ($settings['town'] ? $settings['town'] . '/' : '') . ($settings['city'] ? $settings['city'] . '/' : '') . ($state ? $state . '/' : '') . ($country ? $country . '-' : '') . ($settings['zipcode'] ? $settings['zipcode'] : '')  ?>
					</small><br>
					<small>
						<!-- Company Phone -->
						<?= $settings['phone']; ?>
					</small><br>
					<small>
						<!-- Company Taxoffice & vatnumber -->
						<!-- You can remove these if don't want to display these in pdf -->
						<strong><?= ($settings['taxoffice'] ? $appconfig['tax_label'] . ' ' . lang('taxoffice') . ':' : '') ?></strong><?= $settings['taxoffice']; ?>
					</small><br>
					<small>
						<?= '<strong>' . ($settings['vatnumber'] ? $appconfig['tax_label'] . ' ' . lang('vatnumber') . ':' : '') . '</strong>' . $settings['vatnumber'] . ''; ?>
					</small>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6 font" style="padding: 0">
					<!-- Customer Details -->
					<small>
						<strong class="text-uppercase"><?= lang('staff') ?></strong>
					</small><br>
					<small>
						<strong><?= $staff_number . ' ' . $payslip['staffmembername']; ?></strong>
					</small><br>
					<small>
						<strong><?= $payslip['name']; ?></strong>
					</small>
					<br>
					<small>
						<?= ($payslip['address'] ? $payslip['address'] : ''); ?>
					</small><br>
					<small>
						<?= $payslip['phone']; ?>
					</small><br>
				</div>
			</div>
			<div class="col-md-12 nav panel">

				<div class="col-md-6 col-sm-6 col-xs-6 font" style="padding: 0">
					<strong>
						<h3 class="font"><?= lang('allowance') ?></h3>
					</strong>
					<table class="table panel table-border" style="padding: 0px; margin-right: 5px;">
						<thead class="thead-dark">
							<tr>
								<th class="font">
									<?= lang('name') ?>
								</th>
								<th class="font">
									<?php echo  lang('time') ?>
								</th>
								<th class="font">
									<?php echo  lang('quantity') ?>
								</th>
								<th class="font">
									<?php echo  lang('price') ?>
								</th>
								<th class="font">
									<?php echo  lang('total') ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($allowances as $allowance) { ?>
								<tr>
									<td class="text-left font">
										<?php echo '' . $allowance['payslip_item_name'] . '</b><br><small style="font-size:10px;line-height:10px">' . nl2br($allowance['payslip_item_description'])  . '</small>'; ?>
									</td>
									<td class="text-left font">
										<?php echo '' . $allowance['payslip_item_time_des'] . '' ?>
									</td>
									<td class="text-left font">
										<?php echo '' . amount_format($allowance['payslip_item_quantity']) . '' ?>
									</td>
									<td class="text-left font">
										<?php echo '' . amount_format($allowance['payslip_item_price']) . ''; ?>
									</td>
									<td class="text-left font">
										<?php echo '' . amount_format($allowance['payslip_item_total']) . ''; ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6 font" style="padding: 0">
					<strong>
						<h3 class="font"><?= lang('deduction') ?></h3>
					</strong>
					<table class="table panel table-border" style="padding: 0px;">
						<thead class="thead-dark">
							<tr>
								<th class="font">
									<?= lang('name') ?>
								</th>
								<th class="font">
									<?php echo  lang('time') ?>
								</th>
								<th class="font">
									<?php echo  lang('quantity') ?>
								</th>
								<th class="font">
									<?php echo  lang('price') ?>
								</th>
								<th class="font">
									<?php echo  lang('total') ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($deductions as $deduction) { ?>
								<tr>
									<td class="text-left font">
										<?php echo '' . $deduction['payslip_item_name'] . '</b><br><small style="font-size:10px;line-height:10px">' . nl2br($deduction['payslip_item_description'])  . '</small>'; ?>
									</td>
									<td class="text-left font">
										<?php echo '' . $allowance['payslip_item_time_des'] . '' ?>
									</td>s
									<td class="text-left font">
										<?php echo '' . amount_format($deduction['payslip_item_quantity']) . '' ?>
									</td>
									<td class="text-left font">
										<?php echo '' . amount_format($deduction['payslip_item_price']) . ''; ?>
									</td>
									<td class="text-left font">
										<?php echo '' . amount_format($deduction['payslip_item_total']) . ''; ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-12 col-xs-12 col-sm-12 panel" style="padding:0px;box-shadow: unset;page-break-inside: avoid;">
				<div class="col-md-6 col-xs-6 col-sm-6 panel pull-left" style="padding: 0px;border: unset;box-shadow: unset;">
				</div>
				<div class="col-md-5 col-xs-5 col-sm-5 pull-right" style="padding: 0;">
					<ul class="list-group">
						<li class="list-group-item">
							<strong class="font">
								<?= lang('base_salary'); ?>
							</strong>
							<div class="pull-right">
								<?php echo '' . amount_format($payslip['payslip_base_salary'], true) . '' ?>
							</div>
						</li>
						<li class="list-group-item">
							<strong class="font">
								<?= lang('total') . ' ' . lang('allowance'); ?>
							</strong>
							<div class="pull-right">
								<?php echo '' . amount_format($payslip['payslip_total_allowance'], true) . '' ?>
							</div>
						</li>
						<li class="list-group-item">
							<strong class="font">
								<?= lang('total') . ' ' . lang('deduction'); ?>
							</strong>
							<div class="pull-right">
								<?php echo '' . amount_format($payslip['payslip_total_deduction'], true) . '' ?>
							</div>
						</li>
						<li class="list-group-item active">
							<strong class="font">
								<?php echo lang('grandtotal'); ?>
							</strong>
							<div class="pull-right">
								<?php echo '' . amount_format($payslip['payslip_grand_total'], true) . ''; ?>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>

</html>