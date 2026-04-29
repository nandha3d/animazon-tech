<div class="wrap">
    <h1>🎨 Portfolio Showcase Pro - Enhanced</h1>
    
    <div class="card" style="max-width: 1200px; padding: 30px; margin-top: 20px;">
        <h2>📋 How to Use</h2>
        <p>Display your portfolio using the shortcode with various options:</p>
        <pre style="background: #f5f5f5; padding: 15px; border-radius: 5px; font-size: 14px;">[portfolio_showcase]</pre>
        
        <h3 style="margin-top: 30px;">📊 Portfolio Types:</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0;">
            <div style="padding: 20px; background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0;">🌐 Websites</h4>
                <p style="margin: 0; font-size: 13px; color: #666;">Live websites and web applications with automatic screenshot generation</p>
            </div>
            
            <div style="padding: 20px; background: #ffe0b2; border-left: 4px solid #ff9800; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0;">🎥 Videos</h4>
                <p style="margin: 0; font-size: 13px; color: #666;">YouTube videos with embed player, views counter, and playlists</p>
            </div>
            
            <div style="padding: 20px; background: #f3e5f5; border-left: 4px solid #9c27b0; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0;">🎨 3D Work</h4>
                <p style="margin: 0; font-size: 13px; color: #666;">3D models, animations, and renders with software details</p>
            </div>
            
            <div style="padding: 20px; background: #e0f2f1; border-left: 4px solid #009688; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0;">📱 Applications</h4>
                <p style="margin: 0; font-size: 13px; color: #666;">Mobile and desktop apps with store links and downloads</p>
            </div>
        </div>
        
        <h3 style="margin-top: 40px;">⚙️ Shortcode Parameters:</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 150px;">Parameter</th>
                    <th>Description</th>
                    <th style="width: 350px;">Example</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>category</code></td>
                    <td>Filter by category slug</td>
                    <td><code>[portfolio_showcase category="ecommerce"]</code></td>
                </tr>
                <tr>
                    <td><code>type</code></td>
                    <td>Filter by portfolio type</td>
                    <td><code>[portfolio_showcase type="video"]</code></td>
                </tr>
                <tr>
                    <td><code>limit</code></td>
                    <td>Number of items to show (-1 for all)</td>
                    <td><code>[portfolio_showcase limit="9"]</code></td>
                </tr>
                <tr>
                    <td><code>columns</code></td>
                    <td>Grid columns (2, 3, or 4)</td>
                    <td><code>[portfolio_showcase columns="3"]</code></td>
                </tr>
                <tr>
                    <td><code>orderby</code></td>
                    <td>Sort by (date, title, rand)</td>
                    <td><code>[portfolio_showcase orderby="date"]</code></td>
                </tr>
                <tr>
                    <td><code>order</code></td>
                    <td>Sort order (ASC or DESC)</td>
                    <td><code>[portfolio_showcase order="DESC"]</code></td>
                </tr>
                <tr>
                    <td><code>featured</code></td>
                    <td>Show only featured items</td>
                    <td><code>[portfolio_showcase featured="true"]</code></td>
                </tr>
            </tbody>
        </table>
        
        <h3 style="margin-top: 30px;">📝 Example Shortcodes:</h3>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <h4 style="margin: 0 0 10px 0;">🌐 Show Only Websites</h4>
            <pre style="background: white; padding: 12px; border-radius: 5px; margin: 0;">[portfolio_showcase type="website" columns="3" limit="9"]</pre>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <h4 style="margin: 0 0 10px 0;">🎥 YouTube Videos Only</h4>
            <pre style="background: white; padding: 12px; border-radius: 5px; margin: 0;">[portfolio_showcase type="video" orderby="date" order="DESC"]</pre>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <h4 style="margin: 0 0 10px 0;">⭐ Featured Projects Only</h4>
            <pre style="background: white; padding: 12px; border-radius: 5px; margin: 0;">[portfolio_showcase featured="true" columns="4"]</pre>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <h4 style="margin: 0 0 10px 0;">🎨 3D Work Portfolio</h4>
            <pre style="background: white; padding: 12px; border-radius: 5px; margin: 0;">[portfolio_showcase type="3d" category="animation" columns="3"]</pre>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <h4 style="margin: 0 0 10px 0;">📱 Mobile Applications</h4>
            <pre style="background: white; padding: 12px; border-radius: 5px; margin: 0;">[portfolio_showcase type="application" limit="6"]</pre>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <h2>🔧 Features by Portfolio Type</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin: 30px 0;">
            <!-- Website Features -->
            <div style="background: white; border: 2px solid #2196f3; border-radius: 10px; padding: 20px;">
                <h3 style="color: #2196f3; margin: 0 0 15px 0;">🌐 Website Features</h3>
                <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>Automatic screenshot generation</li>
                    <li>Live website preview in modal</li>
                    <li>External link to live site</li>
                    <li>Demo URL support</li>
                    <li>Technology stack tags</li>
                    <li>Pricing display</li>
                </ul>
            </div>
            
            <!-- Video Features -->
            <div style="background: white; border: 2px solid #ff9800; border-radius: 10px; padding: 20px;">
                <h3 style="color: #ff9800; margin: 0 0 15px 0;">🎥 Video Features</h3>
                <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>YouTube embed player</li>
                    <li>Auto-fetch video thumbnail</li>
                    <li>Video duration display</li>
                    <li>Views counter</li>
                    <li>Playlist support</li>
                    <li>Video gallery</li>
                </ul>
            </div>
            
            <!-- 3D Features -->
            <div style="background: white; border: 2px solid #9c27b0; border-radius: 10px; padding: 20px;">
                <h3 style="color: #9c27b0; margin: 0 0 15px 0;">🎨 3D Work Features</h3>
                <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>Software used display</li>
                    <li>Render engine info</li>
                    <li>Polygon count</li>
                    <li>Image gallery support</li>
                    <li>Custom renders upload</li>
                    <li>Project details</li>
                </ul>
            </div>
            
            <!-- Application Features -->
            <div style="background: white; border: 2px solid #009688; border-radius: 10px; padding: 20px;">
                <h3 style="color: #009688; margin: 0 0 15px 0;">📱 Application Features</h3>
                <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>App Store links</li>
                    <li>Play Store links</li>
                    <li>Direct download links</li>
                    <li>Platform indicators</li>
                    <li>Version tracking</li>
                    <li>App size display</li>
                </ul>
            </div>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <h2>📸 Screenshot & Thumbnail Generation</h2>
        <p>The plugin automatically generates screenshots/thumbnails based on portfolio type:</p>
        
        <div style="background: #fff3cd; padding: 20px; border-left: 4px solid #ffc107; margin: 20px 0; border-radius: 5px;">
            <h4 style="margin: 0 0 10px 0;">💡 Automatic Generation:</h4>
            <ul style="margin: 10px 0 0 20px; line-height: 1.8;">
                <li><strong>Websites:</strong> Uses Microlink API or Screenshot.guru (free)</li>
                <li><strong>YouTube Videos:</strong> Fetches official YouTube thumbnail</li>
                <li><strong>3D Work:</strong> Upload custom renders/images</li>
                <li><strong>Applications:</strong> Upload app screenshots/icons</li>
            </ul>
        </div>
        
        <h3>Alternative Screenshot Services:</h3>
        <ul>
            <li><strong>Microlink</strong> - https://microlink.io (Free tier available)</li>
            <li><strong>Screenshot.guru</strong> - https://screenshot.guru (Free)</li>
            <li><strong>ApiFlash</strong> - https://apiflash.com (Free tier: 100 screenshots/month)</li>
            <li><strong>ScreenshotLayer</strong> - https://screenshotlayer.com (Free tier: 100/month)</li>
        </ul>
        
        <hr style="margin: 40px 0;">
        
        <h2>🎨 Gallery Features</h2>
        <div style="background: #e8f5e9; padding: 20px; border-left: 4px solid #4caf50; margin: 20px 0; border-radius: 5px;">
            <h4 style="margin: 0 0 10px 0;">✨ Image & Video Galleries:</h4>
            <ul style="margin: 10px 0 0 20px; line-height: 1.8;">
                <li>Add multiple images to any portfolio item</li>
                <li>Add multiple YouTube videos for video portfolios</li>
                <li>Lightbox gallery viewer with navigation</li>
                <li>Keyboard navigation (arrow keys)</li>
                <li>Image counter display</li>
                <li>Smooth transitions and animations</li>
            </ul>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <h2>✨ Additional Features</h2>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin: 20px 0;">
            <ul style="line-height: 2;">
                <li>✅ Featured project highlighting</li>
                <li>✅ Multi-filter support (Category + Type)</li>
                <li>✅ Responsive grid layout</li>
                <li>✅ Smooth animations</li>
                <li>✅ Modal preview system</li>
                <li>✅ Type-specific styling</li>
                <li>✅ Stats counter animation</li>
                <li>✅ Badge system</li>
            </ul>
            <ul style="line-height: 2;">
                <li>✅ Technology tags</li>
                <li>✅ App store integration</li>
                <li>✅ GitHub link support</li>
                <li>✅ Demo URL option</li>
                <li>✅ Mobile-optimized</li>
                <li>✅ SEO-friendly</li>
                <li>✅ Fast loading</li>
                <li>✅ Custom taxonomies</li>
            </ul>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <h2>🚀 Quick Start Guide</h2>
        <ol style="line-height: 2.5; font-size: 15px;">
            <li><strong>Add Portfolio Item:</strong> Go to Portfolio → Add New</li>
            <li><strong>Select Type:</strong> Choose Website, Video, 3D Work, or Application</li>
            <li><strong>Enter Details:</strong> Fill in type-specific fields (URL, YouTube link, etc.)</li>
            <li><strong>Generate Thumbnail:</strong> Click "Generate Screenshot" button</li>
            <li><strong>Add Gallery:</strong> Upload additional images or videos (optional)</li>
            <li><strong>Add Categories:</strong> Assign categories and tags</li>
            <li><strong>Mark as Featured:</strong> Check featured box for important projects</li>
            <li><strong>Publish:</strong> Click Publish</li>
            <li><strong>Add Shortcode:</strong> Add <code>[portfolio_showcase]</code> to any page</li>
        </ol>
        
        <hr style="margin: 40px 0;">
        
        <h2>📱 Responsive Design</h2>
        <p>The portfolio is fully responsive and works perfectly on all devices:</p>
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin: 20px 0;">
            <div style="flex: 1; min-width: 200px; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">📱</div>
                <strong>Mobile</strong>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">320px - 767px</p>
            </div>
            <div style="flex: 1; min-width: 200px; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">📱</div>
                <strong>Tablet</strong>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">768px - 1023px</p>
            </div>
            <div style="flex: 1; min-width: 200px; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">💻</div>
                <strong>Desktop</strong>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">1024px - 1399px</p>
            </div>
            <div style="flex: 1; min-width: 200px; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">🖥️</div>
                <strong>Large Screen</strong>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">1400px+</p>
            </div>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <h2>🎨 Customization</h2>
        <p>Customize the appearance by editing these files:</p>
        <ul style="line-height: 2;">
            <li><code>assets/css/portfolio-showcase.css</code> - Main styles</li>
            <li><code>assets/js/portfolio-showcase.js</code> - JavaScript functionality</li>
            <li><code>templates/portfolio-grid.php</code> - HTML template</li>
        </ul>
        
        <div style="background: #e1f5fe; padding: 20px; border-left: 4px solid #03a9f4; margin: 20px 0; border-radius: 5px;">
            <h4 style="margin: 0 0 10px 0;">🎨 CSS Variables for Easy Customization:</h4>
            <pre style="background: white; padding: 15px; border-radius: 5px; margin: 0; overflow-x: auto;">--cyan: #00D4FF;
--orange: #FF6B6B;
--purple: #9D4EDD;
--green: #06D6A0;
--dark-bg: #0A0E27;</pre>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 12px; color: white; text-align: center;">
            <h2 style="color: white; margin: 0 0 15px 0;">✅ Plugin Active & Ready!</h2>
            <p style="margin: 0; font-size: 16px; opacity: 0.95;">Portfolio Showcase Pro Enhanced v2.0.0 is active. Start creating your amazing portfolio!</p>
            <div style="margin-top: 20px;">
                <a href="<?php echo admin_url('post-new.php?post_type=portfolio'); ?>" class="button button-primary button-hero" style="margin-right: 10px;">
                    Add New Portfolio Item
                </a>
                <a href="<?php echo admin_url('edit.php?post_type=portfolio'); ?>" class="button button-hero" style="background: white; color: #667eea; border: none;">
                    View All Portfolio
                </a>
            </div>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
            <h3>📚 Need Help?</h3>
            <p>For support and documentation:</p>
            <ul>
                <li>📧 Email: support@animazon.com</li>
                <li>🌐 Website: https://animazon.com</li>
                <li>📖 Documentation: Check the plugin files for inline comments</li>
            </ul>
        </div>
    </div>
</div>