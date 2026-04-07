<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
*{box-sizing:border-box;}body{font-family:Arial,sans-serif;background:#07090d;margin:0;padding:24px 14px;color:#dce8f8;}
.wrap{max-width:520px;margin:0 auto;}
.card{background:#0b0f15;border-radius:12px;overflow:hidden;border:1px solid rgba(0,212,255,.12);}
.head{background:#0f141b;padding:24px;border-bottom:1px solid rgba(255,255,255,.05);}
.head-title{font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:3px;}
.head-sub{font-family:monospace;font-size:.63rem;color:#00d4ff;letter-spacing:.1em;text-transform:uppercase;}
.body{padding:22px;}
.field{margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,.04);}
.field:last-child{border:none;margin-bottom:0;padding-bottom:0;}
.fl{font-family:monospace;font-size:.57rem;letter-spacing:.16em;text-transform:uppercase;color:#3d5068;margin-bottom:3px;}
.fv{font-size:.84rem;color:#7a90a8;}
.msg{background:rgba(0,212,255,.04);border-radius:7px;padding:12px;margin-top:3px;font-size:.85rem;color:#7a90a8;line-height:1.8;}
.cta{text-align:center;padding:18px 22px;border-top:1px solid rgba(255,255,255,.04);}
.btn{display:inline-block;background:#00d4ff;color:#07090d;padding:10px 22px;border-radius:6px;font-size:.78rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;text-decoration:none;}
.foot{text-align:center;margin-top:14px;font-size:.68rem;color:#3d5068;font-family:monospace;}
</style></head>
<body><div class="wrap">
  <div class="card">
    <div class="head">
      <div class="head-title">New Portfolio Contact</div>
      <div class="head-sub">🔔 {{ $contact->type }} — {{ $contact->subject }}</div>
    </div>
    <div class="body">
      @foreach([['Name',$contact->name],['Email',$contact->email],['Phone',$contact->phone],['Type',ucfirst($contact->type)],['Budget',$contact->budget],['Timeline',$contact->timeline]] as [$l,$v])
      @if($v)<div class="field"><div class="fl">{{ $l }}</div><div class="fv">{{ $v }}</div></div>@endif
      @endforeach
      <div class="field"><div class="fl">Message</div><div class="msg">{{ $contact->message }}</div></div>
    </div>
    <div class="cta"><a href="{{ url('/admin/contacts/'.$contact->id) }}" class="btn">View in Admin →</a></div>
  </div>
  <div class="foot">{{ now()->format('d M Y, H:i') }} · Portfolio CMS</div>
</div></body></html>
