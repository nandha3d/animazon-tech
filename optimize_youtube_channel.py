import os
import re
import sys
import json
import glob
import requests

if sys.stdout.encoding.lower() != 'utf-8':
    try:
        sys.stdout.reconfigure(encoding='utf-8')
    except Exception:
        pass
from PIL import Image, ImageDraw, ImageFont
from googleapiclient.discovery import build
from googleapiclient.http import MediaFileUpload
from google_auth_oauthlib.flow import InstalledAppFlow
from google.oauth2.credentials import Credentials
from google.auth.transport.requests import Request

SCOPES = ['https://www.googleapis.com/auth/youtube.force-ssl']
ANIMAZON_API_URL = "https://animazon.in/api/v1/affiliate/shorten"
DEFAULT_STORE_ID = "ramyadevikola-21"
TOKEN_FILE = "youtube_token.json"
REPORT_FILE = "youtube_seo_report.html"
THUMBNAILS_DIR = "generated_thumbnails"

os.makedirs(THUMBNAILS_DIR, exist_ok=True)

def find_client_secret():
    files = glob.glob("client_secret*.json")
    return files[0] if files else "client_secret.json"

def get_credentials():
    creds = None
    if os.path.exists(TOKEN_FILE):
        try:
            creds = Credentials.from_authorized_user_file(TOKEN_FILE, SCOPES)
        except Exception:
            creds = None

    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            try:
                creds.refresh(Request())
            except Exception:
                creds = None

        if not creds:
            secret_file = find_client_secret()
            if not os.path.exists(secret_file):
                print(f"Error: Client secret file '{secret_file}' not found.")
                return None

            print(f"Using OAuth secrets file: {secret_file}")
            flow = InstalledAppFlow.from_client_secrets_file(secret_file, SCOPES)
            
            with open(secret_file, 'r') as f:
                data = json.load(f)
            
            client_type = list(data.keys())[0]
            redirect_uris = data[client_type].get('redirect_uris', [])
            has_local = any('localhost' in uri or '127.0.0.1' in uri for uri in redirect_uris)
            
            if has_local or client_type == 'installed':
                creds = flow.run_local_server(port=8080)
            else:
                redirect_uri = redirect_uris[0] if redirect_uris else 'https://animazon.in'
                flow.redirect_uri = redirect_uri
                auth_url, _ = flow.authorization_url(prompt='consent')
                print("\n=======================================================")
                print("1. Open the following URL in your browser:")
                print(f"\n{auth_url}\n")
                print("2. Authorize the application.")
                print("3. Copy the full redirect URL (or authorization 'code=...' parameter).")
                print("=======================================================\n")
                
                user_input = None
                for arg in sys.argv:
                    if arg.startswith("--code="):
                        user_input = arg.split("--code=")[1].strip()

                if not user_input:
                    user_input = input("Paste full URL or code here: ").strip()

                code = user_input.split("code=")[1].split("&")[0] if "code=" in user_input else user_input
                flow.fetch_token(code=code)
                creds = flow.credentials

            with open(TOKEN_FILE, 'w') as token:
                token.write(creds.to_json())
            print("✅ Authorization successful! Token saved.")

    return creds

def extract_asin(url):
    match = re.search(r'/(?:dp|gp/product|d|ASIN)/([A-Z0-9]{10})', url, re.IGNORECASE)
    return match.group(1).upper() if match else None

def convert_url_to_animazon(amazon_url, video_title=None):
    asin = extract_asin(amazon_url)
    if not asin:
        match_end = re.search(r'/([A-Z0-9]{10})$', amazon_url, re.IGNORECASE)
        if match_end:
            asin = match_end.group(1).upper()

    # Expand amzn.to shortlinks if needed
    if not asin and ("amzn.to" in amazon_url or "buythebest.online" in amazon_url):
        try:
            resp = requests.get(amazon_url, allow_redirects=True, timeout=5)
            final_url = resp.url
            asin = extract_asin(final_url)
        except Exception:
            pass

    # Call Animazon API to save link in Database & Admin Panel
    try:
        res = requests.post(ANIMAZON_API_URL, json={
            "url": amazon_url,
            "asin": asin,
            "store_id": DEFAULT_STORE_ID,
            "title": video_title or (f"Product {asin}" if asin else "YouTube Affiliate Deal")
        }, timeout=8)
        data = res.json()
        if data.get("status") == "success" and data.get("short_link"):
            return data.get("short_link")
    except Exception as e:
        print(f"Admin Panel API Registration error: {e}")

    if asin:
        return f"https://animazon.in/buy/{asin}"

    return amazon_url

