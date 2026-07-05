@php
    $subBtnId = !empty($companyPayment['razorpay_subscription_button_id']) ? $companyPayment['razorpay_subscription_button_id'] : (!empty($adminPayment['razorpay_subscription_button_id']) ? $adminPayment['razorpay_subscription_button_id'] : 'pl_T9j7p5Gbk0YDsG');
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);

    $rudraSegmentsEn = [
        "Restart Fee and Dues for rudraspirit.com.",
        "Section 1: Context. The rudraspirit.com website was completed, delivered, and the build fee paid in full of 40,000 rupees. Work then paused for roughly 6 months with no active development or feedback. Two amounts are now due to resume: unpaid hosting and domain charges of 2,400 rupees per month, running since 22 December 2025, and a restart fee to bring the dormant project back to a working, current, deployable state. There is no kill fee and nothing extra on the completed build.",
        "Section 2: Why the restart fee applies. Six months of dormancy creates real, billable work before development can resume: rebuilding the local dev environment, re-establishing deployment, WordPress and plugin updates, security review and patching, PHP and server compatibility, and context re-familiarization.",
        "Section 3: Upgrade to Premium VPS Hosting. To prioritize search engine optimization and support business scaling, we migrated the website from Hostinger Shared Hosting to a high-performance, dedicated Virtual Private Server. Benefits of VPS hosting include lightning-fast loading speeds for higher Google SEO rankings, exclusive CPU and RAM to handle high concurrent traffic during promotion, isolated security with dedicated IP, and proactive 24/7 server monitoring.",
        "Section 4: Amount payable now. Congratulations! We have waived off your 6,000 rupees restart fee as a goodwill gesture. You pay 0 rupees for reactivation and only settle the pending web hosting charges of 16,800 rupees. Unpaid hosting and domain renewal since 22 December 2025 is 16,800 rupees. The 6,000 rupees restart fee is waived. Total payable now is 16,800 rupees.",
        "Section 5: Terms to resume. Total of 16,800 rupees is payable in advance before development resumes. Hosting renewal is mandatory at 2,400 rupees per month or automated auto pay subscription."
    ];

    $rudraSegmentsHi = [
        "रूद्र स्पिरिट डॉट कॉम के लिए पुनः आरंभ शुल्क और बकाया राशि।",
        "भाग 1: संदर्भ। रूद्र स्पिरिट डॉट कॉम वेबसाइट पूरी हो चुकी थी, डिलीवर कर दी गई थी, और निर्माण शुल्क 40,000 रुपये का पूरा भुगतान कर दिया गया था। इसके बाद लगभग 6 महीने तक कोई काम या फीडबैक नहीं मिला। काम फिर से शुरू करने के लिए दो राशियाँ देय हैं: 22 दिसंबर 2025 से बकाया होस्टिंग और डोमेन शुल्क 2,400 रुपये प्रति माह, और प्रोजेक्ट को फिर से चालू करने का पुनः आरंभ शुल्क।",
        "भाग 2: पुनः आरंभ शुल्क क्यों लागू होता है। 6 महीने की निष्क्रियता के बाद काम दोबारा शुरू करने से पहले वास्तविक काम करना पड़ता है: लोकल डेवलपमेंट एनवायरनमेंट दोबारा बनाना, डिप्लॉयमेंट दोबारा स्थापित करना, वर्डप्रेस और प्लगइन अपडेट, सुरक्षा जाँच और पैचिंग, पीएचपी और सर्वर संगतता, और प्रोजेक्ट संदर्भ दोबारा समझना।",
        "भाग 3: प्रीमियम वीपीएस होस्टिंग में अपग्रेड। आपके व्यवसाय की वृद्धि और एसईओ अनुकूलन को प्राथमिकता देने के लिए हमने वेबसाइट को होस्टिंगर शेयर्ड होस्टिंग से एक समर्पित वर्चुअल प्राइवेट सर्वर पर माइग्रेट कर दिया है। वीपीएस होस्टिंग के लाभों में गूगल एसईओ रैंकिंग बढ़ाने के लिए सुपर-फ़ास्ट लोडिंग स्पीड, बेहतर ट्रैफिक क्षमता, और दैनिक बैकअप के साथ उन्नत सुरक्षा शामिल है।",
        "भाग 4: अभी देय राशि। बधाई हो! हमने सद्भावना स्वरूप आपका 6,000 रुपये का पुनः आरंभ शुल्क माफ़ कर दिया है! आपको पुनःसक्रियण के लिए 0 रुपये देना होगा और केवल बकाया वेब होस्टिंग शुल्क 16,800 रुपये का भुगतान करना होगा। 22 दिस॰ 2025 से बकाया होस्टिंग और डोमेन नवीनीकरण 16800 रुपये है। 6,000 रुपये पुनः आरंभ शुल्क माफ़ है। अभी देय कुल राशि 16,800 रुपये है।",
        "भाग 5: दोबारा शुरू करने की शर्तें। काम शुरू होने से पहले केवल बकाया होस्टिंग और डोमेन के 16,800 रुपये अग्रिम देय हैं। 2,400 रुपये प्रति माह पर निरंतर वेब होस्टिंग नवीनीकरण अनिवार्य है।"
    ];
