@extends('admin.layout')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('content')

<div class="stats-row">
  <div class="stat c1"><div><div class="stat-label">Total Messages</div><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-sub">All time</div></div><div class="stat-ico">💬</div></div>
  <div class="stat c2"><div><div class="stat-label">Unread</div><div class="stat-num">{{ $stats['new'] }}</div><div class="stat-sub">Need attention</div></div><div class="stat-ico">🔔</div></div>
  <div class="stat c3"><div><div class="stat-label">Replied</div><div class="stat-num">{{ $stats['replied'] }}</div><div class="stat-sub">Completed</div></div><div class="stat-ico">✅</div></div>
  <div class="stat c4"><div><div class="stat-label">Upwork Rating</div><div class="stat-num" style="font-size:1.4rem;padding-top:4px;">⭐ {{ $s['upwork_rating']??'5.0' }}</div><div class="stat-sub">{{ $s['job_success']??'100%' }} success</div></div><div class="stat-ico">🚀</div></div>
</div>

<div class="dash-grid">
  <div class="card">
    <div class="card-h"><span class="card-t">💬 Recent Messages</span><a href="{{ route('admin.contacts') }}" class="btn btn-ghost btn-sm">View All →</a></div>
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>From</th><th>Subject</th><th>Type</th><th>Status</th><th>When</th><th style="text-align:right">Action</th></tr></thead>
        <tbody>
          @forelse($recent as $c)
          <tr>
            <td><div style="font-weight:600;font-size:.82rem;">{{ $c->name }}</div><div style="font-size:.71rem;color:var(--txt3);">{{ $c->email }}</div></td>
            <td style="max-width:160px;">@if($c->status==='new')<span style="color:var(--rose);margin-right:3px;">●</span>@endif{{ \Str::limit($c->subject,32) }}</td>
            <td><span class="badge b-read" style="font-size:.58rem;">{{ ucfirst($c->type) }}</span></td>
            <td><span class="badge b-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
            <td style="font-size:.72rem;color:var(--txt3);white-space:nowrap;">{{ $c->created_at->diffForHumans() }}</td>
            <td style="text-align:right"><a href="{{ route('admin.contact.show',$c) }}" class="btn btn-o btn-sm">View</a></td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:36px;color:var(--txt3);">No messages yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div>
    <div class="card">
      <div class="card-h"><span class="card-t">📈 Last 7 Days</span></div>
      <div class="card-b" style="padding:14px 16px;">
        <div class="chart" id="chart">
          @php $max=max(array_column($chartData,'count')?:[1]);if(!$max)$max=1;@endphp
          @foreach($chartData as $d)
          <div class="bar-w"><div class="bar" data-h="{{ max(4,round(($d['count']/$max)*60)) }}" style="height:4px;" title="{{ $d['count'] }} msg"></div><div class="bar-l">{{ $d['label'] }}</div></div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-h"><span class="card-t">⚡ Quick Actions</span></div>
      <div class="card-b" style="padding:12px 14px;display:flex;flex-direction:column;gap:7px;">
        <a href="{{ route('admin.contacts') }}?status=new" class="btn btn-p btn-full">🔔 Unread @if($stats['new']>0)({{ $stats['new'] }})@endif</a>
        <a href="{{ route('admin.experiences') }}" class="btn btn-o btn-full">💼 Experience</a>
        <a href="{{ route('admin.projects') }}" class="btn btn-g btn-full">🚀 Projects</a>
        <a href="{{ route('admin.upwork') }}" class="btn btn-ghost btn-full">🟢 Reviews</a>
      </div>
    </div>
  </div>
</div>

