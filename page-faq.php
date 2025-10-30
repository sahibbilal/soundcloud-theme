<?php
/**
 * Template Name: FAQ Page
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <?php
            $sc_faq_title = get_post_meta(get_the_ID(), '_sc_faq_title', true);
            $sc_faq_desc  = get_post_meta(get_the_ID(), '_sc_faq_desc', true);
            $sc_faq_items = get_post_meta(get_the_ID(), '_sc_faq_items', true);
            if (!is_array($sc_faq_items)) { $sc_faq_items = array(); }
            ?>
            <div class="page-header">
                <h1><?php echo esc_html($sc_faq_title ?: get_the_title()); ?></h1>
                <div><?php echo wpautop($sc_faq_desc ?: 'Find answers to common questions about our SoundCloud downloader service'); ?></div>
            </div>
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
            
            <div class="faq-content">
                <?php
                $cat_general   = get_post_meta(get_the_ID(), '_sc_faq_cat_general', true);
                $cat_technical = get_post_meta(get_the_ID(), '_sc_faq_cat_technical', true);
                $cat_legal     = get_post_meta(get_the_ID(), '_sc_faq_cat_legal', true);
                $cat_privacy   = get_post_meta(get_the_ID(), '_sc_faq_cat_privacy', true);
                ?>
                <div class="faq-categories">
                    <div class="faq-category active" data-category="general">
                        <h3><?php echo esc_html($cat_general ?: 'General'); ?></h3>
                    </div>
                    <div class="faq-category" data-category="technical">
                        <h3><?php echo esc_html($cat_technical ?: 'Technical'); ?></h3>
                    </div>
                    <div class="faq-category" data-category="legal">
                        <h3><?php echo esc_html($cat_legal ?: 'Legal'); ?></h3>
                    </div>
                    <div class="faq-category" data-category="privacy">
                        <h3><?php echo esc_html($cat_privacy ?: 'Privacy'); ?></h3>
                    </div>
                </div>
                
                <div class="faq-container">
                    <!-- General FAQs -->
                    <div class="faq-section" data-section="general">
                        <?php if (!empty($sc_faq_items)) : ?>
                            <?php foreach ($sc_faq_items as $row) :
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
                        <?php endif; ?>
                    </div>
                    
                    <!-- Technical FAQs -->
                    <div class="faq-section" data-section="technical" style="display: none;">
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
                                <h3>How long does a download take?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>Most downloads are processed within 30 seconds, depending on track length and quality. Our optimized servers ensure fast processing times.</p>
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
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What if a download fails?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>If a download fails, try again with the same URL. If the issue persists, the track might be private, deleted, or have download restrictions. Contact our support team for assistance.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Is there a download limit?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>There are no daily or monthly limits for downloads. However, we may implement rate limiting to ensure fair usage for all users.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Legal FAQs -->
                    <div class="faq-section" data-section="legal" style="display: none;">
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
                                <h3>What about copyrighted music?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>We respect copyright laws and encourage users to only download content they have permission to use. We recommend supporting artists through official channels and purchasing music when possible.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Can I use downloaded music commercially?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>Commercial use depends on the original track's licensing. Please check the track's license on SoundCloud and obtain proper permissions before any commercial use.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What if I receive a DMCA notice?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>We take DMCA notices seriously. If you receive a valid DMCA notice, please remove the content immediately and contact our support team for assistance.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Privacy FAQs -->
                    <div class="faq-section" data-section="privacy" style="display: none;">
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
                                <h3>What data do you collect?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>We only collect anonymous usage statistics to improve our service. We don't collect personal information, IP addresses, or track individual users.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Are my downloads private?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, all downloads are processed privately. We don't log or store information about what you download or when you download it.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Do you use cookies?</h3>
                                <span class="faq-toggle">+</span>
                            </div>
                            <div class="faq-answer">
                                <p>We use minimal cookies only for essential functionality. We don't use tracking cookies or share data with third parties.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                $sc_support_title = get_post_meta(get_the_ID(), '_sc_faq_support_title', true);
                $sc_support_desc  = get_post_meta(get_the_ID(), '_sc_faq_support_desc', true);
                ?>
                <div class="faq-contact">
                    <h2><?php echo esc_html($sc_support_title ?: 'Still Have Questions?'); ?></h2>
                    <div><?php echo wpautop($sc_support_desc ?: "Can't find the answer you're looking for? Our support team is here to help."); ?></div>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="cta-button">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.faq-content {
    margin-top: 2rem;
}

.faq-categories {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.faq-category {
    background: #f8fafc;
    padding: 1rem 2rem;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.faq-category:hover {
    background: #e2e8f0;
}

.faq-category.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.faq-category h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.faq-section {
    max-width: 800px;
    margin: 0 auto;
}

.faq-contact {
    text-align: center;
    margin-top: 4rem;
    padding: 3rem;
    background: #f8fafc;
    border-radius: 15px;
}

.faq-contact h2 {
    color: #333;
    margin-bottom: 1rem;
}

.faq-contact p {
    color: #666;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .faq-categories {
        flex-direction: column;
        align-items: center;
    }
    
    .faq-category {
        width: 200px;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ category switching
    const categoryButtons = document.querySelectorAll('.faq-category');
    const faqSections = document.querySelectorAll('.faq-section');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active category
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding FAQ section
            faqSections.forEach(section => {
                if (section.getAttribute('data-section') === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
    
    // FAQ toggle functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const answer = faqItem.querySelector('.faq-answer');
            
            // Close other FAQ items in the same section
            const currentSection = faqItem.closest('.faq-section');
            const otherItems = currentSection.querySelectorAll('.faq-item');
            otherItems.forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                    const otherAnswer = item.querySelector('.faq-answer');
                    otherAnswer.style.maxHeight = '0';
                }
            });
            
            // Toggle current FAQ item
            faqItem.classList.toggle('active');
            if (faqItem.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = '0';
            }
        });
    });
});
</script>

<?php get_footer(); ?>
