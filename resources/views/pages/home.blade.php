<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $s['full_name']??'Darshan Patel' }} — {{ $s['site_tagline']??'Full-Stack Developer' }}</title>
<meta name="description" content="{{ Str::limit(strip_tags($s['hero_tagline']??''),160) }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;scroll-padding-top:76px;}
:root{
  --ac:{{ $s['accent_color']??'#00d4ff' }};
  /* ── Professional dark surfaces derived from bg ── */
  @php
    $rawBg = $s['bg_color'] ?? '#060a12';
    $rr = hexdec(substr(ltrim($rawBg,'#'),0,2));
    $rg = hexdec(substr(ltrim($rawBg,'#'),2,2));
    $rb = hexdec(substr(ltrim($rawBg,'#'),4,2));
    // Clamp additions so very light bg still looks dark
    $add2  = min(8,  255-max($rr,$rg,$rb));
    $add3  = min(14, 255-max($rr,$rg,$rb));
    $adds  = min(20, 255-max($rr,$rg,$rb));
    $adds2 = min(26, 255-max($rr,$rg,$rb));
    $bg2h  = sprintf('#%02x%02x%02x', min(255,$rr+$add2),  min(255,$rg+$add2),  min(255,$rb+$add2));
    $bg3h  = sprintf('#%02x%02x%02x', min(255,$rr+$add3),  min(255,$rg+$add3),  min(255,$rb+$add3));
    $surfh = sprintf('#%02x%02x%02x', min(255,$rr+$adds),  min(255,$rg+$adds),  min(255,$rb+$adds));
    $surf2h= sprintf('#%02x%02x%02x', min(255,$rr+$adds2), min(255,$rg+$adds2), min(255,$rb+$adds2));
  @endphp
  --bg:{{ $rawBg }};
  --bg2:{{ $bg2h }};
  --bg3:{{ $bg3h }};
  --surf:{{ $surfh }};
  --surf2:{{ $surf2h }};
  --txt:#e2eaf8;--txt2:#8fa8c0;--txt3:#3d5068;
  --bd:rgba(0,212,255,.12);--bd2:rgba(255,255,255,.07);--bd3:rgba(255,255,255,.04);
  --e3:#00ffcc;--rose:#ff4d6d;--amber:#ffb700;--purple:#a855f7;--green:#22c55e;
}
body{
  font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--txt);overflow-x:hidden;-webkit-font-smoothing:antialiased;
}
a{text-decoration:none;color:inherit;}::selection{background:rgba(0,212,255,.22);}
img{max-width:100%;display:block;}
::-webkit-scrollbar{width:4px;}::-webkit-scrollbar-track{background:var(--bg);}::-webkit-scrollbar-thumb{background:var(--ac);border-radius:2px;}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:100;height:72px;display:flex;align-items:center;justify-content:space-between;padding:0 56px;transition:all .35s;}
nav.scrolled{background:rgba(0,0,0,.75);backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);border-bottom:1px solid rgba(255,255,255,.05);}
.nav-logo{font-family:'Syne',sans-serif;font-size:1.12rem;font-weight:800;}
.nav-logo span{color:var(--ac);}
.nav-links{display:flex;align-items:center;gap:30px;}
.nav-links a{font-size:.76rem;letter-spacing:.12em;text-transform:uppercase;color:var(--txt2);font-weight:500;transition:color .22s;}
.nav-links a:hover{color:var(--ac);}
.nav-hire{background:var(--ac)!important;color:var(--bg)!important;padding:8px 20px;border-radius:6px;font-weight:700!important;}
.nav-hire:hover{filter:brightness(1.12);box-shadow:0 0 18px color-mix(in srgb,var(--ac) 35%,transparent);}
.hamburger{display:none;flex-direction:column;gap:4px;background:none;border:none;cursor:pointer;padding:4px;}
.hamburger span{display:block;width:22px;height:1.5px;background:var(--txt);border-radius:2px;transition:.28s;}
.mob-nav{display:none;position:fixed;inset:0;background:rgba(5,10,18,.97);z-index:99;flex-direction:column;align-items:center;justify-content:center;gap:4px;}
.mob-nav.open{display:flex;}
.mob-nav a{font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:var(--txt2);padding:12px;transition:color .2s;}
.mob-nav a:hover{color:var(--ac);}
.mob-close{position:absolute;top:24px;right:24px;background:none;border:none;font-size:1.8rem;color:var(--txt3);cursor:pointer;}