{{-- CONTENT OVERVIEW --}}
<div class="cnt-grid">
  @php $cs=[
    ['icon'=>'💼','label'=>'Experiences','count'=>\App\Models\Experience::count(),'active'=>\App\Models\Experience::where('is_active',true)->count(),'route'=>'admin.experiences'],
    ['icon'=>'🎓','label'=>'Education','count'=>\App\Models\Education::count(),'active'=>\App\Models\Education::where('is_active',true)->count(),'route'=>'admin.educations'],
    ['icon'=>'⚡','label'=>'Skills','count'=>\App\Models\Skill::count(),'active'=>\App\Models\Skill::where('is_active',true)->count(),'route'=>'admin.skills'],
    ['icon'=>'🚀','label'=>'Projects','count'=>\App\Models\Project::count(),'active'=>\App\Models\Project::where('is_active',true)->count(),'route'=>'admin.projects'],
    ['icon'=>'🟢','label'=>'Reviews','count'=>\App\Models\UpworkReview::count(),'active'=>\App\Models\UpworkReview::where('is_active',true)->count(),'route'=>'admin.upwork'],
  ];@endphp
  @foreach($cs as $c)
  <a href="{{ route($c['route']) }}" style="display:block;">
    <div class="cnt-card" onmouseover="this.style.borderColor='rgba(0,212,255,.22)'" onmouseout="this.style.borderColor='rgba(255,255,255,.05)'">
      <div style="font-size:1.4rem;margin-bottom:8px;">{{ $c['icon'] }}</div>
      <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;line-height:1;color:var(--e);">{{ $c['count'] }}</div>
      <div style="font-size:.77rem;color:var(--txt2);margin-top:3px;">{{ $c['label'] }}</div>
      <div style="font-family:'JetBrains Mono',monospace;font-size:.6rem;color:var(--txt3);margin-top:2px;">{{ $c['active'] }} active</div>
    </div>
  </a>
  @endforeach
</div>

