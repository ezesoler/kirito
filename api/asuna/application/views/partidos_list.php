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
          <li class='title'>Partidos</li>
        </ul>
      </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default grid'>
          <div class='panel-heading'>
            <i class='icon-table icon-large'></i>
            Partidos
            <div class='panel-tools'>
              <div class='badge'><?php echo count($ver) ?> registros</div>
            </div>
          </div>
          <table class='table'>
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Local</th>
                <th>Visitante</th>
                <th>Resultado</th>
                <th class='actions'>
                  Acciones
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($ver as $fila){
              ?>
              <tr class='<?php if(intval($fila->jugado)==1){echo 'success';}else if($fila->fecha == date('d M')){echo 'danger';}else{echo 'active';}; ?>'>
                <td><?=$fila->id;?></td>
                <td><?=$fila->fecha;?></td>
                <td><?=$fila->nombreLocal;?></td>
                <td><?=$fila->nombreVisitante;?></td>
                <td><?=$fila->marcadorLocal;?> - <?=$fila->marcadorVisitante;?></td>
                <td class='action'>
                  <a class='btn btn-info' href='<?=base_url("/prode/mod_partido/$fila->id")?>'>
                    <i class='icon-edit'></i>
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
