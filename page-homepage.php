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
                <h1><?php echo esc_html($sc_hero_title ?: 'Download Music from SoundCloud'); ?></h1>
                <div class="hero-desc"><?php echo wpautop($sc_hero_desc ?: 'Download your favorite tracks from SoundCloud in high quality. Fast, secure, and easy to use.'); ?></div>
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
            <div class="text-center">
                <h2><?php echo esc_html($feat_title ?: 'Why Choose Our Downloader?'); ?></h2>
                <div class="mb-4"><?php echo wpautop($feat_desc ?: 'Experience the best SoundCloud downloader with these amazing features'); ?></div>
            </div>
            
            <?php if (!empty($features)) : ?>
            <div class="features-grid">
                <?php foreach ($features as $item) :
                    $icon = isset($item['icon']) ? $item['icon'] : '';
                    $title = isset($item['title']) ? $item['title'] : '';
                    $desc = isset($item['desc']) ? $item['desc'] : '';
                    ?>
                    <div class="feature-card">
                        <div class="feature-icon"><?php echo $icon !== '' ? wp_kses_post($icon) : '🎵'; ?></div>
                        <h3><?php echo esc_html($title ?: 'Feature'); ?></h3>
                        <p><?php echo esc_html($desc ?: '...'); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Downloader Preview Section -->
    <section class="downloader-section">
        <div class="container">
            <div class="text-center mb-4">
                <h2>How It Works</h2>
                <p>Download any SoundCloud track in just 3 simple steps</p>
            </div>
            
            <div class="downloader-form">
                <form id="soundcloud-downloader" method="post">
                    <div class="form-group">
                        <label for="soundcloud-url">Paste SoundCloud URL</label>
                        <input type="url" id="soundcloud-url" name="soundcloud_url" placeholder="https://soundcloud.com/artist/track-name" required>
                    </div>
                    <button type="submit" class="download-btn">Download Now</button>
                </form>
            </div>
            
            <div class="text-center mt-4">
                <p><strong>Supported formats:</strong> MP3, FLAC, WAV, M4A</p>
                <p><strong>Quality options:</strong> 128kbps, 256kbps, 320kbps, Lossless</p>
            </div>
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
            <div class="text-center mb-4">
                <h2><?php echo esc_html($faq_title ?: 'Frequently Asked Questions'); ?></h2>
                <div><?php echo wpautop($faq_desc ?: 'Get answers to common questions about our SoundCloud downloader'); ?></div>
            </div>
            
            <?php if (!empty($faqs)) : ?>
            <div class="faq-container">
                <?php foreach ($faqs as $row) :
                    $q = isset($row['q']) ? $row['q'] : '';
                    $a = isset($row['a']) ? $row['a'] : '';
                ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo esc_html($q ?: 'Question'); ?></h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <?php echo wpautop(esc_html($a ?: 'Answer')); ?>
                    </div>
                </div>
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
