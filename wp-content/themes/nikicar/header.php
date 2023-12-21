<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=CFS()->get('meta-description')?CFS()->get('meta-description'):('Мурахи півдня - '.get_the_title())?>"/>
    <meta name="keywords" content="мурахи півдня, niki car, nikicar, волонтерська організація, сувеніри, підтримка ЗСУ, благодійність, воєнні фонди, патріотичні товари, армійські сувеніри, благодійна діяльність, підтримка військових, національна безпека, товари для ЗСУ, військова тематика, українська армія, патріотизм, армійські товари, воєнна підтримка, воєнний фонд, армійська символіка, солідарність, сувеніри від волонтерів">
    <title><?=get_the_title()?get_the_title().' - ':''?>Мурахи півдня</title>
    <?php wp_head(); ?>
</head>
<body>
<div id="lightbox">
    <div id="lightbox-close"></div>
    <div class="lightbox-image-container">
        <img id="lightbox-image" src="" alt="">
    </div>
</div>
<div id="modal">
    <div id="modal-close"></div>
    <div id="modal-header"></div>
    <div id="modal-body"></div>
</div>
<div class="main-container">
<header id="header">
  <div class="logo" onclick="location.href='<?=get_home_url()?>';">
    <div></div>
  </div>
  <?php wp_nav_menu( ['menu' => 'Головне меню', 'container' => 'nav', 'container_id' => 'header-nav', 'menu_class' => 'header-menu'] );?>
    <div id="cart" data-content="0">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0,0,256,256"><g fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(8.53333,8.53333)"><path d="M2,2c-0.36064,-0.0051 -0.69608,0.18438 -0.87789,0.49587c-0.18181,0.3115 -0.18181,0.69676 0,1.00825c0.18181,0.3115 0.51725,0.50097 0.87789,0.49587h1.87891c0.2259,0 0.4144,0.14146 0.47852,0.35938l4.26172,14.48828c0.37403,1.27171 1.55027,2.15234 2.87695,2.15234h10.97656c1.34842,0 2.539,-0.91131 2.89453,-2.21094l2.59766,-9.52539c0.08217,-0.30078 0.01936,-0.62267 -0.16985,-0.87049c-0.18922,-0.24782 -0.48319,-0.39321 -0.79499,-0.39318h-19.48633l-1.23633,-4.20508c-0.00065,0 -0.0013,0 -0.00195,0c-0.31189,-1.06009 -1.29239,-1.79492 -2.39648,-1.79492zM12,23c-1.10457,0 -2,0.89543 -2,2c0,1.10457 0.89543,2 2,2c1.10457,0 2,-0.89543 2,-2c0,-1.10457 -0.89543,-2 -2,-2zM22,23c-1.10457,0 -2,0.89543 -2,2c0,1.10457 0.89543,2 2,2c1.10457,0 2,-0.89543 2,-2c0,-1.10457 -0.89543,-2 -2,-2z"></path></g></g></svg>
    </div>
    <div class="close-burger close" id="burger"></div>
</header>
<main>