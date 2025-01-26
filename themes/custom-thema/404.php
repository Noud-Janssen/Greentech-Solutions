<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package YourThemeName
 */

get_header();
?>

<main class="page-404">
    <section class="error-404">
        <div class="error-content">
            <h1 class="error-title">404</h1>
            <h2>Page Not Found</h2>
            <p>The page you're looking for doesn't exist or has been moved.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>">Return Home</a>
        </div>
    </section>
</main>

<?php
get_footer();