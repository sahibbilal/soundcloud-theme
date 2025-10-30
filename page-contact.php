<?php
/**
 * Template Name: Contact Us Page
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <?php
            $sc_contact_title = get_post_meta(get_the_ID(), '_sc_contact_title', true);
            $sc_contact_desc  = get_post_meta(get_the_ID(), '_sc_contact_desc', true);
            $sc_contact_email = get_post_meta(get_the_ID(), '_sc_contact_email', true);
            $sc_contact_phone = get_post_meta(get_the_ID(), '_sc_contact_phone', true);
            $sc_contact_address = get_post_meta(get_the_ID(), '_sc_contact_address', true);
            ?>
            <div class="page-header">
                <h1><?php echo esc_html($sc_contact_title ?: get_the_title()); ?></h1>
                <div><?php echo wpautop($sc_contact_desc ?: 'Get in touch with our support team'); ?></div>
            </div>
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
            
            <div class="contact-section">
                <div class="contact-grid">
                    <div class="contact-form-container">
                        <h2>Send us a Message</h2>
                        <form id="contact-form" class="contact-form" method="post">
                            <div class="form-group">
                                <label for="contact-name">Your Name *</label>
                                <input type="text" id="contact-name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-email">Email Address *</label>
                                <input type="email" id="contact-email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-subject">Subject *</label>
                                <select id="contact-subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="technical-support">Technical Support</option>
                                    <option value="download-issue">Download Issue</option>
                                    <option value="feature-request">Feature Request</option>
                                    <option value="copyright-issue">Copyright Issue</option>
                                    <option value="general-inquiry">General Inquiry</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-message">Message *</label>
                                <textarea id="contact-message" name="message" rows="5" required placeholder="Please describe your issue or question in detail..."></textarea>
                            </div>
                            
                            <button type="submit" class="submit-btn">Send Message</button>
                        </form>
                    </div>
                    
                    <div class="contact-info-container">
                        <h2>Get in Touch</h2>
                        <div class="contact-methods">
                            <div class="contact-method">
                                <div class="contact-icon">📧</div>
                                <div class="contact-details">
                                    <h3>Email Support</h3>
                                    <p><?php echo esc_html($sc_contact_email ?: 'support@soundcloud-downloader.com'); ?></p>
                                    <small>Response within 24 hours</small>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="contact-icon">💬</div>
                                <div class="contact-details">
                                    <h3>Live Chat</h3>
                                    <p>Available 24/7</p>
                                    <small>Click the chat icon in the bottom right</small>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="contact-icon">📋</div>
                                <div class="contact-details">
                                    <h3>FAQ</h3>
                                    <p>Check our frequently asked questions</p>
                                    <small><a href="/faq/">Visit FAQ Page</a></small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="response-times">
                            <h3>Response Times</h3>
                            <ul>
                                <li><strong>Technical Issues:</strong> Within 4 hours</li>
                                <li><strong>General Inquiries:</strong> Within 24 hours</li>
                                <li><strong>Copyright Issues:</strong> Within 12 hours</li>
                                <li><strong>Feature Requests:</strong> Within 48 hours</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php
                $sc_contact_faq_title = get_post_meta(get_the_ID(), '_sc_contact_faq_title', true);
                $sc_contact_faq_items = get_post_meta(get_the_ID(), '_sc_contact_faq_items', true);
                if (!is_array($sc_contact_faq_items)) { $sc_contact_faq_items = array(); }
                ?>
                <?php if (!empty($sc_contact_faq_items)) : ?>
                <div class="faq-preview">
                    <h2><?php echo esc_html($sc_contact_faq_title ?: 'Frequently Asked Questions'); ?></h2>
                    <div class="faq-grid">
                        <?php foreach ($sc_contact_faq_items as $row) :
                            $q = isset($row['q']) ? $row['q'] : '';
                            $a = isset($row['a']) ? $row['a'] : '';
                        ?>
                        <div class="faq-item">
                            <h3><?php echo esc_html($q ?: 'Question'); ?></h3>
                            <p><?php echo esc_html($a ?: 'Answer'); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
.contact-section {
    margin-top: 2rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

.contact-form-container {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.contact-form h2 {
    color: #333;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}

.contact-form .form-group {
    margin-bottom: 1.5rem;
}

.contact-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.contact-form input,
.contact-form select,
.contact-form textarea {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.contact-form input:focus,
.contact-form select:focus,
.contact-form textarea:focus {
    outline: none;
    border-color: #667eea;
}

.submit-btn {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.contact-info-container {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 10px;
}

.contact-methods {
    margin-bottom: 2rem;
}

.contact-method {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
}

.contact-icon {
    font-size: 2rem;
    margin-right: 1rem;
}

.contact-details h3 {
    color: #333;
    margin-bottom: 0.25rem;
    font-size: 1.1rem;
}

.contact-details p {
    color: #667eea;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.contact-details small {
    color: #666;
    font-size: 0.85rem;
}

.contact-details a {
    color: #667eea;
    text-decoration: none;
}

.response-times {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
}

.response-times h3 {
    color: #333;
    margin-bottom: 1rem;
}

.response-times ul {
    list-style: none;
    padding: 0;
}

.response-times li {
    margin-bottom: 0.5rem;
    color: #555;
}

.faq-preview {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.faq-item {
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 8px;
}

.faq-item h3 {
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.faq-item p {
    color: #666;
    font-size: 0.95rem;
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            const button = contactForm.querySelector('.submit-btn');
            
            // Show loading state
            button.textContent = 'Sending...';
            button.disabled = true;
            
            // Simulate form submission
            setTimeout(function() {
                alert('Thank you for your message! We will get back to you within 24 hours.');
                contactForm.reset();
                button.textContent = 'Send Message';
                button.disabled = false;
            }, 2000);
        });
    }
});
</script>

<?php get_footer(); ?>
