<section id='sidebar'>
  <i class='icon-align-justify icon-large' id='toggle'></i>
  <ul id='dock'>
    <li class="<?php if($controller_name == 'dashboard') echo 'active ';?>launcher">
      <i class='icon-dashboard'></i>
      <a href="<?php echo base_url(); ?>">Dashboard</a>
    </li>
    <li class='<?php if($controller_name == 'usuarios') echo 'active ';?>launcher'>
      <i class='icon-user'></i>
      <a href="<?php echo base_url('prode/usuarios_list') ?>">Usuarios</a>
    </li>
    <li class='<?php if($controller_name == 'partidos') echo 'active ';?>launcher'>
      <i class='icon-calendar'></i>
      <a href="<?php echo base_url('prode/partidos_list') ?>">Partidos</a>
    </li>
     <li class='<?php if($controller_name == 'novedades') echo 'active ';?>launcher'>
      <i class='icon-bullhorn'></i>
      <a href='<?php echo base_url('prode/novedades_list') ?>'>Novedades</a>
    </li>
    <li class='<?php if($controller_name == 'notificaciones') echo 'active ';?>launcher'>
      <i class='icon-bell'></i>
      <a href='<?php echo base_url('prode/notificaciones_send') ?>'>Notificaciones</a>
    </li>
  </ul>
  <div data-toggle='tooltip' id='beaker' title='Made by lab2023'></div>
</section>