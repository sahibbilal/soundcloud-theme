<?php
/**
 * Template for displaying search forms
 *
 * @package Sound_Cloud_Theme
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-input-group">
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'sound-cloud-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit">
            <span class="search-icon">🔍</span>
            <span class="search-text">Search</span>
        </button>
    </div>
</form>
