<?php
$files = [
    'resources/views/pages/services/3d-animation.blade.php',
    'resources/views/pages/services/web-development.blade.php',
    'resources/views/pages/services/mobile-applications.blade.php',
    'resources/views/pages/services/game-development.blade.php',
];

$replacements = [
    '/ring-gray-[78]00/' => 'ring-animazon-border',
    '/ring-primary-600/' => 'ring-primary',
    '/bg-indigo-900\/\d+/' => 'bg-secondary/10',
    '/bg-purple-900\/\d+/' => 'bg-primary/10',
    '/bg-rose-900\/\d+/' => 'bg-primary/10',
    '/bg-red-900\/\d+/' => 'bg-secondary/10',
    '/text-indigo-[34]00/' => 'text-secondary',
    '/text-purple-[34]00/' => 'text-primary',
    '/text-rose-[34]00/' => 'text-primary',
    '/text-red-[34]00/' => 'text-secondary',
    '/border-indigo-[45]00\/\d+/' => 'border-secondary/30',
    '/border-purple-[45]00\/\d+/' => 'border-primary/30',
    '/border-rose-[45]00\/\d+/' => 'border-primary/30',
    '/border-red-[45]00\/\d+/' => 'border-secondary/30',
    '/group-hover:text-indigo-300/' => 'group-hover:text-secondary',
    '/group-hover:text-purple-300/' => 'group-hover:text-primary',
    '/group-hover:text-rose-300/' => 'group-hover:text-primary',
    '/group-hover:text-red-300/' => 'group-hover:text-secondary',
    '/hover:border-indigo-500\/\d+/' => 'hover:border-secondary/50',
    '/hover:border-purple-500\/\d+/' => 'hover:border-primary/50',
    '/hover:border-rose-500\/\d+/' => 'hover:border-primary/50',
    '/hover:border-red-500\/\d+/' => 'hover:border-secondary/50',
    '/group-hover:bg-indigo-500\/\d+/' => 'group-hover:bg-secondary/20',
    '/group-hover:bg-purple-500\/\d+/' => 'group-hover:bg-primary/20',
    '/group-hover:bg-rose-500\/\d+/' => 'group-hover:bg-primary/20',
    '/group-hover:bg-red-500\/\d+/' => 'group-hover:bg-secondary/20',
    '/bg-indigo-[98]00\/\d+/' => 'bg-secondary/20',
    '/bg-primary-[456]00/' => 'bg-primary',
    '/text-primary-[34]00/' => 'text-primary',
    '/border-primary-[56]00\/\d+/' => 'border-primary/30',
    '/hover:border-primary-[56]00\/\d+/' => 'hover:border-primary/50',
    '/from-primary-[45]00/' => 'from-primary',
    '/bg-gray-800/' => 'bg-animazon-navy',
    '/border-gray-700/' => 'border-animazon-border',
    // cleanup double tags
    '/group-hover:text-primary-300/' => 'group-hover:text-primary',
    '/group-hover:bg-primary-500\/\d+/' => 'group-hover:bg-primary/20',
    // button fixings
    '/bg-blue-600/' => 'bg-primary',
    '/hover:bg-blue-500/' => 'hover:opacity-90',
    '/text-blue-300/' => 'text-primary',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    foreach ($replacements as $pattern => $replacement) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
