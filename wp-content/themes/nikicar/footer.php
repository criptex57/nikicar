</main>
<footer>
  <div class="footer-logo" onclick="location.href='<?=get_home_url()?>';"></div>
  <?php wp_nav_menu( ['menu' => 'Головне меню', 'container' => 'nav', 'container_class' => 'footer-nav', 'menu_class' => 'footer-nav-top'] );?>
  <a class="to-header" href="#header"></a>
</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>