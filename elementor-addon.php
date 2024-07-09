<?php
/*
* Plugin Name: Elementor-Addson-ContactForm
* Description: It is plugin 
* Version: 1.0
* Author: CPM
* License: GPL2
* Text Domain: elementor-addon
*
*
* Requires Plugins: elementor
* Elementor tested up to: 1.0
* Elementor Pro tested up to: 

*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function register_contact_form_widget($widgets_form)
{
    //for contact form
    require_once(__DIR__ . '/widgets/form-addon.php');
    $widgets_form->register(new \form_addon());

    //for widgets in elementor
    require_once(__DIR__ . '/widgets/dropdown-widgets.php');
    $widgets_form->register(new \drop_down());
}
add_action('elementor/widgets/register', 'register_contact_form_widget');


//function to enqueue the style for form
function contact_form_scripts()
{
    wp_enqueue_style('contact-form-style', plugin_dir_url(__FILE__) . 'assets/css/contact-form.css', array(), '1.0.0', 'all');
    wp_enqueue_style('category-dropdown-style', plugin_dir_url(__FILE__) . 'assets/css/category-dropdown.css', array(), '1.0.0', 'all');
} 
add_action('wp_enqueue_scripts', 'contact_form_scripts');

//function to handle the form
function handle_form_submission() {
    if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) && isset( $_POST['message'] ) ) {
        $name = sanitize_text_field( $_POST['name'] );
        $email = sanitize_email( $_POST['email'] );
        $message = sanitize_textarea_field( $_POST['message'] );

        $post_id = wp_insert_post([
            'post_title'   => $name ,
            'post_content' => $message,
            'post_status'  => 'publish',
        ]);

        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta($post_id, 'username', $name);
            update_post_meta($post_id, 'email', $email);
            update_post_meta($post_id, 'content', $message);
            
            //success message
            echo 'Message delivery successfully';
            exit;
        }
    }
}
add_action( 'init', 'handle_form_submission' );


//to add post_id column in post page for admin
// Add a new column for post ID

function add_post_id_column($columns) {
    $columns['post_id'] = __('Post ID'); // Unique identifier for the column
    return $columns;
}
add_filter('manage_posts_columns', 'add_post_id_column', 15); // manage_posts_columns is a hook name to which we are adding our filter. It is used to modify the list of columns displayed in the posts list table.


// Display the post ID in the new column
function display_post_id_column($column, $post_id) {
    if ($column == 'post_id') { // Check if the current column is the one we added
        echo esc_html($post_id); // Display the post ID
    }
}
add_action('manage_posts_custom_column', 'display_post_id_column', 15, 2);
