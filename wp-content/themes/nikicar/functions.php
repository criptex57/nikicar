<?php
add_action('wp_enqueue_scripts', 'add_script_and_style');

function add_script_and_style(){
  wp_register_script('js', get_template_directory_uri().'/assets/js/script.js', false, null, true);
  wp_enqueue_script('js');
  wp_enqueue_style('style', get_template_directory_uri().'/assets/css/style.css');
}