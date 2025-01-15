<div id="sidebar-primary" class="sidebar">
    <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
        <!-- Display the widgets added via the WordPress admin -->
        <?php dynamic_sidebar( 'primary-sidebar' ); ?>
    <?php else : ?>
        <!-- Custom Sidebar Content when no widgets are active -->

        <div class="widget">
            <h3>Search</h3>
            <?php get_search_form(); ?>
        </div>
        
        <div class="widget">
            <h3>Example Links</h3>
            <ul>
                <li><a href="#">Example Link 1</a></li>
                <li><a href="#">Example Link 2</a></li>
                <li><a href="#">Example Link 3</a></li>
            </ul>
        </div>

        <div class="widget">
            <h3><?php if ( is_user_logged_in() ) { echo 'Logout'; } else { echo 'Login'; } ?></h3>
            <ul>
                <?php if ( is_user_logged_in() ) : ?>
                    <li><a href="<?php echo wp_logout_url(); ?>">Logout</a></li>
                <?php else : ?>
                    <li><a href="<?php echo wp_login_url(); ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>

    <?php endif; ?>
</div>