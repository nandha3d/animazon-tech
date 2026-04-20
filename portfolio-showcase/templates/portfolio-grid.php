<?php
if (!$query->have_posts()) {
    echo '<p>No portfolio items found.</p>';
    return;
}

// Get shortcode attributes if available (passed from shortcode function)
$columns = isset($atts['columns']) ? intval($atts['columns']) : 4;
$type_filter = isset($atts['type']) ? $atts['type'] : '';
$show_sections = empty($type_filter); // Only show section headers if no type filter is applied

// Dynamic grid class based on columns
$grid_class = 'portfolio-grid cols-' . $columns;
?>

<?php
    // We will separate the query results into buckets
    $websites = array();
    $videos = array(); // This will include '3d' work
    $apps = array();
    $all_items = array(); // For when type filter is active
    
    // Iterate the main query once and bucket the posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $pid = get_the_ID();
            $post_obj = get_post($pid); // Get the full post object
            $type = get_post_meta($pid, '_portfolio_type', true);
            if (!$type) $type = 'website';
            
            // Always add to all_items for filtered view
            $all_items[] = $post_obj;
            
            // Also bucket for sectioned view
            if ($type === 'website') {
                $websites[] = $post_obj;
            } elseif ($type === 'video' || $type === '3d') {
                $videos[] = $post_obj;
            } elseif ($type === 'application') {
                $apps[] = $post_obj;
            }
        }
        wp_reset_postdata();
    }
    
    // Helper function to render a card (DRY)
    if (!function_exists('render_portfolio_card_v2')) {
        function render_portfolio_card_v2($post_obj) {
            setup_postdata($post_obj);
            $post_id = $post_obj->ID;
            
            // Meta fetching
            $portfolio_type = get_post_meta($post_id, '_portfolio_type', true);
            if (!$portfolio_type) $portfolio_type = 'website';
            // Normalize 3d -> video context for logic, but keep type for icons
            $logic_type = ($portfolio_type === '3d') ? 'video' : $portfolio_type;

            $project_date = get_post_meta($post_id, '_portfolio_date', true);
            $project_price = get_post_meta($post_id, '_portfolio_price', true);
            $tech_stack = get_post_meta($post_id, '_portfolio_tech_stack', true);
            $screenshot_url = get_post_meta($post_id, '_portfolio_screenshot', true);
            $featured = get_post_meta($post_id, '_portfolio_featured', true);
            $badge_text = get_post_meta($post_id, '_portfolio_badge', true);
            
            // Gallery images (for applications)
            $gallery_images = get_post_meta($post_id, '_portfolio_gallery', true);
            $gallery_array = !empty($gallery_images) ? array_filter(explode(',', $gallery_images)) : array();
            
            // URLs
            $website_url = get_post_meta($post_id, '_portfolio_url', true);
            $youtube_url = get_post_meta($post_id, '_portfolio_youtube_url', true);
            $app_store_url = get_post_meta($post_id, '_portfolio_app_store', true);
            $play_store_url = get_post_meta($post_id, '_portfolio_play_store', true);
            $download_url = get_post_meta($post_id, '_portfolio_download', true);
            
            // Video specific
            $video_views = get_post_meta($post_id, '_portfolio_video_views', true);
            $video_duration = get_post_meta($post_id, '_portfolio_video_duration', true);
            
            // Tech stack
            $tech_array = $tech_stack ? array_map('trim', explode(',', $tech_stack)) : array();

            // Image Logic
            $display_image = $screenshot_url;
            $video_id = null;
            $has_youtube_video = false;
            if ($youtube_url) {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $youtube_url, $match);
                if (isset($match[1])) {
                    $video_id = $match[1];
                    $has_youtube_video = true;
                    if (!$display_image) $display_image = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
                }
            }
            if (!$display_image && has_post_thumbnail($post_id)) {
                $display_image = get_the_post_thumbnail_url($post_id, 'large');
            }
            if (!$display_image) {
                $display_image = 'https://via.placeholder.com/800x600/1A1F3A/00D4FF?text=' . urlencode(get_the_title($post_id));
            }

            // Primary URL
            $primary_url = $website_url ?: $youtube_url ?: ($app_store_url ?: $play_store_url ?: $download_url);
            
            // Card type class for styling
            $type_class = 'type-' . $portfolio_type;
            
            // Check if this is an application with gallery images
            $has_gallery = ($portfolio_type === 'application' && !empty($gallery_array));
            ?>
            <div class="portfolio-card <?php echo $featured ? 'featured' : ''; ?> <?php echo esc_attr($type_class); ?><?php echo $has_gallery ? ' has-gallery' : ''; ?>">
                <div class="portfolio-image">
                    <?php if ($has_gallery): ?>
                    <!-- App Gallery Carousel -->
                    <div class="app-gallery-carousel" data-post-id="<?php echo $post_id; ?>">
                        <div class="app-gallery-track">
                            <?php foreach ($gallery_array as $index => $img_url): 
                                $img_url = trim($img_url);
                                if (!empty($img_url)):
                            ?>
                            <div class="app-gallery-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?> - Screenshot <?php echo $index + 1; ?>">
                            </div>
                            <?php endif; endforeach; ?>
                        </div>
                        <?php if (count($gallery_array) > 1): ?>
                        <div class="app-gallery-nav">
                            <button class="app-gallery-prev" aria-label="Previous"><span class="dashicons dashicons-arrow-left-alt2"></span></button>
                            <button class="app-gallery-next" aria-label="Next"><span class="dashicons dashicons-arrow-right-alt2"></span></button>
                        </div>
                        <div class="app-gallery-dots">
                            <?php foreach ($gallery_array as $index => $img_url): ?>
                            <span class="app-gallery-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <img src="<?php echo esc_url($display_image); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                         onerror="this.onerror=null; <?php if($has_youtube_video && isset($video_id)): ?>this.src='https://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg';<?php else: ?>this.src='https://via.placeholder.com/800x600/1A1F3A/00D4FF?text=Image+Not+Found';<?php endif; ?>">
                    <?php endif; ?>
                    
                    <?php if ($badge_text): ?>
                    <span class="portfolio-badge"><?php echo esc_html($badge_text); ?></span>
                    <?php endif; ?>

                    <div class="portfolio-overlay">
                        <div class="overlay-actions">
                            <?php if ($has_youtube_video): ?>
                                <button class="action-btn" onclick="openPortfolioModal('<?php echo esc_js(get_the_title($post_id)); ?>', '<?php echo esc_js($youtube_url); ?>', 'video')" title="Watch Video">
                                    <span class="dashicons dashicons-controls-play"></span>
                                </button>
                            <?php endif; ?>

                            <?php if ($portfolio_type === 'website' && $website_url): ?>
                                <a href="<?php echo esc_url($website_url); ?>" target="_blank" class="action-btn" title="Visit Site">
                                    <span class="dashicons dashicons-admin-links"></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($portfolio_type === 'application'): ?>
                                <?php 
                                // For apps: Show preview icon (visibility) + App Store icon if available
                                $has_any_app_link = $app_store_url || $play_store_url || $download_url;
                                ?>
                                
                                <?php if ($has_any_app_link): ?>
                                    <!-- Preview button for apps -->
                                    <button class="action-btn" onclick="openPortfolioModal('<?php echo esc_js(get_the_title($post_id)); ?>', '<?php echo esc_js($display_image); ?>', 'image')" title="Preview">
                                        <span class="dashicons dashicons-visibility"></span>
                                    </button>
                                    
                                    <!-- App Store icon only (removed Google icon) -->
                                    <?php if ($app_store_url): ?>
                                    <a href="<?php echo esc_url($app_store_url); ?>" target="_blank" class="action-btn" title="App Store">
                                        <span class="dashicons dashicons-smartphone"></span>
                                    </a>
                                    <?php elseif ($play_store_url): ?>
                                    <a href="<?php echo esc_url($play_store_url); ?>" target="_blank" class="action-btn" title="Play Store">
                                        <span class="dashicons dashicons-smartphone"></span>
                                    </a>
                                    <?php elseif ($download_url): ?>
                                    <a href="<?php echo esc_url($download_url); ?>" target="_blank" class="action-btn" title="Download">
                                        <span class="dashicons dashicons-download"></span>
                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <!-- Generic Preview for 3D/video types without youtube -->
                             <?php if (!$has_youtube_video && $portfolio_type !== 'application' && $portfolio_type !== 'website' && $primary_url): ?>
                                <button class="action-btn" onclick="openPortfolioModal('<?php echo esc_js(get_the_title($post_id)); ?>', '<?php echo esc_js($primary_url); ?>', 'image')" title="View">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                             <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="portfolio-info">
                   <div class="portfolio-meta">
                        <?php if ($project_date): ?>
                        <span class="portfolio-meta-item">
                            <span class="dashicons dashicons-calendar-alt" style="font-size:12px;width:12px;height:12px;line-height:1.2;"></span> 
                            <?php echo date('M Y', strtotime($project_date)); ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($logic_type === 'video' && $video_views): ?>
                        <span class="portfolio-meta-item">
                            <span class="dashicons dashicons-visibility" style="font-size:12px;width:12px;height:12px;line-height:1.2;"></span>
                            <?php echo esc_html($video_views); ?>
                        </span>
                        <?php endif; ?>
                   </div>

                    <h3><?php echo get_the_title($post_id); ?></h3>
                    
                    <?php if (!empty($tech_array)): ?>
                    <div class="portfolio-tags">
                        <?php foreach (array_slice($tech_array, 0, 3) as $tech): ?>
                            <span class="portfolio-tag"><?php echo esc_html($tech); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            wp_reset_postdata(); // Reset postdata after rendering each card
        }
    }
    ?>

