<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="error-404">
        <div class="container">
            <div class="error-content">
                <h1>404</h1>
                <h2>Oops! Page Not Found</h2>
                <p>The page you're looking for doesn't exist or has been moved.</p>
                
                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="cta-button">Go Home</a>
                    <a href="<?php echo esc_url(home_url('/downloader/')); ?>" class="secondary-button">Try Downloader</a>
                </div>
                
                <div class="helpful-links">
                    <h3>Maybe you were looking for:</h3>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home Page</a></li>
                        <li><a href="<?php echo esc_url(home_url('/downloader/')); ?>">SoundCloud Downloader</a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Us</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Support</a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="search-section">
                    <h3>Search our site:</h3>
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-group">
                            <input type="search" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.error-404 {
    min-height: 70vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.error-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.error-content h1 {
    font-size: 8rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 1rem;
    line-height: 1;
    text-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
}

.error-content h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1rem;
}

.error-content p {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 2rem;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.cta-button {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.secondary-button {
    display: inline-block;
    background: transparent;
    color: #667eea;
    padding: 1rem 2rem;
    text-decoration: none;
    border: 2px solid #667eea;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.secondary-button:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.helpful-links {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.helpful-links h3 {
    color: #333;
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.helpful-links ul {
    list-style: none;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.5rem;
}

.helpful-links li {
    margin-bottom: 0.5rem;
}

.helpful-links a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: block;
    padding: 0.5rem;
    border-radius: 5px;
}

.helpful-links a:hover {
    color: #764ba2;
    background: #f8fafc;
}

.search-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.search-section h3 {
    color: #333;
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.search-input-group {
    display: flex;
    max-width: 400px;
    margin: 0 auto;
    gap: 0.5rem;
}

.search-field {
    flex: 1;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-field:focus {
    outline: none;
    border-color: #667eea;
}

.search-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

@media (max-width: 768px) {
    .error-content h1 {
        font-size: 6rem;
    }
    
    .error-content h2 {
        font-size: 1.5rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .search-input-group {
        flex-direction: column;
    }
    
    .helpful-links ul {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
