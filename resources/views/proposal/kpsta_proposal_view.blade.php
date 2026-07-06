@php
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);
    $totalDue = $proposal->getDue() > 0 ? $proposal->getDue() : 7000;
    $totalPaid = $proposal->amountPaid();
    $isExpired = $proposal->isExpired();
    $isAccepted = $proposal->isAccepted();
    $isDeclined = $proposal->isDeclined();
    $isPending = !$isAccepted && !$isDeclined;

    $kpstaSegmentsEn = [
        "Website Development and Maintenance Proposal for Kerala Pradesh School Teacher's Association, K.P.S.T.A.",
        "Section 1: Project Scope. We are developing a modern, responsive static website for K.P.S.T.A., complete with a custom Admin Panel. This admin panel will allow your leadership team to easily upload and manage photo galleries, PDF circulars and academic documents, and association news and announcements.",
        "Section 2: Zero Hosting Charges and GitHub Repo Handover. Total website development fee is quoted at a fixed price of 7,000 rupees. Because your association maintains its own server infrastructure, no hosting or server fees are charged from our side! Upon completion, our policy is to simply hand over the complete GitHub repository containing all source code and admin panel files directly to your team, granting you 100 percent independent ownership.",
        "Section 3: One Month Free Maintenance Scope. Following site handover and launch, we include 1 full month of complimentary maintenance. This free maintenance covers technical bug fixes, display troubleshooting, security checks, and a single one-time admin panel demonstration for your staff. New feature additions or major redesigns outside the agreed scope will be quoted separately.",
        "Section 4: Payment Terms and Options. Total project fee is 7,000 rupees. We offer two convenient payment plans: Option A is a 50 percent advance payment of 3,500 rupees to commence development, with the remaining 3,500 rupees due upon completion and handover. Option B is a 100 percent upfront payment of 7,000 rupees for streamlined priority development.",
        "Section 5: Next Steps. To initiate development, simply approve this proposal and select your preferred payment option below. We look forward to building a prestigious online home for Kerala's teachers!"
    ];

    $kpstaSegmentsMl = [
        "കേരള പ്രദേശ് സ്കൂൾ ടീച്ചേഴ്സ് അസോസിയേഷൻ, കെ.പി.എസ്.ടി.എ-യ്ക്ക് വേണ്ടിയുള്ള വെബ്സൈറ്റ് വികസനവും പരിപാലനവും സംബന്ധിച്ച കരാർ.",
        "ഭാഗം 1: പ്രോജക്റ്റ് വിവരണം. കെ.പി.എസ്.ടി.എ-യ്ക്ക് വേണ്ടി അതിവേഗവും സുരക്ഷിതവുമായ ഒരു സ്റ്റാറ്റിക് വെബ്സൈറ്റും അത് എളുപ്പത്തിൽ നിയന്ത്രിക്കാനുള്ള കസ്റ്റം അഡ്മിൻ പാനലും ഞങ്ങൾ വികസിപ്പിക്കുന്നു. ഫോട്ടോ ഗാലറികൾ, പി.ഡി.എഫ് സർക്കുലറുകൾ, വാർത്തകളും അറിയിപ്പുകളും കോഡിംഗ് അറിവില്ലാതെ തന്നെ അഡ്മിൻ പാനൽ വഴി എളുപ്പത്തിൽ കൈകാര്യം ചെയ്യാം.",
        "ഭാഗം 2: ഹോസ്റ്റിംഗ് ചാർജുകൾ ഇല്ല, ഗിറ്റ്‌ഹബ് കൈമാറ്റം. ആകെ നിർമ്മാണ ചെലവ് 7,000 രൂപയാണ്. കെ.പി.എസ്.ടി.എ സ്വന്തമായി സെർവർ പരിപാലിക്കുന്നതിനാൽ ഞങ്ങളുടെ ഭാഗത്തുനിന്ന് വാർഷിക ഹോസ്റ്റിംഗ് ചാർജുകളോ റിന്യൂവൽ ഫീസോ ഈടാക്കുന്നതല്ല! നിർമ്മാണം പൂർത്തിയായ ശേഷം വെബ്സൈറ്റിന്റെയും അഡ്മിൻ പാനലിന്റെയും പൂർണ്ണ ഗിറ്റ്‌ഹബ് റെപ്പോസിറ്ററി സംഘടനയ്ക്ക് കൈമാറുന്നതാണ്.",
        "ഭാഗം 3: 1 മാസത്തെ സൗജന്യ പരിപാലനം. വെബ്സൈറ്റ് ലോഞ്ച് ചെയ്തതിനു ശേഷം 1 മാസത്തേക്ക് പൂർണ്ണ സൗജന്യ സാങ്കേതിക പരിപാലനം നൽകുന്നു. സാങ്കേതിക തകരാറുകൾ പരിഹരിക്കൽ, സുരക്ഷാ പരിശോധന, അഡ്മിൻ പാനൽ ഉപയോഗിക്കാൻ ജീവനക്കാർക്കായി ഒറ്റത്തവണ ഡെമോ (Demo) നൽകൽ എന്നിവ ഇതിൽ ഉൾപ്പെടുന്നു.",
        "ഭാഗം 4: പേയ്മെന്റ് ഓപ്ഷനുകൾ. ആകെ തുക 7,000 രൂപയാണ്. രണ്ട് പേയ്മെന്റ് രീതികൾ ലഭ്യമാണ്: ഓപ്ഷൻ എ - ജോലി ആരംഭിക്കാൻ 3,500 രൂപ അഡ്വാൻസ് നൽകുക, ബാക്കി 3,500 രൂപ വെബ്സൈറ്റ് പൂർത്തിയായി കൈമാറിയ ശേഷം നൽകാം. ഓപ്ഷൻ ബി - പ്രോജക്റ്റിന് മുൻഗണന ലഭിക്കാൻ 7,000 രൂപ മുഴുവൻ തുകയും ഒന്നിച്ച് അടയ്ക്കാം.",
        "ഭാഗം 5: അടുത്ത പടികൾ. പ്രോജക്റ്റ് ആരംഭിക്കുന്നതിനായി താഴെ കാണുന്ന അംഗീകരിക്കുക ബട്ടൺ ക്ലിക്ക് ചെയ്ത് പേയ്മെന്റ് രീതി തിരഞ്ഞെടുക്കാം. കേരളത്തിലെ അദ്ധ്യാപക സമൂഹത്തിനായി മികച്ചൊരു വെബ്സൈറ്റ് നിർമ്മിക്കാൻ ഞങ്ങൾ സദാ സജ്ജമാണ്!"
    ];
@endphp