<div class="portfolio-showcase-wrapper">
    <div class="portfolio-header">
        <h2>Our <span>Portfolio</span></h2>
        <p>Explore our latest projects, videos, 3D work, and applications</p>
    </div>

    <?php if ($show_sections): ?>
        <!-- SECTIONED VIEW (No type filter) -->
        
        <!-- WEBSITES SECTION -->
        <?php if (!empty($websites)): ?>
        <div class="portfolio-section">
            <div class="section-header">
                <h3 class="section-title"><span class="dashicons dashicons-admin-site-alt3"></span> Websites & Web Apps</h3>
                <div class="section-line"></div>
            </div>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php foreach ($websites as $post_obj) { render_portfolio_card_v2($post_obj); } ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- 3D WORK / VIDEOS SECTION -->
        <?php if (!empty($videos)): ?>
        <div class="portfolio-section">
            <div class="section-header">
                <h3 class="section-title"><span class="dashicons dashicons-video-alt3"></span> 3D Work & Animation</h3>
                <div class="section-line"></div>
            </div>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php foreach ($videos as $post_obj) { render_portfolio_card_v2($post_obj); } ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- APPS SECTION - Horizontal Scroll Gallery -->
        <?php if (!empty($apps)): ?>
        <div class="portfolio-section portfolio-section-apps">
            <div class="section-header">
                <h3 class="section-title"><span class="dashicons dashicons-smartphone"></span> Mobile Applications</h3>
                <div class="section-line"></div>
                <div class="gallery-nav-arrows">
                    <button class="gallery-arrow gallery-arrow-prev" data-target="apps-gallery" aria-label="Previous">
                        <span class="dashicons dashicons-arrow-left-alt2"></span>
                    </button>
                    <button class="gallery-arrow gallery-arrow-next" data-target="apps-gallery" aria-label="Next">
                        <span class="dashicons dashicons-arrow-right-alt2"></span>
                    </button>
                </div>
            </div>
            <div class="portfolio-gallery-scroll" id="apps-gallery">
                <div class="portfolio-gallery-track">
                    <?php foreach ($apps as $post_obj) { render_portfolio_card_v2($post_obj); } ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (empty($websites) && empty($videos) && empty($apps)): ?>
            <p class="no-items">No portfolio items found.</p>
        <?php endif; ?>
        
    <?php else: ?>
        <!-- FLAT GRID VIEW (Type filter is active) -->
        <?php if (!empty($all_items)): ?>
        <div class="<?php echo esc_attr($grid_class); ?>">
            <?php foreach ($all_items as $post_obj) { render_portfolio_card_v2($post_obj); } ?>
        </div>
        <?php else: ?>
            <p class="no-items">No portfolio items found.</p>
        <?php endif; ?>
    <?php endif; ?>
    
