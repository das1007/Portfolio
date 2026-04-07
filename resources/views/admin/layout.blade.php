<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>@yield('title','Admin') — Portfolio CMS</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
:root{
  --bg:#07090d;--bg2:#0b0f15;--bg3:#0f141b;--surf:#141c26;--surf2:#192230;--surf3:#1e2a3a;
  --e:#00d4ff;--e2:#0099cc;--e3:#00ffcc;
  --rose:#ff4d6d;--amber:#ffb700;--green:#22c55e;--purple:#a855f7;
  --txt:#dce8f8;--txt2:#7a90a8;--txt3:#3d5068;
  --bd:rgba(0,212,255,.1);--bd2:rgba(255,255,255,.05);--bd3:rgba(0,212,255,.06);
  --sb:252px;--tb:58px;--r:9px;
}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--txt);display:flex;min-height:100vh;font-size:13.5px;overflow-x:hidden;}
a{text-decoration:none;color:inherit;}
button,input,select,textarea{font-family:'DM Sans',sans-serif;}
::selection{background:rgba(0,212,255,.2);}

/* SIDEBAR */
.sb{width:var(--sb);background:var(--bg2);border-right:1px solid var(--bd2);position:fixed;top:0;left:0;bottom:0;display:flex;flex-direction:column;z-index:300;overflow-y:auto;transition:transform .28s cubic-bezier(.4,0,.2,1);}
.sb-brand{padding:18px 16px 14px;border-bottom:1px solid var(--bd2);display:flex;align-items:center;gap:10px;flex-shrink:0;}
.sb-mark{width:34px;height:34px;background:linear-gradient(135deg,var(--e),var(--e3));border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:.9rem;font-weight:800;color:var(--bg);flex-shrink:0;box-shadow:0 0 14px rgba(0,212,255,.25);}
.sb-bname{font-family:'Syne',sans-serif;font-size:1.02rem;font-weight:800;line-height:1.1;}
.sb-bname span{color:var(--e);}
.sb-bsub{font-family:'JetBrains Mono',monospace;font-size:.52rem;color:var(--txt3);letter-spacing:.14em;margin-top:2px;}
.sb-nav{padding:10px 8px;flex:1;}
.sb-sec{font-family:'JetBrains Mono',monospace;font-size:.5rem;letter-spacing:.3em;text-transform:uppercase;color:var(--txt3);margin:14px 8px 6px;padding-bottom:4px;border-bottom:1px solid var(--bd2);}
.sb-a{display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:8px;color:var(--txt3);font-size:.82rem;margin-bottom:1px;transition:all .18s;white-space:nowrap;}
.sb-a:hover{background:rgba(0,212,255,.05);color:var(--txt2);}
.sb-a.on{background:rgba(0,212,255,.1);color:var(--e);border:1px solid rgba(0,212,255,.14);}
.sb-a .ico{font-size:.9rem;width:17px;text-align:center;flex-shrink:0;}
.sb-badge{margin-left:auto;background:var(--rose);color:#fff;font-size:.55rem;padding:2px 6px;border-radius:8px;font-weight:700;min-width:18px;text-align:center;}
.sb-foot{padding:10px 8px;border-top:1px solid var(--bd2);flex-shrink:0;}
.sb-logout{display:flex;align-items:center;gap:8px;color:var(--txt3);font-size:.8rem;width:100%;background:none;border:none;padding:8px 10px;border-radius:8px;transition:all .18s;cursor:pointer;}
.sb-logout:hover{background:rgba(255,77,109,.07);color:var(--rose);}
.sb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:299;}
.sb-overlay.open{display:block;}

/* MAIN */
.main-w{margin-left:var(--sb);flex:1;display:flex;flex-direction:column;min-width:0;}
.tb{background:var(--bg2);border-bottom:1px solid var(--bd2);height:var(--tb);padding:0 22px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
.tb-left{display:flex;align-items:center;gap:12px;}
.mob-tog{display:none;width:34px;height:34px;background:var(--surf);border:1px solid var(--bd2);border-radius:8px;align-items:center;justify-content:center;cursor:pointer;font-size:1.1rem;flex-shrink:0;color:var(--txt2);}
.tb-title{font-family:'Syne',sans-serif;font-size:.95rem;font-weight:700;}
.tb-right{display:flex;align-items:center;gap:8px;}
.tb-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;font-size:.71rem;border:1px solid var(--bd2);background:var(--surf);color:var(--txt2);transition:all .18s;font-family:'JetBrains Mono',monospace;cursor:pointer;white-space:nowrap;}
.tb-btn:hover{border-color:var(--e);color:var(--e);}
.tb-av{width:32px;height:32px;background:linear-gradient(135deg,var(--e),var(--e3));border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:.78rem;color:var(--bg);flex-shrink:0;}
.pb{padding:20px 22px;flex:1;}

