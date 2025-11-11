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
                    }
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">

<?php // fallback removed; header uses wp_list_pages when no menu is assigned ?>
