<?php
/**
 * The main template file
 *
 * @package YourCustomTheme
 */

get_header(); // Include the header template part.
?>

<main id="main-content" role="main">
    <div class="posts-list">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="post-header">
                        <div class="title">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php the_excerpt()?></p>
                        </div>
                        <div class="meta">
                            <time class="published" datetime="<?php get_the_date() ?>"><?php echo get_the_date() ?></time>
                            <a href="#" class="author"><span class="name"><?php the_author() ?></span><img src="images/avatar.jpg" alt="" /></a>
                        </div>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                    
                    <footer class="entry-footer">
                        <button>Continue reading</button>
                        <span class="entry-meta">
                            <ul class="stats">
								<li><a href="#">General</a></li>
								<li><a href="#" class="icon solid fa-heart">28</a></li>
								<li><a href="#" class="icon solid fa-comment">128</a></li>
							</ul>
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
    </div>
</main>

<?php
//get_sidebar(); // Include the sidebar template part if you have one.
get_footer(); // Include the footer template part.
