<?php
/**
 * Sound Cloud Theme functions and definitions
 *
 * @package Sound_Cloud_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function sound_cloud_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'sound-cloud-theme'),
        'footer_quick' => __('Footer Quick Links', 'sound-cloud-theme'),
        'footer_legal' => __('Footer Legal', 'sound-cloud-theme'),
        'footer_support' => __('Footer Support', 'sound-cloud-theme'),
        'footer_bottom' => __('Footer Bottom Links', 'sound-cloud-theme'),
    ));
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');
}
add_action('after_setup_theme', 'sound_cloud_theme_setup');

/**
 * Enqueue scripts and styles
 */
function sound_cloud_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('sound-cloud-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue Google Fonts
    wp_enqueue_style('sound-cloud-theme-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Enqueue main JavaScript
    wp_enqueue_script('sound-cloud-theme-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('sound-cloud-theme-script', 'soundCloudAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sound_cloud_nonce'),
    ));

    $base = get_template_directory_uri() . '/soundcloud';
    // Enqueue external JS for shortcode
    wp_enqueue_script(
        'soundcloud-downloader-shortcode',
        get_template_directory_uri() . '/js/soundcloud-downloader.js',
        array(),
        '1.0.0',
        true
    );
    wp_localize_script('soundcloud-downloader-shortcode', 'SCDL', array('base' => $base));
    
}
add_action('wp_enqueue_scripts', 'sound_cloud_theme_scripts');

/**
 * Register widget areas
 */
function sound_cloud_theme_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'sound-cloud-theme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'sound-cloud-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'sound-cloud-theme'),
        'id' => 'footer-widgets',
        'description' => __('Add widgets here to appear in the footer.', 'sound-cloud-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'sound_cloud_theme_widgets_init');

/**
 * Custom excerpt length
 */
function sound_cloud_theme_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'sound_cloud_theme_excerpt_length');

/**
 * Custom excerpt more
 */
function sound_cloud_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'sound_cloud_theme_excerpt_more');

/**
 * Add custom body classes
 */
function sound_cloud_theme_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    if (is_page_template('page-downloader.php')) {
        $classes[] = 'downloader-page';
    }
    return $classes;
}
add_filter('body_class', 'sound_cloud_theme_body_classes');

/**
 * Customizer additions
 */
/* removed customizer options at user's request
function sound_cloud_theme_customize_register($wp_customize) {
    // Add a section for theme options
    $wp_customize->add_section('sound_cloud_theme_options', array(
        'title' => __('Theme Options', 'sound-cloud-theme'),
        'priority' => 30,
    ));
    
    // Add setting for hero title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Download Music from SoundCloud',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'sound-cloud-theme'),
        'section' => 'sound_cloud_theme_options',
        'type' => 'text',
    ));
    
    // Add setting for hero description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'Download your favorite tracks from SoundCloud in high quality',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label' => __('Hero Description', 'sound-cloud-theme'),
        'section' => 'sound_cloud_theme_options',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'sound_cloud_theme_customize_register');
*/



/**
 * Add custom post types if needed
 */
function sound_cloud_theme_custom_post_types() {
    // You can add custom post types here if needed
}
add_action('init', 'sound_cloud_theme_custom_post_types');

/**
 * Security enhancements
 */
// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Remove unnecessary meta tags
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

/**
 * Performance optimizations
 */
// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove unnecessary scripts
function sound_cloud_theme_remove_unnecessary_scripts() {
    if (!is_admin()) {
        wp_dequeue_script('wp-embed');
    }
}
add_action('wp_footer', 'sound_cloud_theme_remove_unnecessary_scripts');

/**
 * Theme data import functionality
 */
