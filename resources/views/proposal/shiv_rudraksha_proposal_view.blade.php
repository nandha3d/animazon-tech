@php
    $publicParam = !empty($proposal->url_slug) ? $proposal->url_slug : \Illuminate\Support\Facades\Crypt::encrypt($proposal->id);
    $totalPaid = $proposal->amountPaid();
    $isExpired = $proposal->isExpired();
    $isAccepted = $proposal->isAccepted();
    $isDeclined = $proposal->isDeclined();
    $isPending = !$isAccepted && !$isDeclined;

    $shivSegmentsEn = [
        "E-Commerce Development Proposal for Shiv Rudrakshaa.",
        "Section 1: Project Scope and Fixed Valuation. Animazon Design & Web Studio is pleased to partner with Shiv Rudrakshaa to deliver a comprehensive e-commerce website and platform for a finalized fixed investment of just 40,000 rupees.",
        "Section 2: Hosting Infrastructure. For high-speed performance and security, Premium VPS Cloud Hosting is 2,400 rupees per month. You can select either monthly billing or annual billing at 26,400 rupees per year, which includes 1 month free.",
        "Section 3: Dedicated Maintenance & Support. To ensure your online business operates smoothly after launch, Animazon Design & Web Studio includes 6 Months of Dedicated Maintenance & Support completely free of charge with your build package.",
        "Section 4: Six Included E-Commerce Growth Modules. Included at zero extra cost with your 40,000 rupee build are: Multi-Currency and Global Shipping Switcher, One-Page Checkout and Abandoned Cart Recovery, Automated Logistics and Courier Tracking, Advanced SEO Schema Engine, Brand Trust and Review Showcase, and Mobile-First Speed Optimization.",
        "Section 5: Selectable Additional Custom Add-on Modules. You can customize your storefront by checking any optional custom modules: Live Lab Report QR Portal at 12,000 rupees, Accounts and GST Taxation Module at 25,000 rupees, Custom Vedic Puja Checkout at 15,000 rupees, B2B Wholesale Dealer Portal at 25,000 rupees, WhatsApp Commerce and AI Chatbot at 18,000 rupees, and Custom Android and iOS Mobile App at 85,000 rupees.",
        "Section 6: Interactive Financial Quotation. Our live cost calculator dynamically updates your total payable amount based on your selected hosting plan, selected add-on modules, and your preferred payment schedule of either 50 percent advance or 100 percent upfront."
    ];

    $shivSegmentsHi = [
        "शिव रुद्राक्षा के लिए ई-कॉमर्स वेबसाइट विकास प्रस्ताव।",
        "भाग 1: प्रोजेक्ट स्कोप और तय शुल्क। एनिमेज़ॉन डिज़ाइन स्टूडियो शिव रुद्राक्षा के लिए एक अत्याधुनिक ई-कॉमर्स वेबसाइट और प्लेटफॉर्म विकसित करने के लिए प्रस्तुत है। इस संपूर्ण प्रोजेक्ट का अंतिम तय शुल्क केवल 40,000 रुपये है।",
        "भाग 2: वीपीएस क्लाउड होस्टिंग। तेज गति और सुरक्षा के लिए वीपीएस होस्टिंग 2,400 रुपये प्रति माह है। आप मासिक भुगतान या 26,400 रुपये वार्षिक भुगतान का चयन कर सकते हैं, जिसमें 1 महीना मुफ़्त है।",
        "भाग 3: समर्पित रखरखाव व तकनीकी सहायता। वेबसाइट लॉन्च के बाद सुचारू संचालन के लिए, एनिमेज़ॉन डिज़ाइन स्टूडियो आपके पैकेज के साथ 6 महीने का समर्पित रखरखाव व सपोर्ट बिल्कुल मुफ़्त दे रहा है।",
        "भाग 4: 40,000 रुपये में शामिल 6 प्रमुख ई-कॉमर्स ग्रोथ मॉड्यूल। इनमें शामिल हैं: मल्टी-करेंसी और अंतरराष्ट्रीय शिपिंग, वन-पेज चेकआउट, शिप्रॉकेट कूरियर ट्रैकिंग, एसईओ इंजन, ट्रस्ट व रिव्यू सिस्टम, और स्पीड ऑप्टिमाइजेशन।",
        "भाग 5: वैकल्पिक अतिरिक्त कस्टम मॉड्यूल। आप अपनी ज़रूरत के अनुसार अतिरिक्त मॉड्यूल चुन सकते हैं: लैब रिपोर्ट QR पोर्टल (12,000 रुपये), अकाउंट्स व जीएसटी टैक्सेशन (25,000 रुपये), वैदिक पूजा चेकआउट (15,000 रुपये), B2B होलसेल पोर्टल (25,000 रुपये), व्हाट्सएप AI कॉमर्स (18,000 रुपये), और मोबाइल ऐप (85,000 रुपये)।",
        "भाग 6: लाइव मूल्य कैलकुलेटर। आप होस्टिंग विकल्प, अतिरिक्त मॉड्यूल और 50% एडवांस या 100% एकमुश्त भुगतान विकल्प चुनकर अपनी लाइव कुल देय राशि देख सकते हैं।"
    ];
@endphp