/* HERO */
.hero{min-height:100vh;display:flex;align-items:center;padding:0 56px;position:relative;overflow:hidden;}
.hero-grid{position:absolute;inset:0;background-image:linear-gradient(color-mix(in srgb,var(--ac) 4%,transparent) 1px,transparent 1px),linear-gradient(90deg,color-mix(in srgb,var(--ac) 4%,transparent) 1px,transparent 1px);background-size:58px 58px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 40%,transparent 100%);}
.hero-glow{position:absolute;width:650px;height:650px;top:-180px;right:-80px;background:radial-gradient(circle,color-mix(in srgb,var(--ac) 8%,transparent),transparent 65%);pointer-events:none;}
.hero-glow2{position:absolute;width:350px;height:350px;bottom:-80px;left:-50px;background:radial-gradient(circle,rgba(168,85,247,.06),transparent 65%);pointer-events:none;}
.hero-inner{max-width:1200px;margin:0 auto;width:100%;padding-top:72px;position:relative;z-index:1;}
.hero-tag{display:inline-flex;align-items:center;gap:9px;font-family:'JetBrains Mono',monospace;font-size:.7rem;color:var(--ac);background:color-mix(in srgb,var(--ac) 8%,transparent);border:1px solid color-mix(in srgb,var(--ac) 20%,transparent);padding:6px 15px;border-radius:4px;margin-bottom:26px;animation:fadeUp .6s ease both;}
.hero-dot{width:7px;height:7px;background:var(--e3);border-radius:50%;animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.5);}}
.hero-name{font-family:'Syne',sans-serif;font-size:clamp(3.2rem,8vw,6.8rem);font-weight:800;letter-spacing:-.04em;line-height:.94;margin-bottom:18px;animation:fadeUp .6s .08s ease both;}
.hero-name .ghost{color:transparent;-webkit-text-stroke:1.5px color-mix(in srgb,var(--ac) 30%,transparent);}
.hero-tagline{font-size:clamp(.94rem,1.8vw,1.2rem);color:var(--txt2);line-height:1.75;max-width:540px;margin-bottom:38px;animation:fadeUp .6s .16s ease both;font-weight:300;}
.hero-actions{display:flex;gap:12px;flex-wrap:wrap;animation:fadeUp .6s .24s ease both;}
.btn-p{display:inline-flex;align-items:center;gap:8px;background:var(--ac);color:var(--bg);padding:13px 28px;border:none;border-radius:6px;font-family:'Syne',sans-serif;font-size:.84rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;cursor:pointer;transition:all .28s;}
.btn-p:hover{filter:brightness(1.1);box-shadow:0 0 28px color-mix(in srgb,var(--ac) 30%,transparent);transform:translateY(-2px);}
.btn-ghost{display:inline-flex;align-items:center;gap:8px;background:transparent;color:var(--txt);padding:12px 26px;border:1px solid rgba(255,255,255,.12);border-radius:6px;font-family:'Syne',sans-serif;font-size:.84rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;cursor:pointer;transition:all .28s;}
.btn-ghost:hover{border-color:var(--ac);color:var(--ac);transform:translateY(-2px);}
.hero-stats{ padding-bottom:50px; display:flex;gap:0;margin-top:56px;animation:fadeUp .6s .32s ease both;border-top:1px solid var(--bd2);padding-top:32px;}
.hs-item{flex:1;padding-right:24px;border-right:1px solid var(--bd2);}
.hs-item:not(:first-child){padding-left:24px;}
.hs-item:last-child{border-right:none;}
.hs-num{font-family:'Syne',sans-serif;font-size:2.6rem;font-weight:800;color:var(--ac);line-height:1;letter-spacing:-.03em;}
.hs-lbl{font-size:.73rem;color:var(--txt3);letter-spacing:.1em;text-transform:uppercase;margin-top:4px;}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:none;}}

/* SECTIONS */
section{padding:96px 56px;}
.container{max-width:1200px;margin:0 auto;}
.sec-label{font-family:'JetBrains Mono',monospace;font-size:.65rem;letter-spacing:.3em;text-transform:uppercase;color:var(--ac);margin-bottom:12px;display:flex;align-items:center;gap:10px;}
.sec-label::after{content:'';flex:0 0 36px;height:1px;background:var(--ac);opacity:.4;}
.sec-title{font-family:'Syne',sans-serif;font-size:clamp(2.2rem,4vw,3.2rem);font-weight:800;letter-spacing:-.03em;line-height:1.06;margin-bottom:14px;}
.sec-title em{font-style:italic;color:var(--ac);}

