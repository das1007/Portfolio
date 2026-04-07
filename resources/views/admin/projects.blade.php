@extends('admin.layout')
@section('title','Projects')
@section('page_title','🚀 Projects')
@section('content')

{{-- ADD MODAL --}}
<div class="modal-bg" id="addModal">
  <div class="modal">
    <div class="modal-h"><span class="modal-t">➕ Add New Project</span><button class="modal-x" onclick="closeModal('addModal')">✕</button></div>
    <form action="{{ route('admin.project.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-b">
      <div class="fr">
        <div class="fg"><label class="lbl">Project Title *</label><input type="text" name="title" required placeholder="e.g. E-Commerce Platform"></div>
        <div class="fg"><label class="lbl">Company / Client Name</label><input type="text" name="company_name" placeholder="e.g. Credence Technologies"></div>
      </div>
      <div class="fg">
        <label class="lbl">Company Logo (PNG/JPG/SVG · Max 2MB)</label>
        <input type="file" name="company_logo" accept="image/*" onchange="previewLogo(this,'addLogoPreview')">
        <div id="addLogoPreview" style="margin-top:8px;display:none;"><img src="" style="height:40px;border-radius:6px;border:1px solid var(--bd2);"></div>
      </div>
      <div class="fg"><label class="lbl">Description</label><textarea name="description" placeholder="What did you build? What problem did it solve?"></textarea></div>
      <div class="fg"><label class="lbl">Tech Tags (comma separated)</label><input type="text" name="tags" placeholder="Angular, Node.js, MySQL, AWS"></div>
      <div class="fr">
        <div class="fg"><label class="lbl">Live URL</label><input type="url" name="project_url" placeholder="https://project.com"></div>
        <div class="fg"><label class="lbl">GitHub URL</label><input type="url" name="github_url" placeholder="https://github.com/..."></div>
      </div>
      <div class="tog-row">
        <div class="tog-lbl">⭐ Featured Project<small>Show with highlight badge on portfolio</small></div>
        <label class="tog"><input type="checkbox" name="featured" value="1"><span class="tog-sl"></span></label>
      </div>
    </div>
    <div class="modal-f">
      <button type="button" onclick="closeModal('addModal')" class="btn btn-ghost">Cancel</button>
      <button type="submit" class="btn btn-p">🚀 Add Project</button>
    </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-h">
    <div><div class="card-t">🚀 Projects ({{ $items->count() }})</div><div style="font-size:.7rem;color:var(--txt3);margin-top:2px;">Latest added shows first on portfolio</div></div>
    <button onclick="openModal('addModal')" class="btn btn-p">➕ Add Project</button>
  </div>
  <div class="card-b">
    @forelse($items as $item)
    {{-- EDIT MODAL --}}
    <div class="modal-bg" id="edit{{ $item->id }}">
      <div class="modal">
        <div class="modal-h"><span class="modal-t">✏️ Edit: {{ $item->title }}</span><button class="modal-x" onclick="closeModal('edit{{ $item->id }}')">✕</button></div>
        <form action="{{ route('admin.project.update',$item) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <div class="modal-b">
          <div class="fr">
            <div class="fg"><label class="lbl">Project Title</label><input type="text" name="title" value="{{ $item->title }}" required></div>
            <div class="fg"><label class="lbl">Company / Client Name</label><input type="text" name="company_name" value="{{ $item->company_name }}"></div>
          </div>
          <div class="fg">
            <label class="lbl">Company Logo</label>
            @if($item->company_logo)
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
              <img src="{{ asset('storage/'.$item->company_logo) }}" style="height:36px;border-radius:5px;border:1px solid var(--bd2);">
              <label style="display:flex;align-items:center;gap:5px;font-size:.76rem;color:var(--rose);cursor:pointer;">
                <input type="hidden" name="remove_logo" value="0" id="removeLogo{{ $item->id }}">
                <input type="checkbox" onchange="document.getElementById('removeLogo{{ $item->id }}').value=this.checked?'1':'0'"> Remove logo
              </label>
            </div>
            @endif
            <input type="file" name="company_logo" accept="image/*" onchange="previewLogo(this,'editLogoPreview{{ $item->id }}')">
            <div id="editLogoPreview{{ $item->id }}" style="margin-top:6px;display:none;"><img src="" style="height:36px;border-radius:5px;"></div>
          </div>
          <div class="fg"><label class="lbl">Description</label><textarea name="description">{{ $item->description }}</textarea></div>
          <div class="fg"><label class="lbl">Tech Tags</label><input type="text" name="tags" value="{{ is_array($item->tags)?implode(', ',$item->tags):'' }}"></div>
          <div class="fr">
            <div class="fg"><label class="lbl">Live URL</label><input type="url" name="project_url" value="{{ $item->project_url }}"></div>
            <div class="fg"><label class="lbl">GitHub URL</label><input type="url" name="github_url" value="{{ $item->github_url }}"></div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
            <div class="tog-row"><div class="tog-lbl">⭐ Featured<small>Highlight badge</small></div><label class="tog"><input type="checkbox" name="featured" value="1" {{ $item->featured?'checked':'' }}><span class="tog-sl"></span></label></div>
            <div class="tog-row"><div class="tog-lbl">✅ Active<small>Show on portfolio</small></div><label class="tog"><input type="checkbox" name="is_active" value="1" {{ $item->is_active?'checked':'' }}><span class="tog-sl"></span></label></div>
          </div>
        </div>
        <div class="modal-f">
          <button type="button" onclick="closeModal('edit{{ $item->id }}')" class="btn btn-ghost">Cancel</button>
          <button type="submit" class="btn btn-p">💾 Save Changes</button>
        </div>
        </form>
      </div>
    </div>

    <div class="item-card">
      <div class="item-head">
        <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
          {{-- Logo or placeholder --}}
          <div style="width:44px;height:44px;border-radius:8px;background:var(--bg3);border:1px solid var(--bd2);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
            @if($item->company_logo)
              <img src="{{ asset('storage/'.$item->company_logo) }}" style="width:100%;height:100%;object-fit:contain;padding:4px;">
            @else
              <span style="font-size:1.1rem;">🚀</span>
            @endif
          </div>
          <div style="min-width:0;">
            <div class="item-title" style="display:flex;align-items:center;gap:6px;">
              {{ $item->title }}
              @if($item->featured)<span class="badge" style="background:rgba(255,183,0,.1);color:var(--amber);border:1px solid rgba(255,183,0,.2);font-size:.52rem;">⭐ Featured</span>@endif
              @if(!$item->is_active)<span class="badge b-off">Hidden</span>@endif
            </div>
            @if($item->company_name)<div class="item-sub">🏢 {{ $item->company_name }}</div>@endif
            @if($item->description)<div style="font-size:.75rem;color:var(--txt3);margin-top:4px;">{{ \Str::limit($item->description,80) }}</div>@endif
          </div>
        </div>
        <div class="item-actions">
          @if($item->project_url)<a href="{{ $item->project_url }}" target="_blank" class="btn btn-ghost btn-sm" title="View Live">🔗</a>@endif
          @if($item->github_url)<a href="{{ $item->github_url }}" target="_blank" class="btn btn-ghost btn-sm" title="GitHub">🐙</a>@endif
          <button onclick="openModal('edit{{ $item->id }}')" class="btn btn-o btn-sm">✏️ Edit</button>
          <form method="POST" action="{{ route('admin.project.destroy',$item) }}" onsubmit="return confirm('Delete this project?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-r btn-sm">🗑</button>
          </form>
        </div>
      </div>
      @if($item->tags && count($item->tags)>0)
      <div class="item-tags" style="margin-top:10px;">@foreach($item->tags as $t)<span class="itag">{{ $t }}</span>@endforeach</div>
      @endif
    </div>
    @empty
    <div style="text-align:center;padding:48px 24px;color:var(--txt3);">
      <div style="font-size:2.5rem;margin-bottom:12px;">🚀</div>
      <div style="font-family:'Syne',sans-serif;font-size:.9rem;font-weight:700;margin-bottom:6px;">No projects yet</div>
      <div style="font-size:.78rem;margin-bottom:16px;">Add your first project to showcase your work</div>
      <button onclick="openModal('addModal')" class="btn btn-p">➕ Add First Project</button>
    </div>
    @endforelse
  </div>
</div>
@endsection
@section('scripts')
<script>
function previewLogo(input, previewId) {
  if (!input.files || !input.files[0]) return;
  const r = new FileReader();
  r.onload = e => {
    const wrap = document.getElementById(previewId);
    if (wrap) { wrap.style.display = 'block'; wrap.querySelector('img').src = e.target.result; }
  };
  r.readAsDataURL(input.files[0]);
}
</script>
@endsection
