<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Мурахи півдня</title>
  <?php wp_head(); ?>
</head>
<body>
<header>
  <div class="logo" onclick="location.href='<?=get_home_url()?>';">
    <div></div>
  </div>
  <?php wp_nav_menu( ['menu' => 'Головне меню', 'container' => 'nav', 'container_id' => 'header-nav', 'menu_class' => 'header-menu'] );?>
  <div class="close-burger close" id="burger"></div>
</header>