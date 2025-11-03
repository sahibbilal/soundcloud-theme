<?php
/**
 * Template Name: About Us Page
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <?php
            $sc_about_intro = get_post_meta(get_the_ID(), '_sc_about_intro', true);
            $sc_mission_title = get_post_meta(get_the_ID(), '_sc_about_mission_title', true);
            $sc_mission_desc  = get_post_meta(get_the_ID(), '_sc_about_mission_desc', true);
            $sc_what_title    = get_post_meta(get_the_ID(), '_sc_about_what_title', true);
            $sc_what_desc     = get_post_meta(get_the_ID(), '_sc_about_what_desc', true);
            $sc_about_email   = get_post_meta(get_the_ID(), '_sc_about_contact_email', true);
            ?>
            <div class="page-header">
                <h1><?php the_title(); ?></h1>
                <div><?php echo wpautop($sc_about_intro ?: 'Learn more about our mission and team'); ?></div>
            </div>
            
            <div class="content-area">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
                <div class="about-content">
                    <h2><?php echo esc_html($sc_mission_title ?: 'Our Mission'); ?></h2>
                    <div><?php echo wpautop($sc_mission_desc ?: "We are passionate about music and technology, dedicated to providing the best SoundCloud downloading experience. Our mission is to make music accessible to everyone while respecting artists' rights and copyright laws."); ?></div>
                    
                    <h2><?php echo esc_html($sc_what_title ?: 'What We Do'); ?></h2>
                    <div><?php echo wpautop($sc_what_desc ?: 'Our platform allows users to download their favorite tracks from SoundCloud in various high-quality formats. We focus on:'); ?></div>
                    <ul>
                        <li>Providing fast and reliable download services</li>
                        <li>Supporting multiple audio formats and quality options</li>
                        <li>Ensuring user privacy and data security</li>
                        <li>Maintaining a user-friendly interface</li>
                        <li>Respecting copyright and fair use policies</li>
                    </ul>
                    
                    <h2>Our Values</h2>
                    <div class="values-grid">
                        <div class="value-item">
                            <h3>Quality</h3>
                            <p>We strive to provide the highest quality downloads and user experience.</p>
                        </div>
                        <div class="value-item">
                            <h3>Privacy</h3>
                            <p>Your privacy is important to us. We don't store your personal data.</p>
                        </div>
                        <div class="value-item">
                            <h3>Innovation</h3>
                            <p>We continuously improve our technology to serve you better.</p>
                        </div>
                        <div class="value-item">
                            <h3>Respect</h3>
                            <p>We respect artists' rights and encourage legal music consumption.</p>
                        </div>
                    </div>
                    
                    <h2>Legal Notice</h2>
                    <p><strong>Important:</strong> This service is for educational and personal use only. Users are responsible for ensuring they have the right to download content. We encourage users to:</p>
                    <ul>
                        <li>Only download content you have permission to use</li>
                        <li>Respect copyright laws and artist rights</li>
                        <li>Support artists by purchasing their music when possible</li>
                        <li>Use downloaded content for personal use only</li>
                    </ul>
                    
                    <h2>Contact Information</h2>
                    <p>If you have any questions about our service or need support, please don't hesitate to contact us:</p>
                    <div class="contact-info">
                        <p><strong>Email:</strong> <?php echo esc_html($sc_about_email ?: 'support@soundcloud-downloader.com'); ?></p>
                        <p><strong>Response Time:</strong> Within 24 hours</p>
                        <p><strong>Support Hours:</strong> 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.about-content h2 {
    color: #333;
    margin: 2rem 0 1rem;
    font-size: 1.8rem;
}

.about-content h3 {
    color: #667eea;
    margin: 1.5rem 0 0.5rem;
    font-size: 1.3rem;
}

.about-content ul {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.about-content li {
    margin-bottom: 0.5rem;
    color: #555;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.value-item {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
}

.value-item h3 {
    color: #667eea;
    margin-bottom: 0.5rem;
}

.value-item p {
    color: #666;
    font-size: 0.95rem;
}

.contact-info {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.contact-info p {
    margin-bottom: 0.5rem;
    color: #555;
}
</style>

<?php get_footer(); ?>
