<?php
/*
Plugin Name: Easy Post Creator
Description: Adds a simple interface to create posts with an image at the top and an excerpt directly from the admin dashboard.
Version: 1.3
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add a menu item in the admin dashboard
function epc_add_admin_menu() {
    add_menu_page(
        'Easy Post Creator', // Page title
        'Post Creator',      // Menu title
        'manage_options',    // Capability
        'easy-post-creator', // Menu slug
        'epc_render_admin_page', // Callback function
        'dashicons-admin-post',  // Icon
        20                     // Position
    );
}
add_action('admin_menu', 'epc_add_admin_menu');

// Render the admin page
function epc_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>Create a New Post</h1>
        <form method="post" enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="epc_title">Title</label></th>
                    <td><input type="text" name="epc_title" id="epc_title" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="epc_image">Image</label></th>
                    <td><input type="file" name="epc_image" id="epc_image" accept="image/*"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="epc_excerpt">Excerpt</label></th>
                    <td><textarea name="epc_excerpt" id="epc_excerpt" class="large-text" rows="3"></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="epc_content">Content</label></th>
                    <td><textarea name="epc_content" id="epc_content" class="large-text" rows="10"></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="epc_joke">Use Joke</label></th>
                    <td><input name="epc_joke" id="epc_joke" type="checkbox"/></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="epc_submit" id="epc_submit" class="button button-primary" value="Create Post">
            </p>
        </form>
    </div>
    <?php

    // Handle form submission
    if (isset($_POST['epc_submit'])) {
        $title = sanitize_text_field($_POST['epc_title']);
        $content = sanitize_textarea_field($_POST['epc_content']);
        $excerpt = sanitize_textarea_field($_POST['epc_excerpt']);
        $use_joke = $_POST['epc_joke'];;
        $image_html = '';

        echo '<div class="notice notice-error"><p>Joke: ' . $use_joke . esc_html($upload['error']) . '</p></div>';

        if (!empty($_FILES['epc_image']['name'])) {
            // Handle image upload
            $file = $_FILES['epc_image'];
            $upload = wp_handle_upload($file, ['test_form' => false]);

            if ($upload && !isset($upload['error'])) {
                $image_url = $upload['url'];
                $image_html = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($file['name']) . '" style="max-width:100%;height:auto;">';
            } else {
                echo '<div class="notice notice-error"><p>Failed to upload image: ' . esc_html($upload['error']) . '</p></div>';
            }
        }

        if (!empty($title)) {
            if ($use_joke == "on") {
                $joke_content = file_get_contents("https://v2.jokeapi.dev/joke/Any?format=txt");
            }


            // Combine the image HTML and post content
            $final_content = $image_html . "\n" . $content . "\n" . $joke_content;

            $post_id = wp_insert_post([
                'post_title'   => $title,
                'post_content' => $final_content,
                'post_excerpt' => $excerpt,
                'post_status'  => 'publish',
                'post_author'  => get_current_user_id(),
                'post_type'    => 'post',
            ]);

            if ($post_id) {
                echo '<div class="notice notice-success"><p>Post created successfully! <a href="' . get_edit_post_link($post_id) . '">Edit Post</a></p></div>';
            } else {
                echo '<div class="notice notice-error"><p>Failed to create the post.</p></div>';
            }
        } else {
            echo '<div class="notice notice-warning"><p>Title is required to create a post.</p></div>';
        }
    }
}