def create_high_ctr_thumbnail(video_id, title_text):
    """Generates a 1280x720 16:9 high-CTR custom thumbnail using original video image + Tamil font overlay"""
    width, height = 1280, 720
    
    # 1. Download original high-res video thumbnail from YouTube
    img_url = f"https://img.youtube.com/vi/{video_id}/maxresdefault.jpg"
    resp = requests.get(img_url)
    if resp.status_code != 200:
        img_url = f"https://img.youtube.com/vi/{video_id}/hqdefault.jpg"
        resp = requests.get(img_url)

    if resp.status_code == 200:
        from io import BytesIO
        img = Image.open(BytesIO(resp.content)).convert('RGB')
        img = img.resize((width, height), Image.Resampling.LANCZOS)
    else:
        img = Image.new('RGB', (width, height), color='#0f172a')

    draw = ImageDraw.Draw(img)

    # 2. Add subtle dark gradient overlay at bottom for high text readability
    overlay = Image.new('RGBA', (width, height), (0, 0, 0, 0))
    overlay_draw = ImageDraw.Draw(overlay)
    for y in range(350, height):
        alpha = int(((y - 350) / 370) * 220)
        overlay_draw.line([(0, y), (width, y)], fill=(15, 23, 42, alpha))

    img = Image.alpha_composite(img.convert('RGBA'), overlay).convert('RGB')
    draw = ImageDraw.Draw(img)

    # 3. Load Tamil supporting fonts
    tamil_fonts = ["C:\\Windows\\Fonts\\lathab.ttf", "C:\\Windows\\Fonts\\latha.ttf", "C:\\Windows\\Fonts\\Nirmala.ttc", "C:\\Windows\\Fonts\\arialbd.ttf"]
    font_path = "arialbd.ttf"
    for fp in tamil_fonts:
        if os.path.exists(fp):
            font_path = fp
            break

    try:
        badge_font = ImageFont.truetype(font_path, 32)
        title_font = ImageFont.truetype(font_path, 42)
        sub_font = ImageFont.truetype(font_path, 30)
    except IOError:
        badge_font = title_font = sub_font = ImageFont.load_default()

    # 4. Draw Top Badge
    draw.rectangle([50, 40, 480, 95], fill='#f43f5e') # Red accent badge
    draw.text((65, 48), "🔥 BEST PRICE & REVIEW", fill='white', font=badge_font)

    # 5. Clean Title Overlay (Tamil + English)
    clean_title = re.sub(r'[\(\[\{].*?[\)\]\}]', '', title_text).strip()
    words = clean_title.split()

    margin = 50
    offset = 480
    lines = []
    current_line = []

    for word in words:
        current_line.append(word)
        if len(" ".join(current_line)) > 26:
            lines.append(" ".join(current_line[:-1]))
            current_line = [word]
    if current_line:
        lines.append(" ".join(current_line))

    for line in lines[:2]:
        # Text shadow for maximum contrast
        draw.text((margin + 3, offset + 3), line, fill='black', font=title_font)
        draw.text((margin, offset), line, fill='#ffffff', font=title_font)
        offset += 55

    # 6. Bottom Banner
    draw.rectangle([50, offset + 10, 680, offset + 60], fill='#0284c7')
    draw.text((65, offset + 18), "⚡ CLICK DESCRIPTION FOR BUY LINK", fill='white', font=sub_font)

    output_path = os.path.join(THUMBNAILS_DIR, f"thumb_{video_id}.png")
    img.save(output_path)
    return output_path

