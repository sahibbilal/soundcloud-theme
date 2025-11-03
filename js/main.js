/**
 * Sound Cloud Theme JavaScript
 * 
 * @package Sound_Cloud_Theme
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        
        // Mobile menu toggle
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('menu-open');
        });

        // Search popup toggle
        $('.search-toggle').on('click', function() {
            $('#search-popup').addClass('active');
            $('body').addClass('popup-open');
            setTimeout(function() {
                $('.search-popup .search-field').focus();
            }, 300);
        });

        // Close search popup
        $('.search-close, #search-popup').on('click', function(e) {
            if (e.target === this) {
                $('#search-popup').removeClass('active');
                $('body').removeClass('popup-open');
            }
        });

        // Search tag functionality
        $('.search-tag').on('click', function() {
            var tagText = $(this).text();
            $('.search-popup .search-field').val(tagText);
            $('.search-popup .search-field').focus();
        });

        // Smooth scrolling for anchor links
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                    return false;
                }
            }
        });

        // Download form handling
        $('#soundcloud-downloader, #soundcloud-downloader-main').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $button = $form.find('.download-btn, .download-btn');
            var url = $form.find('input[type="url"]').val();
            var quality = $form.find('select[name="quality"]').val() || '320';
            
            if (!url) {
                showNotification('Please enter a valid SoundCloud URL', 'error');
                return;
            }
            
            if (!url.includes('soundcloud.com')) {
                showNotification('Please enter a valid SoundCloud URL', 'error');
                return;
            }
            
            // Show loading state
            var originalText = $button.text();
            $button.text('Processing...').prop('disabled', true);
            
            // Simulate download process
            setTimeout(function() {
                showNotification('Download feature will be implemented with backend integration', 'info');
                $button.text(originalText).prop('disabled', false);
            }, 2000);
        });

        // Contact form handling
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $button = $form.find('.submit-btn');
            var formData = $form.serialize();
            
            // Show loading state
            var originalText = $button.text();
            $button.text('Sending...').prop('disabled', true);
            
            // Simulate form submission
            setTimeout(function() {
                showNotification('Thank you for your message! We will get back to you within 24 hours.', 'success');
                $form[0].reset();
                $button.text(originalText).prop('disabled', false);
            }, 2000);
        });

        // Add loading animation to buttons
        $('.cta-button, .download-btn, .submit-btn').on('click', function() {
            var $this = $(this);
            if (!$this.prop('disabled')) {
                $this.addClass('loading');
            }
        });

        // Remove loading animation after a delay
        setTimeout(function() {
            $('.loading').removeClass('loading');
        }, 3000);

        // Add scroll effect to header
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        });

        // Animate elements on scroll
        function animateOnScroll() {
            $('.feature-card, .value-item, .faq-item').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('animate-in');
                }
            });
        }
        
        $(window).on('scroll', animateOnScroll);
        animateOnScroll(); // Run once on load

        // FAQ functionality
        $('.faq-question').on('click', function() {
            var $faqItem = $(this).parent();
            var $answer = $faqItem.find('.faq-answer');
            
            // Close other FAQ items
            $('.faq-item').not($faqItem).removeClass('active');
            $('.faq-answer').not($answer).css('max-height', '0');
            
            // Toggle current FAQ item
            $faqItem.toggleClass('active');
            if ($faqItem.hasClass('active')) {
                $answer.css('max-height', $answer[0].scrollHeight + 'px');
            } else {
                $answer.css('max-height', '0');
            }
        });

        // Add click tracking for analytics
        $('a[href*="downloader"]').on('click', function() {
            // Track downloader page visits
            console.log('Downloader page accessed');
        });

        // Keyboard navigation support
        $(document).on('keydown', function(e) {
            // ESC key closes mobile menu
            if (e.keyCode === 27) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation').removeClass('menu-open');
            }
        });

    });

    // Notification system
    function showNotification(message, type) {
        var notification = $('<div class="notification notification-' + type + '">' + message + '</div>');
        $('body').append(notification);
        
        setTimeout(function() {
            notification.addClass('show');
        }, 100);
        
        setTimeout(function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 4000);
    }

    // Utility functions
    window.soundCloudTheme = {
        showNotification: showNotification,
        version: '1.0.0'
    };

})(jQuery);

// Add CSS for notifications
var notificationCSS = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }
    
    .notification-error {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    }
    
    .notification-info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    }
    
    .loading {
        position: relative;
        pointer-events: none;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .site-header.scrolled {
        background: rgba(102, 126, 234, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;

// Inject CSS
var style = document.createElement('style');
style.textContent = notificationCSS;
document.head.appendChild(style);
