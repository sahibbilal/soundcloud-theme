<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) :
                    ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                </div>

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="menu-toggle-text">Menu</span>
                        <span class="menu-toggle-icon">☰</span>
                    </button>
                    
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id' => 'primary-menu',
                            'menu_class' => 'nav-menu',
                            'container' => false,
                        ));
                    } else {
                        // Fallback: list top-level pages so new pages appear automatically
                        echo '<ul id="primary-menu" class="nav-menu">';
                        wp_list_pages(array(
                            'title_li' => '',
                            'depth' => 1,
                            'sort_column' => 'menu_order,post_title'
                        ));
                        echo '</ul>';
                    }
                    ?>
                    
                    <div class="header-actions">
                        <button class="search-toggle" aria-label="Search">
                            <span class="search-icon">🔍</span>
                        </button>
                    </div>
                </nav>
                
                <!-- Search Popup -->
                <div id="search-popup" class="search-popup">
                    <div class="search-popup-content">
                        <div class="search-popup-header">
                            <h3>Search</h3>
                            <button class="search-close" aria-label="Close search">
                                <span>×</span>
                            </button>
                        </div>
                        <div class="search-popup-body">
                            <?php get_search_form(); ?>
                            <div class="search-suggestions">
                                <h4>Popular Searches</h4>
                                <div class="search-tags">
                                    <span class="search-tag">SoundCloud</span>
                                    <span class="search-tag">Download</span>
                                    <span class="search-tag">Music</span>
                                    <span class="search-tag">MP3</span>
                                    <span class="search-tag">Audio</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">

<?php // fallback removed; header uses wp_list_pages when no menu is assigned ?>
