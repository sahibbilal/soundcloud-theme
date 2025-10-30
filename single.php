<?php
/**
 * The template for displaying all single posts
 *
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <header class="entry-header">
                        <div class="post-meta">
                            <div class="post-categories">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    foreach ($categories as $category) {
                                        echo '<span class="category-tag">' . esc_html($category->name) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            
                            <div class="entry-meta">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                                    </div>
                                    <div class="author-details">
                                        <span class="byline">
                                            by <span class="author vcard">
                                                <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php echo get_the_author(); ?>
                                                </a>
                                            </span>
                                        </span>
                                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>
                                </div>
                                
                                <div class="post-stats">
                                    <span class="reading-time">
                                        <i class="icon-clock">⏱️</i>
                                        <?php 
                                        $content = get_the_content();
                                        $word_count = str_word_count(strip_tags($content));
                                        $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
                                        echo $reading_time . ' min read';
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-featured-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                    </header>
                    
                    <div class="entry-content">
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'sound-cloud-theme'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                    
                    <footer class="entry-footer">
                        <div class="post-tags">
                            <?php
                            $tags = get_the_tags();
                            if ($tags) {
                                echo '<div class="tags-label">Tags:</div>';
                                foreach ($tags as $tag) {
                                    echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-link">' . $tag->name . '</a>';
                                }
                            }
                            ?>
                        </div>
                        
                        <div class="post-navigation">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if ($prev_post) : ?>
                                <div class="nav-previous">
                                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                        <span class="nav-direction">← Previous</span>
                                        <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($next_post) : ?>
                                <div class="nav-next">
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                        <span class="nav-direction">Next →</span>
                                        <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </footer>
                </article>
                
                <?php
                // Related posts
                $current_id = get_the_ID();
                $related_posts = get_posts(array(
                    'category__in' => wp_get_post_categories($current_id),
                    'numberposts' => 3,
                    'post__not_in' => array($current_id)
                ));
                
                if ($related_posts) : ?>
                    <section class="related-posts">
                        <h2>Related Posts</h2>
                        <div class="related-posts-grid">
                            <?php foreach ($related_posts as $related_post) : ?>
                                <div class="related-post">
                                    <a href="<?php echo get_permalink($related_post->ID); ?>">
                                        <?php echo get_the_post_thumbnail($related_post->ID, 'medium'); ?>
                                        <h3><?php echo get_the_title($related_post->ID); ?></h3>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
                
            <?php endwhile; ?>
        </div>
    </div>
</main>

<style>
.single-post {
    margin: 0 auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.entry-header {
    padding: 2rem 2rem 0;
}

.post-meta {
    margin-bottom: 2rem;
}

.post-categories {
    margin-bottom: 1rem;
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
    display: inline-block;
    margin-right: 0.5rem;
}

.entry-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.entry-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar img {
    border-radius: 50%;
}

.author-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.byline {
    color: #667eea;
    font-weight: 600;
}

.byline a {
    color: #667eea;
    text-decoration: none;
}

.entry-date {
    color: #666;
    font-size: 0.9rem;
}

.post-stats {
    color: #666;
    font-size: 0.9rem;
}

.reading-time {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.post-featured-image {
    margin: 2rem 0;
    border-radius: 10px;
    overflow: hidden;
}

.post-featured-image img {
    width: 100%;
    height: auto;
}

.entry-content {
    padding: 0 2rem 2rem;
    line-height: 1.8;
    color: #555;
}

.entry-content h1,
.entry-content h2,
.entry-content h3,
.entry-content h4,
.entry-content h5,
.entry-content h6 {
    color: #333;
    margin: 2rem 0 1rem;
}

.entry-content p {
    margin-bottom: 1.5rem;
}

.entry-content ul,
.entry-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.entry-content li {
    margin-bottom: 0.5rem;
}

.entry-content blockquote {
    border-left: 4px solid #667eea;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #666;
}

.entry-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.page-links {
    margin: 2rem 0;
    text-align: center;
}

.page-links a {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    background: #f8fafc;
    color: #667eea;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.page-links a:hover {
    background: #667eea;
    color: white;
}

.entry-footer {
    padding: 2rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.post-tags {
    margin-bottom: 2rem;
}

.tags-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.tag-link {
    display: inline-block;
    background: white;
    color: #667eea;
    padding: 0.5rem 1rem;
    margin: 0.25rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.tag-link:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.post-navigation {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.nav-previous,
.nav-next {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.nav-previous:hover,
.nav-next:hover {
    transform: translateY(-2px);
}

.nav-link {
    display: block;
    padding: 1rem;
    text-decoration: none;
    color: #333;
}

.nav-direction {
    display: block;
    font-size: 0.9rem;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.nav-title {
    display: block;
    font-weight: 600;
    line-height: 1.3;
}

.related-posts {
    margin-top: 3rem;
    padding: 2rem;
    background: #f8fafc;
    border-radius: 10px;
}

.related-posts h2 {
    color: #333;
    margin-bottom: 1.5rem;
    text-align: center;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.related-post {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.related-post:hover {
    transform: translateY(-3px);
}

.related-post a {
    display: block;
    text-decoration: none;
    color: #333;
}

.related-post img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.related-post h3 {
    padding: 1rem;
    font-size: 1rem;
    line-height: 1.3;
    margin: 0;
}

@media (max-width: 768px) {
    .entry-header,
    .entry-content,
    .entry-footer {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .entry-title {
        font-size: 2rem;
    }
    
    .entry-meta {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .post-navigation {
        grid-template-columns: 1fr;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
