<?php $appconfig = get_appconfig(); ?>
<?php $number = get_number('proposals',$proposals['id'],'proposal','proposal');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <!-- Encoding utf8 chartset for the pdf -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/bootstrap/dist/css/bootstrap.css'); ?>"/> <!-- Bootstrap CSS file link -->
	<style>
		.list-group-item.active,
		.list-group-item.active:focus,
		.list-group-item.active:hover {
			z-index: 2;
			color: #fff;
			background-color: #555;
			border-color: #555;
		}
		.font{
			font-family: DejaVu Sans; sans-serif;
		}
		/*Custom CSS write/paste here*/
	</style>
</head>
<?php if($proposals['relation_type'] == 'customer'){if($proposals['customercompany']===NULL) /*Customer type i.e individual or company */ { $customer = $proposals['namesurname'];} else $customer = $proposals['customercompany'];} ?>
<?php if($proposals['relation_type'] == 'lead'){$customer = $proposals['leadname'];} 

// Proposal logo
$logo = base_url ('uploads/ciuis_settings/' . $settings['app_logo']);
?>
<body>
	<div class="container">
		<div class="row">
			<div class="page-header">
				<img height="75px" src="<?php echo $logo ?>" alt="">
				<small class="pull-right" style="position:relative;top:20px;right:20px;"><strong><span class="text-uppercase"><?php echo lang('proposal') ?></span> <br> <!--  Proposal Title in your language -->
					#<?php echo '' . $number. '' ?> <!-- Proposal number -->
					<br> <?php echo lang( 'date' ).': '. //Date label 
					date(get_dateFormat(), strtotime($proposals['date']))?> - <?php echo lang( 'opentill' )?> : <?php echo date(get_dateFormat(), strtotime($proposals['opentill']))?>
					<!-- Proposal issuance and ending date -->
					</strong></small>
			</div>
			<div class="col-md-12 nav panel" style="padding-bottom: 30px">
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0">
					<strong><?php echo lang('from') ?></strong><br>
					<hr>
					<small>
						<strong><?php echo ($settings['company']) ? $settings['company'] : ""	; ?></strong>  <!-- Company Name from app settings -->
					</small>
					<br>
					<small>
						<!-- Company Address -->
						<?php echo '' .($settings[ 'town' ] ? $settings[ 'town' ].'/' : '').($settings[ 'city' ] ? $settings[ 'city' ].'/':'').($state ? $state.'/' : '').($country ? $country.'-':'').($settings[ 'zipcode' ] ? $settings[ 'zipcode' ] : '')  ?>
					</small><br>
					<small>
						<!-- Company Phone -->
						<?php echo $settings[ 'phone' ]; ?>
					</small><br>
					<small>
						<!-- Company Taxoffice & vatnumber -->
						<!-- You can remove these if don't want to display these in pdf -->
						<strong><?php echo  ($settings[ 'taxoffice' ] ? $appconfig['tax_label'].' '.lang('taxoffice').':' : '') ?></strong><?php echo $settings[ 'taxoffice' ]; ?>
					</small><br>
					<small>
						<?php echo '<strong>'.($settings[ 'vatnumber' ] ? $appconfig['tax_label'].' '.lang( 'vatnumber' ).':' : '') .'</strong>' . $settings[ 'vatnumber' ] . ''; ?>
					</small>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0">
					<!-- Customer Details -->
					<strong><?php echo lang('to') ?></strong><br>
					<hr>
					<small>
						<strong><?php echo $customer; ?></strong>
					</small>
					<br>
					<small>
						<?php echo ($proposals[ 'toaddress' ] ? $proposals[ 'toaddress' ].'/' : ''); ?><?php echo ($proposals[ 'city' ] ? $proposals[ 'city' ].'/' : ''); ?><?php echo ($custstate ? $custstate.'/' : '') ; ?><?php echo ($custcountry ? $custcountry :''); ?><?php echo ($proposals[ 'zip' ] ? '- '.$proposals[ 'zip' ] : ''); ?> 
					</small><br>
					<small>
						<?php echo $proposals[ 'toemail' ]; ?>
					</small><br>
				</div>
			</div>
		<!--pdf deatils-->
		<div class="col-md-12">
			<strong class="font"><?php echo lang('Details') ?></strong><br> 
			<hr>
		<?php
			if(is_rtl($proposals[ 'content' ])){?>
			<small class="font" style="direction: rtl; text-align: right;">
				<?php echo ($proposals[ 'content' ] ? $proposals[ 'content' ].' ' : ''); ?>	
			</small>
		<?php
			}else { ?>
			<small class="font">
				<?php echo ($proposals[ 'content' ] ? $proposals[ 'content' ].' ' : ''); ?>	
			</small>
		<?php } ?>	
	</div>
			<!--end of pdf deatils-->	
		
			<table class="table panel">
				<thead>
					<tr>
						<th class="col-md-6">
							<?php echo  lang( 'invoiceitemdescription' ) ?>
						</th>
						<th class="col-md-1">
							<?php echo  lang( 'quantity' ) ?>
						</th>
						<th class="col-md-1">
							<?php echo  lang( 'unit' ) ?>
						</th>
						<th class="col-md-1">
							<?php echo  lang( 'price' ) ?>
						</th>
						<th class="col-md-1">
							<?php echo  lang( 'discount' ) ?>
						</th>
						<th class="col-md-1">
							<?php echo  $appconfig['tax_label'] ?> <!-- Tax label from app settings -->
						</th>
						<th class="col-md-2">
							<?php echo  lang( 'total' ) ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($items as $item){ ?>
					<tr>
					<td class="text-left font">
							<?php echo '' . $item[ 'name' ] . '</b><br>'; ?>
						<?php
						if(is_rtl($item[ 'description' ])){?>
							<small class="font" style="direction: rtl; text-align: right; font-size:10px;line-height:10px; ">
						<?php echo ($item[ 'description' ] ? $item[ 'description' ].' ' : ''); ?>	
						</small>
					<?php
						}else { ?>
						<small class="font" style ="direction: rtl; text-align: right; font-size:10px;line-height:10px;">
					<?php echo ($item[ 'description' ] ? $item[ 'description' ].' ' : ''); ?>	
						</small>
					<?php } ?>
				</td>
						<td class="text-left">
							<?php echo '' . amount_format($item[ 'quantity' ]). '' ?>
						</td>
						<td class="text-left">
							<?=  $item[ 'unit' ] ?>
						</td>
						<td class="text-left">
							<?php echo '' . amount_format($item[ 'price' ]) . ''; ?>
						</td>
						<td class="text-left">
							<?php echo '' . amount_format($item[ 'discount' ]) . '%';?>
						</td>
						<td class="text-left">
							<?php echo '' . amount_format($item[ 'tax' ]) . '%';?>
						</td>
						<td class="text-left">
							<?php echo '' . amount_format($item[ 'total' ]) . '' ;?>
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
							<strong>
								<?php echo lang( 'subtotal' ); ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($proposals[ 'sub_total' ], true). '' ?>
							</div>
						</li>
						<li class="list-group-item">
							<strong>
								<?php echo lang( 'linediscount' ); ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($proposals[ 'total_discount' ], true). '' ?>
							</div>
						</li>
						<li class="list-group-item">
							<strong>
								<?php echo $appconfig['tax_label']; ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($proposals[ 'total_tax' ], true). '' ?>
							</div>
						</li>
						<li class="list-group-item active">
							<strong>
								<?php echo lang( 'total' ); ?>
							</strong>
							<div class="pull-right font">
								<?php echo '' . amount_format($proposals[ 'total' ], true). '' ?>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>