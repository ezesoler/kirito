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
          <li class='title'>Usuarios</li>
        </ul>
      </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='icon-edit icon-large'></i>
            Nuevo Usuario
          </div>
          <div class='panel-body'>
            <form class='form-horizontal' action="<?=base_url("prode/addUser");?>" method="post">
              <fieldset>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Email</label>
                  <div class='col-lg-10'>
                    <input class='form-control' placeholder='Ingrese el email' type='email' name="email" id="email">
                  </div>
                </div>
              </fieldset>
              <div class='form-actions'>
                <button class='btn btn-default' type='submit' name="submit" id="submit">Guardar</button>
                <a class='btn' href='#'>Cancelar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
  </body>
</html>
