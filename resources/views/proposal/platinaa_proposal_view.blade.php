@php
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);
    $totalPaid = $proposal->amountPaid();
    $isExpired = $proposal->isExpired();
    $isAccepted = $proposal->isAccepted();
    $isDeclined = $proposal->isDeclined();
    $isPending = !$isAccepted && !$isDeclined;

    $platinaaSegmentsEn = [
        "B2B Refinery Website Development Proposal for Platinaa Ceramics.",
        "Section 1: Project Scope. Animazon Design & Web Studio will deliver a comprehensive 15-to-20-page B2B website for the refinery industry. With a special partnership discount, the finalized fixed cost is just 15,000 rupees.",
        "Section 2: Time and Cost Estimation. The 65-hour project is billed at 800 rupees per hour, totaling 52,000 rupees. We have applied a 37,000 rupee discount to bring the final price to 15,000 rupees.",
        "Section 3: Maintenance Options. Since you have your own hosting, you only need to select a maintenance plan. Choose either a Monthly Retainer or a Pay-As-You-Go plan at 800 rupees per hour.",
        "Section 4: Optional 3D Website Upgrade. You can upgrade to a fully interactive 3D website for an additional 25,000 rupees. Preview this experience at animazon.in/ceramica.",
        "Section 5: Interactive Financial Quotation. Our live calculator updates your total payable amount based on your selected maintenance plan, optional add-ons, and payment schedule."
    ];

    $platinaaSegmentsTa = [
        "Platinaa Ceramics-க்கான B2B Refinery Website Development Proposal.",
        "Section 1: Project Scope. 15 முதல் 20 பக்கங்கள் கொண்ட விரிவான B2B இணையதளத்தை உருவாக்குவோம். சிறப்பு தள்ளுபடியுடன் இதன் இறுதி கட்டணம் 15,000 ரூபாய்.",
        "Section 2: Time and Cost Estimation. 65 மணிநேர திட்டத்திற்கு மணிக்கு 800 ரூபாய் வீதம் 52,000 ரூபாய். இதில் 37,000 ரூபாய் தள்ளுபடி போக, இறுதி விலை 15,000 ரூபாய்.",
        "Section 3: Maintenance Options. உங்களிடம் சொந்த ஹோஸ்டிங் உள்ளதால், பராமரிப்பு திட்டத்தை மட்டும் தேர்ந்தெடுக்கவும். மாதாந்திர திட்டம் அல்லது மணிக்கு 800 ரூபாய் திட்டத்தை நீங்கள் தேர்வு செய்யலாம்.",
        "Section 4: Optional 3D Website Upgrade. 25,000 ரூபாயில் முழுமையான 3D இணையதளத்தை நீங்கள் பெறலாம். இதற்கான முன்னோட்டத்தை animazon.in/ceramica -இல் காணலாம்.",
        "Section 5: Interactive Financial Quotation. நீங்கள் தேர்ந்தெடுக்கும் பராமரிப்பு, கூடுதல் அம்சங்கள் மற்றும் கட்டண முறையின் அடிப்படையில் உங்கள் மொத்த தொகையை லைவ் கால்குலேட்டர் புதுப்பிக்கும்."
    ];
@endphp

