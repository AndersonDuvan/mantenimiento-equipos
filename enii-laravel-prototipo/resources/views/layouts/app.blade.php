<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Mantenimiento ENII')</title>
<style>
:root{--bg:#f5f6f8;--card:#fff;--ink:#1d2433;--muted:#5d6678;--line:#dde1e8;--brand:#17415f;--brand2:#e08a1e;--ok:#1f7a4d;--warn:#b26a00;--bad:#b3261e}
@media (prefers-color-scheme:dark){:root{--bg:#10141b;--card:#181e28;--ink:#e8ebf1;--muted:#9aa4b6;--line:#2a3342;--brand:#6fb0dc;--brand2:#f0a64a;--ok:#5cc58f;--warn:#e8b04f;--bad:#f08a82}}
*{box-sizing:border-box}body{margin:0;font:15px/1.5 system-ui,Segoe UI,Roboto,sans-serif;background:var(--bg);color:var(--ink)}
nav{background:var(--brand);display:flex;flex-wrap:wrap;align-items:center;gap:4px;padding:8px 16px}
nav a,nav button{color:#fff;text-decoration:none;padding:6px 12px;border-radius:6px;background:none;border:0;font:inherit;cursor:pointer}
nav a:hover,nav button:hover,nav a.on{background:rgba(255,255,255,.18)}nav .sp{flex:1}nav span{color:#dfe9f2;font-size:13px}
@media (prefers-color-scheme:dark){nav{background:#1d2a3a}}
main{max-width:1060px;margin:0 auto;padding:20px 16px 48px}
h1{font-size:22px;margin:0 0 16px}h2{font-size:17px;margin:24px 0 10px}
.card{background:var(--card);border:1px solid var(--line);border-radius:8px;padding:16px;margin-bottom:16px}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px}
.stat b{display:block;font-size:28px}.stat small{color:var(--muted)}
.bar{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:14px}
table{width:100%;border-collapse:collapse;background:var(--card)}th,td{padding:9px 10px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top}
th{font-size:13px;color:var(--muted);font-weight:600}.tw{overflow-x:auto;border:1px solid var(--line);border-radius:8px}
label{display:block;font-weight:600;margin:12px 0 4px}input,select,textarea{width:100%;padding:8px 10px;border:1px solid var(--line);border-radius:6px;background:var(--card);color:var(--ink);font:inherit}
textarea{min-height:90px}.btn{display:inline-block;background:var(--brand);color:#fff;border:0;border-radius:6px;padding:8px 16px;font:inherit;text-decoration:none;cursor:pointer}
@media (prefers-color-scheme:dark){.btn{color:#10141b}}
.btn.sec{background:transparent;color:var(--brand);border:1px solid var(--brand)}.btn.del{background:var(--bad)}
.filtros{display:flex;gap:8px;flex-wrap:wrap;align-items:end;margin-bottom:12px}.filtros>*{width:auto;min-width:140px}
.badge{display:inline-block;padding:2px 9px;border-radius:99px;font-size:12px;font-weight:600;border:1px solid currentColor}
.b-operativo,.b-resuelta,.b-realizado,.b-baja{color:var(--ok)}.b-en_mantenimiento,.b-en_atencion,.b-programado,.b-media{color:var(--warn)}
.b-fuera_de_servicio,.b-abierta,.b-alta{color:var(--bad)}.b-cancelado,.b-preventivo,.b-correctivo{color:var(--muted)}
.ok{background:rgba(31,122,77,.12);border:1px solid var(--ok);color:var(--ok);padding:10px 14px;border-radius:6px;margin-bottom:14px}
.err{background:rgba(179,38,30,.1);border:1px solid var(--bad);color:var(--bad);padding:10px 14px;border-radius:6px;margin-bottom:14px}
.err ul{margin:0;padding-left:18px}.muted{color:var(--muted)}.pag{margin-top:12px}
.login{max-width:380px;margin:12vh auto}
</style>
</head>
<body>
@auth
<nav>
  <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'on' : '' }}">Inicio</a>
  <a href="{{ route('equipos.index') }}" class="{{ request()->routeIs('equipos.*') ? 'on' : '' }}">Equipos</a>
  <a href="{{ route('fallas.index') }}" class="{{ request()->routeIs('fallas.*') ? 'on' : '' }}">Fallas</a>
  <a href="{{ route('mantenimientos.index') }}" class="{{ request()->routeIs('mantenimientos.*') ? 'on' : '' }}">Mantenimientos</a>
  <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'on' : '' }}">Reportes</a>
  <span class="sp"></span>
  <span>{{ auth()->user()->name }} ({{ auth()->user()->rol }})</span>
  <form method="POST" action="{{ route('logout') }}">@csrf<button>Cerrar sesión</button></form>
</nav>
@endauth
<main>
  @if(session('ok'))<div class="ok">{{ session('ok') }}</div>@endif
  @if($errors->any())<div class="err"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
  @yield('content')
</main>
</body>
</html>