/* ALERTS */
.msg-s{background:rgba(0,255,204,.06);border:1px solid rgba(0,255,204,.2);color:var(--e3);padding:10px 15px;border-radius:8px;font-size:.82rem;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.msg-e{background:rgba(255,77,109,.07);border:1px solid rgba(255,77,109,.2);color:var(--rose);padding:10px 15px;border-radius:8px;font-size:.82rem;margin-bottom:16px;}

/* CARDS */
.card{background:var(--surf);border:1px solid var(--bd2);border-radius:var(--r);overflow:hidden;margin-bottom:16px;}
.card-h{padding:13px 18px;border-bottom:1px solid var(--bd2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.card-t{font-family:'Syne',sans-serif;font-size:.86rem;font-weight:700;}
.card-b{padding:18px;}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px;}
.stat{background:var(--surf);border:1px solid var(--bd2);border-radius:var(--r);padding:17px 18px;position:relative;overflow:hidden;display:flex;justify-content:space-between;align-items:flex-start;}
.stat::after{content:'';position:absolute;top:0;left:0;right:0;height:2px;}
.stat.c1::after{background:linear-gradient(90deg,var(--e),var(--e3));}
.stat.c2::after{background:linear-gradient(90deg,var(--rose),#ff8fa3);}
.stat.c3::after{background:linear-gradient(90deg,var(--amber),#ffd166);}
.stat.c4::after{background:linear-gradient(90deg,var(--green),#4ade80);}
.stat-label{font-family:'JetBrains Mono',monospace;font-size:.56rem;letter-spacing:.18em;text-transform:uppercase;color:var(--txt3);margin-bottom:8px;}
.stat-num{font-family:'Syne',sans-serif;font-size:2.1rem;font-weight:800;line-height:1;}
.stat.c2 .stat-num{color:var(--rose);}
.stat-sub{font-size:.7rem;color:var(--txt3);margin-top:3px;}
.stat-ico{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;}
.stat.c1 .stat-ico{background:rgba(0,212,255,.09);}
.stat.c2 .stat-ico{background:rgba(255,77,109,.08);}
.stat.c3 .stat-ico{background:rgba(255,183,0,.08);}
.stat.c4 .stat-ico{background:rgba(34,197,94,.08);}

/* DASH GRID */
.dash-grid{display:grid;grid-template-columns:1fr 280px;gap:14px;margin-bottom:14px;}

/* CONTENT OVERVIEW */
.cnt-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:14px;}
.cnt-card{background:var(--surf);border:1px solid var(--bd2);border-radius:var(--r);padding:14px;transition:all .2s;cursor:pointer;}

/* TABLE */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;}
table{width:100%;border-collapse:collapse;min-width:500px;}
th{font-family:'JetBrains Mono',monospace;font-size:.56rem;letter-spacing:.18em;text-transform:uppercase;color:var(--txt3);padding:9px 14px;text-align:left;border-bottom:1px solid var(--bd2);white-space:nowrap;}
td{padding:10px 14px;border-bottom:1px solid rgba(255,255,255,.025);font-size:.81rem;vertical-align:middle;}
tr:last-child td{border-bottom:none;}
tr:hover td{background:rgba(0,212,255,.018);}

/* BADGES */
.badge{display:inline-block;font-family:'JetBrains Mono',monospace;font-size:.58rem;letter-spacing:.06em;text-transform:uppercase;padding:2px 8px;border-radius:4px;font-weight:500;white-space:nowrap;}
.b-new{background:rgba(0,255,204,.09);color:var(--e3);border:1px solid rgba(0,255,204,.18);}
.b-read{background:rgba(0,212,255,.07);color:var(--e);border:1px solid rgba(0,212,255,.14);}
.b-replied{background:rgba(255,183,0,.08);color:var(--amber);border:1px solid rgba(255,183,0,.15);}
.b-archived{background:rgba(255,255,255,.03);color:var(--txt3);border:1px solid var(--bd2);}
.b-on{background:rgba(34,197,94,.08);color:var(--green);border:1px solid rgba(34,197,94,.15);}
.b-off{background:rgba(255,255,255,.03);color:var(--txt3);border:1px solid var(--bd2);}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:7px;font-size:.74rem;font-weight:500;border:none;cursor:pointer;transition:all .18s;white-space:nowrap;}
.btn-p{background:var(--e);color:var(--bg);}.btn-p:hover{background:var(--e3);box-shadow:0 0 16px rgba(0,212,255,.3);}
.btn-o{background:rgba(0,212,255,.08);color:var(--e);border:1px solid rgba(0,212,255,.15);}.btn-o:hover{background:rgba(0,212,255,.14);}
.btn-r{background:rgba(255,77,109,.07);color:var(--rose);border:1px solid rgba(255,77,109,.15);}.btn-r:hover{background:rgba(255,77,109,.13);}
.btn-g{background:rgba(34,197,94,.07);color:var(--green);border:1px solid rgba(34,197,94,.15);}.btn-g:hover{background:rgba(34,197,94,.13);}
.btn-ghost{background:rgba(255,255,255,.04);color:var(--txt2);border:1px solid var(--bd2);}.btn-ghost:hover{border-color:var(--e);color:var(--e);}
.btn-sm{padding:4px 9px;font-size:.69rem;}
.btn-full{width:100%;justify-content:center;padding:11px;}

/* FORMS */
.fg{margin-bottom:13px;}
.fr{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.fr3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;}
label.lbl{display:block;font-family:'JetBrains Mono',monospace;font-size:.57rem;letter-spacing:.16em;text-transform:uppercase;color:var(--txt3);margin-bottom:5px;}
input[type=text],input[type=email],input[type=number],input[type=url],input[type=tel],input[type=file],select,textarea{
  width:100%;padding:9px 12px;background:var(--bg3);border:1px solid var(--bd2);border-radius:7px;font-size:.84rem;color:var(--txt);outline:none;transition:border-color .2s;}
input[type=color]{padding:2px 4px;height:38px;cursor:pointer;width:52px;border-radius:7px;border:1px solid var(--bd2);background:var(--bg3);flex-shrink:0;}
input[type=file]{padding:7px 10px;font-size:.78rem;}
input:focus,select:focus,textarea:focus{border-color:var(--e);background:rgba(0,212,255,.02);}
select{-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%233d5068' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:30px;}
textarea{resize:vertical;min-height:78px;line-height:1.6;}
.hint{font-size:.7rem;color:var(--txt3);margin-top:4px;font-family:'JetBrains Mono',monospace;}

/* TOGGLE */
.tog-row{display:flex;align-items:center;justify-content:space-between;padding:10px 13px;background:var(--bg3);border:1px solid var(--bd2);border-radius:8px;gap:12px;}
.tog-lbl{font-size:.81rem;color:var(--txt2);flex:1;}
.tog-lbl small{display:block;font-size:.71rem;color:var(--txt3);margin-top:1px;}
.tog{position:relative;width:38px;height:21px;flex-shrink:0;}
.tog input{opacity:0;width:0;height:0;position:absolute;}
.tog-sl{position:absolute;inset:0;background:var(--surf3);border-radius:21px;cursor:pointer;transition:.25s;border:1px solid var(--bd2);}
.tog-sl::before{content:'';position:absolute;width:15px;height:15px;left:2px;bottom:2px;background:var(--txt3);border-radius:50%;transition:.25s;}
.tog input:checked+.tog-sl{background:var(--e);border-color:var(--e);}
.tog input:checked+.tog-sl::before{transform:translateX(17px);background:var(--bg);}
.tog-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;}

/* ITEM CARDS */
.item-card{background:var(--surf2);border:1px solid var(--bd2);border-radius:9px;padding:15px;margin-bottom:9px;transition:border-color .2s;}
.item-card:hover{border-color:rgba(0,212,255,.18);}
.item-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.item-title{font-family:'Syne',sans-serif;font-size:.9rem;font-weight:700;}
.item-sub{font-size:.77rem;color:var(--txt2);margin-top:2px;}
.item-period{font-family:'JetBrains Mono',monospace;font-size:.63rem;color:var(--e);margin-top:5px;}
.item-actions{display:flex;gap:5px;flex-shrink:0;}
.item-tags{display:flex;flex-wrap:wrap;gap:4px;margin-top:8px;}
.itag{font-family:'JetBrains Mono',monospace;font-size:.6rem;background:rgba(0,212,255,.06);color:var(--e2);border:1px solid rgba(0,212,255,.1);padding:2px 7px;border-radius:3px;}
.ibadge{font-family:'JetBrains Mono',monospace;font-size:.6rem;background:rgba(168,85,247,.07);color:var(--purple);border:1px solid rgba(168,85,247,.15);padding:2px 7px;border-radius:3px;}

/* MODAL */
.modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.72);z-index:400;align-items:flex-start;justify-content:center;padding:20px;backdrop-filter:blur(6px);overflow-y:auto;}
.modal-bg.open{display:flex;}
.modal{background:var(--bg2);border:1px solid var(--bd);border-radius:12px;width:100%;max-width:620px;margin:auto;position:relative;}
.modal-h{padding:16px 20px;border-bottom:1px solid var(--bd2);display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;background:var(--bg2);z-index:1;border-radius:12px 12px 0 0;}
.modal-t{font-family:'Syne',sans-serif;font-size:.88rem;font-weight:700;}
.modal-x{background:none;border:none;font-size:1.2rem;color:var(--txt3);cursor:pointer;padding:2px 7px;border-radius:5px;line-height:1;transition:all .18s;}
.modal-x:hover{background:rgba(255,77,109,.08);color:var(--rose);}
.modal-b{padding:20px;}
.modal-f{padding:13px 20px;border-top:1px solid var(--bd2);display:flex;justify-content:flex-end;gap:8px;}

/* CHART */
.chart{display:flex;align-items:flex-end;gap:5px;height:72px;padding:0 2px;}
.bar-w{flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;}
.bar{width:100%;background:linear-gradient(180deg,var(--e),rgba(0,212,255,.15));border-radius:3px 3px 0 0;min-height:3px;transition:height .5s ease;}
.bar-l{font-family:'JetBrains Mono',monospace;font-size:.53rem;color:var(--txt3);}

/* SECTION DIVIDER */
.sec-div{font-family:'JetBrains Mono',monospace;font-size:.58rem;letter-spacing:.24em;text-transform:uppercase;color:var(--e);margin:20px 0 11px;padding-bottom:7px;border-bottom:1px solid var(--bd3);display:flex;align-items:center;gap:8px;}
.sec-div::before{content:'//';opacity:.5;}

/* PROFILE UPLOAD */
.profile-row{display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap;}
.profile-preview{flex-shrink:0;}
.profile-img{width:90px;height:90px;object-fit:cover;border-radius:12px;border:2px solid rgba(0,212,255,.3);display:block;}
.profile-placeholder{width:90px;height:90px;border-radius:12px;border:2px dashed rgba(0,212,255,.2);background:var(--bg3);display:flex;align-items:center;justify-content:center;font-size:2.2rem;}

/* SOCIAL GRID */
.social-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 14px;}

/* THEME */
.theme-row{display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:start;}
.color-row{display:flex;align-items:center;gap:10px;margin-bottom:6px;}
.swatches{display:flex;gap:6px;flex-wrap:wrap;margin-top:8px;}
.sw{display:inline-block;width:22px;height:22px;border-radius:5px;cursor:pointer;transition:transform .15s,outline .15s;outline:2px solid transparent;outline-offset:2px;}
.sw:hover{transform:scale(1.2);outline-color:rgba(255,255,255,.4);}
.theme-preview-box{min-width:180px;}

/* RESPONSIVE */
@media(max-width:1200px){.cnt-grid{grid-template-columns:repeat(3,1fr);}  .theme-row{grid-template-columns:1fr 1fr;}.theme-preview-box{grid-column:1/-1;}}
@media(max-width:1024px){.stats-row{grid-template-columns:1fr 1fr;}.dash-grid{grid-template-columns:1fr;}}
@media(max-width:768px){
  .sb{transform:translateX(-100%);}.sb.open{transform:translateX(0);}
  .main-w{margin-left:0;}.mob-tog{display:flex;}
  .stats-row,.cnt-grid{grid-template-columns:1fr 1fr;}
  .fr,.fr3,.tog-grid,.social-grid,.theme-row{grid-template-columns:1fr;}
  .pb{padding:14px;}.tb{padding:0 14px;}
  .profile-row{flex-direction:column;}
}
@media(max-width:480px){.stats-row{grid-template-columns:1fr;}.cnt-grid{grid-template-columns:1fr 1fr;}}
</style>
@yield('extra_css')
</head>
<body>
<div class="sb-overlay" id="sb-overlay" onclick="closeSb()"></div>
<aside class="sb" id="sb">
  <div class="sb-brand">
    <div class="sb-mark">D</div>
    <div><div class="sb-bname">Darshan<span>.</span></div><div class="sb-bsub">// portfolio cms</div></div>
  </div>
  <nav class="sb-nav">
    <div class="sb-sec">Overview</div>
    <a href="{{ route('admin.dashboard') }}" class="sb-a {{ request()->routeIs('admin.dashboard')?'on':'' }}"><span class="ico">📊</span> Dashboard</a>
    <a href="{{ route('admin.contacts') }}" class="sb-a {{ request()->routeIs('admin.contacts','admin.contact.show')?'on':'' }}">
      <span class="ico">💬</span> Messages
      @php try{$__nc=\App\Models\Contact::where('status','new')->count();}catch(\Exception $e){$__nc=0;}@endphp
      @if($__nc>0)<span class="sb-badge">{{ $__nc }}</span>@endif
    </a>
    <div class="sb-sec">Portfolio Content</div>
    <a href="{{ route('admin.experiences') }}" class="sb-a {{ request()->routeIs('admin.experiences')?'on':'' }}"><span class="ico">💼</span> Work Experience</a>
    <a href="{{ route('admin.educations') }}" class="sb-a {{ request()->routeIs('admin.educations')?'on':'' }}"><span class="ico">🎓</span> Education</a>
    <a href="{{ route('admin.skills') }}" class="sb-a {{ request()->routeIs('admin.skills')?'on':'' }}"><span class="ico">⚡</span> Skills</a>
    <a href="{{ route('admin.projects') }}" class="sb-a {{ request()->routeIs('admin.projects')?'on':'' }}"><span class="ico">🚀</span> Projects</a>
    <a href="{{ route('admin.upwork') }}" class="sb-a {{ request()->routeIs('admin.upwork')?'on':'' }}"><span class="ico">🟢</span> Upwork Reviews</a>
    <div class="sb-sec">Configuration</div>
    <a href="{{ route('admin.dashboard') }}#settings" class="sb-a"><span class="ico">⚙️</span> General Settings</a>
    <div class="sb-sec">Site</div>
    <a href="{{ route('home') }}" target="_blank" class="sb-a"><span class="ico">🌐</span> View Portfolio</a>
  </nav>
  <div class="sb-foot">
    <form action="{{ route('admin.logout') }}" method="POST">@csrf
      <button class="sb-logout"><span class="ico">🔐</span> Log Out</button>
    </form>
  </div>
</aside>
<div class="main-w">
  <header class="tb">
    <div class="tb-left">
      <button class="mob-tog" onclick="openSb()">☰</button>
      <div class="tb-title">@yield('page_title','Dashboard')</div>
    </div>
    <div class="tb-right">
      <a href="{{ route('home') }}" target="_blank" class="tb-btn">🌐 Live Site</a>
      <div class="tb-av">DP</div>
    </div>
  </header>
  <div class="pb">
    @if(session('success'))<div class="msg-s">✅ {{ session('success') }}</div>@endif
    @if($errors->any())<div class="msg-e">⚠️ {{ $errors->first() }}</div>@endif
    @yield('content')
  </div>
</div>
<script>
function openSb(){document.getElementById('sb').classList.add('open');document.getElementById('sb-overlay').classList.add('open');document.body.style.overflow='hidden';}
function closeSb(){document.getElementById('sb').classList.remove('open');document.getElementById('sb-overlay').classList.remove('open');document.body.style.overflow='';}
function openModal(id){document.getElementById(id).classList.add('open');document.body.style.overflow='hidden';}
function closeModal(id){document.getElementById(id).classList.remove('open');document.body.style.overflow='';}
document.querySelectorAll('.modal-bg').forEach(m=>m.addEventListener('click',e=>{if(e.target===m){m.classList.remove('open');document.body.style.overflow=''}}));
</script>
@yield('scripts')
</body>
</html>
