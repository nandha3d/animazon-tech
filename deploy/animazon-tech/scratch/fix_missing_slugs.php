<?php

use App\Models\ProjectType;
use Illuminate\Support\Str;

$types = ProjectType::whereNull('slug')->orWhere('slug', '')->get();
$count = 0;

foreach ($types as $type) {
    $type->slug = Str::slug($type->name);
    
    // Ensure uniqueness
    $originalSlug = $type->slug;
    $suffix = 1;
    while (ProjectType::where('slug', $type->slug)->where('id', '!=', $type->id)->exists()) {
        $type->slug = "{$originalSlug}-" . $suffix++;
    }
    
    $type->save();
    $count++;
}

echo "Successfully updated {$count} project types with missing slugs.\n";
