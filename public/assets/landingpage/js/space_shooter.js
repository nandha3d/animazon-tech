/**
 * Animazon Infinite Parallax Space Shooter — v3
 *
 * ─ HP bar above ship (continuous, not hearts)
 * ─ Enemy ships that chase the player
 * ─ Powerups: ❤ Heal, ⚡ Rapid Fire, 🔱 Multi-Shot, ⭐ x2 Score, ⏱ Time Extend
 * ─ Progressive difficulty (speed, spawn rate, enemy types)
 * ─ Corner HUD: score, high-score, active buffs with timers
 */

class SpaceShooter {
    constructor(id) {
        this.canvas = document.getElementById(id);
        if (!this.canvas) return;
        this.ctx = this.canvas.getContext('2d');

        // Ship tiers: score threshold, name, color, size scale, base fire rate, maxHp, speed
        this.tiers = [
            { at: 0, name: 'SCOUT', color: '#00e5ff', scale: 1.0, rate: 260, hp: 100, spd: 8 },
            { at: 500, name: 'FIGHTER', color: '#00e5ff', scale: 1.1, rate: 230, hp: 120, spd: 9 },
            { at: 1500, name: 'DESTROYER', color: '#4fc3f7', scale: 1.2, rate: 200, hp: 150, spd: 10 },
            { at: 3500, name: 'CRUISER', color: '#b388ff', scale: 1.35, rate: 170, hp: 180, spd: 11 },
            { at: 6000, name: 'DREADNOUGHT', color: '#ffab00', scale: 1.5, rate: 140, hp: 220, spd: 12 },
        ];

        this.player = {
            x: 0, y: 0, w: 40, h: 50, speed: 8,
            color: '#00e5ff',
            hp: 100, maxHp: 100,
            invTimer: 0,
            thruster: 0,
            lastFired: 0,
            baseRate: 260,
            fireRate: 260,
            multiShot: 0,
            rapidFire: 0,
            scoreMult: 1,
            multTimer: 0,
            tier: 0,
            upgradeFlash: 0,
        };

        this.keys = {};
        this.mouse = { x: 0, y: 0, on: false };

        this.state = 'DEMO';
        this.score = 0;
        this.highScore = +(localStorage.getItem('az_hs') || 0);
        this.elapsed = 0;

        // Stats
        this.stats = { kills: 0, enemyKills: 0, powUps: { heal: 0, rapid: 0, multi: 0, mult: 0, time: 0 }, dmgTaken: 0, shotsFired: 0 };

        this.stars = []; this.asteroids = []; this.bullets = [];
        this.particles = []; this.powerups = []; this.enemies = [];

        this.resizeCanvas();
        addEventListener('resize', () => this.resizeCanvas());
        this._initStars();
        this._bind();

        this._lt = performance.now();
        requestAnimationFrame(t => this._loop(t));
    }

    resizeCanvas() {
        const p = this.canvas.parentElement;
        const r = p ? p.getBoundingClientRect() : { width: innerWidth, height: innerHeight };
        this.canvas.width = r.width || innerWidth;
        this.canvas.height = r.height || innerHeight;
        if (this.player) { this.player.x = this.canvas.width / 2; this.player.y = this.canvas.height - 100; this.mouse.x = this.player.x; }
    }

    _bind() {
        addEventListener('keydown', e => {
            this.keys[e.key] = true;
            if (this.state === 'GAMEOVER' && e.key === ' ') { e.preventDefault(); this.start(); }
            if (e.key === 'Escape') this.stop();
        });
        addEventListener('keyup', e => this.keys[e.key] = false);
        const mv = e => { this.mouse.on = true; const r = this.canvas.getBoundingClientRect(); this.mouse.x = (e.touches ? e.touches[0].clientX : e.clientX) - r.left; };
        // Listen on the whole slide (not just canvas) so overlay doesn't block cursor tracking
        const slide = this.canvas.closest('.swiper-slide') || this.canvas.parentElement;
        slide.addEventListener('mousemove', mv);
        slide.addEventListener('touchmove', mv, { passive: true });
        slide.addEventListener('click', () => { if (this.state === 'GAMEOVER') this.start(); });
    }

    _initStars() {
        this.stars = [];
        for (let i = 0; i < 120; i++) this.stars.push({ x: Math.random() * (this.canvas.width || 1920), y: Math.random() * (this.canvas.height || 1080), sz: Math.random() * 2 + .5, sp: Math.random() * 2 + .3, c: `rgba(255,255,255,${Math.random() * .7 + .2})` });
    }

