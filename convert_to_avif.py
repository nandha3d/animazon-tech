"""
Convert all static PNG/JPG images to AVIF format for maximum compression.
Keeps originals as fallbacks for <picture> tags.
"""
import os
import sys
from pathlib import Path

try:
    import pillow_avif  # register AVIF plugin
except ImportError:
    pass

from PIL import Image

DIRS = [
    "public/assets/images/branding",
    "public/assets/images/landing/hero",
]

QUALITY = 45  # Good balance of quality vs size for photos
EXTENSIONS = {'.png', '.jpg', '.jpeg', '.webp'}

def convert_image(src_path: Path):
    """Convert a single image to AVIF."""
    avif_path = src_path.with_suffix('.avif')
    
    if avif_path.exists():
        print(f"  SKIP (exists): {avif_path.name}")
        return
    
    try:
        with Image.open(src_path) as img:
            # Convert RGBA to RGB for AVIF (no alpha needed for photos)
            if img.mode in ('RGBA', 'P', 'LA'):
                bg = Image.new('RGB', img.size, (0, 0, 0))
                if img.mode == 'P':
                    img = img.convert('RGBA')
                bg.paste(img, mask=img.split()[-1] if 'A' in img.mode else None)
                img = bg
            elif img.mode != 'RGB':
                img = img.convert('RGB')
            
            img.save(avif_path, format='AVIF', quality=QUALITY)
            
            orig_size = src_path.stat().st_size
            avif_size = avif_path.stat().st_size
            savings = (1 - avif_size / orig_size) * 100
            print(f"  OK: {src_path.name} -> {avif_path.name} "
                  f"({orig_size//1024}KB -> {avif_size//1024}KB, {savings:.0f}% smaller)")
    except Exception as e:
        print(f"  FAIL: {src_path.name} -> {e}")

def main():
    base = Path(os.path.dirname(os.path.abspath(__file__)))
    total_orig = 0
    total_avif = 0
    count = 0
    
    for dir_rel in DIRS:
        dir_path = base / dir_rel
        if not dir_path.exists():
            print(f"Directory not found: {dir_path}")
            continue
        
        print(f"\n=== {dir_rel} ===")
        for f in sorted(dir_path.iterdir()):
            if f.suffix.lower() in EXTENSIONS:
                convert_image(f)
                avif = f.with_suffix('.avif')
                if avif.exists():
                    total_orig += f.stat().st_size
                    total_avif += avif.stat().st_size
                    count += 1
    
    if count > 0:
        print(f"\n{'='*50}")
        print(f"Converted {count} images")
        print(f"Original total: {total_orig//1024}KB ({total_orig//(1024*1024)}MB)")
        print(f"AVIF total:     {total_avif//1024}KB ({total_avif//(1024*1024)}MB)")
        print(f"Savings:        {(1 - total_avif/total_orig)*100:.0f}%")

if __name__ == '__main__':
    main()