function sound_cloud_theme_import_data() {
    // Check if data has already been imported
    if (get_option('sound_cloud_theme_data_imported')) {
        return;
    }
    
    $json_file = get_template_directory() . '/theme-data.json';
    
    if (!file_exists($json_file)) {
        return;
    }
    
    $json_data = file_get_contents($json_file);
    $data = json_decode($json_data, true);
    
    if (!$data || !isset($data['import_data'])) {
        return;
    }
    
    $import_data = $data['import_data'];
    
    // Import pages
    if (isset($import_data['pages'])) {
        foreach ($import_data['pages'] as $page_data) {
            $existing_page = get_page_by_path($page_data['slug']);
            if (!$existing_page) {
                $page_id = wp_insert_post(array(
                    'post_title' => $page_data['title'],
                    'post_name' => $page_data['slug'],
                    'post_content' => $page_data['content'],
                    'post_status' => $page_data['status'],
                    'post_type' => 'page'
                ));
                
                if ($page_id && isset($page_data['meta'])) {
                    foreach ($page_data['meta'] as $key => $value) {
                        update_post_meta($page_id, $key, $value);
                    }
                }
            } else {
                // Update existing page content to make it editable
                wp_update_post(array(
                    'ID' => $existing_page->ID,
                    'post_content' => $page_data['content']
                ));
            }
        }
    }
    
    // Import posts
    if (isset($import_data['posts'])) {
        foreach ($import_data['posts'] as $post_data) {
            $existing_post = get_page_by_path($post_data['slug'], OBJECT, 'post');
            if (!$existing_post) {
                $post_id = wp_insert_post(array(
                    'post_title' => $post_data['title'],
                    'post_name' => $post_data['slug'],
                    'post_content' => $post_data['content'],
                    'post_excerpt' => $post_data['excerpt'],
                    'post_status' => $post_data['status'],
                    'post_type' => 'post'
                ));
                
                if ($post_id && isset($post_data['featured_image'])) {
                    // Set featured image (placeholder for now)
                    // In a real implementation, you would download and set the actual image
                }
            } else {
                // Update existing post content to make it editable
                wp_update_post(array(
                    'ID' => $existing_post->ID,
                    'post_content' => $post_data['content'],
                    'post_excerpt' => $post_data['excerpt']
                ));
            }
        }
    }
    
    // Import menus
    if (isset($import_data['menus'])) {
        foreach ($import_data['menus'] as $menu_data) {
            // Check if menu already exists
            $existing_menu = wp_get_nav_menu_object($menu_data['name']);
            if (!$existing_menu) {
                $menu_id = wp_create_nav_menu($menu_data['name']);
            } else {
                $menu_id = $existing_menu->term_id;
            }
            
            if ($menu_id && !is_wp_error($menu_id) && isset($menu_data['items'])) {
                // Clear existing menu items
                $existing_items = wp_get_nav_menu_items($menu_id);
                if ($existing_items) {
                    foreach ($existing_items as $item) {
                        wp_delete_post($item->ID, true);
                    }
                }
                
                foreach ($menu_data['items'] as $item_data) {
                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' => $item_data['title'],
                        'menu-item-url' => home_url($item_data['url']),
                        'menu-item-status' => 'publish',
                        'menu-item-type' => 'custom'
                    ));
                }
                
                // Assign menu to location
                $locations = get_theme_mod('nav_menu_locations');
                if (!$locations) {
                    $locations = array();
                }
                $locations[$menu_data['location']] = $menu_id;
                set_theme_mod('nav_menu_locations', $locations);
            }
        }
    }
    
    // Import theme options
    if (isset($import_data['theme_options'])) {
        foreach ($import_data['theme_options'] as $key => $value) {
            set_theme_mod($key, $value);
        }
    }
    
    // Set blog page
    $blog_page = get_page_by_path('blog');
    if ($blog_page) {
        update_option('page_for_posts', $blog_page->ID);
    }
    
    // Mark data as imported
    update_option('sound_cloud_theme_data_imported', true);
}

// Run import on theme activation
add_action('after_switch_theme', 'sound_cloud_theme_import_data');


/**
 * Add admin menu for theme data management
 */
function sound_cloud_theme_admin_menu() {
    add_theme_page(
        'Theme Data',
        'Theme Data',
        'manage_options',
        'sound-cloud-theme-data',
        'sound_cloud_theme_data_page'
    );
}
add_action('admin_menu', 'sound_cloud_theme_admin_menu');

// Include template meta boxes
require_once get_template_directory() . '/inc/meta-boxes.php';

/**
 * Theme data management page
 */