<style>
  :root, :root[data-theme="light"] {
    --shiv-bg: #FAF6F0;
    --shiv-surface: #FFFFFF;
    --shiv-ink: #1E1810;
    --shiv-muted: #5D5348;
    --shiv-border: #E8DFD1;
    --shiv-border-strong: #D1C3AD;
    --shiv-accent: #C85A17;
    --shiv-accent-deep: #8E3B09;
    --shiv-accent-soft: #FDF1E7;
    --shiv-good: #2E7D32;
    --shiv-good-soft: #E8F5E9;
    --shiv-gold: #D4AF37;
    --shiv-gold-soft: #FFF9E6;
    --shiv-danger: #C62828;
    --shiv-danger-soft: #FFEBEE;
    --shiv-shadow: 0 4px 24px -4px rgba(200, 90, 23, 0.08);
    --shiv-maxw: 76rem;
  }

  :root[data-theme="dark"], [data-theme="dark"], [data-theme-root="dark"] {
    --shiv-bg: #120E0A;
    --shiv-surface: #1C1611;
    --shiv-ink: #F5EFEB;
    --shiv-muted: #A89F91;
    --shiv-border: #33281E;
    --shiv-border-strong: #4A3B2C;
    --shiv-accent: #E67E22;
    --shiv-accent-deep: #F39C12;
    --shiv-accent-soft: rgba(230, 126, 34, 0.15);
    --shiv-good: #66BB6A;
    --shiv-good-soft: rgba(102, 187, 106, 0.15);
    --shiv-gold: #F1C40F;
    --shiv-gold-soft: rgba(241, 196, 15, 0.15);
    --shiv-danger: #EF5350;
    --shiv-danger-soft: rgba(239, 83, 80, 0.15);
    --shiv-shadow: 0 4px 24px -4px rgba(0, 0, 0, 0.5);
  }

  @keyframes shivPulse {
    0% { box-shadow: 0 0 0 0 rgba(46, 125, 50, 0.6); }
    70% { box-shadow: 0 0 0 10px rgba(46, 125, 50, 0); }
    100% { box-shadow: 0 0 0 0 rgba(46, 125, 50, 0); }
  }
  .badge-highlight {
    background: linear-gradient(135deg, #2E7D32, #1B5E20);
    color: #ffffff !important;
    font-weight: 800;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    display: inline-block;
    margin-bottom: 0.5rem;
    animation: shivPulse 2s infinite;
    border: 1px solid rgba(255,255,255,0.3);
  }

  .shiv-view-container {
    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--shiv-ink);
    background-color: var(--shiv-bg);
    line-height: 1.68;
    -webkit-font-smoothing: antialiased;
    font-variant-numeric: tabular-nums;
    padding: 0 0 6.5rem;
    min-height: 100vh;
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  .shiv-view-container .wrap { max-width: var(--shiv-maxw); margin: 0 auto; padding: 1.5rem 1.5rem 6.5rem; }
  .shiv-view-container .lang-hi { font-family: 'Noto Sans Devanagari', 'Mangal', 'Outfit', sans-serif; line-height: 1.8; }

  .shiv-view-container .sheet { 
    background: var(--shiv-surface); 
    border: 1px solid var(--shiv-border); 
    border-radius: 16px; 
    box-shadow: var(--shiv-shadow); 
    overflow: hidden;
    position: relative;
  }
  .shiv-view-container .sheet::before {
    content: "";
    display: block;
    height: 6px;
    background: linear-gradient(to right, var(--shiv-accent) 0%, var(--shiv-gold) 50%, var(--shiv-good) 100%);
  }
  .shiv-view-container .sheet-pad { padding: clamp(1.5rem, 4vw, 3.5rem); }
  .shiv-view-container [hidden] { display: none !important; }

  .shiv-view-container .mast { border-bottom: 1px solid var(--shiv-border); padding-bottom: 1.75rem; }
  .shiv-view-container .eyebrow { font-size: 0.75rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--shiv-accent); font-weight: 700; margin: 0 0 0.55rem; display: flex; align-items: center; gap: 0.55rem; }
  .shiv-view-container .eyebrow::before { content: ""; width: 1.6rem; height: 3px; background: var(--shiv-accent); display: inline-block; border-radius: 2px; }
  .shiv-view-container h1 { font-family: 'Outfit', sans-serif; font-size: clamp(1.65rem, 4.5vw, 2.45rem); line-height: 1.18; margin: 0; letter-spacing: -0.015em; font-weight: 800; color: var(--shiv-ink); }
  .shiv-view-container .lang-hi h1 { line-height: 1.38; }
  .shiv-view-container .sub { color: var(--shiv-muted); margin: 0.6rem 0 0; font-size: 1.05rem; line-height: 1.6; }

  .shiv-view-container .meta { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem 2rem; margin-top: 1.75rem; background: var(--shiv-accent-soft); padding: 1.25rem 1.5rem; border-radius: 12px; border: 1px solid var(--shiv-border); }
  @media (max-width: 48rem) { .shiv-view-container .meta { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 32rem) { .shiv-view-container .meta { grid-template-columns: 1fr; } }
  .shiv-view-container .meta div { display: flex; flex-direction: column; gap: 0.2rem; }
  .shiv-view-container .meta dt { font-size: 0.71rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--shiv-muted); font-weight: 700; margin: 0; }
  .shiv-view-container .meta dd { margin: 0; font-weight: 700; color: var(--shiv-ink); font-size: 1rem; }

  .shiv-view-container section { margin-top: 2.75rem; }
  .shiv-view-container h2 { font-family: 'Outfit', sans-serif; font-size: 1.28rem; margin: 0 0 1rem; line-height: 1.4; display: flex; align-items: center; gap: 0.65rem; color: var(--shiv-ink); font-weight: 800; }
  .shiv-view-container h2 .n { background: var(--shiv-accent); color: #fff; font-size: 0.85rem; font-weight: 800; font-variant-numeric: tabular-nums; border-radius: 8px; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; flex: none; box-shadow: 0 2px 6px rgba(200, 90, 23, 0.25); }
  .shiv-view-container p { margin: 0.7rem 0; color: var(--shiv-ink); font-size: 0.98rem; }
  .shiv-view-container strong { font-weight: 700; }

  /* pills */
  .shiv-view-container .pill { display: inline-block; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.02em; padding: 0.15rem 0.6rem; border-radius: 999px; white-space: nowrap; }
  .shiv-view-container .pill.paid { background: var(--shiv-good-soft); color: var(--shiv-good); border: 1px solid rgba(46,125,50,0.2); }
  .shiv-view-container .pill.due { background: var(--shiv-accent-soft); color: var(--shiv-accent-deep); border: 1px solid rgba(200,90,23,0.2); }
  .shiv-view-container .pill.out { background: var(--shiv-danger-soft); color: var(--shiv-danger); border: 1px solid rgba(198,40,40,0.2); }
  .shiv-view-container .pill.good { background: var(--shiv-good-soft); color: var(--shiv-good); border: 1px solid rgba(46,125,50,0.2); }
  .shiv-view-container .pill.gold { background: var(--shiv-gold-soft); color: #B7950B; border: 1px solid rgba(212,175,55,0.3); }

  /* Interactive Selector Cards */
  .interactive-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin: 1.25rem 0; }
  .select-card {
    border: 2px solid var(--shiv-border-strong); border-radius: 12px; padding: 1.25rem; background: var(--shiv-bg);
    cursor: pointer; transition: all 0.2s ease; position: relative; display: flex; flex-direction: column; justify-content: space-between;
  }
  .select-card:hover { border-color: var(--shiv-accent); transform: translateY(-2px); }
  .select-card.active { border-color: var(--shiv-good); background: var(--shiv-good-soft); box-shadow: 0 0 0 1px var(--shiv-good); }
  .select-card.addon-active { border-color: var(--shiv-accent); background: var(--shiv-accent-soft); box-shadow: 0 0 0 1px var(--shiv-accent); }
  .select-card input[type="radio"], .select-card input[type="checkbox"] {
    position: absolute; top: 1.25rem; right: 1.25rem; width: 1.3rem; height: 1.3rem; accent-color: var(--shiv-good); cursor: pointer;
  }
  .select-card.addon-card input[type="checkbox"] { accent-color: var(--shiv-accent); }
  .select-card .card-title { font-weight: 800; font-size: 1.08rem; color: var(--shiv-ink); margin-bottom: 0.35rem; padding-right: 2rem; display: block; }
  .select-card .card-price { font-size: 1.35rem; font-weight: 800; color: var(--shiv-accent); margin-bottom: 0.5rem; }
  .select-card .card-desc { font-size: 0.88rem; color: var(--shiv-muted); line-height: 1.5; margin: 0; }

  /* Dedicated AMC Box */
  .amc-box {
    border: 2px solid var(--shiv-gold); background: var(--shiv-gold-soft); border-radius: 16px; padding: 1.75rem; margin: 1.5rem 0;
    transition: all 0.3s ease; position: relative;
  }
  .amc-box.opted-in { border-color: var(--shiv-good); background: var(--shiv-good-soft); }
  .amc-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem; }
  .amc-header h3 { margin: 0; font-size: 1.2rem; font-weight: 800; color: var(--shiv-ink); display: flex; align-items: center; gap: 0.6rem; }
  .amc-toggle-label {
    display: inline-flex; align-items: center; gap: 0.6rem; font-weight: 800; font-size: 1rem; cursor: pointer;
    background: var(--shiv-surface); padding: 0.6rem 1.2rem; border-radius: 999px; border: 2px solid var(--shiv-border-strong);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: all 0.2s ease;
  }
  .amc-toggle-label:hover { border-color: var(--shiv-accent); }
  .amc-toggle-label input[type="checkbox"] { width: 1.3rem; height: 1.3rem; accent-color: var(--shiv-good); cursor: pointer; }

  /* tables */
  .shiv-view-container .tbl-scroll { overflow-x: auto; margin: 0.75rem 0; border: 1px solid var(--shiv-border); border-radius: 12px; }
  .shiv-view-container table.why { width: 100%; border-collapse: collapse; margin: 0; font-size: 0.95rem; background: var(--shiv-surface); }
  .shiv-view-container table.why th, .shiv-view-container table.why td { text-align: left; padding: 0.9rem 1.1rem; vertical-align: top; border-bottom: 1px solid var(--shiv-border); line-height: 1.6; color: var(--shiv-ink); }
  .shiv-view-container table.why thead th { font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--shiv-muted); font-weight: 700; border-bottom: 2px solid var(--shiv-border-strong); background: var(--shiv-accent-soft); }
  .shiv-view-container table.why tbody tr:last-child td { border-bottom: none; }
  .shiv-view-container table.why tbody tr:hover { background: rgba(0,0,0,0.015); }
  .shiv-view-container table.why td:first-child { font-weight: 700; color: var(--shiv-ink); }

  /* payment summary */
  .shiv-view-container .pay { margin-top: 1.5rem; border: 1px solid var(--shiv-border-strong); border-radius: 14px; overflow: hidden; background: var(--shiv-surface); box-shadow: 0 4px 16px rgba(0,0,0,0.04); }
  .shiv-view-container .pay table { width: 100%; border-collapse: collapse; margin: 0; }
  .shiv-view-container .pay th, .shiv-view-container .pay td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid var(--shiv-border); }
  .shiv-view-container .pay thead th { font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--shiv-muted); font-weight: 700; background: var(--shiv-accent-soft); border-bottom: 1px solid var(--shiv-border-strong); }
  .shiv-view-container .pay td.amt, .shiv-view-container .pay th.amt { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; font-weight: 700; color: var(--shiv-ink); }
  .shiv-view-container .pay td.item { font-weight: 700; color: var(--shiv-ink); }
  .shiv-view-container .pay tr.ref td { color: var(--shiv-muted); font-weight: 500; }
  .shiv-view-container .pay tr.ref td.item { font-weight: 700; color: var(--shiv-ink); }
  .shiv-view-container .pay tr.total td { border-bottom: none; background: linear-gradient(180deg, var(--shiv-accent-soft), transparent); font-size: 1.15rem; }
  .shiv-view-container .pay tr.total td.item { font-weight: 800; letter-spacing: -0.01em; color: var(--shiv-ink); }
  .shiv-view-container .pay tr.total td.amt { font-size: 1.75rem; font-weight: 800; color: var(--shiv-accent); }
  .shiv-view-container .pay .cur { opacity: 0.7; margin-right: 0.05rem; }
  .shiv-view-container .pay .muted { display: block; color: var(--shiv-muted); font-size: 0.82rem; font-weight: 500; margin-top: 0.25rem; line-height: 1.5; }
  .shiv-view-container .pay-note { padding: 0.85rem 1.25rem; font-size: 0.88rem; color: var(--shiv-muted); margin: 0; line-height: 1.6; border-top: 1px dashed var(--shiv-border-strong); background: var(--shiv-bg); }
  .shiv-view-container .pay-note b { color: var(--shiv-ink); }
  .shiv-view-container .was { text-decoration: line-through; text-decoration-color: var(--shiv-danger); color: var(--shiv-muted); font-weight: 600; margin-right: 0.5rem; font-size: 0.9em; }

  .shiv-view-container .savings { display: flex; align-items: center; gap: 0.85rem; margin: 1.25rem 0 0; padding: 1rem 1.25rem; border-radius: 12px; background: var(--shiv-good-soft); border: 1px solid var(--shiv-good); }
  .shiv-view-container .savings .tick { flex: none; width: 2.2rem; height: 2.2rem; border-radius: 50%; background: var(--shiv-good); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; }
  .shiv-view-container .savings p { margin: 0; font-size: 0.96rem; line-height: 1.5; color: var(--shiv-ink); }
  .shiv-view-container .savings b { color: var(--shiv-good); font-weight: 800; }

  .shiv-view-container ol.terms { margin: 0.75rem 0; padding-left: 0; counter-reset: t; list-style: none; display: flex; flex-direction: column; gap: 0.85rem; }
  .shiv-view-container ol.terms li { position: relative; padding-left: 2.35rem; counter-increment: t; line-height: 1.65; color: var(--shiv-ink); font-size: 0.96rem; }
  .shiv-view-container ol.terms li::before { content: counter(t); position: absolute; left: 0; top: 0.1rem; width: 1.6rem; height: 1.6rem; border-radius: 50%; background: var(--shiv-accent); color: #fff; font-size: 0.8rem; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(200,90,23,0.2); }
  .shiv-view-container .deadline { color: var(--shiv-accent); font-weight: 800; }

  .shiv-view-container .clause { border-left: 4px solid var(--shiv-accent); background: var(--shiv-accent-soft); padding: 1.25rem 1.5rem; border-radius: 0 12px 12px 0; margin: 1.25rem 0; font-size: 0.96rem; }
  .shiv-view-container .clause p { margin: 0.4rem 0; line-height: 1.65; color: var(--shiv-ink); }

  .shiv-view-container .sign { margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--shiv-border); display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; font-size: 0.88rem; color: var(--shiv-muted); }
  @media (max-width: 32rem) { .shiv-view-container .sign { grid-template-columns: 1fr; } }
  .shiv-view-container .sign .line { border-bottom: 1.5px solid var(--shiv-border-strong); height: 2.5rem; margin-bottom: 0.5rem; }

  /* action payment box */
  .shiv-view-container .pay-action-box {
    margin: 2.5rem auto 1.5rem; max-width: 760px; padding: 2.25rem; border-radius: 16px; text-align: center;
    background: var(--shiv-surface); border: 2px dashed var(--shiv-accent); box-shadow: var(--shiv-shadow); transition: all 0.3s ease;
  }
  .shiv-view-container .pay-action-box.approved {
    background: var(--shiv-accent-soft); border: 2px solid var(--shiv-accent);
  }
  .shiv-view-container .pay-action-box.paid {
    background: var(--shiv-good-soft); border: 2px solid var(--shiv-good); color: var(--shiv-good);
  }

  /* Payment plan selector cards */
  .shiv-plan-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1.5rem 0; text-align: left; }
  @media (max-width: 36rem) { .shiv-plan-selector { grid-template-columns: 1fr; } }
  .shiv-plan-option { border: 2px solid var(--shiv-border-strong); border-radius: 12px; padding: 1.1rem; cursor: pointer; transition: all 0.2s ease; background: var(--shiv-bg); position: relative; }
  .shiv-plan-option:hover { border-color: var(--shiv-accent); transform: translateY(-2px); }
  .shiv-plan-option.selected { border-color: var(--shiv-good); background: var(--shiv-good-soft); box-shadow: 0 0 0 1px var(--shiv-good); }
  .shiv-plan-option input[type="radio"] { position: absolute; top: 1.1rem; right: 1.1rem; accent-color: var(--shiv-good); width: 1.2rem; height: 1.2rem; cursor: pointer; }
  .shiv-plan-option .plan-title { font-weight: 800; font-size: 1.05rem; color: var(--shiv-ink); margin-bottom: 0.25rem; display: block; }
  .shiv-plan-option .plan-price { font-size: 1.45rem; font-weight: 800; color: var(--shiv-accent); margin-bottom: 0.35rem; }
  .shiv-plan-option .plan-desc { font-size: 0.85rem; color: var(--shiv-muted); line-height: 1.45; margin: 0; }

  /* Module Highlight Card */
  .module-card {
    background: var(--shiv-surface); border: 1px solid var(--shiv-border); border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s ease, border-color 0.2s ease;
  }
  .module-card:hover { transform: translateY(-2px); border-color: var(--shiv-accent); }
  .module-card h4 { margin: 0 0 0.4rem; font-size: 1.05rem; color: var(--shiv-ink); font-weight: 800; display: flex; align-items: center; gap: 0.5rem; }
  .module-card p { margin: 0; font-size: 0.92rem; color: var(--shiv-muted); line-height: 1.55; }

  /* Pre-Approval Confirmation Modal Table */
  .confirm-table { width: 100%; border-collapse: collapse; margin: 1rem 0; text-align: left; font-size: 0.92rem; }
  .confirm-table th, .confirm-table td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--shiv-border); }
  .confirm-table th { background: var(--shiv-accent-soft); color: var(--shiv-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
  .confirm-table td.amt { text-align: right; font-weight: 700; color: var(--shiv-ink); font-variant-numeric: tabular-nums; }
  .confirm-table tr.total-row td { border-top: 2px solid var(--shiv-border-strong); border-bottom: none; background: var(--shiv-good-soft); font-size: 1.15rem; font-weight: 800; color: var(--shiv-good); }

  @media print {
    :root { --shiv-bg: #fff; --shiv-surface: #fff; --shiv-shadow: none; }
    html { font-size: 12pt; }
    body { font-size: 1rem; }
    .shiv-view-container .toolbar-header { display: none; }
    .shiv-view-container .wrap { padding: 0; max-width: 100%; }
    .shiv-view-container .sheet { border: none; border-radius: 0; box-shadow: none; }
    .shiv-view-container .sheet-pad { padding: 0; }
    .shiv-view-container .pay, .shiv-view-container .clause, .shiv-view-container .pill { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .shiv-view-container section { break-inside: avoid; }
  }
</style>

<div class="shiv-view-container" data-theme-root>
  @include('proposal.brand_header', [
      'proposal' => $proposal,
      'langType' => 'hi',
      'langNameLocal' => 'हिन्दी (Hindi)',
      'segmentsEn' => json_encode($shivSegmentsEn),
      'segmentsLocal' => json_encode($shivSegmentsHi),
      'audioUrlEn' => $proposal->getTtsAudioUrl('en'),
      'audioUrlLocal' => $proposal->getTtsAudioUrl('hi')
  ])

  <div class="wrap">
    <!-- ============================= ENGLISH ============================= -->
    <article class="sheet lang-en" id="pane-en" lang="en">
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">E-Commerce Development Proposal</p>
          <h1>E-Commerce Build Agreement — Shiv Rudrakshaa</h1>
          <p class="sub">Delivering a world-class, conversion-focused spiritual e-commerce platform with 6 advanced growth modules at a finalized fixed price of ₹40,000.</p>
          <dl class="meta">
            <div><dt>Client Brand</dt><dd>Shiv Rudrakshaa (Mr. Guddu Shah)</dd></div>
            <div><dt>Final Build Fee</dt><dd>₹40,000 <span class="pill paid">Finalized Fixed Price</span></dd></div>
            <div><dt>VPS Hosting</dt><dd>₹2,400 / mo <span class="pill good">1 Month FREE on Annual</span></dd></div>
            <div><dt>Date</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>Prepared for</dt><dd><span>Shiv Rudrakshaa (South Patel Nagar, New Delhi)</span></dd></div>
            <div><dt>Prepared by</dt><dd><span>Animazon Design &amp; Web Studio</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> Project Scope &amp; Finalized Fixed Valuation</h2>
          <p><strong>Animazon Design &amp; Web Studio</strong> is pleased to partner with <strong>Shiv Rudrakshaa</strong> to deliver a high-converting, state-of-the-art e-commerce digital storefront for a finalized fixed investment of just <strong style="color: var(--shiv-accent);">₹40,000</strong>. This comprehensive package includes custom UI/UX design, full e-commerce functionality, and our six essential growth modules at zero extra charge.</p>
          <div class="clause">
            <p><strong>What We Deliver For This Price:</strong> We build an enterprise-grade e-commerce architecture tailored to Shiv Rudrakshaa's decades-established legacy. From product catalog setup to seamless payment gateway integration and automated logistics tracking, everything required to scale your online sales is included in this single fixed investment.</p>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> VPS Cloud Hosting — Select Monthly or Annual Billing</h2>
          <p>To ensure your storefront operates at lightning speed, handles high traffic during festive sales (Maha Shivaratri, Sawan), and achieves top Google SEO rankings, we provide dedicated high-performance VPS Cloud Hosting. <strong>Please select your preferred hosting billing cycle:</strong></p>
          
          <div class="interactive-grid">
            <label class="select-card active" onclick="selectShivOption('hosting', 'monthly', this)">
              <input type="radio" name="hosting_plan_en" value="monthly" checked>
              <span class="card-title" style="margin-top: 0.5rem;">Option 1: Monthly Hosting Billing</span>
              <div class="card-price">₹2,400 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ month</span></div>
              <p class="card-desc">Pay hosting month-by-month. <strong>₹2,400</strong> for your first month is added directly to today's project build invoice.</p>
            </label>

            <label class="select-card" onclick="selectShivOption('hosting', 'annual', this)" style="border-color: var(--shiv-good); background: var(--shiv-good-soft);">
              <input type="radio" name="hosting_plan_en" value="annual">
              <div>
                <span class="badge-highlight">🎁 1 MONTH FREE (Save ₹2,400)</span>
                <span class="card-title">Option 2: Annual Hosting Billing ⭐</span>
              </div>
              <div class="card-price"><span class="was">₹28,800</span>₹26,400 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ 12 months</span></div>
              <p class="card-desc">Worry-free cloud hosting for 1 full year with <b>1 Month FREE (11 months × ₹2,400 = ₹26,400)</b>. Added to today's invoice for streamlined yearly accounting.</p>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> Dedicated Maintenance &amp; Support (6 Months FREE Included)</h2>
          <p>To ensure continuous technical health, security vulnerability patching, checkout flow monitoring, and regular updates for your online business, <strong>Animazon Design &amp; Web Studio includes 6 Months of Dedicated Maintenance &amp; Support (AMC) completely FREE with your ₹40,000 package!</strong></p>
          
          <div class="amc-box opted-in" id="amcBoxEn" style="background: var(--shiv-good-soft); border: 2px solid var(--shiv-good); padding: 1.5rem; border-radius: 12px; margin-top: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
              <span style="font-size: 1.5rem;">🎉</span>
              <h3 style="margin: 0; color: var(--shiv-good); font-size: 1.2rem; font-weight: 800;">6 Months Dedicated AMC &amp; Technical Support Included FREE!</h3>
            </div>
            <p style="margin: 0 0 0.75rem; font-size: 0.95rem; color: var(--shiv-ink); line-height: 1.6;">
              <strong>You do not need to pay for or select any maintenance contract at present!</strong> For the first 6 months post-launch, our engineering team will handle all server monitoring, bug fixes, speed optimization, and security updates at zero extra cost.
            </p>
            <p style="margin: 0; font-size: 0.85rem; color: var(--shiv-muted);">
              * After the complimentary 6-month period expires, ongoing maintenance plans and charges will be decided after evaluating the website's performance, traffic, and server load requirements.
            </p>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> Included E-Commerce Growth Modules (Free with ₹40K Build)</h2>
          <p>To ensure maximum conversion rates and operational efficiency, <strong>Animazon includes these 6 essential e-commerce growth modules at zero extra build cost:</strong></p>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin-top: 1.25rem;">
            <div class="module-card">
              <h4>🌍 1. Multi-Currency &amp; Global Shipping Switcher</h4>
              <p>Enables seamless online sales across India and abroad. Automatic geo-currency conversion (INR, USD, EUR, GBP) and international logistics integration (DHL, FedEx, Aramex) with real-time export shipping rates.</p>
            </div>
            <div class="module-card">
              <h4>⚡ 2. One-Page Checkout &amp; Cart Recovery</h4>
              <p>A streamlined, high-converting checkout flow optimized for rapid purchasing. Features automated email recovery reminders for abandoned carts, guest checkout, and multi-gateway payment support (Razorpay / Stripe / UPI).</p>
            </div>
            <div class="module-card">
              <h4>📦 3. Automated Logistics &amp; Courier Tracking</h4>
              <p>Direct integration with top logistics aggregators (Shiprocket / Delhivery). Features automatic Airway Bill (AWB) generation, live shipping rate calculations, and automated SMS/Email tracking alerts for buyers.</p>
            </div>
            <div class="module-card">
              <h4>🔍 4. Advanced SEO &amp; Schema Engine</h4>
              <p>Built-in e-commerce structured data (JSON-LD schema markup), rich product snippets, XML sitemap auto-generation, and Google Merchant Center product feed setup for dominating search and shopping results.</p>
            </div>
            <div class="module-card">
              <h4>🛡️ 5. Brand Trust, SSL &amp; Review Showcase</h4>
              <p>Engineered to maximize buyer confidence. Includes verified customer photo review showcases, trust badge architecture, full SSL data encryption, and spam-protected inquiry forms.</p>
            </div>
            <div class="module-card">
              <h4>📱 6. Speed &amp; Mobile-First Optimization</h4>
              <p>Custom responsive design built specifically for mobile shoppers. Optimized for Google Core Web Vitals with sub-second page loads, touch-optimized galleries, and instant WhatsApp click-to-chat inquiry support.</p>
            </div>
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> Selectable Additional Custom Add-on Modules</h2>
          <p>Should Mr. Guddu Shah wish to expand Shiv Rudrakshaa with enterprise-grade taxation, B2B, or mobile app capabilities, you can select any of the optional custom add-on modules below. <strong>Check any box to dynamically include it in your project valuation:</strong></p>
          
          <div class="interactive-grid">
            <label class="select-card addon-card" onclick="toggleShivAddon('tax', this, event)">
              <input type="checkbox" id="addon_tax_en" value="25000">
              <span class="card-title">📊 Accounts, GST Taxation &amp; E-Invoicing</span>
              <div class="card-price">+ ₹25,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">one-time</span></div>
              <p class="card-desc">Automated GST tax calculation, B2B/B2C E-Invoicing, ledger accounting reports, and seamless export integration with Tally &amp; Zoho Books.</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('qr', this, event)">
              <input type="checkbox" id="addon_qr_en" value="12000">
              <span class="card-title">🛡️ Live Lab Report QR Verification Portal</span>
              <div class="card-price">+ ₹12,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">one-time</span></div>
              <p class="card-desc">Dedicated authenticity verification portal where customers enter certificate numbers or scan QR codes to view online X-ray testing reports and Mukhi certification.</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('puja', this, event)">
              <input type="checkbox" id="addon_puja_en" value="15000">
              <span class="card-title">🛕 Custom Vedic Puja &amp; Energization Checkout</span>
              <div class="card-price">+ ₹15,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">one-time</span></div>
              <p class="card-desc">Allows buyers to enter Name &amp; Gotra for live Vedic Puja Prana Pratistha and select custom silver/gold capping during the checkout flow.</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('b2b', this, event)">
              <input type="checkbox" id="addon_b2b_en" value="25000">
              <span class="card-title">🏢 B2B Wholesale &amp; Dealer Inquiry Portal</span>
              <div class="card-price">+ ₹25,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">one-time</span></div>
              <p class="card-desc">Tailored for wholesale dealers. Features tiered volume discounts, GST input credit invoicing, bulk quote generators, and verified dealer login.</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('wa', this, event)">
              <input type="checkbox" id="addon_wa_en" value="18000">
              <span class="card-title">💬 WhatsApp Commerce &amp; AI Chatbot Engine</span>
              <div class="card-price">+ ₹18,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">one-time</span></div>
              <p class="card-desc">WhatsApp Business API integration for automated abandoned cart recovery, shipment tracking alerts, and AI customer query answering.</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('app', this, event)">
              <input type="checkbox" id="addon_app_en" value="85000">
              <span class="card-title">📱 Custom Android &amp; iOS Mobile Shopping App</span>
              <div class="card-price">+ ₹85,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">one-time</span></div>
              <p class="card-desc">Dedicated native mobile shopping application deployed on Google Play Store and Apple App Store with push notifications and instant checkout.</p>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">6</span> Financial Quotation &amp; Live Cost Calculator</h2>
          <p>Our interactive financial table dynamically calculates your project investment based on your selected hosting billing cycle, optional AMC decision, selected add-on modules, and preferred payment schedule:</p>
          
          <div class="pay">
            <div class="tbl-scroll" style="margin: 0; border: none;">
            <table>
              <thead><tr><th class="item">Deliverable Item</th><th>Status / Billing Frequency</th><th class="amt">Amount</th></tr></thead>
              <tbody>
                <tr class="ref"><td class="item">Complete E-Commerce Website Build (WooCommerce/Shopify)<span class="muted">Finalized fixed price · Includes all 6 growth modules &amp; Multi-Currency Switcher</span></td><td><span class="pill paid">Finalized Fixed Price</span></td><td class="amt"><span class="was">₹90,000</span><span class="cur">₹</span>40,000</td></tr>
                <tr class="ref" id="row_addons_en" style="display: none;"><td class="item">Selected Custom Add-on Modules<span class="muted" id="names_addons_en">None selected</span></td><td><span class="pill due">Optional Add-ons</span></td><td class="amt"><span class="cur">₹</span><span id="val_addons_en">0</span></td></tr>
                <tr class="ref"><td class="item">VPS Cloud Hosting Infrastructure<span class="muted" id="desc_hosting_en">Monthly Billing (1st month added to invoice)</span></td><td><span class="pill good" id="badge_hosting_en">Monthly Billing</span></td><td class="amt"><span class="cur">₹</span><span id="val_hosting_en">2,400</span></td></tr>
                <tr class="ref" id="row_amc_en"><td class="item">Dedicated Maintenance &amp; Support (AMC)<span class="muted" id="desc_amc_en">6 Months of Dedicated Technical Support included at zero cost</span></td><td><span class="pill good" id="badge_amc_en">6 Months FREE Included</span></td><td class="amt" style="color:var(--shiv-good);font-weight:700;" id="val_amc_en">FREE</td></tr>
                <tr class="total"><td class="item" colspan="2" id="label_total_en">Total Project Valuation / Investment (Selected Package)</td><td class="amt"><span class="cur">₹</span><span class="total-val" id="val_total_en">42,400</span></td></tr>
              </tbody>
            </table>
            </div>
            <p class="pay-note" id="note_total_en">Total project build = <b>₹40,000</b>. You selected <b>50% Advance</b> (₹20,000 today) + <b>Monthly Hosting</b> (₹2,400 today). Total payable today = <b>₹22,400</b>.</p>
          </div>

          <div class="savings">
            <span class="tick">✓</span>
            <p><b>Complete Value Included:</b> Shiv Rudrakshaa receives a world-class e-commerce storefront along with <b>6 essential e-commerce growth modules (including Multi-Currency &amp; Global Shipping) at zero extra charge!</b></p>
          </div>

          <!-- Action Required Box -->
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--shiv-good-soft); border: 2px solid var(--shiv-good); color: var(--shiv-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ Proposal Officially Approved!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--shiv-ink);">Thank you for partnering with Animazon Design &amp; Web Studio. We are excited to build Shiv Rudrakshaa's premier online platform!</p>
                @if(!empty($razorpayKey))
                  <button id="rzpShivPayBtn" type="button" class="btn btn-primary btn-lg mt-3" style="padding: 0.8rem 2.5rem; background: var(--shiv-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    <i class="ti ti-shield-check"></i> Complete Payment — ₹<span id="rzp_val_en">22,400</span>
                  </button>
                @endif
              </div>
            @elseif($isDeclined)
              <div style="background: var(--shiv-danger-soft); border: 2px solid var(--shiv-danger); color: var(--shiv-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ Proposal Declined</strong>
                @if($proposal->decline_reason)
                  <p style="margin: 0.5rem 0 0; font-size: 0.95rem; color: var(--shiv-ink);">Reason: {{ $proposal->decline_reason }}</p>
                @endif
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--shiv-ink); font-size: 1.3rem; font-weight: 800;">Action Required: Select Payment Plan &amp; Approve</h3>
              <p style="margin: 0 0 1.25rem; color: var(--shiv-muted); font-size: 0.92rem;">Please select your preferred project payment schedule below and click approve to review selections &amp; initiate development.</p>
              
              <div class="shiv-plan-selector">
                <label class="shiv-plan-option selected" onclick="selectShivOption('payment', 'advance', this)">
                  <input type="radio" name="payment_plan_en" value="advance" checked>
                  <span class="plan-title">Option A: 50% Advance Build Fee</span>
                  <div class="plan-price" id="card_adv_val_en">₹20,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ build advance</span></div>
                  <p class="plan-desc">Pay 50% build fee today to start work. Remaining 50% build fee due after final launch &amp; QA testing.</p>
                </label>

                <label class="shiv-plan-option" onclick="selectShivOption('payment', 'full', this)">
                  <input type="radio" name="payment_plan_en" value="full">
                  <span class="plan-title">Option B: 100% Upfront Build ⭐</span>
                  <div class="plan-price" id="card_full_val_en">₹40,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ full build fee</span></div>
                  <p class="plan-desc">Streamline accounting with a single upfront build payment. Includes VIP priority development queue.</p>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;', 'id' => 'formApproveEn']) !!}
                  <input type="hidden" name="custom_total_payable" id="hidden_total_en" value="22400">
                  <input type="hidden" name="selected_hosting_plan" id="hidden_hosting_en" value="monthly">
                  <input type="hidden" name="selected_amc_opt_in" id="hidden_amc_opt_en" value="yes">
                  <input type="hidden" name="selected_amc_plan" id="hidden_amc_plan_en" value="6_months_free">
                  <input type="hidden" name="selected_payment_schedule" id="hidden_payment_en" value="advance">
                  <input type="hidden" name="selected_addon_modules" id="hidden_addons_en" value="">
                  
                  <button type="button" onclick="openShivConfirmModal('en')" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--shiv-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(46,125,50,0.3);">
                    ✓ Review Selections &amp; Approve — ₹<span id="btn_val_en">22,400</span>
                  </button>
                {!! Form::close() !!}

                <button type="button" onclick="document.getElementById('declineModalShiv').style.display='flex'" style="font-size: 1.1rem; padding: 0.8rem 1.75rem; background: transparent; color: var(--shiv-danger); border: 1px solid var(--shiv-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                  ✕ Decline
                </button>
              </div>
            @endif
          </div>
        </section>

        <section>
          <h2><span class="n">7</span> Project Timeline &amp; Delivery Guarantee</h2>
          <ol class="terms">
            <li><strong>Rapid Turnaround Timeline:</strong> We commit to completing and launching the full e-commerce platform within <strong>3 to 4 weeks</strong> from onboarding and receipt of initial product catalog data and brand assets.</li>
            <li><strong>Client Collaboration:</strong> To maintain this rapid pace, Shiv Rudrakshaa agrees to promptly provide product details, bead pricing, lab certificates, and feedback during QA testing.</li>
            <li><strong>Hosting &amp; AMC Activation:</strong> Your selected hosting plan and 6 Months Free AMC coverage will commence upon project onboarding and server provisioning.</li>
            <li><span class="deadline">Proposal Validity: 15 days</span> from the date of issuance. Post validity, terms may be re-evaluated based on development team availability.</li>
          </ol>
        </section>

        <div style="margin-top: 3.5rem; padding: 2rem; background: var(--shiv-accent-soft); border: 1px solid var(--shiv-border); border-radius: 14px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1.5rem; align-items: center;">
          <div>
            <h4 style="margin: 0 0 0.5rem; color: var(--shiv-ink); font-size: 1.1rem; font-weight: 800;">Animazon Design &amp; Web Studio</h4>
            <p style="margin: 0; color: var(--shiv-muted); font-size: 0.9rem; line-height: 1.6;">
              <strong>Email:</strong> <a href="mailto:info@animazon.in" style="color: var(--shiv-accent); text-decoration: none; font-weight: 600;">info@animazon.in</a> &nbsp;|&nbsp; 
              <strong>Phone / WhatsApp:</strong> <a href="tel:+918089405950" style="color: var(--shiv-accent); text-decoration: none; font-weight: 600;">+91 80894 05950</a>
            </p>
            <p style="margin: 0.3rem 0 0; color: var(--shiv-muted); font-size: 0.85rem;">
              <strong>Website:</strong> <a href="https://animazon.in" target="_blank" style="color: var(--shiv-ink); text-decoration: underline;">https://animazon.in</a>
            </p>
          </div>
          <div style="display: flex; gap: 0.75rem;">
            <a href="mailto:info@animazon.in" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.3rem; background: var(--shiv-surface); border: 1px solid var(--shiv-border-strong); color: var(--shiv-ink); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
              ✉️ Email Us
            </a>
            <a href="https://wa.me/918089405950" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.3rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37,211,102,0.2);">
              💬 WhatsApp
            </a>
          </div>
        </div>

        <div class="sign">
          <div><div class="line"></div>Mr. Guddu Shah (Owner / Proprietor) — signature &amp; date<br><strong style="color: var(--shiv-ink);">Shiv Rudrakshaa (South Patel Nagar, New Delhi)</strong></div>
          <div><div class="line"></div><strong>Animazon Design &amp; Web Studio</strong><br><span style="font-size: 0.85rem; color: var(--shiv-muted);">info@animazon.in | +91 80894 05950</span></div>
        </div>
      </div>
    </article>

    <!-- ============================= HINDI ============================= -->
    <article class="sheet lang-hi" id="pane-hi" lang="hi" hidden>
      <div class="sheet-pad">
        <header class="mast">
          <p class="eyebrow">ई-कॉमर्स वेबसाइट निर्माण प्रस्ताव</p>
          <h1>ई-कॉमर्स विकास समझौता — शिव रुद्राक्षा (Shiv Rudrakshaa)</h1>
          <p class="sub">शिव रुद्राक्षा के लिए 6 महत्वपूर्ण आधुनिक ई-कॉमर्स ग्रोथ मॉड्यूल के साथ एक अत्याधुनिक, प्रीमियम ऑनलाइन स्टोर का मात्र ₹40,000 के तय मूल्य पर प्रस्ताव।</p>
          <dl class="meta">
            <div><dt>क्लाइंट ब्रांड</dt><dd>शिव रुद्राक्षा (श्री गुड्डू शाह)</dd></div>
            <div><dt>अंतिम तय शुल्क</dt><dd>₹40,000 <span class="pill paid">अंतिम तय मूल्य (Finalized)</span></dd></div>
            <div><dt>वीपीएस होस्टिंग</dt><dd>₹2,400 / माह <span class="pill good">वार्षिक पर 1 माह मुफ़्त</span></dd></div>
            <div><dt>दिनांक</dt><dd><span>{{ $proposal->issue_date ? $proposal->issue_date->format('d M Y') : date('d M Y') }}</span></dd></div>
            <div><dt>प्रस्तुतकर्ता</dt><dd><span>शिव रुद्राक्षा (साउथ पटेल नगर, नई दिल्ली)</span></dd></div>
            <div><dt>निर्माता</dt><dd><span>एनिमेज़ॉन डिज़ाइन व वेब स्टूडियो</span></dd></div>
          </dl>
        </header>

        <section>
          <h2><span class="n">1</span> प्रोजेक्ट स्कोप व अंतिम तय मूल्य</h2>
          <p><strong>एनिमेज़ॉन डिज़ाइन स्टूडियो (Animazon Design &amp; Web Studio)</strong> <strong>शिव रुद्राक्षा (Shiv Rudrakshaa)</strong> के लिए एक अत्याधुनिक, प्रीमियम और हाई-कन्वर्जन ई-कॉमर्स वेबसाइट विकसित करने के लिए प्रस्तुत है। इस संपूर्ण प्रोजेक्ट का अंतिम तय शुल्क केवल <strong style="color: var(--shiv-accent);">₹40,000</strong> रखा गया है।</p>
          <div class="clause">
            <p><strong>इस शुल्क में क्या शामिल है:</strong> हम शिव रुद्राक्षा की वर्षों पुरानी प्रतिष्ठा के अनुरूप एक विश्वस्तरीय ई-कॉमर्स प्लेटफॉर्म तैयार करेंगे। इसमें कस्टम UI/UX डिज़ाइन, सुरक्षित पेमेंट गेटवे इंटीग्रेशन, और बिना किसी अतिरिक्त शुल्क के 6 प्रमुख ग्रोथ मॉड्यूल (अंतरराष्ट्रीय शिपिंग व मल्टी-करेंसी सहित) शामिल हैं।</p>
          </div>
        </section>

        <section>
          <h2><span class="n">2</span> वीपीएस क्लाउड होस्टिंग — मासिक या वार्षिक विकल्प चुनें</h2>
          <p>आपकी वेबसाइट तेज गति से चले, महाशिवरात्रि व सावन की भारी ट्रैफिक को आसानी से संभाले, और गूगल एसईओ (SEO) में शीर्ष पर रहे, इसके लिए हम प्रीमियम वीपीएस क्लाउड होस्टिंग प्रदान करते हैं। <strong>कृपया अपना पसंदीदा होस्टिंग भुगतान विकल्प चुनें:</strong></p>
          
          <div class="interactive-grid">
            <label class="select-card active" onclick="selectShivOption('hosting', 'monthly', this)">
              <input type="radio" name="hosting_plan_hi" value="monthly" checked>
              <span class="card-title" style="margin-top: 0.5rem;">विकल्प 1: मासिक होस्टिंग भुगतान</span>
              <div class="card-price">₹2,400 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ माह</span></div>
              <p class="card-desc">हर महीने होस्टिंग शुल्क दें। पहले महीने के <strong>₹2,400</strong> आज के प्रोजेक्ट इनवॉइस में जोड़ दिए गए हैं।</p>
            </label>

            <label class="select-card" onclick="selectShivOption('hosting', 'annual', this)" style="border-color: var(--shiv-good); background: var(--shiv-good-soft);">
              <input type="radio" name="hosting_plan_hi" value="annual">
              <div>
                <span class="badge-highlight">🎁 1 महीना मुफ़्त (₹2,400 की बचत)</span>
                <span class="card-title">विकल्प 2: वार्षिक होस्टिंग भुगतान ⭐</span>
              </div>
              <div class="card-price"><span class="was">₹28,800</span>₹26,400 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ 12 महीने</span></div>
              <p class="card-desc">पूरे 1 साल के लिए निश्चिंत क्लाउड होस्टिंग, जिसमें <b>1 महीना बिल्कुल मुफ़्त (11 महीने × ₹2,400 = ₹26,400)</b> शामिल है। एकमुश्त वार्षिक लेखांकन के लिए आज के इनवॉइस में जोड़ा जाएगा।</p>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">3</span> समर्पित रखरखाव व तकनीकी सहायता (6 महीने बिल्कुल मुफ़्त)</h2>
          <p>आपकी वेबसाइट की निरंतर तकनीकी सुरक्षा, बग फिक्स, और सुचारू संचालन सुनिश्चित करने के लिए, <strong>एनिमेज़ॉन डिज़ाइन स्टूडियो आपके ₹40,000 के पैकेज के साथ 6 महीने का समर्पित एएमसी (AMC) व सपोर्ट बिल्कुल मुफ़्त (Free) प्रदान कर रहा है!</strong></p>
          
          <div class="amc-box opted-in" id="amcBoxHi" style="background: var(--shiv-good-soft); border: 2px solid var(--shiv-good); padding: 1.5rem; border-radius: 12px; margin-top: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
              <span style="font-size: 1.5rem;">🎉</span>
              <h3 style="margin: 0; color: var(--shiv-good); font-size: 1.2rem; font-weight: 800;">6 महीने का समर्पित एएमसी (AMC) व सपोर्ट बिल्कुल मुफ़्त!</h3>
            </div>
            <p style="margin: 0 0 0.75rem; font-size: 0.95rem; color: var(--shiv-ink); line-height: 1.6;">
              <strong>वर्तमान में एएमसी (AMC) के लिए कुछ भी भुगतान करने की कोई आवश्यकता नहीं है!</strong> आपके ई-कॉमर्स स्टोर के लॉन्च के बाद पूरे 6 महीने तक समर्पित तकनीकी देखभाल, सर्वर मॉनिटरिंग, सुरक्षा अपडेट और स्पीड ऑप्टिमाइजेशन बिना किसी शुल्क के (Zero Cost) प्रदान किया जाएगा।
            </p>
            <p style="margin: 0; font-size: 0.85rem; color: var(--shiv-muted);">
              * 6 महीने की नि:शुल्क अवधि समाप्त होने के बाद, वेबसाइट के प्रदर्शन, ट्रैफिक और सर्वर लोड की जांच करने के बाद ही आगे की एएमसी सेवा और शुल्क तय किया जाएगा।
            </p>
          </div>
        </section>

        <section>
          <h2><span class="n">4</span> ₹40,000 में शामिल 6 प्रमुख ई-कॉमर्स ग्रोथ मॉड्यूल</h2>
          <p>आपकी ऑनलाइन बिक्री और व्यावसायिक वृद्धि को गति देने के लिए, <strong>एनिमेज़ॉन आपके ₹40,000 के पैकेज में निम्नलिखित 6 प्रमुख ई-कॉमर्स ग्रोथ मॉड्यूल बिल्कुल मुफ़्त (Zero Extra Cost) शामिल कर रहा है:</strong></p>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin-top: 1.25rem;">
            <div class="module-card">
              <h4>🌍 1. बहु-मुद्रा (Multi-Currency) व अंतरराष्ट्रीय शिपिंग</h4>
              <p>भारत और विदेशों (अमेरिका, यूरोप, ब्रिटेन) में निर्बाध बिक्री के लिए स्वचालित मुद्रा परिवर्तन (INR, USD, EUR, GBP) और अंतर्राष्ट्रीय कूरियर (DHL, FedEx, Aramex) एकीकरण।</p>
            </div>
            <div class="module-card">
              <h4>⚡ 2. वन-पेज चेकआउट व अधूरे ऑर्डर (Abandoned Cart) रिकवरी</h4>
              <p>ग्राहकों के लिए त्वरित व आसान चेकआउट। अधूरे ऑर्डर्स की स्वचालित ईमेल रिकवरी, गेस्ट चेकआउट और सुरक्षित पेमेंट गेटवे (Razorpay / Stripe / UPI) का एकीकरण।</p>
            </div>
            <div class="module-card">
              <h4>📦 3. स्वचालित लॉजिस्टिक्स व कूरियर ट्रैकिंग</h4>
              <p>शीर्ष लॉजिस्टिक्स एग्रीगेटर्स (Shiprocket / Delhivery) का एकीकरण। लाइव शिपिंग दरें, स्वचालित एयरवे बिल (AWB) निर्माण, और एसएमएस/ईमेल द्वारा लाइव ऑर्डर ट्रैकिंग अपडेट।</p>
            </div>
            <div class="module-card">
              <h4>🔍 4. उन्नत एसईओ (SEO) व गूगल मर्चेंट सेंटर इंजन</h4>
              <p>ई-कॉमर्स स्कीमा मार्कअप, एक्सएमएल (XML) साइटमैप, और गूगल मर्चेंट सेंटर प्रोडक्ट फीड सेटअप ताकि गूगल सर्च और शॉपिंग टैब पर आपके उत्पाद शीर्ष पर दिखें।</p>
            </div>
            <div class="module-card">
              <h4>🛡️ 5. ब्रांड सुरक्षा, एसएसएल (SSL) व वेरिफाइड कस्टमर रिव्यू</h4>
              <p>ग्राहकों का भरोसा जीतने के लिए ट्रस्ट बैज, फोटो के साथ सत्यापित ग्राहक समीक्षाएं (Reviews), एसएसएल एन्क्रिप्शन और स्पैम-मुक्त पूछताछ फॉर्म।</p>
            </div>
            <div class="module-card">
              <h4>📱 6. मोबाइल-फर्स्ट रिस्पॉन्सिव डिजाइन व स्पीड ऑप्टिमाइजेशन</h4>
              <p>विशेष रूप से मोबाइल खरीदारों के लिए 1 सेकंड से कम समय में खुलने वाले पेज, टच-ऑप्टिमाइज्ड गैलरी, रुद्राक्ष ज़ूम-इन इंस्पेक्शन और व्हाट्सएप क्विक-चैट बटन।</p>
            </div>
          </div>
        </section>

        <section>
          <h2><span class="n">5</span> वैकल्पिक अतिरिक्त कस्टम मॉड्यूल (मूल्य के साथ चयन करें)</h2>
          <p>यदि श्री गुड्डू शाह शिव रुद्राक्षा के ऑनलाइन स्टोर में विशिष्ट B2B, टैक्सेशन या मोबाइल ऐप क्षमताएं जोड़ना चाहते हैं, तो आप नीचे दिए गए किसी भी अतिरिक्त मॉड्यूल का चयन कर सकते हैं। <strong>अपने प्रोजेक्ट में जोड़ने के लिए किसी भी बॉक्स पर चेक (☑) करें:</strong></p>
          
          <div class="interactive-grid">
            <label class="select-card addon-card" onclick="toggleShivAddon('tax', this, event)">
              <input type="checkbox" id="addon_tax_hi" value="25000">
              <span class="card-title">📊 अकाउंट्स, जीएसटी (GST) टैक्सेशन व ई-इनवॉइसिंग</span>
              <div class="card-price">+ ₹25,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">एकमुश्त</span></div>
              <p class="card-desc">स्वचालित जीएसटी कर गणना, B2B/B2C ई-इनवॉइसिंग, बहीखाता (Ledger) रिपोर्ट्स और टैली (Tally) / जोहो (Zoho Books) में आसान एक्सपोर्ट।</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('qr', this, event)">
              <input type="checkbox" id="addon_qr_hi" value="12000">
              <span class="card-title">🛡️ लाइव लैब रिपोर्ट व QR ऑथेंटिसिटी पोर्टल</span>
              <div class="card-price">+ ₹12,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">एकमुश्त</span></div>
              <p class="card-desc">समर्पित प्रमाणिकता सत्यापन पोर्टल जहाँ ग्राहक सर्टिफिकेट नंबर डालकर या पैकेजिंग पर QR कोड स्कैन करके ऑनलाइन एक्स-रे रिपोर्ट देख सकते हैं।</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('puja', this, event)">
              <input type="checkbox" id="addon_puja_hi" value="15000">
              <span class="card-title">🛕 कस्टम वैदिक पूजा व अभिमंत्रित चेकआउट</span>
              <div class="card-price">+ ₹15,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">एकमुश्त</span></div>
              <p class="card-desc">चेकआउट के समय खरीदारों को नाम और गोत्र डालकर वैदिक पूजा (प्राण प्रतिष्ठा / अभिमंत्रित) कराने और चांदी/सोने की कैपिंग चुनने की सुविधा।</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('b2b', this, event)">
              <input type="checkbox" id="addon_b2b_hi" value="25000">
              <span class="card-title">🏢 B2B होलसेल व थोक व्यापार डीलर पोर्टल</span>
              <div class="card-price">+ ₹25,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">एकमुश्त</span></div>
              <p class="card-desc">शिव रुद्राक्षा के थोक व्यापार के लिए। मात्रा के आधार पर छूट, जीएसटी इनपुट क्रेडिट इनवॉइसिंग, थोक कोटेशन जेनरेटर और डीलर लॉगिन।</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('wa', this, event)">
              <input type="checkbox" id="addon_wa_hi" value="18000">
              <span class="card-title">💬 व्हाट्सएप कॉमर्स व AI चैटबॉट इंजन</span>
              <div class="card-price">+ ₹18,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">एकमुश्त</span></div>
              <p class="card-desc">व्हाट्सएप बिजनेस API द्वारा अधूरे ऑर्डर्स की स्वचालित रिकवरी अलर्ट, शिपमेंट ट्रैकिंग अपडेट और ग्राहकों के सवालों का AI चैटबॉट द्वारा जवाब।</p>
            </label>

            <label class="select-card addon-card" onclick="toggleShivAddon('app', this, event)">
              <input type="checkbox" id="addon_app_hi" value="85000">
              <span class="card-title">📱 कस्टम एंड्रॉयड व iOS मोबाइल शॉपिंग ऐप</span>
              <div class="card-price">+ ₹85,000 <span style="font-size: 0.75rem; color: var(--shiv-muted); font-weight: 600;">एकमुश्त</span></div>
              <p class="card-desc">गूगल प्ले स्टोर और एप्पल ऐप स्टोर पर आपका समर्पित मोबाइल ऐप, पुश नोटिफिकेशन और त्वरित चेकआउट के साथ।</p>
            </label>
          </div>
        </section>

        <section>
          <h2><span class="n">6</span> वित्तीय कोटेशन व लाइव मूल्य कैलकुलेटर</h2>
          <p>हमारा इंटरैक्टिव मूल्य कैलकुलेटर आपके चुने गए होस्टिंग विकल्प, एएमसी निर्णय, अतिरिक्त मॉड्यूल और भुगतान विकल्प के आधार पर आपकी कुल देय राशि की लाइव गणना करता है:</p>
          
          <div class="pay">
            <div class="tbl-scroll" style="margin: 0; border: none;">
            <table>
              <thead><tr><th class="item">विवरण</th><th>स्थिति / बिलिंग चक्र</th><th class="amt">राशि</th></tr></thead>
              <tbody>
                <tr class="ref"><td class="item">संपूर्ण ई-कॉमर्स वेबसाइट निर्माण (WooCommerce/Shopify)<span class="muted">अंतिम तय मूल्य · 6 प्रमुख ग्रोथ मॉड्यूल व मल्टी-करेंसी एक्सपोर्ट शामिल</span></td><td><span class="pill paid">अंतिम तय मूल्य (Finalized)</span></td><td class="amt"><span class="was">₹90,000</span><span class="cur">₹</span>40,000</td></tr>
                <tr class="ref" id="row_addons_hi" style="display: none;"><td class="item">चयनित अतिरिक्त कस्टम मॉड्यूल<span class="muted" id="names_addons_hi">कोई मॉड्यूल नहीं चुना गया</span></td><td><span class="pill due">वैकल्पिक मॉड्यूल</span></td><td class="amt"><span class="cur">₹</span><span id="val_addons_hi">0</span></td></tr>
                <tr class="ref"><td class="item">वीपीएस क्लाउड होस्टिंग इंफ्रास्ट्रक्चर<span class="muted" id="desc_hosting_hi">मासिक बिलिंग (पहला महीना इनवॉइस में शामिल)</span></td><td><span class="pill good" id="badge_hosting_hi">मासिक बिलिंग</span></td><td class="amt"><span class="cur">₹</span><span id="val_hosting_hi">2,400</span></td></tr>
                <tr class="ref" id="row_amc_hi"><td class="item">समर्पित रखरखाव व तकनीकी सहायता (AMC)<span class="muted" id="desc_amc_hi">6 महीने की तकनीकी देखभाल व सपोर्ट बिना किसी अतिरिक्त शुल्क के शामिल</span></td><td><span class="pill good" id="badge_amc_hi">6 महीने बिल्कुल मुफ़्त</span></td><td class="amt" style="color:var(--shiv-good);font-weight:700;" id="val_amc_hi">FREE</td></tr>
                <tr class="total"><td class="item" colspan="2" id="label_total_hi">कुल प्रोजेक्ट लागत (चयनित पैकेज)</td><td class="amt"><span class="cur">₹</span><span class="total-val" id="val_total_hi">42,400</span></td></tr>
              </tbody>
            </table>
            </div>
            <p class="pay-note" id="note_total_hi">कुल वेबसाइट निर्माण = <b>₹40,000</b>। आपने <b>50% एडवांस</b> (₹20,000 आज) + <b>मासिक होस्टिंग</b> (₹2,400 आज) चुना है। आज कुल देय राशि = <b>₹22,400</b>।</p>
          </div>

          <div class="savings">
            <span class="tick">✓</span>
            <p><b>संपूर्ण मूल्य शामिल:</b> शिव रुद्राक्षा को विश्वस्तरीय ई-कॉमर्स स्टोर के साथ <b>6 महत्वपूर्ण आधुनिक ई-कॉमर्स ग्रोथ मॉड्यूल (मल्टी-करेंसी व अंतरराष्ट्रीय शिपिंग सहित) बिल्कुल मुफ़्त मिलते हैं!</b></p>
          </div>

          <!-- Action Required Box -->
          <div class="pay-action-box">
            @if($isAccepted)
              <div style="background: var(--shiv-good-soft); border: 2px solid var(--shiv-good); color: var(--shiv-good); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✓ प्रस्ताव आधिकारिक रूप से स्वीकृत!</strong>
                <p style="margin: 0; font-size: 0.95rem; color: var(--shiv-ink);">एनिमेज़ॉन डिज़ाइन स्टूडियो पर भरोसा करने के लिए धन्यवाद। हम शिव रुद्राक्षा के प्रीमियम ऑनलाइन स्टोर के निर्माण के लिए उत्साहित हैं!</p>
              </div>
            @elseif($isDeclined)
              <div style="background: var(--shiv-danger-soft); border: 2px solid var(--shiv-danger); color: var(--shiv-danger); padding: 2rem; border-radius: 12px;">
                <strong style="font-size: 1.35rem; display: block; margin-bottom: 0.5rem;">✕ प्रस्ताव अस्वीकृत</strong>
                @if($proposal->decline_reason)
                  <p style="margin: 0.5rem 0 0; font-size: 0.95rem; color: var(--shiv-ink);">कारण: {{ $proposal->decline_reason }}</p>
                @endif
              </div>
            @else
              <h3 style="margin: 0 0 0.5rem; color: var(--shiv-ink); font-size: 1.3rem; font-weight: 800;">आवश्यक कार्रवाई: भुगतान विकल्प चुनें और स्वीकृत करें</h3>
              <p style="margin: 0 0 1.25rem; color: var(--shiv-muted); font-size: 0.92rem;">प्रोजेक्ट टेकओवर शुरू करने के लिए कृपया नीचे अपना पसंदीदा भुगतान विकल्प चुनें और समीक्षा कर स्वीकृत करें बटन पर क्लिक करें।</p>
              
              <div class="shiv-plan-selector">
                <label class="shiv-plan-option selected" onclick="selectShivOption('payment', 'advance', this)">
                  <input type="radio" name="payment_plan_hi" value="advance" checked>
                  <span class="plan-title">विकल्प ए: 50% एडवांस निर्माण शुल्क</span>
                  <div class="plan-price" id="card_adv_val_hi">₹20,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ निर्माण एडवांस</span></div>
                  <p class="plan-desc">काम शुरू करने के लिए आज 50% निर्माण शुल्क दें। शेष 50% शुल्क वेबसाइट लाइव होने और टेस्टिंग के बाद देय होगा।</p>
                </label>

                <label class="shiv-plan-option" onclick="selectShivOption('payment', 'full', this)">
                  <input type="radio" name="payment_plan_hi" value="full">
                  <span class="plan-title">विकल्प बी: 100% एकमुश्त निर्माण शुल्क ⭐</span>
                  <div class="plan-price" id="card_full_val_hi">₹40,000 <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ पूर्ण निर्माण शुल्क</span></div>
                  <p class="plan-desc">एकमुश्त भुगतान के साथ लेखांकन को आसान बनाएं। इसमें वीआईपी (VIP) प्राथमिकता विकास कतार शामिल है।</p>
                </label>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                {!! Form::open(['route' => ['proposal.public.approve', $publicParam], 'method' => 'POST', 'style' => 'margin: 0;', 'id' => 'formApproveHi']) !!}
                  <input type="hidden" name="custom_total_payable" id="hidden_total_hi" value="22400">
                  <input type="hidden" name="selected_hosting_plan" id="hidden_hosting_hi" value="monthly">
                  <input type="hidden" name="selected_amc_opt_in" id="hidden_amc_opt_hi" value="yes">
                  <input type="hidden" name="selected_amc_plan" id="hidden_amc_plan_hi" value="6_months_free">
                  <input type="hidden" name="selected_payment_schedule" id="hidden_payment_hi" value="advance">
                  <input type="hidden" name="selected_addon_modules" id="hidden_addons_hi" value="">

                  <button type="button" onclick="openShivConfirmModal('hi')" style="font-size: 1.1rem; padding: 0.8rem 2.5rem; background: var(--shiv-good); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(46,125,50,0.3);">
                    ✓ चयनित पैकेज समीक्षा व स्वीकृति — ₹<span id="btn_val_hi">22,400</span>
                  </button>
                {!! Form::close() !!}

                <button type="button" onclick="document.getElementById('declineModalShiv').style.display='flex'" style="font-size: 1.1rem; padding: 0.8rem 1.75rem; background: transparent; color: var(--shiv-danger); border: 1px solid var(--shiv-danger); border-radius: 8px; font-weight: 600; cursor: pointer;">
                  ✕ अस्वीकृत करें
                </button>
              </div>
            @endif
          </div>
        </section>

        <section>
          <h2><span class="n">7</span> समय-सीमा और डिलीवरी गारंटी</h2>
          <ol class="terms">
            <li><strong>तीव्र निर्माण समय-सीमा:</strong> हम ऑनबोर्डिंग और शुरुआती प्रोडक्ट डेटा व ब्रांड लोगो मिलने के <strong>3 से 4 सप्ताह</strong> के भीतर संपूर्ण ई-कॉमर्स प्लेटफॉर्म को पूरा करने और लाइव करने की प्रतिबद्धता जताते हैं।</li>
            <li><strong>क्लाइंट का सहयोग:</strong> इस तीव्र गति को बनाए रखने के लिए, शिव रुद्राक्षा समय पर प्रोडक्ट जानकारी, मूल्य, और टेस्टिंग के दौरान फीडबैक देने के लिए सहमत होता है।</li>
            <li><strong>होस्टिंग व एएमसी सक्रियण:</strong> आपका चुना गया होस्टिंग विकल्प और 6 महीने की मुफ़्त एएमसी (AMC) सेवा सर्वर चालू होने पर शुरू होगी।</li>
            <li><span class="deadline">प्रस्ताव वैधता: 15 दिन</span>। इस अवधि के बाद टीम की उपलब्धता के आधार पर शर्तों की समीक्षा की जा सकती है।</li>
          </ol>
        </section>

        <div style="margin-top: 3.5rem; padding: 2rem; background: var(--shiv-accent-soft); border: 1px solid var(--shiv-border); border-radius: 14px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1.5rem; align-items: center;">
          <div>
            <h4 style="margin: 0 0 0.5rem; color: var(--shiv-ink); font-size: 1.1rem; font-weight: 800;">एनिमेज़ॉन डिज़ाइन व वेब स्टूडियो</h4>
            <p style="margin: 0; color: var(--shiv-muted); font-size: 0.9rem; line-height: 1.6;">
              <strong>इमेल:</strong> <a href="mailto:info@animazon.in" style="color: var(--shiv-accent); text-decoration: none; font-weight: 600;">info@animazon.in</a> &nbsp;|&nbsp; 
              <strong>फोन / व्हाट्सएप:</strong> <a href="tel:+918089405950" style="color: var(--shiv-accent); text-decoration: none; font-weight: 600;">+91 80894 05950</a>
            </p>
            <p style="margin: 0.3rem 0 0; color: var(--shiv-muted); font-size: 0.85rem;">
              <strong>वेबसाइट:</strong> <a href="https://animazon.in" target="_blank" style="color: var(--shiv-ink); text-decoration: underline;">https://animazon.in</a>
            </p>
          </div>
          <div style="display: flex; gap: 0.75rem;">
            <a href="mailto:info@animazon.in" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.3rem; background: var(--shiv-surface); border: 1px solid var(--shiv-border-strong); color: var(--shiv-ink); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
              ✉️ इमेल करें
            </a>
            <a href="https://wa.me/918089405950" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.3rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37,211,102,0.2);">
              💬 व्हाट्सएप
            </a>
          </div>
        </div>

        <div class="sign">
          <div><div class="line"></div>श्री गुड्डू शाह (मालिक / प्रोपराइटर) — हस्ताक्षर व दिनांक<br><strong style="color: var(--shiv-ink);">शिव रुद्राक्षा (साउथ पटेल नगर, नई दिल्ली)</strong></div>
          <div><div class="line"></div><strong>एनिमेज़ॉन डिज़ाइन व वेब स्टूडियो</strong><br><span style="font-size: 0.85rem; color: var(--shiv-muted);">info@animazon.in | +91 80894 05950</span></div>
        </div>
      </div>
    </article>
  </div>