def optimize_title_and_tags(original_title, original_desc, affiliate_links):
    clean_title = re.sub(r'[\(\[\{].*?[\)\]\}]', '', original_title).strip()
    
    # Catchy Title formatting
    if "review" not in clean_title.lower() and "unboxing" not in clean_title.lower():
        catchy_title = f"{clean_title} | Full Review & Best Deals 🔥"
    else:
        catchy_title = f"{clean_title} 🔥"

    if len(catchy_title) > 95:
        # Cleanly truncate without breaking words
        catchy_title = catchy_title[:90].rsplit(' ', 1)[0] + " 🔥"

    converted_links = []
    link_mapping = {}
    for link in set(affiliate_links):
        if "animazon.in" not in link:
            new_l = convert_url_to_animazon(link, video_title=original_title)
            link_mapping[link] = new_l
            converted_links.append((link, new_l))
        else:
            converted_links.append((link, link))

    new_desc = original_desc
    for old_l, new_l in link_mapping.items():
        new_desc = new_desc.replace(old_l, new_l)

    if "animazon.in" not in original_desc and converted_links:
        buy_section = "\n\n🛒 BUY DIRECTLY HERE (Best Price & Offers):\n"
        for _, n_link in converted_links:
            buy_section += f"👉 {n_link}\n"
        new_desc = buy_section + "\n" + new_desc

    words = re.findall(r'\b[A-Za-z0-9]{3,}\b', clean_title)
    tags = list(set([clean_title[:30]] + words + ["Amazon Deals", "Best Buy", "Product Review", "Animazon", "Shopping Guide"]))

    return {
        "title": catchy_title,
        "description": new_desc,
        "tags": tags[:15],
        "converted_links": converted_links
    }

def generate_html_report(results):
    html_content = f"""<!DOCTYPE html>
<html>
<head>
    <title>Full YouTube Channel Manager Report</title>
    <style>
        body {{ font-family: 'Segoe UI', Arial, sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; padding: 20px; }}
        h1 {{ color: #38bdf8; text-align: center; font-size: 24px; }}
        .summary {{ background: #1e293b; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 16px; border: 1px solid #334155; }}
        .card {{ background: #1e293b; border-radius: 10px; padding: 20px; margin-bottom: 20px; border: 1px solid #334155; box-shadow: 0 4px 6px rgba(0,0,0,0.3); }}
        .card-header {{ font-size: 18px; font-weight: bold; color: #f43f5e; margin-bottom: 10px; border-bottom: 1px solid #334155; padding-bottom: 8px; }}
        .field {{ margin-bottom: 12px; }}
        .label {{ font-weight: bold; color: #94a3b8; font-size: 12px; text-transform: uppercase; display: block; margin-bottom: 4px; }}
        .old-val {{ color: #f87171; text-decoration: line-through; margin-bottom: 4px; font-size: 14px; }}
        .new-val {{ color: #4ade80; font-size: 15px; font-weight: 600; }}
        .links-box {{ background: #0f172a; padding: 10px; border-radius: 6px; font-family: monospace; font-size: 13px; }}
        .link-row {{ margin-bottom: 6px; word-break: break-all; }}
        .tag {{ display: inline-block; background: #0284c7; color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px; margin-right: 5px; margin-bottom: 5px; }}
    </style>
</head>
<body>
    <h1>🎬 YouTube Channel Complete Automation & SEO Report</h1>
    <div class="summary">
        Total Videos Scanned: <strong>{len(results)}</strong> | Converted Links & SEO Updated: <strong>{sum(1 for r in results if r['has_changes'])}</strong>
    </div>
"""
    for r in results:
        html_content += f"""
    <div class="card">
        <div class="card-header">🎥 {r['original_title']} (ID: {r['video_id']})</div>
        <div class="field">
            <span class="label">Catchy Title Optimization</span>
            <div class="old-val">Old: {r['original_title']}</div>
            <div class="new-val">New: {r['new_title']}</div>
        </div>
        <div class="field">
            <span class="label">Converted Affiliate Shortlinks ({len(r['converted_links'])})</span>
            <div class="links-box">
"""
        for old_l, new_l in r['converted_links']:
            html_content += f'<div class="link-row"><span style="color:#ef4444">{old_l}</span> ➔ <a href="{new_l}" target="_blank" style="color:#38bdf8">{new_l}</a></div>'
        
        tags_html = "".join([f'<span class="tag">{t}</span>' for t in r['tags']])
        html_content += f"""
            </div>
        </div>
        <div class="field">
            <span class="label">Generated SEO Keyword Tags</span>
            <div>{tags_html}</div>
        </div>
    </div>
"""
    html_content += "</body></html>"
    
    with open(REPORT_FILE, "w", encoding="utf-8") as f:
        f.write(html_content)
    print(f"\n📊 Detailed HTML SEO Report saved to: {REPORT_FILE}")

