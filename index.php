<?php
/**
 * The main template file
 *
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">

    <?php if (is_front_page()) : ?>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1><?php echo get_theme_mod('hero_title', 'Download Music from SoundCloud'); ?></h1>
                    <p><?php echo get_theme_mod('hero_description', 'Download your favorite tracks from SoundCloud in high quality. Fast, secure, and easy to use.'); ?></p>
                    <a href="<?php echo esc_url(home_url('/downloader/')); ?>" class="cta-button">Start Downloading</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="text-center">
                    <h2>Why Choose Our Downloader?</h2>
                    <p class="mb-4">Experience the best SoundCloud downloader with these amazing features</p>
                </div>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🎵</div>
                        <h3>High Quality Audio</h3>
                        <p>Download tracks in the highest available quality, including 320kbps MP3 and lossless formats.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3>Lightning Fast</h3>
                        <p>Our optimized servers ensure the fastest download speeds possible for your music.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🔒</div>
                        <h3>Secure & Private</h3>
                        <p>Your downloads are completely secure and private. We don't store your data.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">📱</div>
                        <h3>Mobile Friendly</h3>
                        <p>Works perfectly on all devices - desktop, tablet, and mobile phones.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🆓</div>
                        <h3>100% Free</h3>
                        <p>No registration required, no hidden fees, no premium limitations.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🌍</div>
                        <h3>Global Access</h3>
                        <p>Available worldwide with support for all major languages and regions.</p>
                    </div>
                </div>
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
                <div class="text-center mb-4">
                    <h2>Frequently Asked Questions</h2>
                    <p>Get answers to common questions about our SoundCloud downloader</p>
                </div>
                
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Is this service free to use?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, our basic download service is completely free with no registration required. You can download tracks without any cost or hidden fees.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>What audio formats are supported?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>We support multiple formats including MP3 (128kbps, 256kbps, 320kbps), FLAC (lossless), WAV, and M4A. Choose the quality that best suits your needs.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Is it legal to download from SoundCloud?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Please ensure you have the right to download content. We encourage users to respect copyright laws and only download content they have permission to use. Support artists through official channels when possible.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How long does a download take?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Most downloads are processed within 30 seconds, depending on track length and quality. Our optimized servers ensure fast processing times.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Do you store my personal information?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>No, we don't store your personal information. Your privacy is important to us, and we only process downloads without collecting personal data.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>Can I download playlists?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Currently, we support individual track downloads. For playlists, you'll need to download each track separately. We're working on playlist support for future updates.</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="cta-button">View All FAQs</a>
                </div>
            </div>
        </section>

    <?php else : ?>
        <!-- Regular page content -->
        <div class="page-content">
            <div class="container">
                <div class="page-header">
                    <h1><?php the_title(); ?></h1>
                </div>
                
                <div class="content-area">
                    <?php
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</main><!-- #main -->

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

<?php
get_footer();
