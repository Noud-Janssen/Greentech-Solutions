<div id="sidebar-primary" class="sidebar">
    <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
        <!-- Display the widgets added via the WordPress admin -->
        <?php dynamic_sidebar( 'primary-sidebar' ); ?>
    <?php else : ?>
        <!-- Custom Sidebar Content when no widgets are active -->

        <div class="widget">
            <form class="search" method="get" action="#">
                    <input type="text" name="s" placeholder="Search" />
                </form>
        </div>
        
        <div class="widget">
            <h3>Example Links</h3>
            <div class="sidebar-links">
                <a href="#">Example Link 1</a>
                <a href="#">Example Link 2</a>
                <a href="#">Example Link 3</a>
                <a href="#">Example Link 4</a>
                <a href="#">Example Link 5</a>
            </div>
        </div>

        <div class="widget">
            <ul>
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo wp_logout_url(); ?>" class="button large fit">Logout</a>
                <?php else : ?>
                    <a href="<?php echo wp_login_url(); ?> " class="button large fit">Login</a>
                <?php endif; ?>
            </ul>
        </div>

    <?php endif; ?>
</div>