{{-- SETTINGS --}}
<div id="settings"></div>
<div class="card" style="border-color:rgba(0,212,255,.15);">
  <div class="card-h" style="background:rgba(0,212,255,.03);">
    <div><div class="card-t">⚙️ General Portfolio Settings</div><div style="font-family:'JetBrains Mono',monospace;font-size:.58rem;color:var(--txt3);margin-top:2px;">Changes reflect instantly on your live portfolio</div></div>
    <span class="badge b-on">Live CMS</span>
  </div>
  <form action="{{ route('admin.settings.save') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="card-b">

    {{-- 1. PROFILE IMAGE --}}
    <div class="sec-div">👤 Profile Image</div>
    <div class="profile-row">
      <div id="imgWrap" class="profile-preview">
        @if(!empty($s['profile_image']))
          <img id="imgPreview" src="{{ asset('storage/'.$s['profile_image']) }}" class="profile-img" alt="Profile">
        @else
          <div id="imgPreview" class="profile-placeholder">👤</div>
        @endif
      </div>
      <div style="flex:1;min-width:200px;">
        <label class="lbl">Upload Photo (JPG/PNG/WebP · Max 3MB)</label>
        <input type="file" name="profile_image" id="profileInput" accept="image/*" onchange="previewImg(this)" style="margin-bottom:5px;">
        <div class="hint">Displayed in About section on portfolio</div>
        @if(!empty($s['profile_image']))
        <label style="display:inline-flex;align-items:center;gap:6px;margin-top:9px;cursor:pointer;font-size:.78rem;color:var(--rose);">
          <input type="hidden" name="remove_profile_image" value="0" id="removeHidden">
          <input type="checkbox" id="removeChk" onchange="document.getElementById('removeHidden').value=this.checked?'1':'0'">
          Remove current photo
        </label>
        @endif
      </div>
    </div>

    {{-- 2. VISIBILITY --}}
    <div class="sec-div" style="margin-top:22px;">👁 Section Visibility</div>
    <div class="tog-grid">
      @foreach([
        ['available_for_work','🟢 Available Badge','Shows "Available" on hero'],
        ['show_experience','💼 Experience','Work history'],
        ['show_education','🎓 Education','Academic background'],
        ['show_skills','⚡ Skills','Technical skills'],
        ['show_projects','🚀 Projects','Project showcase'],
        ['show_upwork','🟢 Upwork','Reviews & stats'],
        ['show_contact','✉️ Contact','Contact form'],
      ] as [$key,$label,$hint])
      <div class="tog-row"><div class="tog-lbl">{{ $label }}<small>{{ $hint }}</small></div><label class="tog"><input type="checkbox" name="{{ $key }}" value="1" {{ ($s[$key]??'1')==='1'?'checked':'' }}><span class="tog-sl"></span></label></div>
      @endforeach
    </div>

    {{-- 3. PERSONAL INFO --}}
    <div class="sec-div" style="margin-top:22px;">👨‍💻 Personal Information</div>
    <div class="fr">
      <div class="fg"><label class="lbl">Full Name</label><input type="text" name="full_name" value="{{ $s['full_name']??'' }}"></div>
      <div class="fg"><label class="lbl">Email</label><input type="email" name="email" value="{{ $s['email']??'' }}"></div>
      <div class="fg"><label class="lbl">Phone / WhatsApp</label><input type="tel" name="phone" value="{{ $s['phone']??'' }}"></div>
      <div class="fg"><label class="lbl">Location</label><input type="text" name="location" value="{{ $s['location']??'' }}"></div>
    </div>

    {{-- 4. HERO --}}
    <div class="sec-div" style="margin-top:8px;">🚀 Hero Section</div>
    <div class="fg"><label class="lbl">Availability Badge Text</label><input type="text" name="availability_text" value="{{ $s['availability_text']??'' }}"></div>
    <div class="fg"><label class="lbl">Hero Tagline</label><textarea name="hero_tagline">{{ $s['hero_tagline']??'' }}</textarea></div>
    <div class="fr">
      <div class="fg"><label class="lbl">Years Experience</label><input type="text" name="years_experience" value="{{ $s['years_experience']??'5+' }}"></div>
      <div class="fg"><label class="lbl">Projects Count</label><input type="text" name="projects_count" value="{{ $s['projects_count']??'20+' }}"></div>
    </div>

    {{-- 5. ABOUT --}}
    <div class="sec-div" style="margin-top:8px;">📝 About Section</div>
    <div class="fg"><label class="lbl">About Me Text (supports &lt;strong&gt; HTML)</label><textarea name="about_text" style="min-height:110px;">{{ $s['about_text']??'' }}</textarea></div>

    {{-- 6. UPWORK --}}
    <div class="sec-div" style="margin-top:8px;">🟢 Upwork Section</div>
    <div class="fr3">
      <div class="fg"><label class="lbl">Rating</label><input type="text" name="upwork_rating" value="{{ $s['upwork_rating']??'5.0' }}"></div>
      <div class="fg"><label class="lbl">Job Success %</label><input type="text" name="job_success" value="{{ $s['job_success']??'100%' }}"></div>
      <div class="fg"><label class="lbl">Section Title</label><input type="text" name="upwork_section_title" value="{{ $s['upwork_section_title']??'' }}"></div>
    </div>
    <div class="fg"><label class="lbl">Section Description</label><textarea name="upwork_section_desc">{{ $s['upwork_section_desc']??'' }}</textarea></div>

    {{-- 7. SOCIAL MEDIA --}}
    <div class="sec-div" style="margin-top:8px;">🌐 Social Media & Profile Links</div>
    <div class="social-grid">
      @foreach([
        ['linkedin_url','🔗 LinkedIn','https://linkedin.com/in/...'],
        ['github_url','🐙 GitHub','https://github.com/...'],
        ['stackoverflow_url','📚 Stack Overflow','https://stackoverflow.com/...'],
        ['upwork_url','🟢 Upwork','https://upwork.com/freelancers/...'],
        ['twitter_url','🐦 Twitter / X','https://x.com/...'],
        ['instagram_url','📸 Instagram','https://instagram.com/...'],
        ['youtube_url','▶️ YouTube','https://youtube.com/@...'],
        ['dribbble_url','🎨 Dribbble','https://dribbble.com/...'],
        ['behance_url','✏️ Behance','https://behance.net/...'],
        ['devto_url','💻 Dev.to','https://dev.to/...'],
        ['medium_url','📖 Medium','https://medium.com/@...'],
        ['website_url','🌐 Website','https://yoursite.com'],
      ] as [$field,$label,$ph])
      <div class="fg" style="margin-bottom:0;">
        <label class="lbl">{{ $label }}</label>
        <input type="url" name="{{ $field }}" value="{{ $s[$field]??'' }}" placeholder="{{ $ph }}">
      </div>
      @endforeach
    </div>

    {{-- 8. THEME —  Accent + Background --}}
    <div class="sec-div" style="margin-top:8px;">🎨 Theme & Colors</div>
    <div class="theme-row">
      <div>
        <label class="lbl">Accent Color</label>
        <div class="color-row">
          <input type="color" name="accent_color" id="accentPicker" value="{{ $s['accent_color']??'#00d4ff' }}">
          <input type="text" id="accentHex" value="{{ $s['accent_color']??'#00d4ff' }}" style="font-family:'JetBrains Mono',monospace;font-size:.78rem;" oninput="syncColor('accentPicker',this.value)">
        </div>
        <div class="hint">Buttons · links · glows · highlights</div>
        <div class="swatches">
          @foreach(['#00d4ff','#6366f1','#a855f7','#ec4899','#f97316','#22c55e','#eab308','#f43f5e'] as $hex)
          <span class="sw" style="background:{{ $hex }};" onclick="pickColor('accentPicker','accentHex','{{ $hex }}')"></span>
          @endforeach
        </div>
      </div>
      <div>
        <label class="lbl">Background Color</label>
        <div class="color-row">
          <input type="color" name="bg_color" id="bgPicker" value="{{ $s['bg_color']??'#060a12' }}">
          <input type="text" id="bgHex" value="{{ $s['bg_color']??'#060a12' }}" style="font-family:'JetBrains Mono',monospace;font-size:.78rem;" oninput="syncColor('bgPicker',this.value)">
        </div>
        <div class="hint">Page background color</div>
        <div class="swatches">
          @foreach(['#060a12','#080c10','#0a0e18','#060606','#0c1220','#0f172a','#0a0a14','#050508'] as $hex)
          <span class="sw" style="background:{{ $hex }};border:1px solid rgba(255,255,255,.15);" onclick="pickColor('bgPicker','bgHex','{{ $hex }}')"></span>
          @endforeach
        </div>
      </div>
      <div class="theme-preview-box">
        <label class="lbl">Live Preview</label>
        <div id="themePreview" style="background:{{ $s['bg_color']??'#060a12' }};border-radius:8px;padding:14px 16px;border:1px solid rgba(255,255,255,.08);">
          <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:.95rem;color:#e2eaf8;">{{ $s['full_name']??'Your Name' }}<span id="tp-dot" style="color:{{ $s['accent_color']??'#00d4ff' }};">.</span></div>
          <div id="tp-badge" style="display:inline-flex;align-items:center;gap:5px;font-size:.6rem;font-family:monospace;padding:3px 9px;border-radius:3px;margin:6px 0 10px;color:{{ $s['accent_color']??'#00d4ff' }};border:1px solid {{ $s['accent_color']??'#00d4ff' }}44;background:{{ $s['accent_color']??'#00d4ff' }}18;">● Available</div>
          <div style="display:flex;gap:6px;">
            <span id="tp-btn" style="background:{{ $s['accent_color']??'#00d4ff' }};color:#050a0f;padding:5px 14px;border-radius:4px;font-size:.73rem;font-weight:700;">Hire Me</span>
            <span style="border:1px solid rgba(255,255,255,.12);color:rgba(226,234,248,.7);padding:5px 14px;border-radius:4px;font-size:.73rem;">View Work</span>
          </div>
          <div style="font-size:.55rem;font-family:monospace;color:#3d5068;margin-top:8px;">// updates live as you pick colors</div>
        </div>
      </div>
    </div>

    <div style="display:flex;gap:10px;margin-top:18px;flex-wrap:wrap;">
      <button type="submit" class="btn btn-p" style="padding:12px 28px;font-size:.85rem;font-weight:700;">💾 Save All Settings</button>
      <a href="{{ route('home') }}" target="_blank" class="btn btn-ghost" style="padding:12px 20px;">🌐 Preview Portfolio</a>
    </div>
  </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('accentPicker').addEventListener('input',function(){document.getElementById('accentHex').value=this.value;updatePreview();});