    // ═══ STATE ════════════════════════════
    start() {
        this.state = 'PLAYING'; this.score = 0; this.elapsed = 0;
        this.asteroids = []; this.bullets = []; this.particles = [];
        this.powerups = []; this.enemies = [];
        this.stats = { kills: 0, enemyKills: 0, powUps: { heal: 0, rapid: 0, multi: 0, mult: 0, time: 0 }, dmgTaken: 0, shotsFired: 0 };
        const p = this.player;
        p.tier = 0; p.upgradeFlash = 0;
        const t0 = this.tiers[0];
        p.maxHp = t0.hp; p.hp = p.maxHp; p.baseRate = t0.rate; p.speed = t0.spd; p.color = t0.color;
        p.w = 40 * t0.scale; p.h = 50 * t0.scale;
        p.x = this.canvas.width / 2; p.y = this.canvas.height - 100;
        p.fireRate = p.baseRate; p.invTimer = 0;
        p.multiShot = 0; p.rapidFire = 0; p.scoreMult = 1; p.multTimer = 0;
        const ov = document.getElementById('gameSlideOverlay');
        if (ov) { ov.style.opacity = '0'; ov.style.pointerEvents = 'none'; }
        if (window.heroSwiper) { window.heroSwiper.autoplay.stop(); window.heroSwiper.allowTouchMove = false; }
    }

    _hit(dmg) {
        if (this.player.invTimer > 0) return;
        this.player.hp -= dmg;
        this.stats.dmgTaken += dmg;
        this._boom(this.player.x, this.player.y, 15, '#ff8800');
        if (this.player.hp <= 0) { this.player.hp = 0; this._die(); }
        else this.player.invTimer = 80;
    }

    _die() {
        this.state = 'GAMEOVER';
        if (this.score > this.highScore) { this.highScore = this.score; localStorage.setItem('az_hs', this.highScore); }
        this._boom(this.player.x, this.player.y, 60, this.player.color);
    }

    stop() {
        this.state = 'DEMO';
        this.asteroids = []; this.bullets = []; this.particles = [];
        this.powerups = []; this.enemies = [];
        const p = this.player; p.fireRate = p.baseRate; p.multiShot = 0; p.rapidFire = 0; p.scoreMult = 1; p.multTimer = 0;
        const ov = document.getElementById('gameSlideOverlay');
        if (ov) { ov.style.opacity = '1'; ov.style.pointerEvents = 'auto'; }
        if (window.heroSwiper) { window.heroSwiper.autoplay.start(); window.heroSwiper.allowTouchMove = true; }
    }

    _boom(x, y, n, c) { for (let i = 0; i < n; i++) this.particles.push({ x, y, vx: (Math.random() - .5) * 10, vy: (Math.random() - .5) * 10, life: 1, dec: Math.random() * .04 + .015, c, sz: Math.random() * 4 + 1 }); }

    // ═══ POWERUPS ═════════════════════════
    _spawnPow(x, y) {
        const ts = ['heal', 'rapid', 'multi', 'mult', 'time'];
        const ws = [.25, .22, .18, .15, .20];
        let r = Math.random(), s = 0, t = ts[0];
        for (let i = 0; i < ts.length; i++) { s += ws[i]; if (r < s) { t = ts[i]; break; } }
        const cols = { heal: '#ff4081', rapid: '#ffab00', multi: '#00e5ff', mult: '#b388ff', time: '#00e676' };
        const icons = { heal: '❤', rapid: '⚡', multi: '🔱', mult: '⭐', time: '⏱' };
        this.powerups.push({ x, y, t, vy: 2.2, r: 14, col: cols[t], ic: icons[t] });
    }

    _applyPow(t) {
        const p = this.player;
        this.stats.powUps[t]++;
        switch (t) {
            case 'heal': p.hp = Math.min(p.hp + 30, p.maxHp); break;
            case 'rapid': p.rapidFire = 420; p.fireRate = 90; break;
            case 'multi': p.multiShot = 420; break;
            case 'mult': p.scoreMult = 2; p.multTimer = 600; break;
            case 'time':
                if (p.rapidFire > 0) p.rapidFire += 240;
                if (p.multiShot > 0) p.multiShot += 240;
                if (p.multTimer > 0) p.multTimer += 240;
                if (p.rapidFire <= 0 && p.multiShot <= 0 && p.multTimer <= 0) p.hp = Math.min(p.hp + 15, p.maxHp);
                break;
        }
    }

