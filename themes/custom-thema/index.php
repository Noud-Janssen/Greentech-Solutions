<?php
/**
 * The main template file
 *
 * @package YourCustomTheme
 */

get_header(); // Include the header template part.
?>

<main id="main-content" role="main">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h1>
                </header>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="entry-footer">
                    <span class="entry-meta">
                        Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?>
                    </span>
                </footer>
            </article>
        <?php endwhile; ?>
        
        <div class="pagination">
            <?php
            // Add navigation for older/newer posts.
            the_posts_navigation( array(
                'prev_text' => __( 'Older Posts', 'yourcustomtheme' ),
                'next_text' => __( 'Newer Posts', 'yourcustomtheme' ),
            ) );
            ?>
        </div>
    <?php else : ?>
        <article class="no-posts">
            <h2><?php _e( 'No posts found.', 'yourcustomtheme' ); ?></h2>
        </article>
    <?php endif; ?>
</main>

<?php
//get_sidebar(); // Include the sidebar template part if you have one.
get_footer(); // Include the footer template part.