<style>
  :root, :root[data-theme="light"] {
    --platinaa-bg: #F8F9FA;
    --platinaa-surface: #FFFFFF;
    --platinaa-ink: #1a1a1a;
    --platinaa-muted: #6c757d;
    --platinaa-border: #dee2e6;
    --platinaa-border-strong: #ced4da;
    --platinaa-accent: #c82333;
    --platinaa-accent-deep: #a71d2a;
    --platinaa-accent-soft: #f8d7da;
    --platinaa-good: #28a745;
    --platinaa-good-soft: #d4edda;
    --platinaa-danger: #dc3545;
    --platinaa-danger-soft: #f8d7da;
    --platinaa-shadow: 0 4px 24px -4px rgba(200, 35, 51, 0.1);
    --platinaa-maxw: 76rem;
  }

  :root[data-theme="dark"], [data-theme="dark"], [data-theme-root="dark"] {
    --platinaa-bg: #121212;
    --platinaa-surface: #1e1e1e;
    --platinaa-ink: #f8f9fa;
    --platinaa-muted: #adb5bd;
    --platinaa-border: #343a40;
    --platinaa-border-strong: #495057;
    --platinaa-accent: #e4606d;
    --platinaa-accent-deep: #ff8793;
    --platinaa-accent-soft: rgba(228, 96, 109, 0.15);
    --platinaa-good: #4caf50;
    --platinaa-good-soft: rgba(76, 175, 80, 0.15);
    --platinaa-danger: #ef5350;
    --platinaa-danger-soft: rgba(239, 83, 80, 0.15);
    --platinaa-shadow: 0 4px 24px -4px rgba(0, 0, 0, 0.5);
  }

  .badge-highlight {
    background: linear-gradient(135deg, var(--platinaa-good), #1B5E20);
    color: #ffffff !important;
    font-weight: 800;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    display: inline-block;
    margin-bottom: 0.5rem;
    border: 1px solid rgba(255,255,255,0.3);
  }

  .platinaa-view-container {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--platinaa-ink);
    background-color: var(--platinaa-bg);
    line-height: 1.68;
    padding: 0 0 6.5rem;
    min-height: 100vh;
  }
  .platinaa-view-container .wrap { max-width: var(--platinaa-maxw); margin: 0 auto; padding: 1.5rem 1.5rem 6.5rem; }

  .platinaa-view-container .sheet { 
    background: var(--platinaa-surface); 
    border: 1px solid var(--platinaa-border); 
    border-radius: 16px; 
    box-shadow: var(--platinaa-shadow); 
    overflow: hidden;
    position: relative;
  }
  .platinaa-view-container .sheet::before {
    content: "";
    display: block;
    height: 6px;
    background: linear-gradient(to right, var(--platinaa-accent) 0%, #ff8793 100%);
  }
  .platinaa-view-container .sheet-pad { padding: clamp(1.5rem, 4vw, 3.5rem); }

  .platinaa-view-container [hidden] { display: none !important; }

  .platinaa-view-container .mast { border-bottom: 1px solid var(--platinaa-border); padding-bottom: 1.75rem; }
  .platinaa-view-container .eyebrow { font-size: 0.75rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--platinaa-accent); font-weight: 700; margin: 0 0 0.55rem; display: flex; align-items: center; gap: 0.55rem; }
  .platinaa-view-container .eyebrow::before { content: ""; width: 1.6rem; height: 3px; background: var(--platinaa-accent); display: inline-block; border-radius: 2px; }
  .platinaa-view-container h1 { font-size: clamp(1.65rem, 4.5vw, 2.45rem); line-height: 1.18; margin: 0; font-weight: 800; color: var(--platinaa-ink); }
  .platinaa-view-container .sub { color: var(--platinaa-muted); margin: 0.6rem 0 0; font-size: 1.05rem; line-height: 1.6; }

  .platinaa-view-container .meta { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem 2rem; margin-top: 1.75rem; background: var(--platinaa-accent-soft); padding: 1.25rem 1.5rem; border-radius: 12px; border: 1px solid var(--platinaa-border); }
  .platinaa-view-container .meta div { display: flex; flex-direction: column; gap: 0.2rem; }
  .platinaa-view-container .meta dt { font-size: 0.71rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--platinaa-muted); font-weight: 700; margin: 0; }
  .platinaa-view-container .meta dd { margin: 0; font-weight: 700; color: var(--platinaa-ink); font-size: 1rem; }

  .platinaa-view-container section { margin-top: 2.75rem; }
  .platinaa-view-container h2 { font-size: 1.28rem; margin: 0 0 1rem; line-height: 1.4; display: flex; align-items: center; gap: 0.65rem; color: var(--platinaa-ink); font-weight: 800; }
  .platinaa-view-container h2 .n { background: var(--platinaa-accent); color: #fff; font-size: 0.85rem; font-weight: 800; border-radius: 8px; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; flex: none; }
  
  .platinaa-view-container .pill { display: inline-block; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.02em; padding: 0.15rem 0.6rem; border-radius: 999px; }
  .platinaa-view-container .pill.paid { background: var(--platinaa-good-soft); color: var(--platinaa-good); border: 1px solid rgba(40,167,69,0.2); }
  .platinaa-view-container .pill.due { background: var(--platinaa-accent-soft); color: var(--platinaa-accent-deep); border: 1px solid rgba(200,35,51,0.2); }

  .interactive-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin: 1.25rem 0; }
  .select-card { border: 2px solid var(--platinaa-border-strong); border-radius: 12px; padding: 1.25rem; cursor: pointer; transition: all 0.2s ease; position: relative; display: flex; flex-direction: column; justify-content: space-between; }
  .select-card:hover { border-color: var(--platinaa-accent); transform: translateY(-2px); }
  .select-card.active { border-color: var(--platinaa-good); background: var(--platinaa-good-soft); box-shadow: 0 0 0 1px var(--platinaa-good); }
  .select-card.addon-active { border-color: var(--platinaa-accent); background: var(--platinaa-accent-soft); box-shadow: 0 0 0 1px var(--platinaa-accent); }
  .select-card input[type="radio"], .select-card input[type="checkbox"] { position: absolute; top: 1.25rem; right: 1.25rem; accent-color: var(--platinaa-good); width: 1.3rem; height: 1.3rem; cursor: pointer; }
  .select-card.addon-card input[type="checkbox"] { accent-color: var(--platinaa-accent); }
  .select-card .card-title { font-weight: 800; font-size: 1.08rem; color: var(--platinaa-ink); margin-bottom: 0.35rem; padding-right: 2rem; display: block; }
  .select-card .card-price { font-size: 1.35rem; font-weight: 800; color: var(--platinaa-accent); margin-bottom: 0.5rem; }
  .select-card .card-desc { font-size: 0.88rem; color: var(--platinaa-muted); line-height: 1.5; margin: 0; }

  .platinaa-view-container .pay { margin-top: 1.5rem; border: 1px solid var(--platinaa-border-strong); border-radius: 14px; overflow: hidden; background: var(--platinaa-surface); }
  .platinaa-view-container .pay table { width: 100%; border-collapse: collapse; margin: 0; }
  .platinaa-view-container .pay th, .platinaa-view-container .pay td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid var(--platinaa-border); }
  .platinaa-view-container .pay thead th { font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--platinaa-muted); font-weight: 700; background: var(--platinaa-accent-soft); }
  .platinaa-view-container .pay td.amt, .platinaa-view-container .pay th.amt { text-align: right; font-weight: 700; color: var(--platinaa-ink); font-variant-numeric: tabular-nums; }
  .platinaa-view-container .pay tr.total td { border-bottom: none; background: linear-gradient(180deg, var(--platinaa-accent-soft), transparent); font-size: 1.15rem; font-weight: 800; }
  .platinaa-view-container .pay tr.total td.amt { font-size: 1.75rem; color: var(--platinaa-accent); }
  
  .pay-action-box { margin: 2.5rem auto 1.5rem; max-width: 760px; padding: 2.25rem; border-radius: 16px; text-align: center; background: var(--platinaa-surface); border: 2px dashed var(--platinaa-accent); }
  
  /* Estimate Table */
  .est-table { width: 100%; border-collapse: collapse; margin: 1rem 0; text-align: left; font-size: 0.95rem; }
  .est-table th, .est-table td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--platinaa-border); }
  .est-table th { background: var(--platinaa-accent-soft); color: var(--platinaa-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; }
  .est-table td.hours { text-align: center; font-weight: 600; }
  .est-table td.amt { text-align: right; font-weight: 700; color: var(--platinaa-ink); font-variant-numeric: tabular-nums; }
  
  .discount-row { background: var(--platinaa-danger-soft); color: var(--platinaa-danger); }
  .discount-row td { color: var(--platinaa-danger) !important; font-weight: 700; }

  .preview-card { display: block; margin: 1.25rem 0 0; border-radius: 14px; overflow: hidden; border: 2px solid var(--platinaa-border-strong); transition: all 0.25s ease; text-decoration: none; }
  .preview-card:hover { border-color: var(--platinaa-accent); transform: translateY(-3px); box-shadow: 0 8px 28px -6px rgba(200, 35, 51, 0.18); }
  .preview-card .preview-img { width: 100%; height: 200px; object-fit: cover; display: block; background: var(--platinaa-accent-soft); }
  .preview-card .preview-body { padding: 1rem 1.25rem; background: var(--platinaa-surface); }
  .preview-card .preview-body strong { color: var(--platinaa-accent); font-size: 0.95rem; }
  .preview-card .preview-body p { margin: 0.25rem 0 0; font-size: 0.85rem; color: var(--platinaa-muted); }
</style>

<div class="platinaa-view-container" data-theme-root>
  @include('proposal.brand_header', [
      'proposal' => $proposal,
      'langType' => 'en',
      'langNameLocal' => 'English',
      'segmentsEn' => json_encode($platinaaSegmentsEn),
      'segmentsLocal' => json_encode($platinaaSegmentsTa),
      'audioUrlEn' => $proposal->getTtsAudioUrl('en'),
      'audioUrlLocal' => $proposal->getTtsAudioUrl('ta')
  ])

  <div class="wrap">
    <!-- ENGLISH -->
    <article class="sheet lang-en" id="pane-en" lang="en">
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">B2B Website Development Proposal</p>
          <h1>B2B Refinery Website Build Agreement — Platinaa Ceramics</h1>
          <p class="sub">Delivering an industrial B2B catalog platform (15-20 pages) with Request For Quote (RFQ) capabilities and cross-domain integration. Special discounted price of ₹15,000.</p>
          <dl class="meta">
            <div><dt>Client Brand</dt><dd>Platinaa Ceramics</dd></div>
            <div><dt>Final Build Fee</dt><dd>₹15,000 <span class="pill paid">Fixed Price</span></dd></div>
            <div><dt>Total Hours</dt><dd>65 Hours <span class="pill due">@ ₹800/hr</span></dd></div>
            <div><dt>Date</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>Prepared for</dt><dd><span>Platinaa Ceramics</span></dd></div>
            <div><dt>Prepared by</dt><dd><span>Animazon Design &amp; Web Studio</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> Project Scope &amp; Website Type</h2>
          <p>We will design and develop a highly professional, 15-to-20-page B2B website dedicated to the refinery industry, deployed at <strong>platinaaceramics.in</strong>. Choose your preferred website experience below:</p>

          <div class="interactive-grid">
            <label class="select-card active" onclick="selectPlatinaaOption('websiteType', 'normal', this)">
              <input type="radio" name="website_type_en" value="normal" checked>
              <span class="card-title">🌐 Standard B2B Website</span>
              <div class="card-price">₹15,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ fixed</span></div>
              <p class="card-desc">Professional, responsive multi-page website with product catalog, RFQ forms, and cross-domain search integration.</p>
            </label>
            <label class="select-card" onclick="selectPlatinaaOption('websiteType', '3d', this)">
              <input type="radio" name="website_type_en" value="3d">
              <div><span class="badge-highlight">✨ PREMIUM</span><span class="card-title">🚀 Interactive 3D Website</span></div>
              <div class="card-price">₹35,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ fixed</span></div>
              <p class="card-desc">Everything in Standard + fully interactive 3D WebGL experience with immersive product showcases and animations.</p>
            </label>
          </div>

          <a href="http://animazon.in/ceramica" target="_blank" class="preview-card" id="preview3d_en">
            <div class="preview-img" style="background: linear-gradient(135deg, #1a1a1a 0%, #c82333 100%); display:flex; align-items:center; justify-content:center;">
              <span style="color:#fff; font-size:2.5rem; font-weight:800; text-shadow: 0 2px 12px rgba(0,0,0,0.3);">🎯 Click to Preview 3D Demo</span>
            </div>
            <div class="preview-body">
              <strong>animazon.in/ceramica →</strong>
              <p>See the live 3D interactive ceramics experience we've already built. This is exactly what your website could look like.</p>
            </div>
          </a>

          <div style="margin-top: 1.5rem;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--platinaa-ink); margin: 0 0 0.65rem;">Core Deliverables (Both Options Include):</h3>
            <ul>
              <li><strong>Home:</strong> Impactful Hero section, Industries Served (Refinery focus), Products Overview, and Trust Badges.</li>
              <li><strong>About Us:</strong> Corporate profile, mission, and the legacy of Platinaa Ceramics.</li>
              <li><strong>Products Catalog:</strong> Detailed category and product pages (Refinery Grinding Balls, Catalyst Bed Supports, Alumina Ceramic Balls, etc.).</li>
              <li><strong>Infrastructure / Quality:</strong> Outlining manufacturing capabilities, lab testing, and QA/QC standards.</li>
              <li><strong>Contact Us / RFQ:</strong> Lead generation forms tailored specifically for bulk industrial orders.</li>
            </ul>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> Detailed Time, Cost &amp; Discount Breakdown</h2>
          <p id="est_desc_en">The total project is estimated at 65 hours at our standard agency rate of ₹800/hour (₹52,000). We are providing a special partnership discount of ₹37,000, resulting in a finalized fixed cost of just ₹15,000.</p>
          <div style="overflow-x:auto;">
            <table class="est-table">
              <thead><tr><th>Development Phase</th><th class="hours">Est. Hours</th><th class="amt">Cost (₹800/hr)</th></tr></thead>
              <tbody id="est_tbody_en">
                <tr><td><strong>1. UI/UX Design (Figma)</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Custom design of all layouts including Home, About, Product Details, and RFQ flows.</span></td><td class="hours">15 hrs</td><td class="amt">₹12,000</td></tr>
                <tr><td><strong>2. Frontend Development</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Responsive, industrial-themed frontend programming for the .in domain.</span></td><td class="hours">25 hrs</td><td class="amt">₹20,000</td></tr>
                <tr><td><strong>3. Backend / CMS / RFQ Integration</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Dynamic product catalog setup and Request For Quote (RFQ) lead capture routing.</span></td><td class="hours">15 hrs</td><td class="amt">₹12,000</td></tr>
                <tr><td><strong>4. Cross-Domain Search &amp; QA</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Updating platinaaceramics.com search logic and cross-browser testing.</span></td><td class="hours">10 hrs</td><td class="amt">₹8,000</td></tr>
                <tr><td colspan="2" style="text-align:right;font-weight:700;">Gross Total Valuation</td><td class="amt" style="font-weight:700;">₹52,000</td></tr>
                <tr class="discount-row"><td colspan="2" style="text-align:right;">Special Partnership Discount</td><td class="amt">-₹37,000</td></tr>
                <tr style="background:var(--platinaa-good-soft);"><td colspan="2" style="text-align:right; font-weight:700;color:var(--platinaa-good);">Final Fixed Valuation</td><td class="amt" style="font-weight:800;color:var(--platinaa-good);">₹15,000</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> Post-Launch Maintenance Options</h2>
          <p>Since you are managing your own hosting infrastructure, you only need to select a maintenance plan for ongoing updates, technical monitoring, and quick fixes.</p>
          <div class="interactive-grid">
            <label class="select-card active" onclick="selectPlatinaaOption('maintenance', 'hourly', this)">
              <input type="radio" name="maintenance_plan_en" value="hourly" checked>
              <span class="card-title">Option A: Pay-As-You-Go</span>
              <div class="card-price">₹800 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ hour</span></div>
              <p class="card-desc">Billed purely on an hourly basis as needed for any requested updates or fixes.</p>
            </label>
            <label class="select-card" onclick="selectPlatinaaOption('maintenance', 'monthly', this)">
              <input type="radio" name="maintenance_plan_en" value="monthly">
              <div><span class="badge-highlight">RECOMMENDED</span><span class="card-title">Option B: Monthly Retainer</span></div>
              <div class="card-price">₹2,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ month</span></div>
              <p class="card-desc">Predictable monthly retainer for continuous uptime monitoring, priority updates, and minor changes.</p>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> Selectable B2B Add-on Modules</h2>
          <p>Check any optional advanced B2B modules below to instantly include them in your project valuation:</p>
          <div class="interactive-grid">
            <label class="select-card addon-card">
              <input type="checkbox" id="addon_datasheet_en" value="10000" onchange="togglePlatinaaAddon(this)">
              <span class="card-title">📄 Technical Datasheet Generator</span>
              <div class="card-price">+₹10,000 <span style="font-size: 0.75rem; color: var(--platinaa-muted);">one-time</span></div>
              <p class="card-desc">Allows industrial buyers to download formatted PDF technical datasheets directly from product pages.</p>
            </label>
            <label class="select-card addon-card">
              <input type="checkbox" id="addon_whatsapp_en" value="15000" onchange="togglePlatinaaAddon(this)">
              <span class="card-title">💬 WhatsApp B2B Lead Bot</span>
              <div class="card-price">+₹15,000 <span style="font-size: 0.75rem; color: var(--platinaa-muted);">one-time</span></div>
              <p class="card-desc">Automated WhatsApp chatbot for handling initial inquiry routing, document sharing, and lead capture.</p>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> Live Financial Calculator</h2>
          <div class="pay">
            <table>
              <thead><tr><th>Deliverable Item</th><th>Status</th><th class="amt">Amount</th></tr></thead>
              <tbody>
                <tr><td><strong id="row_base_name_en">B2B Refinery Website Build</strong><br><span id="row_base_desc_en" style="font-size:0.85em;color:var(--platinaa-muted);">Standard website — Special discounted rate (65 hours)</span></td><td><span class="pill paid">Fixed Scope</span></td><td class="amt">₹<span id="val_base_en">15,000</span></td></tr>
                <tr id="row_addons_en" style="display: none;"><td><strong>Selected Add-on Modules</strong><br><span id="names_addons_en" style="font-size:0.85em;color:var(--platinaa-muted);"></span></td><td><span class="pill due">Add-ons</span></td><td class="amt">₹<span id="val_addons_en">0</span></td></tr>
                <tr><td><strong>Post-Launch Maintenance</strong><br><span id="desc_maint_en" style="font-size:0.85em;color:var(--platinaa-muted);">Billed later based on need</span></td><td><span class="pill good" id="badge_maint_en">Pay-As-You-Go</span></td><td class="amt">₹<span id="val_maint_en">0</span> <span style="font-size:0.7em;font-weight:normal;color:var(--platinaa-muted);">Today</span></td></tr>
                <tr class="total"><td>Total Project Valuation</td><td></td><td class="amt">₹<span id="val_total_en">15,000</span></td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--platinaa-good-soft); border: 2px solid var(--platinaa-good); color: var(--platinaa-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ Proposal Officially Approved!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--platinaa-ink);">Thank you for partnering with Animazon Design &amp; Web Studio.</p>
              </div>
            @elseif($isDeclined)
              <div style="background: var(--platinaa-danger-soft); border: 2px solid var(--platinaa-danger); color: var(--platinaa-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ Proposal Declined</strong>
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--platinaa-ink); font-size: 1.3rem; font-weight: 800;">Action Required: Select Payment Plan &amp; Approve</h3>
              
              <div class="interactive-grid" style="text-align:left;">
                <label class="select-card active" onclick="selectPlatinaaOption('payment', 'advance', this)">
                  <input type="radio" name="payment_plan_en" value="advance" checked>
                  <span class="card-title">Option A: 50% Advance</span>
                  <div class="card-price" id="card_adv_val_en">₹7,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ advance</span></div>
                  <p class="card-desc">Pay 50% today to start. Remaining 50% due after launch.</p>
                </label>
                <label class="select-card" onclick="selectPlatinaaOption('payment', 'full', this)">
                  <input type="radio" name="payment_plan_en" value="full">
                  <span class="card-title">Option B: 100% Upfront</span>
                  <div class="card-price" id="card_full_val_en">₹15,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ full fee</span></div>
                  <p class="card-desc">Single payment for priority queue.</p>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;', 'id' => 'formApproveEn']) !!}
                  <input type="hidden" name="custom_total_payable" id="hidden_total_en" value="7500">
                  <button type="button" onclick="document.getElementById('formApproveEn').submit()" style="font-size: 1.1rem; padding: 0.8rem 1.5rem; background: var(--platinaa-good-soft); color: var(--platinaa-good); border: 2px solid var(--platinaa-good); border-radius: 8px; font-weight: 700; cursor: pointer;">
                    ✓ Approve Only
                  </button>
                {!! Form::close() !!}
                
                @if(!empty($razorpayKey))
                  <button id="rzpPlatinaaPayBtnEn" type="button" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--platinaa-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);">
                    💳 Pay Now — ₹<span id="btn_val_en">7,500</span>
                  </button>
                @endif
              </div>
            @endif
          </div>
        </section>
      </div>
    </article>

    <!-- TAMIL -->
    <article class="sheet lang-ta" id="pane-ta" lang="ta" hidden>
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">B2B Website Development Proposal</p>
          <h1>B2B Refinery Website Build Agreement — Platinaa Ceramics</h1>
          <p class="sub">15-20 பக்கங்கள் கொண்ட விரிவான B2B இணையதளத்தை உருவாக்குவோம். சிறப்பு தள்ளுபடியுடன் இதன் இறுதி கட்டணம் ₹15,000.</p>
          <dl class="meta">
            <div><dt>Client Brand</dt><dd>Platinaa Ceramics</dd></div>
            <div><dt>Final Build Fee</dt><dd>₹15,000 <span class="pill paid">Fixed Price</span></dd></div>
            <div><dt>Total Hours</dt><dd>65 Hours <span class="pill due">@ ₹800/hr</span></dd></div>
            <div><dt>Date</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>Prepared for</dt><dd><span>Platinaa Ceramics</span></dd></div>
            <div><dt>Prepared by</dt><dd><span>Animazon Design &amp; Web Studio</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> Project Scope &amp; Website Type</h2>
          <p>நாங்கள் 15 முதல் 20 பக்கங்கள் கொண்ட விரிவான B2B இணையதளத்தை உருவாக்குவோம். <strong>platinaaceramics.in</strong>-இல் செயல்படும். கீழே உங்கள் இணையதள வகையைத் தேர்ந்தெடுக்கவும்:</p>

          <div class="interactive-grid">
            <label class="select-card active" onclick="selectPlatinaaOption('websiteType', 'normal', this)">
              <input type="radio" name="website_type_ta" value="normal" checked>
              <span class="card-title">🌐 Standard B2B Website</span>
              <div class="card-price">₹15,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ fixed</span></div>
              <p class="card-desc">தயாரிப்பு பட்டியல், RFQ படிவங்கள் மற்றும் cross-domain search integration உடன் கூடிய தொழில்முறை இணையதளம்.</p>
            </label>
            <label class="select-card" onclick="selectPlatinaaOption('websiteType', '3d', this)">
              <input type="radio" name="website_type_ta" value="3d">
              <div><span class="badge-highlight">✨ PREMIUM</span><span class="card-title">🚀 Interactive 3D Website</span></div>
              <div class="card-price">₹35,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ fixed</span></div>
              <p class="card-desc">Standard-இல் உள்ள அனைத்தும் + முழுமையான 3D WebGL அனுபவம், immersive தயாரிப்பு காட்சிகள் மற்றும் animations.</p>
            </label>
          </div>

          <a href="http://animazon.in/ceramica" target="_blank" class="preview-card" id="preview3d_ta">
            <div class="preview-img" style="background: linear-gradient(135deg, #1a1a1a 0%, #c82333 100%); display:flex; align-items:center; justify-content:center;">
              <span style="color:#fff; font-size:2.5rem; font-weight:800; text-shadow: 0 2px 12px rgba(0,0,0,0.3);">🎯 3D Demo-வை பார்க்கவும்</span>
            </div>
            <div class="preview-body">
              <strong>animazon.in/ceramica →</strong>
              <p>நாங்கள் ஏற்கனவே உருவாக்கிய 3D இணையதள அனுபவத்தை இங்கே காணலாம்.</p>
            </div>
          </a>

          <div style="margin-top: 1.5rem;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--platinaa-ink); margin: 0 0 0.65rem;">Core Deliverables (இரு விருப்பங்களிலும் அடங்கும்):</h3>
            <ul>
              <li><strong>Home:</strong> முகப்பு பக்கம், Industries Served, Products Overview.</li>
              <li><strong>About Us:</strong> எங்களைப் பற்றி, நிறுவனத்தின் வரலாறு.</li>
              <li><strong>Products Catalog:</strong> விரிவான தயாரிப்பு பட்டியல் (Refinery Grinding Balls, Catalyst Bed Supports).</li>
              <li><strong>Infrastructure / Quality:</strong> உள்கட்டமைப்பு மற்றும் தரக் கட்டுப்பாட்டுத் தகவல்கள்.</li>
              <li><strong>Contact Us / RFQ:</strong> மொத்த ஆர்டர்களுக்கான பிரத்யேக RFQ படிவம்.</li>
            </ul>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> Detailed Time, Cost &amp; Discount Breakdown</h2>
          <p id="est_desc_ta">65 மணிநேர திட்டத்திற்கு மணிக்கு ₹800 வீதம் ₹52,000. இதில் ₹37,000 தள்ளுபடி போக, இறுதி விலை ₹15,000.</p>
          <div style="overflow-x:auto;">
            <table class="est-table">
              <thead><tr><th>Development Phase</th><th class="hours">Est. Hours</th><th class="amt">Cost (₹800/hr)</th></tr></thead>
              <tbody id="est_tbody_ta">
                <tr><td><strong>1. UI/UX Design (Figma)</strong></td><td class="hours">15 hrs</td><td class="amt">₹12,000</td></tr>
                <tr><td><strong>2. Frontend Development</strong></td><td class="hours">25 hrs</td><td class="amt">₹20,000</td></tr>
                <tr><td><strong>3. Backend / CMS / RFQ Integration</strong></td><td class="hours">15 hrs</td><td class="amt">₹12,000</td></tr>
                <tr><td><strong>4. Cross-Domain Search &amp; QA</strong></td><td class="hours">10 hrs</td><td class="amt">₹8,000</td></tr>
                <tr><td colspan="2" style="text-align:right;font-weight:700;">Gross Total Valuation</td><td class="amt" style="font-weight:700;">₹52,000</td></tr>
                <tr class="discount-row"><td colspan="2" style="text-align:right;">Special Partnership Discount</td><td class="amt">-₹37,000</td></tr>
                <tr style="background:var(--platinaa-good-soft);"><td colspan="2" style="text-align:right; font-weight:700;color:var(--platinaa-good);">Final Fixed Valuation</td><td class="amt" style="font-weight:800;color:var(--platinaa-good);">₹15,000</td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> Post-Launch Maintenance Options</h2>
          <p>உங்களிடம் சொந்த ஹோஸ்டிங் உள்ளதால், பராமரிப்பு திட்டத்தை மட்டும் தேர்ந்தெடுக்கவும்.</p>
          <div class="interactive-grid">
            <label class="select-card active" onclick="selectPlatinaaOption('maintenance', 'hourly', this)">
              <input type="radio" name="maintenance_plan_ta" value="hourly" checked>
              <span class="card-title">Option A: Pay-As-You-Go</span>
              <div class="card-price">₹800 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ hour</span></div>
            </label>
            <label class="select-card" onclick="selectPlatinaaOption('maintenance', 'monthly', this)">
              <input type="radio" name="maintenance_plan_ta" value="monthly">
              <div><span class="badge-highlight">RECOMMENDED</span><span class="card-title">Option B: Monthly Retainer</span></div>
              <div class="card-price">₹2,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ month</span></div>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> Selectable B2B Add-on Modules</h2>
          <p>கூடுதல் அம்சங்களைச் சேர்க்க, கீழேயுள்ள விருப்பங்களை தேர்ந்தெடுக்கவும்:</p>
          <div class="interactive-grid">
            <label class="select-card addon-card">
              <input type="checkbox" id="addon_datasheet_ta" value="10000" onchange="togglePlatinaaAddon(this)">
              <span class="card-title">📄 Technical Datasheet Generator</span>
              <div class="card-price">+₹10,000</div>
            </label>
            <label class="select-card addon-card">
              <input type="checkbox" id="addon_whatsapp_ta" value="15000" onchange="togglePlatinaaAddon(this)">
              <span class="card-title">💬 WhatsApp B2B Lead Bot</span>
              <div class="card-price">+₹15,000</div>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> Live Financial Calculator</h2>
          <div class="pay">
            <table>
              <thead><tr><th>Deliverable Item</th><th>Status</th><th class="amt">Amount</th></tr></thead>
              <tbody>
                <tr><td><strong id="row_base_name_ta">B2B Refinery Website Build</strong><br><span id="row_base_desc_ta" style="font-size:0.85em;color:var(--platinaa-muted);">Standard website</span></td><td><span class="pill paid">Fixed Scope</span></td><td class="amt">₹<span id="val_base_ta">15,000</span></td></tr>
                <tr id="row_addons_ta" style="display: none;"><td><strong>Selected Add-on Modules</strong><br><span id="names_addons_ta" style="font-size:0.85em;color:var(--platinaa-muted);"></span></td><td><span class="pill due">Add-ons</span></td><td class="amt">₹<span id="val_addons_ta">0</span></td></tr>
                <tr><td><strong>Post-Launch Maintenance</strong></td><td><span class="pill good" id="badge_maint_ta">Pay-As-You-Go</span></td><td class="amt">₹<span id="val_maint_ta">0</span> <span style="font-size:0.7em;font-weight:normal;color:var(--platinaa-muted);">Today</span></td></tr>
                <tr class="total"><td>Total Project Valuation</td><td></td><td class="amt">₹<span id="val_total_ta">15,000</span></td></tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--platinaa-good-soft); border: 2px solid var(--platinaa-good); color: var(--platinaa-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ Proposal Officially Approved!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--platinaa-ink);">Thank you for partnering with Animazon Design &amp; Web Studio.</p>
              </div>
            @elseif($isDeclined)
              <div style="background: var(--platinaa-danger-soft); border: 2px solid var(--platinaa-danger); color: var(--platinaa-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ Proposal Declined</strong>
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--platinaa-ink); font-size: 1.3rem; font-weight: 800;">Action Required: Select Payment Plan &amp; Approve</h3>
              
              <div class="interactive-grid" style="text-align:left;">
                <label class="select-card active" onclick="selectPlatinaaOption('payment', 'advance', this)">
                  <input type="radio" name="payment_plan_ta" value="advance" checked>
                  <span class="card-title">Option A: 50% Advance</span>
                  <div class="card-price" id="card_adv_val_ta">₹7,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ advance</span></div>
                </label>
                <label class="select-card" onclick="selectPlatinaaOption('payment', 'full', this)">
                  <input type="radio" name="payment_plan_ta" value="full">
                  <span class="card-title">Option B: 100% Upfront</span>
                  <div class="card-price" id="card_full_val_ta">₹15,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ full fee</span></div>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;', 'id' => 'formApproveTa']) !!}
                  <input type="hidden" name="custom_total_payable" id="hidden_total_ta" value="7500">
                  <button type="button" onclick="document.getElementById('formApproveTa').submit()" style="font-size: 1.1rem; padding: 0.8rem 1.5rem; background: var(--platinaa-good-soft); color: var(--platinaa-good); border: 2px solid var(--platinaa-good); border-radius: 8px; font-weight: 700; cursor: pointer;">
                    ✓ Approve Only
                  </button>
                {!! Form::close() !!}
                
                @if(!empty($razorpayKey))
                  <button id="rzpPlatinaaPayBtnTa" type="button" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--platinaa-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);">
                    💳 Pay Now — ₹<span id="btn_val_ta">7,500</span>
                  </button>
                @endif
              </div>
            @endif
          </div>
        </section>
      </div>
    </article>
  </div>
