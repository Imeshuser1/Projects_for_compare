<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Warehouse_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9" ng-cloak>
      <div ng-show="warehouseLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
          <small><strong><?php echo lang('loading'). ' '. lang('warehouse').'...' ?></strong></small></span>
        </p>
      </div>
    <md-toolbar ng-show="!warehouseLoader" class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 class="md-pl-10" flex md-truncate ng-bind="warehouse.warehouse_number+' '+warehouse.warehouse_name"></h2>
        <?php if (check_privilege('warehouses', 'edit')) { ?> 
          <md-button ng-click="Update()" class="md-icon-button" aria-label="Update">
            <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
            <md-icon><i class="ion-compose  text-muted"></i></md-icon>
          </md-button>
        <?php } if (check_privilege('warehouses', 'delete')) { ?> 
          <md-button ng-click="delete_warehouse()" class="md-icon-button" aria-label="Delete">
            <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
            <md-icon><i class="ion-trash-b  text-muted"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content ng-show="!warehouseLoader" class="bg-white">
      <div layout="row"layout="row" layout-wrap>
        <md-content class="bg-white" flex-gt-xs="50" flex-xs="100" style="border-right:1px solid #e0e0e0;">
          <md-list flex class="md-p-0 sm-p-0 lg-p-0">
            <md-list-item>
              <md-icon class="ion-earth"></md-icon>
              <strong flex md-truncate><?= lang('country') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="warehouse.country_name"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="mdi mdi-map"></md-icon>
              <strong flex md-truncate><?= lang('state') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="warehouse.state_name"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="mdi mdi-city"></md-icon>
              <strong flex md-truncate><?= lang('city') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="warehouse.city"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="mdi mdi-markunread-mailbox"></md-icon>
              <strong flex md-truncate><?= lang('zip') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="warehouse.zip"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="ion-android-call"></md-icon>
              <strong flex md-truncate><?= lang('phone') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="warehouse.phone"></p>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
              <md-icon class="ion-ios-home"></md-icon>
              <strong flex md-truncate><?= lang('address') ?></strong>
              <p class="text-right" flex md-truncate ng-bind="warehouse.address"></p>
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
          <md-truncate><?php echo lang('update').' '.lang('warehouse') ?></md-truncate>
        </div>
      </md-toolbar>
      <md-content>
        <md-content layout-padding>
          <md-input-container class="md-block">
            <label><?= lang('warehouse').' '.lang('name') ?></label>
            <input required type="text" ng-model="warehouse.warehouse_name" class="form-control" id="name" placeholder="<?= lang('warehouse').' '.lang('name') ?>" />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('phone'); ?></label>
            <input name="phone" ng-model="warehouse.phone" placeholder="<?= lang('phone') ?>">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('country'); ?></label>
            <md-select placeholder="<?= lang('country'); ?>" ng-model="warehouse.country" ng-change="getStates(warehouse.country)" name="country_id" style="min-width: 200px;">
              <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
            </md-select>
          </md-input-container>
          <br>
          <md-input-container class="md-block">
            <label><?= lang('state'); ?></label>
            <md-select placeholder="<?= lang('states'); ?>" ng-model="warehouse.state" name="state_id" style="min-width: 200px;">
              <md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
            </md-select><br />
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('city'); ?></label>
            <input name="city" ng-model="warehouse.city"  placeholder="<?= lang('city') ?>">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?= lang('zipcode'); ?></label>
            <input name="zipcode" ng-model="warehouse.zip"  placeholder="<?= lang('zipcode') ?>">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('address') ?></label>
            <textarea ng-model="warehouse.address" name="address" md-maxlength="500" rows="3" placeholder="<?= lang('address') ?>"></textarea>
          </md-input-container>
        <md-content layout-padding>
          <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="update_warehouse()" class="md-raised md-primary btn-report block-button"><?= lang('update'); ?></md-button>
          </section>
        </md-content>
      </md-content>
    </md-sidenav>
</div>
<script> 
  var warehouse_id = "<?php echo $warehouse['warehouse_id'] ?>";
</script>
<script type="text/javascript">
  var lang = {};
  lang.attention = "<?php echo lang('attention') ?>";
  lang.doIt = "<?php echo lang('doIt') ?>";
  lang.cancel = "<?php echo lang('cancel') ?>";
  lang.delete = "<?php echo lang('delete') ?>";
  lang.delete_message = "<?php echo lang('delete_meesage').' '.lang('warehouse') ?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url('assets/js/warehouses.js'); ?>"></script>