function sound_cloud_theme_data_page() {
    if (isset($_POST['reimport_data']) && wp_verify_nonce($_POST['_wpnonce'], 'reimport_theme_data')) {
        delete_option('sound_cloud_theme_data_imported');
        sound_cloud_theme_import_data();
        echo '<div class="notice notice-success"><p>Theme data has been reimported successfully!</p></div>';
    }
    
    if (isset($_POST['reset_data']) && wp_verify_nonce($_POST['_wpnonce'], 'reset_theme_data')) {
        delete_option('sound_cloud_theme_data_imported');
        echo '<div class="notice notice-success"><p>Theme data import flag has been reset. Data will be imported on next page load.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Sound Cloud Theme Data Management</h1>
        
        <div class="card">
            <h2>Import Status</h2>
            <p>
                <?php if (get_option('sound_cloud_theme_data_imported')): ?>
                    <span style="color: green;">✓ Theme data has been imported successfully.</span>
                <?php else: ?>
                    <span style="color: orange;">⚠ Theme data has not been imported yet.</span>
                <?php endif; ?>
            </p>
        </div>
        
        <div class="card">
            <h2>Actions</h2>
            <form method="post" style="display: inline-block; margin-right: 10px;">
                <?php wp_nonce_field('reimport_theme_data'); ?>
                <input type="submit" name="reimport_data" class="button button-primary" value="Reimport Theme Data" onclick="return confirm('This will reimport all theme data. Continue?');">
            </form>
            
            <form method="post" style="display: inline-block;">
                <?php wp_nonce_field('reset_theme_data'); ?>
                <input type="submit" name="reset_data" class="button" value="Reset Import Flag" onclick="return confirm('This will reset the import flag. Data will be imported on next page load. Continue?');">
            </form>
        </div>
        
        <div class="card">
            <h2>Imported Content</h2>
            <p>The following content has been automatically created:</p>
            <ul>
                <li><strong>Pages:</strong> Downloader, About Us, Privacy Policy, Contact Us, FAQ, Blog</li>
                <li><strong>Posts:</strong> 5 comprehensive blog posts about SoundCloud downloading</li>
                <li><strong>Menus:</strong> Primary navigation and footer menu</li>
                <li><strong>Theme Options:</strong> Customizable through Appearance → Customize</li>
            </ul>
        </div>
        
        <div class="card">
            <h2>Customization</h2>
            <p>You can customize the theme through:</p>
            <ul>
                <li><strong>Appearance → Customize:</strong> Hero section, contact info, social links, footer</li>
                <li><strong>Pages:</strong> Edit page content through Pages menu</li>
                <li><strong>Posts:</strong> Edit blog posts through Posts menu</li>
                <li><strong>Menus:</strong> Edit navigation through Appearance → Menus</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * Shortcode: [soundcloud_downloader]
 * Renders the SoundCloud downloader UI and wires it to the PHP endpoints in theme/soundcloud/
 */
function sound_cloud_theme_shortcode_downloader() {
    ob_start();
    ?>
    <div class="scdl-container" style="font-family: Arial, sans-serif; background-color: #111; color: #eee; margin: 0; padding: 15px;">
        <div class="container" style="max-width: 1000px; margin: auto; word-wrap: break-word;">
            <h1 style="text-align:center;margin-bottom:20px;color:#ffa500;font-size:clamp(20px,5vw,36px);">🎵 SoundCloud Downloader</h1>

            <div class="input-section" style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:20px;">
                <input type="text" id="scdlUrlInput" placeholder="Enter SoundCloud playlist or track URL" style="flex:1;padding:10px;border-radius:5px;border:none;font-size:16px;width:100%;box-sizing:border-box;" />
                <button id="scdlFetchBtn" style="background-color:#f60;border:none;color:#fff;padding:10px 15px;border-radius:5px;font-size:16px;cursor:pointer;">Download</button>
            </div>

            <div id="scdlPlaylistInfo" style="display:none;background:#222;padding:15px;border-radius:10px;margin-bottom:15px;align-items:center;gap:15px;flex-wrap:wrap;">
                <img id="scdlPlaylistArtwork" src="" alt="Artwork" style="width:90px;height:90px;border-radius:10px;object-fit:cover;background:#333;flex-shrink:0;" />
                <div id="scdlPlaylistDetails" style="flex:1;min-width:200px;">
                    <h2 id="scdlPlaylistTitle" style="margin:0 0 5px 0;font-size:clamp(16px,4vw,24px);color:#ffa500;"></h2>
                    <p id="scdlPlaylistAuthor" style="margin:2px 0;color:#bbb;font-size:14px;"></p>
                    <p id="scdlPlaylistCount" style="margin:2px 0;color:#bbb;font-size:14px;"></p>
                </div>
            </div>

            <div class="control-buttons" id="scdlControlButtons" style="display:none;gap:10px;margin-bottom:15px;flex-wrap:wrap;">
                <button id="scdlDownloadAllBtn" disabled style="display:none;background:#f60;border:none;color:#fff;padding:10px 15px;border-radius:5px;">⬇️ Download Full Playlist (Zip File)</button>
                <button id="scdlDownloadAllIndividuallyBtn" style="background-color:#0078d7;border:none;color:#fff;padding:10px 15px;border-radius:5px;">⬇️ Download Playlist</button>
                <button id="scdlDownloadCoverBtn" disabled style="background:#444;border:none;color:#fff;padding:10px 15px;border-radius:5px;">🎨 Download Cover Image</button>
                <button id="scdlDownloadProfileBtn" disabled style="background:#444;border:none;color:#fff;padding:10px 15px;border-radius:5px;">👤 Download Profile Picture</button>
                <button id="scdlResetBtn" style="background:#555;border:none;color:#fff;padding:10px 15px;border-radius:5px;">🔄 Download More</button>
            </div>

            <div id="scdlTracks"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('soundcloud_downloader', 'sound_cloud_theme_shortcode_downloader');
