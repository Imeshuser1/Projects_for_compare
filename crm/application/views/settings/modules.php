<style>
    .module_img_container {
        background-size:contain;
        position: relative;
    }
    .module_parent {
        display: flex;
    }
    .module_child {
        flex: 1;
        padding: 1em;
    }
    .module_card {
        height:100%;
        position: relative;
    }
    .module_img {
        position:relative;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .version {
        position: absolute;
        background-color: white;
        border-radius: 5px;
        width: fit-content;
        padding: 5px;
        margin-top: 5px;
        margin-right: 5px;
        right: 0;
    }
</style>

<md-content class="md-padding module_parent" layout-xs="column" layout="row">
    <br><br>
    <!-- <div flex-xs flex-sm="50" flex-md="30" flex-lg="25" flex-xl="20" layout="column" class="module_child">
        <md-card class="module_card">
            <figure class="module_img_container">
                <img src="<?php echo base_url('assets/img/modules/mollie.png') ?>" class="module_img">
            </figure>
            <p class="version">Version:<span ng-bind="MollieUsing">1.0</span></p>
            <md-card-actions layout="row" layout-align="end center">
                <md-button ng-show="!isMollieActivated" ng-click="window.href='https://suisesoft.tech/product/ciuis-crm-mollie/'" class="md-raised md-primary primary-button">Buy</md-button>
                <md-button ng-show="!isMollieActivated" ng-click="activateModuleToggle('mollie')" class="md-raised md-primary primary-button">Activate</md-button>
                <md-button ng-show="isMollieActivated" ng-click="CheckModuleVersion('mollie')" class="md-raised md-primary primary-button">Update</md-button>
                <md-button ng-show="isMollieActivated" ng-click="deactivateModuleToggle('mollie')" class="md-raised md-primary primary-button">Deactivate</md-button>
            </md-card-actions>
            <md-card-content style="padding: unset;">
                <div class="panel">
                    <div class="panel-heading" role="tab">Mollie Payment Gateway</div>
                    <div style="padding: 10px;text-align: justify;">
                        Mollie helps businesses of all sizes to sell and build more efficiently with a solid but easy-to-use payment solution. Start growing your business today with effortless payments.
                    </div>
                    <div style="margin: 10px;margin-top: 10%;border: 1px dotted #ebebeb;padding: 5px;border-radius: 2px" ng-show="isMollieActivated">
                        <p ng-show="isMollieAvailable || isMollieUptoDate || MollieUsing">
                            <span ng-show="MollieUsing" class="text-warning text-bold">
                                Current Version: <strong ng-bind="MollieUsing">0.1</strong>
                            </span>
                            <br>
                            <span>
                                <strong class="text-success" ng-show="isMollieAvailable">Available Version: <strong ng-bind="MollieAvailable">0.2</strong></strong><br>
                                <strong ng-bind="MollieChangelog">Changelog:</strong><br>
                                <span></span>
                                <strong class="text-success" ng-show="isMollieUptoDate">Module is up to date</strong>
                            </span>
                        </p>
                        <md-button ng-show="isMollieAvailable" style="margin: unset;" ng-click="DownloadModuleUpdate('mollie')" md-no-ink class="md-primary md-raised"> Download Update </md-button>
                        <md-button ng-show="!isMollieAvailable" style="margin: unset;" ng-click="CheckModuleVersion('mollie')" md-no-ink class="md-primary">
                            Check For Update
                        </md-button>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div> -->
    <div flex-xs flex-sm="50" flex-md="30" flex-lg="25" flex-xl="20" layout="column" class="module_child">
        <md-card class="module_card">
            <figure class="module_img_container">
                <img src="<?php echo base_url('assets/img/modules/hr.png') ?>" class="module_img">
            </figure>
            <p ng-show="isHrmActivated" class="version">Version:<span ng-bind="HrmUsing">1.0</span></p>
            <md-card-actions layout="row" layout-align="end center">
                <md-button ng-show="!isHrmActivated" onclick="window.open('https://suisesoft.tech/product/ciuis-crm-hr-module/','_blank')" class="md-raised md-primary primary-button">Buy</md-button>
                <md-button ng-show="!isHrmActivated" ng-click="activateModuleToggle('hrm')" class="md-raised md-primary primary-button">Activate
                    <md-progress-circular ng-show="checkingModuleVersion == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                    <md-tooltip ng-hide="checkingModuleVersion == true" md-direction="bottom">Activate</md-tooltip>
                </md-button>
                <md-button ng-show="isHrmActivated" ng-click="CheckModuleVersion('hrm')" class="md-raised md-primary primary-button">
                    <md-progress-circular ng-show="checkingModuleVersion == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                    <md-tooltip ng-hide="checkingModuleVersion == true" md-direction="bottom">Update</md-tooltip>
                    Update
                </md-button>
                <md-button ng-show="isHrmActivated" ng-click="deactivateModuleToggle('hrm')" class="md-raised md-primary primary-button">Deactivate</md-button>
            </md-card-actions>
            <md-card-content style="padding: unset;">
                <div class="panel">
                    <div class="panel-heading" role="tab">HR Module</div>
                    <div style="padding: 10px;text-align: justify;">
                        HR Module Details
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>
</md-content>