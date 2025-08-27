<?php $appconfig = get_appconfig(); ?>
<?php $number = get_number('orders',$orders['id'],'order','order');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <!-- Encoding utf8 chartset for the pdf -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/bootstrap/dist/css/bootstrap.css'); ?>" type="text/css"/> <!-- Bootstrap CSS file link -->
	<style>
		.list-group-item.active,
		.list-group-item.active:focus,
		.list-group-item.active:hover {
			z-index: 2;
			color: #fff;
			background-color: #555;
			border-color: #555;
		}
		.page-header.row {
			margin: 30px 0 10px 0 !important;
		}
		.font{
			font-family: DejaVu Sans; sans-serif;
		}
		/*Custom CSS write/paste here*/
	</style>
</head>
<!-- Check Customer or Lead -->
<?php if($orders['relation_type'] == 'customer'){if($orders['customercompany']===NULL){  // Customer type i.e individual or company
	$customer = $orders['namesurname'];} else $customer = $orders['customercompany'];} ?>
<?php if($orders['relation_type'] == 'lead'){$customer = $orders['leadname'];} 

// Order logo
// $logo =  file_exists(FCPATH.'uploads/ciuis_settings/'.$settings['app_logo']);
// if(file_exists(FCPATH.'uploads/ciuis_settings/'.$settings['app_logo'])) {
// 	$logo = FCPATH.'uploads/ciuis_settings/'.$settings['app_logo'];
// } else {
// 	$logo = FCPATH.'uploads/ciuis_settings/'.$settings['logo']; // Use app logo, if order logo is not found
// }
$logo = base_url ('uploads/ciuis_settings/' . $settings['app_logo']);
?>
<body>
	<div class="container">
		<div class="row">
			<div class="page-header row">
				<div class="col-md-3 col-sm-3 col-xs-3 logo">
					<img height="75px" src="<?php echo $logo ?>" alt=""><br>
					<small>
						<strong class="font" style="font-size: 11px;"><?php echo $settings['company']; ?></strong> <!-- Company Name from app settings -->
					</small><br>
					<small class="font" style="font-size: 11px;"> <!-- Company Address -->
						<?php echo '' .$settings[ 'town' ] . ', ' . $settings[ 'city' ] . ', ' . $settings[ 'zipcode' ] . ', ' . $country . '' ?>
					</small><br>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4" style="padding-top: 2%;text-align: center;">
					<strong class="section-title font"><span style="font-size: 25px;" class="text-uppercase"><?php echo lang('order') ?></span> <br> <!--  Order Title in your language -->
					</strong>
					<span class="section-title">
							#<?php echo '' . $number. '' ?></span> <!-- Order number -->
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4">
					<small class="" style="position:relative;top:20px;right:20px;padding-right: 40px;text-align: left;float: right;">
						<strong><span class="text-uppercase font"><?php echo lang('order') ?></span> <br>
							#<?php echo '' . $number. '' ?> <!-- Order number -->
							<br> 
							 <!-- Date label -->
							<span class="font"><?php echo lang( 'date' )?></span> : <span><?php echo date(
								// Order Issuance Date
								get_dateFormat(), strtotime($orders['date']))
							?></span>
							<br>
							<!-- Order Till Date -->
							<span class="font"><?php echo lang( 'opentill' )?></span> : 
							<?php echo date(get_dateFormat(), strtotime($orders['opentill'])) ?>

						</strong>
					</small>
				</div>
			</div>
			<div class="col-md-12 nav panel" style="padding-bottom: 20px">
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0">
					<strong class="font"><?php echo lang('from') ?></strong><br>
					<hr>
					<small>
						<!-- Company Name from app settings -->
						<strong class="font"><?php echo ($settings['company']) ? $settings['company'] : ""	; ?></strong>
					</small>
					<br>
					<small class="font">
						<!-- Company Address -->
						<?php echo '' .($settings[ 'town' ] ? $settings[ 'town' ].'/' : '').($settings[ 'city' ] ? $settings[ 'city' ].'/':'').($state ? $state.'/' : '').($country ? $country.'-':'').($settings[ 'zipcode' ] ? $settings[ 'zipcode' ] : '')  ?>
					</small><br>
					<small class="font">
						<!-- Company Phone -->
						<?php echo $settings[ 'phone' ]; ?>
					</small><br>
					<small class="font">
						<!-- Company Taxoffice & vatnumber -->
						<!-- You can remove these if don't want to display these in pdf -->
						<strong><?php echo  ($settings[ 'taxoffice' ] ? $appconfig['tax_label'].' '.lang('taxoffice').':' : '') ?></strong><?php echo $settings[ 'taxoffice' ]; ?>
					</small><br>
					<small class="font">
						<?php echo '<strong>'.($settings[ 'vatnumber' ] ? $appconfig['tax_label'].' '.lang( 'vatnumber' ).':' : '') .'</strong>' . $settings[ 'vatnumber' ] . ''; ?>
					</small>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0">
					<strong class="font"><?php echo lang('to') ?></strong><br>
					<!-- Customer or Leads Details -->
					<hr>
					<small>
						<strong class="font"><?php echo $customer; ?></strong>
					</small>
					<br>
					<small class="font">
						<?php echo ($orders[ 'toaddress' ] ? $orders[ 'toaddress' ].'/' : ''); ?><?php echo ($orders[ 'city' ] ? $orders[ 'city' ].'/' : ''); ?><?php echo ($custstate ? $custstate.'/' : '') ; ?><?php echo ($custcountry ? $custcountry :''); ?><?php echo ($orders[ 'zip' ] ? '- '.$orders[ 'zip' ] : ''); ?> 
					</small><br>
					<small class="font">
						<?php echo $orders[ 'toemail' ] ?>
					</small><br>
				</div>
			</div>
			<div class="col-md-12 font">
			<?php echo $orders[ 'content' ] ?>
			</div>
			<table class="table panel">
				<thead>
					<tr>
						<th class="col-md-6 font">
							<?php echo  lang( 'invoiceitemdescription' ) ?>
						</th>
						<th class="col-md-1 font">
							<?php echo  lang( 'quantity' ) ?>
						</th>
						<th class="col-md-1 font">
							<?php echo  lang( 'price' ) ?>
						</th>
						<th class="col-md-1 font">
							<?php echo  lang( 'discount' ) ?>
						</th>
						<th class="col-md-1 font">
							<?php echo  $appconfig['tax_label'] ?> <!-- Tax label from app settings -->
						</th>
						<th class="col-md-2 font">
							<?php echo  lang( 'total' ) ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($items as $item){ ?>
					<tr>
						<td class="text-left font">
							<?php echo '' . $item[ 'name' ] . '</b><br><small style="font-size:10px;line-height:10px">' . nl2br($item[ 'description' ]) . '</small>'; ?>
						</td>
						<td class="text-left font">
							<?php echo '' . amount_format($item[ 'quantity' ]). '' ?>
						</td>
						<td class="text-left font">
							<?php echo '' . amount_format($item[ 'price' ]) . ''; ?>
						</td>
						<td class="text-left font">
							<?php echo '' . amount_format($item[ 'discount' ]) . '%';?>
						</td>
						<td class="text-left font">
							<?php echo '' . amount_format($item[ 'tax' ]) . '%';?>
						</td>
						<td class="text-left font">
							<?php echo '' . amount_format($item[ 'total' ]) . '';?>
							<!-- You can change Number format as per your requirement
							i.e. number_format(number or amount, decimal_upto, decimal_separator, number_seperator)
							example: 1. number_format(12345.24, 3, '.', ',')  ===> 12,345.240 -->
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="col-md-12 col-xs-12 col-sm-12 panel" style="padding:0px">
				<div class="col-md-6 col-xs-6 col-sm-6 panel pull-left" style="padding: 0px;">
					
				</div>
				<div class="col-md-5 col-xs-5 col-sm-5 pull-right" style="padding: 0">
					<ul class="list-group">
						<li class="list-group-item">
							<strong class="font">
								<?php echo lang( 'subtotal' ); ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($orders[ 'sub_total' ], true). '' ?>
							</div>
						</li>
						<li class="list-group-item">
							<strong class="font">
								<?php echo lang( 'linediscount' ); ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($orders[ 'total_discount' ], true). '' ?>
							</div>
						</li>
						<li class="list-group-item">
							<strong class="font">
								<?php echo $appconfig['tax_label']; ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($orders[ 'total_tax' ], true). '' ?>
							</div>
						</li>
						<li class="list-group-item active">
							<strong class="font">
								<?php echo lang( 'total' ); ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($orders[ 'total' ], true). ''; ?>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
