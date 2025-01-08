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

/**
 * Modify the search query to include post title, content, and excerpt
 */
function custom_theme_modify_search_query( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
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