@endphp
<style>
  :root, :root[data-theme="light"] {
    --rudra-bg: #FBF8F3; --rudra-surface: #FFFFFF; --rudra-ink: #241D14; --rudra-muted: #6E6353;
    --rudra-border: #E8E0D3; --rudra-border-strong: #D9CEBB;
    --rudra-accent: #A96E1B; --rudra-accent-deep: #7E4F0F; --rudra-accent-soft: #F3E7D2;
    --rudra-good: #3C6B45; --rudra-good-soft: #E4EEE2;
    --rudra-danger: #A6392C; --rudra-danger-soft: #F4E2DE;
    --rudra-shadow: 0 1px 2px rgba(36,29,20,.05), 0 12px 32px -12px rgba(36,29,20,.14);
    --rudra-maxw: 100%;
  }
  :root[data-theme="dark"] {
    --rudra-bg: #151109; --rudra-surface: #1E1810; --rudra-ink: #EFE8DA; --rudra-muted: #A79A85;
    --rudra-border: #332A1C; --rudra-border-strong: #413524;
    --rudra-accent: #D89C3E; --rudra-accent-deep: #E7B45E; --rudra-accent-soft: #2A2213;
    --rudra-good: #7FB588; --rudra-good-soft: #1C2A1D; --rudra-danger: #E08A7C; --rudra-danger-soft: #2E1A16;
    --rudra-shadow: 0 1px 2px rgba(0,0,0,.4), 0 16px 40px -16px rgba(0,0,0,.6);
    --rudra-maxw: 100%;
  }

  .rudra-view-container {
    background: var(--rudra-bg);
    color: var(--rudra-ink);
    font-family: "Segoe UI", -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, "Nirmala UI", "Noto Sans Devanagari", "Mangal", sans-serif;
    font-size: 1rem;
    line-height: 1.68;
    -webkit-font-smoothing: antialiased;
    font-variant-numeric: tabular-nums;
    padding: 0 0 6.5rem;
    border-radius: 16px;
  }
  .rudra-view-container .wrap { max-width: var(--rudra-maxw); margin: 0 auto; padding: 1.5rem 1.5rem 6.5rem; }
  .rudra-view-container .lang-hi { line-height: 1.78; }

  /* toolbar & branded header */
  .rudra-view-container .toolbar-header {
    position: sticky; top: 0; z-index: 50;
    background: var(--rudra-surface);
    border-bottom: 1px solid var(--rudra-border);
    box-shadow: 0 4px 20px -4px rgba(36,29,20,.08);
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
    padding: 1.1rem clamp(1.5rem, 4vw, 3.5rem);
    margin-bottom: 1.5rem;
    border-radius: 16px 16px 0 0;
    transition: background 0.25s ease, border-color 0.25s ease;
  }
  .rudra-view-container .header-brand-area { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
  .rudra-view-container .brand-link { display: flex; align-items: center; text-decoration: none; }
  .rudra-view-container .header-logo-img { max-height: 46px; width: auto; object-fit: contain; }
  .rudra-view-container .studio-badge { font-size: 0.72rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--rudra-accent); font-weight: 700; padding: 0.3rem 0.75rem; background: var(--rudra-accent-soft); border: 1px solid var(--rudra-border-strong); border-radius: 6px; }
  .rudra-view-container .header-actions-area { display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap; }
  .rudra-view-container .logo-for-light { display: block !important; }
  .rudra-view-container .logo-for-dark { display: none !important; }
  :root[data-theme="dark"] .rudra-view-container .logo-for-light { display: none !important; }
  :root[data-theme="dark"] .rudra-view-container .logo-for-dark { display: block !important; }
  .rudra-view-container .toolbar-header .grp { display: flex; gap: .35rem; align-items: center; }
  .rudra-view-container .seg { display: inline-flex; border: 1px solid var(--rudra-border-strong); border-radius: 8px; overflow: hidden; }
  .rudra-view-container .seg button { border: none; border-radius: 0; background: transparent; color: var(--rudra-muted); padding: .42rem .85rem; }
  .rudra-view-container .seg button[aria-pressed="true"] { background: var(--rudra-accent); color: #fff; }
  .rudra-view-container .seg button+button { border-left: 1px solid var(--rudra-border-strong); }
  .rudra-view-container button {
    font: inherit; font-size: .85rem; font-weight: 600; cursor: pointer;
    color: var(--rudra-surface); background: var(--rudra-accent); border: 1px solid var(--rudra-accent-deep);
    padding: .45rem .85rem; border-radius: 8px; transition: background .15s, transform .05s;
  }
  .rudra-view-container button.ghost { background: transparent; color: var(--rudra-accent); border-color: var(--rudra-border-strong); }
  .rudra-view-container button:hover { background: var(--rudra-accent-deep); }
  .rudra-view-container button.ghost:hover { background: var(--rudra-accent-soft); }
  .rudra-view-container .seg button:hover { background: var(--rudra-accent-soft); }
  .rudra-view-container .seg button[aria-pressed="true"]:hover { background: var(--rudra-accent-deep); }
  .rudra-view-container button:focus-visible { outline: 2px solid var(--rudra-accent); outline-offset: 2px; }

  /* Switch slider for subscription toggle */
  .switch-sub { position: relative; display: inline-block; width: 54px; height: 30px; margin: 0; cursor: pointer; flex-shrink: 0; }
  .switch-sub input { opacity: 0; width: 0; height: 0; }
  .slider-round { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 34px; }
  .slider-round:before { position: absolute; content: ""; height: 22px; width: 22px; left: 4px; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
  .switch-sub input:checked + .slider-round { background-color: var(--rudra-good); }
  .switch-sub input:checked + .slider-round:before { transform: translateX(24px); }

  .rudra-view-container .sheet { background: var(--rudra-surface); border: 1px solid var(--rudra-border); border-radius: 14px; box-shadow: var(--rudra-shadow); overflow: hidden; }
  .rudra-view-container .sheet-pad { padding: clamp(1.5rem, 4vw, 3rem); }
  .rudra-view-container [hidden] { display: none !important; }

  .rudra-view-container .mast { border-bottom: 1px solid var(--rudra-border); padding-bottom: 1.5rem; }
  .rudra-view-container .brand { display: flex; align-items: baseline; gap: .6rem; margin: 0 0 1.25rem; flex-wrap: wrap; }
  .rudra-view-container .brand .mark { font-size: 1.2rem; font-weight: 800; letter-spacing: .01em; display: inline-flex; align-items: center; gap: .4rem; color: var(--rudra-ink); }
  .rudra-view-container .brand .mark::before { content: ""; width: .55rem; height: .55rem; border-radius: 50%; background: var(--rudra-accent); display: inline-block; }
  .rudra-view-container .brand .tag { font-size: .66rem; letter-spacing: .15em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; }
  .rudra-view-container .eyebrow { font-size: .73rem; letter-spacing: .13em; text-transform: uppercase; color: var(--rudra-accent); font-weight: 700; margin: 0 0 .55rem; display: flex; align-items: center; gap: .55rem; }
  .rudra-view-container .eyebrow::before { content: ""; width: 1.6rem; height: 2px; background: var(--rudra-accent); display: inline-block; }
  .rudra-view-container h1 { font-size: clamp(1.6rem, 4.4vw, 2.25rem); line-height: 1.18; margin: 0; letter-spacing: -.015em; text-wrap: balance; font-weight: 700; color: var(--rudra-ink); }
  .rudra-view-container .lang-hi h1 { line-height: 1.32; }
  .rudra-view-container .sub { color: var(--rudra-muted); margin: .6rem 0 0; font-size: 1rem; line-height: 1.55; }

  .rudra-view-container .meta { display: grid; grid-template-columns: repeat(2, 1fr); gap: .9rem 2rem; margin-top: 1.5rem; }
  @media (max-width: 32rem) { .rudra-view-container .meta { grid-template-columns: 1fr; } }
  .rudra-view-container .meta div { display: flex; flex-direction: column; gap: .15rem; }
  .rudra-view-container .meta dt { font-size: .71rem; letter-spacing: .06em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; margin: 0; }
  .rudra-view-container .meta dd { margin: 0; font-weight: 600; color: var(--rudra-ink); }

  .rudra-view-container .fill { border-bottom: 1.5px dotted var(--rudra-border-strong); min-width: 6ch; padding: 0 .15rem; outline: none; color: var(--rudra-ink); font-weight: 600; }
  .rudra-view-container .fill:empty::before { content: attr(data-ph); color: var(--rudra-muted); font-weight: 400; font-style: italic; }
  .rudra-view-container .fill:focus { border-bottom-color: var(--rudra-accent); background: var(--rudra-accent-soft); }

  .rudra-view-container section { margin-top: 2.15rem; }
  .rudra-view-container h2 { font-size: 1.05rem; margin: 0 0 .8rem; line-height: 1.4; display: flex; align-items: baseline; gap: .65rem; color: var(--rudra-ink); font-weight: 700; }
  .rudra-view-container h2 .n { color: var(--rudra-accent); font-size: .8rem; font-weight: 700; font-variant-numeric: tabular-nums; border: 1px solid var(--rudra-border-strong); border-radius: 6px; padding: .05rem .42rem; line-height: 1.4; flex: none; }
  .rudra-view-container p { margin: .7rem 0; color: var(--rudra-ink); }
  .rudra-view-container strong { font-weight: 700; }

  /* pills */
  .rudra-view-container .pill { display: inline-block; font-size: .72rem; font-weight: 700; letter-spacing: .02em; padding: .12rem .55rem; border-radius: 999px; white-space: nowrap; }
  .rudra-view-container .pill.paid { background: var(--rudra-good-soft); color: var(--rudra-good); }
  .rudra-view-container .pill.due { background: var(--rudra-accent-soft); color: var(--rudra-accent-deep); }
  .rudra-view-container .pill.out { background: var(--rudra-danger-soft); color: var(--rudra-danger); }
  .rudra-view-container .pill.good { background: var(--rudra-good-soft); color: var(--rudra-good); }

  /* payment summary */
  .rudra-view-container .pay { margin-top: 1.5rem; border: 1px solid var(--rudra-border-strong); border-radius: 12px; overflow: hidden; background: var(--rudra-surface); }
  .rudra-view-container .pay table { width: 100%; border-collapse: collapse; margin: 0; }
  .rudra-view-container .pay th, .rudra-view-container .pay td { padding: .7rem .9rem; text-align: left; border-bottom: 1px solid var(--rudra-border); }
  .rudra-view-container .pay thead th { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; background: var(--rudra-accent-soft); border-bottom: 1px solid var(--rudra-border-strong); }
  .rudra-view-container .pay td.amt, .rudra-view-container .pay th.amt { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; font-weight: 700; color: var(--rudra-ink); }
  .rudra-view-container .pay td.item { font-weight: 600; color: var(--rudra-ink); }
  .rudra-view-container .pay tr.ref td { color: var(--rudra-muted); font-weight: 500; }
  .rudra-view-container .pay tr.ref td.item { font-weight: 600; color: var(--rudra-ink); }
  .rudra-view-container .pay tr.total td { border-bottom: none; background: linear-gradient(180deg, var(--rudra-accent-soft), transparent); font-size: 1.05rem; }
  .rudra-view-container .pay tr.total td.item { font-weight: 800; letter-spacing: -.01em; color: var(--rudra-ink); }
  .rudra-view-container .pay tr.total td.amt { font-size: 1.5rem; font-weight: 800; color: var(--rudra-accent-deep); }
  .rudra-view-container .pay .cur { opacity: .7; margin-right: .05rem; }
  .rudra-view-container .pay .muted { display: block; color: var(--rudra-muted); font-size: .8rem; font-weight: 500; margin-top: .2rem; line-height: 1.5; }
  .rudra-view-container .was { text-decoration: line-through; text-decoration-color: var(--rudra-danger); color: var(--rudra-muted); font-weight: 600; margin-right: .45rem; font-size: .88em; }
  
  .rudra-view-container .savings { display: flex; align-items: center; gap: .8rem; margin: 1.15rem 0 0; padding: .95rem 1.15rem; border-radius: 10px; background: var(--rudra-good-soft); border: 1px solid var(--rudra-good); }
  .rudra-view-container .savings .tick { flex: none; width: 1.8rem; height: 1.8rem; border-radius: 50%; background: var(--rudra-good); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; }
  .rudra-view-container .savings p { margin: 0; font-size: .96rem; line-height: 1.5; color: var(--rudra-ink); }
  .rudra-view-container .savings b { color: var(--rudra-good); }
  .rudra-view-container .pay-note { padding: .85rem .9rem; font-size: .85rem; color: var(--rudra-muted); margin: 0; line-height: 1.6; border-top: 1px dashed var(--rudra-border-strong); }
  .rudra-view-container .pay-note b { color: var(--rudra-ink); }
  .rudra-view-container .tbl-scroll { overflow-x: auto; }

  .rudra-view-container ul { margin: .6rem 0; padding-left: 0; list-style: none; display: flex; flex-direction: column; gap: .42rem; }
  .rudra-view-container ul li { position: relative; padding-left: 1.45rem; color: var(--rudra-ink); }
  .rudra-view-container ul li::before { content: ""; position: absolute; left: .15rem; top: .66rem; width: .4rem; height: .4rem; background: var(--rudra-accent); border-radius: 50%; }
  .rudra-view-container ul.no li::before { background: var(--rudra-muted); width: .55rem; height: 2px; border-radius: 0; top: .8rem; }

  .rudra-view-container ol.terms { margin: .6rem 0; padding-left: 0; counter-reset: t; list-style: none; display: flex; flex-direction: column; gap: .7rem; }
  .rudra-view-container ol.terms li { position: relative; padding-left: 2.1rem; counter-increment: t; line-height: 1.6; color: var(--rudra-ink); }
  .rudra-view-container ol.terms li::before { content: counter(t); position: absolute; left: 0; top: .1rem; width: 1.5rem; height: 1.5rem; border-radius: 50%; background: var(--rudra-accent); color: #fff; font-size: .78rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
  .rudra-view-container .deadline { color: var(--rudra-accent-deep); font-weight: 700; }

  .rudra-view-container .clause { border-left: 3px solid var(--rudra-accent); background: var(--rudra-accent-soft); padding: 1rem 1.25rem; border-radius: 0 8px 8px 0; margin: 1rem 0; font-size: .93rem; }
  .rudra-view-container .clause p { margin: .4rem 0; line-height: 1.65; color: var(--rudra-ink); }

  .rudra-view-container table.why { width: 100%; border-collapse: collapse; margin: .4rem 0; font-size: .92rem; }
  .rudra-view-container table.why th, .rudra-view-container table.why td { text-align: left; padding: .6rem .75rem; vertical-align: top; border-bottom: 1px solid var(--rudra-border); line-height: 1.5; color: var(--rudra-ink); }
  .rudra-view-container table.why thead th { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; border-bottom: 1.5px solid var(--rudra-border-strong); background: transparent; }
  .rudra-view-container table.why tbody tr:last-child td { border-bottom: none; }
  .rudra-view-container table.why td:first-child { font-weight: 600; }

  .rudra-view-container .sign { margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--rudra-border); display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; font-size: .85rem; color: var(--rudra-muted); }
  @media (max-width: 32rem) { .rudra-view-container .sign { grid-template-columns: 1fr; } }
  .rudra-view-container .sign .line { border-bottom: 1px solid var(--rudra-border-strong); height: 2rem; margin-bottom: .4rem; }

  /* action payment box */
  .rudra-view-container .pay-action-box {
    margin-top: 1.5rem; padding: 1.75rem; border-radius: 14px; text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s ease;
  }
  .rudra-view-container .pay-action-box.pending {
    background: var(--rudra-surface); border: 2px dashed var(--rudra-accent);
  }
  .rudra-view-container .pay-action-box.approved {
    background: var(--rudra-accent-soft); border: 2px solid var(--rudra-accent);
  }
  .rudra-view-container .pay-action-box.paid {
    background: var(--rudra-good-soft); border: 2px solid var(--rudra-good); color: var(--rudra-good);
  }

  @media print {
    :root { --rudra-bg: #fff; --rudra-surface: #fff; --rudra-shadow: none; }
    html { font-size: 12pt; }
    body { font-size: 1rem; }
    .rudra-view-container .toolbar { display: none; }
    .rudra-view-container .wrap { padding: 0; max-width: 100%; }
    .rudra-view-container .sheet { border: none; border-radius: 0; box-shadow: none; }
    .rudra-view-container .sheet-pad { padding: 0; }
    .rudra-view-container .pay, .rudra-view-container .clause, .rudra-view-container .pill { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .rudra-view-container section { break-inside: avoid; }
  }
  @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
</style>

<div class="rudra-view-container">
  <header class="toolbar-header">
    <div class="header-brand-area">
      <a href="{{ url('/') }}" class="brand-link">
        @php
          $logoPath = \App\Models\Utility::get_file('uploads/logo');
          $logoDark = !empty($company_setting['company_logo_dark']) ? $company_setting['company_logo_dark'] : (!empty($settings['company_logo_dark']) ? $settings['company_logo_dark'] : 'logo-dark.png');
          $logoLight = !empty($company_setting['company_logo_light']) ? $company_setting['company_logo_light'] : (!empty($settings['company_logo_light']) ? $settings['company_logo_light'] : 'logo-light.png');
        @endphp
        <img src="{{ $logoPath . '/' . $logoDark . '?' . time() }}" alt="Animazon Logo" class="header-logo-img logo-for-light" />
        <img src="{{ $logoPath . '/' . $logoLight . '?' . time() }}" alt="Animazon Logo" class="header-logo-img logo-for-dark" />
      </a>
      <span class="studio-badge">DESIGN &amp; WEB STUDIO</span>
    </div>
    <div class="header-actions-area">
      <button class="ghost" type="button" data-role="proposal-read-aloud"
              data-tts-audio-url-en="{{ $proposal->getTtsAudioUrl('en') }}"
              data-tts-audio-url-hi="{{ $proposal->getTtsAudioUrl('hi') }}"
              data-tts-segments-en="{{ json_encode($rudraSegmentsEn) }}"
              data-tts-segments-hi="{{ json_encode($rudraSegmentsHi) }}">
          <i class="ti ti-volume-2"></i> {{ __('Read Aloud') }}
      </button>
      <span class="seg" role="group" aria-label="Language">
        <button id="btn-en" aria-pressed="true" onclick="setLang('en')">English</button>
        <button id="btn-hi" aria-pressed="false" onclick="setLang('hi')">हिंदी</button>
      </span>
      <button class="ghost" onclick="toggleRudraTheme()">◐ Theme</button>
      <button onclick="window.print()">🖨️ Print / PDF</button>
    </div>
  </header>

  <div class="wrap">
    <!-- ============================= ENGLISH ============================= -->
    <article class="sheet lang-en" id="pane-en" lang="en">
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">Project Reactivation Notice</p>
          <h1>Restart Fee &amp; Dues — rudraspirit.com</h1>
          <p class="sub">Reactivating the Rudraksha e-commerce website after a dormancy period.</p>
          <dl class="meta">
            <div><dt>Project</dt><dd>rudraspirit.com</dd></div>
            <div><dt>Website build</dt><dd>₹40,000 <span class="pill paid">Paid</span></dd></div>
            <div><dt>Dormant</dt><dd>~6 months</dd></div>
            <div><dt>Date</dt><dd><span class="fill" contenteditable="true">{{ $user->dateFormat($proposal->issue_date) }}</span></dd></div>
            <div><dt>Prepared for</dt><dd><span class="fill" contenteditable="true">rudraspirit.com</span></dd></div>
            <div><dt>Prepared by</dt><dd><span class="fill" contenteditable="true">Animazon</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> Context</h2>
          <p>The rudraspirit.com website was completed, delivered, and the build fee <strong>paid in full (₹40,000)</strong>. Work then paused for roughly <strong>6 months</strong> with no active development or feedback.</p>
          <p>Two amounts are now due to resume: <strong>unpaid hosting + domain charges</strong> (₹2,400/month, running since 22 Dec 2025), and a <strong>restart fee</strong> to bring the dormant project back to a working, current, deployable state. There is no kill fee and nothing extra on the completed build.</p>
          <div class="clause">
            <p><strong>Why an extra charge?</strong> The ₹40,000 paid for <strong>building and delivering</strong> the site — not for holding it ready indefinitely. In the 6-month gap, resources moved to other clients and the site fell behind on updates and security. Getting it back to a safe, current, deployable state — and reserving schedule time again — is <strong>fresh work that wasn't part of the completed project.</strong> Hosting is a separate service cost that remained unpaid.</p>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> Why the restart fee applies</h2>
          <p>Six months of dormancy creates real, billable work before development can resume:</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>Reactivation task</th><th>Why it's needed after 6 months</th></tr></thead>
              <tbody>
                <tr><td>Rebuild local dev environment</td><td>Site re-imported into LocalWP; database, config, and URLs re-wired</td></tr>
                <tr><td>Re-establish deployment</td><td>New SSH keys, deploy scripts, and live-server sync set up from scratch</td></tr>
                <tr><td>WordPress &amp; plugin updates</td><td>6 months of updates for WooCommerce, Elementor, and other plugins</td></tr>
                <tr><td>Security review &amp; patching</td><td>Dormant sites accumulate known vulnerabilities that must be patched</td></tr>
                <tr><td>PHP / server compatibility</td><td>Host environment and PHP versions move on; code re-verified</td></tr>
                <tr><td>Context re-familiarization</td><td>Time to reload full project context after moving to other work</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> Upgrade to Premium VPS Hosting</h2>
          <p>To prioritize search engine optimization (SEO) and support business scaling, we migrated the website from <strong>Hostinger Shared Hosting</strong> to a high-performance, dedicated <strong>Virtual Private Server (VPS)</strong>. This migration includes optimized server configurations tailored specifically for WooCommerce performance.</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>VPS Cloud Advantage</th><th>Why it matters for rudraspirit.com</th></tr></thead>
              <tbody>
                <tr><td>Google SEO Ranking</td><td>Faster response times (Time to First Byte) directly improve mobile and desktop search engine rankings.</td></tr>
                <tr><td>Dedicated Resources</td><td>Exclusive CPU, RAM, and SSD storage prevent site slow-downs or crashes during high-traffic sales.</td></tr>
                <tr><td>Isolated Security</td><td>A private server environment with dedicated IP, custom firewalls, and isolated file access.</td></tr>
                <tr><td>24/7 Proactive Monitoring</td><td>Continuous server health checks, regular database optimizations, and auto-renewing SSL monitoring.</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> Amount payable now</h2>
          <div style="background: linear-gradient(135deg, var(--rudra-good-soft), var(--rudra-accent-soft)); border: 2px solid var(--rudra-good); border-radius: 16px; padding: 1.5rem 1.75rem; margin: 1.5rem 0 1.75rem; box-shadow: 0 8px 24px rgba(60,107,69,0.12); display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
            <div style="background: var(--rudra-good); color: #fff; width: 3.5rem; height: 3.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 800; flex-shrink: 0; box-shadow: 0 4px 12px rgba(60,107,69,0.3);">
              🎉
            </div>
            <div style="flex: 1; min-width: 250px;">
              <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem; flex-wrap: wrap;">
                <span style="background: var(--rudra-good); color: #fff; font-size: 0.75rem; font-weight: 800; padding: 0.2rem 0.65rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">GOODWILL GESTURE</span>
                <strong style="font-size: 1.35rem; color: var(--rudra-good); line-height: 1.2;">Congratulations! We Have Waived Off Your ₹6,000 Restart Fee!</strong>
              </div>
              <p style="margin: 0; font-size: 1rem; color: var(--rudra-ink); line-height: 1.5;">
                To celebrate continuing our partnership, we have completely waived off the <strong>₹6,000 Server Reactivation &amp; Restart Fee</strong> as a goodwill gesture. You pay <strong style="color: var(--rudra-good); font-size: 1.1rem;">₹0</strong> for reactivation and only settle the pending web hosting charges!
              </p>
            </div>
          </div>

          <div class="pay">
            <div class="tbl-scroll">
            <table>
              <thead><tr><th class="item">Item</th><th>Status</th><th class="amt">Amount</th></tr></thead>
              <tbody>
                <tr class="ref"><td class="item">Website build &amp; delivery</td><td><span class="pill paid">Paid in full</span></td><td class="amt"><span class="cur">₹</span>40,000</td></tr>
                <tr><td class="item">Hosting + domain renewal<span class="muted">₹<span class="fill rate" contenteditable="true" style="min-width:3ch">2,400</span>/month × <span class="fill months" contenteditable="true" style="min-width:2ch">7</span> months · since 22 Dec 2025</span></td><td><span class="pill out">Unpaid</span></td><td class="amt"><span class="cur">₹</span><span class="host-sub">16,800</span></td></tr>
                <tr class="waived"><td class="item">Restart / reactivation fee</td><td><span class="pill good">Waived · goodwill</span></td><td class="amt"><span class="was">₹6,000</span><span class="cur">₹</span>0</td></tr>
                <tr class="total"><td class="item" colspan="2">Total payable now</td><td class="amt"><span class="cur">₹</span><span class="total-val">16,800</span></td></tr>
              </tbody>
            </table>
            </div>
            <p class="pay-note">Total payable now = hosting + domain only (<b>₹2,400/month × 7 = ₹16,800</b>, accrued since 22 Dec 2025). The ₹40,000 build fee is already settled. The <b>₹6,000 restart fee is waived</b> — no charge for reactivation.</p>
          </div>
          <div class="savings">
            <span class="tick">✓</span>
            <p><b>Good news:</b> the ₹6,000 restart fee is <b>waived as a thank-you</b> for continuing together. You only pay the pending hosting — <b>you save ₹6,000</b>.</p>
          </div>

          <!-- Side-by-Side: Web Hosting Auto-Pay & Action Required Box -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin: 2rem 0 1.5rem; align-items: stretch;">
              <!-- Left Column: Web Hosting Charges Auto-Pay -->
              <div style="padding: 1.5rem; background: var(--rudra-bg-subtle); border: 2px solid var(--rudra-border-strong); border-radius: 14px; text-align: left; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                  <div>
                      <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                          <span style="background: var(--rudra-accent); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">WEB HOSTING CHARGES</span>
                          <strong style="font-size: 1.15rem; color: var(--rudra-ink);">Web Hosting Charges Auto-Pay</strong>
                      </div>
                      <p style="margin: 0 0 1.25rem; font-size: 0.9rem; color: var(--rudra-muted); line-height: 1.5;">
                          Ongoing web hosting charges are compulsory. Choose between manual monthly payments or enable automated recurring payments (Auto-Pay) via Razorpay for cloud hosting, domain renewal, 24/7 uptime monitoring, and security patching.
                      </p>
                  </div>
                  <div style="padding-top: 1rem; border-top: 1px solid var(--rudra-border-strong);">
                      <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
                          <span id="subStatusTextEn" style="font-weight: 700; font-size: 0.95rem; color: var(--rudra-good);">Yes, Auto-Pay Enabled</span>
                          <label class="switch-sub">
                              <input type="checkbox" id="toggleSubEn" checked onchange="toggleSubscriptionWidget('En', this.checked)">
                              <span class="slider-round"></span>
                          </label>
                      </div>
                      <div id="subWidgetBoxEn" style="display: block; margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px dashed var(--rudra-border-strong); text-align: center;">
                          <p style="font-size: 0.9rem; color: var(--rudra-accent-deep); font-weight: 700; margin-bottom: 0.85rem;">
                              ✓ Auto-Pay Mode Selected — Authorize recurring hosting payments below:
                          </p>
                          <div style="display: flex; justify-content: center; align-items: center; min-height: 50px;">
                              <form>
                                  <script src="https://cdn.razorpay.com/static/widget/subscription-button.js" 
                                          data-subscription_button_id="{{ $subBtnId }}" 
                                          data-button_theme="brand-color" 
                                          async>
                                  </script>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Right Column: Payment Gateway & Approval Actions Box -->
              <div style="display: flex; flex-direction: column;">
                  @if($isAccepted && $totalDue > 0)
                      <div class="pay-action-box approved" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <h3 style="margin: 0 0 0.5rem; color: var(--rudra-accent-deep); font-size: 1.3rem; font-weight: 800;">Proposal Approved — Ready for Payment</h3>
                          <p style="margin: 0 0 1.5rem; color: var(--rudra-ink);">Please complete the payment of <strong>{{ \App\Models\Utility::priceFormat($settings, $totalDue) }}</strong> to reactivate hosting and resume development.</p>
                          @if(!empty($razorpayKey))
                              <button type="button" class="btn-rzp-pay" style="font-size: 1.15rem; padding: 0.85rem 2.5rem; background: var(--rudra-accent); color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 6px 16px rgba(0,0,0,0.2);">
                                  <i class="ti ti-shield-check"></i> Pay Now — {{ \App\Models\Utility::priceFormat($settings, $totalDue) }}
                              </button>
                              <p style="margin: 0.85rem 0 0; font-size: 0.85rem; color: var(--rudra-muted);"><i class="ti ti-lock"></i> Secured by Razorpay</p>
                          @else
                              <p style="margin: 0; color: var(--rudra-danger); font-weight: 600;">Online payment is not configured yet. Please contact us to arrange payment.</p>
                          @endif
                      </div>
                  @elseif($isAccepted && $totalDue <= 0)
                      <div class="pay-action-box paid" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <strong style="font-size: 1.25rem;">✓ Paid in Full — Thank you!</strong>
                          <p style="margin: 0.5rem 0 0; color: var(--rudra-muted);">Your project reactivation is confirmed and active.</p>
                      </div>
                  @elseif($isDeclined)
                      <div class="pay-action-box" style="background: var(--rudra-danger-soft); border: 2px solid var(--rudra-danger); color: var(--rudra-danger); height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <strong style="font-size: 1.25rem;">✕ Proposal Declined</strong>
                          @if($proposal->decline_reason)
                              <p style="margin: 0.5rem 0 0; font-size: 0.95rem; color: var(--rudra-ink);">Reason: {{ $proposal->decline_reason }}</p>
                          @endif
                      </div>
                  @else
                      <div class="pay-action-box pending" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <h3 style="margin: 0 0 0.5rem; color: var(--rudra-ink); font-size: 1.25rem; font-weight: 800;">Action Required: Approve Proposal</h3>
                          <p style="margin: 0 0 1.5rem; color: var(--rudra-muted);">Please review the terms above and click approve to confirm reactivation and unlock online payment.</p>
                          <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                              {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;']) !!}
                              <button type="submit" style="font-size: 1.1rem; padding: 0.75rem 2rem; background: var(--rudra-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(60,107,69,0.3);">
                                  ✓ Approve Proposal
                              </button>
                              {!! Form::close() !!}

                              <button type="button" onclick="document.getElementById('declineModalRudra').style.display='flex'" style="font-size: 1.1rem; padding: 0.75rem 1.75rem; background: transparent; color: var(--rudra-danger); border: 1px solid var(--rudra-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                                  ✕ Decline
                              </button>
                          </div>
                          @if(!empty($razorpayKey))
                              <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px dashed var(--rudra-border-strong);">
                                  <p style="font-size: 0.9rem; color: var(--rudra-muted); margin-bottom: 0.75rem;">Or proceed directly to instant secure payment:</p>
                                  <button type="button" class="btn-rzp-pay" style="font-size: 1rem; padding: 0.6rem 1.75rem; background: var(--rudra-accent); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                                      <i class="ti ti-shield-check"></i> Pay Now — {{ \App\Models\Utility::priceFormat($settings, $totalDue) }}
                                  </button>
                              </div>
                          @endif
                      </div>
                  @endif
              </div>
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> Terms to resume</h2>
          <ol class="terms">
            <li>Total of <strong>₹<span class="fill" contenteditable="true" style="min-width:5ch">16,800</span></strong> (pending hosting + domain only — <strong>restart fee waived</strong>) payable <strong>in advance</strong>, before development resumes.</li>
            <li>Any new work beyond the original delivered scope is quoted and approved separately.</li>
            <li><span class="deadline">Response deadline: 5 days</span> from the date above. Without confirmation in 5 days, the project stays closed, no resources are reserved, and a fresh reactivation quote at then-current rates will be required later.</li>
          </ol>
        </section>

        <section>
          <h2><span class="n">6</span> Maintenance &amp; future work</h2>
          <p>Maintenance keeps the existing, agreed website healthy — updates, backups, security, and uptime.</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>Item</th><th>Charge</th></tr></thead>
              <tbody>
                <tr><td>Maintenance — first 6 months</td><td><span class="pill good">Free</span> &nbsp;No charge, from the restart date</td></tr>
                <tr><td>Maintenance — after 6 months</td><td>Decided later, based on the site's <strong>performance &amp; traffic</strong></td></tr>
                <tr><td>Maintenance scope</td><td>Covers the <strong>agreed works only</strong> (existing features &amp; upkeep)</td></tr>
                <tr><td>New features / modules</td><td>Anything new is quoted separately at <strong>₹800 / hour</strong></td></tr>
              </tbody>
            </table>
          </div>
          <div class="clause">
            <p><strong>Dormancy clause.</strong> If the project receives no client feedback or approval for <strong>15 consecutive days</strong>, it is automatically marked <em>paused</em>. Resuming requires a restart fee (waived this once as goodwill), payable before work continues. After <strong>30 days</strong> of inactivity the project may be closed and final-invoiced for work completed to date.</p>
          </div>
        </section>

        <div class="proposal-contact-footer" style="margin-top: 3rem; padding: 2rem; background: var(--rudra-bg); border: 1px solid var(--rudra-border); border-radius: 12px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1.5rem; align-items: center;">
          <div>
            <h4 style="margin: 0 0 0.5rem; color: var(--rudra-ink); font-size: 1.1rem; font-weight: 700;">Animazon Design &amp; Web Studio</h4>
            <p style="margin: 0; color: var(--rudra-muted); font-size: 0.9rem; line-height: 1.6;">
              <strong>Email:</strong> <a href="mailto:info@animazon.in" style="color: var(--rudra-accent); text-decoration: none; font-weight: 600;">info@animazon.in</a> &nbsp;|&nbsp; 
              <strong>Phone / WhatsApp:</strong> <a href="tel:+918089405950" style="color: var(--rudra-accent); text-decoration: none; font-weight: 600;">+91 80894 05950</a>
            </p>
            <p style="margin: 0.3rem 0 0; color: var(--rudra-muted); font-size: 0.85rem;">
              <strong>Website:</strong> <a href="https://animazon.in" target="_blank" style="color: var(--rudra-ink); text-decoration: underline;">https://animazon.in</a>
            </p>
          </div>
          <div style="display: flex; gap: 0.75rem;">
            <a href="mailto:info@animazon.in" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: var(--rudra-surface); border: 1px solid var(--rudra-border-strong); color: var(--rudra-ink); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
              ✉️ Email Us
            </a>
            <a href="https://wa.me/918089405950" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37,211,102,0.2);">
              💬 WhatsApp
            </a>
          </div>
        </div>

        <div class="sign">
          <div><div class="line"></div>Client (rudraspirit.com) — signature &amp; date</div>
          <div><div class="line"></div><strong>Animazon Design &amp; Web Studio</strong><br><span style="font-size: 0.85rem; color: var(--rudra-muted);">info@animazon.in | +91 80894 05950</span></div>
        </div>
      </div>
    </article>

    <!-- ============================= HINDI ============================= -->
    <article class="sheet lang-hi" id="pane-hi" lang="hi" hidden>
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">प्रोजेक्ट पुनःसक्रियण सूचना</p>
          <h1>पुनः आरंभ शुल्क व बकाया — rudraspirit.com</h1>
          <p class="sub">लंबे विराम के बाद रुद्राक्ष ई-कॉमर्स वेबसाइट को दोबारा सक्रिय करना।</p>
          <dl class="meta">
            <div><dt>प्रोजेक्ट</dt><dd>rudraspirit.com</dd></div>
            <div><dt>वेबसाइट निर्माण</dt><dd>₹40,000 <span class="pill paid">भुगतान हुआ</span></dd></div>
            <div><dt>निष्क्रिय अवधि</dt><dd>लगभग 6 महीने</dd></div>
            <div><dt>दिनांक</dt><dd><span class="fill" contenteditable="true">{{ $user->dateFormat($proposal->issue_date) }}</span></dd></div>
            <div><dt>ग्राहक</dt><dd><span class="fill" contenteditable="true">rudraspirit.com</span></dd></div>
            <div><dt>प्रस्तुतकर्ता</dt><dd><span class="fill" contenteditable="true">Animazon</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> संदर्भ</h2>
          <p>rudraspirit.com वेबसाइट पूरी हुई, डिलीवर हुई और निर्माण शुल्क का <strong>पूरा भुगतान (₹40,000)</strong> हो चुका है। इसके बाद लगभग <strong>6 महीने</strong> तक कोई सक्रिय काम या फीडबैक नहीं मिला और काम रुका रहा।</p>
          <p>अब दोबारा शुरू करने के लिए दो राशि देय हैं: <strong>बकाया होस्टिंग + डोमेन शुल्क</strong> (₹2,400/माह, 22 दिस॰ 2025 से चालू), और निष्क्रिय प्रोजेक्ट को दोबारा चालू, अद्यतन व डिप्लॉय-योग्य बनाने के लिए <strong>पुनः आरंभ शुल्क</strong>। कोई रद्दीकरण शुल्क नहीं है और पूरे हो चुके निर्माण पर कुछ अतिरिक्त नहीं।</p>
          <div class="clause">
            <p><strong>अतिरिक्त शुल्क क्यों?</strong> ₹40,000 वेबसाइट <strong>बनाने और डिलीवर करने</strong> के लिए था — इसे अनिश्चितकाल तक तैयार रखने के लिए नहीं। इन 6 महीनों में संसाधन दूसरे ग्राहकों पर लगे और साइट अपडेट व सुरक्षा में पीछे रह गई। इसे दोबारा सुरक्षित, अद्यतन व डिप्लॉय-योग्य बनाना — और शेड्यूल में दोबारा समय देना — <strong>नया काम है जो पूरे हो चुके प्रोजेक्ट का हिस्सा नहीं था।</strong> होस्टिंग एक अलग सेवा शुल्क है जो अब तक बकाया रहा।</p>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> पुनः आरंभ शुल्क क्यों लागू होता है</h2>
          <p>6 महीने की निष्क्रियता के बाद, काम दोबारा शुरू करने से पहले वास्तविक काम करना पड़ता है:</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>पुनःसक्रियण कार्य</th><th>6 महीने बाद यह क्यों ज़रूरी है</th></tr></thead>
              <tbody>
                <tr><td>लोकल डेवलपमेंट एनवायरनमेंट दोबारा बनाना</td><td>साइट को LocalWP में दोबारा इम्पोर्ट; डेटाबेस, कॉन्फ़िग व URL दोबारा सेट</td></tr>
                <tr><td>डिप्लॉयमेंट दोबारा स्थापित करना</td><td>नई SSH keys, deploy स्क्रिप्ट व लाइव-सर्वर सिंक नए सिरे से</td></tr>
                <tr><td>WordPress व प्लगइन अपडेट</td><td>WooCommerce, Elementor व अन्य प्लगइन के 6 महीने के अपडेट</td></tr>
                <tr><td>सुरक्षा जाँच व पैचिंग</td><td>निष्क्रिय साइटों में ज्ञात कमजोरियाँ जमा होती हैं, जिन्हें पैच करना ज़रूरी</td></tr>
                <tr><td>PHP / सर्वर संगतता</td><td>होस्ट एनवायरनमेंट व PHP वर्शन बदलते हैं; कोड दोबारा जाँचा जाता है</td></tr>
                <tr><td>प्रोजेक्ट संदर्भ दोबारा समझना</td><td>दूसरे काम पर जाने के बाद पूरा प्रोजेक्ट संदर्भ दोबारा लोड करने का समय</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> प्रीमियम वीपीएस होस्टिंग में अपग्रेड</h2>
          <p>सर्च इंजन ऑप्टिमाइज़ेशन (SEO) और व्यापार विस्तार को प्राथमिकता देने के लिए, हमने वेबसाइट को <strong>होस्टिंगर शेयर्ड होस्टिंग</strong> से हटाकर एक उच्च-प्रदर्शन वाले समर्पित <strong>वर्चुअल प्राइवेट सर्वर (VPS)</strong> पर माइग्रेट कर दिया है। इस माइग्रेशन में WooCommerce प्रदर्शन के अनुकूल अनुकूलित सर्वर कॉन्फ़िगरेशन शामिल हैं।</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>वीपीएस क्लाउड के लाभ</th><th>rudraspirit.com के लिए इसका महत्व</th></tr></thead>
              <tbody>
                <tr><td>गूगल SEO रैंकिंग</td><td>तेज़ रिस्पांस टाइम (टाइम टू फर्स्ट बाइट) सीधे तौर पर मोबाइल और डेस्कटॉप सर्च इंजन रैंकिंग में सुधार करता है।</td></tr>
                <tr><td>समर्पित संसाधन</td><td>अनन्य CPU, RAM, और SSD स्टोरेज उच्च-ट्रैफ़िक बिक्री के दौरान साइट को धीमा होने या क्रैश होने से बचाते हैं।</td></tr>
                <tr><td>उन्नत सुरक्षा</td><td>समर्पित आईपी, कस्टम फ़ायरवॉल और सुरक्षित फ़ाइल एक्सेस के साथ एक पूरी तरह से निजी सर्वर वातावरण।</td></tr>
                <tr><td>24/7 सक्रिय निगरानी</td><td>लगातार सर्वर स्वास्थ्य जाँच, डेटाबेस अनुकूलन और ऑटो-रिन्यूइंग एसएसएल (SSL) निगरानी शामिल है।</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> अभी देय राशि</h2>
          <div style="background: linear-gradient(135deg, var(--rudra-good-soft), var(--rudra-accent-soft)); border: 2px solid var(--rudra-good); border-radius: 16px; padding: 1.5rem 1.75rem; margin: 1.5rem 0 1.75rem; box-shadow: 0 8px 24px rgba(60,107,69,0.12); display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
            <div style="background: var(--rudra-good); color: #fff; width: 3.5rem; height: 3.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 800; flex-shrink: 0; box-shadow: 0 4px 12px rgba(60,107,69,0.3);">
              🎉
            </div>
            <div style="flex: 1; min-width: 250px;">
              <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem; flex-wrap: wrap;">
                <span style="background: var(--rudra-good); color: #fff; font-size: 0.75rem; font-weight: 800; padding: 0.2rem 0.65rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">सद्भावना स्वरूप</span>
                <strong style="font-size: 1.35rem; color: var(--rudra-good); line-height: 1.2;">बधाई हो! हमने आपका पुनः आरंभ शुल्क माफ़ कर दिया है!</strong>
              </div>
              <p style="margin: 0; font-size: 1rem; color: var(--rudra-ink); line-height: 1.5;">
                हमारी साझेदारी जारी रखने की खुशी में, हमने <strong>₹6,000 का सर्वर पुनःसक्रियण और पुनः आरंभ शुल्क</strong> पूरी तरह से माफ़ कर दिया है। आपको पुनःसक्रियण के लिए <strong style="color: var(--rudra-good); font-size: 1.1rem;">₹0</strong> देना होगा और केवल बकाया वेब होस्टिंग शुल्क का भुगतान करना होगा!
              </p>
            </div>
          </div>

          <div class="pay">
            <div class="tbl-scroll">
            <table>
              <thead><tr><th class="item">विवरण</th><th>स्थिति</th><th class="amt">राशि</th></tr></thead>
              <tbody>
                <tr class="ref"><td class="item">वेबसाइट निर्माण व डिलीवरी</td><td><span class="pill paid">पूर्ण भुगतान</span></td><td class="amt"><span class="cur">₹</span>40,000</td></tr>
                <tr><td class="item">होस्टिंग + डोमेन नवीनीकरण<span class="muted">₹<span class="fill rate" contenteditable="true" style="min-width:3ch">2,400</span>/माह × <span class="fill months" contenteditable="true" style="min-width:2ch">7</span> माह · 22 दिस॰ 2025 से</span></td><td><span class="pill out">अभुगतान</span></td><td class="amt"><span class="cur">₹</span><span class="host-sub">16,800</span></td></tr>
                <tr class="waived"><td class="item">पुनः आरंभ / पुनःसक्रियण शुल्क</td><td><span class="pill good">माफ़ · सद्भावना</span></td><td class="amt"><span class="was">₹6,000</span><span class="cur">₹</span>0</td></tr>
                <tr class="total"><td class="item" colspan="2">अभी देय कुल राशि</td><td class="amt"><span class="cur">₹</span><span class="total-val">16,800</span></td></tr>
              </tbody>
            </table>
            </div>
            <p class="pay-note">अभी देय कुल = केवल होस्टिंग + डोमेन (<b>₹2,400/माह × 7 = ₹16,800</b>, 22 दिस॰ 2025 से बकाया)। ₹40,000 निर्माण शुल्क पहले ही चुकाया जा चुका है। <b>₹6,000 पुनः आरंभ शुल्क माफ़</b> कर दिया गया है — पुनःसक्रियण का कोई शुल्क नहीं।</p>
            <div class="savings">
              <span class="tick">✓</span>
              <p><b>खुशखबरी:</b> ₹6,000 पुनः आरंभ शुल्क <b>सद्भावना स्वरूप माफ़</b> कर दिया गया है। आपको केवल बकाया होस्टिंग देना है — <b>₹6,000 की बचत</b>।</p>
            </div>
          </div>

          <!-- Side-by-Side: Web Hosting Auto-Pay & Action Required Box (Hindi) -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin: 2rem 0 1.5rem; align-items: stretch;">
              <!-- Left Column: Web Hosting Charges Auto-Pay (Hindi) -->
              <div style="padding: 1.5rem; background: var(--rudra-bg-subtle); border: 2px solid var(--rudra-border-strong); border-radius: 14px; text-align: left; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                  <div>
                      <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                          <span style="background: var(--rudra-accent); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">वेब होस्टिंग शुल्क</span>
                          <strong style="font-size: 1.15rem; color: var(--rudra-ink);">वेब होस्टिंग शुल्क ऑटो-पे (Auto-Pay)</strong>
                      </div>
                      <p style="margin: 0 0 1.25rem; font-size: 0.9rem; color: var(--rudra-muted); line-height: 1.5;">
                          निरंतर वेब होस्टिंग अनिवार्य है। क्लाउड होस्टिंग, डोमेन नवीनीकरण, 24/7 अपटाइम मॉनिटरिंग और सुरक्षा पैचिंग के लिए मैनुअल मासिक भुगतान या Razorpay द्वारा स्वचालित आवर्ती भुगतान (Auto-Pay) चुनें।
                      </p>
                  </div>
                  <div style="padding-top: 1rem; border-top: 1px solid var(--rudra-border-strong);">
                      <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
                          <span id="subStatusTextHi" style="font-weight: 700; font-size: 0.95rem; color: var(--rudra-good);">हाँ, ऑटो-पे सक्रिय</span>
                          <label class="switch-sub">
                              <input type="checkbox" id="toggleSubHi" checked onchange="toggleSubscriptionWidget('Hi', this.checked)">
                              <span class="slider-round"></span>
                          </label>
                      </div>
                      <div id="subWidgetBoxHi" style="display: block; margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px dashed var(--rudra-border-strong); text-align: center;">
                          <p style="font-size: 0.9rem; color: var(--rudra-accent-deep); font-weight: 700; margin-bottom: 0.85rem;">
                              ✓ स्वचालित भुगतान मोड चयनित — नीचे आवर्ती होस्टिंग भुगतान अधिकृत करें:
                          </p>
                          <div style="display: flex; justify-content: center; align-items: center; min-height: 50px;">
                              <form>
                                  <script src="https://cdn.razorpay.com/static/widget/subscription-button.js" 
                                          data-subscription_button_id="{{ $subBtnId }}" 
                                          data-button_theme="brand-color" 
                                          async>
                                  </script>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Right Column: Payment Gateway & Approval Actions Box (Hindi) -->
              <div style="display: flex; flex-direction: column;">
                  @if($isAccepted && $totalDue > 0)
                      <div class="pay-action-box approved" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <h3 style="margin: 0 0 0.5rem; color: var(--rudra-accent-deep); font-size: 1.3rem; font-weight: 800;">प्रस्ताव स्वीकृत — भुगतान के लिए तैयार</h3>
                          <p style="margin: 0 0 1.5rem; color: var(--rudra-ink);">कृपया होस्टिंग और विकास कार्य पुनः शुरू करने के लिए <strong>{{ \App\Models\Utility::priceFormat($settings, $totalDue) }}</strong> का भुगतान पूरा करें।</p>
                          @if(!empty($razorpayKey))
                              <button type="button" class="btn-rzp-pay" style="font-size: 1.15rem; padding: 0.85rem 2.5rem; background: var(--rudra-accent); color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 6px 16px rgba(0,0,0,0.2);">
                                  <i class="ti ti-shield-check"></i> अभी भुगतान करें — {{ \App\Models\Utility::priceFormat($settings, $totalDue) }}
                              </button>
                              <p style="margin: 0.85rem 0 0; font-size: 0.85rem; color: var(--rudra-muted);"><i class="ti ti-lock"></i> Razorpay द्वारा सुरक्षित</p>
                          @else
                              <p style="margin: 0; color: var(--rudra-danger); font-weight: 600;">ऑनलाइन भुगतान अभी कॉन्फ़िगर नहीं किया गया है। कृपया भुगतान के लिए हमसे संपर्क करें।</p>
                          @endif
                      </div>
                  @elseif($isAccepted && $totalDue <= 0)
                      <div class="pay-action-box paid" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <strong style="font-size: 1.25rem;">✓ पूर्ण भुगतान प्राप्त — धन्यवाद!</strong>
                          <p style="margin: 0.5rem 0 0; color: var(--rudra-muted);">आपका प्रोजेक्ट पुनःसक्रियण कन्फर्म है।</p>
                      </div>
                  @elseif($isDeclined)
                      <div class="pay-action-box" style="background: var(--rudra-danger-soft); border: 2px solid var(--rudra-danger); color: var(--rudra-danger); height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <strong style="font-size: 1.25rem;">✕ प्रस्ताव अस्वीकृत</strong>
                          @if($proposal->decline_reason)
                              <p style="margin: 0.5rem 0 0; font-size: 0.95rem; color: var(--rudra-ink);">कारण: {{ $proposal->decline_reason }}</p>
                          @endif
                      </div>
                  @else
                      <div class="pay-action-box pending" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                          <h3 style="margin: 0 0 0.5rem; color: var(--rudra-ink); font-size: 1.25rem; font-weight: 800;">आवश्यक कार्रवाई: प्रस्ताव स्वीकृत करें</h3>
                          <p style="margin: 0 0 1.5rem; color: var(--rudra-muted);">कृपया उपरोक्त शर्तों की समीक्षा करें और ऑनलाइन भुगतान अनलॉक करने व अपना प्रोजेक्ट पुनः सक्रिय करने के लिए स्वीकृति पर क्लिक करें।</p>
                          <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                              {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;']) !!}
                              <button type="submit" style="font-size: 1.1rem; padding: 0.75rem 2rem; background: var(--rudra-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(60,107,69,0.3);">
                                  ✓ प्रस्ताव स्वीकृत करें
                              </button>
                              {!! Form::close() !!}

                              <button type="button" onclick="document.getElementById('declineModalRudra').style.display='flex'" style="font-size: 1.1rem; padding: 0.75rem 1.75rem; background: transparent; color: var(--rudra-danger); border: 1px solid var(--rudra-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                                  ✕ अस्वीकृत करें
                              </button>
                          </div>
                          @if(!empty($razorpayKey))
                              <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px dashed var(--rudra-border-strong);">
                                  <p style="font-size: 0.9rem; color: var(--rudra-muted); margin-bottom: 0.75rem;">या तुरंत सुरक्षित चेकआउट के माध्यम से सीधे भुगतान करें:</p>
                                  <button type="button" class="btn-rzp-pay" style="font-size: 1rem; padding: 0.6rem 1.75rem; background: var(--rudra-accent); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                                      <i class="ti ti-shield-check"></i> अभी भुगतान करें — {{ \App\Models\Utility::priceFormat($settings, $totalDue) }}
                                  </button>
                              </div>
                          @endif
                      </div>
                  @endif
              </div>
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> दोबारा शुरू करने की शर्तें</h2>
          <ol class="terms">
            <li>कुल <strong>₹<span class="fill" contenteditable="true" style="min-width:5ch">16,800</span></strong> (केवल बकाया होस्टिंग + डोमेन — <strong>पुनः आरंभ शुल्क माफ़</strong>) काम शुरू होने से पहले <strong>अग्रिम देय</strong>।</li>
            <li>मूल डिलीवर स्कोप से बाहर का कोई भी नया काम अलग से कोट व स्वीकृत किया जाएगा।</li>
            <li><span class="deadline">उत्तर की समय-सीमा: 5 दिन</span> (ऊपर दी तारीख से)। 5 दिन में पुष्टि न होने पर प्रोजेक्ट बंद रहेगा, कोई संसाधन आरक्षित नहीं होंगे, और बाद में तत्कालीन दरों पर नया पुनःसक्रियण कोट लगेगा।</li>
          </ol>
        </section>

        <section>
          <h2><span class="n">6</span> रखरखाव व आगे का काम</h2>
          <p>रखरखाव मौजूदा, तयशुदा वेबसाइट को स्वस्थ रखता है — अपडेट, बैकअप, सुरक्षा व अपटाइम।</p>
          <div class="tbl-scroll">
            <table class="why">
              <thead><tr><th>विवरण</th><th>शुल्क</th></tr></thead>
              <tbody>
                <tr><td>रखरखाव — पहले 6 महीने</td><td><span class="pill good">नि:शुल्क</span> &nbsp;पुनः आरंभ तिथि से कोई शुल्क नहीं</td></tr>
                <tr><td>रखरखाव — 6 महीने बाद</td><td>बाद में तय होगा, साइट के <strong>प्रदर्शन व ट्रैफ़िक</strong> के आधार पर</td></tr>
                <tr><td>रखरखाव का दायरा</td><td>केवल <strong>तयशुदा कार्य</strong> (मौजूदा फ़ीचर व देखरेख) शामिल</td></tr>
                <tr><td>नए फ़ीचर / मॉड्यूल</td><td>कोई भी नया काम अलग से, <strong>₹800 / घंटा</strong></td></tr>
              </tbody>
            </table>
          </div>
          <div class="clause">
            <p><strong>निष्क्रियता खंड।</strong> यदि प्रोजेक्ट को लगातार <strong>15 दिन</strong> तक कोई ग्राहक फीडबैक या स्वीकृति नहीं मिलती, तो इसे स्वतः <em>रुका हुआ (paused)</em> मान लिया जाएगा। दोबारा शुरू करने के लिए पुनः आरंभ शुल्क (इस बार सद्भावना स्वरूप माफ़) काम जारी रखने से पहले देय होगा। <strong>30 दिन</strong> की निष्क्रियता के बाद प्रोजेक्ट बंद किया जा सकता है और अब तक हुए काम का अंतिम इनवॉइस भेजा जा सकता है।</p>
          </div>
        </section>

        <div class="proposal-contact-footer" style="margin-top: 3rem; padding: 2rem; background: var(--rudra-bg); border: 1px solid var(--rudra-border); border-radius: 12px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1.5rem; align-items: center;">
          <div>
            <h4 style="margin: 0 0 0.5rem; color: var(--rudra-ink); font-size: 1.1rem; font-weight: 700;">Animazon डिज़ाइन एवं वेब स्टूडियो</h4>
            <p style="margin: 0; color: var(--rudra-muted); font-size: 0.9rem; line-height: 1.6;">
              <strong>ईमेल:</strong> <a href="mailto:info@animazon.in" style="color: var(--rudra-accent); text-decoration: none; font-weight: 600;">info@animazon.in</a> &nbsp;|&nbsp; 
              <strong>फ़ोन / WhatsApp:</strong> <a href="tel:+918089405950" style="color: var(--rudra-accent); text-decoration: none; font-weight: 600;">+91 80894 05950</a>
            </p>
            <p style="margin: 0.3rem 0 0; color: var(--rudra-muted); font-size: 0.85rem;">
              <strong>वेबसाइट:</strong> <a href="https://animazon.in" target="_blank" style="color: var(--rudra-ink); text-decoration: underline;">https://animazon.in</a>
            </p>
          </div>
          <div style="display: flex; gap: 0.75rem;">
            <a href="mailto:info@animazon.in" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: var(--rudra-surface); border: 1px solid var(--rudra-border-strong); color: var(--rudra-ink); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
              ✉️ ईमेल करें
            </a>
            <a href="https://wa.me/918089405950" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37,211,102,0.2);">
              💬 WhatsApp
            </a>
          </div>
        </div>

        <div class="sign">
          <div><div class="line"></div>ग्राहक (rudraspirit.com) — हस्ताक्षर व दिनांक</div>
          <div><div class="line"></div><strong>Animazon डिज़ाइन एवं वेब स्टूडियो</strong><br><span style="font-size: 0.85rem; color: var(--rudra-muted);">info@animazon.in | +91 80894 05950</span></div>
        </div>
    </article>
  </div>

  <!-- Sticky / Fixed Bottom Payment Bar (Visible While Scrolling) -->
  <div id="stickyPaymentBar" style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 999; background: var(--rudra-surface); border-top: 2px solid var(--rudra-border-strong); box-shadow: 0 -8px 30px rgba(0,0,0,0.25); padding: 0.85rem clamp(1.5rem, 4vw, 3.5rem); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
      <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
          <div>
              <span style="font-size: 0.72rem; color: var(--rudra-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block;">Total Payable Now / देय राशि</span>
              <strong style="font-size: 1.35rem; color: var(--rudra-ink);">{{ \App\Models\Utility::priceFormat($settings, $totalDue) }}</strong>
          </div>
          @if($isAccepted && $totalDue > 0)
              <span style="padding: 0.35rem 0.85rem; background: var(--rudra-good-soft); color: var(--rudra-good); font-weight: 700; border-radius: 20px; font-size: 0.85rem; border: 1px solid var(--rudra-good);">✓ Approved & Ready for Payment</span>
          @elseif($isAccepted && $totalDue <= 0)
              <span style="padding: 0.35rem 0.85rem; background: var(--rudra-good-soft); color: var(--rudra-good); font-weight: 700; border-radius: 20px; font-size: 0.85rem; border: 1px solid var(--rudra-good);">✓ Paid in Full</span>
          @elseif($isDeclined)
              <span style="padding: 0.35rem 0.85rem; background: var(--rudra-danger-soft); color: var(--rudra-danger); font-weight: 700; border-radius: 20px; font-size: 0.85rem; border: 1px solid var(--rudra-danger);">✕ Proposal Declined</span>
          @else
              <span style="padding: 0.35rem 0.85rem; background: var(--rudra-accent-soft); color: var(--rudra-accent-deep); font-weight: 700; border-radius: 20px; font-size: 0.85rem; border: 1px solid var(--rudra-accent-deep);">⚠️ Action Required: Approve Proposal</span>
          @endif
      </div>
      <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
          @if($isAccepted && $totalDue > 0 && !empty($razorpayKey))
              <button type="button" class="btn-rzp-pay" style="font-size: 1rem; padding: 0.65rem 1.75rem; background: var(--rudra-accent); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(0,0,0,0.2);">
                  <i class="ti ti-shield-check"></i> Pay Now — {{ \App\Models\Utility::priceFormat($settings, $totalDue) }}
              </button>
          @elseif(!$isAccepted && !$isDeclined)
              {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;']) !!}
              <button type="submit" style="font-size: 1rem; padding: 0.65rem 1.5rem; background: var(--rudra-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(60,107,69,0.3);">
                  ✓ Approve Proposal
              </button>
              {!! Form::close() !!}
              <button type="button" onclick="document.getElementById('declineModalRudra').style.display='flex'" style="font-size: 1rem; padding: 0.65rem 1.25rem; background: transparent; color: var(--rudra-danger); border: 1px solid var(--rudra-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                  ✕ Decline
              </button>
          @endif
      </div>
  </div>
</div>

<!-- Decline Modal -->
<div id="declineModalRudra" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: var(--rudra-surface); color: var(--rudra-ink); border-radius: 14px; max-width: 480px; width: 100%; padding: 1.75rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid var(--rudra-border);">
        {!! Form::open(['route' => ['proposal.public.decline', $publicParam], 'method' => 'POST']) !!}
        <h4 style="margin: 0 0 1rem; color: var(--rudra-ink); font-weight: 700;">Decline Proposal / प्रस्ताव अस्वीकृत करें</h4>
        <label style="display: block; font-size: 0.85rem; color: var(--rudra-muted); margin-bottom: 0.5rem;">Reason (optional) / कारण (वैकल्पिक)</label>
        <textarea name="reason" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--rudra-border-strong); border-radius: 8px; background: var(--rudra-bg); color: var(--rudra-ink); margin-bottom: 1.5rem; font-family: inherit;"></textarea>
        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <button type="button" onclick="document.getElementById('declineModalRudra').style.display='none'" style="background: transparent; color: var(--rudra-muted); border: 1px solid var(--rudra-border-strong); padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
            <button type="submit" style="background: var(--rudra-danger); color: #fff; border: none; padding: 0.5rem 1.5rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Decline Proposal</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
  function setLang(l){
    document.documentElement.lang = l;
    if (window.speechSynthesis) {
      window.speechSynthesis.cancel();
      // Reset is-speaking classes/icons on buttons
      document.querySelectorAll('[data-role="proposal-read-aloud"]').forEach(function(btn) {
        btn.classList.remove('is-speaking');
        var icon = btn.querySelector('i');
        if (icon) icon.className = 'ti ti-volume-2';
      });
    }
    var pe = document.getElementById('pane-en');
    var ph = document.getElementById('pane-hi');
    if(pe) pe.hidden = (l!=='en');
    if(ph) ph.hidden = (l!=='hi');
    var be = document.getElementById('btn-en');
    var bh = document.getElementById('btn-hi');
    if(be) be.setAttribute('aria-pressed', l==='en');
    if(bh) bh.setAttribute('aria-pressed', l==='hi');
  }
  function toggleRudraTheme(){
    var r = document.documentElement;
    var current = r.getAttribute('data-theme') || 'light';
    r.setAttribute('data-theme', current === 'dark' ? 'light' : 'dark');
  }
  function num(t){ return parseInt((t||'').replace(/[^0-9]/g,''),10)||0; }
  function fmt(n){ return n.toLocaleString('en-IN'); }
  function recalc(pane){
    var rate=num(pane.querySelector('.rate')?.textContent);
    var months=num(pane.querySelector('.months')?.textContent);
    var host=rate*months;
    var hs=pane.querySelector('.host-sub'); if(hs) hs.textContent=fmt(host);
    var tv=pane.querySelector('.total-val'); if(tv) tv.textContent=fmt(host);
  }
  document.querySelectorAll('.sheet').forEach(function(pane){
    pane.querySelectorAll('.rate,.months,.fee').forEach(function(el){
      el.addEventListener('input', function(){ recalc(pane); });
    });
  });
  function toggleSubscriptionWidget(lang, isChecked) {
    var box = document.getElementById('subWidgetBox' + lang);
    var text = document.getElementById('subStatusText' + lang);
    if (isChecked) {
        if(box) box.style.display = 'block';
        if(text) {
            text.innerText = (lang === 'En') ? 'Yes, Add Subscription' : 'हाँ, सदस्यता जोड़ें';
            text.style.color = 'var(--rudra-good)';
        }
    } else {
        if(box) box.style.display = 'none';
        if(text) {
            text.innerText = (lang === 'En') ? 'No, skip for now' : 'नहीं, अभी छोड़ें';
            text.style.color = 'var(--rudra-muted)';
        }
    }
  }
</script>

@if(!$isDeclined && !$isExpired && $totalDue > 0 && !empty($razorpayKey))
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function triggerRazorpayCheckout() {
            var options = {
                key: "{{ $razorpayKey }}",
                amount: {{ (int) round($totalDue * 100) }},
                currency: "INR",
                name: "{{ !empty($company_setting['company_name']) ? $company_setting['company_name'] : config('app.name', 'ANIMAZON') }}",
                description: "Proposal #{{ \Auth::user() ? \Auth::user()->proposalNumberFormat($proposal->proposal_id) : $proposal->proposal_id }} Payment",
                handler: function (response) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('proposal.public.pay.razorpay', $publicParam) }}";
                    form.style.display = 'none';

                    var tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = "{{ csrf_token() }}";
                    form.appendChild(tokenInput);

                    var payIdInput = document.createElement('input');
                    payIdInput.type = 'hidden';
                    payIdInput.name = 'razorpay_payment_id';
                    payIdInput.value = response.razorpay_payment_id;
                    form.appendChild(payIdInput);

                    var amountInput = document.createElement('input');
                    amountInput.type = 'hidden';
                    amountInput.name = 'amount';
                    amountInput.value = "{{ $totalDue }}";
                    form.appendChild(amountInput);

                    document.body.appendChild(form);
                    form.submit();
                },
                prefill: {
                    name: "{{ !empty($customer) ? $customer->name : '' }}",
                    email: "{{ !empty($customer) ? $customer->email : '' }}",
                    contact: "{{ !empty($customer) ? $customer->contact : '' }}"
                },
                theme: {
                    color: "{{ $color ? $color : '#A96E1B' }}"
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }

        document.querySelectorAll('.btn-rzp-pay').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                triggerRazorpayCheckout();
            });
        });
    </script>
@endif