    // ═══ UPDATE ═══════════════════════════
    update(dt) {
        const W = this.canvas.width, H = this.canvas.height, f = dt * .06;
        const playing = this.state === 'PLAYING';
        const alive = this.state === 'DEMO' || playing;

        // Stars
        const sm = playing ? 2 : .6;
        this.stars.forEach(s => { s.y += s.sp * sm * f; if (s.y > H) { s.y = 0; s.x = Math.random() * W; } });

        // Particles
        for (let i = this.particles.length - 1; i >= 0; i--) { const p = this.particles[i]; p.x += p.vx * f; p.y += p.vy * f; p.life -= p.dec * f; if (p.life <= 0) this.particles.splice(i, 1); }

        if (!alive) return;

        // ── Ship ──
        const pl = this.player;
        let tx = pl.x;
        if (this.keys['ArrowLeft'] || this.keys['a']) tx -= pl.speed;
        if (this.keys['ArrowRight'] || this.keys['d']) tx += pl.speed;
        if (this.mouse.on) tx += (this.mouse.x - tx) * .1;
        pl.x = Math.max(pl.w / 2, Math.min(W - pl.w / 2, tx));
        pl.thruster = (pl.thruster + 1) % 20;
        if (pl.invTimer > 0) pl.invTimer--;
        if (pl.upgradeFlash > 0) pl.upgradeFlash--;

        // Check tier upgrade
        if (playing) {
            let newTier = 0;
            for (let t = this.tiers.length - 1; t >= 0; t--) { if (this.score >= this.tiers[t].at) { newTier = t; break; } }
            if (newTier > pl.tier) {
                pl.tier = newTier;
                const td = this.tiers[newTier];
                const hpRatio = pl.hp / pl.maxHp;
                pl.maxHp = td.hp; pl.hp = Math.ceil(hpRatio * pl.maxHp); // keep same % health
                pl.baseRate = td.rate; pl.speed = td.spd; pl.color = td.color;
                pl.w = 40 * td.scale; pl.h = 50 * td.scale;
                if (pl.rapidFire <= 0) pl.fireRate = pl.baseRate;
                pl.upgradeFlash = 60;
                this._boom(pl.x, pl.y, 30, td.color);
            }
        }

        // Buff timers
        if (pl.rapidFire > 0) { pl.rapidFire--; if (pl.rapidFire <= 0) pl.fireRate = pl.baseRate; }
        if (pl.multiShot > 0) pl.multiShot--;
        if (pl.multTimer > 0) { pl.multTimer--; if (pl.multTimer <= 0) pl.scoreMult = 1; }

        // Fire
        const now = performance.now();
        if (now - pl.lastFired > pl.fireRate) {
            const bx = pl.x, by = pl.y - pl.h / 2;
            this.bullets.push({ x: bx, y: by, vy: -17, w: 3, h: 14, friendly: true });
            this.stats.shotsFired++;
            if (pl.multiShot > 0) {
                this.bullets.push({ x: bx - 14, y: by + 5, vy: -16, w: 3, h: 12, friendly: true });
                this.bullets.push({ x: bx + 14, y: by + 5, vy: -16, w: 3, h: 12, friendly: true });
                this.stats.shotsFired += 2;
            }
            pl.lastFired = now;
        }

        // Update bullets
        for (let i = this.bullets.length - 1; i >= 0; i--) {
            const b = this.bullets[i];
            b.x += (b.vx || 0) * f; b.y += b.vy * f;
            if (b.y < -20 || b.y > H + 20 || b.x < -20 || b.x > W + 20) this.bullets.splice(i, 1);
        }

        // ── DEMO asteroids ──
        if (this.state === 'DEMO') {
            if (Math.random() < .008) this.asteroids.push(this._mkAst(W, false, 0));
            this._updAst(f, H, false);
            return;
        }

        // ═══ PLAYING ═══
        this.elapsed += dt / 1000;
        const diff = Math.min(this.elapsed / 90, 1); // 0→1 over 90s

        // Spawn asteroids
        if (Math.random() < .018 + diff * .035) this.asteroids.push(this._mkAst(W, true, diff));
        this._updAst(f, H, true);

        // ── Enemy ships ──
        // Spawn: starts at 10s, frequency increases
        if (this.elapsed > 10 && Math.random() < .003 + diff * .008) {
            const ex = Math.random() * (W - 60) + 30;
            this.enemies.push({
                x: ex, y: -40,
                w: 30, h: 36,
                hp: 2 + Math.floor(diff * 3),
                maxHp: 2 + Math.floor(diff * 3),
                speed: 1.5 + diff * 2,
                color: '#ff6d00',
                lastFired: now,
                fireRate: 1200 - diff * 400,
                pts: 50 + Math.floor(diff * 80),
            });
        }

        for (let i = this.enemies.length - 1; i >= 0; i--) {
            const e = this.enemies[i];

            // Chase player horizontally, advance vertically
            const dx = pl.x - e.x;
            e.x += Math.sign(dx) * Math.min(Math.abs(dx), e.speed * .7) * f;
            e.y += e.speed * .5 * f;

            // Enemy fires
            if (now - e.lastFired > e.fireRate) {
                this.bullets.push({ x: e.x, y: e.y + e.h / 2, vy: 8 + diff * 4, vx: 0, w: 3, h: 10, friendly: false, color: '#ff6d00' });
                e.lastFired = now;
            }

            // Friendly bullet vs enemy
            for (let j = this.bullets.length - 1; j >= 0; j--) {
                const b = this.bullets[j];
                if (!b.friendly) continue;
                if (b.x > e.x - e.w / 2 && b.x < e.x + e.w / 2 && b.y > e.y - e.h / 2 && b.y < e.y + e.h / 2) {
                    e.hp--;
                    this.bullets.splice(j, 1);
                    this._boom(b.x, b.y, 4, '#fff');
                    if (e.hp <= 0) {
                        this.score += e.pts * pl.scoreMult;
                        this.stats.enemyKills++;
                        this._boom(e.x, e.y, 20, e.color);
                        if (Math.random() < .30) this._spawnPow(e.x, e.y);
                        this.enemies.splice(i, 1);
                    }
                    break;
                }
            }
            if (!this.enemies[i]) continue;

            // Enemy bullet vs player
            // (handled below in bullet loop)

            // Enemy body vs player
            if (Math.abs(e.x - pl.x) < (e.w + pl.w) / 2 && Math.abs(e.y - pl.y) < (e.h + pl.h) / 2) {
                this._boom(e.x, e.y, 15, e.color);
                this.enemies.splice(i, 1);
                this._hit(25);
                continue;
            }

            // Off-screen
            if (e.y > H + 60) this.enemies.splice(i, 1);
        }

        // Enemy bullets vs player
        for (let i = this.bullets.length - 1; i >= 0; i--) {
            const b = this.bullets[i];
            if (b.friendly) continue;
            if (Math.abs(b.x - pl.x) < pl.w / 2 + 4 && Math.abs(b.y - pl.y) < pl.h / 2 + 4) {
                this.bullets.splice(i, 1);
                this._hit(15);
            }
        }

        // Powerups
        for (let i = this.powerups.length - 1; i >= 0; i--) {
            const pw = this.powerups[i];
            pw.y += pw.vy * f;
            if (Math.hypot(pw.x - pl.x, pw.y - pl.y) < pw.r + 20) {
                this._applyPow(pw.t);
                this._boom(pw.x, pw.y, 8, pw.col);
                this.powerups.splice(i, 1);
                continue;
            }
            if (pw.y > H + 30) this.powerups.splice(i, 1);
        }
    }

