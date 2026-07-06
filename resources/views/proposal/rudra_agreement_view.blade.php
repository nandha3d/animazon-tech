@php
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);

    $agreementSegmentsEn = [
        "Proposal 1: Initial Website Development and Maintenance Agreement for rudraspirit.com.",
        "Section 1: Scope of Work. The project included a premium custom website of up to 20 pages, 2 payment gateway integrations, inventory management, product variants, customer dashboard, and e-commerce tracking.",
        "Section 2: Financial Schedule. The total development cost was 40,000 rupees, payable across three milestones: 20,000 rupees advance, 10,000 rupees mid-development, and 10,000 rupees upon completion. This amount has been paid in full.",
        "Section 3: Hosting and Renewal Terms. As stated in Sections 3 and 7 of the agreement, the initial 40,000 rupees fee included domain registration and hosting services for one year only. Section 7.2 explicitly states that subsequent hosting renewal is not included in maintenance and is charged separately at the current market rate.",
        "Section 4: Maintenance and Support. The agreement provided 6 months of free post-launch support. After 6 months, ongoing maintenance is billed at 3,000 rupees per month.",
        "Section 5: Current Status. This initial agreement is fully executed and paid. To view the 1-month project completion timeline and reactivate development, please switch to Proposal 2."
    ];

    $agreementSegmentsHi = [
        "प्रस्ताव 1: रूद्र स्पिरिट डॉट कॉम के लिए प्रारंभिक वेबसाइट निर्माण और रखरखाव समझौता।",
        "भाग 1: कार्य का दायरा। इस प्रोजेक्ट में 20 पेजों तक की कस्टम डिज़ाइन वेबसाइट, 2 पेमेंट गेटवे इंटीग्रेशन, इन्वेंट्री मैनेजमेंट, और ई-कॉमर्स ट्रैकिंग शामिल थे।",
        "भाग 2: वित्तीय अनुसूची। वेबसाइट निर्माण की कुल लागत 40,000 रुपये थी, जिसका भुगतान तीन चरणों में किया गया: 20,000 रुपये अग्रिम, 10,000 रुपये मध्य-निर्माण, और 10,000 रुपये पूर्ण होने पर। यह पूरी राशि प्राप्त हो चुकी है।",
        "भाग 3: होस्टिंग और नवीनीकरण शर्तें। समझौते के भाग 3 और 7 के अनुसार, प्रारंभिक 40,000 रुपये के शुल्क में केवल एक वर्ष के लिए डोमेन और होस्टिंग सेवा शामिल थी। भाग 7.2 स्पष्ट करता है कि इसके बाद होस्टिंग नवीनीकरण रखरखाव में शामिल नहीं है और इसे वर्तमान बाजार दर पर अलग से लिया जाएगा।",
        "भाग 4: रखरखाव और सहायता। समझौते में लॉन्च के बाद 6 महीने की निःशुल्क सहायता शामिल थी। 6 महीने के बाद, निरंतर सहायता शुल्क 3,000 रुपये प्रति माह निर्धारित है।",
        "भाग 5: वर्तमान स्थिति। यह प्रारंभिक समझौता पूर्ण और भुगतान किया हुआ है। 1-महीने की पूर्णता समय-सीमा देखने और काम दोबारा शुरू करने के लिए, कृपया प्रस्ताव 2 पर जाएं।"
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
  :root[data-theme="dark"], [data-theme="dark"], [data-theme-root="dark"] {
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
  .rudra-view-container .studio-badge { font-size: 0.72rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--rudra-good); font-weight: 700; padding: 0.3rem 0.75rem; background: var(--rudra-good-soft); border: 1px solid var(--rudra-border-strong); border-radius: 6px; }
  .rudra-view-container .header-actions-area { display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap; }
  .rudra-view-container .logo-for-light { display: block !important; }
  .rudra-view-container .logo-for-dark { display: none !important; }
  :root[data-theme="dark"] .rudra-view-container .logo-for-light,
  [data-theme="dark"] .logo-for-light,
  [data-theme-root="dark"] .logo-for-light { display: none !important; }
  :root[data-theme="dark"] .rudra-view-container .logo-for-dark,
  [data-theme="dark"] .logo-for-dark,
  [data-theme-root="dark"] .logo-for-dark { display: block !important; }
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

  .rudra-view-container .sheet { background: var(--rudra-surface); border: 1px solid var(--rudra-border); border-radius: 14px; box-shadow: var(--rudra-shadow); overflow: hidden; }
  .rudra-view-container .sheet-pad { padding: clamp(1.5rem, 4vw, 3rem); }
  .rudra-view-container [hidden] { display: none !important; }

  .rudra-view-container .mast { border-bottom: 1px solid var(--rudra-border); padding-bottom: 1.5rem; }
  .rudra-view-container .brand { display: flex; align-items: baseline; gap: .6rem; margin: 0 0 1.25rem; flex-wrap: wrap; }
  .rudra-view-container .brand .mark { font-size: 1.2rem; font-weight: 800; letter-spacing: .01em; display: inline-flex; align-items: center; gap: .4rem; color: var(--rudra-ink); }
  .rudra-view-container .brand .mark::before { content: ""; width: .55rem; height: .55rem; border-radius: 50%; background: var(--rudra-good); display: inline-block; }
  .rudra-view-container .brand .tag { font-size: .66rem; letter-spacing: .15em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; }
  .rudra-view-container .eyebrow { font-size: .73rem; letter-spacing: .13em; text-transform: uppercase; color: var(--rudra-good); font-weight: 700; margin: 0 0 .55rem; display: flex; align-items: center; gap: .55rem; }
  .rudra-view-container .eyebrow::before { content: ""; width: 1.6rem; height: 2px; background: var(--rudra-good); display: inline-block; }
  .rudra-view-container h1 { font-size: clamp(1.6rem, 4.4vw, 2.25rem); line-height: 1.18; margin: 0; letter-spacing: -.015em; text-wrap: balance; font-weight: 700; color: var(--rudra-ink); }
  .rudra-view-container .lang-hi h1 { line-height: 1.32; }
  .rudra-view-container .sub { color: var(--rudra-muted); margin: .6rem 0 0; font-size: 1rem; line-height: 1.55; }

  .rudra-view-container .meta { display: grid; grid-template-columns: repeat(2, 1fr); gap: .9rem 2rem; margin-top: 1.5rem; }
  @media (max-width: 32rem) { .rudra-view-container .meta { grid-template-columns: 1fr; } }
  .rudra-view-container .meta div { display: flex; flex-direction: column; gap: .15rem; }
  .rudra-view-container .meta dt { font-size: .71rem; letter-spacing: .06em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; margin: 0; }
  .rudra-view-container .meta dd { margin: 0; font-weight: 600; color: var(--rudra-ink); }

  .rudra-view-container section { margin-top: 2.15rem; }
  .rudra-view-container h2 { font-size: 1.05rem; margin: 0 0 .8rem; line-height: 1.4; display: flex; align-items: baseline; gap: .65rem; color: var(--rudra-ink); font-weight: 700; }
  .rudra-view-container h2 .n { color: var(--rudra-good); font-size: .8rem; font-weight: 700; font-variant-numeric: tabular-nums; border: 1px solid var(--rudra-border-strong); border-radius: 6px; padding: .05rem .42rem; line-height: 1.4; flex: none; }
  .rudra-view-container p { margin: .7rem 0; color: var(--rudra-ink); }
  .rudra-view-container strong { font-weight: 700; }

  /* pills */
  .rudra-view-container .pill { display: inline-block; font-size: .72rem; font-weight: 700; letter-spacing: .02em; padding: .12rem .55rem; border-radius: 999px; white-space: nowrap; }
  .rudra-view-container .pill.paid { background: var(--rudra-good-soft); color: var(--rudra-good); }
  .rudra-view-container .pill.due { background: var(--rudra-accent-soft); color: var(--rudra-accent-deep); }
  .rudra-view-container .pill.out { background: var(--rudra-danger-soft); color: var(--rudra-danger); }

  /* milestone table */
  .rudra-view-container .pay { margin-top: 1.5rem; border: 1px solid var(--rudra-border-strong); border-radius: 12px; overflow: hidden; background: var(--rudra-surface); }
  .rudra-view-container .pay table { width: 100%; border-collapse: collapse; margin: 0; }
  .rudra-view-container .pay th, .rudra-view-container .pay td { padding: .7rem .9rem; text-align: left; border-bottom: 1px solid var(--rudra-border); }
  .rudra-view-container .pay thead th { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: var(--rudra-muted); font-weight: 700; background: var(--rudra-good-soft); border-bottom: 1px solid var(--rudra-border-strong); }
  .rudra-view-container .pay td.amt, .rudra-view-container .pay th.amt { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; font-weight: 700; color: var(--rudra-ink); }
  .rudra-view-container .pay td.item { font-weight: 600; color: var(--rudra-ink); }
  .rudra-view-container .pay tr.total td { border-bottom: none; background: linear-gradient(180deg, var(--rudra-good-soft), transparent); font-size: 1.05rem; }
  .rudra-view-container .pay tr.total td.item { font-weight: 800; letter-spacing: -.01em; color: var(--rudra-ink); }

  /* feature grid */
  .feature-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1rem; margin-top: 1rem; }
  .feature-card { padding: 1rem; border: 1px solid var(--rudra-border); border-radius: 10px; background: var(--rudra-bg); }
  .feature-card h4 { font-size: 0.95rem; margin: 0 0 0.4rem; font-weight: 700; color: var(--rudra-ink); display: flex; align-items: center; gap: 0.5rem; }
  .feature-card p { font-size: 0.85rem; margin: 0; color: var(--rudra-muted); }

  /* callout box */
  .callout-hosting { border-left: 4px solid var(--rudra-accent); background: var(--rudra-accent-soft); padding: 1.25rem 1.5rem; border-radius: 8px; margin: 1.5rem 0; }
  .callout-hosting h3 { font-size: 1rem; margin: 0 0 0.5rem; font-weight: 700; color: var(--rudra-accent-deep); display: flex; align-items: center; gap: 0.5rem; }

  /* signature area */
  .sig-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed var(--rudra-border-strong); }
  @media (max-width: 32rem) { .sig-grid { grid-template-columns: 1fr; } }
  .sig-box { padding: 1.25rem; border: 1px solid var(--rudra-border); border-radius: 10px; background: var(--rudra-bg); }
  .sig-box h4 { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--rudra-muted); margin: 0 0 1rem; }
  .sig-line { font-family: 'Courier New', Courier, monospace; font-size: 1.1rem; font-weight: 700; color: var(--rudra-ink); border-bottom: 1px solid var(--rudra-border-strong); padding-bottom: 0.4rem; margin-bottom: 0.5rem; }
