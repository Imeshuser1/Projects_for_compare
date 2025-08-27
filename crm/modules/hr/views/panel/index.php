<?php include_once(FCPATH . 'modules/hr/views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<!-- <?php //var_dump($this->session->userdata('usr_id'));die; ?> -->
<div class="ciuis-body-content" ng_controller="Panel_controller">

	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-content class="bg-white ciuis-home-summary-top">
			<div class="col-md-3 col-sm-3 col-lg-3 nopadding">
				<md-toolbar class="toolbar-white" style="border-right:1px solid #e0e0e0">
					<div class="md-toolbar-tools">
						<h4 class="text-muted" flex md-truncate ><strong><?php echo lang('panelsummary')?></strong></h4>					
						<md-button class="md-icon-button" aria-label="Actions" ng-cloak>
							<md-icon><span class="ion-flag text-muted"></span></md-icon>
						</md-button>
					</div>
				</md-toolbar>

			</div>
			<div class="col-sm-9 xs-p-0">
				<md-toolbar class="toolbar-white">
					<div class="md-toolbar-tools">
						<h4 class="text-muted" flex md-truncate ><strong><?php echo lang('welcome')?></strong></h4>

					</div>
				</md-toolbar> 
				<md-content layout-padding class="bg-white ciuis-summary-two" style="overflow: hidden;">


				</md-content>
			</div>
		</md-content>
	</div>

	<ciuis-sidebar></ciuis-sidebar>
</div>
<script type="text/javascript">
	var lang = {};

</script>
  <?php include_once( FCPATH . 'modules/hr/views/inc/footer.php' );?>
<script type="text/javascript" src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/lib/chartjs/dist/Chart.min.js'); ?>" type="text/javascript"></script>
<script src='<?php echo base_url('modules/hr/assets/js/Hrm.js'); ?>'></script>