    _mkAst(W, real, diff) {
        const r = real ? Math.random() * 22 + 14 : Math.random() * 15 + 10;
        return { x: Math.random() * W, y: -50, r, vx: (Math.random() - .5) * 2, vy: real ? 2 + Math.random() * 2 + diff * 3.5 : 1 + Math.random() * 1.5, col: real ? '#ff2a5f' : 'rgba(255,42,95,.4)', rot: 0, rs: (Math.random() - .5) * .1, hp: real && r > 28 ? 2 : 1, dmg: real ? Math.ceil(r / 3) : 0 };
    }

    _updAst(f, H, real) {
        const pl = this.player;
        for (let i = this.asteroids.length - 1; i >= 0; i--) {
            const a = this.asteroids[i];
            a.x += a.vx * f; a.y += a.vy * f; a.rot += a.rs;
            if (real && Math.hypot(a.x - pl.x, a.y - pl.y) < a.r + pl.w / 2 - 8) {
                this._boom(a.x, a.y, 12, a.col);
                this.asteroids.splice(i, 1);
                this._hit(a.dmg);
                continue;
            }
            for (let j = this.bullets.length - 1; j >= 0; j--) {
                const b = this.bullets[j];
                if (!b.friendly) continue;
                if (b.x > a.x - a.r && b.x < a.x + a.r && b.y > a.y - a.r && b.y < a.y + a.r) {
                    a.hp--; this.bullets.splice(j, 1); this._boom(b.x, b.y, 4, '#fff');
                    if (a.hp <= 0) {
                        if (this.state === 'PLAYING') {
                            this.score += Math.floor(a.r) * pl.scoreMult;
                            this.stats.kills++;
                            if (Math.random() < .18) this._spawnPow(a.x, a.y);
                        }
                        this._boom(a.x, a.y, 14, a.col);
                        this.asteroids.splice(i, 1);
                    }
                    break;
                }
            }
            if (this.asteroids[i] && this.asteroids[i].y > H + 60) this.asteroids.splice(i, 1);
        }
    }