<style>
  :root, :root[data-theme="light"] {
    --kpsta-bg: #fefcf9;
    --kpsta-surface: #ffffff;
    --kpsta-ink: #0f172a;
    --kpsta-muted: #475569;
    --kpsta-border: #e2e8f0;
    --kpsta-border-strong: #cbd5e1;
    --kpsta-accent: #0c4a5c;
    --kpsta-accent-deep: #043e49;
    --kpsta-accent-soft: #e0f2fe;
    --kpsta-good: #2e9e14;
    --kpsta-good-soft: #f0fdf4;
    --kpsta-orange: #f37835;
    --kpsta-orange-soft: #fff7ed;
    --kpsta-danger: #dc2626;
    --kpsta-danger-soft: #fef2f2;
    --kpsta-shadow: 0 4px 20px -4px rgba(4, 62, 73, 0.08);
    --kpsta-maxw: 72rem;
  }

  :root[data-theme="dark"], [data-theme="dark"], [data-theme-root="dark"] {
    --kpsta-bg: #041f25;
    --kpsta-surface: #0a2d37;
    --kpsta-ink: #f8fafc;
    --kpsta-muted: #94a3b8;
    --kpsta-border: #154a59;
    --kpsta-border-strong: #226477;
    --kpsta-accent: #38bdf8;
    --kpsta-accent-deep: #7dd3fc;
    --kpsta-accent-soft: rgba(56, 189, 248, 0.15);
    --kpsta-good: #4ade80;
    --kpsta-good-soft: rgba(74, 222, 128, 0.15);
    --kpsta-orange: #fb923c;
    --kpsta-orange-soft: rgba(251, 146, 60, 0.15);
    --kpsta-danger: #f87171;
    --kpsta-danger-soft: rgba(248, 113, 113, 0.15);
    --kpsta-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.4);
  }

  .kpsta-view-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--kpsta-ink);
    background-color: var(--kpsta-bg);
    line-height: 1.68;
    -webkit-font-smoothing: antialiased;
    font-variant-numeric: tabular-nums;
    padding: 0 0 6.5rem;
    min-height: 100vh;
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  .kpsta-view-container .wrap { max-width: var(--kpsta-maxw); margin: 0 auto; padding: 1.5rem 1.5rem 6.5rem; }
  .kpsta-view-container .lang-ml { font-family: 'Manjari', 'AnjaliOldLipi', 'Inter', sans-serif; line-height: 1.8; }

  .kpsta-view-container .sheet { 
    background: var(--kpsta-surface); 
    border: 1px solid var(--kpsta-border); 
    border-radius: 14px; 
    box-shadow: var(--kpsta-shadow); 
    overflow: hidden;
    position: relative;
  }
  .kpsta-view-container .sheet::before {
    content: "";
    display: block;
    height: 5px;
    background: linear-gradient(to right, var(--kpsta-orange) 0%, #ffffff 50%, var(--kpsta-good) 100%);
  }
  .kpsta-view-container .sheet-pad { padding: clamp(1.5rem, 4vw, 3.5rem); }
  .kpsta-view-container [hidden] { display: none !important; }

  .kpsta-view-container .mast { border-bottom: 1px solid var(--kpsta-border); padding-bottom: 1.75rem; }
  .kpsta-view-container .eyebrow { font-size: 0.75rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--kpsta-accent); font-weight: 700; margin: 0 0 0.55rem; display: flex; align-items: center; gap: 0.55rem; }
  .kpsta-view-container .eyebrow::before { content: ""; width: 1.6rem; height: 3px; background: var(--kpsta-orange); display: inline-block; border-radius: 2px; }
  .kpsta-view-container h1 { font-family: 'Outfit', sans-serif; font-size: clamp(1.6rem, 4.4vw, 2.35rem); line-height: 1.18; margin: 0; letter-spacing: -0.015em; font-weight: 700; color: var(--kpsta-ink); }
  .kpsta-view-container .lang-ml h1 { line-height: 1.38; }
  .kpsta-view-container .sub { color: var(--kpsta-muted); margin: 0.6rem 0 0; font-size: 1.05rem; line-height: 1.6; }

  .kpsta-view-container .meta { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem 2rem; margin-top: 1.75rem; background: var(--kpsta-accent-soft); padding: 1.25rem 1.5rem; border-radius: 12px; border: 1px solid var(--kpsta-border); }
  @media (max-width: 48rem) { .kpsta-view-container .meta { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 32rem) { .kpsta-view-container .meta { grid-template-columns: 1fr; } }
  .kpsta-view-container .meta div { display: flex; flex-direction: column; gap: 0.2rem; }
  .kpsta-view-container .meta dt { font-size: 0.71rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--kpsta-muted); font-weight: 700; margin: 0; }
  .kpsta-view-container .meta dd { margin: 0; font-weight: 700; color: var(--kpsta-ink); font-size: 1rem; }

  .kpsta-view-container section { margin-top: 2.5rem; }
  .kpsta-view-container h2 { font-family: 'Outfit', sans-serif; font-size: 1.2rem; margin: 0 0 1rem; line-height: 1.4; display: flex; align-items: center; gap: 0.65rem; color: var(--kpsta-ink); font-weight: 700; }
  .kpsta-view-container h2 .n { background: var(--kpsta-accent); color: #fff; font-size: 0.85rem; font-weight: 800; font-variant-numeric: tabular-nums; border-radius: 8px; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; flex: none; box-shadow: 0 2px 6px rgba(12, 74, 92, 0.25); }
  .kpsta-view-container p { margin: 0.7rem 0; color: var(--kpsta-ink); font-size: 0.96rem; }
  .kpsta-view-container strong { font-weight: 700; }

  /* pills */
  .kpsta-view-container .pill { display: inline-block; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.02em; padding: 0.15rem 0.6rem; border-radius: 999px; white-space: nowrap; }
  .kpsta-view-container .pill.paid { background: var(--kpsta-good-soft); color: var(--kpsta-good); border: 1px solid rgba(46,158,20,0.2); }
  .kpsta-view-container .pill.due { background: var(--kpsta-orange-soft); color: var(--kpsta-orange); border: 1px solid rgba(243,120,53,0.2); }
  .kpsta-view-container .pill.out { background: var(--kpsta-danger-soft); color: var(--kpsta-danger); border: 1px solid rgba(220,38,38,0.2); }
  .kpsta-view-container .pill.good { background: var(--kpsta-good-soft); color: var(--kpsta-good); border: 1px solid rgba(46,158,20,0.2); }

  /* tables */
  .kpsta-view-container table.why { width: 100%; border-collapse: collapse; margin: 0.75rem 0; font-size: 0.93rem; border: 1px solid var(--kpsta-border); border-radius: 10px; overflow: hidden; }
  .kpsta-view-container table.why th, .kpsta-view-container table.why td { text-align: left; padding: 0.85rem 1rem; vertical-align: top; border-bottom: 1px solid var(--kpsta-border); line-height: 1.6; color: var(--kpsta-ink); }
  .kpsta-view-container table.why thead th { font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--kpsta-muted); font-weight: 700; border-bottom: 2px solid var(--kpsta-border-strong); background: var(--kpsta-accent-soft); }
  .kpsta-view-container table.why tbody tr:last-child td { border-bottom: none; }
  .kpsta-view-container table.why tbody tr:hover { background: rgba(0,0,0,0.015); }
  .kpsta-view-container table.why td:first-child { font-weight: 700; color: var(--kpsta-ink); }
  .kpsta-view-container .tbl-scroll { overflow-x: auto; margin: 0.75rem 0; border: 1px solid var(--kpsta-border); border-radius: 10px; }

  /* payment summary */
  .kpsta-view-container .pay { margin-top: 1.5rem; border: 1px solid var(--kpsta-border-strong); border-radius: 12px; overflow: hidden; background: var(--kpsta-surface); }
  .kpsta-view-container .pay table { width: 100%; border-collapse: collapse; margin: 0; }
  .kpsta-view-container .pay th, .kpsta-view-container .pay td { padding: 0.85rem 1.1rem; text-align: left; border-bottom: 1px solid var(--kpsta-border); }
  .kpsta-view-container .pay thead th { font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--kpsta-muted); font-weight: 700; background: var(--kpsta-accent-soft); border-bottom: 1px solid var(--kpsta-border-strong); }
  .kpsta-view-container .pay td.amt, .kpsta-view-container .pay th.amt { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; font-weight: 700; color: var(--kpsta-ink); }
  .kpsta-view-container .pay td.item { font-weight: 700; color: var(--kpsta-ink); }
  .kpsta-view-container .pay tr.ref td { color: var(--kpsta-muted); font-weight: 500; }
  .kpsta-view-container .pay tr.ref td.item { font-weight: 700; color: var(--kpsta-ink); }
  .kpsta-view-container .pay tr.total td { border-bottom: none; background: linear-gradient(180deg, var(--kpsta-accent-soft), transparent); font-size: 1.1rem; }
  .kpsta-view-container .pay tr.total td.item { font-weight: 800; letter-spacing: -0.01em; color: var(--kpsta-ink); }
  .kpsta-view-container .pay tr.total td.amt { font-size: 1.6rem; font-weight: 800; color: var(--kpsta-accent); }
  .kpsta-view-container .pay .cur { opacity: 0.7; margin-right: 0.05rem; }
  .kpsta-view-container .pay .muted { display: block; color: var(--kpsta-muted); font-size: 0.82rem; font-weight: 500; margin-top: 0.25rem; line-height: 1.5; }
  .kpsta-view-container .pay-note { padding: 0.85rem 1.1rem; font-size: 0.88rem; color: var(--kpsta-muted); margin: 0; line-height: 1.6; border-top: 1px dashed var(--kpsta-border-strong); background: var(--kpsta-bg); }
  .kpsta-view-container .pay-note b { color: var(--kpsta-ink); }

  .kpsta-view-container .savings { display: flex; align-items: center; gap: 0.85rem; margin: 1.25rem 0 0; padding: 1rem 1.25rem; border-radius: 10px; background: var(--kpsta-good-soft); border: 1px solid var(--kpsta-good); }
  .kpsta-view-container .savings .tick { flex: none; width: 2rem; height: 2rem; border-radius: 50%; background: var(--kpsta-good); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; }
  .kpsta-view-container .savings p { margin: 0; font-size: 0.96rem; line-height: 1.5; color: var(--kpsta-ink); }
  .kpsta-view-container .savings b { color: var(--kpsta-good); font-weight: 800; }

  .kpsta-view-container ol.terms { margin: 0.75rem 0; padding-left: 0; counter-reset: t; list-style: none; display: flex; flex-direction: column; gap: 0.85rem; }
  .kpsta-view-container ol.terms li { position: relative; padding-left: 2.35rem; counter-increment: t; line-height: 1.65; color: var(--kpsta-ink); font-size: 0.96rem; }
  .kpsta-view-container ol.terms li::before { content: counter(t); position: absolute; left: 0; top: 0.1rem; width: 1.6rem; height: 1.6rem; border-radius: 50%; background: var(--kpsta-accent); color: #fff; font-size: 0.8rem; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(12,74,92,0.2); }
  .kpsta-view-container .deadline { color: var(--kpsta-orange); font-weight: 800; }

  .kpsta-view-container .clause { border-left: 4px solid var(--kpsta-orange); background: var(--kpsta-orange-soft); padding: 1.25rem 1.5rem; border-radius: 0 10px 10px 0; margin: 1.25rem 0; font-size: 0.95rem; }
  .kpsta-view-container .clause p { margin: 0.4rem 0; line-height: 1.65; color: var(--kpsta-ink); }

  .kpsta-view-container .sign { margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--kpsta-border); display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; font-size: 0.88rem; color: var(--kpsta-muted); }
  @media (max-width: 32rem) { .kpsta-view-container .sign { grid-template-columns: 1fr; } }
  .kpsta-view-container .sign .line { border-bottom: 1.5px solid var(--kpsta-border-strong); height: 2.5rem; margin-bottom: 0.5rem; }

  /* action payment box */
  .kpsta-view-container .pay-action-box {
    margin: 2rem auto 1.5rem; max-width: 680px; padding: 2rem; border-radius: 16px; text-align: center;
    background: var(--kpsta-surface); border: 2px dashed var(--kpsta-accent); box-shadow: var(--kpsta-shadow); transition: all 0.3s ease;
  }
  .kpsta-view-container .pay-action-box.approved {
    background: var(--kpsta-accent-soft); border: 2px solid var(--kpsta-accent);
  }
  .kpsta-view-container .pay-action-box.paid {
    background: var(--kpsta-good-soft); border: 2px solid var(--kpsta-good); color: var(--kpsta-good);
  }

  /* Payment plan selector cards inside action box */
  .kpsta-plan-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1.5rem 0; text-align: left; }
  @media (max-width: 36rem) { .kpsta-plan-selector { grid-template-columns: 1fr; } }
  .kpsta-plan-option { border: 2px solid var(--kpsta-border-strong); border-radius: 12px; padding: 1rem; cursor: pointer; transition: all 0.2s ease; background: var(--kpsta-bg); position: relative; }
  .kpsta-plan-option:hover { border-color: var(--kpsta-accent); transform: translateY(-2px); }
  .kpsta-plan-option.selected { border-color: var(--kpsta-good); background: var(--kpsta-good-soft); box-shadow: 0 0 0 1px var(--kpsta-good); }
  .kpsta-plan-option input[type="radio"] { position: absolute; top: 1rem; right: 1rem; accent-color: var(--kpsta-good); width: 1.1rem; height: 1.1rem; }
  .kpsta-plan-option .plan-title { font-weight: 800; font-size: 1rem; color: var(--kpsta-ink); margin-bottom: 0.25rem; display: block; }
  .kpsta-plan-option .plan-price { font-size: 1.35rem; font-weight: 800; color: var(--kpsta-accent); margin-bottom: 0.25rem; }
  .kpsta-plan-option .plan-desc { font-size: 0.8rem; color: var(--kpsta-muted); line-height: 1.4; margin: 0; }

  @media print {
    :root { --kpsta-bg: #fff; --kpsta-surface: #fff; --kpsta-shadow: none; }
    html { font-size: 12pt; }
    body { font-size: 1rem; }
    .kpsta-view-container .toolbar-header { display: none; }
    .kpsta-view-container .wrap { padding: 0; max-width: 100%; }
    .kpsta-view-container .sheet { border: none; border-radius: 0; box-shadow: none; }
    .kpsta-view-container .sheet-pad { padding: 0; }
    .kpsta-view-container .pay, .kpsta-view-container .clause, .kpsta-view-container .pill { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .kpsta-view-container section { break-inside: avoid; }
  }
</style>

<div class="kpsta-view-container" data-theme-root>
  @include('proposal.brand_header', [
      'proposal' => $proposal,
      'langType' => 'ml',
      'langNameLocal' => 'മലയാളം (Malayalam)',
      'segmentsEn' => json_encode($kpstaSegmentsEn),
      'segmentsLocal' => json_encode($kpstaSegmentsMl),
      'audioUrlEn' => $proposal->getTtsAudioUrl('en'),
      'audioUrlLocal' => $proposal->getTtsAudioUrl('ml')
  ])

  <div class="wrap">
    <!-- ============================= ENGLISH ============================= -->
    <article class="sheet lang-en" id="pane-en" lang="en">
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">Static Website &amp; Custom Admin Panel Quotation</p>
          <h1>Website Development &amp; Maintenance Agreement — K.P.S.T.A.</h1>
          <p class="sub">Developing a modern, high-speed static portal and custom admin panel for Kerala Pradesh School Teacher's Association with 100% GitHub repository code handover.</p>
          <dl class="meta">
            <div><dt>Project</dt><dd>Kerala Pradesh School Teacher's Association</dd></div>
            <div><dt>Website build</dt><dd>₹7,000 <span class="pill paid">Fixed Quote</span></dd></div>
            <div><dt>Server &amp; Hosting</dt><dd>Client Managed <span class="pill good">No Hosting Required</span></dd></div>
            <div><dt>Date</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>Prepared for</dt><dd><span>K.P.S.T.A. State Executive Committee</span></dd></div>
            <div><dt>Prepared by</dt><dd><span>Animazon Design &amp; Web Studio</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> Project Scope &amp; Deliverables</h2>
          <p>Animazon Design &amp; Web Studio is privileged to present this technical quotation for developing the official digital portal of the <strong>Kerala Pradesh School Teacher's Association (K.P.S.T.A.)</strong>. Our goal is to build a high-performance, ultra-secure, and responsive website that serves as a prestigious academic and administrative hub for teachers across Kerala.</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th style="width: 30%;">Deliverable Module</th><th>Technical Scope &amp; Feature Breakdown</th></tr></thead>
              <tbody>
                <tr><td>⚡ Ultra-Fast Static Website</td><td>Built with lightweight, modern front-end technologies for instantaneous loading speeds, superior Google SEO rankings, and maximum immunity against server hacking.</td></tr>
                <tr><td>🛠️ Custom Admin Panel</td><td>Empower association administrators to effortlessly manage dynamic content without touching code! Upload and organize <strong>Photo Galleries, PDF Circulars, and News &amp; Announcements</strong> in real time.</td></tr>
                <tr><td>📚 Academic &amp; Support Corner</td><td>Dedicated sections inspired by K.P.S.T.A.'s core mission: downloadable government circulars, syllabus updates, teacher welfare software links, and association membership forms.</td></tr>
                <tr><td>👥 Leadership &amp; Heritage Showcase</td><td>Elegantly structured directories highlighting present state office bearers, district committees, and a tribute gallery honoring former leaders (Melakal / Kalolsavam).</td></tr>
                <tr><td>📱 Universal Responsive UI</td><td>Flawless visual presentation across all devices—mobile phones, iPads, laptops, and desktop screens with interactive touch menus.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> Zero Hosting Charges &amp; GitHub Repo Handover</h2>
          <p>At Animazon, we operate on a complete transparency and independence model. Since K.P.S.T.A. already maintains its own server infrastructure and domain, <strong style="color: var(--kpsta-good);">no hosting is required from our side and we charge ₹0 for server management or annual hosting fees.</strong></p>
          <div class="clause">
            <p><strong>100% GitHub Repository Handover:</strong> Our policy is clean and hassle-free: we do not bind you to recurring hosting contracts or server dependencies. Upon completion of website development and receipt of the final settlement, we directly hand over the <strong>complete GitHub repository (source code and admin panel codebase)</strong> to your technical team—granting K.P.S.T.A. total, unencumbered ownership and control over your digital assets.</p>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> 1-Month Free Maintenance Scope</h2>
          <p>We stand firmly behind the quality of our engineering. Following the live server launch and handover, K.P.S.T.A. receives <strong>1 Full Month (30 Calendar Days) of Complimentary Post-Launch Maintenance</strong>. To ensure complete clarity between both teams, the exact scope of free maintenance is detailed below:</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th style="width: 35%;">Maintenance Category</th><th style="width: 15%;">Status</th><th>Scope Description &amp; Deliverables</th></tr></thead>
              <tbody>
                <tr><td>Bug Fixes &amp; Troubleshooting</td><td><span class="pill good">Included / Free</span></td><td>Immediate technical resolution of layout glitches, broken links, responsive mobile display anomalies, or scripting errors discovered after launch.</td></tr>
                <tr><td>One-Time Admin Panel Demo</td><td><span class="pill good">Included (1 Session)</span></td><td>A single, one-time live demonstration and walkthrough for K.P.S.T.A. office staff on how to use the admin panel to upload PDF circulars, publish news articles, and manage photo galleries.</td></tr>
                <tr><td>Security &amp; Performance Checks</td><td><span class="pill good">Included / Free</span></td><td>Monitoring form submissions, file upload security handlers, and verifying browser compatibility across Chrome, Safari, Edge, and mobile devices during traffic surges.</td></tr>
                <tr><td>New Feature Development</td><td><span class="pill out">Excluded</span></td><td>Developing brand new software modules, custom portals, or major architectural redesigns outside the agreed initial scope (quoted separately at ₹800/hour or via AMC).</td></tr>
                <tr><td>Server Outages &amp; Renewals</td><td><span class="pill out">Excluded</span></td><td>Since K.P.S.T.A. maintains its own server infrastructure and domain, third-party server hardware downtime, hosting deployment, or billing renewals are handled directly by your association.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> Financial Quotation &amp; Payment Plans</h2>
          <p>The total fixed investment for developing the K.P.S.T.A. website and custom admin panel is <strong>₹7,000</strong>. We offer two transparent payment schedules to accommodate association financial workflows.</p>
          
          <div class="pay">
            <div class="tbl-scroll" style="margin: 0; border: none;">
            <table>
              <thead><tr><th class="item">Deliverable Item</th><th>Billing Status</th><th class="amt">Amount</th></tr></thead>
              <tbody>
                <tr class="ref"><td class="item">Static Website Development &amp; Custom Admin Panel</td><td><span class="pill paid">Fixed Price Quote</span></td><td class="amt"><span class="cur">₹</span>7,000</td></tr>
                <tr class="ref"><td class="item">GitHub Repository Handover &amp; Code Transfer<span class="muted">Complete source code &amp; admin panel repository transferred to client</span></td><td><span class="pill good">Included / Free</span></td><td class="amt"><span class="cur">₹</span>0</td></tr>
                <tr class="ref"><td class="item">1-Month Complimentary Post-Launch Maintenance<span class="muted">30 Calendar Days of technical bug fixes &amp; 1-time admin demo</span></td><td><span class="pill good">Included / Free</span></td><td class="amt"><span class="cur">₹</span>0</td></tr>
                <tr class="total"><td class="item" colspan="2">Total Project Investment</td><td class="amt"><span class="cur">₹</span><span class="total-val">7,000</span></td></tr>
              </tbody>
            </table>
            </div>
            <p class="pay-note">Total project investment = <b>₹7,000</b>! Zero annual hosting charges from Animazon. <b>1 month of full maintenance is 100% free</b>.</p>
          </div>

          <div class="savings">
            <span class="tick">✓</span>
            <p><b>Flexible Payment Plans Available:</b> Choose between <b>Option A</b> (50% Advance ₹3,500 today + 50% on completion) or <b>Option B</b> (100% Full Upfront ₹7,000 for priority development and streamlined accounting).</p>
          </div>

          <!-- Action Required Box -->
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--kpsta-good-soft); border: 2px solid var(--kpsta-good); color: var(--kpsta-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ Proposal Officially Approved!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--kpsta-ink);">Thank you for trusting Animazon Design &amp; Web Studio. We are thrilled to commence work on the official K.P.S.T.A. website!</p>
              </div>
            @elseif($isDeclined)
              <div style="background: var(--kpsta-danger-soft); border: 2px solid var(--kpsta-danger); color: var(--kpsta-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ Proposal Declined</strong>
                @if($proposal->decline_reason)
                  <p style="margin: 0.5rem 0 0; font-size: 0.95rem; color: var(--kpsta-ink);">Reason: {{ $proposal->decline_reason }}</p>
                @endif
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--kpsta-ink); font-size: 1.3rem; font-weight: 800;">Action Required: Select Payment Plan &amp; Approve</h3>
              <p style="margin: 0 0 1.25rem; color: var(--kpsta-muted); font-size: 0.92rem;">Please select your preferred payment schedule below and click approve to initiate development.</p>
              
              <div class="kpsta-plan-selector">
                <label class="kpsta-plan-option selected" onclick="selectPlan(this, 'advance')">
                  <input type="radio" name="payment_plan" value="advance" checked>
                  <span class="plan-title">Option A: 50% Advance</span>
                  <div class="plan-price">₹3,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--kpsta-muted);">/ now</span></div>
                  <p class="plan-desc">Pay ₹3,500 advance today to start work. Remaining ₹3,500 due after final handover.</p>
                </label>

                <label class="kpsta-plan-option" onclick="selectPlan(this, 'full')">
                  <input type="radio" name="payment_plan" value="full">
                  <span class="plan-title">Option B: 100% Upfront ⭐</span>
                  <div class="plan-price">₹7,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--kpsta-muted);">/ full amount</span></div>
                  <p class="plan-desc">Streamline accounting with a single upfront payment. Priority scheduling included.</p>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;']) !!}
                <button type="submit" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--kpsta-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(46,158,20,0.3);">
                  ✓ Approve Agreement &amp; Proceed
                </button>
                {!! Form::close() !!}

                <button type="button" onclick="document.getElementById('declineModalKpsta').style.display='flex'" style="font-size: 1.1rem; padding: 0.8rem 1.75rem; background: transparent; color: var(--kpsta-danger); border: 1px solid var(--kpsta-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                  ✕ Decline
                </button>
              </div>
            @endif
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> Terms of Agreement &amp; Timeline</h2>
          <ol class="terms">
            <li><strong>Development Timeline:</strong> Animazon commits to completing the entire static website and custom admin panel within just <strong>3 to 4 days</strong> from the date of advance payment and receipt of initial association assets (logos, leadership photos, and text).</li>
            <li><strong>Client Responsibility:</strong> To ensure a swift turnaround, K.P.S.T.A. agrees to promptly provide required PDF circulars, news items, and design feedback when requested by our team.</li>
            <li><strong>GitHub Repo Ownership:</strong> Upon full settlement of the ₹7,000 project fee, complete ownership and access to the GitHub repository (all frontend and admin panel code) are permanently transferred to K.P.S.T.A.</li>
            <li><span class="deadline">Response deadline: 15 days</span> from the date above. Without confirmation within 15 days, this quotation may require re-validation.</li>
          </ol>
        </section>

        <section>
          <h2><span class="n">6</span> Maintenance &amp; Future Support</h2>
          <p>Maintenance keeps the official website healthy, updated, secure, and running smoothly.</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>Maintenance Period</th><th>Fee &amp; Technical Scope</th></tr></thead>
              <tbody>
                <tr><td>First 1 Month (30 Days)</td><td><span class="pill good">Free</span> &nbsp;100% complimentary technical support from the live launch date.</td></tr>
                <tr><td>After 1 Month (Optional)</td><td>Can be managed by K.P.S.T.A. staff or via an optional Annual Maintenance Contract (AMC).</td></tr>
                <tr><td>New Features / Modules</td><td>Anything new outside the agreed scope is quoted separately at <strong>₹800 / hour</strong> or fixed fee.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <div style="margin-top: 3.5rem; padding: 2rem; background: var(--kpsta-accent-soft); border: 1px solid var(--kpsta-border); border-radius: 12px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1.5rem; align-items: center;">
          <div>
            <h4 style="margin: 0 0 0.5rem; color: var(--kpsta-ink); font-size: 1.1rem; font-weight: 700;">Animazon Design &amp; Web Studio</h4>
            <p style="margin: 0; color: var(--kpsta-muted); font-size: 0.9rem; line-height: 1.6;">
              <strong>Email:</strong> <a href="mailto:info@animazon.in" style="color: var(--kpsta-accent); text-decoration: none; font-weight: 600;">info@animazon.in</a> &nbsp;|&nbsp; 
              <strong>Phone / WhatsApp:</strong> <a href="tel:+918089405950" style="color: var(--kpsta-accent); text-decoration: none; font-weight: 600;">+91 80894 05950</a>
            </p>
            <p style="margin: 0.3rem 0 0; color: var(--kpsta-muted); font-size: 0.85rem;">
              <strong>Website:</strong> <a href="https://animazon.in" target="_blank" style="color: var(--kpsta-ink); text-decoration: underline;">https://animazon.in</a>
            </p>
          </div>
          <div style="display: flex; gap: 0.75rem;">
            <a href="mailto:info@animazon.in" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: var(--kpsta-surface); border: 1px solid var(--kpsta-border-strong); color: var(--kpsta-ink); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
              ✉️ Email Us
            </a>
            <a href="https://wa.me/918089405950" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37,211,102,0.2);">
              💬 WhatsApp
            </a>
          </div>
        </div>

        <div class="sign">
          <div><div class="line"></div>Authorized Signatory — signature &amp; date<br><strong style="color: var(--kpsta-ink);">Kerala Pradesh School Teacher's Association (K.P.S.T.A.)</strong></div>
          <div><div class="line"></div><strong>Animazon Design &amp; Web Studio</strong><br><span style="font-size: 0.85rem; color: var(--kpsta-muted);">info@animazon.in | +91 80894 05950</span></div>
        </div>
      </div>
    </article>

    <!-- ============================= MALAYALAM ============================= -->
    <article class="sheet lang-ml" id="pane-ml" lang="ml" hidden>
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">ഔദ്യോഗിക വെബ്സൈറ്റ് &amp; അഡ്മിൻ പാനൽ നിർമ്മാണ കരാർ</p>
          <h1>വെബ്സൈറ്റ് വികസനവും പരിപാലനവും സംബന്ധിച്ച കരാർ — കെ.പി.എസ്.ടി.എ (K.P.S.T.A.)</h1>
          <p class="sub">കേരള പ്രദേശ് സ്കൂൾ ടീച്ചേഴ്സ് അസോസിയേഷനായി അതിവേഗ സ്റ്റാറ്റിക് വെബ്സൈറ്റും കസ്റ്റം അഡ്മിൻ പാനലും നിർമ്മിച്ച് ഗിറ്റ്‌ഹബ് (GitHub) റെപ്പോ വഴി കൈമാറുന്നു.</p>
          <dl class="meta">
            <div><dt>പ്രോജക്റ്റ്</dt><dd>കേരള പ്രദേശ് സ്കൂൾ ടീച്ചേഴ്സ് അസോസിയേഷൻ (K.P.S.T.A.)</dd></div>
            <div><dt>നിർമ്മാണ ചെലവ്</dt><dd>₹7,000 <span class="pill paid">നിശ്ചിത തുക</span></dd></div>
            <div><dt>സെർവറും ഹോസ്റ്റിംഗും</dt><dd>ക്ലയന്റ് നിയന്ത്രിക്കുന്നത് <span class="pill good">ഹോസ്റ്റിംഗ് ആവശ്യമില്ല</span></dd></div>
            <div><dt>തീയതി</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>തയ്യാറാക്കിയത്</dt><dd><span>കെ.പി.എസ്.ടി.എ സംസ്ഥാന എക്സിക്യൂട്ടീവ് സമിതിക്ക് വേണ്ടി</span></dd></div>
            <div><dt>നിർമ്മാണം</dt><dd><span>അനിമൈസോൺ ഡിസൈൻ &amp; വെബ് സ്റ്റുഡിയോ</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> പ്രോജക്റ്റ് വിവരണം &amp; സവിശേഷതകൾ</h2>
          <p>കേരളത്തിലെ അദ്ധ്യാപക സമൂഹത്തിന്റെ ഔദ്യോഗിക ഡിജിറ്റൽ വേദിയായി <strong>കേരള പ്രദേശ് സ്കൂൾ ടീച്ചേഴ്സ് അസോസിയേഷന് (K.P.S.T.A.)</strong> വേണ്ടി അതിവേഗവും സുരക്ഷിതവുമായ ഒരു സ്റ്റാറ്റിക് വെബ്സൈറ്റും അത് എളുപ്പത്തിൽ നിയന്ത്രിക്കാനുള്ള കസ്റ്റം അഡ്മിൻ പാനലും വികസിപ്പിക്കാൻ അനിമൈസോൺ ഡിസൈൻ സ്റ്റുഡിയോ തയ്യാറാണ്.</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th style="width: 30%;">വിഭാഗം / മൊഡ്യൂൾ</th><th>സാങ്കേതിക വിവരണം &amp; സവിശേഷതകൾ</th></tr></thead>
              <tbody>
                <tr><td>⚡ അതിവേഗ സ്റ്റാറ്റിക് വെബ്സൈറ്റ്</td><td>ഏറ്റവും ആധുനിക സാങ്കേതികവിദ്യ ഉപയോഗിച്ച് നിർമ്മിക്കുന്നതിനാൽ പേജുകൾ കണ്ണുചിമ്മുന്ന വേഗത്തിൽ ലോഡ് ചെയ്യുന്നു. ഉയർന്ന ഗൂഗിൾ എസ്.ഇ.ഒ (SEO) റാങ്കിംഗും പൂർണ്ണ സുരക്ഷിതത്വവും ഉറപ്പ്.</td></tr>
                <tr><td>🛠️ കസ്റ്റം അഡ്മിൻ പാനൽ</td><td>കോഡിംഗ് അറിവില്ലാതെ തന്നെ ഭാരവാഹികൾക്ക് എളുപ്പത്തിൽ വിവരങ്ങൾ ചേർക്കാം! <strong>ഫോട്ടോ ഗാലറികൾ, പി.ഡി.എഫ് സർക്കുലറുകൾ, വാർത്തകളും അറിയിപ്പുകളും</strong> നിമിഷങ്ങൾക്കകം അപ്‌ലോഡ് ചെയ്യാം.</td></tr>
                <tr><td>📚 അക്കാദമിക് &amp; സർവീസ് കോർണർ</td><td>സർക്കാർ സർക്കുലറുകൾ, ഫോമുകൾ, സിലബസ് അപ്‌ഡേറ്റുകൾ, അദ്ധ്യാപക സഹായ സോഫ്റ്റ്‌വെയർ ലിങ്കുകൾ, അംഗത്വ ഫോമുകൾ എന്നിവയ്ക്കായി പ്രത്യേക വിഭാഗങ്ങൾ.</td></tr>
                <tr><td>👥 നേതൃനിര &amp; ചരിത്രം</td><td>നിലവിലെ സംസ്ഥാന ഭാരവാഹികൾ, എക്സിക്യൂട്ടീവ് അംഗങ്ങൾ എന്നിവരുടെ വിവരങ്ങളും മുൻകാല സംഘടന നേതാക്കളെ ആദരിക്കുന്ന പ്രത്യേക ചരിത്ര ഗാലറിയും (മേളകൾ / കലോത്സവം).</td></tr>
                <tr><td>📱 എല്ലാ ഡിവൈസുകളിലും അനുയോജ്യം</td><td>മൊബൈൽ ഫോണുകൾ, ടാബ്‌ലെറ്റുകൾ, ലാപ്‌ടോപ്പുകൾ, കമ്പ്യൂട്ടറുകൾ എന്നിവയിൽ വളരെ മനോഹരമായി പ്രവർത്തിക്കുന്ന റെസ്‌പോൺസീവ് ഡിസൈൻ.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> ഹോസ്റ്റിംഗ് ചാർജുകൾ ഇല്ല &amp; ഗിറ്റ്‌ഹബ് (GitHub) കൈമാറ്റം</h2>
          <p>മറ്റു ഏജൻസികളിൽ നിന്ന് വ്യത്യസ്തമായി ഞങ്ങൾ പൂർണ്ണ സുതാര്യത കാത്തുസൂക്ഷിക്കുന്നു. കെ.പി.എസ്.ടി.എ സ്വന്തമായി സെർവറും ഡൊമൈനും പരിപാലിക്കുന്നതിനാൽ, <strong style="color: var(--kpsta-good);">ഞങ്ങളുടെ ഭാഗത്തുനിന്ന് ഹോസ്റ്റിംഗോ വാർഷിക ഫീസുകളോ ആവശ്യമില്ല (₹0 ചാർജ്).</strong></p>
          <div class="clause">
            <p><strong>100% ഗിറ്റ്‌ഹബ് റെപ്പോ കൈമാറ്റം (GitHub Repo Handover):</strong> ഞങ്ങളുടെ പോളിസി വളരെ ലളിതവും സുതാര്യവുമാണ്. വാർഷിക ഹോസ്റ്റിംഗ് കരാറുകളിലോ സെർവർ നിയന്ത്രണങ്ങളിലോ ഞങ്ങൾ നിങ്ങളെ തളച്ചിടുന്നില്ല. വെബ്സൈറ്റ് നിർമ്മാണം പൂർത്തിയായി അവസാന പേയ്മെന്റ് ലഭിച്ച ഉടൻ തന്നെ, വെബ്സൈറ്റിന്റെയും അഡ്മിൻ പാനലിന്റെയും <strong>പൂർണ്ണ ഗിറ്റ്‌ഹബ് റെപ്പോസിറ്ററി (GitHub Repository / Source Code)</strong> നിങ്ങളുടെ സാങ്കേതിക വിഭാഗത്തിന് കൈമാറുന്നതാണ്. ഇതോടെ വെബ്സൈറ്റിന്റെ പൂർണ്ണ ഉടമസ്ഥാവകാശവും നിയന്ത്രണവും സംഘടനയ്ക്ക് ലഭിക്കുന്നു.</p>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> 1 മാസത്തെ സൗജന്യ പരിപാലനം — വിവരണം</h2>
          <p>വെബ്സൈറ്റ് ലൈവ് ലോഞ്ച് ചെയ്തതിനു ശേഷം <strong>1 മാസത്തേക്ക് (30 ദിവസങ്ങൾ) പൂർണ്ണ സൗജന്യ സാങ്കേതിക പരിപാലനം</strong> ഞങ്ങൾ നൽകുന്നു. ഇരുവിഭാഗങ്ങൾക്കും വ്യക്തത ലഭിക്കുന്നതിനായി സൗജന്യ പരിപാലനത്തിൽ ഉൾപ്പെടുന്നവയും ഉൾപ്പെടാത്തവയും താഴെ വിശദീകരിക്കുന്നു:</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th style="width: 35%;">വിഭാഗം</th><th style="width: 15%;">തൽസ്ഥിതി</th><th>വിശദീകരണം</th></tr></thead>
              <tbody>
                <tr><td>സാങ്കേതിക തകരാറുകൾ പരിഹരിക്കൽ</td><td><span class="pill good">സൗജന്യം / ഉൾപ്പെട്ടിട്ടുണ്ട്</span></td><td>വെബ്സൈറ്റിലോ മൊബൈൽ ഡിസ്പ്ലേയിലോ ഉണ്ടാകുന്ന സാങ്കേതിക പ്രശ്നങ്ങളും ലിങ്ക് തകരാറുകളും ഉടൻ പരിഹരിച്ചു നൽകുന്നു.</td></tr>
                <tr><td>ഒറ്റത്തവണ അഡ്മിൻ പാനൽ ഡെമോ (Demo)</td><td><span class="pill good">സൗജന്യം (1 സെഷൻ)</span></td><td>അഡ്മിൻ പാനൽ വഴി വാർത്തകളും സർക്കുലറുകളും ചിത്രങ്ങളും എങ്ങനെ അപ്‌ലോഡ് ചെയ്യാമെന്ന് ജീവനക്കാർക്കായി ഒറ്റത്തവണ ലൈവ് ഡെമോ നൽകുന്നു.</td></tr>
                <tr><td>സുരക്ഷയും പ്രവർത്തന പരിശോധനയും</td><td><span class="pill good">സൗജന്യം / ഉൾപ്പെട്ടിട്ടുണ്ട്</span></td><td>ഫോം സബ്മിഷനുകളും ഫയൽ അപ്‌ലോഡുകളും സുരക്ഷിതമാണെന്നും എല്ലാ ബ്രൗസറുകളിലും വേഗത്തിൽ പ്രവർത്തിക്കുന്നുണ്ടെന്നും ഉറപ്പുവരുത്തുന്നു.</td></tr>
                <tr><td>പുതിയ ഫീച്ചറുകൾ നിർമ്മിക്കൽ</td><td><span class="pill out">ഉൾപ്പെട്ടിട്ടില്ല</span></td><td>കരാറിൽ ഇല്ലാത്ത പുതിയ സോഫ്റ്റ്‌വെയർ മൊഡ്യൂളുകളോ പേജുകളോ നിർമ്മിക്കുന്നത് (ഇതിന് മണിക്കൂറിന് ₹800 അല്ലെങ്കിൽ പ്രത്യേക ഫീസ് ബാധകം).</td></tr>
                <tr><td>സെർവർ തകരാറുകളും റിന്യൂവലും</td><td><span class="pill out">ഉൾപ്പെട്ടിട്ടില്ല</span></td><td>ഹോസ്റ്റിംഗും സെർവറും കെ.പി.എസ്.ടി.എ നേരിട്ട് പരിപാലിക്കുന്നതിനാൽ, സെർവർ തകരാറുകൾ പരിഹരിക്കുന്നതും ഡൊമൈൻ റിന്യൂവൽ ചെയ്യുന്നതും സംഘടന സ്വന്തമായി ചെയ്യേണ്ടതാണ്.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> നിർമ്മാണ ചെലവും പേയ്മെന്റ് രീതികളും</h2>
          <p>വെബ്സൈറ്റും കസ്റ്റം അഡ്മിൻ പാനലും നിർമ്മിക്കുന്നതിനായുള്ള ആകെ നിശ്ചിത തുക <strong>₹7,000</strong> ആണ്. സംഘടനയുടെ സൗകര്യാർത്ഥം രണ്ട് പേയ്മെന്റ് രീതികൾ താഴെ നൽകുന്നു.</p>
          
          <div class="pay">
            <div class="tbl-scroll" style="margin: 0; border: none;">
            <table>
              <thead><tr><th class="item">വിഭാഗം</th><th>സ്റ്റാറ്റസ്</th><th class="amt">തുക</th></tr></thead>
              <tbody>
                <tr class="ref"><td class="item">സ്റ്റാറ്റിക് വെബ്സൈറ്റും കസ്റ്റം അഡ്മിൻ പാനലും</td><td><span class="pill paid">നിശ്ചിത തുക</span></td><td class="amt"><span class="cur">₹</span>7,000</td></tr>
                <tr class="ref"><td class="item">ഗിറ്റ്‌ഹബ് (GitHub) റെപ്പോ കൈമാറ്റം<span class="muted">വെബ്സൈറ്റിന്റെയും അഡ്മിൻ പാനലിന്റെയും പൂർണ്ണ സോഴ്സ് കോഡ് നൽകുന്നു</span></td><td><span class="pill good">സൗജന്യം</span></td><td class="amt"><span class="cur">₹</span>0</td></tr>
                <tr class="ref"><td class="item">1 മാസത്തെ സൗജന്യ സാങ്കേതിക പരിപാലനം<span class="muted">30 ദിവസത്തെ സാങ്കേതിക സപ്പോർട്ടും ഒറ്റത്തവണ ഡെമോയും</span></td><td><span class="pill good">സൗജന്യം</span></td><td class="amt"><span class="cur">₹</span>0</td></tr>
                <tr class="total"><td class="item" colspan="2">ആകെ നിർമ്മാണ ചെലവ്</td><td class="amt"><span class="cur">₹</span><span class="total-val">7,000</span></td></tr>
              </tbody>
            </table>
            </div>
            <p class="pay-note">ആകെ നിർമ്മാണ ചെലവ് = <b>₹7,000</b>! അനിമൈസോണിന്റെ ഭാഗത്തുനിന്ന് വാർഷിക ഹോസ്റ്റിംഗ് ഫീസ് ഇല്ല. <b>1 മാസത്തെ പരിപാലനം പൂർണ്ണ സൗജന്യമാണ്</b>.</p>
          </div>

          <div class="savings">
            <span class="tick">✓</span>
            <p><b>രണ്ട് പേയ്മെന്റ് രീതികൾ ലഭ്യമാണ്:</b> <b>ഓപ്ഷൻ എ</b> (ജോലി ആരംഭിക്കാൻ 50% അഡ്വാൻസ് ₹3,500 + പൂർത്തിയാകുമ്പോൾ ബാക്കി 50%) അല്ലെങ്കിൽ <b>ഓപ്ഷൻ ബി</b> (മുൻഗണന ലഭിക്കാൻ 100% മുഴുവൻ തുക ₹7,000 ഒന്നിച്ച് നൽകാം).</p>
          </div>

          <!-- Action Required Box -->
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--kpsta-good-soft); border: 2px solid var(--kpsta-good); color: var(--kpsta-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ കരാർ ഔദ്യോഗികമായി അംഗീകരിച്ചു!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--kpsta-ink);">അനിമൈസോൺ ഡിസൈൻ സ്റ്റുഡിയോയെ വിശ്വസിച്ചതിന് നന്ദി. കെ.പി.എസ്.ടി.എ വെബ്സൈറ്റ് നിർമ്മാണം ഞങ്ങൾ ഉടൻ ആരംഭിക്കുന്നതാണ്!</p>
              </div>
            @elseif($isDeclined)
              <div style="background: var(--kpsta-danger-soft); border: 2px solid var(--kpsta-danger); color: var(--kpsta-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ കരാർ നിരസിച്ചു</strong>
                @if($proposal->decline_reason)
                  <p style="margin: 0.5rem 0 0; font-size: 0.95rem; color: var(--kpsta-ink);">കാരണം: {{ $proposal->decline_reason }}</p>
                @endif
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--kpsta-ink); font-size: 1.3rem; font-weight: 800;">തുടരുന്നതിനായി പേയ്മെന്റ് രീതി തിരഞ്ഞെടുത്ത് അംഗീകരിക്കുക</h3>
              <p style="margin: 0 0 1.25rem; color: var(--kpsta-muted); font-size: 0.92rem;">താഴെ കാണുന്ന പേയ്മെന്റ് ഓപ്ഷൻ തിരഞ്ഞെടുത്ത് അംഗീകരിക്കുക ബട്ടൺ ക്ലിക്ക് ചെയ്യുക.</p>
              
              <div class="kpsta-plan-selector">
                <label class="kpsta-plan-option selected" onclick="selectPlan(this, 'advance')">
                  <input type="radio" name="payment_plan_ml" value="advance" checked>
                  <span class="plan-title">ഓപ്ഷൻ എ: 50% അഡ്വാൻസ്</span>
                  <div class="plan-price">₹3,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--kpsta-muted);">/ ഇപ്പോൾ</span></div>
                  <p class="plan-desc">ജോലി ആരംഭിക്കാൻ ₹3,500 അഡ്വാൻസ് നൽകുക. ബാക്കി ₹3,500 വെബ്സൈറ്റ് കൈമാറിയ ശേഷം നൽകാം.</p>
                </label>

                <label class="kpsta-plan-option" onclick="selectPlan(this, 'full')">
                  <input type="radio" name="payment_plan_ml" value="full">
                  <span class="plan-title">ഓപ്ഷൻ ബി: 100% മുഴുവൻ തുക ⭐</span>
                  <div class="plan-price">₹7,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--kpsta-muted);">/ മുഴുവൻ തുക</span></div>
                  <p class="plan-desc">പ്രോജക്റ്റിന് മുൻഗണന ലഭിക്കാൻ ₹7,000 മുഴുവൻ തുകയും ഒന്നിച്ച് അടയ്ക്കാം.</p>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;']) !!}
                <button type="submit" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--kpsta-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(46,158,20,0.3);">
                  ✓ കരാർ അംഗീകരിച്ചു മുന്നോട്ട് പോകുക
                </button>
                {!! Form::close() !!}

                <button type="button" onclick="document.getElementById('declineModalKpsta').style.display='flex'" style="font-size: 1.1rem; padding: 0.8rem 1.75rem; background: transparent; color: var(--kpsta-danger); border: 1px solid var(--kpsta-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                  ✕ നിരസിക്കുക
                </button>
              </div>
            @endif
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> കരാർ നിബന്ധനകളും സമയപരിധിയും</h2>
          <ol class="terms">
            <li><strong>നിർമ്മാണ സമയപരിധി:</strong> അഡ്വാൻസ് തുകയും സംഘടനയുടെ വിവരങ്ങളും (ലോഗോ, ഭാരവാഹികളുടെ ചിത്രങ്ങൾ, വിവരണം) ലഭിച്ച് <strong>3 മുതൽ 4 ദിവസങ്ങൾക്കുള്ളിൽ (3 to 4 days)</strong> വെബ്സൈറ്റും അഡ്മിൻ പാനലും പൂർണ്ണമായി നിർമ്മിച്ച് നൽകുന്നതാണ്.</li>
            <li><strong>സംഘടനയുടെ ചുമതല:</strong> നിർമ്മാണം വേഗത്തിലാക്കാൻ ആവശ്യമായ സർക്കുലറുകളും വാർത്തകളും ചിത്രങ്ങളും സമയബന്ധിതമായി നൽകാൻ കെ.പി.എസ്.ടി.എ ശ്രദ്ധിക്കേണ്ടതാണ്.</li>
            <li><strong>ഗിറ്റ്‌ഹബ് (GitHub) ഉടമസ്ഥാവകാശം:</strong> ₹7,000 മുഴുവൻ തുകയും ലഭിച്ച ഉടൻ തന്നെ വെബ്സൈറ്റിന്റെയും അഡ്മിൻ പാനലിന്റെയും ഗിറ്റ്‌ഹബ് റെപ്പോസിറ്ററി (GitHub Repo) കെ.പി.എസ്.ടി.എ-യ്ക്ക് സ്ഥിരമായി കൈമാറുന്നതാണ്.</li>
            <li><span class="deadline">മറുപടി നൽകേണ്ട സമയം: 15 ദിവസങ്ങൾ</span>. ഈ തീയതിക്കുള്ളിൽ അംഗീകാരം നൽകിയില്ലെങ്കിൽ കരാർ വിവരങ്ങൾ പുനഃപരിശോധിക്കേണ്ടി വന്നേക്കാം.</li>
          </ol>
        </section>

        <section>
          <h2><span class="n">6</span> ഭാവി പരിപാലനവും പിന്തുണയും</h2>
          <p>വെബ്സൈറ്റ് സുരക്ഷിതമായും തകരാറുകളില്ലാതെയും പ്രവർത്തിക്കാൻ പരിപാലനം സഹായിക്കുന്നു.</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>കാലയളവ്</th><th>ഫീസും വിശദീകരണവും</th></tr></thead>
              <tbody>
                <tr><td>ആദ്യ 1 മാസം (30 ദിവസങ്ങൾ)</td><td><span class="pill good">സൗജന്യം</span> &nbsp;വെബ്സൈറ്റ് ലോഞ്ച് ചെയ്തതിനു ശേഷം 100% സൗജന്യ സാങ്കേതിക സപ്പോർട്ട്.</td></tr>
                <tr><td>1 മാസത്തിന് ശേഷം (ഓപ്ഷണൽ)</td><td>സംഘടനയുടെ ജീവനക്കാർക്ക് നേരിട്ടോ അല്ലെങ്കിൽ വാർഷിക പരിപാലന കരാർ (AMC) വഴിയോ നിയന്ത്രിക്കാം.</td></tr>
                <tr><td>പുതിയ ഫീച്ചറുകൾ / പേജുകൾ</td><td>കരാറിൽ ഇല്ലാത്ത പുതിയ മാറ്റങ്ങൾക്ക് മണിക്കൂറിന് <strong>₹800</strong> അല്ലെങ്കിൽ പ്രത്യേക ഫീസ് ബാധകമായിരിക്കും.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <div style="margin-top: 3.5rem; padding: 2rem; background: var(--kpsta-accent-soft); border: 1px solid var(--kpsta-border); border-radius: 12px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1.5rem; align-items: center;">
          <div>
            <h4 style="margin: 0 0 0.5rem; color: var(--kpsta-ink); font-size: 1.1rem; font-weight: 700;">അനിമൈസോൺ ഡിസൈൻ &amp; വെബ് സ്റ്റുഡിയോ</h4>
            <p style="margin: 0; color: var(--kpsta-muted); font-size: 0.9rem; line-height: 1.6;">
              <strong>ഇമെയിൽ:</strong> <a href="mailto:info@animazon.in" style="color: var(--kpsta-accent); text-decoration: none; font-weight: 600;">info@animazon.in</a> &nbsp;|&nbsp; 
              <strong>ഫോൺ / വാട്ട്‌സ്ആപ്പ്:</strong> <a href="tel:+918089405950" style="color: var(--kpsta-accent); text-decoration: none; font-weight: 600;">+91 80894 05950</a>
            </p>
            <p style="margin: 0.3rem 0 0; color: var(--kpsta-muted); font-size: 0.85rem;">
              <strong>വെബ്സൈറ്റ്:</strong> <a href="https://animazon.in" target="_blank" style="color: var(--kpsta-ink); text-decoration: underline;">https://animazon.in</a>
            </p>
          </div>
          <div style="display: flex; gap: 0.75rem;">
            <a href="mailto:info@animazon.in" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: var(--kpsta-surface); border: 1px solid var(--kpsta-border-strong); color: var(--kpsta-ink); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
              ✉️ ഇമെയിൽ ചെയ്യുക
            </a>
            <a href="https://wa.me/918089405950" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37,211,102,0.2);">
              💬 വാട്ട്‌സ്ആപ്പ്
            </a>
          </div>
        </div>

        <div class="sign">
          <div><div class="line"></div>ഔദ്യോഗിക ഭാരവാഹി — ഒപ്പും തീയതിയും<br><strong style="color: var(--kpsta-ink);">കേരള പ്രദേശ് സ്കൂൾ ടീച്ചേഴ്സ് അസോസിയേഷൻ (K.P.S.T.A.)</strong></div>
          <div><div class="line"></div><strong>അനിമൈസോൺ ഡിസൈൻ &amp; വെബ് സ്റ്റുഡിയോ</strong><br><span style="font-size: 0.85rem; color: var(--kpsta-muted);">info@animazon.in | +91 80894 05950</span></div>
        </div>
      </div>
    </article>
  </div>
