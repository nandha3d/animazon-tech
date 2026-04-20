<?php
/**
 * Plugin Name: Portfolio Showcase Pro Enhanced
 * Plugin URI: https://animazon.com
 * Description: Display portfolio with YouTube videos, 3D work, websites, and applications with rich features
 * Version: 2.0.0
 * Author: Animazon
 * Author URI: https://animazon.com
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('PORTFOLIO_SHOWCASE_VERSION', '2.4.6');
define('PORTFOLIO_SHOWCASE_DIR', plugin_dir_path(__FILE__));
define('PORTFOLIO_SHOWCASE_URL', plugin_dir_url(__FILE__));
define('PORTFOLIO_SHOWCASE_UPLOAD_DIR', wp_upload_dir()['basedir'] . '/portfolio-screenshots/');
define('PORTFOLIO_SHOWCASE_UPLOAD_URL', wp_upload_dir()['baseurl'] . '/portfolio-screenshots/');

// Add this function near the top of your plugin (after constants)
function portfolio_showcase_enqueue_assets() {
    // Only load on pages that have the shortcode
    if (has_shortcode(get_post()->post_content, 'portfolio_showcase')) {
        wp_enqueue_style('dashicons'); // Enqueue Dashicons for frontend
        wp_enqueue_style(
            'portfolio-showcase-style', 
            PORTFOLIO_SHOWCASE_URL . 'assets/css/portfolio-showcase.css', 
            array('dashicons'), // Dependency
            filemtime(PORTFOLIO_SHOWCASE_DIR . 'assets/css/portfolio-showcase.css')
        );

        wp_enqueue_script(
            'portfolio-showcase-script', 
            PORTFOLIO_SHOWCASE_URL . 'assets/js/portfolio-showcase.js', 
            array('jquery'), 
            filemtime(PORTFOLIO_SHOWCASE_DIR . 'assets/js/portfolio-showcase.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'portfolio_showcase_enqueue_assets');





// Create upload directory on activation
register_activation_hook(__FILE__, 'portfolio_showcase_activate');
function portfolio_showcase_activate() {
    if (!file_exists(PORTFOLIO_SHOWCASE_UPLOAD_DIR)) {
        wp_mkdir_p(PORTFOLIO_SHOWCASE_UPLOAD_DIR);
    }
    
    portfolio_register_post_type();
    portfolio_register_taxonomy();
    flush_rewrite_rules();
}

// Register Custom Post Type
function portfolio_register_post_type() {
    $labels = array(
        'name' => 'Portfolio',
        'singular_name' => 'Portfolio Item',
        'menu_name' => 'Portfolio',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Portfolio Item',
        'edit_item' => 'Edit Portfolio Item',
        'new_item' => 'New Portfolio Item',
        'view_item' => 'View Portfolio Item',
        'search_items' => 'Search Portfolio',
        'not_found' => 'No portfolio items found',
        'not_found_in_trash' => 'No portfolio items found in Trash'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'portfolio')
    );

    register_post_type('portfolio', $args);
}
add_action('init', 'portfolio_register_post_type');

// Register Custom Taxonomy (Categories)
function portfolio_register_taxonomy() {
    register_taxonomy(
        'portfolio_category',
        'portfolio',
        array(
            'label' => 'Categories',
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'portfolio-category')
        )
    );
    
    // Register Portfolio Type (3D, Website, Application, Video)
    register_taxonomy(
        'portfolio_type',
        'portfolio',
        array(
            'label' => 'Portfolio Types',
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'portfolio-type')
        )
    );
}
add_action('init', 'portfolio_register_taxonomy');

// Add category image field to portfolio_category taxonomy
function portfolio_category_add_image_field() {
    ?>
    <div class="form-field term-group">
        <label for="category-image">Category Image</label>
        <div id="category-image-wrapper"></div>
        <input type="hidden" id="category-image-id" name="category-image-id">
        <button type="button" class="button" id="category-image-button">Add Image</button>
        <button type="button" class="button" id="category-image-remove" style="display:none;">Remove Image</button>
        <p class="description">Upload an image for this category (optional)</p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#category-image-button').on('click', function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Category Image',
                button: { text: 'Use this image' },
                multiple: false,
                library: { type: 'image' }
            }).open()
            .on('select', function(){
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                var image_id = uploaded_image.toJSON().id;
                
                $('#category-image-id').val(image_id);
                $('#category-image-wrapper').html('<img src="' + image_url + '" style="max-width: 200px; height: auto; border: 2px solid #ddd; border-radius: 8px;">');
                $('#category-image-remove').show();
            });
        });
        
        $('#category-image-remove').on('click', function() {
            $('#category-image-id').val('');
            $('#category-image-wrapper').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}
add_action('portfolio_category_add_form_fields', 'portfolio_category_add_image_field', 10, 2);

// Add category image field when editing
function portfolio_category_edit_image_field($term) {
    $image_id = get_term_meta($term->term_id, 'category_image_id', true);
    $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="category-image">Category Image</label>
        </th>
        <td>
            <div id="category-image-wrapper">
                <?php if ($image_url): ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; height: auto; border: 2px solid #ddd; border-radius: 8px; margin-bottom: 10px;">
                <?php endif; ?>
            </div>
            <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo esc_attr($image_id); ?>">
            <button type="button" class="button" id="category-image-button">
                <?php echo $image_url ? 'Change Image' : 'Add Image'; ?>
            </button>
            <button type="button" class="button" id="category-image-remove" style="<?php echo $image_url ? '' : 'display:none;'; ?>">Remove Image</button>
            <p class="description">Upload an image for this category (optional)</p>
        </td>
    </tr>
    
    <script>
    jQuery(document).ready(function($) {
        $('#category-image-button').on('click', function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Category Image',
                button: { text: 'Use this image' },
                multiple: false,
                library: { type: 'image' }
            }).open()
            .on('select', function(){
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                var image_id = uploaded_image.toJSON().id;
                
                $('#category-image-id').val(image_id);
                $('#category-image-wrapper').html('<img src="' + image_url + '" style="max-width: 200px; height: auto; border: 2px solid #ddd; border-radius: 8px; margin-bottom: 10px;">');
                $('#category-image-remove').show();
                $('#category-image-button').text('Change Image');
            });
        });
        
        $('#category-image-remove').on('click', function() {
            $('#category-image-id').val('');
            $('#category-image-wrapper').html('');
            $(this).hide();
            $('#category-image-button').text('Add Image');
        });
    });
    </script>
    <?php
}
add_action('portfolio_category_edit_form_fields', 'portfolio_category_edit_image_field', 10, 2);

// Save category image
function portfolio_save_category_image($term_id) {
    if (isset($_POST['category-image-id'])) {
        $image_id = absint($_POST['category-image-id']);
        if ($image_id) {
            update_term_meta($term_id, 'category_image_id', $image_id);
            $image_url = wp_get_attachment_url($image_id);
            if ($image_url) {
                update_term_meta($term_id, 'category_image', $image_url);
            }
        } else {
            delete_term_meta($term_id, 'category_image_id');
            delete_term_meta($term_id, 'category_image');
        }
    }
}
add_action('created_portfolio_category', 'portfolio_save_category_image', 10, 2);
add_action('edited_portfolio_category', 'portfolio_save_category_image', 10, 2);

// Add column to category list
function portfolio_category_columns($columns) {
    $columns['category_image'] = 'Image';
    return $columns;
}
add_filter('manage_edit-portfolio_category_columns', 'portfolio_category_columns');

// Display category image in column
function portfolio_category_column_content($content, $column_name, $term_id) {
    if ($column_name === 'category_image') {
        $image_id = get_term_meta($term_id, 'category_image_id', true);
        if ($image_id) {
            $image_url = wp_get_attachment_url($image_id);
            if ($image_url) {
                $content = '<img src="' . esc_url($image_url) . '" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 2px solid #ddd;">';
            }
        }
    }
    return $content;
}
add_filter('manage_portfolio_category_custom_column', 'portfolio_category_column_content', 10, 3);


// Add Meta Boxes
function portfolio_add_meta_boxes() {
    add_meta_box(
        'portfolio_type_selector',
        'Portfolio Type',
        'portfolio_type_selector_callback',
        'portfolio',
        'side',
        'high'
    );
    
    add_meta_box(
        'portfolio_details',
        'Portfolio Details',
        'portfolio_details_callback',
        'portfolio',
        'normal',
        'high'
    );
    
    add_meta_box(
        'portfolio_media',
        'Media & Gallery',
        'portfolio_media_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'portfolio_add_meta_boxes');

// Portfolio Type Selector Meta Box
function portfolio_type_selector_callback($post) {
    wp_nonce_field('portfolio_save_meta', 'portfolio_meta_nonce');
    
    $portfolio_type = get_post_meta($post->ID, '_portfolio_type', true);
    if (empty($portfolio_type)) {
        $portfolio_type = 'website';
    }
    
    ?>
    <style>
        .portfolio-type-selector {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .portfolio-type-option {
            display: flex;
            align-items: center;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .portfolio-type-option:hover {
            border-color: #00D4FF;
            background: #f0f9ff;
        }
        .portfolio-type-option input[type="radio"] {
            margin-right: 10px;
        }
        .portfolio-type-option input[type="radio"]:checked + label {
            font-weight: 700;
            color: #00D4FF;
        }
        .portfolio-type-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .portfolio-type-info {
            flex: 1;
        }
        .portfolio-type-info strong {
            display: block;
            margin-bottom: 3px;
        }
        .portfolio-type-info small {
            color: #666;
        }
    </style>
    
    <div class="portfolio-type-selector">
        <label class="portfolio-type-option">
            <input type="radio" name="portfolio_type" value="website" <?php checked($portfolio_type, 'website'); ?>>
            <span class="portfolio-type-icon">🌐</span>
            <div class="portfolio-type-info">
                <strong>Website</strong>
                <small>Live websites & web applications</small>
            </div>
        </label>
        
        <label class="portfolio-type-option">
            <input type="radio" name="portfolio_type" value="video" <?php checked($portfolio_type, 'video'); ?>>
            <span class="portfolio-type-icon">🎥</span>
            <div class="portfolio-type-info">
                <strong>Video</strong>
                <small>YouTube videos & demos</small>
            </div>
        </label>
        
        <label class="portfolio-type-option">
            <input type="radio" name="portfolio_type" value="3d" <?php checked($portfolio_type, '3d'); ?>>
            <span class="portfolio-type-icon">🎨</span>
            <div class="portfolio-type-info">
                <strong>3D Work</strong>
                <small>3D models, animations & renders</small>
            </div>
        </label>
        
        <label class="portfolio-type-option">
            <input type="radio" name="portfolio_type" value="application" <?php checked($portfolio_type, 'application'); ?>>
            <span class="portfolio-type-icon">📱</span>
            <div class="portfolio-type-info">
                <strong>Application</strong>
                <small>Mobile & desktop apps</small>
            </div>
        </label>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('input[name="portfolio_type"]').on('change', function() {
            var type = $(this).val();
            
            // Show/hide relevant fields based on type
            $('.portfolio-field').hide();
            $('.portfolio-field-' + type).show();
            $('.portfolio-field-common').show();
        });
        
        // Trigger on load
        $('input[name="portfolio_type"]:checked').trigger('change');
    });
    </script>
    <?php
}

// Portfolio Details Meta Box
// Replace the portfolio_details_callback function in portfolio-showcase.php

function portfolio_details_callback($post) {
    $portfolio_type = get_post_meta($post->ID, '_portfolio_type', true);
    if (empty($portfolio_type)) {
        $portfolio_type = 'website';
    }
    
    $website_url = get_post_meta($post->ID, '_portfolio_url', true);
    $youtube_url = get_post_meta($post->ID, '_portfolio_youtube_url', true);
    $youtube_playlist = get_post_meta($post->ID, '_portfolio_youtube_playlist', true);
    $video_duration = get_post_meta($post->ID, '_portfolio_video_duration', true);
    $video_views = get_post_meta($post->ID, '_portfolio_video_views', true);
    $app_store_url = get_post_meta($post->ID, '_portfolio_app_store', true);
    $play_store_url = get_post_meta($post->ID, '_portfolio_play_store', true);
    $download_url = get_post_meta($post->ID, '_portfolio_download', true);
    $demo_url = get_post_meta($post->ID, '_portfolio_demo', true);
    $github_url = get_post_meta($post->ID, '_portfolio_github', true);
    
    $project_date = get_post_meta($post->ID, '_portfolio_date', true);
    $project_price = get_post_meta($post->ID, '_portfolio_price', true);
    $tech_stack = get_post_meta($post->ID, '_portfolio_tech_stack', true);
    $client_name = get_post_meta($post->ID, '_portfolio_client', true);
    $screenshot_url = get_post_meta($post->ID, '_portfolio_screenshot', true);
    $badge_text = get_post_meta($post->ID, '_portfolio_badge', true);
    $featured = get_post_meta($post->ID, '_portfolio_featured', true);
    
    // 3D specific fields
    $software_used = get_post_meta($post->ID, '_portfolio_3d_software', true);
    $render_engine = get_post_meta($post->ID, '_portfolio_3d_render_engine', true);
    $poly_count = get_post_meta($post->ID, '_portfolio_3d_poly_count', true);
    
    // Application specific fields
    $app_platform = get_post_meta($post->ID, '_portfolio_app_platform', true);
    $app_version = get_post_meta($post->ID, '_portfolio_app_version', true);
    $app_size = get_post_meta($post->ID, '_portfolio_app_size', true);
    
    ?>
    <style>
        .portfolio-meta-box { max-width: 100%; }
        .portfolio-meta-box table.form-table th { width: 200px; padding-left: 0; }
        .portfolio-field { display: none; }
        .portfolio-field.show { display: table-row; }
        .screenshot-preview { 
            max-width: 400px; 
            height: auto; 
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .screenshot-buttons { margin-top: 10px; }
        .screenshot-buttons .button { margin-right: 10px; }
        #screenshot-status { 
            margin-top: 15px;
            padding: 10px 15px;
            border-radius: 5px;
        }
        #screenshot-status.success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        #screenshot-status.error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        #screenshot-status.loading {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .portfolio-help {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .youtube-preview {
            margin-top: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .youtube-preview iframe {
            width: 100%;
            height: 300px;
            border: none;
        }
    </style>
    
    <table class="form-table portfolio-meta-box">
        <!-- Common Fields -->
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_date">Completion Date</label></th>
            <td>
                <input type="date" id="portfolio_date" name="portfolio_date" value="<?php echo esc_attr($project_date); ?>" class="regular-text">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_price">Project Price (₹)</label></th>
            <td>
                <input type="text" id="portfolio_price" name="portfolio_price" value="<?php echo esc_attr($project_price); ?>" class="regular-text" placeholder="15,000">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_client">Client Name</label></th>
            <td>
                <input type="text" id="portfolio_client" name="portfolio_client" value="<?php echo esc_attr($client_name); ?>" class="regular-text">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_badge">Badge Text</label></th>
            <td>
                <input type="text" id="portfolio_badge" name="portfolio_badge" value="<?php echo esc_attr($badge_text); ?>" class="regular-text" placeholder="Featured">
                <p class="description">Optional badge label (e.g., Featured, New, Popular)</p>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_featured">Featured Project</label></th>
            <td>
                <label>
                    <input type="checkbox" id="portfolio_featured" name="portfolio_featured" value="1" <?php checked($featured, '1'); ?>>
                    Mark as featured project (appears first)
                </label>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_tech_stack">Technology Stack</label></th>
            <td>
                <input type="text" id="portfolio_tech_stack" name="portfolio_tech_stack" value="<?php echo esc_attr($tech_stack); ?>" class="regular-text" placeholder="WordPress, React, Node.js">
                <p class="description">Comma-separated list of technologies</p>
            </td>
        </tr>
        
        <!-- Website Fields -->
        <tr class="portfolio-field portfolio-field-website">
            <th><label for="portfolio_url">Website URL *</label></th>
            <td>
                <input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo esc_attr($website_url); ?>" class="regular-text" placeholder="https://example.com">
                <p class="description">Enter the complete website URL</p>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-website">
            <th><label for="portfolio_demo">Demo URL</label></th>
            <td>
                <input type="url" id="portfolio_demo" name="portfolio_demo" value="<?php echo esc_attr($demo_url); ?>" class="regular-text" placeholder="https://demo.example.com">
                <p class="description">Optional demo/preview URL</p>
            </td>
        </tr>
        
        <!-- Video Fields -->
        <tr class="portfolio-field portfolio-field-video">
            <th><label for="portfolio_youtube_url">YouTube Video URL *</label></th>
            <td>
                <input type="url" id="portfolio_youtube_url" name="portfolio_youtube_url" value="<?php echo esc_attr($youtube_url); ?>" class="regular-text" placeholder="https://www.youtube.com/watch?v=VIDEO_ID">
                <button type="button" class="button" id="preview-youtube">Preview Video</button>
                <button type="button" class="button button-primary" id="fetch-youtube-thumbnail">Fetch Thumbnail</button>
                <p class="description">Enter full YouTube video URL or share link</p>
                <div id="youtube-preview-container" class="youtube-preview" style="display:none;"></div>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-video">
            <th><label for="portfolio_youtube_playlist">YouTube Playlist URL</label></th>
            <td>
                <input type="url" id="portfolio_youtube_playlist" name="portfolio_youtube_playlist" value="<?php echo esc_attr($youtube_playlist); ?>" class="regular-text" placeholder="https://www.youtube.com/playlist?list=...">
                <p class="description">Optional: Link to related playlist</p>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-video">
            <th><label for="portfolio_video_duration">Video Duration</label></th>
            <td>
                <input type="text" id="portfolio_video_duration" name="portfolio_video_duration" value="<?php echo esc_attr($video_duration); ?>" class="regular-text" placeholder="5:30">
                <p class="description">Format: MM:SS or HH:MM:SS</p>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-video">
            <th><label for="portfolio_video_views">Total Views</label></th>
            <td>
                <input type="text" id="portfolio_video_views" name="portfolio_video_views" value="<?php echo esc_attr($video_views); ?>" class="regular-text" placeholder="10,000">
            </td>
        </tr>
        
        <!-- 3D Work Fields -->
        <tr class="portfolio-field portfolio-field-3d">
            <th><label for="portfolio_3d_software">Software Used</label></th>
            <td>
                <input type="text" id="portfolio_3d_software" name="portfolio_3d_software" value="<?php echo esc_attr($software_used); ?>" class="regular-text" placeholder="Blender, Maya, 3ds Max">
                <p class="description">3D software/tools used</p>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-3d">
            <th><label for="portfolio_3d_render_engine">Render Engine</label></th>
            <td>
                <input type="text" id="portfolio_3d_render_engine" name="portfolio_3d_render_engine" value="<?php echo esc_attr($render_engine); ?>" class="regular-text" placeholder="Cycles, V-Ray, Arnold">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-3d">
            <th><label for="portfolio_3d_poly_count">Polygon Count</label></th>
            <td>
                <input type="text" id="portfolio_3d_poly_count" name="portfolio_3d_poly_count" value="<?php echo esc_attr($poly_count); ?>" class="regular-text" placeholder="50,000">
            </td>
        </tr>
        
        <!-- Application Fields -->
        <tr class="portfolio-field portfolio-field-application">
            <th><label for="portfolio_app_platform">Platform</label></th>
            <td>
                <select id="portfolio_app_platform" name="portfolio_app_platform" class="regular-text">
                    <option value="">Select Platform</option>
                    <option value="ios" <?php selected($app_platform, 'ios'); ?>>iOS</option>
                    <option value="android" <?php selected($app_platform, 'android'); ?>>Android</option>
                    <option value="web" <?php selected($app_platform, 'web'); ?>>Web App</option>
                    <option value="desktop" <?php selected($app_platform, 'desktop'); ?>>Desktop</option>
                    <option value="cross-platform" <?php selected($app_platform, 'cross-platform'); ?>>Cross-Platform</option>
                </select>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-application">
            <th><label for="portfolio_app_store">App Store URL</label></th>
            <td>
                <input type="url" id="portfolio_app_store" name="portfolio_app_store" value="<?php echo esc_attr($app_store_url); ?>" class="regular-text" placeholder="https://apps.apple.com/...">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-application">
            <th><label for="portfolio_play_store">Play Store URL</label></th>
            <td>
                <input type="url" id="portfolio_play_store" name="portfolio_play_store" value="<?php echo esc_attr($play_store_url); ?>" class="regular-text" placeholder="https://play.google.com/...">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-application">
            <th><label for="portfolio_download">Download URL</label></th>
            <td>
                <input type="url" id="portfolio_download" name="portfolio_download" value="<?php echo esc_attr($download_url); ?>" class="regular-text" placeholder="https://example.com/download">
                <p class="description">Direct download link for desktop apps</p>
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-application">
            <th><label for="portfolio_app_version">Version</label></th>
            <td>
                <input type="text" id="portfolio_app_version" name="portfolio_app_version" value="<?php echo esc_attr($app_version); ?>" class="regular-text" placeholder="1.0.0">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-application">
            <th><label for="portfolio_app_size">App Size</label></th>
            <td>
                <input type="text" id="portfolio_app_size" name="portfolio_app_size" value="<?php echo esc_attr($app_size); ?>" class="regular-text" placeholder="45 MB">
            </td>
        </tr>
        
        <tr class="portfolio-field portfolio-field-common">
            <th><label for="portfolio_github">GitHub URL</label></th>
            <td>
                <input type="url" id="portfolio_github" name="portfolio_github" value="<?php echo esc_attr($github_url); ?>" class="regular-text" placeholder="https://github.com/username/repo">
                <p class="description">Optional GitHub repository link</p>
            </td>
        </tr>
        
        <!-- Screenshot Section -->
        <tr class="portfolio-field portfolio-field-common">
            <th><label>Thumbnail/Screenshot</label></th>
            <td>
                <div class="screenshot-preview-container">
                    <?php if ($screenshot_url): ?>
                        <img src="<?php echo esc_url($screenshot_url); ?>" class="screenshot-preview" id="screenshot-preview">
                    <?php else: ?>
                        <img src="https://placehold.co/800x600/f0f0f0/999999?text=No+Screenshot" class="screenshot-preview" id="screenshot-preview">
                    <?php endif; ?>
                </div>
                
                <div class="screenshot-buttons">
                    <button type="button" class="button button-primary" id="generate-screenshot">
                        <span class="dashicons dashicons-camera" style="margin-top: 3px;"></span>
                        <?php echo $screenshot_url ? 'Regenerate Screenshot' : 'Generate Screenshot'; ?>
                    </button>
                    <button type="button" class="button" id="upload-screenshot">
                        <span class="dashicons dashicons-upload" style="margin-top: 3px;"></span>
                        Upload Custom Image
                    </button>
                    <?php if ($screenshot_url): ?>
                    <button type="button" class="button button-link-delete" id="delete-screenshot">
                        <span class="dashicons dashicons-trash" style="margin-top: 3px;"></span>
                        Remove
                    </button>
                    <?php endif; ?>
                </div>
                
                <input type="hidden" id="portfolio_screenshot" name="portfolio_screenshot" value="<?php echo esc_attr($screenshot_url); ?>">
                
                <div id="screenshot-status"></div>
                
                <div class="portfolio-help">
                    <strong>💡 Tips:</strong>
                    <ul style="margin: 5px 0 0 20px;">
                        <li>For websites: Auto-generate from URL</li>
                        <li>For videos: YouTube thumbnail auto-fetched (will NOT show in grid view)</li>
                        <li>For 3D/Apps: Upload custom renders/screenshots</li>
                        <li>Recommended size: 1200x800 pixels</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>
    
    <script>
    jQuery(document).ready(function($) {
        var isGenerating = false;
        
        // YouTube Preview
        $('#preview-youtube').on('click', function() {
            var youtubeUrl = $('#portfolio_youtube_url').val();
            if (!youtubeUrl) {
                alert('Please enter a YouTube URL first');
                return;
            }
            
            var videoId = extractYouTubeID(youtubeUrl);
            if (videoId) {
                $('#youtube-preview-container').html(
                    '<iframe src="https://www.youtube.com/embed/' + videoId + '" allowfullscreen></iframe>'
                ).show();
            } else {
                alert('Invalid YouTube URL');
            }
        });
        
        // Fetch YouTube Thumbnail
        $('#fetch-youtube-thumbnail').on('click', function() {
            var youtubeUrl = $('#portfolio_youtube_url').val();
            if (!youtubeUrl) {
                alert('Please enter a YouTube URL first');
                return;
            }
            
            var videoId = extractYouTubeID(youtubeUrl);
            if (videoId) {
                var thumbnailUrl = 'https://img.youtube.com/vi/' + videoId + '/maxresdefault.jpg';
                
                // Check if maxres exists, fallback to hqdefault
                var img = new Image();
                img.onload = function() {
                    if (this.width === 120) { // maxresdefault doesn't exist
                        thumbnailUrl = 'https://img.youtube.com/vi/' + videoId + '/hqdefault.jpg';
                    }
                    $('#portfolio_screenshot').val(thumbnailUrl);
                    $('#screenshot-preview').attr('src', thumbnailUrl);
                    
                    $('#screenshot-status').removeClass('loading error')
                                          .addClass('success')
                                          .html('<strong>✓ Success!</strong> YouTube thumbnail fetched! Save post to apply changes.');
                    
                    if ($('#delete-screenshot').length === 0) {
                        $('.screenshot-buttons').append(
                            '<button type="button" class="button button-link-delete" id="delete-screenshot">' +
                            '<span class="dashicons dashicons-trash" style="margin-top: 3px;"></span> Remove</button>'
                        );
                    }
                };
                img.onerror = function() {
                    thumbnailUrl = 'https://img.youtube.com/vi/' + videoId + '/hqdefault.jpg';
                    $('#portfolio_screenshot').val(thumbnailUrl);
                    $('#screenshot-preview').attr('src', thumbnailUrl);
                    
                    $('#screenshot-status').removeClass('loading error')
                                          .addClass('success')
                                          .html('<strong>✓ Success!</strong> YouTube thumbnail fetched! Save post to apply changes.');
                };
                img.src = thumbnailUrl;
            } else {
                alert('Invalid YouTube URL');
            }
        });
        
        function extractYouTubeID(url) {
            var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            var match = url.match(regExp);
            return (match && match[7].length == 11) ? match[7] : false;
        }
        
        // Generate Screenshot
        $('#generate-screenshot').on('click', function() {
            if (isGenerating) return;
            
            var btn = $(this);
            var portfolioType = $('input[name="portfolio_type"]:checked').val();
            var url = '';
            var postId = <?php echo $post->ID; ?>;
            var status = $('#screenshot-status');
            
            // Get URL based on portfolio type
            if (portfolioType === 'website') {
                url = $('#portfolio_url').val();
            } else if (portfolioType === 'video') {
                url = $('#portfolio_youtube_url').val();
            } else if (portfolioType === 'application') {
                status.removeClass('success error loading')
                      .addClass('error')
                      .html('<strong>Info:</strong> Please upload a custom screenshot for applications');
                return;
            } else if (portfolioType === '3d') {
                status.removeClass('success error loading')
                      .addClass('error')
                      .html('<strong>Info:</strong> Please upload a custom render/screenshot for 3D work');
                return;
            }
            
            if (!url) {
                status.removeClass('success error loading')
                      .addClass('error')
                      .html('<strong>Error:</strong> Please enter a URL first');
                return;
            }
            
            isGenerating = true;
            btn.prop('disabled', true);
            btn.html('<span class="dashicons dashicons-update dashicons-spin" style="margin-top: 3px;"></span> Generating...');
            
            status.removeClass('success error')
                  .addClass('loading')
                  .html('📸 Generating thumbnail...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'generate_portfolio_screenshot',
                    url: url,
                    post_id: postId,
                    portfolio_type: portfolioType,
                    nonce: '<?php echo wp_create_nonce('generate_screenshot'); ?>'
                },
                timeout: 60000,
                success: function(response) {
                    isGenerating = false;
                    btn.prop('disabled', false)
                       .html('<span class="dashicons dashicons-camera" style="margin-top: 3px;"></span> Regenerate Screenshot');
                    
                    if (response.success) {
                        $('#portfolio_screenshot').val(response.data.screenshot_url);
                        $('#screenshot-preview').attr('src', response.data.screenshot_url);
                        
                        status.removeClass('loading error')
                              .addClass('success')
                              .html('<strong>✓ Success!</strong> Thumbnail generated! Save post to apply changes.');
                        
                        if ($('#delete-screenshot').length === 0) {
                            $('.screenshot-buttons').append(
                                '<button type="button" class="button button-link-delete" id="delete-screenshot">' +
                                '<span class="dashicons dashicons-trash" style="margin-top: 3px;"></span> Remove</button>'
                            );
                        }
                    } else {
                        status.removeClass('loading success')
                              .addClass('error')
                              .html('<strong>✗ Error:</strong> ' + response.data.message);
                    }
                },
                error: function(xhr, status, error) {
                    isGenerating = false;
                    btn.prop('disabled', false)
                       .html('<span class="dashicons dashicons-camera" style="margin-top: 3px;"></span> Retry Generation');
                    
                    $('#screenshot-status').removeClass('loading success')
                                          .addClass('error')
                                          .html('<strong>✗ Error:</strong> Request failed. Please try again or upload manually.');
                }
            });
        });
        
        // Upload Custom Screenshot
        $('#upload-screenshot').on('click', function(e) {
            e.preventDefault();
            
            var image = wp.media({ 
                title: 'Upload Portfolio Image',
                button: { text: 'Use this image' },
                multiple: false,
                library: { type: 'image' }
            }).open()
            .on('select', function(){
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                
                $('#portfolio_screenshot').val(image_url);
                $('#screenshot-preview').attr('src', image_url);
                
                $('#screenshot-status').removeClass('loading error')
                                      .addClass('success')
                                      .html('<strong>✓ Success!</strong> Custom image uploaded! Save post to apply changes.');
                
                if ($('#delete-screenshot').length === 0) {
                    $('.screenshot-buttons').append(
                        '<button type="button" class="button button-link-delete" id="delete-screenshot">' +
                        '<span class="dashicons dashicons-trash" style="margin-top: 3px;"></span> Remove</button>'
                    );
                }
            });
        });
        
        // Delete Screenshot
        $(document).on('click', '#delete-screenshot', function() {
            if (confirm('Are you sure you want to remove this image?')) {
                $('#portfolio_screenshot').val('');
                $('#screenshot-preview').attr('src', 'https://placehold.co/800x600/f0f0f0/999999?text=No+Screenshot');
                $(this).remove();
                
                $('#screenshot-status').removeClass('loading error success')
                                      .addClass('success')
                                      .html('<strong>✓ Image removed.</strong> Save post to apply changes.');
            }
        });
    });
    </script>
    <?php
}

// Portfolio Media & Gallery Meta Box
function portfolio_media_callback($post) {
    $gallery_images = get_post_meta($post->ID, '_portfolio_gallery', true);
    $video_gallery = get_post_meta($post->ID, '_portfolio_video_gallery', true);
    
    ?>
    <style>
        .portfolio-gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .gallery-item {
            position: relative;
            aspect-ratio: 1;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-item-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
        }
        .gallery-item-remove:hover {
            background: #c82333;
        }
        .video-gallery-item {
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .video-gallery-item input {
            width: 100%;
            margin-bottom: 5px;
        }
    </style>
    
    <div class="portfolio-media-section">
        <h3>📷 Image Gallery</h3>
        <p>Add multiple images for this portfolio item</p>
        
        <button type="button" class="button button-primary" id="add-gallery-images">
            <span class="dashicons dashicons-format-gallery" style="margin-top: 3px;"></span>
            Add Images to Gallery
        </button>
        
        <div class="portfolio-gallery-container" id="gallery-container">
            <?php if (!empty($gallery_images)): 
                $images = explode(',', $gallery_images);
                foreach ($images as $image_url): ?>
                    <div class="gallery-item">
                        <img src="<?php echo esc_url($image_url); ?>">
                        <button type="button" class="gallery-item-remove" onclick="removeGalleryItem(this)">×</button>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
        
        <input type="hidden" id="portfolio_gallery" name="portfolio_gallery" value="<?php echo esc_attr($gallery_images); ?>">
        
        <hr style="margin: 30px 0;">
        
        <h3>🎥 Video Gallery (YouTube URLs)</h3>
        <p>Add multiple YouTube videos related to this project</p>
        
        <button type="button" class="button" id="add-video-url">
            <span class="dashicons dashicons-video-alt3" style="margin-top: 3px;"></span>
            Add Video URL
        </button>
        
        <div id="video-gallery-container">
            <?php if (!empty($video_gallery)): 
                $videos = json_decode($video_gallery, true);
                if (is_array($videos)):
                    foreach ($videos as $index => $video): ?>
                        <div class="video-gallery-item">
                            <input type="text" class="video-url-input" placeholder="YouTube URL" value="<?php echo esc_attr($video['url']); ?>">
                            <input type="text" class="video-title-input" placeholder="Video title (optional)" value="<?php echo esc_attr($video['title']); ?>">
                            <button type="button" class="button button-small button-link-delete" onclick="removeVideoItem(this)">Remove</button>
                        </div>
                    <?php endforeach;
                endif;
            endif; ?>
        </div>
        
        <input type="hidden" id="portfolio_video_gallery" name="portfolio_video_gallery" value='<?php echo esc_attr($video_gallery); ?>'>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add Gallery Images
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            var gallery = wp.media({
                title: 'Add Images to Gallery',
                button: { text: 'Add to Gallery' },
                multiple: true,
                library: { type: 'image' }
            }).open()
            .on('select', function() {
                var selection = gallery.state().get('selection');
                var currentGallery = $('#portfolio_gallery').val();
                var galleryArray = currentGallery ? currentGallery.split(',') : [];
                
                selection.each(function(attachment) {
                    var imageUrl = attachment.toJSON().url;
                    galleryArray.push(imageUrl);
                    
                    $('#gallery-container').append(
                        '<div class="gallery-item">' +
                        '<img src="' + imageUrl + '">' +
                        '<button type="button" class="gallery-item-remove" onclick="removeGalleryItem(this)">×</button>' +
                        '</div>'
                    );
                });
                
                $('#portfolio_gallery').val(galleryArray.join(','));
            });
        });
        
        // Add Video URL
        $('#add-video-url').on('click', function() {
            $('#video-gallery-container').append(
                '<div class="video-gallery-item">' +
                '<input type="text" class="video-url-input" placeholder="YouTube URL">' +
                '<input type="text" class="video-title-input" placeholder="Video title (optional)">' +
                '<button type="button" class="button button-small button-link-delete" onclick="removeVideoItem(this)">Remove</button>' +
                '</div>'
            );
            updateVideoGallery();
        });
        
        // Update video gallery on input change
        $(document).on('input', '.video-url-input, .video-title-input', function() {
            updateVideoGallery();
        });
    });
    
    function removeGalleryItem(btn) {
        var container = jQuery(btn).closest('.gallery-item');
        container.remove();
        
        var galleryArray = [];
        jQuery('.gallery-item img').each(function() {
            galleryArray.push(jQuery(this).attr('src'));
        });
        
        jQuery('#portfolio_gallery').val(galleryArray.join(','));
    }
    
    function removeVideoItem(btn) {
        jQuery(btn).closest('.video-gallery-item').remove();
        updateVideoGallery();
    }
    
    function updateVideoGallery() {
        var videos = [];
        jQuery('.video-gallery-item').each(function() {
            var url = jQuery(this).find('.video-url-input').val();
            var title = jQuery(this).find('.video-title-input').val();
            if (url) {
                videos.push({ url: url, title: title });
            }
        });
        jQuery('#portfolio_video_gallery').val(JSON.stringify(videos));
    }
    </script>
    <?php
}

// Save Meta Box Data
function portfolio_save_meta($post_id) {
    if (!isset($_POST['portfolio_meta_nonce']) || !wp_verify_nonce($_POST['portfolio_meta_nonce'], 'portfolio_save_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'portfolio_type' => '_portfolio_type',
        'portfolio_url' => '_portfolio_url',
        'portfolio_youtube_url' => '_portfolio_youtube_url',
        'portfolio_youtube_playlist' => '_portfolio_youtube_playlist',
        'portfolio_video_duration' => '_portfolio_video_duration',
        'portfolio_video_views' => '_portfolio_video_views',
        'portfolio_app_store' => '_portfolio_app_store',
        'portfolio_play_store' => '_portfolio_play_store',
        'portfolio_download' => '_portfolio_download',
        'portfolio_demo' => '_portfolio_demo',
        'portfolio_github' => '_portfolio_github',
        'portfolio_date' => '_portfolio_date',
        'portfolio_price' => '_portfolio_price',
        'portfolio_tech_stack' => '_portfolio_tech_stack',
        'portfolio_client' => '_portfolio_client',
        'portfolio_screenshot' => '_portfolio_screenshot',
        'portfolio_badge' => '_portfolio_badge',
        'portfolio_3d_software' => '_portfolio_3d_software',
        'portfolio_3d_render_engine' => '_portfolio_3d_render_engine',
        'portfolio_3d_poly_count' => '_portfolio_3d_poly_count',
        'portfolio_app_platform' => '_portfolio_app_platform',
        'portfolio_app_version' => '_portfolio_app_version',
        'portfolio_app_size' => '_portfolio_app_size',
        'portfolio_gallery' => '_portfolio_gallery',
        'portfolio_video_gallery' => '_portfolio_video_gallery'
    );
    
    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Handle featured checkbox
    $featured = isset($_POST['portfolio_featured']) ? '1' : '0';
    update_post_meta($post_id, '_portfolio_featured', $featured);
}
add_action('save_post_portfolio', 'portfolio_save_meta');

// AJAX Handler for Screenshot Generation
function generate_portfolio_screenshot() {
    check_ajax_referer('generate_screenshot', 'nonce');
    
    $url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $portfolio_type = isset($_POST['portfolio_type']) ? sanitize_text_field($_POST['portfolio_type']) : 'website';
    
    if (!$url) {
        wp_send_json_error(array('message' => 'Invalid URL'));
    }
    
    $screenshot_url = '';
    
    // Handle different portfolio types
    if ($portfolio_type === 'video') {
        // Extract YouTube video ID and get thumbnail
        $screenshot_url = portfolio_get_youtube_thumbnail($url);
    } else if ($portfolio_type === 'website') {
        // Generate website screenshot
        $screenshot_url = portfolio_get_screenshot_multimethod($url, $post_id);
    }
    
    if ($screenshot_url) {
        update_post_meta($post_id, '_portfolio_screenshot', $screenshot_url);
        wp_send_json_success(array(
            'screenshot_url' => $screenshot_url,
            'message' => 'Thumbnail generated successfully!'
        ));
    } else {
        wp_send_json_error(array('message' => 'Could not generate thumbnail. Please upload one manually.'));
    }
}
add_action('wp_ajax_generate_portfolio_screenshot', 'generate_portfolio_screenshot');

// Get YouTube Thumbnail
function portfolio_get_youtube_thumbnail($url) {
    // Extract video ID
    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match);
    
    if (isset($match[1])) {
        $video_id = $match[1];
        // Try to get maxres thumbnail first, fall back to high quality
        $thumbnail_urls = array(
            "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg",
            "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg"
        );
        
        foreach ($thumbnail_urls as $thumb_url) {
            $response = wp_remote_head($thumb_url);
            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                return $thumb_url;
            }
        }
    }
    
    return false;
}

// Multi-method Screenshot Generation for Websites
function portfolio_get_screenshot_multimethod($url, $post_id) {
    $upload_dir = PORTFOLIO_SHOWCASE_UPLOAD_DIR;
    if (!file_exists($upload_dir)) {
        wp_mkdir_p($upload_dir);
    }
    
    // Method 1: Microlink API
    $screenshot_url = portfolio_try_microlink($url);
    if ($screenshot_url) {
        $saved = portfolio_save_screenshot_locally($screenshot_url, $post_id);
        if ($saved) return $saved;
        return $screenshot_url;
    }
    
    // Method 2: Screenshot.guru
    $screenshot_url = portfolio_try_screenshot_guru($url);
    if ($screenshot_url) {
        return $screenshot_url;
    }
    
    // Fallback: Placeholder
    return 'https://placehold.co/1200x800/1A1F3A/00D4FF?text=' . urlencode(parse_url($url, PHP_URL_HOST));
}

// Microlink API
function portfolio_try_microlink($url) {
    $api_url = 'https://api.microlink.io/?url=' . urlencode($url) . '&screenshot=true&meta=false&embed=screenshot.url';
    
    $response = wp_remote_get($api_url, array(
        'timeout' => 30,
        'headers' => array('Content-Type' => 'application/json')
    ));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (isset($data['status']) && $data['status'] === 'success' && isset($data['data']['screenshot']['url'])) {
        return $data['data']['screenshot']['url'];
    }
    
    return false;
}

// Screenshot.guru
function portfolio_try_screenshot_guru($url) {
    $screenshot_url = 'https://image.thum.io/get/width/1200/crop/800/' . urlencode($url);
    
    $response = wp_remote_head($screenshot_url, array('timeout' => 10));
    
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
        return $screenshot_url;
    }
    
    return false;
}

// Save screenshot locally
function portfolio_save_screenshot_locally($image_url, $post_id) {
    $upload_dir = PORTFOLIO_SHOWCASE_UPLOAD_DIR;
    
    if (!file_exists($upload_dir)) {
        if (!wp_mkdir_p($upload_dir)) {
            return false;
        }
    }
    
    if (!is_writable($upload_dir)) {
        return false;
    }
    
    $filename = 'portfolio-' . $post_id . '-' . time() . '.jpg';
    $file_path = $upload_dir . $filename;
    
    $response = wp_remote_get($image_url, array(
        'timeout' => 30,
        'stream' => true,
        'filename' => $file_path
    ));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    if (file_exists($file_path) && filesize($file_path) > 0) {
        return PORTFOLIO_SHOWCASE_UPLOAD_URL . $filename;
    }
    
    $image_data = @file_get_contents($image_url);
    
    if ($image_data && strlen($image_data) > 0) {
        if (@file_put_contents($file_path, $image_data)) {
            return PORTFOLIO_SHOWCASE_UPLOAD_URL . $filename;
        }
    }
    
    return false;
}

// Enqueue Admin Scripts
function portfolio_admin_scripts($hook) {
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        global $post_type;
        if ($post_type == 'portfolio') {
            wp_enqueue_media();
            wp_enqueue_script('jquery');
        }
    }
}
add_action('admin_enqueue_scripts', 'portfolio_admin_scripts');

// Shortcode Function
function portfolio_showcase_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
        'type' => '', // New: filter by portfolio type
        'limit' => -1,
        'columns' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
        'featured' => '' // New: show only featured items
    ), $atts);
    
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => intval($atts['limit']),
        'orderby' => $atts['orderby'],
        'order' => $atts['order']
    );
    
    // Add meta query for featured items
    if ($atts['featured'] === 'true') {
        $args['meta_query'] = array(
            array(
                'key' => '_portfolio_featured',
                'value' => '1',
                'compare' => '='
            )
        );
    } else {
        // Featured items first
        $args['meta_key'] = '_portfolio_featured';
        $args['orderby'] = array('meta_value_num' => 'DESC', 'date' => 'DESC');
    }
    
    $tax_query = array();
    
    if (!empty($atts['category'])) {
        $tax_query[] = array(
            'taxonomy' => 'portfolio_category',
            'field' => 'slug',
            'terms' => $atts['category']
        );
    }
    
    // Type filter - uses post meta, not taxonomy
    if (!empty($atts['type'])) {
        // Map common shortcode values to meta values
        $type_map = array(
            'website' => 'website',
            'video' => 'video',
            '3d' => '3d',
            'application' => 'application',
            'app' => 'application' // alias
        );
        
        $type_value = isset($type_map[$atts['type']]) ? $type_map[$atts['type']] : $atts['type'];
        
        if (!isset($args['meta_query'])) {
            $args['meta_query'] = array();
        }
        $args['meta_query'][] = array(
            'key' => '_portfolio_type',
            'value' => $type_value,
            'compare' => '='
        );
    }
    
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
        if (count($tax_query) > 1) {
            $args['tax_query']['relation'] = 'AND';
        }
    }
    
    $query = new WP_Query($args);
    
    // Enqueue frontend assets
   // wp_enqueue_style('portfolio-showcase-style', PORTFOLIO_SHOWCASE_URL . 'assets/css/portfolio-showcase.css', array(), PORTFOLIO_SHOWCASE_VERSION);
   // wp_enqueue_script('portfolio-showcase-script', PORTFOLIO_SHOWCASE_URL . 'assets/js/portfolio-showcase.js', array('jquery'), PORTFOLIO_SHOWCASE_VERSION, true);
    
    ob_start();
    include PORTFOLIO_SHOWCASE_DIR . 'templates/portfolio-grid.php';
    return ob_get_clean();
}
add_shortcode('portfolio_showcase', 'portfolio_showcase_shortcode');

// Settings Page
function portfolio_showcase_menu() {
    add_submenu_page(
        'edit.php?post_type=portfolio',
        'Portfolio Settings',
        'Settings',
        'manage_options',
        'portfolio-settings',
        'portfolio_settings_page'
    );
}
add_action('admin_menu', 'portfolio_showcase_menu');

function portfolio_settings_page() {
    include PORTFOLIO_SHOWCASE_DIR . 'templates/settings-page.php';
}