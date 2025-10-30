<?php
/**
 * The template for displaying archive pages
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
                    if (is_category()) {
                        single_cat_title();
                    } elseif (is_tag()) {
                        single_tag_title();
                    } elseif (is_author()) {
                        echo 'Posts by ' . get_the_author();
                    } elseif (is_date()) {
                        if (is_year()) {
                            echo get_the_date('Y');
                        } elseif (is_month()) {
                            echo get_the_date('F Y');
                        } elseif (is_day()) {
                            echo get_the_date('F j, Y');
                        }
                    } else {
                        echo 'Archives';
                    }
                    ?>
                </h1>
                <p>
                    <?php
                    if (is_category()) {
                        echo category_description();
                    } elseif (is_tag()) {
                        echo tag_description();
                    } elseif (is_author()) {
                        echo 'All posts by ' . get_the_author();
                    } else {
                        echo 'Browse our archives';
                    }
                    ?>
                </p>
            </div>
            
            <div class="blog-content">
                <?php if (have_posts()) : ?>
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                        <div class="post-category">
                                            <?php
                                            $categories = get_the_category();
                                            if (!empty($categories)) {
                                                echo '<span class="category-tag">' . esc_html($categories[0]->name) . '</span>';
                                            }
                                            ?>
                                        </div>
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
                    <div class="no-posts">
                        <h2>No Posts Found</h2>
                        <p>There are no posts in this archive. Try browsing our other content.</p>
                        <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="cta-button">View All Posts</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
.blog-content {
    margin-top: 2rem;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.post-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    position: relative;
}

.post-card:hover {
    transform: translateY(-5px);
}

.post-thumbnail {
    position: relative;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-category {
    position: absolute;
    top: 1rem;
    left: 1rem;
}

.category-tag {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.post-content {
    padding: 1.5rem;
}

.entry-title {
    margin-bottom: 0.5rem;
    font-size: 1.4rem;
    line-height: 1.3;
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
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.entry-meta span {
    display: flex;
    align-items: center;
}

.entry-summary {
    color: #555;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.read-more {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
    display: inline-flex;
    align-items: center;
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

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin: 3rem 0;
}

.page-numbers {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
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

.no-posts {
    text-align: center;
    padding: 3rem 0;
}

.no-posts h2 {
    color: #333;
    margin-bottom: 1rem;
}

.no-posts p {
    color: #666;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
    
    .entry-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<?php get_footer(); ?>