def run_channel_optimization(apply_changes=False, max_videos=2):
    creds = get_credentials()
    if not creds:
        return

    youtube = build('youtube', 'v3', credentials=creds)

    print("\nFetching YouTube Channel details...")
    channel_res = youtube.channels().list(mine=True, part='contentDetails,snippet').execute()
    if not channel_res.get('items'):
        print("No YouTube channel found.")
        return

    channel_title = channel_res['items'][0]['snippet']['title']
    uploads_playlist_id = channel_res['items'][0]['contentDetails']['relatedPlaylists']['uploads']
    print(f"Connected to Channel: {channel_title}")
    print(f"Processing ONLY {max_videos} video(s) for initial review...\n")

    next_page_token = None
    results = []

    while len(results) < max_videos:
        playlist_res = youtube.playlistItems().list(
            playlistId=uploads_playlist_id,
            part='snippet',
            maxResults=min(50, max_videos - len(results)),
            pageToken=next_page_token
        ).execute()

        items = playlist_res.get('items', [])
        if not items:
            break

        v_ids = [item['snippet']['resourceId']['videoId'] for item in items]
        videos_res = youtube.videos().list(id=",".join(v_ids), part='snippet').execute()

        for video in videos_res.get('items', []):
            if len(results) >= max_videos:
                break

            v_id = video['id']
            snippet = video['snippet']
            orig_title = snippet['title']
            orig_desc = snippet.get('description', '')
            category_id = snippet.get('categoryId', '22')

            aff_links = re.findall(r'https?://(?:www\.)?(?:amazon\.in|amzn\.to|buythebest\.online)[^\s"\']+', orig_desc)
            
            opt = optimize_title_and_tags(orig_title, orig_desc, aff_links)

            has_changes = (opt['title'] != orig_title) or (opt['description'] != orig_desc) or bool(opt['converted_links'])

            results.append({
                "video_id": v_id,
                "original_title": orig_title,
                "new_title": opt['title'],
                "original_desc": orig_desc,
                "new_desc": opt['description'],
                "tags": opt['tags'],
                "converted_links": opt['converted_links'],
                "has_changes": has_changes,
                "category_id": category_id
            })

            print(f"Processed Video [{len(results)}/{max_videos}]: {orig_title}")
            print(f"  -> Converted {len(opt['converted_links'])} affiliate shortlinks")

            if apply_changes:
                if has_changes:
                    snippet['title'] = opt['title']
                    snippet['description'] = opt['description']
                    snippet['tags'] = opt['tags']
                    
                    youtube.videos().update(
                        part='snippet',
                        body={
                            'id': v_id,
                            'snippet': snippet
                        }
                    ).execute()
                    print(f"  ✅ UPDATED LIVE ON YOUTUBE (Title, Desc & Links): {v_id}")

        next_page_token = playlist_res.get('nextPageToken')
        if not next_page_token:
            break

    generate_html_report(results)
    if not apply_changes:
        print(f"\nMODE: Preview (Dry Run for {len(results)} videos). Run with `--apply` to update these 2 videos live on YouTube.")

if __name__ == "__main__":
    import sys
    apply_mode = "--apply" in sys.argv
    video_limit = 2
    for arg in sys.argv:
        if arg.startswith("--limit="):
            try:
                video_limit = int(arg.split("--limit=")[1])
            except ValueError:
                pass
    run_channel_optimization(apply_changes=apply_mode, max_videos=video_limit)