    // ═══ DRAW ═════════════════════════════
    draw() {
        const W = this.canvas.width, H = this.canvas.height, c = this.ctx;
        c.fillStyle = 'rgba(10,10,18,.45)'; c.fillRect(0, 0, W, H);

        // Stars
        this.stars.forEach(s => { c.fillStyle = s.c; c.beginPath(); c.arc(s.x, s.y, s.sz, 0, 6.28); c.fill(); });

        // Particles
        this.particles.forEach(p => { c.globalAlpha = p.life; c.fillStyle = p.c; c.beginPath(); c.arc(p.x, p.y, p.sz, 0, 6.28); c.fill(); });
        c.globalAlpha = 1;

        const alive = this.state === 'DEMO' || this.state === 'PLAYING';

        // Ship
        if (alive) {
            if (this.player.invTimer > 0 && Math.floor(this.player.invTimer / 4) % 2 === 0) { /* blink */ } else this._drawShip(c);
        }

        // Bullets
        if (alive) {
            this.bullets.forEach(b => {
                c.shadowBlur = 6; c.shadowColor = b.friendly ? '#00e5ff' : '#ff6d00';
                c.fillStyle = b.friendly ? '#fff' : '#ff6d00';
                c.fillRect(b.x - b.w / 2, b.y, b.w, b.h);
            });
            c.shadowBlur = 0;
        }

        // Asteroids
        this.asteroids.forEach(a => {
            c.save(); c.translate(a.x, a.y); c.rotate(a.rot);
            c.strokeStyle = a.col; c.lineWidth = 2.5; c.shadowBlur = 12; c.shadowColor = a.col;
            c.beginPath();
            for (let i = 0; i < 6; i++) { const ang = i / 6 * 6.28, rd = a.r * (.8 + .4 * (i % 2)); i === 0 ? c.moveTo(Math.cos(ang) * rd, Math.sin(ang) * rd) : c.lineTo(Math.cos(ang) * rd, Math.sin(ang) * rd); }
            c.closePath(); c.stroke(); c.restore();
        });
        c.shadowBlur = 0;

        // Enemy ships
        this.enemies.forEach(e => {
            c.save(); c.translate(e.x, e.y);
            // Body — inverted triangle
            c.fillStyle = e.color;
            c.beginPath(); c.moveTo(0, e.h / 2); c.lineTo(e.w / 2, -e.h / 2); c.lineTo(-e.w / 2, -e.h / 2); c.closePath(); c.fill();
            // HP bar
            const bw = 30, bh = 3, bx = -bw / 2, by = -e.h / 2 - 8;
            c.fillStyle = 'rgba(255,255,255,.2)'; c.fillRect(bx, by, bw, bh);
            c.fillStyle = '#ff4444'; c.fillRect(bx, by, bw * (e.hp / e.maxHp), bh);
            c.restore();
        });

        // Powerups
        this.powerups.forEach(pw => {
            c.save(); c.translate(pw.x, pw.y);
            c.beginPath(); c.arc(0, 0, pw.r, 0, 6.28);
            c.fillStyle = pw.col + '33'; c.fill();
            c.strokeStyle = pw.col; c.lineWidth = 2; c.stroke();
            c.font = '15px sans-serif'; c.textAlign = 'center'; c.textBaseline = 'middle';
            c.fillStyle = '#fff'; c.fillText(pw.ic, 0, 1);
            c.restore();
        });

        // HUD
        if (this.state === 'PLAYING') this._drawHUD(c, W, H);

        // HP bar above ship (PLAYING)
        if (this.state === 'PLAYING') {
            const p = this.player, bw = 50, bh = 5;
            const bx = p.x - bw / 2, by = p.y - p.h / 2 - 14;
            c.fillStyle = 'rgba(255,255,255,.15)'; c.fillRect(bx, by, bw, bh);
            const ratio = p.hp / p.maxHp;
            c.fillStyle = ratio > .5 ? '#00e676' : ratio > .25 ? '#ffab00' : '#ff1744';
            c.fillRect(bx, by, bw * ratio, bh);
            c.strokeStyle = 'rgba(255,255,255,.3)'; c.lineWidth = 1; c.strokeRect(bx, by, bw, bh);
        }

        // GAMEOVER
        if (this.state === 'GAMEOVER') this._drawGO(c, W, H);
    }