document.getElementById('bgPicker').addEventListener('input',function(){document.getElementById('bgHex').value=this.value;updatePreview();});
function syncColor(id,val){if(/^#[0-9a-fA-F]{6}$/.test(val)){document.getElementById(id).value=val;updatePreview();}}
function pickColor(pid,hid,val){document.getElementById(pid).value=val;document.getElementById(hid).value=val;updatePreview();}
function updatePreview(){
  const ac=document.getElementById('accentPicker').value;
  const bg=document.getElementById('bgPicker').value;
  document.getElementById('themePreview').style.background=bg;
  document.getElementById('tp-dot').style.color=ac;
  document.getElementById('tp-btn').style.background=ac;
  document.getElementById('tp-badge').style.color=ac;
  document.getElementById('tp-badge').style.borderColor=ac+'44';
  document.getElementById('tp-badge').style.background=ac+'18';
}
function previewImg(input){
  if(!input.files||!input.files[0])return;
  const r=new FileReader();
  r.onload=e=>{document.getElementById('imgWrap').innerHTML='<img id="imgPreview" src="'+e.target.result+'" class="profile-img" style="border-color:rgba(0,212,255,.5);">';};
  r.readAsDataURL(input.files[0]);
}
setTimeout(()=>document.querySelectorAll('.bar[data-h]').forEach(b=>b.style.height=b.dataset.h+'px'),200);
</script>
@endsection
