<?php
/**
 * The main template file
 *
 * @package YourCustomTheme
 */

get_header(); // Include the header template part.
?>
<div id="main" role="main">
<div class="side-posts">
    <!-- Intro -->
    <div class="intro">
        <header>
            <h2 class="intro-header" >GreenTech Solutions</h2>
            <p>Lorem ipsum</p>
        </header>
    </div>

    <!-- Mini Posts -->
        <div class="mini-posts">
            <?php
            // Custom WP_Query for mini-posts that is not affected by search
            $mini_posts_query = new WP_Query( array(
                'post_type' => 'post',  // Specify post type (or your custom post type)
                'posts_per_page' => 5,  // Set number of posts you want to display
                's' => '',  // Ensure no search term is passed to this query
            ) );

            // Loop through the mini posts
            if ( $mini_posts_query->have_posts() ) :
                while ( $mini_posts_query->have_posts() ) : $mini_posts_query->the_post();
            ?>
            <!-- Individual posts -->
                <article class="mini-post">
                    <header>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <time class="published" datetime="<?php get_the_date() ?>"><?php echo get_the_date() ?></time>
                    </header>
                    <a href="<?php the_permalink(); ?>" class="image"><?php getTheFirstImage(); ?></a>
                </article>
            <?php endwhile; endif; wp_reset_postdata(); ?>
        </div>

    <!-- About -->
        <div class="blurb">
            <h2>About</h2>
            <p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod amet placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at phasellus sed ultricies.</p>
            <ul class="actions">
                <li><a href="#" class="button">Learn More</a></li>
            </ul>
        </div>

        <!-- Footer -->
        <div id="footer">
            <ul class="icons">
                <!-- Example links -->
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon solid fa-rss"><span class="label">RSS</span></a></li>
                <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <p class="copyright">&copy; Untitled.</p>
        </div>
    </div>
    <!-- All posts (Effected by search query) -->
    <div class="posts-list">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <!-- Individual post -->
                <article class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="post-header">
                        <div class="title">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php the_excerpt()?></p>
                        </div>
                        <div class="meta">
                            <time class="published" datetime="<?php get_the_date() ?>"><?php echo get_the_date() ?></time>
                            <a href="#" class="author"><span class="name"><?php the_author() ?></a>
                        </div>
                    </header>
                    
                    <!-- The content -->
                    <div class="entry-content image featured">
                        <?php echo custom_content_length(get_the_content(), 200); ?>
                    </div>

                    <footer>
                        <ul class="actions">
                            <li><a href="<?php the_permalink() ?>" class="button large">Continue Reading</a></li>
                        </ul>
                        <ul class="stats">
                            <li><a href="#">General</a></li>
                            <li><a href="#" class="icon solid fa-heart">28</a></li>
                            <li><a href="#" class="icon solid fa-comment">128</a></li>
                        </ul>
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
    </div>
    <?php 
        get_footer();
    ?>
