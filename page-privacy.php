<?php
/**
 * Template Name: Privacy Policy Page
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <div class="page-header">
                <h1><?php the_title(); ?></h1>
                <p>Last updated: <?php echo date('F j, Y'); ?></p>
            </div>
            
            <div class="content-area">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
                <div class="privacy-content">
                    <h2>Introduction</h2>
                    <p>This Privacy Policy describes how we collect, use, and protect your information when you use our SoundCloud downloader service. We are committed to protecting your privacy and ensuring the security of your personal information.</p>
                    
                    <h2>Information We Collect</h2>
                    <h3>Information You Provide</h3>
                    <ul>
                        <li>SoundCloud URLs that you submit for downloading</li>
                        <li>Your preferred download quality settings</li>
                        <li>Any feedback or support requests you send us</li>
                    </ul>
                    
                    <h3>Information We Collect Automatically</h3>
                    <ul>
                        <li>IP address and location data (for service optimization)</li>
                        <li>Browser type and version</li>
                        <li>Device information (for mobile compatibility)</li>
                        <li>Usage patterns and download statistics (anonymized)</li>
                    </ul>
                    
                    <h2>How We Use Your Information</h2>
                    <p>We use the collected information to:</p>
                    <ul>
                        <li>Process your download requests</li>
                        <li>Improve our service quality and performance</li>
                        <li>Analyze usage patterns to optimize our platform</li>
                        <li>Provide customer support when needed</li>
                        <li>Ensure compliance with legal requirements</li>
                    </ul>
                    
                    <h2>Information Sharing</h2>
                    <p>We do not sell, trade, or otherwise transfer your personal information to third parties, except in the following circumstances:</p>
                    <ul>
                        <li>When required by law or legal process</li>
                        <li>To protect our rights and prevent fraud</li>
                        <li>With your explicit consent</li>
                        <li>To trusted service providers who assist in our operations (under strict confidentiality agreements)</li>
                    </ul>
                    
                    <h2>Data Security</h2>
                    <p>We implement appropriate security measures to protect your information:</p>
                    <ul>
                        <li>SSL encryption for all data transmission</li>
                        <li>Secure servers with regular security updates</li>
                        <li>Limited access to personal information on a need-to-know basis</li>
                        <li>Regular security audits and monitoring</li>
                    </ul>
                    
                    <h2>Data Retention</h2>
                    <p>We retain your information only as long as necessary to:</p>
                    <ul>
                        <li>Provide our services</li>
                        <li>Comply with legal obligations</li>
                        <li>Resolve disputes and enforce agreements</li>
                    </ul>
                    <p>Download URLs and related data are typically deleted within 24 hours of processing.</p>
                    
                    <h2>Cookies and Tracking</h2>
                    <p>We use cookies and similar technologies to:</p>
                    <ul>
                        <li>Remember your preferences</li>
                        <li>Analyze site traffic and usage</li>
                        <li>Improve user experience</li>
                    </ul>
                    <p>You can control cookie settings through your browser preferences.</p>
                    
                    <h2>Third-Party Services</h2>
                    <p>Our service may integrate with third-party services for analytics and performance monitoring. These services have their own privacy policies, and we encourage you to review them.</p>
                    
                    <h2>Your Rights</h2>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Object to processing of your information</li>
                        <li>Data portability (where applicable)</li>
                    </ul>
                    
                    <h2>Children's Privacy</h2>
                    <p>Our service is not intended for children under 13. We do not knowingly collect personal information from children under 13. If we become aware that we have collected such information, we will take steps to delete it promptly.</p>
                    
                    <h2>International Users</h2>
                    <p>If you are accessing our service from outside the United States, please note that your information may be transferred to, stored, and processed in the United States where our servers are located.</p>
                    
                    <h2>Changes to This Policy</h2>
                    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.</p>
                    
                    <h2>Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy, please contact us:</p>
                    <div class="contact-info">
                        <p><strong>Email:</strong> privacy@soundcloud-downloader.com</p>
                        <p><strong>Response Time:</strong> Within 48 hours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.privacy-content h2 {
    color: #333;
    margin: 2rem 0 1rem;
    font-size: 1.8rem;
    border-bottom: 2px solid #667eea;
    padding-bottom: 0.5rem;
}

.privacy-content h3 {
    color: #667eea;
    margin: 1.5rem 0 0.5rem;
    font-size: 1.3rem;
}

.privacy-content ul {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.privacy-content li {
    margin-bottom: 0.5rem;
    color: #555;
    line-height: 1.6;
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