</div>

<script>
  let basePrice = 15000;
  let maintPriceToday = 0; // Maintenance is billed later, adds 0 to today's invoice
  let addonsTotal = 0;
  let paymentPlan = 'advance'; // 'advance' or 'full'
  let websiteType = 'normal'; // 'normal' or '3d'

  function updatePlatinaaCalc() {
    let totalValue = basePrice + addonsTotal;
    
    // Update both English and Tamil elements
    const langs = ['en', 'ta'];
    
    langs.forEach(lang => {
      // Update base price row
      let el_val_base = document.getElementById('val_base_' + lang);
      if(el_val_base) el_val_base.innerText = basePrice.toLocaleString();

      let el_base_name = document.getElementById('row_base_name_' + lang);
      if(el_base_name) el_base_name.innerText = websiteType === '3d' ? '3D Interactive Refinery Website' : 'B2B Refinery Website Build';

      let el_base_desc = document.getElementById('row_base_desc_' + lang);
      if(el_base_desc) el_base_desc.innerText = websiteType === '3d' ? 'Premium 3D WebGL experience — Fixed price' : 'Standard website — Special discounted rate (65 hours)';

      let el_val_total = document.getElementById('val_total_' + lang);
      if(el_val_total) el_val_total.innerText = totalValue.toLocaleString();

      let advFee = (basePrice + addonsTotal) / 2;
      let fullFee = basePrice + addonsTotal;

      let el_card_adv = document.getElementById('card_adv_val_' + lang);
      if(el_card_adv) el_card_adv.innerHTML = '₹' + advFee.toLocaleString() + ' <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ advance</span>';
      
      let el_card_full = document.getElementById('card_full_val_' + lang);
      if(el_card_full) el_card_full.innerHTML = '₹' + fullFee.toLocaleString() + ' <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ full fee</span>';

      let payableToday = (paymentPlan === 'advance' ? advFee : fullFee) + maintPriceToday;
      
      let el_btn_val = document.getElementById('btn_val_' + lang);
      if(el_btn_val) el_btn_val.innerText = payableToday.toLocaleString();
      
      let el_hidden_total = document.getElementById('hidden_total_' + lang);
      if(el_hidden_total) el_hidden_total.value = payableToday;
    });
  }

  function selectPlatinaaOption(type, value, el) {
    let group = el.parentElement.querySelectorAll('.select-card');
    group.forEach(card => card.classList.remove('active'));
    el.classList.add('active');
    el.querySelector('input').checked = true;

    // Sync radio buttons across languages
    const inputName = el.querySelector('input').name;
    const baseName = inputName.replace('_en', '').replace('_ta', '');
    document.querySelectorAll(`input[name="${baseName}_en"][value="${value}"], input[name="${baseName}_ta"][value="${value}"]`).forEach(inp => {
        inp.checked = true;
        let card = inp.closest('.select-card');
        if(card) {
            card.parentElement.querySelectorAll('.select-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
        }
    });

    if (type === 'websiteType') {
      websiteType = value;
      basePrice = (value === '3d') ? 35000 : 15000;
      updateEstimateTable();
    }

    if (type === 'maintenance') {
      ['en', 'ta'].forEach(lang => {
          let el_desc = document.getElementById('desc_maint_' + lang);
          if(el_desc) el_desc.innerText = (value === 'hourly') ? 'Pay-As-You-Go (Billed later)' : 'Monthly Retainer (Billed later)';
          let el_badge = document.getElementById('badge_maint_' + lang);
          if(el_badge) el_badge.innerText = (value === 'hourly') ? 'Pay-As-You-Go' : 'Monthly';
      });
    }
    
    if (type === 'payment') {
      paymentPlan = value;
    }

    updatePlatinaaCalc();
  }

  function updateEstimateTable() {
    const stdRows = [
      {name: '1. UI/UX Design (Figma)', descEn: 'Custom design of all layouts including Home, About, Product Details, and RFQ flows.', hrs: 15, cost: 12000},
      {name: '2. Frontend Development', descEn: 'Responsive, industrial-themed frontend programming for the .in domain.', hrs: 25, cost: 20000},
      {name: '3. Backend / CMS / RFQ Integration', descEn: 'Dynamic product catalog setup and Request For Quote (RFQ) lead capture routing.', hrs: 15, cost: 12000},
      {name: '4. Cross-Domain Search & QA', descEn: 'Updating platinaaceramics.com search logic and cross-browser testing.', hrs: 10, cost: 8000}
    ];
    const tdRows = [
      {name: '1. UI/UX Design (Figma)', descEn: 'Custom design + 3D scene mockups, spatial layouts, and immersive product views.', hrs: 15, cost: 12000},
      {name: '2. 3D WebGL Development', descEn: 'Interactive Three.js / WebGL scenes with product 3D models, animations, and camera controls.', hrs: 30, cost: 24000},
      {name: '3. Frontend Development', descEn: 'Responsive shell, page transitions, and seamless 3D-to-page integration.', hrs: 20, cost: 16000},
      {name: '4. Backend / CMS / RFQ', descEn: 'Dynamic product catalog setup and Request For Quote (RFQ) lead capture routing.', hrs: 10, cost: 8000},
      {name: '5. Cross-Domain & QA', descEn: 'Cross-browser WebGL testing, performance profiling, and platinaaceramics.com integration.', hrs: 10, cost: 8000}
    ];

    const rows = (websiteType === '3d') ? tdRows : stdRows;
    const totalHrs = rows.reduce((s, r) => s + r.hrs, 0);
    const gross = rows.reduce((s, r) => s + r.cost, 0);
    const discount = gross - basePrice;

    ['en', 'ta'].forEach(lang => {
      let tbody = document.getElementById('est_tbody_' + lang);
      if (!tbody) return;

      let html = '';
      rows.forEach(r => {
        html += `<tr><td><strong>${r.name}</strong>`;
        if (lang === 'en') html += `<br><span style="font-size:0.85em;color:var(--platinaa-muted);">${r.descEn}</span>`;
        html += `</td><td class="hours">${r.hrs} hrs</td><td class="amt">₹${r.cost.toLocaleString()}</td></tr>`;
      });
      html += `<tr><td colspan="2" style="text-align:right;font-weight:700;">Gross Total Valuation (${totalHrs} hrs)</td><td class="amt" style="font-weight:700;">₹${gross.toLocaleString()}</td></tr>`;
      html += `<tr class="discount-row"><td colspan="2" style="text-align:right;">Special Partnership Discount</td><td class="amt">-₹${discount.toLocaleString()}</td></tr>`;
      html += `<tr style="background:var(--platinaa-good-soft);"><td colspan="2" style="text-align:right; font-weight:700;color:var(--platinaa-good);">Final Fixed Valuation</td><td class="amt" style="font-weight:800;color:var(--platinaa-good);">₹${basePrice.toLocaleString()}</td></tr>`;
      tbody.innerHTML = html;

      // Update description paragraph
      let descP = document.getElementById('est_desc_' + lang);
      if (descP) {
        if (lang === 'en') {
          descP.innerText = `The total project is estimated at ${totalHrs} hours at our standard agency rate of ₹800/hour (₹${gross.toLocaleString()}). We are providing a special partnership discount of ₹${discount.toLocaleString()}, resulting in a finalized fixed cost of just ₹${basePrice.toLocaleString()}.`;
        } else {
          descP.innerText = `${totalHrs} மணிநேர திட்டத்திற்கு மணிக்கு ₹800 வீதம் ₹${gross.toLocaleString()}. இதில் ₹${discount.toLocaleString()} தள்ளுபடி போக, இறுதி விலை ₹${basePrice.toLocaleString()}.`;
        }
      }
    });
  }

  function togglePlatinaaAddon(cb) {
    const inputId = cb.id;
    const baseId = inputId.replace('_en', '').replace('_ta', '');
    
    // Sync checkboxes across languages
    document.querySelectorAll(`#${baseId}_en, #${baseId}_ta`).forEach(inp => {
        inp.checked = cb.checked;
        let card = inp.closest('.select-card');
        if(card) {
            if (cb.checked) {
              card.classList.add('addon-active');
            } else {
              card.classList.remove('addon-active');
            }
        }
    });

    let allCbs = document.querySelectorAll('#pane-en .addon-card input[type="checkbox"]:checked');
    addonsTotal = 0;
    let names = [];
    allCbs.forEach(box => {
      addonsTotal += parseInt(box.value);
      names.push(box.nextElementSibling.innerText.trim());
    });

    ['en', 'ta'].forEach(lang => {
        let el_val_addons = document.getElementById('val_addons_' + lang);
        if(el_val_addons) el_val_addons.innerText = addonsTotal.toLocaleString();
        
        let row_addons = document.getElementById('row_addons_' + lang);
        if(row_addons) {
            if (addonsTotal > 0) {
              row_addons.style.display = 'table-row';
              document.getElementById('names_addons_' + lang).innerText = names.join(' + ');
            } else {
              row_addons.style.display = 'none';
              document.getElementById('names_addons_' + lang).innerText = '';
            }
        }
    });

    updatePlatinaaCalc();
  }
</script>

@if(!empty($razorpayKey) && !$isDeclined && !$isExpired)
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    function openPlatinaaRazorpay(lang) {
        var currentAmt = parseInt(document.getElementById('hidden_total_' + lang).value);
        if(!currentAmt || currentAmt <= 0) return;
        
        var options = {
            key: "{{ $razorpayKey }}",
            amount: currentAmt * 100,
            currency: "INR",
            name: "{{ Utility::companyData($proposal->created_by, 'title_text') ?: config('app.name', 'ANIMAZON') }}",
            description: "{{ __('Proposal') }} {{ $proposal->proposal_id }} - Platinaa Ceramics",
            handler: function (response) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('proposal.public.pay.razorpay', $publicParam) }}";

                var csrf = document.createElement('input');
                csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);

                var payId = document.createElement('input');
                payId.type = 'hidden'; payId.name = 'razorpay_payment_id'; payId.value = response.razorpay_payment_id;
                form.appendChild(payId);

                var amt = document.createElement('input');
                amt.type = 'hidden'; amt.name = 'amount'; amt.value = currentAmt;
                form.appendChild(amt);

                document.body.appendChild(form);
                form.submit();
            },
            prefill: {
                name: "{{ $customer->name ?? '' }}",
                email: "{{ $customer->email ?? '' }}",
                contact: "{{ $customer->contact ?? '' }}"
            },
            theme: { color: "#c82333" }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
    
    let rzpBtnEn = document.getElementById('rzpPlatinaaPayBtnEn');
    if(rzpBtnEn) {
        rzpBtnEn.addEventListener('click', function() { openPlatinaaRazorpay('en'); });
    }
    
    let rzpBtnTa = document.getElementById('rzpPlatinaaPayBtnTa');
    if(rzpBtnTa) {
        rzpBtnTa.addEventListener('click', function() { openPlatinaaRazorpay('ta'); });
    }
  </script>
@endif
