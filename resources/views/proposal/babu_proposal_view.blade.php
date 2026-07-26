<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    /* ─── IPCATN Document Reset ─── */
    .ipca-doc * { box-sizing: border-box; }
    .ipca-doc {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: #1e293b;
        line-height: 1.7;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #faf5ff 100%);
        padding: 30px 16px;
        min-height: 100vh;
    }

    /* ─── Main Container ─── */
    .ipca-doc .doc-container {
        max-width: 960px;
        margin: 0 auto;
    }

    /* ─── Hero Header ─── */
    .ipca-doc .doc-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #1e40af 100%);
        border-radius: 20px;
        padding: 48px 40px 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.3);
    }
    .ipca-doc .doc-hero::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .ipca-doc .doc-hero::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(234, 179, 8, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .ipca-doc .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(234, 179, 8, 0.15);
        border: 1px solid rgba(234, 179, 8, 0.3);
        color: #fbbf24;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
        position: relative;
    }
    .ipca-doc .doc-hero h1 {
        color: #ffffff;
        font-size: 36px;
        font-weight: 800;
        margin: 0 0 8px;
        letter-spacing: -0.5px;
        position: relative;
    }
    .ipca-doc .doc-hero .hero-sub {
        color: #94a3b8;
        font-size: 15px;
        font-weight: 400;
        margin: 0;
        position: relative;
    }

    /* ─── Meta Cards ─── */
    .ipca-doc .meta-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
        margin-bottom: 28px;
    }
    .ipca-doc .meta-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .ipca-doc .meta-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .ipca-doc .meta-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 12px;
    }
    .ipca-doc .meta-icon.blue { background: #dbeafe; color: #2563eb; }
    .ipca-doc .meta-icon.amber { background: #fef3c7; color: #d97706; }
    .ipca-doc .meta-icon.green { background: #dcfce7; color: #16a34a; }
    .ipca-doc .meta-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 4px;
    }
    .ipca-doc .meta-value {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ─── Section Cards ─── */
    .ipca-doc .section-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .ipca-doc .section-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }
    .ipca-doc .section-num {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
    }
    .ipca-doc .section-num.s1 { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .ipca-doc .section-num.s2 { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .ipca-doc .section-num.s3 { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .ipca-doc .section-num.s4 { background: linear-gradient(135deg, #10b981, #059669); }
    .ipca-doc .section-num.s5 { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .ipca-doc .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    /* ─── Screen Layout Diagram ─── */
    .ipca-doc .screen-layout {
        display: grid;
        grid-template-columns: 80px 1fr 80px;
        gap: 12px;
        align-items: stretch;
        margin: 20px 0 10px;
        padding: 24px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 14px;
    }
    .ipca-doc .screen-panel {
        border-radius: 8px;
        padding: 16px 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .ipca-doc .screen-main {
        background: linear-gradient(135deg, #1e3a5f, #2563eb);
        border: 2px solid #3b82f6;
        min-height: 120px;
    }
    .ipca-doc .screen-side {
        background: rgba(99, 102, 241, 0.15);
        border: 1px dashed #6366f1;
        writing-mode: vertical-rl;
        font-size: 10px;
    }
    .ipca-doc .screen-panel .screen-label {
        color: #93c5fd;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .ipca-doc .screen-panel .screen-dim {
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
    }
    .ipca-doc .screen-panel .screen-desc {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 6px;
    }
    .ipca-doc .screen-side .screen-label { writing-mode: vertical-rl; color: #a5b4fc; }
    .ipca-doc .screen-side .screen-dim { writing-mode: vertical-rl; color: #c7d2fe; font-size: 12px; }

    /* ─── Committee Member Cards ─── */
    .ipca-doc .member-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .ipca-doc .member-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 18px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .ipca-doc .member-card:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
    }
    .ipca-doc .member-card.chairman {
        grid-column: 1 / -1;
        background: linear-gradient(135deg, #fefce8 0%, #fef9c3 100%);
        border-color: #fde68a;
    }
    .ipca-doc .member-avatar {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .ipca-doc .member-avatar.c1 { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .ipca-doc .member-avatar.c2 { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .ipca-doc .member-avatar.c3 { background: linear-gradient(135deg, #10b981, #059669); }
    .ipca-doc .member-avatar.c4 { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .ipca-doc .member-avatar.c5 { background: linear-gradient(135deg, #ec4899, #db2777); }
    .ipca-doc .member-name {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }
    .ipca-doc .member-role {
        font-size: 12px;
        color: #64748b;
    }
    .ipca-doc .member-company {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }
    .ipca-doc .role-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 4px;
    }
    .ipca-doc .role-badge.gold { background: #fef3c7; color: #92400e; }
    .ipca-doc .role-badge.blue { background: #dbeafe; color: #1e40af; }

    /* ─── Day Timeline ─── */
    .ipca-doc .day-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 28px 0 22px;
        padding: 16px 22px;
        border-radius: 12px;
        color: #fff;
    }
    .ipca-doc .day-header.day1 {
        background: linear-gradient(135deg, #0f766e, #0d9488);
    }
    .ipca-doc .day-header.day2 {
        background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    }
    .ipca-doc .day-header .day-num {
        font-size: 28px;
        font-weight: 900;
        opacity: 0.3;
    }
    .ipca-doc .day-header .day-title {
        font-size: 16px;
        font-weight: 700;
    }
    .ipca-doc .day-header .day-sub {
        font-size: 12px;
        opacity: 0.8;
    }

    /* ─── Timeline Items ─── */
    .ipca-doc .timeline {
        position: relative;
        padding-left: 36px;
    }
    .ipca-doc .timeline::before {
        content: '';
        position: absolute;
        left: 14px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #e2e8f0, #cbd5e1);
    }
    .ipca-doc .tl-item {
        position: relative;
        margin-bottom: 18px;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .ipca-doc .tl-item:hover {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }
    .ipca-doc .tl-item::before {
        content: '';
        position: absolute;
        left: -28px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        background: #fff;
    }
    .ipca-doc .tl-item.highlight::before {
        background: #3b82f6;
        border-color: #1d4ed8;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }
    .ipca-doc .tl-item.special {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border-color: #fde68a;
    }
    .ipca-doc .tl-item.special::before {
        border-color: #f59e0b;
        background: #f59e0b;
    }
    .ipca-doc .tl-item.break-item {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-color: #bae6fd;
        text-align: center;
        padding: 10px;
    }
    .ipca-doc .tl-item.break-item::before {
        border-color: #94a3b8;
        background: #94a3b8;
    }
    .ipca-doc .tl-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }
    .ipca-doc .tl-desc {
        font-size: 13px;
        color: #475569;
        margin: 0;
    }
    .ipca-doc .tl-persons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    .ipca-doc .person-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
    }
    .ipca-doc .person-chip .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #3b82f6;
    }
    .ipca-doc .person-chip.gold-chip {
        background: #fffbeb;
        border-color: #fde68a;
    }
    .ipca-doc .person-chip.gold-chip .dot { background: #f59e0b; }

    /* ─── Special Announcements ─── */
    .ipca-doc .special-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .ipca-doc .special-card {
        padding: 22px;
        border-radius: 14px;
        border: 1px solid;
    }
    .ipca-doc .special-card.lucky {
        background: linear-gradient(135deg, #fefce8, #fef9c3);
        border-color: #fde68a;
    }
    .ipca-doc .special-card.souvenir {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-color: #bbf7d0;
    }
    .ipca-doc .special-emoji {
        font-size: 28px;
        margin-bottom: 12px;
    }
    .ipca-doc .special-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }
    .ipca-doc .special-desc {
        font-size: 13px;
        color: #64748b;
    }

    /* ─── Pending Assets Checklist ─── */
    .ipca-doc .checklist {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .ipca-doc .checklist li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 8px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        font-size: 13px;
        color: #431407;
    }
    .ipca-doc .checklist li .check-icon {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        border: 2px solid #f97316;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
        font-size: 10px;
        color: #f97316;
    }

    /* ─── Approval CTA ─── */
    .ipca-doc .approval-cta {
        background: linear-gradient(135deg, #0f172a, #1e3a5f);
        border-radius: 16px;
        padding: 36px 32px;
        text-align: center;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .ipca-doc .approval-cta::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 30% 50%, rgba(99, 102, 241, 0.1), transparent 60%);
        pointer-events: none;
    }
    .ipca-doc .approval-cta h3 {
        color: #ffffff;
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 8px;
        position: relative;
    }
    .ipca-doc .approval-cta p {
        color: #94a3b8;
        font-size: 14px;
        margin: 0;
        position: relative;
    }

    /* ─── Footer ─── */
    .ipca-doc .doc-footer {
        text-align: center;
        padding: 16px;
        font-size: 12px;
        color: #94a3b8;
    }

    /* ─── Responsive ─── */
    @media (max-width: 768px) {
        .ipca-doc .meta-row { grid-template-columns: 1fr; }
        .ipca-doc .member-grid { grid-template-columns: 1fr; }
        .ipca-doc .special-grid { grid-template-columns: 1fr; }
        .ipca-doc .screen-layout { grid-template-columns: 1fr; }
        .ipca-doc .screen-side { writing-mode: horizontal-tb; }
        .ipca-doc .screen-side .screen-label,
        .ipca-doc .screen-side .screen-dim { writing-mode: horizontal-tb; }
        .ipca-doc .doc-hero { padding: 28px 20px; }
        .ipca-doc .doc-hero h1 { font-size: 24px; }
        .ipca-doc .section-card { padding: 20px; }
    }
</style>

<div class="ipca-doc">
    <div class="doc-container">

        {{-- ═══ HERO HEADER ═══ --}}
        <div class="doc-hero">
            <div class="hero-badge">⚡ Official Scope Document</div>
            <h1>IPCA Event — Munnar</h1>
            <p class="hero-sub">Master Video Production, Display Sequence & Content Specification Document</p>
        </div>

        {{-- ═══ META INFO CARDS ═══ --}}
        <div class="meta-row">
            <div class="meta-card">
                <div class="meta-icon blue">🎬</div>
                <div class="meta-label">Deliverable</div>
                <div class="meta-value">On-Screen Event Presentation & Display Videos</div>
            </div>
            <div class="meta-card">
                <div class="meta-icon amber">📅</div>
                <div class="meta-label">Event Dates</div>
                <div class="meta-value">July 23 – 24, 2026</div>
            </div>
            <div class="meta-card">
                <div class="meta-icon green">📋</div>
                <div class="meta-label">Total Program Items</div>
                <div class="meta-value">2 Days · 18+ Segments</div>
            </div>
        </div>

        {{-- ═══ SECTION 1: SCREEN SPECIFICATIONS ═══ --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-num s1">1</div>
                <h2 class="section-title">Display Layout & Screen Specifications</h2>
            </div>

            <div class="screen-layout">
                <div class="screen-panel screen-side">
                    <div class="screen-label">Left Wing</div>
                    <div class="screen-dim">2×10 ft</div>
                </div>
                <div class="screen-panel screen-main">
                    <div class="screen-label">Main Center Screen</div>
                    <div class="screen-dim">16 × 10 ft</div>
                    <div class="screen-desc">Video playback · Profile slides · Presentations · Announcements</div>
                </div>
                <div class="screen-panel screen-side">
                    <div class="screen-label">Right Wing</div>
                    <div class="screen-dim">2×10 ft</div>
                </div>
            </div>

            <div style="margin-top: 18px;">
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px; padding: 14px 18px; background: #f1f5f9; border-radius: 10px; border-left: 3px solid #3b82f6;">
                        <div style="font-size: 12px; font-weight: 700; color: #1e40af; margin-bottom: 4px;">🔄 Standby Loop</div>
                        <div style="font-size: 12px; color: #64748b;">30-sec rotating sponsor logo slideshow on side wings</div>
                    </div>
                    <div style="flex: 1; min-width: 200px; padding: 14px 18px; background: #f1f5f9; border-radius: 10px; border-left: 3px solid #8b5cf6;">
                        <div style="font-size: 12px; font-weight: 700; color: #6d28d9; margin-bottom: 4px;">🔗 Felicitation Sync</div>
                        <div style="font-size: 12px; color: #64748b;">Side wings mirror center screen during honors</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ SECTION 2: COMMITTEE MEMBERS ═══ --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-num s2">2</div>
                <h2 class="section-title">Key Committee Members & Office Bearers</h2>
            </div>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Prominently featured across official address slides, profiles, and felicitations.</p>

            <div class="member-grid">
                <div class="member-card chairman">
                    <div class="member-avatar c1">BT</div>
                    <div>
                        <div class="member-name">Babu Thiyagarajan <span class="role-badge gold">★ Chairman</span></div>
                        <div class="member-role">Founder Chairman</div>
                        <div class="member-company">Platinaa Paint Industries</div>
                    </div>
                </div>
                <div class="member-card">
                    <div class="member-avatar c2">SA</div>
                    <div>
                        <div class="member-name">Sivarajan Arunachalam</div>
                        <div class="member-role">Vice Chairman & Convener <span class="role-badge blue">Dual Role</span></div>
                        <div class="member-company">Sree Paints</div>
                    </div>
                </div>
                <div class="member-card">
                    <div class="member-avatar c3">CR</div>
                    <div>
                        <div class="member-name">Chandramohan Ramasamy</div>
                        <div class="member-role">General Secretary</div>
                        <div class="member-company">Aara Paints</div>
                    </div>
                </div>
                <div class="member-card">
                    <div class="member-avatar c4">LS</div>
                    <div>
                        <div class="member-name">L.G. Senthil Kumar</div>
                        <div class="member-role">Finance Secretary</div>
                        <div class="member-company">Asir Containers</div>
                    </div>
                </div>
                <div class="member-card">
                    <div class="member-avatar c5">BR</div>
                    <div>
                        <div class="member-name">B. Raguragavan</div>
                        <div class="member-role">Joint Secretary</div>
                        <div class="member-company">Bala Enterprises</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ SECTION 3: MASTER VIDEO PROGRAM SEQUENCE ═══ --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-num s3">3</div>
                <h2 class="section-title">Master Video Program Sequence</h2>
            </div>

            {{-- ─── DAY 1 ─── --}}
            <div class="day-header day1">
                <div class="day-num">01</div>
                <div>
                    <div class="day-title">Inauguration, Addresses & Felicitations</div>
                    <div class="day-sub">July 23, 2026</div>
                </div>
            </div>

            <div class="timeline">
                <div class="tl-item highlight">
                    <div class="tl-title">🏛️ Main Event Title Slide</div>
                    <p class="tl-desc">IPCA Munnar Welcome & Branding Banner</p>
                </div>

                <div class="tl-item special">
                    <div class="tl-title">🪔 Lamp Lighting Ceremony (Kuthu Vilakku)</div>
                    <p class="tl-desc">Visual slide with devotional background music — Ganesh Invocation / Lamp Lighting melody</p>
                </div>

                <div class="tl-item">
                    <div class="tl-title">🎤 Welcome Address Slides</div>
                    <div class="tl-persons">
                        <span class="person-chip gold-chip"><span class="dot"></span>Babu Thiyagarajan — Founder Chairman</span>
                        <span class="person-chip"><span class="dot"></span>Sivarajan Arunachalam — Vice Chairman & Convener</span>
                    </div>
                </div>

                <div class="tl-item">
                    <div class="tl-title">📸 Keynote Addresses (Photo, Name & Designation Slides)</div>
                    <div class="tl-persons">
                        <span class="person-chip"><span class="dot"></span>President Address</span>
                        <span class="person-chip"><span class="dot"></span>Vice President Address</span>
                        <span class="person-chip"><span class="dot"></span>Chief Guest Address</span>
                    </div>
                </div>

                <div class="tl-item highlight">
                    <div class="tl-title">🇮🇳 National Anthem</div>
                    <p class="tl-desc">Standard audio-visual video playback</p>
                </div>

                <div class="tl-item highlight">
                    <div class="tl-title">🏴 Tamil Thai Vaazthu</div>
                    <p class="tl-desc">Standard audio-visual video playback</p>
                </div>

                <div class="tl-item special">
                    <div class="tl-title">🏆 Sponsor Felicitations</div>
                    <p class="tl-desc"><strong>Main Screen (16×10):</strong> Dedicated custom slides for 12–15 key sponsors (e.g., <em>Fine Organics – Diamond Sponsor</em>)</p>
                    <p class="tl-desc" style="margin-top: 6px;"><strong>Side Wings (2×10):</strong> Simultaneous sponsor logo display, synchronized with center screen</p>
                </div>

                <div class="tl-item">
                    <div class="tl-title">🚀 New Ventures Introduction</div>
                    <p class="tl-desc">Special slide deck introducing upcoming schemes, ventures, and announcements</p>
                </div>

                <div class="tl-item">
                    <div class="tl-title">🙏 Vote of Thanks (Day 1)</div>
                    <div class="tl-persons">
                        <span class="person-chip"><span class="dot"></span>Chandramohan Ramasamy — General Secretary</span>
                        <span class="person-chip"><span class="dot"></span>B. Raguragavan — Joint Secretary</span>
                    </div>
                </div>
            </div>

            {{-- ─── DAY 2 ─── --}}
            <div class="day-header day2">
                <div class="day-num">02</div>
                <div>
                    <div class="day-title">Technical Sessions, Panel Discussion & Closing</div>
                    <div class="day-sub">July 24, 2026</div>
                </div>
            </div>

            <div class="timeline">
                <div class="tl-item">
                    <div class="tl-title">📊 Morning Technical Presentations (Sessions 1–5)</div>
                    <p class="tl-desc">Individual slides per session: <em>Presentation Title + Speaker Photo + Name & Designation</em></p>
                </div>

                <div class="tl-item break-item">
                    <div class="tl-title" style="margin: 0; color: #0369a1;">🍽️ LUNCH BREAK</div>
                </div>

                <div class="tl-item">
                    <div class="tl-title">📊 Afternoon Technical Presentations (Sessions 6 & 7)</div>
                    <p class="tl-desc">Individual speaker profile slides for Presentations 6 and 7</p>
                </div>

                <div class="tl-item">
                    <div class="tl-title">💬 Panel Discussion</div>
                    <p class="tl-desc">Overview slide: Panel topic + Moderator name + Photos/names of all participating panelists</p>
                </div>

                <div class="tl-item">
                    <div class="tl-title">🎙️ Closing Ceremony Addresses</div>
                    <div class="tl-persons">
                        <span class="person-chip"><span class="dot"></span>Sivarajan Arunachalam — Vice Chairman & Convener</span>
                        <span class="person-chip gold-chip"><span class="dot"></span>Babu Thiyagarajan — Founder Chairman</span>
                        <span class="person-chip"><span class="dot"></span>President & Vice President</span>
                    </div>
                </div>

                <div class="tl-item">
                    <div class="tl-title">💭 Impressions & Guest Remarks</div>
                    <p class="tl-desc">Feedback segment slides featuring profile photos:</p>
                    <div class="tl-persons">
                        <span class="person-chip"><span class="dot"></span>Maharashtra Chairman</span>
                        <span class="person-chip"><span class="dot"></span>Madhya Pradesh Chairman</span>
                        <span class="person-chip"><span class="dot"></span>Secretary & Treasurer</span>
                    </div>
                </div>

                <div class="tl-item highlight">
                    <div class="tl-title">🙏 Vote of Thanks (Closing)</div>
                    <div class="tl-persons">
                        <span class="person-chip"><span class="dot"></span>Chandramohan Ramasamy — General Secretary</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ SECTION 4: SPECIAL ANNOUNCEMENTS ═══ --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-num s4">4</div>
                <h2 class="section-title">Special Interactive & Event Announcements</h2>
            </div>

            <div class="special-grid">
                <div class="special-card lucky">
                    <div class="special-emoji">🎰</div>
                    <div class="special-title">Lucky Draw Announcements</div>
                    <div class="special-desc">Individual slide graphics for <strong>Mega Lucky Draw</strong> and <strong>Early Bird Lucky Draw</strong></div>
                </div>
                <div class="special-card souvenir">
                    <div class="special-emoji">📖</div>
                    <div class="special-title">Souvenir Book Release</div>
                    <div class="special-desc">Unveiling slide with 3D high-resolution cover image mockup of the official Souvenir Book</div>
                </div>
            </div>
        </div>

        {{-- ═══ SECTION 5: PENDING ASSETS ═══ --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-num s5">5</div>
                <h2 class="section-title">Pending Client Assets Required</h2>
            </div>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">To finalize video rendering ("Fill in the Blanks" template framework), please share:</p>

            <ul class="checklist">
                <li>
                    <span class="check-icon">◻</span>
                    <span>High-resolution <strong>PNG/Vector Logos</strong> for all 12–15 sponsors</span>
                </li>
                <li>
                    <span class="check-icon">◻</span>
                    <span>High-res <strong>photos and names</strong> for the President, Vice President, Chief Guest, and Regional Chairmen (Maharashtra & Madhya Pradesh)</span>
                </li>
                <li>
                    <span class="check-icon">◻</span>
                    <span><strong>Titles and Speaker Photos</strong> for Day 2 Technical Sessions (1 through 7) & Panel Discussion</span>
                </li>
                <li>
                    <span class="check-icon">◻</span>
                    <span>High-resolution <strong>artwork file</strong> for the Souvenir Book Cover</span>
                </li>
            </ul>
        </div>

        {{-- ═══ APPROVAL CTA ═══ --}}
        <div class="approval-cta">
            @if($isAccepted)
                <h3 style="color: #4ade80;">✅ Proposal Approved</h3>
                <p>Thank you for approving this project scope. We will proceed with the final video creation.</p>
            @elseif($isDeclined)
                <h3 style="color: #f87171;">❌ Proposal Declined</h3>
                <p>This proposal has been declined. We will be in touch shortly.</p>
            @else
                <h3>✅ Client Approval Confirmation</h3>
                <p>Please review the sequence and details above. If everything looks good, click Approve to proceed with final video creation.</p>
                <div style="margin-top: 24px; display: flex; justify-content: center; gap: 16px;">
                    {!! Form::open(['route' => ['proposal.public.approve', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)], 'method' => 'POST', 'class' => 'd-inline']) !!}
                    <button type="submit" style="background: #10b981; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 15px;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                        Approve Proposal
                    </button>
                    {!! Form::close() !!}
                    
                    {!! Form::open(['route' => ['proposal.public.decline', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)], 'method' => 'POST', 'class' => 'd-inline']) !!}
                    <input type="hidden" name="reason" value="Declined via custom view">
                    <button type="submit" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 15px;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        Decline
                    </button>
                    {!! Form::close() !!}
                </div>
            @endif
        </div>

        {{-- ═══ FOOTER ═══ --}}
        <div class="doc-footer">
            IPCA Munnar Video Production Scope Document &bull; Generated for Client Review &bull; Animazon Design & Web Studio
        </div>

    </div>
</div>
