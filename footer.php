    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php bloginfo('name'); ?></h3>
                    <p><?php bloginfo('description'); ?></p>
                    <p>Download your favorite tracks from SoundCloud in high quality. Fast, secure, and easy to use.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <?php if (has_nav_menu('footer_quick')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_quick',
                            'container' => false,
                            'menu_class' => '',
                            'fallback_cb' => false,
                        ));
                    } ?>
                </div>
                
                <div class="footer-section">
                    <h3>Legal</h3>
                    <?php if (has_nav_menu('footer_legal')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_legal',
                            'container' => false,
                            'menu_class' => '',
                            'fallback_cb' => false,
                        ));
                    } ?>
                </div>
                
                <div class="footer-section">
                    <h3>Support</h3>
                    <?php if (has_nav_menu('footer_support')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_support',
                            'container' => false,
                            'menu_class' => '',
                            'fallback_cb' => false,
                        ));
                    } ?>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                <?php if (has_nav_menu('footer_bottom')) {
                    wp_nav_menu(array(
                        'theme_location' => 'footer_bottom',
                        'container' => false,
                        'menu_class' => 'footer-bottom-menu',
                        'fallback_cb' => false,
                        'depth' => 1,
                    ));
                } ?>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.main-navigation');
    
    if (menuToggle && navigation) {
        menuToggle.addEventListener('click', function() {
            navigation.classList.toggle('menu-open');
            menuToggle.classList.toggle('menu-open');
        });
    }
});
</script>

</body>
</html>
