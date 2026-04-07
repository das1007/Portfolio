@extends('admin.layout')
@section('title','Education')
@section('page_title','Education')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
  <div style="font-size:.82rem;color:var(--txt3);">{{ $items->count() }} total · {{ $items->where('is_active',true)->count() }} visible</div>
  <button onclick="openModal('modal-add-edu')" class="btn btn-p">➕ Add Education</button>
</div>

@forelse($items as $edu)
<div class="item-card">
  <div class="item-head">
    <div style="flex:1;min-width:0;">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <span style="font-size:1.5rem;">{{ $edu->emoji }}</span>
        <div>
          <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            <div class="item-title">{{ $edu->degree }}</div>
            <span class="badge {{ $edu->is_active ? 'b-on' : 'b-off' }}">{{ $edu->is_active ? 'Active' : 'Hidden' }}</span>
          </div>
          <div class="item-sub">{{ $edu->institution }} @if($edu->location)· {{ $edu->location }}@endif</div>
          <div class="item-period">📅 {{ $edu->period_start }}@if($edu->period_end) — {{ $edu->period_end }}@endif</div>
        </div>
      </div>
      @if($edu->badges && count($edu->badges) > 0)
      <div class="item-tags">@foreach($edu->badges as $b)<span class="ibadge">{{ $b }}</span>@endforeach</div>
      @endif
    </div>
    <div class="item-actions">
      <button onclick="openModal('modal-edit-edu-{{ $edu->id }}')" class="btn btn-o btn-sm">✏️ Edit</button>
      <form action="{{ route('admin.education.destroy',$edu) }}" method="POST" onsubmit="return confirm('Delete this education?')">@csrf @method('DELETE')
        <button class="btn btn-r btn-sm">🗑</button>
      </form>
    </div>
  </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-bg" id="modal-edit-edu-{{ $edu->id }}">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">✏️ Edit: {{ $edu->degree }}</div>
    <button class="modal-x" onclick="closeModal('modal-edit-edu-{{ $edu->id }}')">✕</button>
  </div>
  <form action="{{ route('admin.education.update',$edu) }}" method="POST">
  @csrf @method('PATCH')
  <div class="modal-b">
    <div class="fr">
      <div class="fg"><label class="lbl">Emoji Icon</label><input type="text" name="emoji" value="{{ $edu->emoji }}" placeholder="🎓" style="font-size:1.2rem;"></div>
    </div>
    <div class="fg"><label class="lbl">Degree / Qualification *</label><input type="text" name="degree" value="{{ $edu->degree }}" required placeholder="e.g. MBA in AI & Data Science"></div>
    <div class="fg"><label class="lbl">Institution / University *</label><input type="text" name="institution" value="{{ $edu->institution }}" required></div>
    <div class="fr">
      <div class="fg"><label class="lbl">Location</label><input type="text" name="location" value="{{ $edu->location }}"></div>
    </div>
    <div class="fr">
      <div class="fg"><label class="lbl">Start (e.g. 09/2023)</label><input type="text" name="period_start" value="{{ $edu->period_start }}" required placeholder="MM/YYYY"></div>
      <div class="fg"><label class="lbl">End (e.g. 06/2024)</label><input type="text" name="period_end" value="{{ $edu->period_end }}" placeholder="MM/YYYY"></div>
    </div>
    <div class="fg">
      <label class="lbl">Badges / Subjects (comma separated)</label>
      <input type="text" name="badges" value="{{ $edu->badges ? implode(', ',$edu->badges) : '' }}" placeholder="AI, Data Science, Machine Learning">
    </div>
    <div class="tog-row">
      <div class="tog-lbl">Show on portfolio<small>Uncheck to hide</small></div>
      <label class="tog"><input type="checkbox" name="is_active" value="1" {{ $edu->is_active ? 'checked' : '' }}><span class="tog-sl"></span></label>
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-edit-edu-{{ $edu->id }}')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">💾 Save Changes</button>
  </div>
  </form>
</div>
</div>
@empty
<div class="card"><div class="card-b" style="text-align:center;padding:48px;color:var(--txt3);">No education entries. Click "Add Education".</div></div>
@endforelse

{{-- ADD MODAL --}}
<div class="modal-bg" id="modal-add-edu">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">➕ Add Education</div>
    <button class="modal-x" onclick="closeModal('modal-add-edu')">✕</button>
  </div>
  <form action="{{ route('admin.education.store') }}" method="POST">@csrf
  <div class="modal-b">
    <div class="fg"><label class="lbl">Emoji Icon</label><input type="text" name="emoji" value="🎓" style="font-size:1.2rem;width:80px;"></div>
    <div class="fg"><label class="lbl">Degree / Qualification *</label><input type="text" name="degree" required placeholder="e.g. MBA in AI & Data Science"></div>
    <div class="fg"><label class="lbl">Institution / University *</label><input type="text" name="institution" required placeholder="e.g. Paris Business School"></div>
    <div class="fr">
      <div class="fg"><label class="lbl">Location</label><input type="text" name="location" placeholder="e.g. Paris, France"></div>
    </div>
    <div class="fr">
      <div class="fg"><label class="lbl">Start (MM/YYYY)</label><input type="text" name="period_start" required placeholder="09/2023"></div>
      <div class="fg"><label class="lbl">End (MM/YYYY)</label><input type="text" name="period_end" placeholder="06/2024"></div>
    </div>
    <div class="fg">
      <label class="lbl">Badges / Subjects (comma separated)</label>
      <input type="text" name="badges" placeholder="AI, Machine Learning, Analytics">
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-add-edu')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">➕ Add Education</button>
  </div>
  </form>
</div>
</div>
@endsection
