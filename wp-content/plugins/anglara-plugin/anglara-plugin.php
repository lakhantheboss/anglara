<?php
/*
Plugin Name: Custom Anglara Post Type Plugin
Description: Creates a custom post type 'news' with custom fields stored in a custom table.
Version: 1.0
*/

require_once plugin_dir_path(__FILE__) . 'class-custom-news.php';

$custom_news_plugin = new Custom_News_Plugin();


// register_activation_hook(__FILE__, array($this, 'activate'));

register_activation_hook(__FILE__, array($custom_news_plugin, 'activate'));

// register_uninstall_hook(__FILE__, array($custom_news_plugin, 'uninstall'));