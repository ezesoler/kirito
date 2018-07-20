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
          <li class='title'>Notificaciones</li>
        </ul>
      </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='icon-edit icon-large'></i>
            Enviar Notificacion
          </div>
          <div class='panel-body'>
            <form class='form-horizontal' action="<?=base_url("prode/sendNotificacion");?>" method="post">
              <fieldset>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Destino</label>
                  <div class='col-lg-10'>
                    <select class='form-control' id="destino" name="destino">
                      <option value="/topics/kirito">Todos</option>
                      <?php
                      foreach($usuarios as $fila){
                      ?>
                        <option value="<?=$fila->tfcm;?>"><?=$fila->nombre;?></option>
                      <?php  
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Tipo</label>
                  <div class='col-lg-10'>
                    <select class='form-control' id="tipo" name="tipo">
                      <option value="generic">General</option>
                      <option value="results">Resultados</option>
                      <option value="news">Novedad</option>
                    </select>
                  </div>
                </div>
                 <div class='form-group'>
                  <label class='col-lg-2 control-label'>Icono</label>
                  <div class='col-lg-10'>
                    <input class='form-control' placeholder='Ingrese el título' type='text' name="icono" id="icono" value="icon.png">
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Texto</label>
                  <div class='col-lg-10'>
                    <textarea class='form-control' rows='4' name="texto" id="texto"></textarea>
                  </div>
                </div>
              </fieldset>
              <div class='form-actions'>
                <button class='btn btn-default' type='submit' name="submit" id="submit">Enviar</button>
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
