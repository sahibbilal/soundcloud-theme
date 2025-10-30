<?php
/**
 * Meta Boxes registry for theme templates
 * - This file can be extended to add meta boxes per template.
 */

// ------------------------------
// Homepage (page-homepage.php)
// ------------------------------

if (!function_exists('sc_theme_add_homepage_meta_box')) {
    function sc_theme_add_homepage_meta_box($post_type, $post) {
        if ($post_type !== 'page' || empty($post)) { return; }
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-homepage.php') { return; }
        add_meta_box(
            'sc_homepage_hero',
            __('Homepage Hero', 'sound-cloud-theme'),
            'sc_theme_render_homepage_meta_box',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'sc_theme_add_homepage_meta_box', 10, 2);

if (!function_exists('sc_theme_render_homepage_meta_box')) {
    function sc_theme_render_homepage_meta_box($post) {
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-homepage.php') {
            echo '<p>' . esc_html__('This meta box applies to pages using the Homepage Template.', 'sound-cloud-theme') . '</p>';
            return;
        }

        wp_nonce_field('sc_homepage_meta_nonce', 'sc_homepage_meta_nonce_field');

        $hero_title = get_post_meta($post->ID, '_sc_home_hero_title', true);
        $hero_desc  = get_post_meta($post->ID, '_sc_home_hero_desc', true);

        echo '<table class="form-table">';
        echo '<tr><th><label for="sc_home_hero_title">' . esc_html__('Hero Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_home_hero_title" name="sc_home_hero_title" value="' . esc_attr($hero_title) . '" style="width:100%;" /></td></tr>';

        echo '<tr><th><label>' . esc_html__('Hero Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $hero_desc,
            'sc_home_hero_desc',
            array(
                'textarea_name' => 'sc_home_hero_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 5,
            )
        );
        echo '</td></tr>';
        echo '</table>';
    }
}

if (!function_exists('sc_theme_save_homepage_meta_box')) {
    function sc_theme_save_homepage_meta_box($post_id) {
        if (!isset($_POST['sc_homepage_meta_nonce_field']) || !wp_verify_nonce($_POST['sc_homepage_meta_nonce_field'], 'sc_homepage_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $tpl = get_page_template_slug($post_id);
        if ($tpl !== 'page-homepage.php') {
            return;
        }

        if (isset($_POST['sc_home_hero_title'])) {
            update_post_meta($post_id, '_sc_home_hero_title', sanitize_text_field($_POST['sc_home_hero_title']));
        }
        if (isset($_POST['sc_home_hero_desc'])) {
            update_post_meta($post_id, '_sc_home_hero_desc', wp_kses_post($_POST['sc_home_hero_desc']));
        }
    }
}
add_action('save_post_page', 'sc_theme_save_homepage_meta_box');

// -------------------------------------------------
// Pattern to add more template-specific meta boxes:
// - Copy the three function blocks above (add, render, save),
// - Check get_page_template_slug($post_id) === 'your-template.php'.
// -------------------------------------------------

// ------------------------------
// Homepage Features (page-homepage.php 27-72)
// ------------------------------

if (!function_exists('sc_theme_add_homepage_features_meta_box')) {
    function sc_theme_add_homepage_features_meta_box($post_type, $post) {
        if ($post_type !== 'page' || empty($post)) { return; }
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-homepage.php') { return; }
        add_meta_box(
            'sc_homepage_features',
            __('Homepage Features', 'sound-cloud-theme'),
            'sc_theme_render_homepage_features_meta_box',
            'page',
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'sc_theme_add_homepage_features_meta_box', 10, 2);

if (!function_exists('sc_theme_render_homepage_features_meta_box')) {
    function sc_theme_render_homepage_features_meta_box($post) {
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-homepage.php') {
            echo '<p>' . esc_html__('This meta box applies to pages using the Homepage Template.', 'sound-cloud-theme') . '</p>';
            return;
        }

        wp_nonce_field('sc_homepage_features_meta_nonce', 'sc_homepage_features_meta_nonce_field');

        $feat_title = get_post_meta($post->ID, '_sc_home_feat_title', true);
        $feat_desc  = get_post_meta($post->ID, '_sc_home_feat_desc', true);
        $features   = get_post_meta($post->ID, '_sc_home_features', true);
        if (!is_array($features)) {
            $features = array();
        }

        echo '<table class="form-table">';
        echo '<tr><th><label for="sc_home_feat_title">' . esc_html__('Section Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_home_feat_title" name="sc_home_feat_title" value="' . esc_attr($feat_title) . '" style="width:100%;" /></td></tr>';

        echo '<tr><th><label>' . esc_html__('Section Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $feat_desc,
            'sc_home_feat_desc',
            array(
                'textarea_name' => 'sc_home_feat_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';
        echo '</table>';

        // Repeater UI
        echo '<h4>' . esc_html__('Feature Items', 'sound-cloud-theme') . '</h4>';
        echo '<div id="sc-features-wrapper">';
        $index = 0;
        foreach ($features as $item) {
            $icon = isset($item['icon']) ? $item['icon'] : '';
            $title = isset($item['title']) ? $item['title'] : '';
            $desc = isset($item['desc']) ? $item['desc'] : '';
            echo '<div class="sc-feature-row" style="border:1px solid #ddd;padding:10px;margin-bottom:10px;">';
            echo '<p><label>' . esc_html__('Icon (emoji or HTML)', 'sound-cloud-theme') . '</label><br/><input type="text" name="sc_home_features['.$index.'][icon]" value="' . esc_attr($icon) . '" style="width:100%;" /></p>';
            echo '<p><label>' . esc_html__('Title', 'sound-cloud-theme') . '</label><br/><input type="text" name="sc_home_features['.$index.'][title]" value="' . esc_attr($title) . '" style="width:100%;" /></p>';
            echo '<p><label>' . esc_html__('Description', 'sound-cloud-theme') . '</label><br/><textarea name="sc_home_features['.$index.'][desc]" rows="3" style="width:100%;">' . esc_textarea($desc) . '</textarea></p>';
            echo '<button type="button" class="button sc-remove-feature">' . esc_html__('Remove', 'sound-cloud-theme') . '</button>';
            echo '</div>';
            $index++;
        }
        echo '</div>';
        echo '<p><button type="button" class="button button-primary" id="sc-add-feature">' . esc_html__('Add Feature', 'sound-cloud-theme') . '</button></p>';

        // Simple JS to clone rows
        ?>
        <script>
        (function(){
          const wrap = document.getElementById('sc-features-wrapper');
          const addBtn = document.getElementById('sc-add-feature');
          if(!wrap || !addBtn) return;
          addBtn.addEventListener('click', function(){
            const idx = wrap.querySelectorAll('.sc-feature-row').length;
            const div = document.createElement('div');
            div.className = 'sc-feature-row';
            div.style.cssText = 'border:1px solid #ddd;padding:10px;margin-bottom:10px;';
            div.innerHTML = `
              <p><label><?php echo esc_js(__('Icon (emoji or HTML)', 'sound-cloud-theme')); ?></label><br/>
              <input type="text" name="sc_home_features[${idx}][icon]" style="width:100%;" /></p>
              <p><label><?php echo esc_js(__('Title', 'sound-cloud-theme')); ?></label><br/>
              <input type="text" name="sc_home_features[${idx}][title]" style="width:100%;" /></p>
              <p><label><?php echo esc_js(__('Description', 'sound-cloud-theme')); ?></label><br/>
              <textarea name="sc_home_features[${idx}][desc]" rows="3" style="width:100%;"></textarea></p>
              <button type="button" class="button sc-remove-feature"><?php echo esc_js(__('Remove', 'sound-cloud-theme')); ?></button>
            `;
            wrap.appendChild(div);
          });
          wrap.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('sc-remove-feature')){
              e.target.closest('.sc-feature-row').remove();
            }
          });
        })();
        </script>
        <?php
    }
}

if (!function_exists('sc_theme_save_homepage_features_meta_box')) {
    function sc_theme_save_homepage_features_meta_box($post_id) {
        if (!isset($_POST['sc_homepage_features_meta_nonce_field']) || !wp_verify_nonce($_POST['sc_homepage_features_meta_nonce_field'], 'sc_homepage_features_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $tpl = get_page_template_slug($post_id);
        if ($tpl !== 'page-homepage.php') {
            return;
        }

        // Title/Desc
        if (isset($_POST['sc_home_feat_title'])) {
            update_post_meta($post_id, '_sc_home_feat_title', sanitize_text_field($_POST['sc_home_feat_title']));
        }
        if (isset($_POST['sc_home_feat_desc'])) {
            update_post_meta($post_id, '_sc_home_feat_desc', wp_kses_post($_POST['sc_home_feat_desc']));
        }

        // Repeater
        if (isset($_POST['sc_home_features']) && is_array($_POST['sc_home_features'])) {
            $clean = array();
            foreach ($_POST['sc_home_features'] as $row) {
                if (empty($row['title']) && empty($row['desc']) && empty($row['icon'])) continue;
                $clean[] = array(
                    'icon' => isset($row['icon']) ? wp_kses_post($row['icon']) : '',
                    'title' => isset($row['title']) ? sanitize_text_field($row['title']) : '',
                    'desc' => isset($row['desc']) ? sanitize_textarea_field($row['desc']) : '',
                );
            }
            update_post_meta($post_id, '_sc_home_features', $clean);
        } else {
            delete_post_meta($post_id, '_sc_home_features');
        }
    }
}
add_action('save_post_page', 'sc_theme_save_homepage_features_meta_box');

// ------------------------------
// Homepage FAQ (page-homepage.php FAQ section)
// ------------------------------

if (!function_exists('sc_theme_add_homepage_faq_meta_box')) {
    function sc_theme_add_homepage_faq_meta_box($post_type, $post) {
        if ($post_type !== 'page' || empty($post)) { return; }
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-homepage.php') { return; }
        add_meta_box(
            'sc_homepage_faq',
            __('Homepage FAQ', 'sound-cloud-theme'),
            'sc_theme_render_homepage_faq_meta_box',
            'page',
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'sc_theme_add_homepage_faq_meta_box', 10, 2);

if (!function_exists('sc_theme_render_homepage_faq_meta_box')) {
    function sc_theme_render_homepage_faq_meta_box($post) {
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-homepage.php') {
            echo '<p>' . esc_html__('This meta box applies to pages using the Homepage Template.', 'sound-cloud-theme') . '</p>';
            return;
        }

        wp_nonce_field('sc_homepage_faq_meta_nonce', 'sc_homepage_faq_meta_nonce_field');

        $faq_title = get_post_meta($post->ID, '_sc_home_faq_title', true);
        $faq_desc  = get_post_meta($post->ID, '_sc_home_faq_desc', true);
        $faqs      = get_post_meta($post->ID, '_sc_home_faq_items', true);
        if (!is_array($faqs)) { $faqs = array(); }

        echo '<table class="form-table">';
        echo '<tr><th><label for="sc_home_faq_title">' . esc_html__('FAQ Section Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_home_faq_title" name="sc_home_faq_title" value="' . esc_attr($faq_title) . '" style="width:100%;" /></td></tr>';

        echo '<tr><th><label>' . esc_html__('FAQ Section Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $faq_desc,
            'sc_home_faq_desc',
            array(
                'textarea_name' => 'sc_home_faq_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';
        echo '</table>';

        echo '<h4>' . esc_html__('FAQ Items', 'sound-cloud-theme') . '</h4>';
        echo '<div id="sc-faqs-wrapper">';
        $i = 0;
        foreach ($faqs as $row) {
            $q = isset($row['q']) ? $row['q'] : '';
            $a = isset($row['a']) ? $row['a'] : '';
            echo '<div class="sc-faq-row" style="border:1px solid #ddd;padding:10px;margin-bottom:10px;">';
            echo '<p><label>' . esc_html__('Question', 'sound-cloud-theme') . '</label><br/>';
            echo '<input type="text" name="sc_home_faq_items['.$i.'][q]" value="' . esc_attr($q) . '" style="width:100%;" /></p>';
            echo '<p><label>' . esc_html__('Answer', 'sound-cloud-theme') . '</label><br/>';
            echo '<textarea name="sc_home_faq_items['.$i.'][a]" rows="3" style="width:100%;">' . esc_textarea($a) . '</textarea></p>';
            echo '<button type="button" class="button sc-remove-faq">' . esc_html__('Remove', 'sound-cloud-theme') . '</button>';
            echo '</div>';
            $i++;
        }
        echo '</div>';
        echo '<p><button type="button" class="button button-primary" id="sc-add-faq">' . esc_html__('Add FAQ', 'sound-cloud-theme') . '</button></p>';

        ?>
        <script>
        (function(){
          const wrap = document.getElementById('sc-faqs-wrapper');
          const addBtn = document.getElementById('sc-add-faq');
          if(!wrap || !addBtn) return;
          addBtn.addEventListener('click', function(){
            const idx = wrap.querySelectorAll('.sc-faq-row').length;
            const div = document.createElement('div');
            div.className = 'sc-faq-row';
            div.style.cssText = 'border:1px solid #ddd;padding:10px;margin-bottom:10px;';
            div.innerHTML = `
              <p><label><?php echo esc_js(__('Question', 'sound-cloud-theme')); ?></label><br/>
              <input type=\"text\" name=\"sc_home_faq_items[${idx}][q]\" style=\"width:100%;\" /></p>
              <p><label><?php echo esc_js(__('Answer', 'sound-cloud-theme')); ?></label><br/>
              <textarea name=\"sc_home_faq_items[${idx}][a]\" rows=\"3\" style=\"width:100%;\"></textarea></p>
              <button type=\"button\" class=\"button sc-remove-faq\"><?php echo esc_js(__('Remove', 'sound-cloud-theme')); ?></button>
            `;
            wrap.appendChild(div);
          });
          wrap.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('sc-remove-faq')){
              e.target.closest('.sc-faq-row').remove();
            }
          });
        })();
        </script>
        <?php
    }
}

if (!function_exists('sc_theme_save_homepage_faq_meta_box')) {
    function sc_theme_save_homepage_faq_meta_box($post_id) {
        if (!isset($_POST['sc_homepage_faq_meta_nonce_field']) || !wp_verify_nonce($_POST['sc_homepage_faq_meta_nonce_field'], 'sc_homepage_faq_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $tpl = get_page_template_slug($post_id);
        if ($tpl !== 'page-homepage.php') {
            return;
        }

        if (isset($_POST['sc_home_faq_title'])) {
            update_post_meta($post_id, '_sc_home_faq_title', sanitize_text_field($_POST['sc_home_faq_title']));
        }
        if (isset($_POST['sc_home_faq_desc'])) {
            update_post_meta($post_id, '_sc_home_faq_desc', wp_kses_post($_POST['sc_home_faq_desc']));
        }

        if (isset($_POST['sc_home_faq_items']) && is_array($_POST['sc_home_faq_items'])) {
            $clean = array();
            foreach ($_POST['sc_home_faq_items'] as $row) {
                if (empty($row['q']) && empty($row['a'])) continue;
                $clean[] = array(
                    'q' => isset($row['q']) ? sanitize_text_field($row['q']) : '',
                    'a' => isset($row['a']) ? sanitize_textarea_field($row['a']) : '',
                );
            }
            update_post_meta($post_id, '_sc_home_faq_items', $clean);
        } else {
            delete_post_meta($post_id, '_sc_home_faq_items');
        }
    }
}
add_action('save_post_page', 'sc_theme_save_homepage_faq_meta_box');

// ------------------------------
// FAQ Page (page-faq.php)
// ------------------------------

if (!function_exists('sc_theme_add_faq_page_meta_box')) {
    function sc_theme_add_faq_page_meta_box($post_type, $post) {
        if ($post_type !== 'page' || empty($post)) { return; }
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-faq.php') { return; }
        add_meta_box(
            'sc_faq_page',
            __('FAQ Page Content', 'sound-cloud-theme'),
            'sc_theme_render_faq_page_meta_box',
            'page',
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'sc_theme_add_faq_page_meta_box', 10, 2);

if (!function_exists('sc_theme_render_faq_page_meta_box')) {
    function sc_theme_render_faq_page_meta_box($post) {
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-faq.php') {
            echo '<p>' . esc_html__('This meta box applies to pages using the FAQ Template.', 'sound-cloud-theme') . '</p>';
            return;
        }

        wp_nonce_field('sc_faq_page_meta_nonce', 'sc_faq_page_meta_nonce_field');

        $title = get_post_meta($post->ID, '_sc_faq_title', true);
        $desc  = get_post_meta($post->ID, '_sc_faq_desc', true);
        $faqs  = get_post_meta($post->ID, '_sc_faq_items', true);
        $support_title = get_post_meta($post->ID, '_sc_faq_support_title', true);
        $support_desc  = get_post_meta($post->ID, '_sc_faq_support_desc', true);
        $cat_general   = get_post_meta($post->ID, '_sc_faq_cat_general', true);
        $cat_technical = get_post_meta($post->ID, '_sc_faq_cat_technical', true);
        $cat_legal     = get_post_meta($post->ID, '_sc_faq_cat_legal', true);
        $cat_privacy   = get_post_meta($post->ID, '_sc_faq_cat_privacy', true);
        if (!is_array($faqs)) { $faqs = array(); }

        echo '<table class="form-table">';
        echo '<tr><th><label for="sc_faq_title">' . esc_html__('Page Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_faq_title" name="sc_faq_title" value="' . esc_attr($title) . '" style="width:100%;" /></td></tr>';

        echo '<tr><th><label>' . esc_html__('Intro Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $desc,
            'sc_faq_desc',
            array(
                'textarea_name' => 'sc_faq_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';

        // Category labels
        echo '<tr><th><label for="sc_faq_cat_general">' . esc_html__('General Tab Label', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_faq_cat_general" name="sc_faq_cat_general" value="' . esc_attr($cat_general) . '" style="width:100%;" placeholder="General" /></td></tr>';

        echo '<tr><th><label for="sc_faq_cat_technical">' . esc_html__('Technical Tab Label', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_faq_cat_technical" name="sc_faq_cat_technical" value="' . esc_attr($cat_technical) . '" style="width:100%;" placeholder="Technical" /></td></tr>';

        echo '<tr><th><label for="sc_faq_cat_legal">' . esc_html__('Legal Tab Label', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_faq_cat_legal" name="sc_faq_cat_legal" value="' . esc_attr($cat_legal) . '" style="width:100%;" placeholder="Legal" /></td></tr>';

        echo '<tr><th><label for="sc_faq_cat_privacy">' . esc_html__('Privacy Tab Label', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_faq_cat_privacy" name="sc_faq_cat_privacy" value="' . esc_attr($cat_privacy) . '" style="width:100%;" placeholder="Privacy" /></td></tr>';

        echo '<tr><th><label for="sc_faq_support_title">' . esc_html__('Support Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_faq_support_title" name="sc_faq_support_title" value="' . esc_attr($support_title) . '" style="width:100%;" /></td></tr>';

        echo '<tr><th><label>' . esc_html__('Support Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $support_desc,
            'sc_faq_support_desc',
            array(
                'textarea_name' => 'sc_faq_support_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 3,
            )
        );
        echo '</td></tr>';
        echo '</table>';

        echo '<h4>' . esc_html__('FAQ Items', 'sound-cloud-theme') . '</h4>';
        echo '<div id="sc-faqpage-wrapper">';
        $i = 0;
        foreach ($faqs as $row) {
            $q = isset($row['q']) ? $row['q'] : '';
            $a = isset($row['a']) ? $row['a'] : '';
            echo '<div class="sc-faqpage-row" style="border:1px solid #ddd;padding:10px;margin-bottom:10px;">';
            echo '<p><label>' . esc_html__('Question', 'sound-cloud-theme') . '</label><br/>';
            echo '<input type="text" name="sc_faq_items['.$i.'][q]" value="' . esc_attr($q) . '" style="width:100%;" /></p>';
            echo '<p><label>' . esc_html__('Answer', 'sound-cloud-theme') . '</label><br/>';
            echo '<textarea name="sc_faq_items['.$i.'][a]" rows="3" style="width:100%;">' . esc_textarea($a) . '</textarea></p>';
            echo '<button type="button" class="button sc-remove-faqpage">' . esc_html__('Remove', 'sound-cloud-theme') . '</button>';
            echo '</div>';
            $i++;
        }
        echo '</div>';
        echo '<p><button type="button" class="button button-primary" id="sc-add-faqpage">' . esc_html__('Add FAQ', 'sound-cloud-theme') . '</button></p>';

        ?>
        <script>
        (function(){
          const wrap = document.getElementById('sc-faqpage-wrapper');
          const addBtn = document.getElementById('sc-add-faqpage');
          if(!wrap || !addBtn) return;
          addBtn.addEventListener('click', function(){
            const idx = wrap.querySelectorAll('.sc-faqpage-row').length;
            const div = document.createElement('div');
            div.className = 'sc-faqpage-row';
            div.style.cssText = 'border:1px solid #ddd;padding:10px;margin-bottom:10px;';
            div.innerHTML = `
              <p><label><?php echo esc_js(__('Question', 'sound-cloud-theme')); ?></label><br/>
              <input type=\"text\" name=\"sc_faq_items[${idx}][q]\" style=\"width:100%;\" /></p>
              <p><label><?php echo esc_js(__('Answer', 'sound-cloud-theme')); ?></label><br/>
              <textarea name=\"sc_faq_items[${idx}][a]\" rows=\"3\" style=\"width:100%;\"></textarea></p>
              <button type=\"button\" class=\"button sc-remove-faqpage\"><?php echo esc_js(__('Remove', 'sound-cloud-theme')); ?></button>
            `;
            wrap.appendChild(div);
          });
          wrap.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('sc-remove-faqpage')){
              e.target.closest('.sc-faqpage-row').remove();
            }
          });
        })();
        </script>
        <?php
    }
}

if (!function_exists('sc_theme_save_faq_page_meta_box')) {
    function sc_theme_save_faq_page_meta_box($post_id) {
        if (!isset($_POST['sc_faq_page_meta_nonce_field']) || !wp_verify_nonce($_POST['sc_faq_page_meta_nonce_field'], 'sc_faq_page_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $tpl = get_page_template_slug($post_id);
        if ($tpl !== 'page-faq.php') {
            return;
        }

        if (isset($_POST['sc_faq_title'])) {
            update_post_meta($post_id, '_sc_faq_title', sanitize_text_field($_POST['sc_faq_title']));
        }
        if (isset($_POST['sc_faq_desc'])) {
            update_post_meta($post_id, '_sc_faq_desc', wp_kses_post($_POST['sc_faq_desc']));
        }
        if (isset($_POST['sc_faq_support_title'])) {
            update_post_meta($post_id, '_sc_faq_support_title', sanitize_text_field($_POST['sc_faq_support_title']));
        }
        if (isset($_POST['sc_faq_support_desc'])) {
            update_post_meta($post_id, '_sc_faq_support_desc', wp_kses_post($_POST['sc_faq_support_desc']));
        }

        // Category labels
        if (isset($_POST['sc_faq_cat_general'])) {
            update_post_meta($post_id, '_sc_faq_cat_general', sanitize_text_field($_POST['sc_faq_cat_general']));
        }
        if (isset($_POST['sc_faq_cat_technical'])) {
            update_post_meta($post_id, '_sc_faq_cat_technical', sanitize_text_field($_POST['sc_faq_cat_technical']));
        }
        if (isset($_POST['sc_faq_cat_legal'])) {
            update_post_meta($post_id, '_sc_faq_cat_legal', sanitize_text_field($_POST['sc_faq_cat_legal']));
        }
        if (isset($_POST['sc_faq_cat_privacy'])) {
            update_post_meta($post_id, '_sc_faq_cat_privacy', sanitize_text_field($_POST['sc_faq_cat_privacy']));
        }

        if (isset($_POST['sc_faq_items']) && is_array($_POST['sc_faq_items'])) {
            $clean = array();
            foreach ($_POST['sc_faq_items'] as $row) {
                if (empty($row['q']) && empty($row['a'])) continue;
                $clean[] = array(
                    'q' => isset($row['q']) ? sanitize_text_field($row['q']) : '',
                    'a' => isset($row['a']) ? sanitize_textarea_field($row['a']) : '',
                );
            }
            update_post_meta($post_id, '_sc_faq_items', $clean);
        } else {
            delete_post_meta($post_id, '_sc_faq_items');
        }
    }
}
add_action('save_post_page', 'sc_theme_save_faq_page_meta_box');

// ------------------------------
// Contact Page (page-contact.php)
// ------------------------------

if (!function_exists('sc_theme_add_contact_page_meta_box')) {
    function sc_theme_add_contact_page_meta_box($post_type, $post) {
        if ($post_type !== 'page' || empty($post)) { return; }
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-contact.php') { return; }
        add_meta_box(
            'sc_contact_page',
            __('Contact Page Content', 'sound-cloud-theme'),
            'sc_theme_render_contact_page_meta_box',
            'page',
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'sc_theme_add_contact_page_meta_box', 10, 2);

if (!function_exists('sc_theme_render_contact_page_meta_box')) {
    function sc_theme_render_contact_page_meta_box($post) {
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-contact.php') {
            echo '<p>' . esc_html__('This meta box applies to pages using the Contact Template.', 'sound-cloud-theme') . '</p>';
            return;
        }

        wp_nonce_field('sc_contact_page_meta_nonce', 'sc_contact_page_meta_nonce_field');

        $title = get_post_meta($post->ID, '_sc_contact_title', true);
        $desc  = get_post_meta($post->ID, '_sc_contact_desc', true);
        $email = get_post_meta($post->ID, '_sc_contact_email', true);
        $phone = get_post_meta($post->ID, '_sc_contact_phone', true);
        $address = get_post_meta($post->ID, '_sc_contact_address', true);
        $faq_title = get_post_meta($post->ID, '_sc_contact_faq_title', true);
        $faqs = get_post_meta($post->ID, '_sc_contact_faq_items', true);
        if (!is_array($faqs)) { $faqs = array(); }

        echo '<table class="form-table">';
        echo '<tr><th><label for="sc_contact_title">' . esc_html__('Page Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_contact_title" name="sc_contact_title" value="' . esc_attr($title) . '" style="width:100%;" /></td></tr>';

        echo '<tr><th><label>' . esc_html__('Intro Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $desc,
            'sc_contact_desc',
            array(
                'textarea_name' => 'sc_contact_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';

        echo '<tr><th><label for="sc_contact_email">' . esc_html__('Support Email', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="email" id="sc_contact_email" name="sc_contact_email" value="' . esc_attr($email) . '" style="width:100%;" placeholder="support@example.com" /></td></tr>';

        echo '<tr><th><label for="sc_contact_phone">' . esc_html__('Phone', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_contact_phone" name="sc_contact_phone" value="' . esc_attr($phone) . '" style="width:100%;" placeholder="+1 (555) 555-5555" /></td></tr>';

        echo '<tr><th><label for="sc_contact_address">' . esc_html__('Address', 'sound-cloud-theme') . '</label></th>';
        echo '<td><textarea id="sc_contact_address" name="sc_contact_address" rows="3" style="width:100%;">' . esc_textarea($address) . '</textarea></td></tr>';
        echo '</table>';

        // FAQ Preview fields
        echo '<h4>' . esc_html__('FAQ Preview', 'sound-cloud-theme') . '</h4>';
        echo '<table class="form-table">';
        echo '<tr><th><label for="sc_contact_faq_title">' . esc_html__('FAQ Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_contact_faq_title" name="sc_contact_faq_title" value="' . esc_attr($faq_title) . '" style="width:100%;" placeholder="Frequently Asked Questions" /></td></tr>';
        echo '</table>';

        echo '<div id="sc-contact-faqs-wrapper">';
        $i = 0;
        foreach ($faqs as $row) {
            $q = isset($row['q']) ? $row['q'] : '';
            $a = isset($row['a']) ? $row['a'] : '';
            echo '<div class="sc-contact-faq-row" style="border:1px solid #ddd;padding:10px;margin-bottom:10px;">';
            echo '<p><label>' . esc_html__('Question', 'sound-cloud-theme') . '</label><br/>';
            echo '<input type="text" name="sc_contact_faq_items['.$i.'][q]" value="' . esc_attr($q) . '" style="width:100%;" /></p>';
            echo '<p><label>' . esc_html__('Answer', 'sound-cloud-theme') . '</label><br/>';
            echo '<textarea name="sc_contact_faq_items['.$i.'][a]" rows="3" style="width:100%;">' . esc_textarea($a) . '</textarea></p>';
            echo '<button type="button" class="button sc-remove-contact-faq">' . esc_html__('Remove', 'sound-cloud-theme') . '</button>';
            echo '</div>';
            $i++;
        }
        echo '</div>';
        echo '<p><button type="button" class="button button-primary" id="sc-add-contact-faq">' . esc_html__('Add FAQ', 'sound-cloud-theme') . '</button></p>';

        ?>
        <script>
        (function(){
          const wrap = document.getElementById('sc-contact-faqs-wrapper');
          const addBtn = document.getElementById('sc-add-contact-faq');
          if(!wrap || !addBtn) return;
          addBtn.addEventListener('click', function(){
            const idx = wrap.querySelectorAll('.sc-contact-faq-row').length;
            const div = document.createElement('div');
            div.className = 'sc-contact-faq-row';
            div.style.cssText = 'border:1px solid #ddd;padding:10px;margin-bottom:10px;';
            div.innerHTML = `
              <p><label><?php echo esc_js(__('Question', 'sound-cloud-theme')); ?></label><br/>
              <input type=\"text\" name=\"sc_contact_faq_items[${idx}][q]\" style=\"width:100%;\" /></p>
              <p><label><?php echo esc_js(__('Answer', 'sound-cloud-theme')); ?></label><br/>
              <textarea name=\"sc_contact_faq_items[${idx}][a]\" rows=\"3\" style=\"width:100%;\"></textarea></p>
              <button type=\"button\" class=\"button sc-remove-contact-faq\"><?php echo esc_js(__('Remove', 'sound-cloud-theme')); ?></button>
            `;
            wrap.appendChild(div);
          });
          wrap.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('sc-remove-contact-faq')){
              e.target.closest('.sc-contact-faq-row').remove();
            }
          });
        })();
        </script>
        <?php
    }
}

if (!function_exists('sc_theme_save_contact_page_meta_box')) {
    function sc_theme_save_contact_page_meta_box($post_id) {
        if (!isset($_POST['sc_contact_page_meta_nonce_field']) || !wp_verify_nonce($_POST['sc_contact_page_meta_nonce_field'], 'sc_contact_page_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $tpl = get_page_template_slug($post_id);
        if ($tpl !== 'page-contact.php') {
            return;
        }

        if (isset($_POST['sc_contact_title'])) {
            update_post_meta($post_id, '_sc_contact_title', sanitize_text_field($_POST['sc_contact_title']));
        }
        if (isset($_POST['sc_contact_desc'])) {
            update_post_meta($post_id, '_sc_contact_desc', wp_kses_post($_POST['sc_contact_desc']));
        }
        if (isset($_POST['sc_contact_email'])) {
            update_post_meta($post_id, '_sc_contact_email', sanitize_email($_POST['sc_contact_email']));
        }
        if (isset($_POST['sc_contact_phone'])) {
            update_post_meta($post_id, '_sc_contact_phone', sanitize_text_field($_POST['sc_contact_phone']));
        }
        if (isset($_POST['sc_contact_address'])) {
            update_post_meta($post_id, '_sc_contact_address', sanitize_textarea_field($_POST['sc_contact_address']));
        }

        // FAQ Preview save
        if (isset($_POST['sc_contact_faq_title'])) {
            update_post_meta($post_id, '_sc_contact_faq_title', sanitize_text_field($_POST['sc_contact_faq_title']));
        }
        if (isset($_POST['sc_contact_faq_items']) && is_array($_POST['sc_contact_faq_items'])) {
            $clean = array();
            foreach ($_POST['sc_contact_faq_items'] as $row) {
                if (empty($row['q']) && empty($row['a'])) continue;
                $clean[] = array(
                    'q' => isset($row['q']) ? sanitize_text_field($row['q']) : '',
                    'a' => isset($row['a']) ? sanitize_textarea_field($row['a']) : '',
                );
            }
            update_post_meta($post_id, '_sc_contact_faq_items', $clean);
        } else {
            delete_post_meta($post_id, '_sc_contact_faq_items');
        }
    }
}
add_action('save_post_page', 'sc_theme_save_contact_page_meta_box');

// ------------------------------
// About Page (page-about.php)
// ------------------------------

if (!function_exists('sc_theme_add_about_page_meta_box')) {
    function sc_theme_add_about_page_meta_box($post_type, $post) {
        if ($post_type !== 'page' || empty($post)) { return; }
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-about.php') { return; }
        add_meta_box(
            'sc_about_page',
            __('About Page Content', 'sound-cloud-theme'),
            'sc_theme_render_about_page_meta_box',
            'page',
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'sc_theme_add_about_page_meta_box', 10, 2);

if (!function_exists('sc_theme_render_about_page_meta_box')) {
    function sc_theme_render_about_page_meta_box($post) {
        $tpl = get_page_template_slug($post->ID);
        if ($tpl !== 'page-about.php') {
            echo '<p>' . esc_html__('This meta box applies to pages using the About Template.', 'sound-cloud-theme') . '</p>';
            return;
        }

        wp_nonce_field('sc_about_page_meta_nonce', 'sc_about_page_meta_nonce_field');

        $intro = get_post_meta($post->ID, '_sc_about_intro', true);
        $mission_title = get_post_meta($post->ID, '_sc_about_mission_title', true);
        $mission_desc  = get_post_meta($post->ID, '_sc_about_mission_desc', true);
        $what_title = get_post_meta($post->ID, '_sc_about_what_title', true);
        $what_desc  = get_post_meta($post->ID, '_sc_about_what_desc', true);
        $contact_email = get_post_meta($post->ID, '_sc_about_contact_email', true);

        echo '<table class="form-table">';
        echo '<tr><th><label>' . esc_html__('Intro Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $intro,
            'sc_about_intro',
            array(
                'textarea_name' => 'sc_about_intro',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';

        echo '<tr><th><label for="sc_about_mission_title">' . esc_html__('Mission Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_about_mission_title" name="sc_about_mission_title" value="' . esc_attr($mission_title) . '" style="width:100%;" /></td></tr>';
        echo '<tr><th><label>' . esc_html__('Mission Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $mission_desc,
            'sc_about_mission_desc',
            array(
                'textarea_name' => 'sc_about_mission_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';

        echo '<tr><th><label for="sc_about_what_title">' . esc_html__('What We Do Title', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="text" id="sc_about_what_title" name="sc_about_what_title" value="' . esc_attr($what_title) . '" style="width:100%;" /></td></tr>';
        echo '<tr><th><label>' . esc_html__('What We Do Description', 'sound-cloud-theme') . '</label></th>';
        echo '<td>';
        wp_editor(
            $what_desc,
            'sc_about_what_desc',
            array(
                'textarea_name' => 'sc_about_what_desc',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
            )
        );
        echo '</td></tr>';

        echo '<tr><th><label for="sc_about_contact_email">' . esc_html__('Contact Email', 'sound-cloud-theme') . '</label></th>';
        echo '<td><input type="email" id="sc_about_contact_email" name="sc_about_contact_email" value="' . esc_attr($contact_email) . '" style="width:100%;" placeholder="support@example.com" /></td></tr>';
        echo '</table>';
    }
}

if (!function_exists('sc_theme_save_about_page_meta_box')) {
    function sc_theme_save_about_page_meta_box($post_id) {
        if (!isset($_POST['sc_about_page_meta_nonce_field']) || !wp_verify_nonce($_POST['sc_about_page_meta_nonce_field'], 'sc_about_page_meta_nonce')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $tpl = get_page_template_slug($post_id);
        if ($tpl !== 'page-about.php') {
            return;
        }

        if (isset($_POST['sc_about_intro'])) {
            update_post_meta($post_id, '_sc_about_intro', wp_kses_post($_POST['sc_about_intro']));
        }
        if (isset($_POST['sc_about_mission_title'])) {
            update_post_meta($post_id, '_sc_about_mission_title', sanitize_text_field($_POST['sc_about_mission_title']));
        }
        if (isset($_POST['sc_about_mission_desc'])) {
            update_post_meta($post_id, '_sc_about_mission_desc', wp_kses_post($_POST['sc_about_mission_desc']));
        }
        if (isset($_POST['sc_about_what_title'])) {
            update_post_meta($post_id, '_sc_about_what_title', sanitize_text_field($_POST['sc_about_what_title']));
        }
        if (isset($_POST['sc_about_what_desc'])) {
            update_post_meta($post_id, '_sc_about_what_desc', wp_kses_post($_POST['sc_about_what_desc']));
        }
        if (isset($_POST['sc_about_contact_email'])) {
            update_post_meta($post_id, '_sc_about_contact_email', sanitize_email($_POST['sc_about_contact_email']));
        }
    }
}
add_action('save_post_page', 'sc_theme_save_about_page_meta_box');


