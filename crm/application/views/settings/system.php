<md-content class="md-padding bg-white">
    <div class="col-md-12">
        <div class="form-group clearfix" style="border-bottom: 1px solid gray;">
            <h4 class="pull-left" ><strong><?php echo lang('system').' '.lang('settings'); ?></strong></h4>
            <?php if (check_privilege('settings', 'edit')) { ?>
                <md-button ng-click="uploadAppFiles()" class="md-raised md-primary pull-right successButton">
                    <md-icon>
                        <i class="ion-android-upload"></i>
                    </md-icon>
                    <?php echo lang('debug');?>
                </md-button>
                <md-button ng-click="RunMySQL()" class="md-raised md-primary pull-right successButton"  ng-show="settings_detail.is_mysql == '1'">
                    <md-icon>
                        <i class="ion-social-buffer"></i>
                    </md-icon>
                    <?php echo lang('mysql');?>
                </md-button>
                <md-button ng-click="UninstallLicense()" class="md-raised md-primary pull-right successButton">
                    <md-icon>
                        <i class="ion-unlocked"></i>
                    </md-icon>
                    <?php echo lang('uninstall_license');?>
                </md-button>
                <md-button ng-href="<?php echo base_url('editor') ?>" class="md-raised md-primary pull-right successButton">
                    <md-icon>
                        <i class="ion-ios-compose-outline"></i>
                    </md-icon>
                    <?php echo lang('editor');?>
                </md-button>
            <?php } ?>
            <md-button ng-click="systemInfo()" class="md-raised md-primary pull-right successButton">
                <md-icon>
                    <i class="ion-information-circled"></i>
                </md-icon>
                <?php echo lang('system');?>
            </md-button>
        </div>
    </div>
	<div class="col-md-6">
		<h3 class="md-title"><?= lang('header'); ?></h3>
		<pre id="ace_header" class="ace_editor_this" style="min-height:17em;"></pre>
		<!-- <textarea ng-model="system.header"></textarea> -->
		<h3 class="md-title"><?= lang('footer'); ?></h3>
		<pre id="ace_footer" class="ace_editor_this" style="min-height:17em;"></pre>
		<!-- <textarea ng-model="system.footer"></textarea> -->

		<!-- <textarea ng-model="system.custom_css"></textarea> -->
	</div>
	<div class="col-md-6">
		<h3 class="md-title"><?= lang('custom') . ' ' . lang('css'); ?></h3>
		<pre id="ace_custom_css" class="ace_editor_this" style="min-height:38.3em;"></pre>
	</div>
</md-content>
<style type="text/css" media="screen">
	.ace_editor_this {
		overflow-y: auto;
		overflow-x: hidden;
		/* min-height: 70vh !important; */
		z-index: 999;
	}

	.ace-twilight .ace_print-margin {
		display: none;
	}

	.ace_scrollbar-h {
		overflow-x: hidden !important;
	}
</style>
<script src="<?php echo base_url('assets/lib/editor/ace.js') ?>"></script>
<script>
	var editors = new Object();
</script>