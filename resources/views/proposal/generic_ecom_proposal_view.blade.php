@php
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);
    $totalPaid = $proposal->amountPaid();
    $isExpired = $proposal->isExpired();
    $isAccepted = $proposal->isAccepted();
    $isDeclined = $proposal->isDeclined();
    $isPending = !$isAccepted && !$isDeclined;

    // For simplicity, we just keep english for this generic proposal
    $segmentsEn = [
        "Proposal for Custom eCommerce Website with CRM and ERP Integration.",
        "Section 1: Project Scope. We will build a unified system featuring an eCommerce storefront, centralized CRM, and a lightweight ERP backend.",
        "Section 2: Time and Cost Estimation. The complete project scope is fixed at 35,000 rupees.",
        "Section 3: Maintenance Options. Choose between a Pay-As-You-Go plan or a Monthly Retainer for ongoing support.",
        "Section 4: Live Financial Calculator. Your total is 35,000 rupees. You can pay 50% advance to initiate the project."
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
    --platinaa-accent: #0f9c86; /* Changed to a generic green/teal for eCommerce */
    --platinaa-accent-deep: #097564;
    --platinaa-accent-soft: #e0f2f0;
    --platinaa-good: #28a745;
    --platinaa-good-soft: #d4edda;
    --platinaa-danger: #dc3545;
    --platinaa-danger-soft: #f8d7da;
    --platinaa-shadow: 0 4px 24px -4px rgba(15, 156, 134, 0.1);
    --platinaa-maxw: 76rem;
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
    background: linear-gradient(to right, var(--platinaa-accent) 0%, #20c997 100%);
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
  .platinaa-view-container .pill.due { background: var(--platinaa-accent-soft); color: var(--platinaa-accent-deep); border: 1px solid var(--platinaa-accent); }

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

  .preview-card { display: block; margin: 0; border-radius: 14px; overflow: hidden; border: 2px solid var(--platinaa-border-strong); transition: all 0.25s ease; text-decoration: none; }
  .preview-card:hover { border-color: var(--platinaa-accent); transform: translateY(-3px); box-shadow: 0 8px 28px -6px rgba(15, 156, 134, 0.18); }
  .preview-card .preview-img { width: 100%; height: 160px; object-fit: cover; display: block; background: var(--platinaa-accent-soft); position: relative; }
  .preview-card .preview-iframe { position: absolute; top: 0; left: 0; width: 400%; height: 400%; border: none; transform: scale(0.25); transform-origin: top left; pointer-events: none; }
  .preview-card .preview-body { padding: 1rem 1.25rem; background: var(--platinaa-surface); }
  .preview-card .preview-body strong { color: var(--platinaa-accent); font-size: 0.95rem; }
  .preview-card .preview-body p { margin: 0.25rem 0 0; font-size: 0.85rem; color: var(--platinaa-muted); }
  
  .portfolio-carousel { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 1.25rem; padding-bottom: 1rem; -webkit-overflow-scrolling: touch; }
  .portfolio-carousel::-webkit-scrollbar { height: 8px; }
  .portfolio-carousel::-webkit-scrollbar-thumb { background: var(--platinaa-border-strong); border-radius: 4px; }
  .portfolio-carousel > .preview-card { flex: 0 0 280px; scroll-snap-align: start; margin: 0; }
  
</style>

<div class="platinaa-view-container" data-theme-root>
  @include('proposal.brand_header', [
      'proposal' => $proposal,
      'langType' => 'en',
      'langNameLocal' => 'English',
      'segmentsEn' => json_encode($segmentsEn),
      'segmentsLocal' => '[]',
      'audioUrlEn' => $proposal->getTtsAudioUrl('en'),
      'audioUrlLocal' => ''
  ])

  <div class="wrap">
    <article class="sheet lang-en" id="pane-en" lang="en">
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">Enterprise eCommerce Proposal</p>
          <h1>Custom eCommerce Website with CRM and ERP Backend</h1>
          <p class="sub">Designing and developing a scalable eCommerce platform that seamlessly integrates customer relationship management and essential ERP functionalities to streamline your business operations.</p>
          <dl class="meta">
            <div><dt>Client</dt><dd>{{ str_ireplace('Random Client', 'Esteemed Customer', $customer->name ?? 'Esteemed Customer') }}</dd></div>
            <div><dt>Final Build Fee</dt><dd>₹35,000 <span class="pill paid">Fixed Price</span></dd></div>
            <div><dt>Tech Stack</dt><dd>Scalable Stack</dd></div>
            <div><dt>Date</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>Prepared for</dt><dd><span>{{ str_ireplace('Random Client', 'Esteemed Customer', $customer->name ?? 'Esteemed Customer') }}</span></dd></div>
            <div><dt>Prepared by</dt><dd><span>Animazon Web Studio</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> Why Animazon Web Studio?</h2>
          <p>We are a dedicated digital studio specializing in high-performance web applications, striking UI/UX, and complex business automations. We bring years of industry-grade experience in building scalable multi-tenant SaaS, responsive eCommerce storefronts, and tailored ERP solutions.</p>
          
          <div class="portfolio-carousel">
             <a href="https://animazon.in/ceramica" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://animazon.in/ceramica" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>Platinaa Ceramics →</strong>
                <p>Interactive 3D WebGL B2B product showcase.</p>
              </div>
            </a>
            <a href="https://animazon.in" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://animazon.in" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>Our Digital Home →</strong>
                <p>Explore our premium design aesthetics.</p>
              </div>
            </a>
            <a href="https://www.lenzbreeze.com/" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://www.lenzbreeze.com/" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>LenzBreeze →</strong>
                <p>Corporate Website and Product Showcase.</p>
              </div>
            </a>
            <a href="https://dhanvanthrifoods.com/" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://dhanvanthrifoods.com/" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>Dhanvanthiri Foods →</strong>
                <p>FMCG Brand Platform & eCommerce.</p>
              </div>
            </a>
            <a href="https://rudraspirit.com/" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://rudraspirit.com/" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>Rudra Spirit →</strong>
                <p>Spiritual eCommerce & Product Catalog.</p>
              </div>
            </a>
            <a href="https://wildlifeleather.in/" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://wildlifeleather.in/" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>Wildlife Leather →</strong>
                <p>Premium Leather Goods eCommerce.</p>
              </div>
            </a>
            <a href="https://app.animazon.in/home" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://app.animazon.in/home" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>Loan Track ERP →</strong>
                <p>Custom Financial Tracking ERP App.</p>
              </div>
            </a>
            <a href="https://ipcatn.com/login/" target="_blank" class="preview-card">
              <div class="preview-img">
                <iframe src="https://ipcatn.com/login/" class="preview-iframe" tabindex="-1"></iframe>
              </div>
              <div class="preview-body">
                <strong>IPCA TN →</strong>
                <p>Medical Association Member Portal.</p>
              </div>
            </a>
          </div>
          
          <div style="background: var(--platinaa-good-soft); border: 1px solid var(--platinaa-good); border-radius: 8px; padding: 1.2rem; margin-top: 1.5rem; color: var(--platinaa-ink);">
            <strong>🌟 Our Promise:</strong> You get agency-level quality, premium modern design, and robust scalable architecture for a fraction of traditional agency costs.
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> Proposed Architecture & Scope</h2>
          <p>We will build a unified system that handles eCommerce sales, customer relationship management, and ERP functionalities. This is exactly the kind of architecture we specialize in.</p>
          <div style="margin-top: 1.5rem;">
            <ul>
              <li style="margin-bottom: 0.8rem"><strong>eCommerce Frontend & Backend:</strong> Fast, responsive, and custom storefront featuring a complete product catalog, cart, secure checkout, and payment gateway integration. Built on scalable, modern frameworks.</li>
              <li style="margin-bottom: 0.8rem"><strong>CRM Integration:</strong> Centralized customer data, order history, and activity logs. Your team can efficiently track leads, manage repeat customers, and handle support seamlessly in one dashboard.</li>
              <li style="margin-bottom: 0.8rem"><strong>Lightweight ERP Backend:</strong> Essential ERP functionalities tailored to your workflow, such as inventory management, order fulfillment tracking, and basic reporting.</li>
              <li style="margin-bottom: 0.8rem"><strong>Scalable Architecture:</strong> Built modularly from day one, ensuring that as your business grows, components can scale independently without any technical bottlenecks.</li>
            </ul>
          </div>
          <div style="background: var(--platinaa-surface); border: 1px solid var(--platinaa-border); border-radius: 8px; padding: 1.5rem; margin-top: 1.5rem;">
            <strong>Relevant Experience:</strong><br>
            Our team has extensive experience building comprehensive portals, e-commerce platforms, and business management systems that require complex architecture, payment gateways, and seamless admin dashboards. Review our portfolio here: <a href="https://animazon.in" target="_blank" style="color: var(--platinaa-accent); font-weight: bold; text-decoration: none;">https://animazon.in</a>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> Pricing Breakdown</h2>
          <p>We can deliver this complete initial scope for a fixed cost of ₹35,000.</p>
          
          <div class="pay">
            <table>
              <thead><tr><th>Deliverable Item</th><th>Status</th><th class="amt">Amount</th></tr></thead>
              <tbody>
                <tr>
                    <td><strong>Custom eCommerce Platform</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Scalable frontend and backend with secure checkout</span></td>
                    <td><span class="pill paid">Included</span></td>
                    <td class="amt">-</td>
                </tr>
                <tr>
                    <td><strong>CRM Integration</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Centralized dashboard, customer data and communication tracking</span></td>
                    <td><span class="pill paid">Included</span></td>
                    <td class="amt">-</td>
                </tr>
                <tr>
                    <td><strong>Lightweight ERP Module</strong><br><span style="font-size:0.85em;color:var(--platinaa-muted);">Inventory management & order fulfillment</span></td>
                    <td><span class="pill paid">Included</span></td>
                    <td class="amt">-</td>
                </tr>
                <tr class="total">
                    <td>Total Project Valuation</td>
                    <td></td>
                    <td class="amt">₹35,000</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> Terms &amp; Conditions</h2>
          <div style="background: var(--platinaa-surface); border: 1px solid var(--platinaa-border); border-radius: 8px; padding: 1.5rem; margin-top: 1rem;">
            <ul style="margin: 0; padding-left: 1.25rem; color: var(--platinaa-ink); font-size: 0.95rem; line-height: 1.6;">
              <li style="margin-bottom: 0.5rem;"><strong>Support & Warranty:</strong> Post-launch support and bug fixes for 6 months covering delivered code.</li>
              <li style="margin-bottom: 0.5rem;"><strong>Scope Adjustments:</strong> Extra features requested outside this proposed scope will be scoped and quoted separately.</li>
              <li style="margin-bottom: 0.5rem;"><strong>Content Delivery:</strong> The client will provide product details, branding assets, and text content in a timely manner.</li>
            </ul>
          </div>
        </section>

        <section>
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--platinaa-good-soft); border: 2px solid var(--platinaa-good); color: var(--platinaa-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ Proposal Officially Approved!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--platinaa-ink);">Thank you for partnering with Animazon Web Studio.</p>
              </div>
            @elseif($isDeclined)
              <div style="background: var(--platinaa-danger-soft); border: 2px solid var(--platinaa-danger); color: var(--platinaa-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ Proposal Declined</strong>
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--platinaa-ink); font-size: 1.3rem; font-weight: 800;">Action Required: Select Payment Plan &amp; Approve</h3>
              
              <div class="interactive-grid" style="text-align:left;">
                <label class="select-card active" onclick="selectPaymentOption('advance', 17500, this)">
                  <input type="radio" name="payment_plan" value="advance" checked>
                  <span class="card-title">Option A: 50% Advance</span>
                  <div class="card-price">₹17,500 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ advance</span></div>
                  <p class="card-desc">Pay 50% today to start. Remaining 50% due after launch.</p>
                </label>
                <label class="select-card" onclick="selectPaymentOption('full', 35000, this)">
                  <input type="radio" name="payment_plan" value="full">
                  <span class="card-title">Option B: 100% Upfront</span>
                  <div class="card-price">₹35,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--platinaa-muted);">/ full fee</span></div>
                  <p class="card-desc">Single payment for priority queue.</p>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;', 'id' => 'formApprove']) !!}
                  <button type="button" onclick="document.getElementById('formApprove').submit()" style="font-size: 1.1rem; padding: 0.8rem 1.5rem; background: var(--platinaa-good-soft); color: var(--platinaa-good); border: 2px solid var(--platinaa-good); border-radius: 8px; font-weight: 700; cursor: pointer;">
                    ✓ Approve Proposal
                  </button>
                {!! Form::close() !!}
                
                @if(!empty($razorpayKey))
                  <button id="rzpPaymentBtn" type="button" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--platinaa-accent); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(15, 156, 134, 0.3);">
                    💳 Pay Now — ₹<span id="btn_val">17,500</span>
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
  let currentPayable = 17500;

  function selectPaymentOption(type, amount, element) {
    document.querySelectorAll('.select-card').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    
    let radio = element.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
    
    currentPayable = amount;
    
    let btnVal = document.getElementById('btn_val');
    if (btnVal) {
      btnVal.innerText = currentPayable.toLocaleString('en-IN');
    }
  }

  @if(!$isAccepted && !$isDeclined && !empty($razorpayKey))
  document.addEventListener("DOMContentLoaded", function() {
    let rzpBtn = document.getElementById('rzpPaymentBtn');
    if(rzpBtn) {
      rzpBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        var options = {
            key: "{{ $razorpayKey }}",
            amount: currentPayable * 100, // razorpay amount in paise
            currency: "INR",
            name: "Animazon Web Studio",
            description: "Proposal Advance Payment - Custom eCommerce",
            handler: function (response) {
                // Submit payment to backend
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
                amt.type = 'hidden'; amt.name = 'amount'; amt.value = currentPayable;
                form.appendChild(amt);

                document.body.appendChild(form);
                form.submit();
            },
            prefill: {
                name: "{{ $customer->name ?? '' }}",
                email: "{{ $customer->email ?? '' }}"
            },
            theme: { color: "#0f9c86" }
        };
        var rzp = new Razorpay(options);
        rzp.open();
      });
    }
  });
  @endif
</script>
