<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<div class="ciuis-body-content">
	<div ng-controller="Purchases_Controller" class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
					<md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo lang('newpurchase') ?></h2>
				<md-switch ng-model="purchase_status" aria-label="Status" ng-cloak><strong class="text-muted"><?php echo lang('paid') ?></strong></md-switch>
				<md-switch ng-model="purchase_recurring" aria-label="Recurring" ng-cloak>
					<strong class="text-muted"><?php echo lang('recurring') ?></strong>
				</md-switch>
				<md-button ng-href="<?php echo base_url('purchases') ?>" class="md-icon-button" aria-label="Save" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
					<md-icon><i class="ion-close-circled text-muted"></i></md-icon>
				</md-button>
				<?php if (check_privilege('purchases', 'create')) { ?>
					<md-button type="submit" ng-click="saveAll()" class="md-icon-button" aria-label="Save" ng-cloak>
						<md-progress-circular ng-show="savingPurchase == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
						<md-tooltip ng-hide="savingPurchase == true" md-direction="bottom"><?php echo lang('save') ?></md-tooltip>
						<md-icon ng-hide="savingPurchase == true"><i class="ion-checkmark-circled text-muted"></i></md-icon>
					</md-button>
				<?php } ?>
			</div>
		</md-toolbar>
		<md-content class="bg-white" layout-padding ng-cloak>
			<div layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-sm>
					<label><?php echo lang('serie') ?></label>
					<input ng-model="serie" name="serie">
				</md-input-container>
				<md-input-container class="md-block" flex-gt-sm>
					<label><?php echo lang('purchase_number') ?></label>
					<input ng-model="no" name="no">
				</md-input-container>
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('vendor'); ?></label>
					<md-select required placeholder="<?php echo lang('vendor'); ?>" ng-model="vendor" name="vendor" style="min-width: 200px;">
						<md-select-header>
							<md-toolbar class="toolbar-white">
								<div class="md-toolbar-tools">
									<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
										<md-icon><i class="ico-ciuis-customers text-muted"></i></md-icon>
									</md-button>
									<h2 flex md-truncate><?php echo lang('vendor') ?></h2>
									<md-button ng-href="<?php echo base_url('vendors') ?>" class="md-icon-button" aria-label="Create New">
										<md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
									</md-button>
								</div>
							</md-toolbar>
						</md-select-header>
						<md-option ng-value="vendor.id" ng-repeat="vendor in all_vendors">{{vendor.name}}</md-option>
					</md-select>
					<div ng-messages="userForm.customer" role="alert" multiple>
						<div ng-message="required" class="my-message"><?php //echo lang('you_must_supply_a_customer') 
																		?></div>
					</div>
				</md-input-container>
				<md-input-container>
					<label><?php echo lang('dateofissuance') ?></label>
					<md-datepicker name="created" ng-model="created" md-date-locale="locale" md-open-on-focus></md-datepicker>
				</md-input-container>
			</div>
			<div ng-show="purchase_status" layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('paidcashornank'); ?></label>
					<md-select placeholder="<?php echo lang('choiseaccount'); ?>" ng-model="account" name="account" style="min-width: 200px;">
						<md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
					</md-select>
					<div ng-messages="userForm.customer" role="alert" multiple>
						<div ng-message="required" class="my-message">You must supply a Vendor.</div>
					</div>
				</md-input-container>
				<md-input-container>
					<label><?php echo lang('datepaid') ?></label>
					<md-datepicker name="datepayment" ng-model="datepayment" md-date-locale="locale" md-open-on-focus></md-datepicker>
				</md-input-container>
			</div>
			<div ng-show="purchase_recurring" layout-gt-xs="row">
			<input name="recurring_id" ng-model="recurring_id" type="hidden">
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('recurring_period') ?></label>
					<input type="number" ng-model="recurring_period" name="recurring_period" min="0">
				</md-input-container>
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('recurring_type') ?></label>
					<md-select ng-model="recurring_type" name="recurring_type">
						<md-option value="0"><?php echo lang('days') ?></md-option>
						<md-option value="1" selected><?php echo lang('weeks') ?></md-option>
						<md-option value="2"><?php echo lang('months') ?></md-option>
						<md-option value="3"><?php echo lang('years') ?></md-option>
					</md-select>
				</md-input-container>
				<md-input-container>
					<label><?php echo lang('ends_on') ?></label>
					<md-datepicker name="EndRecurring" ng-model="EndRecurring" md-date-locale="locale" style="min-width: 100%;" md-open-on-focus></md-datepicker>
					<div>
						<div ng-message="required" class="my-message"><?php echo lang('leave_blank_for_lifetime') ?></div>
					</div>
				</md-input-container>
			</div>
			<div ng-show="!purchase_status" layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-sm>
					<label><?php echo lang('duenote') ?></label>
					<input ng-model="duenote" name="duenote">
				</md-input-container>
				<md-input-container ng-show="!purchase_status">
					<label><?php echo lang('duedate') ?></label>
					<md-datepicker name="duedate" md-min-date="created" ng-model="duedate" md-date-locale="locale" md-open-on-focus></md-datepicker>
				</md-input-container>
			</div>
		</md-content>
		<md-content class="bg-white" layout-padding ng-cloak>
			<md-list-item ng-repeat="item in purchase.items">
				<!--class added-->
				<div layout-gt-sm="row" class="total-line">
					<md-autocomplete md-autofocus md-items="product in GetProduct(item.name)" md-search-text="item.name" md-item-text="product.name" md-selected-item="selectedProduct" md-no-cache="true" md-min-length="0" md-floating-label="<?php echo lang('productservice'); ?>">
						<md-item-template>
							<span md-highlight-text="item.name">{{product.name}}</span>
							<strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong>
						</md-item-template>
					</md-autocomplete>
					<md-input-container class="md-block">
						<label><?php echo lang('description'); ?></label>
						<input class="min_input_width" type="hidden" ng-model="item.name">
						<bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
						<textarea class="min_input_width" ng-model="item.description" placeholder="<?php echo lang('description'); ?>"></textarea>
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
						<input type = "number" min ="1"  class="min_input_width" ng-model="item.quantity" style="min-width: 30px !important;">
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('unit'); ?></label>
						<md-select ng-model="item.unit" ng-disabled="selectedProduct.unit!=unit.name">
							<md-option ng-value="unit.name" ng-repeat="unit in units">{{unit.name}}</md-option>
						</md-select><br />
						<bind-expression ng-init="selectedProduct.unit = item.unit" expression="selectedProduct.unit" ng-model="item.unit" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('price'); ?></label>
						<input  type = "number" min ="0"  class="min_input_width" ng-model="item.price">
						<bind-expression ng-init="selectedProduct.price = 0" expression="selectedProduct.price" ng-model="item.price" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-xs>
						<label><?php echo $appconfig['tax_label']; ?></label>
						<input  type = "number" min ="0" class="min_input_width" ng-value="item.tax" ng-model="item.tax" style="min-width: 30px !important;">
						<bind-expression ng-init="selectedProduct.tax = 0" expression="selectedProduct.tax" ng-model="item.tax" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('discount'); ?></label>
						<input  type = "number" min ="1" class="min_input_width" ng-model="item.discount" style="min-width: 25px !important;">
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('total'); ?></label>
						<!--NaN-->
						<input  type = "number" min ="1" class="min_input_width" readonly=""  ng-value="sub_val(item)"/>
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
						<div class="text-right text-uppercase text-muted">Sub Total:</div>
						<div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted">Total Discount:</div>
						<div ng-show="totaltax() > 0" class="text-right text-uppercase text-muted">Total Tax:</div>
						<div class="text-right text-uppercase text-black">Grand Total:</div>
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
	</div>
</div>
<ciuis-sidebar></ciuis-sidebar>
<?php include_once(APPPATH . 'views/inc/other_footer.php'); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/purchases.js'); ?>"></script>