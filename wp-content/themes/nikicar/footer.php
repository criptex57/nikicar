<footer>
  <div class="footer-logo" onclick="location.href='<?=get_home_url()?>';"></div>
  <?php wp_nav_menu( ['menu' => 'Головне меню', 'container' => 'nav', 'container_class' => 'footer-nav', 'menu_class' => 'footer-nav-top'] );?>
  <div class="to-header" onclick="up()"></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>