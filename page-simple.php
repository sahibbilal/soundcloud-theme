<?php
/**
 * Template Name: Simple Page
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <div class="page-header">
                <h1><?php the_title(); ?></h1>
            </div>
            
            <div class="content-area">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
.content-area {
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

.content-area h1,
.content-area h2,
.content-area h3,
.content-area h4,
.content-area h5,
.content-area h6 {
    color: #333;
    margin: 2rem 0 1rem;
}

.content-area p {
    margin-bottom: 1.5rem;
    color: #555;
}

.content-area ul,
.content-area ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.content-area li {
    margin-bottom: 0.5rem;
}

.content-area blockquote {
    border-left: 4px solid #667eea;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #666;
}

.content-area img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}
</style>

<?php get_footer(); ?>
