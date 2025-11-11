<?php
/**
 * Template Name: Homepage Template
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <?php
                $sc_hero_title = get_post_meta(get_the_ID(), '_sc_home_hero_title', true);
                $sc_hero_desc  = get_post_meta(get_the_ID(), '_sc_home_hero_desc', true);
                ?>
                <?php if (!empty($sc_hero_title)) : ?><h1><?php echo esc_html($sc_hero_title); ?></h1><?php endif; ?>
                <?php if (!empty($sc_hero_desc)) : ?><div class="hero-desc"><?php echo wpautop($sc_hero_desc); ?></div><?php endif; ?>
                <?php echo do_shortcode('[soundcloud_downloader]'); ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <?php
            $feat_title = get_post_meta(get_the_ID(), '_sc_home_feat_title', true);
            $feat_desc  = get_post_meta(get_the_ID(), '_sc_home_feat_desc', true);
            $features   = get_post_meta(get_the_ID(), '_sc_home_features', true);
            if (!is_array($features)) { $features = array(); }
            ?>
            <?php if (!empty($feat_title) || !empty($feat_desc)) : ?>
            <div class="text-center">
                <?php if (!empty($feat_title)) : ?><h2><?php echo esc_html($feat_title); ?></h2><?php endif; ?>
                <?php if (!empty($feat_desc)) : ?><div class="mb-4"><?php echo wpautop($feat_desc); ?></div><?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($features)) : ?>
            <div class="features-grid">
                <?php foreach ($features as $item) :
                    $icon = isset($item['icon']) ? $item['icon'] : '';
                    $title = isset($item['title']) ? $item['title'] : '';
                    $desc = isset($item['desc']) ? $item['desc'] : '';
                    ?>
                    <div class="feature-card">
                        <?php if (!empty($icon)) : ?><div class="feature-icon"><?php echo wp_kses_post($icon); ?></div><?php endif; ?>
                        <?php if (!empty($title)) : ?><h3><?php echo esc_html($title); ?></h3><?php endif; ?>
                        <?php if (!empty($desc)) : ?><p><?php echo esc_html($desc); ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section" style="padding: 4rem 0;">
        <div class="container">
            <?php the_content(); ?>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" style="background: #f8fafc; padding: 4rem 0;">
        <div class="container">
            <div class="text-center">
                <h2>Trusted by Millions</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 2rem;">
                    <div class="text-center">
                        <h3 style="font-size: 2.5rem; color: #667eea; margin-bottom: 0.5rem;">10M+</h3>
                        <p>Downloads Completed</p>
                    </div>
                    <div class="text-center">
                        <h3 style="font-size: 2.5rem; color: #667eea; margin-bottom: 0.5rem;">500K+</h3>
                        <p>Happy Users</p>
                    </div>
                    <div class="text-center">
                        <h3 style="font-size: 2.5rem; color: #667eea; margin-bottom: 0.5rem;">99.9%</h3>
                        <p>Success Rate</p>
                    </div>
                    <div class="text-center">
                        <h3 style="font-size: 2.5rem; color: #667eea; margin-bottom: 0.5rem;">24/7</h3>
                        <p>Available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" style="background: white; padding: 4rem 0;">
        <div class="container">
            <?php
            $faq_title = get_post_meta(get_the_ID(), '_sc_home_faq_title', true);
            $faq_desc  = get_post_meta(get_the_ID(), '_sc_home_faq_desc', true);
            $faqs      = get_post_meta(get_the_ID(), '_sc_home_faq_items', true);
            if (!is_array($faqs)) { $faqs = array(); }
            ?>
            <?php if (!empty($faq_title) || !empty($faq_desc)) : ?>
            <div class="text-center mb-4">
                <?php if (!empty($faq_title)) : ?><h2><?php echo esc_html($faq_title); ?></h2><?php endif; ?>
                <?php if (!empty($faq_desc)) : ?><div><?php echo wpautop($faq_desc); ?></div><?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($faqs)) : ?>
            <div class="faq-container">
                <?php foreach ($faqs as $row) :
                    $q = isset($row['q']) ? $row['q'] : '';
                    $a = isset($row['a']) ? $row['a'] : '';
                ?>
                <?php if (!empty($q) || !empty($a)) : ?>
                <div class="faq-item">
                    <?php if (!empty($q)) : ?>
                    <div class="faq-question">
                        <h3><?php echo esc_html($q); ?></h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($a)) : ?>
                    <div class="faq-answer">
                        <?php echo wpautop(esc_html($a)); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="cta-button">View All FAQs</a>
            </div>
        </div>
    </section>
</main>

<script>
// Download form handling
document.addEventListener('DOMContentLoaded', function() {
    const downloadForm = document.getElementById('soundcloud-downloader');
    
    if (downloadForm) {
        downloadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const url = document.getElementById('soundcloud-url').value;
            const button = downloadForm.querySelector('.download-btn');
            
            if (!url) {
                alert('Please enter a valid SoundCloud URL');
                return;
            }
            
            // Show loading state
            button.textContent = 'Processing...';
            button.disabled = true;
            
            // Simulate download process (replace with actual AJAX call)
            setTimeout(function() {
                alert('Download feature will be implemented with backend integration');
                button.textContent = 'Download Now';
                button.disabled = false;
            }, 2000);
        });
    }
});
</script>

<?php get_footer(); ?>
