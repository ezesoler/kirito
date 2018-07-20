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
          <li class='title'>Novedades</li>
        </ul>
      </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default grid'>
          <div class='panel-heading'>
            <i class='icon-table icon-large'></i>
            Novedades
            <div class='panel-tools'>
              <div class='badge'><?php echo count($ver) ?> registros</div>
            </div>
          </div>
          <div class='panel-body filters'>
            <div class='row'>
              <div class='col-md-9'>
                <a class='btn' href='<?php echo base_url('prode/novedad_add') ?>'>Agregar</a>
              </div>
              <div class='col-md-3'>
              </div>
            </div>
          </div>
          <table class='table'>
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Foto</th>
                <th>Titulo</th>
                <th>Texto</th>
                <th class='actions'>
                  Acciones
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($ver as $fila){
              ?>
              <tr class='active'>
                <td><?=$fila->id;?></td>
                <td><?=$fila->fecha;?></td>
                <td><img src="http://ezesoler.com/kirito/imgs/<?=$fila->foto;?>" width="50" /></td>
                <td><?=$fila->titulo;?></td>
                <td><?=$fila->texto;?></td>
                <td class='action'>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <?php  
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Footer -->
  </body>
</html>