</div>

<!-- Decline Modal -->
<div id="declineModalKpsta" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
  <div style="background: var(--kpsta-surface); color: var(--kpsta-ink); padding: 2rem; border-radius: 16px; max-width: 450px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.3); border: 1px solid var(--kpsta-border);">
    <h3 style="margin: 0 0 0.5rem; font-size: 1.25rem; font-weight: 800;">Decline Proposal</h3>
    <p style="margin: 0 0 1.25rem; font-size: 0.9rem; color: var(--kpsta-muted);">Please let us know why you are declining so we can improve our quotation or adjust the scope.</p>
    
    {!! Form::open(['route' => ['proposal.public.decline', $publicParam], 'method' => 'POST']) !!}
      <textarea name="decline_reason" rows="3" placeholder="Enter reason (optional)..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--kpsta-border-strong); border-radius: 8px; background: var(--kpsta-bg); color: var(--kpsta-ink); font-family: inherit; font-size: 0.9rem; margin-bottom: 1.25rem;"></textarea>
      
      <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
        <button type="button" onclick="document.getElementById('declineModalKpsta').style.display='none'" style="padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--kpsta-border-strong); border-radius: 8px; color: var(--kpsta-ink); font-weight: 600; cursor: pointer;">
          Cancel
        </button>
        <button type="submit" style="padding: 0.6rem 1.2rem; background: var(--kpsta-danger); border: none; border-radius: 8px; color: #fff; font-weight: 700; cursor: pointer;">
          Confirm Decline
        </button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

<script>
  function selectPlan(element, planType) {
    // Find all plan options in the current action box and remove selected class
    const container = element.closest('.kpsta-plan-selector');
    container.querySelectorAll('.kpsta-plan-option').forEach(opt => {
      opt.classList.remove('selected');
    });
    // Add selected class to clicked option
    element.classList.add('selected');
    // Check radio button
    const radio = element.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
  }
</script>