</div>

<!-- Pre-Approval Confirmation Modal -->
<div id="confirmModalShiv" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 1050; align-items: center; justify-content: center; padding: 1rem; backdrop-filter: blur(4px);">
  <div style="background: var(--shiv-surface); color: var(--shiv-ink); padding: 2.25rem; border-radius: 16px; max-width: 650px; width: 100%; box-shadow: 0 24px 48px rgba(0,0,0,0.35); border: 1px solid var(--shiv-border); max-height: 90vh; overflow-y: auto;">
    <h3 id="confirmModalTitle" style="margin: 0 0 0.5rem; font-size: 1.35rem; font-weight: 800; color: var(--shiv-ink); display: flex; align-items: center; gap: 0.5rem;">
      📋 Review Your Selected Package &amp; Total Investment
    </h3>
    <p id="confirmModalSub" style="margin: 0 0 1.25rem; font-size: 0.92rem; color: var(--shiv-muted);">
      Please verify your selected development schedule, hosting plan, and optional modules before submitting your official approval.
    </p>

    <div style="border: 1px solid var(--shiv-border-strong); border-radius: 12px; overflow: hidden; background: var(--shiv-bg); margin-bottom: 1.5rem;">
      <table class="confirm-table" id="confirmTableBody">
        <!-- Dynamically populated by JS -->
      </table>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: flex-end; flex-wrap: wrap;">
      <button type="button" onclick="document.getElementById('confirmModalShiv').style.display='none'" style="padding: 0.75rem 1.5rem; background: transparent; border: 2px solid var(--shiv-border-strong); border-radius: 8px; color: var(--shiv-ink); font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
        ← <span id="confirmBtnBackText">Back / Edit Selections</span>
      </button>
      <button type="button" id="confirmBtnSubmit" onclick="submitShivApproval()" style="padding: 0.75rem 2rem; background: var(--shiv-good); border: none; border-radius: 8px; color: #fff; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(46,125,50,0.3); transition: all 0.2s ease;">
        <span id="confirmBtnSubmitText">✓ Confirm &amp; Submit Approval — ₹0</span>
      </button>
    </div>
  </div>
