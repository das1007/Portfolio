@extends('admin.layout')
@section('title','Message Detail')
@section('page_title','Message Detail')
@section('content')
<div style="display:grid;grid-template-columns:1fr 320px;gap:16px;align-items:start;">
  <div>
    <div class="card">
      <div class="card-h">
        <span class="card-t">📋 Message from {{ $contact->name }}</span>
        <span class="badge b-{{ $contact->status }}">{{ ucfirst($contact->status) }}</span>
      </div>
      <div class="card-b">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px;">
          @foreach([['👤 Name',$contact->name,null],['✉️ Email',$contact->email,'mailto:'.$contact->email],['📞 Phone',$contact->phone,$contact->phone?'tel:'.$contact->phone:null],['🏷 Type',ucfirst($contact->type),null],['💰 Budget',$contact->budget,null],['⏱ Timeline',$contact->timeline,null],['📋 Subject',$contact->subject,null]] as [$l,$v,$href])
          @if($v)
          <div style="background:var(--bg3);border-radius:7px;padding:11px 13px;">
            <div style="font-family:'JetBrains Mono',monospace;font-size:.56rem;letter-spacing:.14em;text-transform:uppercase;color:var(--txt3);margin-bottom:4px;">{{ $l }}</div>
            <div style="font-size:.84rem;">@if($href)<a href="{{ $href }}" style="color:var(--e);">{{ $v }}</a>@else{{ $v }}@endif</div>
          </div>
          @endif
          @endforeach
        </div>
        <div style="background:var(--bg3);border-radius:8px;padding:15px;margin-bottom:14px;">
          <div style="font-family:'JetBrains Mono',monospace;font-size:.56rem;letter-spacing:.14em;text-transform:uppercase;color:var(--txt3);margin-bottom:8px;">💬 Message</div>
          <div style="font-size:.86rem;color:var(--txt2);line-height:1.85;white-space:pre-line;">{{ $contact->message }}</div>
        </div>
        @if($contact->admin_notes)
        <div style="background:rgba(0,212,255,.04);border:1px solid var(--bd);border-radius:8px;padding:14px;">
          <div style="font-family:'JetBrains Mono',monospace;font-size:.56rem;letter-spacing:.14em;text-transform:uppercase;color:var(--e);margin-bottom:6px;">📝 Admin Notes</div>
          <div style="font-size:.84rem;color:var(--txt2);white-space:pre-line;">{{ $contact->admin_notes }}</div>
        </div>
        @endif
        <div style="display:flex;gap:8px;margin-top:16px;flex-wrap:wrap;">
          <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-p">📧 Reply by Email</a>
          @if($contact->phone)<a href="tel:{{ $contact->phone }}" class="btn btn-o">📞 Call</a>@endif
          <a href="{{ route('admin.contacts') }}" class="btn btn-ghost">← Back</a>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class="card">
      <div class="card-h"><span class="card-t">⚙️ Update</span></div>
      <div class="card-b">
        <form action="{{ route('admin.contact.update',$contact) }}" method="POST">@csrf @method('PATCH')
          <div class="fg"><label class="lbl">Status</label>
            <select name="status">
              @foreach(['new'=>'New','read'=>'Read','replied'=>'Replied','archived'=>'Archived'] as $v=>$l)
              <option value="{{ $v }}" {{ $contact->status===$v?'selected':'' }}>{{ $l }}</option>
              @endforeach
            </select>
          </div>
          <div class="fg"><label class="lbl">Admin Notes</label><textarea name="admin_notes" style="min-height:100px;" placeholder="Internal notes...">{{ $contact->admin_notes }}</textarea></div>
          <button type="submit" class="btn btn-p btn-full">💾 Update</button>
        </form>
      </div>
    </div>
    <div class="card">
      <div class="card-b" style="padding:13px 16px;">
        <div style="font-family:'JetBrains Mono',monospace;font-size:.65rem;color:var(--txt3);margin-bottom:10px;">📅 {{ $contact->created_at->format('d M Y, H:i') }}<br>{{ $contact->created_at->diffForHumans() }}</div>
        <form action="{{ route('admin.contact.destroy',$contact) }}" method="POST" onsubmit="return confirm('Delete permanently?')">@csrf @method('DELETE')
          <button class="btn btn-r btn-full">🗑 Delete Message</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
