</md-content>
<script type="text/javascript">
  var dateFormat = "<?php echo get_dateFormat(); ?>";
</script>
<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/Ciuis.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/moment.js/min/moment.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/bootstrap/dist/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/jquery.gritter/js/jquery.gritter.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/angular-datepicker/src/js/angular-datepicker.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/material/angular-material.min.js') ?>"></script>
<script src="<?php echo base_url('assets/lib/currency-format/currency-format.min.js') ?>"></script>
<script src="<?php echo base_url('assets/lib/angular-datetimepicker/angular-material-datetimepicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/lib/data-table/md-data-table.min.js'); ?>"></script>
<?php include_once(APPPATH . 'views/inc/templates.php'); ?>
<script type="text/javascript">
  <?php $newreminder = $this->Report_Model->newreminder(); ?>
  <?php $openticket = $this->Report_Model->otc(); ?>
  <?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>

  <?php if ($this->session->flashdata('ntf1')) { ?>
    $.gritter.add({
      title: '<b><?php echo lang('notification') ?></b>',
      text: '<?php echo $this->session->flashdata('ntf1'); ?>',
      class_name: 'color success'
    });
  <?php } ?>
  <?php if ($this->session->flashdata('ntf2')) { ?>
    $.gritter.add({
      title: '<b><?php echo lang('notification') ?></b>',
      text: '<?php echo $this->session->flashdata('ntf2'); ?>',
      class_name: 'color primary'
    });
  <?php } ?>
  <?php if ($this->session->flashdata('ntf3')) { ?>
    $.gritter.add({
      title: '<b><?php echo lang('notification') ?></b>',
      text: '<?php echo $this->session->flashdata('ntf3'); ?>',
      class_name: 'color warning'
    });
  <?php } ?>
  <?php if ($this->session->flashdata('ntf4')) { ?>
    $.gritter.add({
      title: '<b><?php echo lang('notification') ?></b>',
      text: '<?php echo $this->session->flashdata('ntf4'); ?>',
      class_name: 'color danger'
    });
  <?php } ?>
  <?php if ($this->session->flashdata('login_notification')) {
    if ($this->session->userdata('admin')) { ?>
      $.gritter.add({
        title: '<?php echo lang('welcome_message') . '! ' . $this->session->userdata('staffname'); ?>',
        text: '<?php echo $this->session->userdata('admin_notification'); ?>',
        image: '<?php echo base_url(); ?>uploads/images/<?php echo $this->session->userdata('staffavatar'); ?>',
        class_name: 'img-rounded',
        time: '',
      });
    <?php } else { ?>
      $.gritter.add({
        title: '<?php echo lang('welcome_message') . '! ' . $this->session->userdata('staffname'); ?>',
        text: '<?php echo lang('login_message') ?>',
        image: '<?php echo base_url(); ?>uploads/images/<?php echo $this->session->userdata('staffavatar'); ?>',
        class_name: 'img-rounded',
        time: '',
      });
    <?php } ?>

  <?php } ?>
</script>

</body>

</html>