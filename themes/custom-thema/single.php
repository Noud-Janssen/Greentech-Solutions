<?php
/**
 * The main template file
 *
 * @package YourCustomTheme
 */

get_header(); // Include the header template part.
?>

<main id="main-content" role="main">
    <?php if (have_posts()) : ?>
        <?php while ( have_posts() ) : the_post(); ?>   
            <article id="post-<?php the_ID(); ?>">
                <div class="post-header">
                    <div class="title">
                        <h1><?php the_title() ?></h1>
                        <h2><?php the_excerpt() ?></h1>
                    </div>
                    <div class="meta">
                        <h3><?php echo get_the_date() ?></h3>
                        <h4><?php echo get_the_author() ?></h4>
                    </div>
                </div>
                <p><?php the_content() ?></p>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>

</main>

<?php
//get_sidebar(); // Include the sidebar template part if you have one.
get_footer(); // Include the footer template part.
