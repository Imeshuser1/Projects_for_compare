<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo "File Manager" ?> <small>(<span ng-bind="expenses.length"></span>)</small><br>
					<small flex md-truncate><?php echo "Organise your files" ?></small>
				</h2>
			</div>
		</md-toolbar>

		<iframe src="<?php echo base_url('application/third_party/vendor/fm/dialog.php'); ?>" frameborder="0" style="height: 800px; overflow:scroll; width: 100%;" allowfullscreen></iframe>
	</div>

	<ciuis-sidebar></ciuis-sidebar>
</div>

<?php include_once(APPPATH . 'views/inc/other_footer.php'); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>