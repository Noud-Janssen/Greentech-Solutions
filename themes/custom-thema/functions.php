<?php
/**
 * Register custom sidebar
 */
function custom_theme_sidebar_init() {
    register_sidebar(array(
        'name'          => __('Custom Sidebar', 'custom-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'custom-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'custom_theme_sidebar_init');

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
