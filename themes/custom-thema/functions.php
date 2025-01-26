<?php
/**
 * Register custom sidebar
 */
function custom_sidebar() {
    register_sidebar(
        array(
            'name'          => 'Primary Sidebar',
            'id'            => 'primary-sidebar',
            'before_widget' => '<div class="widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'custom_sidebar');

/**
 * Unregister default WordPress widgets
 */
function remove_default_widgets() {
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search'); // Optional: Remove default search widget
    unregister_widget('WP_Widget_Recent_Posts'); // Optional: Remove recent posts widget
    unregister_widget('WP_Widget_Recent_Comments'); // Optional: Remove recent comments widget
}
add_action('widgets_init', 'remove_default_widgets', 11);

/**
 * Load custom 404 error page
 */
function custom_404_template($template) {
    if (is_404()) {
        $custom_template = locate_template('404.php');
        if ($custom_template) {
            return $custom_template;
        }
    }
    return $template;
}
add_filter('template_include', 'custom_404_template');

function getTheFirstImage() {
    $post_content = get_the_content();
    $pattern = '/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i';
    if (preg_match($pattern, $post_content, $matches)) {
        // Inline image found
        $image_src = $matches[1];
        echo "<img src='$image_src' class='thumbnail' />";
        return;
    }

    // Fallback: check for attached images
    $files = get_children([
        'post_parent'    => get_the_ID(),
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
    ]);
    if ($files) {
        $keys = array_reverse(array_keys($files));
        $num = $keys[0];
        $thumb = wp_get_attachment_thumb_url($num);
        echo "<img src='$thumb' class='thumbnail' />";
    }
}

/**
 * Custom content length
 */
function custom_content_length($content, $limit = 200) {
    // Match the first image tag if it exists
    preg_match('/<img[^>]*>/i', $content, $image_match);

    // Extract the image HTML or set it to empty
    $image_html = $image_match[0] ?? '';

    // Remove the image tag from the content
    $content_without_image = preg_replace('/<img[^>]*>/i', '', $content);

    // Strip remaining HTML tags from the text content
    $clean_text = wp_strip_all_tags($content_without_image);

    // Truncate the text content to the specified limit
    if (strlen($clean_text) > $limit) {
        $clean_text = substr($clean_text, 0, $limit) . '...';
    }

    // Combine the image and truncated text
    return $image_html . '<p>' . $clean_text . '</p>';
}



/**
 * Modify the search query to include post title, content, and excerpt(only the main Post-list)
 */
function custom_theme_modify_search_query( $query ) {
    // Check if we are on a search page, not in the admin area, and it is the main query
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
        // Exclude search results from affecting the side-posts section
        // Make sure to exclude side posts by checking the specific part of the page
        if ( ! is_home() && ! is_front_page() ) {
            return; // Skip the modification on side posts
        }

        $search_term = get_query_var('s');

        // Modify query to search in post_title, post_content, and post_excerpt
        $query->set( 's', $search_term );
        $query->set( 'posts_per_page', 10 ); // Adjust posts per page if needed

        // Filter by custom logic using a direct SQL WHERE clause
        add_filter( 'posts_search', function( $search, $wp_query ) use ( $search_term ) {
            global $wpdb;

            if ( empty( $search_term ) ) {
                return $search;
            }

            // Custom SQL search logic
            $search = $wpdb->prepare(
                " AND (
                    {$wpdb->posts}.post_title LIKE %s
                    OR {$wpdb->posts}.post_content LIKE %s
                    OR {$wpdb->posts}.post_excerpt LIKE %s
                )",
                '%' . $wpdb->esc_like( $search_term ) . '%',
                '%' . $wpdb->esc_like( $search_term ) . '%',
                '%' . $wpdb->esc_like( $search_term ) . '%'
            );

            return $search;
        }, 10, 2 );
    }
}
add_action( 'pre_get_posts', 'custom_theme_modify_search_query' );


?>
