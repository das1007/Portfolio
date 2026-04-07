@extends('admin.layout')
@section('title','Messages')
@section('page_title','Messages & Inquiries')
@section('content')

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px;">
  @foreach([['Total',$contacts->total(),'var(--e)'],['Unread',\App\Models\Contact::where('status','new')->count(),'var(--rose)'],['Replied',\App\Models\Contact::where('status','replied')->count(),'var(--green)']] as [$l,$n,$c])
  <div style="background:var(--surf);border:1px solid var(--bd2);border-radius:var(--r);padding:16px 18px;">
    <div style="font-family:'JetBrains Mono',monospace;font-size:.56rem;letter-spacing:.18em;text-transform:uppercase;color:var(--txt3);margin-bottom:6px;">{{ $l }}</div>
    <div style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;color:{{ $c }};">{{ $n }}</div>
  </div>
  @endforeach
</div>

<div class="card" style="margin-bottom:12px;">
  <div class="card-b" style="padding:13px 16px;">
    <form action="{{ route('admin.contacts') }}" method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
      <div style="flex:1;min-width:180px;"><label class="lbl">Search</label><input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..."></div>
      <div style="min-width:140px;"><label class="lbl">Status</label>
        <select name="status"><option value="">All Statuses</option>@foreach(['new','read','replied','archived'] as $s)<option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select>
      </div>
      <div style="min-width:140px;"><label class="lbl">Type</label>
        <select name="type"><option value="">All Types</option>@foreach(['project','job','collaboration','general'] as $t)<option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach</select>
      </div>
      <div style="display:flex;gap:7px;align-items:flex-end;padding-bottom:1px;">
        <button type="submit" class="btn btn-p">Filter</button>
        <a href="{{ route('admin.contacts') }}" class="btn btn-ghost">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-h">
    <span class="card-t">💬 All Messages ({{ $contacts->total() }}) @if($newCount>0)<span class="badge b-new" style="margin-left:6px;">{{ $newCount }} new</span>@endif</span>
  </div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Sender</th><th>Subject</th><th>Type</th><th>Budget</th><th>Status</th><th>Date</th><th style="text-align:right">Actions</th></tr></thead>
      <tbody>
        @forelse($contacts as $c)
        <tr>
          <td>
            <div style="font-weight:600;font-size:.82rem;">{{ $c->name }}</div>
            <div style="font-size:.71rem;color:var(--txt3);">{{ $c->email }}</div>
            @if($c->phone)<div style="font-size:.69rem;color:var(--txt3);">{{ $c->phone }}</div>@endif
          </td>
          <td style="max-width:180px;">@if($c->status==='new')<span style="color:var(--rose);margin-right:3px;">●</span>@endif{{ \Str::limit($c->subject,38) }}</td>
          <td><span class="badge b-read" style="font-size:.58rem;">{{ ucfirst($c->type) }}</span></td>
          <td style="font-size:.77rem;color:var(--txt3);">{{ $c->budget ?: '—' }}</td>
          <td><span class="badge b-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
          <td style="font-size:.73rem;color:var(--txt3);white-space:nowrap;">{{ $c->created_at->format('d M Y') }}</td>
          <td style="text-align:right">
            <div style="display:flex;gap:5px;justify-content:flex-end;">
              <a href="{{ route('admin.contact.show',$c) }}" class="btn btn-o btn-sm">View</a>
              <form action="{{ route('admin.contact.destroy',$c) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                <button class="btn btn-r btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--txt3);">No messages found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($contacts->hasPages())
  <div style="padding:14px 18px;border-top:1px solid var(--bd2);">{{ $contacts->links() }}</div>
  @endif
</div>
@endsection
