<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="Amazon Deal">
    <meta property="og:description" content="Click to open this deal in the Amazon App.">
    <meta property="og:image" content="https://animazon.in/images/amazon-logo.png">

    @if($deviceType === 'android')
    <script>
        // Mimic OpeninApp's aggressive intent launch
        window.onload = function() {
            setTimeout(function() {
                window.location.replace("{!! $androidIntent !!}");
            }, 300);
        };
    </script>
    @endif

    <title>Open in Amazon App</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0a0e17;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            background: linear-gradient(145deg, #141b2d 0%, #1a2332 100%);
            border: 1px solid rgba(255, 153, 0, 0.25);
            border-radius: 20px;
            padding: 32px 24px 28px;
            max-width: 360px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
        }
        .amazon-icon {
            width: 60px; height: 60px;
            margin: 0 auto 18px;
            background: linear-gradient(135deg, #ff9900, #e88b00);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(255, 153, 0, 0.35);
        }
        .amazon-icon svg { width: 34px; height: 34px; fill: #000; }
        h1 { font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 6px; }
        p { font-size: .88rem; color: #94a3b8; line-height: 1.4; margin-bottom: 24px; }
        
        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: linear-gradient(135deg, #ff9900, #d97706);
            color: #000; font-weight: 800; font-size: 1.05rem;
            padding: 16px 20px; border-radius: 14px;
            text-decoration: none; margin-bottom: 14px;
            box-shadow: 0 4px 18px rgba(255, 153, 0, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 4px 18px rgba(255, 153, 0, 0.4); }
            50% { transform: scale(1.02); box-shadow: 0 6px 24px rgba(255, 153, 0, 0.6); }
        }
        .btn-sec {
            display: block; width: 100%;
            padding: 12px 16px; border-radius: 10px;
            text-decoration: none; font-size: .85rem; font-weight: 600;
            color: #94a3b8; background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            transition: background 0.15s;
        }
        .btn-sec:active { background: rgba(255,255,255,.1); }
        .foot { margin-top: 20px; font-size: .68rem; color: #475569; letter-spacing: 0.3px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="amazon-icon">
            <svg viewBox="0 0 24 24">
                <path d="M1.04 17.52q.1-.16.32-.02a21.2 21.2 0 0010.88 2.9c3.2 0 6.32-.89 8.9-2.56.4-.26.76.18.4.54C19.75 20.33 16.2 21.5 12.5 21.5c-4.15 0-8.15-1.37-11.12-3.72-.16-.12-.2-.24-.34-.26zM22.54 16.67c-.36-.46-2.38-.22-3.3-.11-.28.04-.32-.2-.08-.38 1.6-1.12 4.26-.8 4.56-.42.3.38-.08 3.04-1.58 4.3-.22.2-.44.1-.34-.16.34-.84 1.1-2.76.74-3.23z"/>
                <path d="M13.4 10.48c0-1.58.04-2.9-.76-4.3-.64-1.12-1.66-1.82-2.78-1.82-1.54 0-2.46 1.18-2.46 2.92 0 3.44 3.08 4.06 6 4.06v-.86zM19.42 14.06c-.26.24-.64.26-.94.1-.66-.56-.78-.82-1.14-1.34-1.1 1.12-1.86 1.46-3.3 1.46-1.68 0-3-1.04-3-3.12 0-1.62.88-2.74 2.14-3.28 1.08-.48 2.6-.56 3.76-.7v-.26c0-.48.04-1.04-.24-1.46-.24-.36-.72-.52-1.14-.52-.78 0-1.46.4-1.64 1.22-.04.18-.16.36-.34.36l-1.88-.2c-.16-.04-.34-.16-.28-.4C11.84 4.02 13.8 3.5 15.56 3.5c.9 0 2.08.24 2.78.92.9.84.82 1.96.82 3.18v2.88c0 .86.36 1.24.7 1.72.12.16.14.36 0 .48l-1.44 1.38z"/>
            </svg>
        </div>

        <h1>Open in Amazon App</h1>
        <p>Tap below to view product deal directly in the Amazon Shopping app</p>

        @if($deviceType === 'android')
            <!-- Method 1: Standard App Link with target="_blank" -->
            <a href="{{ $androidAppLink }}" target="_blank" class="btn-primary" style="margin-bottom: 12px;">⚡ Open in Amazon App</a>
            <!-- Method 2: Custom URI Scheme -->
            <a href="com.amazon.mobile.shopping.web://www.amazon.in/dp/{{ $asin }}?tag={{ $tag }}" class="btn-sec" style="margin-bottom: 12px; background: rgba(255,153,0,0.1); border-color: rgba(255,153,0,0.2); color: #ff9900;">Fallback 1 (Custom URI)</a>
            <!-- Method 3: Explicit Intent with ACTION_VIEW -->
            <a href="{{ $androidIntent }}" class="btn-sec" style="background: rgba(255,153,0,0.1); border-color: rgba(255,153,0,0.2); color: #ff9900;">Fallback 2 (Explicit Intent)</a>
        @else
            <a href="{{ $iosScheme }}" class="btn-primary">⚡ Open in Amazon App</a>
        @endif

        <a href="{{ $finalUrl }}" class="btn-sec">🌐 Continue in Web Browser</a>
        <div class="foot">Powered by animazon.in</div>
    </div>
</body>
</html>