    _drawShip(c) {
        const p = this.player, tier = p.tier;

        // Upgrade flash ring
        if (p.upgradeFlash > 0) {
            c.save(); c.beginPath(); c.arc(p.x, p.y, 35 + (60 - p.upgradeFlash), 0, 6.28);
            c.strokeStyle = p.color; c.lineWidth = 2; c.globalAlpha = p.upgradeFlash / 60;
            c.stroke(); c.globalAlpha = 1; c.restore();
        }

        // Buff aura
        if (p.multiShot > 0 || p.rapidFire > 0) {
            c.save(); c.beginPath(); c.arc(p.x, p.y, 30 * (p.w / 40), 0, 6.28);
            c.fillStyle = p.multiShot > 0 ? 'rgba(0,229,255,.08)' : 'rgba(255,171,0,.08)';
            c.fill(); c.restore();
        }

        c.save(); c.translate(p.x, p.y);

        // Main hull
        c.fillStyle = p.color;
        c.beginPath(); c.moveTo(0, -p.h / 2); c.lineTo(p.w / 2, p.h / 2); c.lineTo(0, p.h / 3); c.lineTo(-p.w / 2, p.h / 2); c.closePath(); c.fill();

        // Tier 1+: side fins
        if (tier >= 1) {
            c.fillStyle = p.color + 'aa';
            c.beginPath(); c.moveTo(-p.w / 2 - 4, p.h / 3); c.lineTo(-p.w / 2, p.h / 2 + 4); c.lineTo(-p.w / 2 + 6, p.h / 4); c.closePath(); c.fill();
            c.beginPath(); c.moveTo(p.w / 2 + 4, p.h / 3); c.lineTo(p.w / 2, p.h / 2 + 4); c.lineTo(p.w / 2 - 6, p.h / 4); c.closePath(); c.fill();
        }

        // Tier 2+: swept wings
        if (tier >= 2) {
            c.fillStyle = p.color + '66';
            c.beginPath(); c.moveTo(-p.w / 2, p.h / 2); c.lineTo(-p.w / 2 - 12, p.h / 2 + 8); c.lineTo(-p.w / 2 + 4, p.h / 6); c.closePath(); c.fill();
            c.beginPath(); c.moveTo(p.w / 2, p.h / 2); c.lineTo(p.w / 2 + 12, p.h / 2 + 8); c.lineTo(p.w / 2 - 4, p.h / 6); c.closePath(); c.fill();
        }

        // Tier 3+: cockpit glow
        if (tier >= 3) {
            c.fillStyle = 'rgba(255,255,255,.3)';
            c.beginPath(); c.arc(0, -p.h / 6, 4, 0, 6.28); c.fill();
        }

        // Tier 4 (max): side cannons
        if (tier >= 4) {
            c.fillStyle = '#fff';
            c.fillRect(-p.w / 2 - 6, -2, 4, 12);
            c.fillRect(p.w / 2 + 2, -2, 4, 12);
            c.fillStyle = p.color + '88';
            c.beginPath(); c.arc(-p.w / 2 - 4, -4, 3, 0, 6.28); c.fill();
            c.beginPath(); c.arc(p.w / 2 + 4, -4, 3, 0, 6.28); c.fill();
        }

        // Thruster(s)
        c.fillStyle = '#ff8800';
        c.beginPath(); c.moveTo(-5, p.h / 3 + 2); c.lineTo(5, p.h / 3 + 2); c.lineTo(0, p.h / 3 + 10 + Math.random() * 15); c.closePath(); c.fill();
        // Extra thrusters tier 2+
        if (tier >= 2) {
            c.beginPath(); c.moveTo(-p.w / 4 - 3, p.h / 3 + 2); c.lineTo(-p.w / 4 + 3, p.h / 3 + 2); c.lineTo(-p.w / 4, p.h / 3 + 6 + Math.random() * 10); c.closePath(); c.fill();
            c.beginPath(); c.moveTo(p.w / 4 - 3, p.h / 3 + 2); c.lineTo(p.w / 4 + 3, p.h / 3 + 2); c.lineTo(p.w / 4, p.h / 3 + 6 + Math.random() * 10); c.closePath(); c.fill();
        }

        if (p.multiShot > 0) {
            c.fillStyle = 'rgba(0,229,255,.6)';
            c.beginPath(); c.arc(-p.w / 2 + 2, 8, 3, 0, 6.28); c.fill();
            c.beginPath(); c.arc(p.w / 2 - 2, 8, 3, 0, 6.28); c.fill();
        }
        c.restore();
    }

