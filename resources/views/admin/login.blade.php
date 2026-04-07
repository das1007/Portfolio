<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Admin Login</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--bg:#07090d;--bg2:#0b0f15;--surf:#141c26;--e:#00d4ff;--e3:#00ffcc;--rose:#ff4d6d;--txt:#dce8f8;--txt2:#7a90a8;--txt3:#3d5068;--bd:rgba(0,212,255,.12);--bd2:rgba(255,255,255,.06);}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--txt);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
.grid{position:fixed;inset:0;background-image:linear-gradient(rgba(0,212,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,255,.03) 1px,transparent 1px);background-size:52px 52px;mask-image:radial-gradient(ellipse 70% 70% at 50% 50%,#000 30%,transparent 100%);pointer-events:none;}
.glow{position:fixed;width:500px;height:500px;top:-150px;right:-100px;background:radial-gradient(circle,rgba(0,212,255,.06),transparent 65%);pointer-events:none;}
.box{background:var(--bg2);border:1px solid var(--bd);border-radius:14px;padding:40px;width:100%;max-width:400px;position:relative;z-index:1;overflow:hidden;}
.box::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--e),var(--e3));}
.logo{font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;margin-bottom:4px;}
.logo span{color:var(--e);}
.sub{font-family:'JetBrains Mono',monospace;font-size:.6rem;color:var(--txt3);letter-spacing:.14em;margin-bottom:28px;}
.fg{margin-bottom:16px;}
label{display:block;font-family:'JetBrains Mono',monospace;font-size:.58rem;letter-spacing:.16em;text-transform:uppercase;color:var(--txt3);margin-bottom:5px;}
input{width:100%;padding:10px 13px;background:#0b0f15;border:1px solid var(--bd2);border-radius:7px;font-size:.88rem;color:var(--txt);outline:none;transition:border-color .2s;font-family:'DM Sans',sans-serif;}
input:focus{border-color:var(--e);background:rgba(0,212,255,.02);}
.btn{width:100%;padding:12px;background:var(--e);color:var(--bg);border:none;border-radius:7px;font-family:'Syne',sans-serif;font-size:.88rem;font-weight:700;letter-spacing:.05em;cursor:pointer;margin-top:6px;transition:all .25s;}
.btn:hover{background:var(--e3);box-shadow:0 0 20px rgba(0,212,255,.3);}
.err{background:rgba(255,77,109,.07);border:1px solid rgba(255,77,109,.2);color:var(--rose);padding:10px 13px;border-radius:7px;font-size:.81rem;margin-bottom:14px;}
.back{display:block;text-align:center;margin-top:18px;font-size:.76rem;color:var(--txt3);transition:color .2s;font-family:'JetBrains Mono',monospace;}
.back:hover{color:var(--e);}
</style>
</head>
<body>
<div class="grid"></div><div class="glow"></div>
<div class="box">
  <div class="logo">Darshan<span>.</span></div>
  <div class="sub">// admin panel access</div>
  @if($errors->any())<div class="err">⚠️ {{ $errors->first() }}</div>@endif
  <form action="{{ route('admin.login.post') }}" method="POST">@csrf
    <div class="fg"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@email.com"></div>
    <div class="fg"><label>Password</label><input type="password" name="password" required placeholder="••••••••"></div>
    <button type="submit" class="btn">Access Panel →</button>
  </form>
  <a href="{{ route('home') }}" class="back">← Back to Portfolio</a>
</div>
</body>
</html>
