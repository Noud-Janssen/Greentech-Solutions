<?php
/**
 * The main template file
 *
 * @package YourCustomTheme
 */

get_header(); // Include the header template part.
?>

<div role="main">
    <?php if (have_posts()) : ?>
        <?php while ( have_posts() ) : the_post(); ?>   
            <article class="post" id="post-<?php the_ID(); ?>">
                <header>
                    <div class="title">
                        <h2><a href="#"><?php the_title()?></a></h2>
                        <p><?php the_excerpt() ?></p>
                    </div>
                    <div class="meta">
                            <time class="published" datetime="<?php get_the_date() ?>"><?php echo get_the_date() ?></time>
                            <a href="#" class="author"><span class="name"><?php the_author() ?></span><img src="images/avatar.jpg" alt="" /></a>
                        </div>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                    <footer>
                        <ul class="stats">
                            <li><a href="#">General</a></li>
                            <li><a href="#" class="icon solid fa-heart">28</a></li>
                            <li><a href="#" class="icon solid fa-comment">128</a></li>
                        </ul>
                    </footer>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>

</div>

<?php
//get_sidebar(); // Include the sidebar template part if you have one.
get_footer(); // Include the footer template part.
