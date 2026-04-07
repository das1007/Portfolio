@extends('admin.layout')
@section('title','Upwork Reviews')
@section('page_title','Upwork Reviews')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
  <div>
    <div style="font-size:.82rem;color:var(--txt3);">{{ $items->count() }} reviews · {{ $items->where('is_active',true)->count() }} visible</div>
  </div>
  <button onclick="openModal('modal-add-review')" class="btn btn-p">➕ Add Review</button>
</div>

@forelse($items as $review)
<div class="item-card">
  <div class="item-head">
    <div style="flex:1;min-width:0;">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
        <div style="color:var(--amber);font-size:.95rem;letter-spacing:2px;">{{ str_repeat('★',$review->rating) }}{{ str_repeat('☆',5-$review->rating) }}</div>
        <span class="badge {{ $review->is_active ? 'b-on' : 'b-off' }}">{{ $review->is_active ? 'Visible' : 'Hidden' }}</span>
      </div>
      <div style="font-size:.82rem;color:var(--txt2);line-height:1.7;font-style:italic;margin-bottom:6px;">"{{ \Str::limit($review->review_text, 120) }}"</div>
      <div style="font-size:.74rem;color:var(--txt3);font-family:'JetBrains Mono',monospace;">— {{ $review->reviewer }} @if($review->project_type)· {{ $review->project_type }}@endif</div>
    </div>
    <div class="item-actions">
      <button onclick="openModal('modal-edit-rv-{{ $review->id }}')" class="btn btn-o btn-sm">✏️ Edit</button>
      <form action="{{ route('admin.upwork.destroy',$review) }}" method="POST" onsubmit="return confirm('Delete this review?')">@csrf @method('DELETE')
        <button class="btn btn-r btn-sm">🗑</button>
      </form>
    </div>
  </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-bg" id="modal-edit-rv-{{ $review->id }}">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">✏️ Edit Review</div>
    <button class="modal-x" onclick="closeModal('modal-edit-rv-{{ $review->id }}')">✕</button>
  </div>
  <form action="{{ route('admin.upwork.update',$review) }}" method="POST">@csrf @method('PATCH')
  <div class="modal-b">
    <div class="fr">
      <div class="fg"><label class="lbl">Reviewer Name</label><input type="text" name="reviewer" value="{{ $review->reviewer }}" placeholder="Upwork Client"></div>
      <div class="fg"><label class="lbl">Project Type</label><input type="text" name="project_type" value="{{ $review->project_type }}" placeholder="Full-Stack Project"></div>
    </div>
    <div class="fg">
      <label class="lbl">Review Text *</label>
      <textarea name="review_text" style="min-height:100px;" required>{{ $review->review_text }}</textarea>
    </div>
    <div class="fg">
      <label class="lbl">Rating (1–5)</label>
      <select name="rating">
        @for($i=5;$i>=1;$i--)
        <option value="{{ $i }}" {{ $review->rating==$i?'selected':'' }}>{{ str_repeat('★',$i) }} {{ $i }}/5</option>
        @endfor
      </select>
    </div>
    <div class="tog-row">
      <div class="tog-lbl">Show on portfolio<small>Uncheck to hide this review</small></div>
      <label class="tog"><input type="checkbox" name="is_active" value="1" {{ $review->is_active ? 'checked' : '' }}><span class="tog-sl"></span></label>
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-edit-rv-{{ $review->id }}')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">💾 Save</button>
  </div>
  </form>
</div>
</div>
@empty
<div class="card"><div class="card-b" style="text-align:center;padding:48px;color:var(--txt3);">No reviews yet. Add your Upwork client reviews above.</div></div>
@endforelse

{{-- ADD MODAL --}}
<div class="modal-bg" id="modal-add-review">
<div class="modal">
  <div class="modal-h">
    <div class="modal-t">➕ Add Upwork Review</div>
    <button class="modal-x" onclick="closeModal('modal-add-review')">✕</button>
  </div>
  <form action="{{ route('admin.upwork.store') }}" method="POST">@csrf
  <div class="modal-b">
    <div class="fr">
      <div class="fg"><label class="lbl">Reviewer Name</label><input type="text" name="reviewer" placeholder="Upwork Client"></div>
      <div class="fg"><label class="lbl">Project Type</label><input type="text" name="project_type" placeholder="e.g. API Integration"></div>
    </div>
    <div class="fg">
      <label class="lbl">Review Text *</label>
      <textarea name="review_text" style="min-height:100px;" required placeholder="Excellent developer! Delivered on time..."></textarea>
    </div>
    <div class="fg">
      <label class="lbl">Rating</label>
      <select name="rating">
        <option value="5">★★★★★ 5/5</option>
        <option value="4">★★★★☆ 4/5</option>
        <option value="3">★★★☆☆ 3/5</option>
      </select>
    </div>
  </div>
  <div class="modal-f">
    <button type="button" onclick="closeModal('modal-add-review')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-p">➕ Add Review</button>
  </div>
  </form>
</div>
</div>
@endsection
