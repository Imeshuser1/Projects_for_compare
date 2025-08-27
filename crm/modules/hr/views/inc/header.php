<?php $rebrand = load_config();
$appconfig = get_appconfig();
$menus = get_hr_menu();
$leftmenus = get_hr_leftmenu();
$user_data = get_user(); 
$app_logo = base_url('uploads/ciuis_settings/'.$user_data['settings']['logo']);
$app_logo_alternate = base_url('assets/img/placeholder.png');
$user_image = base_url('uploads/images/'.$user_data['avatar']);
$user_image_alternate = base_url('uploads/images/n-img.jpg');
?>
<!DOCTYPE html>
<html ng-app="Hrm" lang="<?php echo lang('lang_code');?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo $rebrand['meta_description'] ?>">
  <meta name="keywords" content="<?php echo $rebrand['meta_keywords'] ?>">
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/images/' . $rebrand['favicon_icon'] . ''); ?>">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('modules/hr/assets/css/hr.css'); ?>" type="text/css" />
  <script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/lib/angular/angular-animate.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/lib/angular/angular-aria.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/lib/angular/i18n/angular-locale_' . lang('lang_code_dash') . '.js'); ?>">
  </script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/data-table/md-data-table.min.css'); ?>">
  <script>
  var BASE_URL = "<?php echo base_url(); ?>",
    update_error = "<?php echo lang('update_error'); ?>",
    email_error = "<?php echo lang('email_error'); ?>",
    ACTIVESTAFF = "<?php echo $this->session->userdata('usr_id'); ?>",
    SHOW_ONLY_ADMIN = "<?php if (!if_admin) {echo 'true';} else echo 'false';?>",
    CURRENCY = "<?php echo currency ?>",
    LOCATE_SELECTED = "<?php echo lang('lang_code');?>",
    UPIMGURL = "<?php echo base_url('uploads/images/'); ?>",
    NTFTITLE = "<?php echo lang('notification')?>",
    TODAYDATE = "<?php echo date('Y.m.d ')?>",
    LOGGEDINSTAFFID = "<?php echo $this->session->userdata('usr_id'); ?>",
    LOGGEDINSTAFFNAME = "<?php echo $this->session->userdata('staffname'); ?>",
    LOGGEDINSTAFFAVATAR = "<?php echo $this->session->userdata('staffavatar'); ?>",
    VOICENOTIFICATIONLANG = "<?php echo lang('lang_code_dash');?>",
    initialLocaleCode = "<?php echo lang('initial_locale_code');?>";
  var new_item = "<?php echo lang('new'); ?>";
  var item_unit = "<?php echo lang('unit'); ?>";
  </script>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis();
?>

<body ng-controller="Hrm_Controller">
  <?php if ($rebrand['disable_preloader'] == '0') { 
        $preloader =  base_url('assets/img/'.$rebrand['preloader']); ?>
  <div id="ciuisloader" style="background-image: url(<?php echo $preloader ?>);"></div>
  <?php } ?>
  <md-toolbar class="toolbar-ciuis-top">
    <div class="md-toolbar-tools">
      <!-- CRM NAME -->
      <div md-truncate class="crm-name crm-nm"><span><?php echo $user_data['settings']['crm_name'] ?></span></div>
      <md-button ng-click="OpenMenu()" class="md-icon-button hidden-lg hidden-md" aria-label="Menu">
        <md-icon><i class="ion-navicon-round text-muted"></i></md-icon>
      </md-button>
      <!-- CRM NAME -->
      <!-- NAVBAR MENU -->
      <ul flex class="ciuis-v3-menu hidden-xs">
        <?php foreach ($menus as $menu) { ?>
        <?php if ($menu['url'] != '#') { ?>
        <li><a href="<?php echo $menu['url'] ?>"><?= $menu['title'];?></a>

        </li>
        <?php } ?>
        <?php } ?>
      </ul>
      <!-- NAVBAR MENU -->
      <md-button ng-click="Profile();" class="md-icon-button avatar-button-ciuis"
        aria-label="User Profile" ng-cloak>
        <img height="100%" src="<?php echo $user_image ?>" class="md-avatar"
          style="max-height: 36px;height: 100%;max-width: 40px;"
          onerror="this.onerror=null; this.src='<?php echo $user_image_alternate ?>'">
      </md-button>
      <div ng-click="Profile();" md-truncate class="user-informations hidden-xs"
        ng-cloak> <span class="user-name-in"><?php echo $user_data['name'] ?></span><br>
        <span class="user-email-in"><?php echo $user_data['email'] ?></span>
      </div>
    </div>
  </md-toolbar>
  <md-content id="mobile-menu" class="" style="left: 0px; opacity: 1; display: none">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <div flex md-truncate class="crm-name"><span ng-bind="settings.crm_name"></span></div>
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close">
          <md-icon><i class="ion-close-circled text-muted"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-content class="mobile-menu-box bg-white">
      <div class="mobile-menu-wrapper-inner">
        <div class="mobile-menu-wrapper">
          <div class="mobile-menu-slider" style="left: 0px;">
            <div class="mobile-menu">
              <?php foreach ($menus as $menu) { ?>
              <span>
                <?php if($menu['url'] != '#') {?>
                <ul>
                  <li class="nav-item">
                    <div class="mobile-menu-item"><a href="<?php $menu['url'] ?>"><?php echo $menu['title'] ?></a>
                    </div>
                  </li>
                </ul>
                <?php }?>

              </span>
              <?php } ?>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </md-content>
  </md-content>
  <header id="mainHeader" role="banner" class="hidden-xs">
    <nav role="navigation">
      <div class="top-header">
        <div class="navBurger"><a href="{{appurl + 'panel'}}">
            <img class="transform_logo" width="34px" src="<?php echo $app_logo ?>" height="34px"
              onerror="this.onerror=null; this.src='<?php echo $app_logo_alternate ?>'">
          </a>
        </div>
      </div>
      <ul id="menu-vertical-menu icon" class="nav">
        <?php foreach ($leftmenus as $leftmenu) { ?>
        <?php if ($leftmenu['show_staff'] == '0') { ?>
        <li class="material-icons <?php echo $leftmenu['icon'] ?>"><a
            href="<?php echo $leftmenu['url'] ?>"><?php echo $leftmenu['title'] ?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>
    </nav>
  </header>


  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Profile" ng-cloak style="width: 450px;">
    <md-content>
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="Profile">
          <md-content layout-padding class="md-mt-10 text-center" style="line-height: 0px;height:200px"> <img
              style="border-radius: 50%; box-shadow: 0 0 20px 0px #00000014;" height="100px" width="auto"
              ng-src="{{appurl + 'uploads/images/' + user.avatar}}" class="md-avatar" alt="{{user.name}}" />
            <h3><strong ng-bind="user.name"></strong></h3>
            <br>
            <span ng-bind="user.email"></span>
          </md-content>
          <md-content class="md-mt-30 text-center">
            <md-button ng-href="{{appurl + 'login/logout'}}" class="md-raised" ng-bind='lang.logout'
              aria-label='LogOut'></md-button>
          </md-content>

        </md-tab>
        <md-tabs>
    </md-content>
  </md-sidenav>
  <md-content class="ciuis-body-wrapper ciuis-body-fixed-sidebar" ciuis-ready>