/* ABOUT */
#about{background:var(--bg2);}
.about-grid{display:grid;grid-template-columns:320px 1fr;gap:64px;align-items:center;}
.about-card{background:var(--surf);border:1px solid rgba(0,212,255,.15);border-radius:14px;padding:28px;position:relative;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.4);}
.about-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--ac),var(--e3));}
.about-card::after{content:'';position:absolute;bottom:0;right:0;width:140px;height:140px;background:radial-gradient(circle,rgba(0,212,255,.06),transparent 70%);pointer-events:none;}
/* profile photo / initials */
.av-wrap{margin-bottom:16px;}
.av-photo{width:84px;height:84px;border-radius:14px;object-fit:cover;border:2px solid rgba(0,212,255,.4);box-shadow:0 0 24px rgba(0,212,255,.18);}
.av-initials{width:84px;height:84px;border-radius:14px;background:linear-gradient(135deg,var(--ac),var(--purple));display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:1.8rem;font-weight:800;color:#050a0f;box-shadow:0 0 28px rgba(0,212,255,.25);}
.about-name{font-family:'Syne',sans-serif;font-size:1.45rem;font-weight:800;margin-bottom:3px;color:var(--txt);}
.about-role{font-family:'JetBrains Mono',monospace;font-size:.72rem;color:var(--ac);letter-spacing:.05em;margin-bottom:16px;}
.about-info{font-size:.8rem;color:var(--txt2);margin-bottom:6px;display:flex;align-items:center;gap:7px;}
.avail{display:inline-flex;align-items:center;gap:7px;font-family:'JetBrains Mono',monospace;font-size:.64rem;letter-spacing:.1em;text-transform:uppercase;background:rgba(0,255,204,.08);color:var(--e3);border:1px solid rgba(0,255,204,.22);padding:6px 12px;border-radius:5px;margin-top:12px;}
.avail-dot{width:6px;height:6px;background:var(--e3);border-radius:50%;animation:pulse 2s infinite;}
.upwork-pill{display:flex;align-items:center;gap:10px;background:rgba(111,218,68,.08);border:1px solid rgba(111,218,68,.22);border-radius:9px;padding:12px 14px;margin-top:12px;}
.upwork-pill a{font-size:.77rem;color:#6fda44;text-decoration:underline;}
/* social links */
.social-row{display:flex;gap:5px;margin-top:14px;flex-wrap:wrap;}
.soc-btn{display:inline-flex;align-items:center;gap:4px;font-family:'JetBrains Mono',monospace;font-size:.6rem;color:var(--txt3);border:1px solid rgba(255,255,255,.08);padding:4px 9px;border-radius:4px;transition:all .2s;white-space:nowrap;background:rgba(255,255,255,.025);}
.soc-btn:hover{border-color:var(--ac);color:var(--ac);background:rgba(0,212,255,.06);}
.skill-chips{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;margin-top:24px;}
.chip{font-family:'JetBrains Mono',monospace;font-size:.64rem;background:var(--bg3);border:1px solid rgba(255,255,255,.07);border-radius:5px;padding:7px 8px;color:var(--txt3);text-align:center;transition:all .22s;cursor:default;}
.chip:hover{border-color:rgba(0,212,255,.3);color:var(--ac);background:rgba(0,212,255,.06);}

/* EXPERIENCE */
#experience{background:var(--bg);}
.exp-wrap{display:grid;grid-template-columns:180px 1fr;gap:48px;}
.exp-nav{position:sticky;top:92px;}
.exp-nav-item{display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,.04);cursor:pointer;font-size:.8rem;color:var(--txt3);transition:all .22s;}
.exp-nav-item:hover,.exp-nav-item.on{color:var(--ac);}
.exp-nav-dot{width:7px;height:7px;border-radius:50%;background:var(--txt3);flex-shrink:0;transition:all .22s;}
.exp-nav-item:hover .exp-nav-dot,.exp-nav-item.on .exp-nav-dot{background:var(--ac);box-shadow:0 0 8px rgba(0,212,255,.5);}
.exp-card{background:var(--surf);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:28px;margin-bottom:14px;position:relative;overflow:hidden;transition:border-color .25s,box-shadow .25s;}
.exp-card::before{content:'';position:absolute;left:0;top:0;bottom:0;width:2px;background:linear-gradient(180deg,var(--ac),transparent);opacity:0;transition:opacity .25s;}
.exp-card:hover::before{opacity:1;}
.exp-card:hover{border-color:rgba(0,212,255,.2);box-shadow:0 8px 32px rgba(0,0,0,.3);}
.exp-period{font-family:'JetBrains Mono',monospace;font-size:.65rem;color:var(--ac);letter-spacing:.07em;margin-bottom:8px;}
.exp-role{font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:700;margin-bottom:3px;color:var(--txt);}
.exp-co{font-size:.82rem;color:var(--txt2);margin-bottom:14px;display:flex;align-items:center;gap:7px;}
.exp-loc{font-size:.7rem;color:var(--txt3);font-family:'JetBrains Mono',monospace;}
.exp-bullets{list-style:none;display:flex;flex-direction:column;gap:8px;}
.exp-bullets li{font-size:.84rem;color:var(--txt2);padding-left:15px;position:relative;line-height:1.7;font-weight:300;}
.exp-bullets li::before{content:'→';position:absolute;left:0;color:var(--ac);font-size:.72rem;}
.exp-tags{display:flex;flex-wrap:wrap;gap:5px;margin-top:14px;}
.etag{font-family:'JetBrains Mono',monospace;font-size:.62rem;background:rgba(0,212,255,.06);color:var(--txt2);border:1px solid rgba(0,212,255,.12);padding:2px 8px;border-radius:3px;}

/* EDUCATION */
#education{background:var(--bg2);}
.edu-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.edu-card{background:var(--surf);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:26px;transition:all .28s;position:relative;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.25);}
.edu-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--ac),transparent);transform:scaleX(0);transition:.28s;}
.edu-card:hover::after{transform:scaleX(1);}
.edu-card:hover{border-color:rgba(0,212,255,.25);transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,.4);}
.edu-emoji{font-size:2rem;margin-bottom:14px;}
.edu-degree{font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;margin-bottom:3px;color:var(--txt);}
.edu-school{font-size:.79rem;color:var(--ac);margin-bottom:5px;}
.edu-period{font-family:'JetBrains Mono',monospace;font-size:.64rem;color:var(--txt3);}
.edu-loc{font-size:.73rem;color:var(--txt3);margin-top:3px;}
.edu-badges{margin-top:12px;display:flex;flex-wrap:wrap;gap:5px;}
.ebadge{font-size:.62rem;background:rgba(168,85,247,.08);color:var(--purple);border:1px solid rgba(168,85,247,.18);padding:2px 7px;border-radius:3px;font-family:'JetBrains Mono',monospace;}

/* SKILLS */
#skills{background:var(--bg);}
.skills-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.skill-group{background:var(--surf);border:1px solid var(--bd2);border-radius:12px;padding:22px;transition:border-color .25s,box-shadow .25s;position:relative;overflow:hidden;}
.skill-group::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--ac),var(--e3));opacity:0;transition:opacity .25s;}
.skill-group:hover::before{opacity:1;}
.skill-group:hover{border-color:rgba(0,212,255,.22);box-shadow:0 8px 32px rgba(0,0,0,.35);}
.sg-title{font-family:'JetBrains Mono',monospace;font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;color:var(--ac);margin-bottom:16px;display:flex;align-items:center;gap:7px;}
.sg-title::before{content:'//';opacity:.5;}
.sg-item{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid rgba(255,255,255,.04);font-size:.82rem;color:var(--txt2);transition:color .2s;}
.sg-item:last-child{border-bottom:none;}
.sg-item:hover{color:var(--txt);}
.sg-dot{width:5px;height:5px;border-radius:50%;background:var(--ac);flex-shrink:0;box-shadow:0 0 6px rgba(0,212,255,.5);}

