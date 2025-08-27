<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Inventory_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9" ng-cloak>
      <div ng-show="inventoryLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
          <small><strong><?php echo lang('loading'). ' '. lang('inventory').'...' ?></strong></small></span>
        </p>
      </div>
    <md-toolbar ng-show="!inventoryLoader" class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 class="md-pl-10" flex md-truncate ng-bind="inventory.inventory_number+' '+inventory.product_name"></h2>
        <?php if (check_privilege('inventories', 'edit')) { ?> 
          <md-button ng-click="Update()" class="md-icon-button" aria-label="Update">
            <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
            <md-icon><i class="ion-compose  text-muted"></i></md-icon>
          </md-button>
        <?php } if (check_privilege('inventories', 'delete')) { ?> 
          <md-button ng-click="DeleteInventory()" class="md-icon-button" aria-label="Delete">
            <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
            <md-icon><i class="ion-trash-b  text-muted"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content ng-show="!inventoryLoader" class="bg-white">
      <div layout="row"layout="row" layout-wrap>
        <md-content class="bg-white" flex-gt-xs="50" flex-xs="100" style="border-right:1px solid #e0e0e0;">
          <md-list flex class="md-p-0 sm-p-0 lg-p-0">
            <md-list-item>
              <md-icon class="ion-pricetags icon"></md-icon>
              <strong flex md-truncate><?php echo lang('productcategory') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="inventory.category"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="ion-pricetags icon"></md-icon>
              <strong flex md-truncate><?php echo lang('product').' '.lang('type') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="inventory.product_type"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="mdi mdi-label"></md-icon>
              <strong flex md-truncate><?php echo lang('cost').' '.lang('price') ?></strong>
              <p class="text-right" flex md-truncate ng-bind-html="inventory.cost_price | currencyFormat:cur_code:null:true:cur_lct"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="mdi mdi-balance"></md-icon>
              <strong flex md-truncate><?php echo lang('warehouse') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="inventory.warehouse"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="mdi mdi-book"></md-icon>
              <strong flex md-truncate><?php echo lang('instock') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="inventory.stock_qty"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="ion-ios-barcode-outline"></md-icon>
              <strong flex md-truncate><?php echo lang('move_type') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="inventory.move_type"></p>
            </md-list-item>
          </md-list>
        </md-content>
      </div>
    </md-content>
  </div>
  <ciuis-sidebar></ciuis-sidebar>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('update') ?></md-truncate>
      </div>
    </md-toolbar>
      <md-content>
        <md-content layout-padding>
          <md-autocomplete
            md-input-name="autocompleteField"
            md-min-length="0"
            md-no-cache="true"
            md-selected-item="selectedProduct"
            md-search-text="inventory.product_name"
            md-items="product in GetProduct(inventory.product_name)"
            md-item-text="product.name"   
            md-require-match=""
            md-floating-label="<?php echo lang('productservice'); ?>">
            <md-item-template><span class="blur" ng-bind="product.product_number"></span> <strong md-highlight-text="inventory.product_name">{{product.name}}</strong></md-item-template>
          </md-autocomplete>
          <input class="min_input_width" type="hidden" ng-model="inventory.product_id">
          <bind-expression ng-init="selectedProduct.product_id = inventory.product_id" expression="selectedProduct.product_id" ng-model="inventory.product_id" />
          <input type="hidden" ng-model="selectedProduct.categoryid">
          <bind-expression ng-init="selectedProduct.categoryid = inventory.category_id" expression="selectedProduct.categoryid" ng-model="inventory.category_id" />
          <input type="hidden" ng-model="selectedProduct.product_type">
          <bind-expression ng-init="selectedProduct.product_type = inventory.product_type_id" expression="selectedProduct.product_type" ng-model="inventory.product_type_id" />
          <input type="hidden" ng-model="selectedProduct.warehouse_id">
          <bind-expression ng-init="selectedProduct.warehouse_id = inventory.warehouse_id" expression="selectedProduct.warehouse_id" ng-model="inventory.warehouse_id" />
          <div layout-gt-xs="row">
            <md-input-container class="md-block">
              <label><?php echo lang('productcategory'); ?></label>
              <input type="text" ng-model="inventory.category" disabled>
              <bind-expression ng-init="selectedProduct.category_name = inventory.category" expression="selectedProduct.category_name" ng-model="inventory.category" />
            </md-input-container>
            <md-input-container class="md-block">
              <label><?php echo lang('product').' '.lang('type'); ?></label>
              <input type="text" ng-model="inventory.product_type" disabled>
            </md-input-container>
          </div>
          <div layout-gt-xs="row">
            <md-input-container class="md-block">
              <label><?php echo lang('cost').' '.lang('price') ?></label>
              <input required type="text" ng-model="inventory.cost_price" class="form-control" id="amount" placeholder="0.00" disabled="" /><br />
              <bind-expression ng-init="selectedProduct.purchase_price = inventory.cost_price" expression="selectedProduct.purchase_price" ng-model="inventory.cost_price" />
            </md-input-container>
            <md-input-container class="md-block">
              <label><?php echo lang('warehouse'); ?></label>
              <input type="text" ng-model="inventory.warehouse" disabled>
              <bind-expression ng-init="selectedProduct.warehouse_name = inventory.warehouse" expression="selectedProduct.warehouse_name" ng-model="inventory.warehouse" />
            </md-input-container>
          </div>
          <div layout-gt-xs="row">
            <md-input-container class="md-block">
              <label><?php echo lang('stock').' '.lang('quantity') ?></label>
              <input type="text" ng-model="inventory.stock_qty" ng-value="0" class="form-control" id="stock" placeholder="<?php echo lang('stock').' '.lang('quantity') ?>" />
            </md-input-container>
            <md-input-container class="md-block">
              <md-select placeholder="<?php echo lang('move_type')?>" ng-model="inventory.move_type_id" style="min-width: 180px;">
                <md-option ng-repeat="move in movements" ng-value="move.movement_id">{{move.movement_name}}</md-option>
              </md-select><br />
            </md-input-container>
            <!-- <md-input-container class="md-block">
              <label><?php echo lang('warehouse'); ?></label>
              <md-select placeholder="<?php echo lang('warehouse'); ?>" ng-model="inventory.warehouse_id" style="min-width: 200px;">
                <md-select-header>
                  <md-toolbar class="toolbar-white">
                    <div class="md-toolbar-tools">
                      <h4 flex md-truncate><?php echo lang('warehouse') ?></h4>
                      <md-button class="md-icon-button" ng-click="NewWarehouse()" aria-label="Create New">
                        <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                      </md-button>
                    </div>
                  </md-toolbar>
                </md-select-header>
                <md-option ng-value="name.warehouse_id" ng-repeat="name in warehouses">{{name.warehouse_name}}</md-option>
              </md-select><br />
            </md-input-container> -->
          </div>
          <div layout-gt-xs="row" ng-show="inventory.move_type_id == 3">
            <md-input-container class="md-block">
              <label><?php echo lang('warehouse').' '.lang('from'); ?></label>
              <input type="text" ng-model="inventory.warehouse" disabled>
            </md-input-container>
            <md-input-container class="md-block">
              <label><?php echo lang('warehouse').' '.lang('to'); ?></label>
              <md-select placeholder="<?php echo lang('warehouse').' '.lang('to'); ?>" ng-model="inventory.warehouse_to" style="min-width: 180px;">
                <md-option ng-if="inventory.warehouse_id != name.warehouse_id" ng-value="name.warehouse_id" ng-repeat="name in warehouses">{{name.warehouse_name}}</md-option>
              </md-select><br />
            </md-input-container>
          </div>
        </md-content>
        <md-content layout-padding>
          <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="UpdateInventory()" class="md-raised md-primary pull-right block-button" ng-disabled="savingInventory == true">
              <span ng-hide="savingInventory == true"><?php echo lang('update'); ?></span>
              <md-progress-circular class="white" ng-show="savingInventory == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
          </section>
        </md-content>
      </md-content>
  </md-sidenav>
</div>
<script> 
  var INVENTORY_ID = "<?php echo $inventory['inventory_id'] ?>";
</script>
<script type="text/javascript">
  var lang = {};
  lang.attention = "<?php echo lang('attention') ?>";
  lang.doIt = "<?php echo lang('doIt') ?>";
  lang.cancel = "<?php echo lang('cancel') ?>";
  lang.delete = "<?php echo lang('delete') ?>";
  lang.delete_message = "<?php echo lang('delete_meesage').' '.lang('inventory') ?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script type="text/javascript" src="<?php echo base_url('assets/js/inventory.js') ?>"></script>