</style>

<div class="rudra-view-container" data-theme-root>
  @include('proposal.brand_header', [
      'proposal' => $proposal,
      'langType' => 'hi',
      'langNameLocal' => 'हिन्दी (Hindi)',
      'segmentsEn' => json_encode($agreementSegmentsEn),
      'segmentsLocal' => json_encode($agreementSegmentsHi),
      'audioUrlEn' => $proposal->getTtsAudioUrl('en'),
      'audioUrlLocal' => $proposal->getTtsAudioUrl('hi')
  ])

  <div class="wrap">
    <!-- Chronological Proposal Navigation Switcher -->
    <div class="sheet mb-4" style="border-left: 4px solid var(--rudra-good);">
      <div class="sheet-pad" style="padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <div style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--rudra-muted); font-weight: 700;">Chronological Proposal Navigation</div>
          <div style="font-weight: 700; color: var(--rudra-ink);">Viewing: <span style="color: var(--rudra-good);">Proposal #1 — Initial Development & Maintenance Agreement (Nov 2025)</span></div>
        </div>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
          <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; background: var(--rudra-good); color: #fff;">
            ✔ Proposal #1 (Paid in Full)
          </span>
          <a href="{{ url('/customer/proposal/rudra-spirit-hosting') }}" class="btn-nav ghost" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: 1px solid var(--rudra-accent); color: var(--rudra-accent); background: var(--rudra-accent-soft);">
            🚀 View Proposal #2: Reactivation & 1-Month Delivery Plan →
          </a>
        </div>
      </div>
    </div>

    <!-- ENGLISH VERSION -->
    <article class="sheet lang-en" id="rudra-doc-en">
      <div class="sheet-pad">
        <header class="mast">
          <div class="brand">
            <span class="mark">Animazon Studio</span>
            <span class="tag">Executed Agreement • Proposal #1</span>
          </div>
          <p class="eyebrow">Initial Website Development Package</p>
          <h1>Website Development and Maintenance Agreement</h1>
          <p class="sub">This document represents the initial contract executed on <strong>28 November 2025</strong> between Animazon and Rudra Spirit for the complete build and delivery of <a href="https://rudraspirit.com" target="_blank" style="color: var(--rudra-accent); text-decoration: underline;">rudraspirit.com</a>.</p>

          <dl class="meta">
            <div><dt>Service Provider</dt><dd>Animazon (Nandhakumar G)</dd></div>
            <div><dt>Client / Project</dt><dd>Rudra Spirit (rudraspirit.com)</dd></div>
            <div><dt>Agreement Date</dt><dd>28 November 2025</dd></div>
            <div><dt>Financial Status</dt><dd><span class="pill paid">✔ PAID IN FULL (₹40,000)</span></dd></div>
          </dl>
        </header>

        <!-- Section 1: Scope of Work -->
        <section>
          <h2><span class="n">01</span> Scope of Work &amp; Package Features</h2>
          <p>As per Section 1.2 of the agreement, the <strong>"Business Plan" Package</strong> included the complete end-to-end custom development of the e-commerce platform with the following deliverables:</p>
          <div class="feature-grid">
            <div class="feature-card"><h4>✨ Custom Design</h4><p>Up to 20 custom-designed pages with responsive mobile &amp; desktop layouts.</p></div>
            <div class="feature-card"><h4>💳 Payment Gateways</h4><p>Integration of 2 secure payment gateways for seamless online transactions.</p></div>
            <div class="feature-card"><h4>📦 Inventory &amp; SKUs</h4><p>Full inventory management, product variants (size, color), and bulk upload.</p></div>
            <div class="feature-card"><h4>🚚 Shipping Partner</h4><p>Integration with 1 shipping courier partner and multiple shipping options.</p></div>
            <div class="feature-card"><h4>⭐ Reviews &amp; Wishlist</h4><p>Customer product reviews, ratings, wishlist functionality, and related products.</p></div>
            <div class="feature-card"><h4>👤 Customer Dashboard</h4><p>User account management, order history tracking, and address books.</p></div>
            <div class="feature-card"><h4>🏷️ Coupons &amp; Invoices</h4><p>Discount coupon management, automated invoice generation, and email alerts.</p></div>
            <div class="feature-card"><h4>📈 Google Analytics</h4><p>E-commerce tracking integration and basic product photography editing.</p></div>
          </div>
        </section>

        <!-- Section 2: Development Terms -->
        <section>
          <h2><span class="n">02</span> Terms &amp; Conditions for Development</h2>
          <p><strong>2.1 Project Timeline:</strong> The development time was agreed at <strong>15–20 working days</strong> from receiving advance payment and client content.</p>
          <p><strong>2.2 Revisions &amp; Data Entry:</strong> Included <strong>3 rounds of revisions</strong> on design and functionality during development. Initial data entry for <strong>25 SKUs</strong> included (additional SKUs charged at ₹40/SKU).</p>
          <p><strong>2.3 Out-of-Scope Work:</strong> Any features not explicitly defined in Section 1.2 (such as Live Chat, WhatsApp messaging, or custom SMS integrations) require separate written estimates and billing.</p>
        </section>

        <!-- Section 3: Financial Schedule -->
        <section>
          <h2><span class="n">03</span> Financial Terms &amp; Payment Schedule</h2>
          <p>As per Section 3 of the agreement, the total cost for the Website development, including domain and hosting for the initial one year, was agreed at <strong>₹40,000</strong>.</p>
          
          <div class="pay mb-3">
            <table>
              <thead>
                <tr>
                  <th>Milestone Stage</th>
                  <th>Due Event</th>
                  <th class="amt">Amount (₹)</th>
                  <th class="amt">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="item">1. Advance Payment</td>
                  <td>Upon signing of this Agreement (28 Nov 2025)</td>
                  <td class="amt">₹20,000.00</td>
                  <td class="amt"><span class="pill paid">PAID</span></td>
                </tr>
                <tr>
                  <td class="item">2. Mid-Development</td>
                  <td>Upon completion of design and core structure</td>
                  <td class="amt">₹10,000.00</td>
                  <td class="amt"><span class="pill paid">PAID</span></td>
                </tr>
                <tr>
                  <td class="item">3. Final Completion</td>
                  <td>Upon final approval and prior to live launch</td>
                  <td class="amt">₹10,000.00</td>
                  <td class="amt"><span class="pill paid">PAID</span></td>
                </tr>
                <tr class="total">
                  <td class="item" colspan="2">Total Build Package Cost (Paid in Full)</td>
                  <td class="amt">₹40,000.00</td>
                  <td class="amt"><span class="pill paid">✔ COMPLETED</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <p style="font-size: 0.88rem; color: var(--rudra-muted);"><em>Note (Section 3.1): Domain registration cost up to ₹800 was included in this initial build package.</em></p>
        </section>

        <!-- Section 4 & 7: Hosting Renewal & Maintenance (THE ANSWER TO THE USER'S QUESTION) -->
        <section>
          <h2><span class="n">04</span> Domain Registration, Hosting Renewal &amp; Maintenance Terms</h2>
          <div class="callout-hosting">
            <h3>💡 What does the Initial Agreement state about Hosting Charges?</h3>
            <p>To answer any questions regarding ongoing hosting fees, the initial contract explicitly separates the first-year build from subsequent annual hosting and maintenance renewals:</p>
            <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0; color: var(--rudra-ink); display: flex; flex-direction: column; gap: 0.5rem;">
              <li><strong>1st Year Included (Section 3 &amp; 7):</strong> The initial ₹40,000 development cost covered domain registration and basic shared hosting services <strong>for an initial period of one (1) year only</strong> (running from initial project commencement in Dec 2025 to Dec 2026).</li>
              <li><strong>Separate Renewal &amp; Upgrade Charges (Section 7.2):</strong> <em>"The cost for domain registration and hosting renewal or server upgrades is <strong>not included</strong> in the annual maintenance fee and will be <strong>charged separately at the then-current market rate</strong>. The Company is not responsible for any price increases for these third-party services."</em></li>
              <li><strong>Consequences of Non-Renewal (Section 7.3):</strong> <em>"Failure by the Client to renew the domain name and hosting services before their expiration date may result in the Website becoming inaccessible, potential loss of the domain name, and additional charges for restoration services."</em></li>
              <li><strong>Post-Support Maintenance (Section 4.2 &amp; 6.2):</strong> Following the initial 6 months of free post-launch bug support, ongoing technical support and maintenance is established at <strong>₹3,000 per month</strong> (or discounted annual terms upon mutual agreement).</li>
            </ul>
          </div>
          <p><strong>Conclusion &amp; Link to Proposal #2:</strong> Because your initial one-year basic shared hosting period runs from <strong>December 2025 to December 2026</strong>, basic shared hosting remains included at no extra charge! However, as work paused for roughly 6 months, and your e-commerce store requires optimal Google SEO speed and high-traffic stability, we have provided an optional upgrade to Premium VPS Cloud Hosting and project reactivation terms in <a href="{{ url('/customer/proposal/rudra-spirit-hosting') }}" style="color: var(--rudra-accent); font-weight: 700; text-decoration: underline;">Proposal #2: Reactivation &amp; Optional VPS Upgrade</a>.</p>
        </section>

        <!-- Section 5: Ownership -->
        <section>
          <h2><span class="n">05</span> Deliverables &amp; Ownership</h2>
          <p><strong>5.2 Deliverables:</strong> Upon full and final payment of the ₹40,000 development fee (which was completed), Animazon provided the Client with full access and ownership of the Website, including source files, database, and administrative credentials.</p>
        </section>

        <!-- Section 8: Signatures -->
        <section>
          <h2><span class="n">06</span> Agreement Execution &amp; Signatures</h2>
          <p>This agreement was formally acknowledged and executed by both parties upon project commencement:</p>
          <div class="sig-grid">
            <div class="sig-box">
              <h4>For The Company: Animazon</h4>
              <div class="sig-line">NANDHAKUMAR G</div>
              <p style="font-size: 0.85rem; color: var(--rudra-muted); margin: 0;">Date: 28-11-2025 • Authorized Signature</p>
            </div>
            <div class="sig-box">
              <h4>For The Client: Rudra Spirit</h4>
              <div class="sig-line">RUDRASPIRIT.COM</div>
              <p style="font-size: 0.85rem; color: var(--rudra-muted); margin: 0;">Date: 28-11-2025 • Client Acceptance</p>
            </div>
          </div>
        </section>
      </div>
    </article>

    <!-- HINDI VERSION -->
    <article class="sheet lang-hi" id="rudra-doc-hi" hidden>
      <div class="sheet-pad">
        <header class="mast">
          <div class="brand">
            <span class="mark">एनीमेज़ॉन स्टूडियो</span>
            <span class="tag">निष्पादित समझौता • प्रस्ताव #1</span>
          </div>
          <p class="eyebrow">प्रारंभिक वेबसाइट निर्माण पैकेज</p>
          <h1>वेबसाइट निर्माण और रखरखाव समझौता</h1>
          <p class="sub">यह दस्तावेज़ एनीमेज़ॉन और रूद्र स्पिरिट के बीच <strong>28 नवंबर 2025</strong> को <a href="https://rudraspirit.com" target="_blank" style="color: var(--rudra-accent); text-decoration: underline;">rudraspirit.com</a> के पूर्ण निर्माण और डिलीवरी के लिए हस्ताक्षरित प्रारंभिक अनुबंध को दर्शाता है।</p>

          <dl class="meta">
            <div><dt>सेवा प्रदाता</dt><dd>एनीमेज़ॉन (नंदकुमार जी)</dd></div>
            <div><dt>क्लाइंट / प्रोजेक्ट</dt><dd>रूद्र स्पिरिट (rudraspirit.com)</dd></div>
            <div><dt>अनुबंध तिथि</dt><dd>28 नवंबर 2025</dd></div>
            <div><dt>वित्तीय स्थिति</dt><dd><span class="pill paid">✔ पूर्ण भुगतान (₹40,000)</span></dd></div>
          </dl>
        </header>

        <!-- Section 1: Scope of Work -->
        <section>
          <h2><span class="n">01</span> कार्य का दायरा और पैकेज विशेषताएं</h2>
          <p>अनुबंध के भाग 1.2 के अनुसार, <strong>"बिज़नेस प्लान" पैकेज</strong> में निम्नलिखित सुविधाओं के साथ ई-कॉमर्स प्लेटफॉर्म का संपूर्ण कस्टम निर्माण शामिल था:</p>
          <div class="feature-grid">
            <div class="feature-card"><h4>✨ कस्टम डिज़ाइन</h4><p>मोबाइल और डेस्कटॉप के लिए 20 पेजों तक की कस्टम-डिज़ाइन वेबसाइट।</p></div>
            <div class="feature-card"><h4>💳 पेमेंट गेटवे</h4><p>सुरक्षित ऑनलाइन लेनदेन के लिए 2 पेमेंट गेटवे का इंटीग्रेशन।</p></div>
            <div class="feature-card"><h4>📦 इन्वेंट्री और SKU</h4><p>पूर्ण इन्वेंट्री प्रबंधन, प्रोडक्ट वेरिएंट (साइज़, रंग), और बल्क अपलोड।</p></div>
            <div class="feature-card"><h4>🚚 शिपिंग पार्टनर</h4><p>1 शिपिंग कूरियर पार्टनर इंटीग्रेशन और कई शिपिंग विकल्प।</p></div>
            <div class="feature-card"><h4>⭐ रिव्यू और विशलिस्ट</h4><p>ग्राहक प्रोडक्ट रिव्यू, रेटिंग, विशलिस्ट सुविधा, और संबंधित उत्पाद।</p></div>
            <div class="feature-card"><h4>👤 ग्राहक डैशबोर्ड</h4><p>यूज़र अकाउंट प्रबंधन, ऑर्डर हिस्ट्री ट्रैकिंग, और एड्रेस बुक।</p></div>
            <div class="feature-card"><h4>🏷️ कूपन और इनवॉइस</h4><p>डिस्काउंट कूपन प्रबंधन, स्वचालित इनवॉइस निर्माण, और ईमेल अलर्ट।</p></div>
            <div class="feature-card"><h4>📈 गूगल एनालिटिक्स</h4><p>ई-कॉमर्स ट्रैकिंग इंटीग्रेशन और बेसिक प्रोडक्ट फोटोग्राफी एडिटिंग।</p></div>
          </div>
        </section>

        <!-- Section 2: Development Terms -->
        <section>
          <h2><span class="n">02</span> निर्माण की शर्तें और नियम</h2>
          <p><strong>2.1 प्रोजेक्ट समयसीमा:</strong> निर्माण का समय अग्रिम भुगतान और सामग्री प्राप्त होने की तिथि से <strong>15-20 कार्य दिवस</strong> निर्धारित किया गया था।</p>
          <p><strong>2.2 संशोधन और डेटा एंट्री:</strong> निर्माण चरण के दौरान डिज़ाइन और कार्यक्षमता पर <strong>3 बार संशोधन (revisions)</strong> शामिल थे। शुरुआती <strong>25 SKU</strong> की डेटा एंट्री शामिल थी (अतिरिक्त SKU के लिए ₹40/SKU शुल्क)।</p>
          <p><strong>2.3 दायरे से बाहर का कार्य:</strong> भाग 1.2 में स्पष्ट रूप से परिभाषित न की गई सुविधाएं (जैसे लाइव चैट, व्हाट्सएप मैसेजिंग, या कस्टम एसएमएस) अलग लिखित अनुमान और शुल्क के अधीन हैं।</p>
        </section>

        <!-- Section 3: Financial Schedule -->
        <section>
          <h2><span class="n">03</span> वित्तीय शर्तें और भुगतान अनुसूची</h2>
          <p>अनुबंध के भाग 3 के अनुसार, पहले वर्ष के लिए डोमेन और होस्टिंग सहित वेबसाइट निर्माण की कुल लागत <strong>₹40,000</strong> निर्धारित की गई थी।</p>
          
          <div class="pay mb-3">
            <table>
              <thead>
                <tr>
                  <th>चरण</th>
                  <th>देय घटना</th>
                  <th class="amt">राशि (₹)</th>
                  <th class="amt">स्थिति</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="item">1. अग्रिम भुगतान</td>
                  <td>अनुबंध पर हस्ताक्षर करने पर (28 नव॰ 2025)</td>
                  <td class="amt">₹20,000.00</td>
                  <td class="amt"><span class="pill paid">भुगतान किया</span></td>
                </tr>
                <tr>
                  <td class="item">2. मध्य-निर्माण</td>
                  <td>डिज़ाइन और मुख्य संरचना पूरी होने पर</td>
                  <td class="amt">₹10,000.00</td>
                  <td class="amt"><span class="pill paid">भुगतान किया</span></td>
                </tr>
                <tr>
                  <td class="item">3. पूर्णता</td>
                  <td>अंतिम स्वीकृति और लाइव लॉन्च से पहले</td>
                  <td class="amt">₹10,000.00</td>
                  <td class="amt"><span class="pill paid">भुगतान किया</span></td>
                </tr>
                <tr class="total">
                  <td class="item" colspan="2">कुल निर्माण पैकेज लागत (पूर्ण भुगतान प्राप्त)</td>
                  <td class="amt">₹40,000.00</td>
                  <td class="amt"><span class="pill paid">✔ पूर्ण</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <p style="font-size: 0.88rem; color: var(--rudra-muted);"><em>नोट (भाग 3.1): इस शुरुआती पैकेज में ₹800 तक की डोमेन पंजीकरण लागत शामिल थी।</em></p>
        </section>

        <!-- Section 4 & 7: Hosting Renewal & Maintenance -->
        <section>
          <h2><span class="n">04</span> डोमेन पंजीकरण, होस्टिंग नवीनीकरण और रखरखाव शर्तें</h2>
          <div class="callout-hosting">
            <h3>💡 प्रारंभिक समझौते में होस्टिंग शुल्क के बारे में क्या कहा गया है?</h3>
            <p>होस्टिंग शुल्क से संबंधित किसी भी प्रश्न के उत्तर के लिए, प्रारंभिक अनुबंध स्पष्ट रूप से पहले वर्ष के निर्माण को बाद के वार्षिक होस्टिंग और रखरखाव नवीनीकरण से अलग करता है:</p>
            <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0; color: var(--rudra-ink); display: flex; flex-direction: column; gap: 0.5rem;">
              <li><strong>पहला वर्ष शामिल (भाग 3 और 7):</strong> प्रारंभिक ₹40,000 निर्माण शुल्क में <strong>केवल एक वर्ष की प्रारंभिक अवधि के लिए</strong> डोमेन पंजीकरण और बेसिक शेयर्ड होस्टिंग सेवा शामिल थी (दिसंबर 2025 से दिसंबर 2026 तक)।</li>
              <li><strong>अलग नवीनीकरण व अपग्रेड शुल्क (भाग 7.2):</strong> <em>"डोमेन पंजीकरण और होस्टिंग नवीनीकरण या सर्वर अपग्रेड की लागत वार्षिक रखरखाव शुल्क में <strong>शामिल नहीं है</strong> और इसे <strong>तत्कालीन बाजार दर पर अलग से लिया जाएगा</strong>। कंपनी इन तृतीय-पक्ष सेवाओं के मूल्य वृद्धि के लिए जिम्मेदार नहीं है।"</em></li>
              <li><strong>नवीनीकरण न करने के परिणाम (भाग 7.3):</strong> <em>"क्लाइंट द्वारा समाप्ति तिथि से पहले डोमेन नाम और होस्टिंग सेवा का नवीनीकरण न करने पर वेबसाइट दुर्गम (inaccessible) हो सकती है और डोमेन खोने का जोखिम हो सकता है।"</em></li>
              <li><strong>रखरखाव और सहायता (भाग 4.2 और 6.2):</strong> लॉन्च के बाद 6 महीने की निःशुल्क सहायता के पश्चात, निरंतर तकनीकी सहायता और रखरखाव शुल्क <strong>₹3,000 प्रति माह</strong> निर्धारित है।</li>
            </ul>
          </div>
          <p><strong>निष्कर्ष और प्रस्ताव #2 से लिंक:</strong> चूंकि आपकी शुरुआती एक वर्ष की बेसिक शेयर्ड होस्टिंग अवधि <strong>दिसंबर 2025 से दिसंबर 2026</strong> तक है, इसलिए बेसिक होस्टिंग बिना किसी अतिरिक्त शुल्क के शामिल है! हालाँकि, 6 महीने तक काम रुके रहने के कारण और आपके ई-कॉमर्स स्टोर को गूगल एसईओ स्पीड और उच्च ट्रैफिक क्षमता देने के लिए, हमने <a href="{{ url('/customer/proposal/rudra-spirit-hosting') }}" style="color: var(--rudra-accent); font-weight: 700; text-decoration: underline;">प्रस्ताव #2: प्रोजेक्ट पुनः सक्रियण और वैकल्पिक वीपीएस अपग्रेड</a> में प्रीमियम वीपीएस क्लाउड होस्टिंग का विकल्प और पुनः सक्रियण शर्तें दी हैं।</p>
        </section>

        <!-- Section 5: Ownership -->
        <section>
          <h2><span class="n">05</span> डिलीवरी और स्वामित्व</h2>
          <p><strong>5.2 डिलीवरी:</strong> ₹40,000 निर्माण शुल्क का पूर्ण भुगतान प्राप्त होने पर, एनीमेज़ॉन ने क्लाइंट को सोर्स फ़ाइलें, डेटाबेस और प्रशासनिक क्रेडेंशियल सहित वेबसाइट का पूर्ण स्वामित्व और एक्सेस प्रदान कर दिया था।</p>
        </section>

        <!-- Section 8: Signatures -->
        <section>
          <h2><span class="n">06</span> समझौता निष्पादन और हस्ताक्षर</h2>
          <p>यह समझौता प्रोजेक्ट शुरू होने पर दोनों पक्षों द्वारा औपचारिक रूप से स्वीकार और हस्ताक्षरित किया गया था:</p>
          <div class="sig-grid">
            <div class="sig-box">
              <h4>कंपनी की ओर से: एनीमेज़ॉन</h4>
              <div class="sig-line">NANDHAKUMAR G</div>
              <p style="font-size: 0.85rem; color: var(--rudra-muted); margin: 0;">तिथि: 28-11-2025 • अधिकृत हस्ताक्षर</p>
            </div>
            <div class="sig-box">
              <h4>क्लाइंट की ओर से: रूद्र स्पिरिट</h4>
              <div class="sig-line">RUDRASPIRIT.COM</div>
              <p style="font-size: 0.85rem; color: var(--rudra-muted); margin: 0;">तिथि: 28-11-2025 • क्लाइंट स्वीकृति</p>
            </div>
          </div>
        </section>
      </div>
    </article>
  </div>
</div>

<script>
  (function() {
    var seg = document.querySelector('.rudra-view-container .seg');
    var btns = seg ? seg.querySelectorAll('button[data-lang]') : [];
    var docEn = document.getElementById('rudra-doc-en');
    var docHi = document.getElementById('rudra-doc-hi');

    btns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        btns.forEach(function(b) { b.setAttribute('aria-pressed', 'false'); });
        btn.setAttribute('aria-pressed', 'true');
        var lang = btn.getAttribute('data-lang');
        if (lang === 'hi') {
          if (docEn) docEn.hidden = true;
          if (docHi) docHi.hidden = false;
        } else {
          if (docEn) docEn.hidden = false;
          if (docHi) docHi.hidden = true;
        }
      });
    });

    var toggleBtn = document.getElementById('rudraThemeToggleBtn');
    var themeIcon = document.getElementById('rudraThemeIcon');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', function() {
        var current = document.documentElement.getAttribute('data-theme') || 'light';
        var next = (current === 'dark') ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('rudra_theme_pref', next);
        if (themeIcon) {
          themeIcon.className = (next === 'dark') ? 'ti ti-sun' : 'ti ti-moon';
        }
      });
    }

    var saved = localStorage.getItem('rudra_theme_pref');
    if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.documentElement.setAttribute('data-theme', 'dark');
      if (themeIcon) themeIcon.className = 'ti ti-sun';
    } else {
      document.documentElement.setAttribute('data-theme', 'light');
      if (themeIcon) themeIcon.className = 'ti ti-moon';
    }
  })();
</script>
