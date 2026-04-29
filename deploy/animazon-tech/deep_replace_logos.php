<?php
$sourceLogo = 'C:/Users/Nandha/.gemini/antigravity/brain/99aa9608-f3ef-4260-be03-2aa5c67f3703/media__1773120741614.png';
$sourceFavicon = 'C:/Users/Nandha/.gemini/antigravity/brain/99aa9608-f3ef-4260-be03-2aa5c67f3703/media__1773120741659.png';

$targetDirs = [
    'public/assets/images',
    'public/uploads/logo',
    'storage/app/public/uploads/logo',
    'storage/uploads/logo'
];

foreach ($targetDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $lower = strtolower($file);
        $fullPath = $dir . '/' . $file;
        
        if (strpos($lower, 'favicon') !== false) {
            echo "Replacing Favicon: $fullPath\n";
            copy($sourceFavicon, $fullPath);
        } elseif (strpos($lower, 'logo') !== false) {
            echo "Replacing Logo: $fullPath\n";
            copy($sourceLogo, $fullPath);
        }
    }
    
    // Ensure generic names exist in each dir
    copy($sourceLogo, $dir . '/logo-dark.png');
    copy($sourceLogo, $dir . '/logo-light.png');
    copy($sourceFavicon, $dir . '/favicon.png');
}

// Special case for SVG logos if they exist
$svgs = ['public/assets/images/logo-sm.svg', 'public/assets/images/logo-sm-light.svg'];
foreach ($svgs as $svg) {
    if (file_exists($svg)) {
        echo "Updating SVG placeholder: $svg\n";
        // We can't easily turn PNG to SVG, but we can replace it with a simple SVG that says ANIMAZON or just the PNG URL if the browser allows it (though usually it expects SVG)
        // For now, let's just leave them or replace with a generic ANIMAZON SVG if I can create one.
        $svgContent = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><text x="10" y="50" font-family="Arial" font-size="20" fill="gray">ANIMAZON</text></svg>';
        file_put_contents($svg, $svgContent);
    }
}
echo "Replacement complete.\n";