</div>

<!-- Website/App Preview Modal -->
<div class="portfolio-modal-overlay" id="portfolioModalOverlay"></div>
<div class="portfolio-modal-container" id="portfolioModalContainer">
    <div class="portfolio-modal-header">
        <h3 id="portfolioModalTitle">Project Preview</h3>
        <div class="portfolio-modal-actions">
            <button class="portfolio-modal-close" onclick="closePortfolioModal()">×</button>
        </div>
    </div>
    <div class="portfolio-modal-body" id="portfolioModalBody">
        <div class="portfolio-loading">Loading preview...</div>
    </div>
</div>

<!-- Gallery Modal -->
<div class="portfolio-gallery-modal" id="portfolioGalleryModal" onclick="closeGalleryModal()">
    <div class="gallery-modal-content" onclick="event.stopPropagation()">
        <button class="gallery-close" onclick="closeGalleryModal()">×</button>
        <img id="galleryModalImage" src="" alt="Gallery Image">
        <button class="gallery-nav prev" onclick="prevGalleryImage()">‹</button>
        <button class="gallery-nav next" onclick="nextGalleryImage()">›</button>
        <div id="galleryCounter" style="position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%); color: white; font-weight: 600;"></div>
    </div>
</div>

<?php wp_reset_postdata(); ?>