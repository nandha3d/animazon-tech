@php
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);
    $langType = $langType ?? 'none';
    $langNameLocal = $langNameLocal ?? 'Local';
@endphp

<style>
  /* Standardized Animazon Studio Brand Header */
  .animazon-brand-header {
    background: var(--brand-surface, #ffffff);
    border: 1px solid var(--brand-border, #e2e8f0);
    border-radius: 16px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.25rem;
    transition: all 0.3s ease;
  }
  
  :root[data-theme="dark"] .animazon-brand-header,
  [data-theme="dark"] .animazon-brand-header,
  [data-theme-root="dark"] .animazon-brand-header {
    background: #1e293b;
    border-color: #334155;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }

  .brand-identity {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .brand-logo-img {
    max-height: 48px;
    width: auto;
    object-fit: contain;
  }

  .logo-for-light { display: block !important; }
  .logo-for-dark { display: none !important; }
  :root[data-theme="dark"] .logo-for-light,
  [data-theme="dark"] .logo-for-light,
  [data-theme-root="dark"] .logo-for-light { display: none !important; }
  :root[data-theme="dark"] .logo-for-dark,
  [data-theme="dark"] .logo-for-dark,
  [data-theme-root="dark"] .logo-for-dark { display: block !important; }

  .brand-text {
    border-left: 2px solid var(--brand-border, #cbd5e1);
    padding-left: 1rem;
    margin-left: 0.25rem;
  }
  :root[data-theme="dark"] .brand-text,
  [data-theme="dark"] .brand-text,
  [data-theme-root="dark"] .brand-text { border-left-color: #334155 !important; }

  .brand-text span {
    font-size: 0.8rem;
    color: var(--brand-muted, #64748b);
    font-weight: 600;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  :root[data-theme="dark"] .brand-text span,
  [data-theme="dark"] .brand-text span,
  [data-theme-root="dark"] .brand-text span { color: #94a3b8; }

  .brand-text strong {
    font-size: 0.95rem;
    color: var(--brand-ink, #0f172a);
    font-weight: 800;
  }
  :root[data-theme="dark"] .brand-text strong,
  [data-theme="dark"] .brand-text strong,
  [data-theme-root="dark"] .brand-text strong { color: #f8fafc; }

  .brand-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
  }

  .btn-brand-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid var(--brand-border-strong, #cbd5e1);
    background: var(--brand-surface, #ffffff);
    color: var(--brand-ink, #0f172a);
  }

  :root[data-theme="dark"] .btn-brand-action,
  [data-theme="dark"] .btn-brand-action,
  [data-theme-root="dark"] .btn-brand-action {
    background: #0f172a;
    border-color: #475569;
    color: #f8fafc;
  }

  .btn-brand-action:hover {
    transform: translateY(-1px);
    border-color: #3b82f6;
    color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
  }

  .btn-brand-primary {
    background: #1d4ed8 !important;
    border-color: #1d4ed8 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(29, 78, 216, 0.25);
  }

  .btn-brand-primary:hover {
    background: #1e3a8a !important;
    color: #ffffff !important;
  }

  .btn-lang-switch {
    background: rgba(59, 130, 246, 0.1) !important;
    border-color: #3b82f6 !important;
    color: #2563eb !important;
    font-weight: 700;
  }
  :root[data-theme="dark"] .btn-lang-switch,
  [data-theme="dark"] .btn-lang-switch,
  [data-theme-root="dark"] .btn-lang-switch {
    color: #60a5fa !important;
  }
  .btn-lang-switch:hover {
    background: #3b82f6 !important;
    color: #ffffff !important;
  }

  @media print {
    .animazon-brand-header { display: none !important; }
  }
</style>

<div class="animazon-brand-header no-print">
  <div class="brand-identity">
    <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
      <img src="{{ \App\Models\Utility::get_file('uploads/logo/logo-dark.png') }}" alt="Animazon Logo" class="brand-logo-img logo-for-light">
      <img src="{{ \App\Models\Utility::get_file('uploads/logo/logo-light.png') }}" alt="Animazon Logo" class="brand-logo-img logo-for-dark">
    </a>
    <div class="brand-text">
      <span>Interactive Proposal Portal</span>
      <strong>Proposal #{{ \Auth::user() ? \Auth::user()->proposalNumberFormat($proposal->proposal_id) : $proposal->proposal_id }}</strong>
    </div>
  </div>

  <div class="brand-actions">
    @if($langType !== 'none')
      <button type="button" class="btn-brand-action btn-lang-switch" id="btnLangToggle" onclick="toggleProposalLanguage('{{ $langType }}')">
        <span id="langIcon">🇮🇳</span> <span id="langText">Switch to {{ $langNameLocal }}</span>
      </button>
    @endif

    <button type="button" class="btn-brand-action" onclick="toggleProposalTheme()">
      <span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span>
    </button>

    <button type="button" class="btn-brand-action" id="btnReadAloudBrand"
            data-role="proposal-read-aloud"
            data-tts-audio-url="{{ $audioUrlEn ?? $proposal->getTtsAudioUrl('en') }}"
            data-tts-segments="{{ $segmentsEn ?? '[]' }}"
            data-tts-audio-url-local="{{ $audioUrlLocal ?? '' }}"
            data-tts-segments-local="{{ $segmentsLocal ?? '[]' }}">
      🔊 Read Aloud
    </button>

    <a href="{{ route('proposal.pdf', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)) }}" target="_blank" class="btn-brand-action btn-brand-primary">
      🖨️ Download PDF
    </a>
  </div>
</div>

<script>
  function toggleProposalTheme() {
    var htmlRoot = document.documentElement;
    var container = document.querySelector('[data-theme-root]') || document.querySelector('.rudra-view-container') || document.querySelector('.kpsta-view-container') || htmlRoot;
    var icon = document.getElementById('themeIcon');
    var text = document.getElementById('themeText');
    var current = htmlRoot.getAttribute('data-theme') || container.getAttribute('data-theme') || 'light';
    
    var nextTheme = (current === 'light') ? 'dark' : 'light';
    
    htmlRoot.setAttribute('data-theme', nextTheme);
    document.querySelectorAll('[data-theme-root], .rudra-view-container, .kpsta-view-container').forEach(function(el) {
      el.setAttribute('data-theme', nextTheme);
    });
    
    if (nextTheme === 'dark') {
      if(icon) icon.innerText = '☀️';
      if(text) text.innerText = 'Light Mode';
      localStorage.setItem('animazon_theme', 'dark');
    } else {
      if(icon) icon.innerText = '🌙';
      if(text) text.innerText = 'Dark Mode';
      localStorage.setItem('animazon_theme', 'light');
    }
  }

  function toggleProposalLanguage(langType) {
    var paneEn = document.getElementById('pane-en') || document.getElementById('rudra-doc-en');
    var paneLocal = document.getElementById('pane-' + langType) || document.getElementById('rudra-doc-' + langType);
    var langText = document.getElementById('langText');
    var langIcon = document.getElementById('langIcon');
    var btnReadAloud = document.getElementById('btnReadAloudBrand');
    
    if (!paneEn || !paneLocal) return;

    if ((paneEn.style.display !== 'none' && !paneEn.hidden) || (paneEn.style.display === 'block')) {
      // Switch to Local Language
      paneEn.style.display = 'none';
      paneEn.hidden = true;
      paneLocal.style.display = 'block';
      paneLocal.hidden = false;
      if(langText) langText.innerText = 'Switch to English';
      if(langIcon) langIcon.innerText = '🇬🇧';
      
      // Update TTS button attributes for local language
      if (btnReadAloud && btnReadAloud.getAttribute('data-tts-audio-url-local')) {
        btnReadAloud.setAttribute('data-tts-audio-url', btnReadAloud.getAttribute('data-tts-audio-url-local'));
        btnReadAloud.setAttribute('data-tts-segments', btnReadAloud.getAttribute('data-tts-segments-local'));
      }
    } else {
      // Switch to English
      paneLocal.style.display = 'none';
      paneLocal.hidden = true;
      paneEn.style.display = 'block';
      paneEn.hidden = false;
      if(langText) langText.innerText = 'Switch to ' + (langType === 'ml' ? 'മലയാളം (Malayalam)' : 'हिन्दी (Hindi)');
      if(langIcon) langIcon.innerText = '🇮🇳';
      
      // Revert TTS button attributes to English
      if (btnReadAloud && btnReadAloud.getAttribute('data-tts-audio-url-en-orig')) {
        btnReadAloud.setAttribute('data-tts-audio-url', btnReadAloud.getAttribute('data-tts-audio-url-en-orig'));
        btnReadAloud.setAttribute('data-tts-segments', btnReadAloud.getAttribute('data-tts-segments-en-orig'));
      }
    }
  }

  // Save original English TTS attributes on load
  document.addEventListener('DOMContentLoaded', function() {
    var btnReadAloud = document.getElementById('btnReadAloudBrand');
    if (btnReadAloud) {
      btnReadAloud.setAttribute('data-tts-audio-url-en-orig', btnReadAloud.getAttribute('data-tts-audio-url'));
      btnReadAloud.setAttribute('data-tts-segments-en-orig', btnReadAloud.getAttribute('data-tts-segments'));
    }

    // Restore theme
    var savedTheme = localStorage.getItem('animazon_theme');
    if (savedTheme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      document.querySelectorAll('[data-theme-root], .rudra-view-container, .kpsta-view-container').forEach(function(el) {
        el.setAttribute('data-theme', 'dark');
      });
      var icon = document.getElementById('themeIcon');
      var text = document.getElementById('themeText');
      if(icon) icon.innerText = '☀️';
      if(text) text.innerText = 'Light Mode';
    }
  });
</script>