    _drawHUD(c, W, H) {
        const p = this.player, st = this.stats;
        c.save();

        // ── TOP-LEFT PANEL: Score + HP ──
        const panelW = 200, panelH = 90;
        c.fillStyle = 'rgba(0,0,0,.45)';
        this._roundRect(c, 10, 10, panelW, panelH, 10); c.fill();
        c.strokeStyle = 'rgba(255,255,255,.1)'; c.lineWidth = 1;
        this._roundRect(c, 10, 10, panelW, panelH, 10); c.stroke();

        // Score
        c.textAlign = 'left';
        // Tier badge
        const td = this.tiers[p.tier];
        c.font = 'bold 10px "Inter",sans-serif'; c.fillStyle = td.color;
        c.fillText('▸ ' + td.name, 22, 26);
        // Score
        c.font = 'bold 22px "Inter",sans-serif'; c.fillStyle = '#fff';
        c.fillText(this.score.toLocaleString(), 22, 49);
        c.font = '10px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.3)';
        c.fillText('HI: ' + this.highScore.toLocaleString(), 22, 63);

        // HP bar inside panel
        const hpX = 22, hpY = 71, hpW = panelW - 24, hpH = 8;
        c.fillStyle = 'rgba(255,255,255,.12)'; this._roundRect(c, hpX, hpY, hpW, hpH, 4); c.fill();
        const ratio = Math.max(0, p.hp / p.maxHp);
        const hpCol = ratio > .5 ? '#00e676' : ratio > .25 ? '#ffab00' : '#ff1744';
        c.fillStyle = hpCol; this._roundRect(c, hpX, hpY, hpW * ratio, hpH, 4); c.fill();
        c.font = 'bold 8px "Inter",sans-serif'; c.fillStyle = '#fff'; c.textAlign = 'center';
        c.fillText(Math.ceil(p.hp) + ' / ' + p.maxHp, hpX + hpW / 2, hpY + 7);

        // Tier XP bar (progress towards next tier)
        if (p.tier < this.tiers.length - 1) {
            const next = this.tiers[p.tier + 1].at, prev = this.tiers[p.tier].at;
            const prog = (this.score - prev) / (next - prev);
            const xpY = hpY + 13, xpH = 4;
            c.fillStyle = 'rgba(255,255,255,.08)'; this._roundRect(c, hpX, xpY, hpW, xpH, 2); c.fill();
            c.fillStyle = td.color + '88'; this._roundRect(c, hpX, xpY, hpW * Math.min(prog, 1), xpH, 2); c.fill();
            c.font = '7px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.3)'; c.textAlign = 'right';
            c.fillText('NEXT: ' + this.tiers[p.tier + 1].name, hpX + hpW, xpY + 11);
        } else {
            c.font = '7px "Inter",sans-serif'; c.fillStyle = '#ffab00'; c.textAlign = 'right';
            c.fillText('MAX TIER', hpX + hpW, hpY + 20);
        }
        c.textAlign = 'left';

        // ── TOP-RIGHT PANEL: Time + Active Buffs ──
        const rPanelW = 170, rPanelH = 90;
        const rx = W - rPanelW - 10;
        c.fillStyle = 'rgba(0,0,0,.45)';
        this._roundRect(c, rx, 10, rPanelW, rPanelH, 10); c.fill();
        c.strokeStyle = 'rgba(255,255,255,.1)'; c.lineWidth = 1;
        this._roundRect(c, rx, 10, rPanelW, rPanelH, 10); c.stroke();

        // Time
        c.textAlign = 'right';
        c.font = 'bold 11px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.5)';
        c.fillText('TIME', W - 22, 30);
        const mins = Math.floor(this.elapsed / 60);
        const secs = Math.floor(this.elapsed % 60).toString().padStart(2, '0');
        c.font = 'bold 20px "Inter",sans-serif'; c.fillStyle = '#fff';
        c.fillText(`${mins}:${secs}`, W - 22, 50);

        // Difficulty progress bar
        const diff = Math.min(this.elapsed / 90, 1);
        const dpX = rx + 12, dpY = 58, dpW = rPanelW - 24, dpH = 5;
        c.fillStyle = 'rgba(255,255,255,.1)'; this._roundRect(c, dpX, dpY, dpW, dpH, 3); c.fill();
        const dCol = diff < .5 ? '#00e5ff' : diff < .8 ? '#ffab00' : '#ff1744';
        c.fillStyle = dCol; this._roundRect(c, dpX, dpY, dpW * diff, dpH, 3); c.fill();
        c.font = '8px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.35)'; c.textAlign = 'center';
        c.fillText('DIFFICULTY', dpX + dpW / 2, dpY + 14);

        // Active buffs
        const buffs = [];
        if (p.rapidFire > 0) buffs.push({ ic: '⚡', t: Math.ceil(p.rapidFire / 60), max: 7, cur: p.rapidFire / 420, col: '#ffab00' });
        if (p.multiShot > 0) buffs.push({ ic: '🔱', t: Math.ceil(p.multiShot / 60), max: 7, cur: p.multiShot / 420, col: '#00e5ff' });
        if (p.multTimer > 0) buffs.push({ ic: '⭐', t: Math.ceil(p.multTimer / 60), max: 10, cur: p.multTimer / 600, col: '#b388ff' });
        if (buffs.length > 0) {
            c.textAlign = 'left';
            let bx = rx + 12, by = 82;
            buffs.forEach(b => {
                c.font = '13px sans-serif'; c.fillStyle = '#fff'; c.fillText(b.ic, bx, by);
                // Timer bar
                const tbx = bx + 20, tbw = 30, tbh = 5;
                c.fillStyle = 'rgba(255,255,255,.12)'; c.fillRect(tbx, by - 6, tbw, tbh);
                c.fillStyle = b.col; c.fillRect(tbx, by - 6, tbw * Math.min(b.cur, 1), tbh);
                c.font = '9px "Inter",sans-serif'; c.fillStyle = b.col; c.fillText(b.t + 's', tbx + tbw + 4, by);
                bx += 72;
            });
        }

        // ── BOTTOM-LEFT: Kills & Pickups ──
        const bPanelW = 220, bPanelH = 32;
        c.fillStyle = 'rgba(0,0,0,.35)';
        this._roundRect(c, 10, H - bPanelH - 10, bPanelW, bPanelH, 8); c.fill();
        c.textAlign = 'left'; c.font = '11px "Inter",sans-serif';
        const totalPow = st.powUps.heal + st.powUps.rapid + st.powUps.multi + st.powUps.mult + st.powUps.time;
        c.fillStyle = 'rgba(255,255,255,.5)';
        c.fillText(`💀 ${st.kills + st.enemyKills}  ·  🎁 ${totalPow}  ·  🔫 ${st.shotsFired}`, 22, H - bPanelH + 10);

        c.restore();
    }

