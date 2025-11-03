<?php
/**
 * Template Name: Downloader Page
 * 
 * @package Sound_Cloud_Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-content">
        <div class="container">
            <div class="page-header">
                <h1><?php the_title(); ?></h1>
                <p>Download any track from SoundCloud in high quality</p>
            </div>
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
            
            <div class="downloader-section">
                <div class="downloader-form">
                    <form id="soundcloud-downloader-main" method="post">
                        <div class="form-group">
                            <label for="soundcloud-url-main">Paste SoundCloud URL</label>
                            <input type="url" id="soundcloud-url-main" name="soundcloud_url" 
                                   placeholder="https://soundcloud.com/artist/track-name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="quality-select">Select Quality</label>
                            <select id="quality-select" name="quality">
                                <option value="320">320 kbps (High Quality)</option>
                                <option value="256">256 kbps (Good Quality)</option>
                                <option value="128">128 kbps (Standard)</option>
                                <option value="flac">FLAC (Lossless)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="download-btn">Download Track</button>
                    </form>
                </div>
                
                <div class="downloader-info">
                    <h3>How to Download:</h3>
                    <ol>
                        <li>Copy the SoundCloud track URL from your browser</li>
                        <li>Paste it in the input field above</li>
                        <li>Select your preferred audio quality</li>
                        <li>Click "Download Track" and wait for processing</li>
                        <li>Your file will be ready for download</li>
                    </ol>
                </div>
                
                <div class="supported-formats">
                    <h3>Supported Formats:</h3>
                    <div class="format-grid">
                        <div class="format-item">
                            <strong>MP3</strong>
                            <p>Most compatible format</p>
                        </div>
                        <div class="format-item">
                            <strong>FLAC</strong>
                            <p>Lossless audio quality</p>
                        </div>
                        <div class="format-item">
                            <strong>WAV</strong>
                            <p>Uncompressed audio</p>
                        </div>
                        <div class="format-item">
                            <strong>M4A</strong>
                            <p>Apple compatible format</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.downloader-info {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 10px;
    margin: 2rem 0;
}

.downloader-info h3 {
    color: #333;
    margin-bottom: 1rem;
}

.downloader-info ol {
    padding-left: 1.5rem;
}

.downloader-info li {
    margin-bottom: 0.5rem;
    color: #555;
}

.supported-formats {
    margin-top: 2rem;
}

.format-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.format-item {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.format-item strong {
    display: block;
    color: #667eea;
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
}

.format-item p {
    color: #666;
    font-size: 0.9rem;
}

#quality-select {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    background: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadForm = document.getElementById('soundcloud-downloader-main');
    
    if (downloadForm) {
        downloadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const url = document.getElementById('soundcloud-url-main').value;
            const quality = document.getElementById('quality-select').value;
            const button = downloadForm.querySelector('.download-btn');
            
            if (!url) {
                alert('Please enter a valid SoundCloud URL');
                return;
            }
            
            // Validate SoundCloud URL
            if (!url.includes('soundcloud.com')) {
                alert('Please enter a valid SoundCloud URL');
                return;
            }
            
            // Show loading state
            button.textContent = 'Processing...';
            button.disabled = true;
            
            // Simulate download process
            setTimeout(function() {
                alert('Download feature will be implemented with backend integration. URL: ' + url + ', Quality: ' + quality);
                button.textContent = 'Download Track';
                button.disabled = false;
            }, 2000);
        });
    }
});
</script>

<?php get_footer(); ?>
