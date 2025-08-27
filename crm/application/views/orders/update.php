<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Order_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<?php echo form_open('orders/update', array("class" => "form-horizontal orderForm")); ?>
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true" ng-cloak>
					<md-icon><i class="ion-ios-filing-outline text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo lang('update') . ' ' . lang('order') ?></h2>
				<md-switch ng-model="order.comment" aria-label="comments"> <strong class="text-muted"><?php echo lang('allowcomments') ?></strong> </md-switch>
				<md-switch ng-model="order.recurring_status" aria-label="Recurring"> <strong class="text-muted"><?php echo lang('recurring') ?></strong> </md-switch>
				<md-button ng-href="<?php echo base_url('orders/order/{{order.id}}') ?>" class="md-icon-button" aria-label="Save" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
					<md-icon><i class="ion-close-circled text-muted"></i></md-icon>
				</md-button>
				<md-button ng-click="saveAll()" class="md-icon-button" aria-label="Save" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('save') ?></md-tooltip>
					<md-icon><i class="ion-checkmark-circled text-muted"></i></md-icon>
				</md-button>
			</div>
		</md-toolbar>
		<md-content class="bg-white" layout-padding ng-cloak>
			<div layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-sm>
					<label><?php echo lang('subject') ?></label>
					<input ng-model="order.subject" name="subject">
				</md-input-container>
				<md-input-container ng-show="order.order_type == false" class="md-block" flex-gt-xs>
					<label><?php echo lang('customer'); ?></label>
					<md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="order.customer"  ng-change="change_cus_address(order.customer)" name="customer" style="min-width: 200px;" data-md-container-class="selectdemoSelectHeader">
						<md-select-header class="demo-select-header">
							<label style="display: none;"><?php echo lang('search') . ' ' . lang('customer') ?></label>
							<input ng-submit="search_customers(search_input)" ng-model="search_input" type="text" placeholder="<?php echo lang('search') . ' ' . lang('customers') ?>" class="demo-header-searchbox md-text" ng-keyup="search_customers(search_input)">
						</md-select-header>
						<md-optgroup label="customers">
							<md-option ng-value="customer.id" ng-repeat="customer in all_customers">
								<span class="blur" ng-bind="customer.customer_number"></span>
								<span ng-bind="customer.name"></span><br>
								<span class="blur">(<small ng-bind="customer.email"></small>)</span>
							</md-option>
						</md-optgroup>
					</md-select>
					<div ng-messages="userForm.customer" role="alert" multiple>
						<div ng-message="required" class="my-message"><?php echo lang('you_must_supply_a_customer') ?>.</div>
					</div>
				</md-input-container>
				<md-input-container ng-show="order.order_type == true" class="md-block" flex-gt-xs>
					<label><?php echo lang('lead'); ?></label>
					<md-select required placeholder="<?php echo lang('choiselead'); ?>" ng-model="order.lead" name="lead" style="min-width: 200px;">
						<md-option ng-value="lead.id" ng-repeat="lead in leads">{{lead.name}}</md-option>
					</md-select>
					<div ng-messages="userForm.customer" role="alert" multiple>
						<div ng-message="required" class="my-message"><?php echo lang('you_must_supply_a_customer') ?>.</div>
					</div>
				</md-input-container>
				<md-input-container>
					<label><?php echo lang('dateofissuance') ?></label>
					<md-datepicker name="created" ng-model="order.date_edit" md-date-locale="locale" md-open-on-focus></md-datepicker>
				</md-input-container>
			</div>
			<div layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('assigned'); ?></label>
					<md-select required placeholder="<?php echo lang('assigned'); ?>" ng-model="order.assigned" name="assigned" style="min-width: 200px;">
						<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
					</md-select>
					<div ng-messages="userForm.assigned" role="alert" multiple>
						<div ng-message="required" class="my-message"><?php echo lang('must_supply_assigner') ?>.</div>
					</div>
				</md-input-container>
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('status'); ?></label>
					<md-select ng-init="statuses = [{id: 1,name: '<?php echo lang('draft'); ?>'}, {id: 2,name: '<?php echo lang('sent'); ?>'}, {id: 3,name: '<?php echo lang('open'); ?>'}, {id: 4,name: '<?php echo lang('revised'); ?>'}, {id:5,name: '<?php echo lang('declined'); ?>'}, {id: 6,name: '<?php echo lang('accepted'); ?>'}];" required placeholder="<?php echo lang('status'); ?>" ng-model="order.status" name="status" style="min-width: 200px;">
						<md-option ng-value="status.id" ng-repeat="status in statuses"><span class="text-uppercase">{{status.name}}</span></md-option>
					</md-select>
					<div ng-messages="userForm.status" role="alert" multiple>
						<div ng-message="required" class="my-message"><?php echo lang('must_select_status') ?>.</div>
					</div>
				</md-input-container>
				<md-input-container>
					<label><?php echo lang('opentill') ?></label>
					<md-datepicker name="opentill" md-mind-date="order.created_edit" ng-model="order.opentill_edit" md-date-locale="locale" md-open-on-focus></md-datepicker>
				</md-input-container>
			</div>
			<div ng-show="order.recurring_status" layout-gt-xs="row">
				<input name="recurring_id" ng-model="order.recurring_id" type="hidden">
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('recurring_period') ?></label>
					<input type="number" ng-model="order.recurring_period" name="recurring_period">
				</md-input-container>
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('recurring_type') ?></label>
					<md-select ng-model="order.recurring_type" name="recurring_type">
						<md-option value="0"><?php echo lang('days') ?></md-option>
						<md-option value="1" selected><?php echo lang('weeks') ?></md-option>
						<md-option value="2"><?php echo lang('months') ?></md-option>
						<md-option value="3"><?php echo lang('years') ?></md-option>
					</md-select>
				</md-input-container>
				<md-input-container>
					<label><?php echo lang('ends_on') ?></label>
					<md-datepicker md-min-date="date" name="recurring_enddate"   ng-model="order.recurring_enddate" md-date-locale="locale" md-open-on-focus></md-datepicker>
					<div>
						<div ng-message="required" class="my-message"><?php echo lang('leave_blank_for_lifetime') ?></div>
					</div>
				</md-input-container>
				
			</div>
			<div layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('detail') ?></label>
					<br>
					<textarea class="tinymce" id="content" ng-model="order.content" rows="2"></textarea>
					<div class="errors" ng-messages="Form.detail.$error" ng-show="submitted || Form.detail.$touched">
										<span ng-show="(Form.detail.$error.maxlength)" ng-message="maxlength"><?= lang('Detail', 'is too long.') ?></span>
									</div>
				</md-input-container>
			</div>
		</md-content>
		<md-content class="bg-white" layout-padding ng-cloak>
			<md-list-item ng-repeat="item in order.items">
				<div layout-gt-sm="row">
					<md-autocomplete md-autofocus md-items="product in GetProduct(item.name)" md-search-text="item.name" md-item-text="product.name" md-selected-item="selectedProduct" md-no-cache="true" md-min-length="0" md-floating-label="<?php echo lang('productservice'); ?>" placeholder="What is your favorite US state?">
						<md-item-template> <span md-highlight-text="item.name">{{product.name}}</span> <strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong> </md-item-template>
					</md-autocomplete>
					<md-input-container class="md-block">
						<label><?php echo lang('description'); ?></label>
						<input class="min_input_width" type="hidden" ng-model="item.name">
						<input class="min_input_width" type="hidden" ng-model="item.id">
						<bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
						<textarea class="min_input_width" ng-model="item.description"></textarea>
						<bind-expression ng-init="selectedProduct.description = item.description" expression="selectedProduct.description" ng-model="item.description" />
						<input class="min_input_width" type="hidden" ng-model="item.product_id">
						<bind-expression ng-init="selectedProduct.product_id = item.product_id" expression="selectedProduct.product_id" ng-model="item.product_id" />
						<input class="min_input_width" type="hidden" ng-model="item.code" ng-value="selectedProduct.code">
						<bind-expression ng-init="selectedProduct.code = item.code" expression="selectedProduct.code" ng-model="item.code" />
						<input class="min_input_width" type="hidden" ng-model="item.stock">
						<bind-expression ng-init="selectedProduct.stock = item.stock" expression="selectedProduct.stock" ng-model="item.stock" />
						<input class="min_input_width" type="hidden" ng-model="item.purchase_price">
						<bind-expression ng-init="selectedProduct.purchase_price = item.purchase_price" expression="selectedProduct.purchase_price" ng-model="item.purchase_price" />
						<input class="min_input_width" type="hidden" ng-model="item.categoryid">
						<bind-expression ng-init="selectedProduct.categoryid = item.categoryid" expression="selectedProduct.categoryid" ng-model="item.categoryid" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('type'); ?></label>
						<md-select ng-model="item.product_type" ng-disabled="selectedProduct.unit!=unit.name">
							<md-option ng-value="0"><?php echo lang('physical_item') . ' <small>(' . lang('inv_manage') . ' )</small>' ?></md-option>
							<md-option ng-value="1"><?php echo lang('service_item') . ' <small>(' . lang('non_inv_manage') . ' )</small>' ?></md-option>
							<md-option ng-value="2"><?php echo lang('digital_item') . ' <small>(' . lang('inv_manage') . ' )</small>' ?></md-option>
							<md-option ng-value="3"><?php echo lang('physical_item') . ' <small>(' . lang('non_inv_manage') . ' )</small>' ?></md-option>
							<md-option ng-value="4"><?php echo lang('digital_item') . ' <small>(' . lang('non_inv_manage') . ' )</small>' ?></md-option>
						</md-select><br />
						<bind-expression ng-init="selectedProduct.product_type = item.product_type" expression="selectedProduct.product_type" ng-model="item.product_type" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('warehouse'); ?></label>
						<md-select placeholder="<?php echo lang('warehouse'); ?>" ng-model="item.warehouse_id" class="min_input_width" ng-disabled="selectedProduct.unit!=unit.name">
							<md-option ng-value="name.warehouse_id" ng-repeat="name in warehouses">{{name.warehouse_name}}</md-option>
						</md-select>
						<bind-expression ng-init="selectedProduct.warehouse_id = item.warehouse_id" expression="selectedProduct.warehouse_id" ng-model="item.warehouse_id"></bind-expression>
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('quantity'); ?></label>
						<input type="number" min="1" type="text" class="min_input_width" ng-model="item.quantity" name="item.quantity" style="min-width: 30px !important;">
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('unit'); ?></label>
						<md-select ng-model="item.unit">
							<md-option ng-value="unit.name" ng-repeat="unit in units">{{unit.name}}</md-option>
						</md-select><br />
						<bind-expression ng-init="selectedProduct.unit = item.unit" expression="selectedProduct.unit" ng-model="item.unit" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('price'); ?></label>
						<input type="number" min="0" class="min_input_width" ng-model="item.price">
						<bind-expression ng-init="selectedProduct.price = item.price" expression="selectedProduct.price" ng-model="item.price" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo $appconfig['tax_label']; ?></label>
						<input type="number" min="0" class="min_input_width" ng-value="item.tax" ng-model="item.tax" style="min-width: 30px !important;">
						<bind-expression ng-init="selectedProduct.tax = item.tax" expression="selectedProduct.tax" ng-model="item.tax" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('discount'); ?></label>
						<input type="number" min="1" class="min_input_width" ng-model="item.discount" style="min-width: 30px !important;">
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('total'); ?></label>
						<input type="number" min="0" readonly="" class="min_input_width" ng-value="sub_val(item)">
					</md-input-container>
				</div>
				<md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b text-muted"></md-icon>
			</md-list-item>
			<md-content class="bg-white" layout-padding>
				<div class="col-md-6">
					<md-button ng-click="add()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
						<md-icon class="ion-plus-round text-muted"></md-icon>
					</md-button>
				</div>
				<div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
					<div class="col-md-7">
						<div class="text-right text-uppercase text-muted"><?php echo lang('sub_total') ?>:</div>
						<div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
						<div ng-show="totaltax() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total') . ' ' . $appconfig['tax_label'] ?>:</div>
						<div class="text-right text-uppercase text-black"><?php echo lang('grand_total') ?>:</div>
					</div>
					<div class="col-md-5">
						<div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
						<div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
						<div ng-show="totaltax() > 0" class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
						<div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
					</div>
				</div>
			</md-content>
		</md-content>
		<?php echo form_close(); ?>
		<script>
			var ORDERID = <?php echo $order['id']; ?>;
		</script>
	</div>
	<div ng-show="!orderLoader" class="main-content container-fluid lg-pl-0 col-xs-12 col-md-12 col-lg-3" ng-cloak>
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
					<md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo lang('billing_and_shipping_details'); ?></h2>
			</div>
		</md-toolbar>
		<md-subheader class="md-primary bg-white text-uppercase text-bold"><?php echo lang('billing_address'); ?></md-subheader>
		<md-divider></md-divider>
		<md-content layout-padding class="bg-white">
		<address class="m-t-5 m-b-5">
			<strong ng-bind="order.billing_street"></strong><br>
			<span ng-bind="order.billing_city"></span> / <span ng-bind="order.billing_state"></span> <span ng-bind="order.billing_zip"></span><br>
			<strong ng-bind="order.billing_country"></strong>
			<!-- <srong ng-bind="invoice.billing_country_id"></srong> -->
			</address>
			<md-content ng-if='EditBilling == true' layout-padding class="bg-white">
				<md-input-container class="md-block">
					<label><?php echo lang('address') ?></label>
					<textarea ng-model="order.billing_street" md-maxlength="500" rows="2" md-select-on-focus></textarea>
				</md-input-container>
				<md-input-container class="md-block">
					<md-select placeholder="<?php echo lang('country'); ?>" ng-model="order.billing_country_id" ng-change="getBillingStates(order.billing_country_id)" name="billing_country" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select><br />
				</md-input-container>
				<br />
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<md-select placeholder="<?php echo lang('state'); ?>" ng-model="order.billing_state_id" name="billing_state_id" style="min-width: 200px;">
						<md-option ng-value="state.id" ng-repeat="state in billingStates">{{state.state_name}}</md-option>
					</md-select>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="order.billing_city">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('zipcode'); ?></label>
					<input name="zipcode" ng-model="order.billing_zip">
				</md-input-container>
			</md-content>
			<md-switch ng-model="NeedShippingAddress" aria-label="Status"><strong class="text-muted"><?php echo lang('need_shipping_address'); ?></strong></md-switch>
			<md-button ng-show='EditBilling == false' ng-click="EditBilling = true" ng-init="EditBilling=false" class="md-icon-button pull-right" aria-label="Edit">
				<md-icon><i class="mdi mdi-edit text-muted"></i></md-icon>
				<md-tooltip md-direction="left"><?php echo lang('edit'); ?></md-tooltip>
			</md-button>
			<md-button ng-show='EditBilling == true' ng-click="EditBilling = false" class="md-icon-button pull-right" aria-label="Hide Billing Form">
				<md-icon><i class="mdi mdi-minus-circle-outline text-muted"></i></md-icon>
				<md-tooltip md-direction="left"><?php echo lang('hide'); ?></md-tooltip>
			</md-button>
			<!-- <md-button ng-click='copy_shipping_from_bill_to()' class="md-icon-button pull-right" aria-label="Billing Copy">
				<md-icon><i class="mdi mdi-copy text-muted"></i></md-icon>
				<md-tooltip md-direction="left"><?php echo lang('bill_to'); ?></md-tooltip>
			</md-button> -->
		</md-content>
		<md-divider></md-divider>
		<md-subheader ng-show='NeedShippingAddress == true' class="md-primary bg-white text-uppercase text-bold"><?php echo lang('shipping_address'); ?></md-subheader>
		<md-divider ng-show='NeedShippingAddress == true'></md-divider>
		<md-content ng-show='NeedShippingAddress == true' layout-padding class="bg-white">
			<address ng-hide='EditShipping == true' class="m-t-5 m-b-5">
				<strong ng-bind="order.shipping_street"></strong><br>
				<span ng-bind="order.shipping_city"></span> / <span ng-bind="order.shipping_state"></span> <span ng-bind="order.shipping_zip"></span><br>
				<strong ng-bind="order.shipping_country"></strong>
				<!-- <srong ng-bind="invoice.shipping_country.id"></srong> -->
			</address>
			<md-content ng-show='EditShipping == true' layout-padding class="bg-white">
				<md-input-container class="md-block">
					<label><?php echo lang('address') ?></label>
					<textarea ng-model="order.shipping_street" md-maxlength="500" rows="2" md-select-on-focus></textarea>
				</md-input-container>
				<md-input-container class="md-block">
					<md-select placeholder="<?php echo lang('country'); ?>" ng-model="order.shipping_country_id" ng-change="getShippingStates(order.shipping_country_id)" name="shipping_country_id" style="min-width: 200px;">
						<md-option ng-value="{{country.id}}" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select><br>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<md-select placeholder="<?php echo lang('state'); ?>" ng-model="order.shipping_state_id" name="shipping_state_id" style="min-width: 200px;">
						<md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
					</md-select>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="order.shipping_city">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('zipcode'); ?></label>
					<input name="zipcode" ng-model="order.shipping_zip">
				</md-input-container>
				<bind-expression ng-init="order.shipping_country = '----'" expression="customer.shipping_country" ng-model="order.shipping_country" />
			</md-content>
			<md-button ng-show='EditShipping == false' ng-click="EditShipping = true" ng-init="EditShipping=false" class="md-icon-button pull-right" aria-label="Edit">
				<md-icon><i class="mdi mdi-edit text-muted"></i></md-icon>
				<md-tooltip md-direction="left"><?php echo lang('edit'); ?></md-tooltip>
			</md-button>
			<md-button ng-show='EditShipping == true' ng-click="EditShipping = false" class="md-icon-button pull-right" aria-label="Hide Form">
				<md-icon><i class="mdi mdi-minus-circle-outline text-muted"></i></md-icon>
				<md-tooltip md-direction="left"><?php echo lang('hide'); ?></md-tooltip>
			</md-button>
			<md-button ng-click='copy_shipping_from_bill_to()' class="md-icon-button pull-right" aria-label="Cop Shipping">
				<md-icon><i class="mdi mdi-copy text-muted"></i></md-icon>
				<md-tooltip md-direction="left"><?php echo lang('bill_to'); ?></md-tooltip>
			</md-button>
		</md-content>
		<md-content class="bg-white">
			<custom-fields-vertical></custom-fields-vertical>
			</md-toolbar>
			<md-divider></md-divider>
		</md-content>
	</div>
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script src="<?php echo base_url('assets/lib/tinymce/tinymce.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<script type="text/javascript">
	tinymce.init({
		selector: '#content',
		mode: "specific_textareas",
		themes: "modern",
		// force_br_newlines : false,
      	// force_p_newlines : false,
		// force_button: false,
      	// forced_root_block : '',
		//height: 200,
		editor_selector: "mceEditor",
		//themes: "modern",
		valid_elements: '*',
		valid_styles: '*',
		plugins: 'print preview paste importcss searchreplace autolink save directionality code visualblocks visualchars image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
		//body_class: 'my_class',
		valid_children: "+body[style]",
		valid_elements: "@[id|class|title|style]," +
			"a[name|href|target|title|alt]," +
			"#p,-ol,,div,h1,h2,h3,h4,h5,h6,strong,-ul,-li,br,img[src|unselectable],-sub,-sup,-b,-i,-u," +
			"-span[data-mce-type],hr",

		valid_child_elements: "body[p,ol,ul,div,h1,h2,h3,h4,h5,h6,strong,b]" +
			",p[a|span|b|i|u|sup|sub|img|hr|#text]" +
			",span[a|b|i|u|sup|sub|img|#text]" +
			",a[span|b|i|u|sup|sub|img|#text]" +
			",b[span|a|i|u|sup|sub|img|#text]" +
			",i[span|a|b|u|sup|sub|img|#text]" +
			",sup[span|a|i|b|u|sub|img|#text]" +
			",sub[span|a|i|b|u|sup|img|#text]" +
			",li[span|a|b|i|u|sup|sub|img|ol|ul|#text]" +
			",ol[li]" +
			",ul[li]",
		content_css: [
			//fonts.googleapis.com/css?family=Lato:300,300i,400,400i’,
			//www.tinymce.com/css/codepen.min.css’
		],
		toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | preview save print | insertfile image media template link anchor codesample | ltr rtl',
	});
</script>