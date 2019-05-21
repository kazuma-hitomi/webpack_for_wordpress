<?php

/**
 * Class Global_var
 */
class Global_var {
  
  /**
   * ルートパス
   */
  public function root_path() {
    echo esc_url(home_url('/'));
  }
  
  /**
   * ファイルパス
   * @param $file_name
   */
  public function assets_path($file_name) {
    echo get_template_directory_uri() . '/assets/' . $file_name;
  }
  
  /**
   * ユーザーエージェントで切り替える
   * @return string
   */
  public function ua() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) || (strpos($ua, 'iPhone') !== false) || (strpos($ua, 'Windows Phone') !== false)) {
      return 'sp';
    } elseif((strpos($ua, 'Android') !== false) || (strpos($ua, 'iPad') !== false)) {
      return 'tab';
    } else {
      return 'pc';
    }
  }
}
$global_var = new Global_var();

// 管理バーの非表示
add_filter('show_admin_bar', '__return_false');

// WPバージョンの非表示
remove_action('wp_head', 'wp_generator');

// アイキャッチ画像の有効化
add_theme_support('post-thumbnails');

/**
 * キャッシュ対策
 * ファイルのバージョン更新
 * @param $file
 * @return string
 */
function latest_version($file) {
  return date_i18n('YmdHi', filemtime(get_template_directory_uri() . $file));
}

function loading_scripts() {
  if(!is_admin()) {
    // 管理画面以外で読み込み
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), false, true);
    wp_enqueue_script('main', get_template_directory_uri() . '/main.js', array(), latest_version('main.js'), true);
    wp_enqueue_style('style', get_stylesheet_uri(), array(), latest_version('style.css'), 'all');
  }
}
add_action('wp_enqueue_scripts', 'loading_scripts');