/* PROJECTS */
#projects{background:var(--bg2);}
.proj-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
.proj-card{background:var(--surf);border:1px solid rgba(255,255,255,.06);border-radius:14px;overflow:hidden;transition:all .3s;display:flex;flex-direction:column;box-shadow:0 2px 16px rgba(0,0,0,.3);}
.proj-card:hover{border-color:rgba(0,212,255,.22);transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,0,0,.45);}
.proj-card.featured{border-color:rgba(0,212,255,.16);}
.proj-header{padding:20px 20px 0;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.proj-logo-wrap{width:48px;height:48px;border-radius:10px;background:var(--bg3);border:1px solid var(--bd2);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;}
.proj-logo-wrap img{width:100%;height:100%;object-fit:contain;padding:5px;}
.proj-logo-placeholder{font-size:1.3rem;}
.proj-badges{display:flex;gap:5px;flex-direction:column;align-items:flex-end;}
.proj-featured-badge{font-family:'JetBrains Mono',monospace;font-size:.52rem;background:rgba(255,183,0,.1);color:var(--amber);border:1px solid rgba(255,183,0,.2);padding:2px 7px;border-radius:3px;white-space:nowrap;}
.proj-body{padding:16px 20px;flex:1;}
.proj-title{font-family:'Syne',sans-serif;font-size:1.05rem;font-weight:700;margin-bottom:4px;}
.proj-company{font-family:'JetBrains Mono',monospace;font-size:.65rem;color:var(--ac);letter-spacing:.04em;margin-bottom:10px;}
.proj-desc{font-size:.82rem;color:var(--txt2);line-height:1.75;font-weight:300;}
.proj-tags{padding:0 20px;display:flex;flex-wrap:wrap;gap:5px;margin-bottom:14px;}
.ptag{font-family:'JetBrains Mono',monospace;font-size:.6rem;background:color-mix(in srgb,var(--ac) 5%,transparent);color:var(--txt2);border:1px solid color-mix(in srgb,var(--ac) 10%,transparent);padding:2px 7px;border-radius:3px;}
.proj-footer{padding:14px 20px;border-top:1px solid var(--bd2);display:flex;gap:8px;align-items:center;}
.proj-link{display:inline-flex;align-items:center;gap:5px;font-family:'JetBrains Mono',monospace;font-size:.62rem;color:var(--txt2);border:1px solid var(--bd2);padding:5px 10px;border-radius:5px;transition:all .2s;}
.proj-link:hover{border-color:var(--ac);color:var(--ac);}
.proj-link-primary{background:var(--ac);color:var(--bg);border-color:var(--ac);}
.proj-link-primary:hover{filter:brightness(1.1);box-shadow:0 0 14px color-mix(in srgb,var(--ac) 30%,transparent);}

/* UPWORK */
#upwork{background:var(--bg);}
.upwork-wrap{background:linear-gradient(135deg,rgba(111,218,68,.07),rgba(111,218,68,.03));border:1px solid rgba(111,218,68,.18);border-radius:14px;padding:48px;display:grid;grid-template-columns:1fr 1fr;gap:52px;align-items:start;}
.uw-h2{font-family:'Syne',sans-serif;font-size:clamp(1.8rem,3vw,2.5rem);font-weight:800;letter-spacing:-.03em;margin-bottom:12px;}
.uw-h2 span{color:#6fda44;}
.uw-p{font-size:.92rem;color:var(--txt2);line-height:1.85;margin-bottom:22px;font-weight:300;}
.uw-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;}
.uw-stat{background:rgba(0,0,0,.3);border-radius:7px;padding:16px;text-align:center;}
.uw-num{font-family:'Syne',sans-serif;font-size:1.9rem;font-weight:800;color:#6fda44;line-height:1;}
.uw-lbl{font-size:.65rem;color:var(--txt3);margin-top:4px;letter-spacing:.08em;text-transform:uppercase;}
.btn-uw{display:inline-flex;align-items:center;gap:8px;background:#6fda44;color:#07090d;padding:12px 26px;border-radius:6px;font-family:'Syne',sans-serif;font-size:.83rem;font-weight:700;transition:all .28s;}
.btn-uw:hover{background:#7ff559;box-shadow:0 0 22px rgba(111,218,68,.3);transform:translateY(-2px);}
.uw-reviews{display:flex;flex-direction:column;gap:12px;}
.uw-review{background:rgba(0,0,0,.28);border-radius:9px;padding:18px;border-left:2px solid #6fda44;}
.uw-stars{color:var(--amber);font-size:.88rem;letter-spacing:2px;margin-bottom:7px;}
.uw-txt{font-size:.8rem;color:var(--txt2);line-height:1.75;font-style:italic;margin-bottom:8px;}
.uw-by{font-size:.71rem;color:var(--txt3);font-family:'JetBrains Mono',monospace;}

/* CONTACT */
#contact{background:var(--bg2);}
.contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:52px;align-items:start;}
.contact-info{display:flex;flex-direction:column;gap:12px;}
.ci{display:flex;align-items:flex-start;gap:13px;padding:15px;background:var(--surf);border:1px solid rgba(255,255,255,.06);border-radius:10px;transition:border-color .22s;}
.ci:hover{border-color:rgba(0,212,255,.22);}
.ci-ico{width:36px;height:36px;background:rgba(0,212,255,.08);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;border:1px solid rgba(0,212,255,.14);}
.ci-lbl{font-family:'JetBrains Mono',monospace;font-size:.6rem;letter-spacing:.14em;text-transform:uppercase;color:var(--txt3);margin-bottom:3px;}
.ci-val{font-size:.85rem;color:var(--txt2);}
.ci-val a{color:var(--txt2);transition:color .2s;}.ci-val a:hover{color:var(--ac);}
.contact-form{background:var(--surf);border:1px solid rgba(255,255,255,.06);border-radius:14px;padding:32px;position:relative;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.35);}
.contact-form::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--ac),var(--e3),var(--purple));}
.fg{margin-bottom:15px;}
.fr{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
label{display:block;font-family:'JetBrains Mono',monospace;font-size:.58rem;letter-spacing:.16em;text-transform:uppercase;color:var(--txt3);margin-bottom:5px;}
input,select,textarea{width:100%;padding:10px 13px;background:var(--bg3);border:1px solid var(--bd2);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:.88rem;color:var(--txt);outline:none;transition:border-color .22s;}
input:focus,select:focus,textarea:focus{border-color:var(--ac);}
select{-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%233d5068' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:30px;}
textarea{resize:vertical;min-height:110px;line-height:1.6;}
.submit-btn{width:100%;padding:13px;background:var(--ac);color:var(--bg);border:none;border-radius:6px;font-family:'Syne',sans-serif;font-size:.86rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;cursor:pointer;transition:all .28s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:4px;}
.submit-btn:hover{filter:brightness(1.1);box-shadow:0 0 26px color-mix(in srgb,var(--ac) 30%,transparent);}
.alert-s{background:rgba(0,255,204,.06);border:1px solid rgba(0,255,204,.2);color:var(--e3);padding:11px 14px;border-radius:7px;font-size:.83rem;margin-bottom:15px;}
.alert-e{background:rgba(255,77,109,.07);border:1px solid rgba(255,77,109,.2);color:var(--rose);padding:11px 14px;border-radius:7px;font-size:.83rem;margin-bottom:15px;}

/* FOOTER */
footer{background:var(--bg);border-top:1px solid var(--bd2);padding:32px 56px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;}
.foot-brand{font-family:'Syne',sans-serif;font-size:.96rem;font-weight:700;}
.foot-brand span{color:var(--ac);}
.foot-links{display:flex;gap:16px;flex-wrap:wrap;}
.foot-links a{font-size:.74rem;color:var(--txt3);font-family:'JetBrains Mono',monospace;transition:color .2s;}
.foot-links a:hover{color:var(--ac);}
.foot-copy{font-size:.71rem;color:var(--txt3);font-family:'JetBrains Mono',monospace;}

/* FLOAT CTA */
.float-cta{position:fixed;bottom:28px;right:28px;z-index:90;background:var(--ac);color:var(--bg);border:none;border-radius:50px;padding:11px 20px;font-family:'Syne',sans-serif;font-size:.76rem;font-weight:700;cursor:pointer;box-shadow:0 8px 28px color-mix(in srgb,var(--ac) 30%,transparent);transition:all .28s;display:none;align-items:center;gap:7px;}
.float-cta:hover{filter:brightness(1.1);transform:translateY(-2px);}
.float-cta.show{display:flex;}

/* REVEAL */
.reveal{opacity:0;transform:translateY(24px);transition:opacity .65s ease,transform .65s ease;}
.reveal.in{opacity:1;transform:none;}
.d1{transition-delay:.1s;}.d2{transition-delay:.2s;}.d3{transition-delay:.3s;}

/* RESPONSIVE */
@media(max-width:1100px){.skills-grid{grid-template-columns:1fr 1fr;}.about-grid{grid-template-columns:1fr;gap:36px;}.proj-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:900px){
  nav{padding:0 20px;}.nav-links{display:none;}.hamburger{display:flex;}
  .hero{padding:0 20px;}.hero-inner{padding-top:108px;}
  section{padding:68px 20px;}
  .about-grid,.contact-grid,.exp-wrap,.upwork-wrap{grid-template-columns:1fr;gap:28px;}
  .edu-grid{grid-template-columns:1fr 1fr;}
  .skills-grid,.proj-grid{grid-template-columns:1fr 1fr;}
  .hero-stats{flex-direction:column;gap:16px;padding-top:24px;}
  .hs-item{border-right:none;border-bottom:1px solid var(--bd2);padding:0 0 16px;padding-left:0!important;}
  .hs-item:last-child{border-bottom:none;padding-bottom:0;}
  footer{padding:24px 20px;flex-direction:column;align-items:flex-start;}
  .exp-nav{display:none;}
  .uw-stats{grid-template-columns:1fr 1fr;}
  .upwork-wrap{padding:28px;}
}
@media(max-width:600px){
  .hero-name{font-size:clamp(2.5rem,9vw,3.8rem);}
  .edu-grid,.proj-grid,.skills-grid,.contact-grid,.about-grid{grid-template-columns:1fr;}
  .fr{grid-template-columns:1fr;}
  .hero{padding:0 16px;}section{padding:56px 16px;}
  .skill-chips{grid-template-columns:repeat(3,1fr);}
  .social-row{gap:4px;}
}
</style>
</head>
<body>

@php
/* Build active social list */
$socials = [];
$socialDefs = [
  'linkedin_url'     => ['LinkedIn','🔗'],
  'github_url'       => ['GitHub','🐙'],
  'stackoverflow_url'=> ['Stack Overflow','📚'],
  'twitter_url'      => ['X / Twitter','🐦'],
  'instagram_url'    => ['Instagram','📸'],
  'youtube_url'      => ['YouTube','▶️'],
  'dribbble_url'     => ['Dribbble','🎨'],
  'behance_url'      => ['Behance','✏️'],
  'devto_url'        => ['Dev.to','💻'],
  'medium_url'       => ['Medium','📖'],
  'website_url'      => ['Website','🌐'],
];
foreach ($socialDefs as $key => [$label,$icon]) {
  if (!empty($s[$key])) $socials[$key] = ['label'=>$label,'icon'=>$icon,'url'=>$s[$key]];
}
/* initials */
$nameParts = array_filter(explode(' ', $s['full_name']??'DP'));
$initials = implode('', array_map(fn($p) => strtoupper(mb_substr($p,0,1)), array_slice($nameParts,0,2)));
/* name split for hero */
$np = explode(' ', trim($s['full_name']??'Darshan Patel'), 2);
@endphp

<!-- NAV -->
<nav id="nav">
  <a href="#" class="nav-logo">{{ $np[0] }}<span>.</span></a>
  <div class="nav-links">
    <a href="#about">About</a>
    @if(($s['show_experience']??'1')==='1')<a href="#experience">Experience</a>@endif
    @if(($s['show_education']??'1')==='1')<a href="#education">Education</a>@endif
    @if(($s['show_skills']??'1')==='1')<a href="#skills">Skills</a>@endif
    @if(($s['show_projects']??'1')==='1' && $projects->count()>0)<a href="#projects">Projects</a>@endif
    @if(($s['show_upwork']??'1')==='1')<a href="#upwork">Upwork</a>@endif
    @if(($s['show_contact']??'1')==='1')<a href="#contact" class="nav-hire">Hire Me</a>@endif
  </div>
  <button class="hamburger" onclick="toggleMob()"><span></span><span></span><span></span></button>
</nav>
<div class="mob-nav" id="mobNav">
  <button class="mob-close" onclick="toggleMob()">✕</button>
  <a href="#about" onclick="toggleMob()">About</a>
  @if(($s['show_experience']??'1')==='1')<a href="#experience" onclick="toggleMob()">Experience</a>@endif
  @if(($s['show_education']??'1')==='1')<a href="#education" onclick="toggleMob()">Education</a>@endif
  @if(($s['show_skills']??'1')==='1')<a href="#skills" onclick="toggleMob()">Skills</a>@endif
  @if(($s['show_projects']??'1')==='1' && $projects->count()>0)<a href="#projects" onclick="toggleMob()">Projects</a>@endif
  @if(($s['show_upwork']??'1')==='1')<a href="#upwork" onclick="toggleMob()">Upwork</a>@endif
  @if(($s['show_contact']??'1')==='1')<a href="#contact" onclick="toggleMob()">Contact</a>@endif
</div>

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-grid"></div><div class="hero-glow"></div><div class="hero-glow2"></div>
  <div class="hero-inner">
    @if(($s['available_for_work']??'1')==='1')
    <div class="hero-tag"><div class="hero-dot"></div>🟢 {{ $s['availability_text']??'Available for Freelance & Full-Time' }}</div>
    @endif
    <h1 class="hero-name">{{ $np[0] }}<br><span class="ghost">{{ $np[1]??'' }}</span></h1>
    <p class="hero-tagline">{{ $s['hero_tagline']??'' }}</p>
    <div class="hero-actions">
      <a href="#contact" class="btn-p">Let's Work Together →</a>
      @if(($s['show_projects']??'1')==='1' && $projects->count()>0)<a href="#projects" class="btn-ghost">View My Projects</a>
      @elseif(($s['show_experience']??'1')==='1')<a href="#experience" class="btn-ghost">View My Work</a>@endif
    </div>
    <div class="hero-stats">
      <div class="hs-item"><div class="hs-num">{{ $s['years_experience']??'5+' }}</div><div class="hs-lbl">Years Experience</div></div>
      <div class="hs-item"><div class="hs-num">⭐{{ $s['upwork_rating']??'5.0' }}</div><div class="hs-lbl">Upwork Rating</div></div>
      <div class="hs-item"><div class="hs-num">{{ $s['projects_count']??'20+' }}</div><div class="hs-lbl">Projects Delivered</div></div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section id="about">
  <div class="container">
    <div class="about-grid">
      <div class="reveal">
        <div class="about-card">
          <div class="av-wrap">
            @if(!empty($s['profile_image']))
              <img src="{{ asset('storage/'.$s['profile_image']) }}" alt="{{ $s['full_name']??'Profile' }}" class="av-photo">
            @else
              <div class="av-initials">{{ $initials }}</div>
            @endif
          </div>
          <div class="about-name">{{ $s['full_name']??'Darshan Patel' }}</div>
          <div class="about-role">// full-stack-developer</div>
          @if($s['location']??'')<div class="about-info">📍 {{ $s['location'] }}</div>@endif
          @if($s['phone']??'')<div class="about-info">📞 {{ $s['phone'] }}</div>@endif
          @if($s['email']??'')<div class="about-info">✉️ {{ $s['email'] }}</div>@endif
          @if(($s['available_for_work']??'1')==='1')
          <div class="avail"><div class="avail-dot"></div>Available for new projects</div>
          @endif
          @if($s['upwork_url']??'')
          <div class="upwork-pill">
            <span style="font-size:1.2rem;">🟢</span>
            <div style="font-size:.77rem;color:var(--txt2);"><strong style="color:#6fda44;">5-Star Freelancer on Upwork</strong><br><a href="{{ $s['upwork_url'] }}" target="_blank">View Upwork Profile →</a></div>
          </div>
          @endif
          @if(count($socials)>0)
          <div class="social-row">
            @foreach($socials as $sl)
            <a href="{{ $sl['url'] }}" target="_blank" class="soc-btn"><span>{{ $sl['icon'] }}</span>{{ $sl['label'] }}</a>
            @endforeach
          </div>
          @endif
        </div>
      </div>
      <div class="reveal d1">
        <div class="sec-label">About Me</div>
        <h2 class="sec-title">Building Things <em>That Matter</em></h2>
        @foreach(array_filter(explode("\n\n",$s['about_text']??'')) as $para)
        <p style="font-size:.94rem;line-height:1.88;color:var(--txt2);margin-bottom:14px;font-weight:300;">{!! $para !!}</p>
        @endforeach
        @if($skills->count()>0)
        <div class="skill-chips">
          @foreach($skills->take(1) as $sg)@foreach(array_slice($sg->items,0,16) as $sk)<div class="chip">{{ $sk }}</div>@endforeach @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- EXPERIENCE -->
@if(($s['show_experience']??'1')==='1' && $experiences->count()>0)
<section id="experience">
  <div class="container">
    <div class="sec-label">Career Timeline</div>
    <h2 class="sec-title" style="margin-bottom:48px;">Work <em>Experience</em></h2>
    <div class="exp-wrap">
      <div class="exp-nav reveal">
        @foreach($experiences as $i=>$exp)
        <div class="exp-nav-item" data-i="{{ $i }}" onclick="scrollToExp({{ $i }})"><div class="exp-nav-dot"></div>{{ $exp->company }}</div>
        @endforeach
      </div>
      <div>
        @foreach($experiences as $i=>$exp)
        <div class="exp-card reveal d1" data-exp="{{ $i }}">
          <div class="exp-period">{{ $exp->period_start }} — {{ $exp->period_end }}</div>
          <div class="exp-role">{{ $exp->role }}</div>
          <div class="exp-co">{{ $exp->company }} @if($exp->location)<span class="exp-loc">📍 {{ $exp->location }}</span>@endif</div>
          @if($exp->bullets&&count($exp->bullets)>0)<ul class="exp-bullets">@foreach($exp->bullets as $b)<li>{{ $b }}</li>@endforeach</ul>@endif
          @if($exp->tags&&count($exp->tags)>0)<div class="exp-tags">@foreach($exp->tags as $t)<span class="etag">{{ $t }}</span>@endforeach</div>@endif
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

<!-- EDUCATION -->
@if(($s['show_education']??'1')==='1' && $educations->count()>0)
<section id="education">
  <div class="container">
    <div class="sec-label">Academic Background</div>
    <h2 class="sec-title" style="margin-bottom:44px;">Education & <em>Qualifications</em></h2>
    <div class="edu-grid">
      @foreach($educations as $i=>$edu)
      <div class="edu-card reveal d{{ min($i,3) }}">
        <div class="edu-emoji">{{ $edu->emoji }}</div>
        <div class="edu-degree">{{ $edu->degree }}</div>
        <div class="edu-school">{{ $edu->institution }}</div>
        <div class="edu-period">{{ $edu->period_start }}@if($edu->period_end) — {{ $edu->period_end }}@endif</div>
        @if($edu->location)<div class="edu-loc">📍 {{ $edu->location }}</div>@endif
        @if($edu->badges&&count($edu->badges)>0)<div class="edu-badges">@foreach($edu->badges as $b)<span class="ebadge">{{ $b }}</span>@endforeach</div>@endif
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- SKILLS -->
@if(($s['show_skills']??'1')==='1' && $skills->count()>0)
<section id="skills">
  <div class="container">
    <div class="sec-label">Technical Arsenal</div>
    <h2 class="sec-title" style="margin-bottom:44px;">Skills & <em>Technologies</em></h2>
    <div class="skills-grid">
      @foreach($skills as $i=>$sg)
      <div class="skill-group reveal d{{ min($i,3) }}">
        <div class="sg-title">// {{ $sg->group_label }}</div>
        @foreach($sg->items as $item)<div class="sg-item"><div class="sg-dot"></div>{{ $item }}</div>@endforeach
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- PROJECTS -->
@if(($s['show_projects']??'1')==='1' && $projects->count()>0)
<section id="projects">
  <div class="container">
    <div class="sec-label">Featured Work</div>
    <h2 class="sec-title" style="margin-bottom:44px;">My <em>Projects</em></h2>
    <div class="proj-grid">
      @foreach($projects as $i=>$proj)
      <div class="proj-card {{ $proj->featured?'featured':'' }} reveal d{{ min($i%3,3) }}">
        <div class="proj-header">
          <div class="proj-logo-wrap">
            @if($proj->company_logo)
              <img src="{{ asset('storage/'.$proj->company_logo) }}" alt="{{ $proj->company_name }}">
            @else
              <span class="proj-logo-placeholder">🚀</span>
            @endif
          </div>
          <div class="proj-badges">
            @if($proj->featured)<span class="proj-featured-badge">⭐ Featured</span>@endif
          </div>
        </div>
        <div class="proj-body">
          <div class="proj-title">{{ $proj->title }}</div>
          @if($proj->company_name)<div class="proj-company">{{ $proj->company_name }}</div>@endif
          @if($proj->description)<div class="proj-desc">{{ $proj->description }}</div>@endif
        </div>
        @if($proj->tags&&count($proj->tags)>0)
        <div class="proj-tags">
          @foreach($proj->tags as $t)<span class="ptag">{{ $t }}</span>@endforeach
        </div>
        @endif
        @if($proj->project_url || $proj->github_url)
        <div class="proj-footer">
          @if($proj->project_url)<a href="{{ $proj->project_url }}" target="_blank" class="proj-link proj-link-primary">🔗 Live Demo</a>@endif
          @if($proj->github_url)<a href="{{ $proj->github_url }}" target="_blank" class="proj-link">🐙 GitHub</a>@endif
        </div>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- UPWORK -->
@if(($s['show_upwork']??'1')==='1')
<section id="upwork">
  <div class="container">
    <div class="upwork-wrap reveal">
      <div>
        <div class="sec-label">Freelance Platform</div>
        <h2 class="uw-h2">{{ $s['upwork_section_title']??'5-Star Rated on Upwork' }}</h2>
        <p class="uw-p">{{ $s['upwork_section_desc']??'' }}</p>
        <div class="uw-stats">
          <div class="uw-stat"><div class="uw-num">{{ $s['upwork_rating']??'5.0' }}</div><div class="uw-lbl">Star Rating</div></div>
          <div class="uw-stat"><div class="uw-num">{{ $s['job_success']??'100%' }}</div><div class="uw-lbl">Job Success</div></div>
          <div class="uw-stat"><div class="uw-num">Top</div><div class="uw-lbl">Rated Plus</div></div>
        </div>
        @if($s['upwork_url']??'')<a href="{{ $s['upwork_url'] }}" target="_blank" class="btn-uw">View Upwork Profile →</a>@endif
      </div>
      <div class="uw-reviews">
        @forelse($reviews as $r)
        <div class="uw-review">
          <div class="uw-stars">{{ str_repeat('★',$r->rating) }}{{ str_repeat('☆',5-$r->rating) }}</div>
          <div class="uw-txt">"{{ $r->review_text }}"</div>
          <div class="uw-by">— {{ $r->reviewer }}@if($r->project_type) · {{ $r->project_type }}@endif</div>
        </div>
        @empty
        <div class="uw-review"><div class="uw-stars">★★★★★</div><div class="uw-txt">"No reviews added yet."</div></div>
        @endforelse
      </div>
    </div>
  </div>
</section>
@endif

<!-- CONTACT -->
@if(($s['show_contact']??'1')==='1')
<section id="contact">
  <div class="container">
    <div class="sec-label">Get In Touch</div>
    <h2 class="sec-title" style="margin-bottom:12px;">Let's Build <em>Something Great</em></h2>
    <p style="font-size:.93rem;color:var(--txt2);max-width:500px;margin-bottom:46px;font-weight:300;line-height:1.8;">Have a project in mind? I'd love to hear from you.</p>
    <div class="contact-grid">
      <div class="contact-info reveal">
        @foreach([['📧','Email',$s['email']??'','mailto:'.($s['email']??'')],['📞','Phone / WhatsApp',$s['phone']??'','tel:'.($s['phone']??'')],['📍','Location',$s['location']??'',null]] as [$ico,$lbl,$val,$href])
        @if($val)<div class="ci"><div class="ci-ico">{{ $ico }}</div><div><div class="ci-lbl">{{ $lbl }}</div><div class="ci-val">@if($href)<a href="{{ $href }}" target="_blank">{{ $val }}</a>@else{{ $val }}@endif</div></div></div>@endif
        @endforeach
        @foreach(['linkedin_url'=>['💼','LinkedIn'],'upwork_url'=>['🟢','Upwork'],'github_url'=>['🐙','GitHub']] as $key=>[$ico,$lbl])
        @if(!empty($s[$key]))<div class="ci"><div class="ci-ico">{{ $ico }}</div><div><div class="ci-lbl">{{ $lbl }}</div><div class="ci-val"><a href="{{ $s[$key] }}" target="_blank">{{ parse_url($s[$key],PHP_URL_HOST) }}</a></div></div></div>@endif
        @endforeach
      </div>
      <div class="contact-form reveal d1">
        @if(session('success'))<div class="alert-s">✅ {{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert-e">⚠️ {{ $errors->first() }}</div>@endif
        <h3 style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:700;margin-bottom:4px;">Send a Message</h3>
        <p style="font-size:.78rem;color:var(--txt3);margin-bottom:22px;font-family:'JetBrains Mono',monospace;">// I reply within 24 hours</p>
        <form action="{{ route('contact.send') }}" method="POST">@csrf
          <div class="fr"><div class="fg"><label>Name *</label><input type="text" name="name" value="{{ old('name') }}" required placeholder="Your name"></div><div class="fg"><label>Email *</label><input type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com"></div></div>
          <div class="fr"><div class="fg"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+1 000 000 0000"></div><div class="fg"><label>Type</label><select name="type">@foreach(['project'=>'New Project','job'=>'Job Opportunity','collaboration'=>'Collaboration','general'=>'General'] as $v=>$l)<option value="{{ $v }}" {{ old('type')===$v?'selected':'' }}>{{ $l }}</option>@endforeach</select></div></div>
          <div class="fg"><label>Subject *</label><input type="text" name="subject" value="{{ old('subject') }}" required placeholder="What's this about?"></div>
          <div class="fr"><div class="fg"><label>Budget</label><select name="budget"><option value="">Select range</option>@foreach(['< $500','$500–$1,000','$1,000–$5,000','$5,000–$10,000','$10,000+','Negotiable'] as $b)<option value="{{ $b }}" {{ old('budget')===$b?'selected':'' }}>{{ $b }}</option>@endforeach</select></div><div class="fg"><label>Timeline</label><select name="timeline"><option value="">Select</option>@foreach(['< 1 Week','1–2 Weeks','1 Month','2–3 Months','3–6 Months','Ongoing'] as $t)<option value="{{ $t }}" {{ old('timeline')===$t?'selected':'' }}>{{ $t }}</option>@endforeach</select></div></div>
          <div class="fg"><label>Message *</label><textarea name="message" required placeholder="Tell me about your project...">{{ old('message') }}</textarea></div>
          <button type="submit" class="submit-btn">Send Message →</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endif

<footer>
  <div class="foot-brand">{{ $np[0] }}<span>.</span></div>
  <div class="foot-links">
    @foreach($socials as $sl)<a href="{{ $sl['url'] }}" target="_blank">{{ $sl['label'] }}</a>@endforeach
  </div>
  <div class="foot-copy">© {{ date('Y') }} {{ $s['full_name']??'Darshan Patel' }} · Built with Laravel</div>
</footer>

<button class="float-cta" id="floatCta" onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">💬 Let's Talk</button>

<script>
window.addEventListener('scroll',()=>{
  document.getElementById('nav').classList.toggle('scrolled',scrollY>60);
  document.getElementById('floatCta').classList.toggle('show',scrollY>400);
});
function toggleMob(){document.getElementById('mobNav').classList.toggle('open');document.body.style.overflow=document.getElementById('mobNav').classList.contains('open')?'hidden':'';}
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target);}}),{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
function scrollToExp(i){document.querySelectorAll('.exp-nav-item').forEach((el,j)=>el.classList.toggle('on',j===i));const items=document.querySelectorAll('.exp-card');if(items[i])items[i].scrollIntoView({behavior:'smooth',block:'center'});}
const expObs=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){const i=x.target.dataset.exp;document.querySelectorAll('.exp-nav-item').forEach((el,j)=>el.classList.toggle('on',String(j)===i));}}),{threshold:.5});
document.querySelectorAll('.exp-card[data-exp]').forEach(el=>expObs.observe(el));
document.querySelectorAll('a[href^="#"]').forEach(a=>a.addEventListener('click',e=>{const t=document.querySelector(a.getAttribute('href'));if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth'});}}));
</script>
</body>
</html>
