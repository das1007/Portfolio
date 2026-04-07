@extends('admin.layout')
@section('title','Work Experience')
@section('page_title','Work Experience')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
  <div>
    <div style="font-size:.82rem;color:var(--txt3);">{{ $items->count() }} total · {{ $items->where('is_active',true)->count() }} visible</div>
  </div>
  <button onclick="openModal('modal-add')" class="btn btn-p">➕ Add Experience</button>
</div>

@forelse($items as $exp)
<div class="item-card">
  <div class="item-head">
    <div style="flex:1;min-width:0;">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <div class="item-title">{{ $exp->role }}</div>
        <span class="badge {{ $exp->is_active ? 'b-on' : 'b-off' }}">{{ $exp->is_active ? 'Active' : 'Hidden' }}</span>
      </div>
      <div class="item-sub">{{ $exp->company }} @if($exp->location)· {{ $exp->location }}@endif</div>
      <div class="item-period">📅 {{ $exp->period_start }} — {{ $exp->period_end }}</div>
      @if($exp->bullets && count($exp->bullets) > 0)
      <div style="font-size:.77rem;color:var(--txt3);margin-top:6px;">{{ count($exp->bullets) }} bullet points</div>
      @endif
      @if($exp->tags && count($exp->tags) > 0)
      <div class="item-tags">@foreach($exp->tags as $t)<span class="itag">{{ $t }}</span>@endforeach</div>
      @endif
    </div>
    <div class="item-actions">
      <button onclick="openModal('modal-edit-{{ $exp->id }}')" class="btn btn-o btn-sm">✏️ Edit</button>
      <form action="{{ route('admin.experience.destroy',$exp) }}" method="POST" onsubmit="return confirm('Delete this experience?')">@csrf @method('DELETE')
        <button class="btn btn-r btn-sm">🗑</button>
      </form>
    </div>
  </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-bg" id="modal-edit-{{ $exp->id }}">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">✏️ Edit: {{ $exp->role }}</div>
    <button class="modal-x" onclick="closeModal('modal-edit-{{ $exp->id }}')">✕</button>
  </div>
  <form action="{{ route('admin.experience.update',$exp) }}" method="POST">
  @csrf @method('PATCH')
  <div class="modal-b">
    <div class="fr">
      <div class="fg"><label class="lbl">Job Title / Role *</label><input type="text" name="role" value="{{ $exp->role }}" required></div>
      <div class="fg"><label class="lbl">Company *</label><input type="text" name="company" value="{{ $exp->company }}" required></div>
      <div class="fg"><label class="lbl">Location</label><input type="text" name="location" value="{{ $exp->location }}"></div>
    </div>
    <div class="fr">
      <div class="fg"><label class="lbl">Start (e.g. 12/2021)</label><input type="text" name="period_start" value="{{ $exp->period_start }}" required></div>
      <div class="fg"><label class="lbl">End (leave blank = Present)</label><input type="text" name="period_end" value="{{ $exp->period_end === 'Present' ? '' : $exp->period_end }}" placeholder="Present"></div>
    </div>
    <div class="fg"><label class="lbl">Description (short summary)</label><textarea name="description">{{ $exp->description }}</textarea></div>
    <div class="fg">
      <label class="lbl">Bullet Points (one per line)</label>
      <textarea name="bullets" style="min-height:120px;">{{ $exp->bullets ? implode("\n",$exp->bullets) : '' }}</textarea>
      <div class="hint">Each new line = one bullet point</div>
    </div>
    <div class="fg">
      <label class="lbl">Tech Tags (comma separated)</label>
      <input type="text" name="tags" value="{{ $exp->tags ? implode(', ',$exp->tags) : '' }}" placeholder="Angular, Node.js, MySQL">
    </div>
    <div class="tog-row" style="margin-top:4px;">
      <div class="tog-lbl">Show on portfolio<small>Uncheck to hide this entry</small></div>
      <label class="tog"><input type="checkbox" name="is_active" value="1" {{ $exp->is_active ? 'checked' : '' }}><span class="tog-sl"></span></label>
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-edit-{{ $exp->id }}')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">💾 Save Changes</button>
  </div>
  </form>
</div>
</div>
@empty
<div class="card"><div class="card-b" style="text-align:center;padding:48px;color:var(--txt3);">No experiences yet. Click "Add Experience" to get started.</div></div>
@endforelse

{{-- ADD MODAL --}}
<div class="modal-bg" id="modal-add">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">➕ Add New Experience</div>
    <button class="modal-x" onclick="closeModal('modal-add')">✕</button>
  </div>
  <form action="{{ route('admin.experience.store') }}" method="POST">
  @csrf
  <div class="modal-b">
    <div class="fr">
      <div class="fg"><label class="lbl">Job Title / Role *</label><input type="text" name="role" required placeholder="e.g. Full-Stack Developer"></div>
      <div class="fg"><label class="lbl">Company *</label><input type="text" name="company" required placeholder="e.g. Credence Technologies"></div>
      <div class="fg"><label class="lbl">Location</label><input type="text" name="location" placeholder="e.g. Surat, India"></div>
    </div>
    <div class="fr">
      <div class="fg"><label class="lbl">Start (e.g. 12/2021)</label><input type="text" name="period_start" required placeholder="MM/YYYY"></div>
      <div class="fg"><label class="lbl">End (blank = Present)</label><input type="text" name="period_end" placeholder="Present"></div>
    </div>
    <div class="fg"><label class="lbl">Description (short summary)</label><textarea name="description" placeholder="Brief description..."></textarea></div>
    <div class="fg">
      <label class="lbl">Bullet Points (one per line)</label>
      <textarea name="bullets" style="min-height:120px;" placeholder="Integrated third-party APIs to enhance UX&#10;Built responsive Angular interfaces&#10;Managed MySQL and MongoDB databases"></textarea>
      <div class="hint">Each new line = one bullet point</div>
    </div>
    <div class="fg">
      <label class="lbl">Tech Tags (comma separated)</label>
      <input type="text" name="tags" placeholder="Angular, Node.js, MySQL, MongoDB">
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-add')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">➕ Add Experience</button>
  </div>
  </form>
</div>
</div>
@endsection
