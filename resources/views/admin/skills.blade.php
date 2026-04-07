@extends('admin.layout')
@section('title','Skills')
@section('page_title','Skills')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
  <div style="font-size:.82rem;color:var(--txt3);">{{ $items->count() }} skill groups</div>
  <button onclick="openModal('modal-add-skill')" class="btn btn-p">➕ Add Skill Group</button>
</div>

<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
@forelse($items as $skill)
<div class="item-card">
  <div class="item-head">
    <div style="flex:1;min-width:0;">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <div class="item-title">{{ $skill->group_label }}</div>
        <span class="badge {{ $skill->is_active ? 'b-on' : 'b-off' }}">{{ $skill->is_active ? 'Active' : 'Hidden' }}</span>
      </div>
      <div class="item-tags" style="margin-top:8px;">
        @foreach($skill->items as $item)<span class="itag">{{ $item }}</span>@endforeach
      </div>
      <div style="font-size:.72rem;color:var(--txt3);margin-top:6px;">{{ count($skill->items) }} skills</div>
    </div>
    <div class="item-actions">
      <button onclick="openModal('modal-edit-sk-{{ $skill->id }}')" class="btn btn-o btn-sm">✏️ Edit</button>
      <form action="{{ route('admin.skill.destroy',$skill) }}" method="POST" onsubmit="return confirm('Delete this skill group?')">@csrf @method('DELETE')
        <button class="btn btn-r btn-sm">🗑</button>
      </form>
    </div>
  </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-bg" id="modal-edit-sk-{{ $skill->id }}">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">✏️ Edit: {{ $skill->group_label }}</div>
    <button class="modal-x" onclick="closeModal('modal-edit-sk-{{ $skill->id }}')">✕</button>
  </div>
  <form action="{{ route('admin.skill.update',$skill) }}" method="POST">
  @csrf @method('PATCH')
  <div class="modal-b">
    <div class="fg"><label class="lbl">Group Label *</label><input type="text" name="group_label" value="{{ $skill->group_label }}" required placeholder="e.g. Frontend"></div>
    <div class="fg">
      <label class="lbl">Skills (comma separated) *</label>
      <textarea name="items" style="min-height:110px;" required>{{ implode(', ',$skill->items) }}</textarea>
      <div class="hint">Separate each skill with a comma: Angular, Vue.js, React</div>
    </div>
    <div class="tog-row">
      <div class="tog-lbl">Show on portfolio<small>Uncheck to hide this group</small></div>
      <label class="tog"><input type="checkbox" name="is_active" value="1" {{ $skill->is_active ? 'checked' : '' }}><span class="tog-sl"></span></label>
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-edit-sk-{{ $skill->id }}')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">💾 Save Changes</button>
  </div>
  </form>
</div>
</div>
@empty
<div style="grid-column:span 2;" class="card"><div class="card-b" style="text-align:center;padding:48px;color:var(--txt3);">No skill groups yet.</div></div>
@endforelse
</div>

{{-- ADD MODAL --}}
<div class="modal-bg" id="modal-add-skill">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">➕ Add Skill Group</div>
    <button class="modal-x" onclick="closeModal('modal-add-skill')">✕</button>
  </div>
  <form action="{{ route('admin.skill.store') }}" method="POST">@csrf
  <div class="modal-b">
    <div class="fg"><label class="lbl">Group Label *</label><input type="text" name="group_label" required placeholder="e.g. Frontend, Backend, Database"></div>
    <div class="fg">
      <label class="lbl">Skills (comma separated) *</label>
      <textarea name="items" style="min-height:100px;" required placeholder="Angular, Vue.js, React, HTML5, CSS3, JavaScript"></textarea>
      <div class="hint">Separate each skill with a comma</div>
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-add-skill')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">➕ Add Group</button>
  </div>
  </form>
</div>
</div>
@endsection
