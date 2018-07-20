<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($this->session->userdata['logged_in'])) {
  redirect(base_url());
}
?><!DOCTYPE html>
<html class='no-js' lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>Asuna</title>
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link href="<?php echo base_url(); ?>public/assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/assets/images/favicon.ico" rel="icon" type="image/ico" />
    
  </head>
  <body class='main page'>
    <!-- Navbar -->
    <?php
      include("includes/header.php");
    ?>
    <div id='wrapper'>
      <!-- Sidebar -->
      <?php
      include("includes/menu.php");
      ?>
      <!-- Tools -->
      <section id='tools'>
        <ul class='breadcrumb' id='breadcrumb'>
          <li class='title'>Dashboard</li>
        </ul>
      </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='icon-beer icon-large'></i>
            Hierapolis Rocks!
            <div class='panel-tools'>
              <div class='btn-group'>
                <a class='btn' href='#'>
                  <i class='icon-refresh'></i>
                  Refresh statics
                </a>
                <a class='btn' data-toggle='toolbar-tooltip' href='#' title='Toggle'>
                  <i class='icon-chevron-down'></i>
                </a>
              </div>
            </div>
          </div>
          <div class='panel-body'>
            <div class='page-header'>
              <h4>System usage</h4>
            </div>
            <div class='progress'>
              <div class='progress-bar progress-bar-success' style='width: 35%'></div>
              <div class='progress-bar progress-bar-warning' style='width: 20%'></div>
              <div class='progress-bar progress-bar-danger' style='width: 10%'></div>
            </div>
            <div class='page-header'>
              <h4>User statics</h4>
            </div>
            <div class='row text-center'>
              <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#d4ecfd' data-fgcolor='#30a1ec' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='50'>
              </div>
              <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#c4e9aa' data-fgcolor='#8ac368' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='75'>
              </div>
              <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#cef3f5' data-fgcolor='#5ba0a3' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='35'>
              </div>
              <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#f8d2e0' data-fgcolor='#b85e80' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='85'>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
  </body>
</html>
