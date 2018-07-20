<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html class='no-js' lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>Asuna Login</title>
    <link href="<?php echo base_url(); ?>public/assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/assets/images/favicon.ico" rel="icon" type="image/ico" />
    
  </head>
  <body class='login'>
    <div class='wrapper'>
      <div class='row'>
        <div class='col-lg-12'>
          <div class='brand text-center'>
            <h1>
              <div class='logo-icon'>
              </div>
              Asuna
            </h1>
          </div>
        </div>
      </div>
      <div class='row'>
        <?php
          echo "<div class='error_msg'>";
          if (isset($error_message)) {
            echo $error_message;
          }
          echo "</div>";
          ?>
        <div class='col-lg-12'>
          <?php echo form_open('prode/process'); ?>
            <fieldset class='text-center'>
              <div class='form-group'>
                <input class='form-control' placeholder='Nombre de usuario' type='text' name="user">
              </div>
              <div class='form-group'>
                <input class='form-control' placeholder='Password' type='password' name="password">
              </div>
              <div class='text-center'>
                <input class="btn btn-default" type="submit" value="Entrar" name="submit"/>
                <br>
              </div>
            </fieldset>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </body>
</html>