</div>

<!-- Decline Modal -->
<div id="declineModalShiv" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
  <div style="background: var(--shiv-surface); color: var(--shiv-ink); padding: 2rem; border-radius: 16px; max-width: 450px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.3); border: 1px solid var(--shiv-border);">
    <h3 style="margin: 0 0 0.5rem; font-size: 1.25rem; font-weight: 800;">Decline Proposal</h3>
    <p style="margin: 0 0 1.25rem; font-size: 0.9rem; color: var(--shiv-muted);">Please let us know why you are declining so we can adjust our valuation or technical scope.</p>
    
    {!! Form::open(['route' => ['proposal.public.decline', $publicParam], 'method' => 'POST']) !!}
      <textarea name="decline_reason" rows="3" placeholder="Enter reason (optional)..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--shiv-border-strong); border-radius: 8px; background: var(--shiv-bg); color: var(--shiv-ink); font-family: inherit; font-size: 0.9rem; margin-bottom: 1.25rem;"></textarea>
      
      <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
        <button type="button" onclick="document.getElementById('declineModalShiv').style.display='none'" style="padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--shiv-border-strong); border-radius: 8px; color: var(--shiv-ink); font-weight: 600; cursor: pointer;">
          Cancel
        </button>
        <button type="submit" style="padding: 0.6rem 1.2rem; background: var(--shiv-danger); border: none; border-radius: 8px; color: #fff; font-weight: 700; cursor: pointer;">
          Confirm Decline
        </button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

