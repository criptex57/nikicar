<?php
add_action('wp_enqueue_scripts', 'add_script_and_style');

function add_script_and_style(){ //Подключение скриптов и стилей
  wp_register_script('js', get_template_directory_uri().'/assets/js/script.js', false, null, true);
  wp_enqueue_script('js');

  if(is_front_page()){
    wp_register_script('main-page', get_template_directory_uri().'/assets/js/main-page.js', false, null, true);
    wp_enqueue_script('main-page');
  }

  if(is_front_page() || get_post_type() == 'help'){
    wp_register_script('slider', get_template_directory_uri().'/assets/js/slider.js', false, null, true);
    wp_enqueue_script('slider');
  }

  wp_enqueue_style('style', get_template_directory_uri().'/assets/css/style.css');
}

//Добавить возможность загружать превью
if ( function_exists( 'add_theme_support' ) ){
  add_theme_support( 'post-thumbnails' );
}

//Создание типа help
add_action( 'init', 'register_post_help' );
function register_post_help(){
  register_post_type( 'help', [
    'label'  => null,
    'labels' => [
      'name'               => 'Допомога', // основное название для типа записи
      'singular_name'      => 'Додати тип допомоги', // название для одной записи этого типа
      'add_new'            => 'Додати тип допомоги', // для добавления новой записи
      'add_new_item'       => 'Додати тип допомоги', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Редагувати тип допомоги', // для редактирования типа записи
      'new_item'           => 'Новий тип домопоги', // текст новой записи
      'view_item'          => 'Дивитись', // для просмотра записи этого типа.
      'search_items'       => 'Шукати тип допомоги', // для поиска по этим типам записи
      'not_found'          => 'Не знайдено', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Не знайдено у кошику', // если не было найдено в корзине
      'parent_item_colon'  => '', // для родителей (у древовидных типов)
      'menu_name'          => 'Допомога', // название меню
    ],
    'description'            => '',
    'public'                 => true,
    // 'publicly_queryable'  => null, // зависит от public
    // 'exclude_from_search' => null, // зависит от public
    // 'show_ui'             => null, // зависит от public
    // 'show_in_nav_menus'   => null, // зависит от public
    'show_in_menu'           => true, // показывать ли в меню админки
    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
    'show_in_rest'        => null, // добавить в REST API. C WP 4.7
    'rest_base'           => null, // $post_type. C WP 4.7
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-sos',
    //'capability_type'   => 'post',
    //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
    //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
    'hierarchical'        => false,
    'supports'            => [ 'title', 'editor', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
    'taxonomies'          => [],
    'has_archive'         => false,
    'rewrite'             => true,
    'query_var'           => true,
  ] );
}

//Создание типа report
add_action( 'init', 'register_post_report' );
function register_post_report(){
  register_post_type( 'report', [
    'label'  => null,
    'labels' => [
      'name'               => 'Звітність',
      'singular_name'      => 'Додати звіт',
      'add_new'            => 'Додати звіт',
      'add_new_item'       => 'Додати звіт',
      'edit_item'          => 'Редагувати звіт',
      'new_item'           => 'Новий звіт',
      'view_item'          => 'Дивитись',
      'search_items'       => 'Шукати звіт',
      'not_found'          => 'Не знайдено',
      'not_found_in_trash' => 'Не знайдено у кошику',
      'parent_item_colon'  => '',
      'menu_name'          => 'Звіти',
    ],
    'description'            => '',
    'public'                 => true,
    'show_in_menu'           => true,
    'show_in_rest'        => null,
    'rest_base'           => null,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-admin-customizer',
    'hierarchical'        => false,
    'supports'            => [ 'title', 'editor', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
    'taxonomies'          => [],
    'has_archive'         => false,
    'rewrite'             => true,
    'query_var'           => true,
  ] );
}

//Создание типа report
add_action( 'init', 'register_post_souvenir' );
function register_post_souvenir(){
	register_post_type( 'souvenir', [
		'label'  => null,
		'labels' => [
			'name'               => 'Сувеніри',
			'singular_name'      => 'Додати сувенір',
			'add_new'            => 'Додати сувенір',
			'add_new_item'       => 'Додати сувенір',
			'edit_item'          => 'Редагувати сувенір',
			'new_item'           => 'Новий сувенір',
			'view_item'          => 'Дивитись',
			'search_items'       => 'Шукати сувенір',
			'not_found'          => 'Не знайдено',
			'not_found_in_trash' => 'Не знайдено у кошику',
			'parent_item_colon'  => '',
			'menu_name'          => 'Сувеніри',
		],
		'description'            => '',
		'public'                 => true,
		'show_in_menu'           => true,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => 5,
		'publicly_queryable' => true,
		'menu_icon' => 'dashicons-awards',
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );
}

//flush_rewrite_rules(); //@todo Обновляет правила перезаписи ЧПУ. Запускать при добавлении новых типов записи

function wordSafeBreak($str) {
  for($middle = floor(strlen($str)/2); $middle >= 0 && $str[$middle] !== ' '; $middle--){
    if ($middle < 0) {
      return [$str];
    }
  }

  return [substr($str, 0, $middle), substr($str, $middle+1)];
}