    _roundRect(c, x, y, w, h, r) {
        if (w < 0) w = 0;
        c.beginPath();
        c.moveTo(x + r, y);
        c.arcTo(x + w, y, x + w, y + h, r);
        c.arcTo(x + w, y + h, x, y + h, r);
        c.arcTo(x, y + h, x, y, r);
        c.arcTo(x, y, x + w, y, r);
        c.closePath();
    }

    _drawGO(c, W, H) {
        c.fillStyle = 'rgba(0,0,0,.75)'; c.fillRect(0, 0, W, H);

        // Central panel
        const pw = 400, ph = 320, px = (W - pw) / 2, py = (H - ph) / 2;
        c.fillStyle = 'rgba(15,15,25,.9)';
        this._roundRect(c, px, py, pw, ph, 16); c.fill();
        c.strokeStyle = 'rgba(255,255,255,.1)'; c.lineWidth = 1;
        this._roundRect(c, px, py, pw, ph, 16); c.stroke();

        c.textAlign = 'center';
        const cx = W / 2;

        // Title
        c.fillStyle = '#ff2a5f'; c.font = 'bold 36px "Inter",sans-serif';
        c.fillText('MISSION FAILED', cx, py + 50);

        // Score
        c.fillStyle = '#fff'; c.font = 'bold 28px "Inter",sans-serif';
        c.fillText(this.score.toLocaleString(), cx, py + 90);
        c.fillStyle = this.score >= this.highScore ? '#ffab00' : 'rgba(255,255,255,.45)';
        c.font = '13px "Inter",sans-serif';
        c.fillText(this.score >= this.highScore ? '🏆 NEW HIGH SCORE!' : 'HIGH SCORE: ' + this.highScore.toLocaleString(), cx, py + 112);

        // Divider
        c.strokeStyle = 'rgba(255,255,255,.1)'; c.lineWidth = 1;
        c.beginPath(); c.moveTo(px + 30, py + 125); c.lineTo(px + pw - 30, py + 125); c.stroke();

        // Stats grid
        const st = this.stats;
        const stats = [
            { label: 'SURVIVED', value: Math.floor(this.elapsed) + 's', col: '#00e5ff' },
            { label: 'ASTEROIDS', value: st.kills.toString(), col: '#ff2a5f' },
            { label: 'ENEMIES', value: st.enemyKills.toString(), col: '#ff6d00' },
            { label: 'POWERUPS', value: (st.powUps.heal + st.powUps.rapid + st.powUps.multi + st.powUps.mult + st.powUps.time).toString(), col: '#00e676' },
        ];
        const colW = pw / stats.length;
        stats.forEach((s, i) => {
            const sx = px + colW * i + colW / 2;
            c.font = 'bold 22px "Inter",sans-serif'; c.fillStyle = s.col;
            c.fillText(s.value, sx, py + 160);
            c.font = '9px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.4)';
            c.fillText(s.label, sx, py + 176);
        });

        // Powerup breakdown
        const pows = [
            { ic: '❤', n: st.powUps.heal, col: '#ff4081' },
            { ic: '⚡', n: st.powUps.rapid, col: '#ffab00' },
            { ic: '🔱', n: st.powUps.multi, col: '#00e5ff' },
            { ic: '⭐', n: st.powUps.mult, col: '#b388ff' },
            { ic: '⏱', n: st.powUps.time, col: '#00e676' },
        ];
        const pStartX = cx - (pows.length * 40) / 2 + 20;
        pows.forEach((p, i) => {
            const ppx = pStartX + i * 40;
            c.font = '16px sans-serif'; c.fillStyle = '#fff';
            c.fillText(p.ic, ppx, py + 210);
            c.font = 'bold 12px "Inter",sans-serif'; c.fillStyle = p.col;
            c.fillText('x' + p.n, ppx, py + 228);
        });

        // Ship tier reached
        c.font = '11px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.35)';
        c.fillText(`${st.shotsFired} shots fired  ·  ${st.dmgTaken} dmg taken  ·  Tier: ${this.tiers[this.player.tier].name}`, cx, py + 258);

        // Prompt
        c.font = '14px "Inter",sans-serif'; c.fillStyle = 'rgba(255,255,255,.5)';
        c.fillText('Click or SPACE to retry  ·  ESC to exit', cx, py + 295);
        c.restore ? c.restore() : null;
    }

    _loop(ts) {
        let dt = ts - this._lt; this._lt = ts;
        if (dt > 100) dt = 16;
        this.update(dt); this.draw();
        requestAnimationFrame(t => this._loop(t));
    }
}

document.addEventListener('DOMContentLoaded', () => { window.spaceShooterGame = new SpaceShooter('heroGameCanvas'); });
function launchSpaceShooter() { if (window.spaceShooterGame) window.spaceShooterGame.start(); }