<script>
  // Global Interactive State
  let shivState = {
    coreBuild: 40000,
    hostingPlan: 'monthly', // 'monthly' (2400) or 'annual' (26400 with 1 month free)
    amcOptIn: true,
    amcPlan: '6_months_free', // 6 Months Free included
    paymentSchedule: 'advance', // 'advance' (50%) or 'full' (100%)
    addons: {
      tax:    { nameEn: 'Accounts, GST Taxation & E-Invoicing', nameHi: 'अकाउंट्स, जीएसटी टैक्सेशन व ई-इनवॉइसिंग', price: 25000, selected: false },
      qr:     { nameEn: 'Live Lab Report QR Portal', nameHi: 'लाइव लैब रिपोर्ट QR ऑथेंटिसिटी पोर्टल', price: 12000, selected: false },
      puja:   { nameEn: 'Custom Vedic Puja & Energization', nameHi: 'कस्टम वैदिक पूजा व अभिमंत्रित चेकआउट', price: 15000, selected: false },
      b2b:    { nameEn: 'B2B Wholesale & Dealer Portal', nameHi: 'B2B होलसेल व डीलर पोर्टल', price: 25000, selected: false },
      wa:     { nameEn: 'WhatsApp Commerce & AI Chatbot', nameHi: 'व्हाट्सएप कॉमर्स व AI चैटबॉट', price: 18000, selected: false },
      app:    { nameEn: 'Custom Android & iOS Shopping App', nameHi: 'कस्टम एंड्रॉयड व iOS मोबाइल ऐप', price: 85000, selected: false }
    }
  };

  let currentConfirmLang = 'en';

  function formatINR(amount) {
    return Math.round(amount).toLocaleString('en-IN');
  }

  function toggleShivAMC(isChecked) {
    // 6 Months AMC is included FREE by default
    updateShivCalculator();
  }

  function selectShivOption(category, val, el) {
    if (category === 'hosting') {
      shivState.hostingPlan = val;
      document.querySelectorAll('input[name="hosting_plan_en"][value="' + val + '"]').forEach(r => { r.checked = true; r.closest('.select-card').classList.add('active'); });
      document.querySelectorAll('input[name="hosting_plan_hi"][value="' + val + '"]').forEach(r => { r.checked = true; r.closest('.select-card').classList.add('active'); });
      document.querySelectorAll('input[name="hosting_plan_en"]:not([value="' + val + '"])').forEach(r => r.closest('.select-card').classList.remove('active'));
      document.querySelectorAll('input[name="hosting_plan_hi"]:not([value="' + val + '"])').forEach(r => r.closest('.select-card').classList.remove('active'));
    } else if (category === 'payment') {
      shivState.paymentSchedule = val;
      document.querySelectorAll('input[name="payment_plan_en"][value="' + val + '"]').forEach(r => { r.checked = true; r.closest('.shiv-plan-option').classList.add('selected'); });
      document.querySelectorAll('input[name="payment_plan_hi"][value="' + val + '"]').forEach(r => { r.checked = true; r.closest('.shiv-plan-option').classList.add('selected'); });
      document.querySelectorAll('input[name="payment_plan_en"]:not([value="' + val + '"])').forEach(r => r.closest('.shiv-plan-option').classList.remove('selected'));
      document.querySelectorAll('input[name="payment_plan_hi"]:not([value="' + val + '"])').forEach(r => r.closest('.shiv-plan-option').classList.remove('selected'));
    }
    updateShivCalculator();
  }

  function toggleShivAddon(key, el, evt) {
    if (evt.target.tagName !== 'INPUT') {
      const chk = el.querySelector('input[type="checkbox"]');
      chk.checked = !chk.checked;
    }
    const isSelected = el.querySelector('input[type="checkbox"]').checked;
    shivState.addons[key].selected = isSelected;

    // Sync EN and HI
    const chkEn = document.getElementById('addon_' + key + '_en');
    const chkHi = document.getElementById('addon_' + key + '_hi');
    if (chkEn) { chkEn.checked = isSelected; isSelected ? chkEn.closest('.select-card').classList.add('addon-active') : chkEn.closest('.select-card').classList.remove('addon-active'); }
    if (chkHi) { chkHi.checked = isSelected; isSelected ? chkHi.closest('.select-card').classList.add('addon-active') : chkHi.closest('.select-card').classList.remove('addon-active'); }

    updateShivCalculator();
  }

  function updateShivCalculator() {
    // 1. Calculate Add-ons total
    let addonsTotal = 0;
    let selectedNamesEn = [];
    let selectedNamesHi = [];
    for (let k in shivState.addons) {
      if (shivState.addons[k].selected) {
        addonsTotal += shivState.addons[k].price;
        selectedNamesEn.push(shivState.addons[k].nameEn + ' (₹' + formatINR(shivState.addons[k].price) + ')');
        selectedNamesHi.push(shivState.addons[k].nameHi + ' (₹' + formatINR(shivState.addons[k].price) + ')');
      }
    }

    // 2. Build Fee Calculations
    let totalBuildFee = shivState.coreBuild + addonsTotal;
    let buildPayableToday = (shivState.paymentSchedule === 'advance') ? (totalBuildFee / 2) : totalBuildFee;

    // Update Plan Card Prices in Checkout Box
    let advAmount = totalBuildFee / 2;
    document.getElementById('card_adv_val_en').innerHTML = '₹' + formatINR(advAmount) + ' <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ build advance</span>';
    document.getElementById('card_adv_val_hi').innerHTML = '₹' + formatINR(advAmount) + ' <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ निर्माण एडवांस</span>';
    document.getElementById('card_full_val_en').innerHTML = '₹' + formatINR(totalBuildFee) + ' <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ full build fee</span>';
    document.getElementById('card_full_val_hi').innerHTML = '₹' + formatINR(totalBuildFee) + ' <span style="font-size: 0.8rem; font-weight: 600; color: var(--shiv-muted);">/ पूर्ण निर्माण शुल्क</span>';

    // 3. Hosting Calculations (1 Month Free on Annual = 26,400)
    let hostingPayableToday = (shivState.hostingPlan === 'annual') ? 26400 : 2400;
    let hostingBadgeEn = (shivState.hostingPlan === 'annual') ? 'Annual Billing (1 Month FREE)' : 'Monthly Billing';
    let hostingBadgeHi = (shivState.hostingPlan === 'annual') ? 'वार्षिक बिलिंग (1 माह मुफ़्त)' : 'मासिक बिलिंग';
    let hostingDescEn = (shivState.hostingPlan === 'annual') ? 'Annual Billing (11 months @ ₹2,400/mo = ₹26,400 added to invoice, 1 month free)' : 'Monthly Billing (1st month added to invoice)';
    let hostingDescHi = (shivState.hostingPlan === 'annual') ? 'वार्षिक बिलिंग (11 महीने @ ₹2,400/माह = ₹26,400 इनवॉइस में शामिल, 1 माह मुफ़्त)' : 'मासिक बिलिंग (पहला महीना इनवॉइस में शामिल)';

    // 4. AMC Calculations (6 Months FREE Included)
    let amcPayableToday = 0;
    if (document.getElementById('row_amc_en')) {
      document.getElementById('row_amc_en').style.display = 'table-row';
      document.getElementById('val_amc_en').innerHTML = 'FREE';
      document.getElementById('badge_amc_en').innerText = '6 Months FREE Included';
      document.getElementById('desc_amc_en').innerText = '6 Months of Dedicated Technical Support included at zero cost';
    }
    if (document.getElementById('row_amc_hi')) {
      document.getElementById('row_amc_hi').style.display = 'table-row';
      document.getElementById('val_amc_hi').innerHTML = 'FREE';
      document.getElementById('badge_amc_hi').innerText = '6 महीने बिल्कुल मुफ़्त';
      document.getElementById('desc_amc_hi').innerText = '6 महीने की तकनीकी देखभाल व सपोर्ट बिना किसी अतिरिक्त शुल्क के शामिल';
    }

    // 5. Add-ons Table Row (Always show ACTUAL 100% selected amount in initial table)
    if (addonsTotal > 0) {
      document.getElementById('row_addons_en').style.display = 'table-row';
      document.getElementById('row_addons_hi').style.display = 'table-row';
      document.getElementById('val_addons_en').innerText = formatINR(addonsTotal);
      document.getElementById('val_addons_hi').innerText = formatINR(addonsTotal);
      document.getElementById('names_addons_en').innerText = selectedNamesEn.join(', ');
      document.getElementById('names_addons_hi').innerText = selectedNamesHi.join(', ');
    } else {
      document.getElementById('row_addons_en').style.display = 'none';
      document.getElementById('row_addons_hi').style.display = 'none';
    }

    // 6. Update Hosting Table Row
    document.getElementById('val_hosting_en').innerText = formatINR(hostingPayableToday);
    document.getElementById('val_hosting_hi').innerText = formatINR(hostingPayableToday);
    document.getElementById('badge_hosting_en').innerText = hostingBadgeEn;
    document.getElementById('badge_hosting_hi').innerText = hostingBadgeHi;
    document.getElementById('desc_hosting_en').innerText = hostingDescEn;
    document.getElementById('desc_hosting_hi').innerText = hostingDescHi;

    // 7. Calculate Grand Total Valuation (Table sum of actual amounts) & Grand Total Payable Today (Checkout amount)
    let grandTotalValuation = totalBuildFee + hostingPayableToday + amcPayableToday;
    let grandTotalToday = buildPayableToday + hostingPayableToday + amcPayableToday;

    // Update Table Bottom Row (Shows Actual Total Project Valuation)
    document.getElementById('label_total_en').innerText = 'Total Project Valuation / Investment (Selected Package)';
    document.getElementById('label_total_hi').innerText = 'कुल प्रोजेक्ट लागत (चयनित पैकेज)';
    document.getElementById('val_total_en').innerText = formatINR(grandTotalValuation);
    document.getElementById('val_total_hi').innerText = formatINR(grandTotalValuation);

    // Update Notes
    let noteEn = 'Total Project Valuation = <b>₹' + formatINR(grandTotalValuation) + '</b> (<b>₹' + formatINR(totalBuildFee) + '</b> build + <b>' + hostingBadgeEn + ' (₹' + formatINR(hostingPayableToday) + ')</b> + <b>6 Months AMC (FREE)</b>).<br>In Checkout below, you selected <b>' + ((shivState.paymentSchedule === 'advance') ? '50% Advance Build (₹' + formatINR(advAmount) + ' today)' : '100% Upfront Build (₹' + formatINR(totalBuildFee) + ' today)') + '</b>. Total payable today = <b style="color:var(--shiv-accent); font-size:1.1em;">₹' + formatINR(grandTotalToday) + '</b>.';
    document.getElementById('note_total_en').innerHTML = noteEn;

    let noteHi = 'कुल प्रोजेक्ट लागत = <b>₹' + formatINR(grandTotalValuation) + '</b> (<b>₹' + formatINR(totalBuildFee) + '</b> निर्माण + <b>' + hostingBadgeHi + ' (₹' + formatINR(hostingPayableToday) + ')</b> + <b>6 महीने AMC (मुफ़्त)</b>) ।<br>नीचे चेकआउट में आपने <b>' + ((shivState.paymentSchedule === 'advance') ? '50% एडवांस (₹' + formatINR(advAmount) + ' आज)' : '100% एकमुश्त (₹' + formatINR(totalBuildFee) + ' आज)') + '</b> चुना है। आज कुल देय राशि = <b style="color:var(--shiv-accent); font-size:1.1em;">₹' + formatINR(grandTotalToday) + '</b>।';
    document.getElementById('note_total_hi').innerHTML = noteHi;

    // Update Buttons & Hidden Fields
    if (document.getElementById('btn_val_en')) document.getElementById('btn_val_en').innerText = formatINR(grandTotalToday);
    if (document.getElementById('btn_val_hi')) document.getElementById('btn_val_hi').innerText = formatINR(grandTotalToday);
    if (document.getElementById('rzp_val_en')) document.getElementById('rzp_val_en').innerText = formatINR(grandTotalToday);

    // Update Hidden Form Inputs
    ['en', 'hi'].forEach(lang => {
      if (document.getElementById('hidden_total_' + lang)) document.getElementById('hidden_total_' + lang).value = grandTotalToday;
      if (document.getElementById('hidden_hosting_' + lang)) document.getElementById('hidden_hosting_' + lang).value = shivState.hostingPlan;
      if (document.getElementById('hidden_amc_opt_' + lang)) document.getElementById('hidden_amc_opt_' + lang).value = 'yes';
      if (document.getElementById('hidden_amc_plan_' + lang)) document.getElementById('hidden_amc_plan_' + lang).value = '6_months_free';
      if (document.getElementById('hidden_payment_' + lang)) document.getElementById('hidden_payment_' + lang).value = shivState.paymentSchedule;
      if (document.getElementById('hidden_addons_' + lang)) document.getElementById('hidden_addons_' + lang).value = selectedNamesEn.join('; ');
    });
  }

  // Pre-Approval Confirmation Modal Logic
  function openShivConfirmModal(lang) {
    currentConfirmLang = lang;
    const isHi = (lang === 'hi');

    // 1. Calculate current values
    let addonsTotal = 0;
    let checkedAddonsList = [];
    for (let k in shivState.addons) {
      if (shivState.addons[k].selected) {
        addonsTotal += shivState.addons[k].price;
        let name = isHi ? shivState.addons[k].nameHi : shivState.addons[k].nameEn;
        checkedAddonsList.push('• ' + name + ' (₹' + formatINR(shivState.addons[k].price) + ')');
      }
    }

    let totalBuildFee = shivState.coreBuild + addonsTotal;
    let buildPayableToday = (shivState.paymentSchedule === 'advance') ? (totalBuildFee / 2) : totalBuildFee;
    let hostingPayableToday = (shivState.hostingPlan === 'annual') ? 26400 : 2400;
    let amcPayableToday = 0; // 6 Months Free Included
    let grandTotalToday = buildPayableToday + hostingPayableToday + amcPayableToday;

    // 2. Set Modal Titles and Buttons
    if (isHi) {
      document.getElementById('confirmModalTitle').innerHTML = '📋 अपने चयनित पैकेज और कुल शुल्क की समीक्षा करें';
      document.getElementById('confirmModalSub').innerText = 'अंतिम स्वीकृति देने से पहले कृपया अपने चुने गए निर्माण विकल्प, होस्टिंग और अतिरिक्त मॉड्यूल की जांच करें।';
      document.getElementById('confirmBtnBackText').innerText = 'पीछे जाएं / बदलाव करें';
      document.getElementById('confirmBtnSubmitText').innerText = '✓ अंतिम स्वीकृति दें और जमा करें — ₹' + formatINR(grandTotalToday);
    } else {
      document.getElementById('confirmModalTitle').innerHTML = '📋 Review Your Selected Package &amp; Total Investment';
      document.getElementById('confirmModalSub').innerText = 'Please verify your selected development schedule, hosting plan, and optional modules before submitting your official approval.';
      document.getElementById('confirmBtnBackText').innerText = 'Back / Edit Selections';
      document.getElementById('confirmBtnSubmitText').innerText = '✓ Confirm & Submit Approval — ₹' + formatINR(grandTotalToday);
    }

    // 3. Build Table HTML
    let thItem = isHi ? 'चयनित सेवा / मॉड्यूल विवरण' : 'Selected Service / Module Item';
    let thType = isHi ? 'भुगतान प्रकार' : 'Billing Schedule';
    let thAmt  = isHi ? 'आज देय राशि (₹)' : 'Payable Today (₹)';

    let buildTitle = isHi ? 'ई-कॉमर्स मुख्य वेबसाइट निर्माण (6 ग्रोथ मॉड्यूल सहित)' : 'E-Commerce Core Build (includes 6 Growth Modules)';
    let buildType  = isHi ? ((shivState.paymentSchedule === 'advance') ? '50% एडवांस (कुल ₹40,000)' : '100% एकमुश्त शुल्क') : ((shivState.paymentSchedule === 'advance') ? '50% Advance (Total ₹40,000)' : '100% Upfront Build');
    let buildAmtVal = (shivState.paymentSchedule === 'advance') ? 20000 : 40000;

    let html = `<thead><tr><th>${thItem}</th><th>${thType}</th><th style="text-align:right;">${thAmt}</th></tr></thead><tbody>`;
    
    // Core Build Row
    html += `<tr><td><strong>${buildTitle}</strong></td><td><span class="pill paid">${buildType}</span></td><td class="amt">₹${formatINR(buildAmtVal)}</td></tr>`;

    // Addons Row
    if (addonsTotal > 0) {
      let addonsTitle = isHi ? 'चयनित अतिरिक्त कस्टम सॉफ्टवेयर मॉड्यूल' : 'Selected Custom Add-on Modules';
      let addonsType = isHi ? ((shivState.paymentSchedule === 'advance') ? '50% एडवांस (कुल ₹' + formatINR(addonsTotal) + ')' : '100% एकमुश्त शुल्क') : ((shivState.paymentSchedule === 'advance') ? '50% Advance (Total ₹' + formatINR(addonsTotal) + ')' : '100% Upfront Fee');
      let addonsAmtVal = (shivState.paymentSchedule === 'advance') ? (addonsTotal / 2) : addonsTotal;
      html += `<tr><td><strong>${addonsTitle}</strong><br><span style="font-size:0.82rem; color:var(--shiv-muted); line-height:1.4; display:block; margin-top:4px;">${checkedAddonsList.join('<br>')}</span></td><td><span class="pill due">${addonsType}</span></td><td class="amt">₹${formatINR(addonsAmtVal)}</td></tr>`;
    }

    // Hosting Row (Annual has 1 Month Free = 26,400)
    let hostingTitle = isHi ? 'प्रीमियम वीपीएस क्लाउड होस्टिंग' : 'Premium VPS Cloud Hosting';
    let hostingType  = isHi ? ((shivState.hostingPlan === 'annual') ? 'वार्षिक बिलिंग (1 माह मुफ़्त)' : 'मासिक बिलिंग') : ((shivState.hostingPlan === 'annual') ? 'Annual Billing (1 Month FREE)' : 'Monthly Billing');
    html += `<tr><td><strong>${hostingTitle}</strong></td><td><span class="pill good">${hostingType}</span></td><td class="amt">₹${formatINR(hostingPayableToday)}</td></tr>`;

    // AMC Row (6 Months FREE Included)
    let amcTitle = isHi ? 'समर्पित रखरखाव व तकनीकी सहायता (AMC)' : 'Dedicated Maintenance & Support (AMC)';
    let amcType  = isHi ? '6 महीने बिल्कुल मुफ़्त (Included Free)' : '6 Months FREE Included';
    html += `<tr><td><strong>${amcTitle}</strong></td><td><span class="pill good">${amcType}</span></td><td class="amt" style="color:var(--shiv-good);font-weight:700;">₹0 (FREE)</td></tr>`;

    // Total Row
    let totalTitle = isHi ? 'आज कुल देय राशि (Grand Total Payable Today)' : 'Grand Total Payable Today';
    html += `<tr class="total-row"><td colspan="2"><strong>${totalTitle}</strong></td><td class="amt" style="font-size:1.4rem; color:var(--shiv-accent);">₹${formatINR(grandTotalToday)}</td></tr>`;
    html += `</tbody>`;

    document.getElementById('confirmTableBody').innerHTML = html;
    document.getElementById('confirmModalShiv').style.display = 'flex';
  }

  function submitShivApproval() {
    let formId = (currentConfirmLang === 'hi') ? 'formApproveHi' : 'formApproveEn';
    document.getElementById(formId).submit();
  }

  // Run initial calculation on page load
  document.addEventListener('DOMContentLoaded', function() {
    updateShivCalculator();
  });
</script>
