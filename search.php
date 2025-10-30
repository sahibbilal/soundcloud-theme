<?php
/**
 * The template for displaying search results pages
 *
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <div class="page-header">
                <h1>
                    <?php
                    printf(
                        esc_html__('Search Results for: %s', 'sound-cloud-theme'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
                <p>Found <?php echo $wp_query->found_posts; ?> result(s)</p>
            </div>
            
            <div class="search-results">
                <?php if (have_posts()) : ?>
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                        
                                        <div class="entry-meta">
                                            <span class="posted-on">
                                                <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                    <?php echo get_the_date(); ?>
                                                </time>
                                            </span>
                                            <span class="byline">
                                                by <span class="author vcard">
                                                    <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                        <?php echo get_the_author(); ?>
                                                    </a>
                                                </span>
                                            </span>
                                        </div>
                                    </header>
                                    
                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            Read More <span class="arrow">→</span>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('← Previous', 'sound-cloud-theme'),
                        'next_text' => __('Next →', 'sound-cloud-theme'),
                    ));
                    ?>
                    
                <?php else : ?>
                    <div class="no-results">
                        <h2>Nothing Found</h2>
                        <p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
                        
                        <div class="search-suggestions">
                            <h3>Try these suggestions:</h3>
                            <ul>
                                <li>Check your spelling</li>
                                <li>Try different keywords</li>
                                <li>Use more general terms</li>
                                <li>Try fewer keywords</li>
                            </ul>
                        </div>
                        
                        <div class="search-form-container">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
.search-results {
    margin-top: 2rem;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.post-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.post-card:hover {
    transform: translateY(-5px);
}

.post-thumbnail {
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-content {
    padding: 1.5rem;
}

.entry-title {
    margin-bottom: 0.5rem;
    font-size: 1.3rem;
}

.entry-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.entry-title a:hover {
    color: #667eea;
}

.entry-meta {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.entry-meta span {
    margin-right: 1rem;
}

.entry-summary {
    color: #555;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.read-more {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.read-more:hover {
    color: #764ba2;
}

.read-more .arrow {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.read-more:hover .arrow {
    transform: translateX(3px);
}

.no-results {
    text-align: center;
    padding: 3rem 0;
}

.no-results h2 {
    color: #333;
    margin-bottom: 1rem;
}

.no-results p {
    color: #666;
    margin-bottom: 2rem;
}

.search-suggestions {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    text-align: left;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.search-suggestions h3 {
    color: #333;
    margin-bottom: 1rem;
}

.search-suggestions ul {
    list-style: none;
    padding: 0;
}

.search-suggestions li {
    padding: 0.5rem 0;
    color: #555;
    border-bottom: 1px solid #e2e8f0;
}

.search-suggestions li:last-child {
    border-bottom: none;
}

.search-form-container {
    max-width: 400px;
    margin: 0 auto;
}

.search-form {
    display: flex;
    gap: 0.5rem;
}

.search-field {
    flex: 1;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
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

/* Pagination */
.page-numbers {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin: 3rem 0;
}

.page-numbers a,
.page-numbers span {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 5px;
    color: #667eea;
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-numbers a:hover,
.page-numbers .current {
    background: #667eea;
    color: white;
    border-color: #667eea;
}
</style>

<?php get_footer(); ?>
