@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* ── Stats grid: 4 kolona ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }

    /* ── Module cards: 6 kolona ── */
    .mods-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .s-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 1.4rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #eef0f5;
    }

    .bdg-up { background:#dcfce7; color:#16a34a; padding:3px 9px; border-radius:20px; font-size:0.7rem; font-weight:700; white-space:nowrap; }
    .bdg-dn { background:#fee2e2; color:#dc2626; padding:3px 9px; border-radius:20px; font-size:0.7rem; font-weight:700; white-space:nowrap; }

    .stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
    .stat-lbl { font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#aaa; margin-bottom:4px; }
    .stat-val { font-size:1.6rem; font-weight:900; color:#16181D; line-height:1; }
    .stat-bar { height:5px; background:#f0f0f5; border-radius:3px; overflow:hidden; }
    .stat-fill { height:100%; border-radius:3px; }
    .stat-sub { font-size:0.7rem; color:#aaa; margin-top:5px; }

    .mod-icon {
        width:44px; height:44px; border-radius:12px;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0; font-size:1.05rem;
    }
    .mod-card {
        background:white; border-radius:14px; border:1px solid #eef0f5;
        padding:1rem 1.1rem;
        display:flex; align-items:center; gap:10px;
        box-shadow:0 1px 4px rgba(0,0,0,0.05);
    }
    .mod-title { font-size:0.82rem; font-weight:700; color:#16181D; }
    .mod-sub   { font-size:0.68rem; color:#aaa; }
    .mod-badge {
        margin-left:auto; flex-shrink:0;
        font-size:0.62rem; font-weight:700; padding:3px 8px;
        border-radius:20px; text-decoration:none;
    }

    /* ── Table ── */
    .ord-table-wrap {
        background:white; border-radius:16px;
        border:1px solid #eef0f5;
        box-shadow:0 1px 4px rgba(0,0,0,0.05);
        overflow:hidden;
    }
    .ord-table-head {
        display:flex; align-items:center; justify-content:space-between;
        padding:1rem 1.5rem; border-bottom:1px solid #f5f5f5; flex-wrap:wrap; gap:8px;
    }
    .ord-table-head h6 { font-weight:800; font-size:0.95rem; margin:0; }
    .badge-row { display:flex; gap:6px; flex-wrap:wrap; }
    .pill { font-size:0.68rem; font-weight:700; padding:4px 12px; border-radius:20px; }
    .pill-new    { background:#fff0f2; color:var(--cherry); }
    .pill-wait   { background:#fef3c7; color:#92400e; }
    .pill-ship   { background:#dbeafe; color:#1e40af; }
    .pill-done   { background:#dcfce7; color:#15803d; }

    table.ord-table { width:100%; border-collapse:collapse; font-size:0.83rem; }
    table.ord-table thead tr { background:#fafafa; }
    table.ord-table th { padding:10px 16px; color:#aaa; font-weight:700; font-size:0.7rem; text-transform:uppercase; letter-spacing:.4px; text-align:left; border-bottom:1px solid #f5f5f5; }
    table.ord-table td { padding:11px 16px; border-bottom:1px solid #f5f5f5; color:#333; }
    table.ord-table tbody tr:last-child td { border-bottom:none; }
    table.ord-table tbody tr:hover td { background:#fdfbfb; }

    .sts { font-size:0.68rem; font-weight:700; padding:3px 10px; border-radius:20px; }
    .sts-delivered { background:#dcfce7; color:#15803d; }
    .sts-shipped   { background:#dbeafe; color:#1e40af; }
    .sts-pending   { background:#fef3c7; color:#92400e; }
    .sts-new       { background:#fff0f2; color:var(--cherry); }

    .topbar-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }

    @media(max-width:1200px) { .mods-grid { grid-template-columns:repeat(3, 1fr); } }
    @media(max-width:900px)  { .stats-grid { grid-template-columns:repeat(2, 1fr); } .mods-grid { grid-template-columns:repeat(2, 1fr); } }
    @media(max-width:560px)  { .stats-grid { grid-template-columns:1fr; } .mods-grid { grid-template-columns:repeat(2, 1fr); } }
</style>
@endsection

@section('content')

<div class="topbar-row">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">Mirë se vini, {{ Auth::user()->name }}! 👋</h4>
        <p style="color:#aaa;margin:0;font-size:0.83rem;">Pasqyra e sistemit të bibliotekës</p>
    </div>
    <select id="period-select" onchange="updateStats(this.value)" style="background:white;border:1px solid #eef0f5;border-radius:10px;padding:0.4rem 0.85rem;font-size:0.82rem;font-family:'Nunito',sans-serif;outline:none;box-shadow:0 1px 4px rgba(0,0,0,0.05);cursor:pointer;">
        <option value="month">Ky muaj</option>
        <option value="week">Java e kaluar</option>
        <option value="year">Ky vit</option>
    </select>
</div>

{{-- ── 4 Stat Cards ── --}}
<div class="stats-grid">
    <div class="s-card">
        <div class="stat-top">
            <div>
                <div class="stat-lbl">Të Ardhurat Totale</div>
                <div class="stat-val" id="stat-revenue">€ 12,540</div>
            </div>
            <span id="bdg-revenue" class="bdg-up">▲ 12%</span>
        </div>
        <div class="stat-bar"><div class="stat-fill" id="bar-revenue" style="width:65%;background:var(--cherry);"></div></div>
        <div class="stat-sub" id="sub-revenue">vs muaji i kaluar</div>
    </div>
    <div class="s-card">
        <div class="stat-top">
            <div>
                <div class="stat-lbl">Porositë Totale</div>
                <div class="stat-val" id="stat-orders">354</div>
            </div>
            <span id="bdg-orders" class="bdg-up">▲ 8%</span>
        </div>
        <div class="stat-bar"><div class="stat-fill" id="bar-orders" style="width:42%;background:#6366f1;"></div></div>
        <div class="stat-sub" id="sub-orders">vs muaji i kaluar</div>
    </div>
    <div class="s-card">
        <div class="stat-top">
            <div>
                <div class="stat-lbl">Fitimi Neto</div>
                <div class="stat-val" id="stat-profit">€ 6,042</div>
            </div>
            <span id="bdg-profit" class="bdg-dn">▼ 3%</span>
        </div>
        <div class="stat-bar"><div class="stat-fill" id="bar-profit" style="width:55%;background:#22c55e;"></div></div>
        <div class="stat-sub" id="sub-profit">vs muaji i kaluar</div>
    </div>
    <div class="s-card">
        <div class="stat-top">
            <div>
                <div class="stat-lbl">Klientë Aktivë</div>
                <div class="stat-val" id="stat-clients">217</div>
            </div>
            <span id="bdg-clients" class="bdg-up">▲ 5%</span>
        </div>
        <div class="stat-bar"><div class="stat-fill" id="bar-clients" style="width:72%;background:#f59e0b;"></div></div>
        <div class="stat-sub" id="sub-clients">vs muaji i kaluar</div>
    </div>
</div>

{{-- ── 6 Module Cards ── --}}
<div class="mods-grid">
    @foreach([
        ['bi-tag-fill',                '#fff0f2','var(--cherry)', 'Kuponat',         '98',    'Aktive',       'pill-new'],
        ['bi-credit-card-2-front-fill','#f0fdf4','#16a34a',       'Pagesat',         '€4.2k', 'Muajin',       'pill-done'],
        ['bi-star-fill',               '#fefce8','#ca8a04',       'Vlerësimet',      '127',   'Totale',       'pill-wait'],
        ['bi-truck-front-fill',        '#eff6ff','#2563eb',       'Dërgesat',        '45',    'Aktive',       'pill-ship'],
        ['bi-geo-alt-fill',            '#faf5ff','#7c3aed',       'Adresat',         '89',    'Regj.',        'pill-ship'],
        ['bi-heart-fill',              '#fff0f2','var(--cherry)', 'Lista Dëshirave', '312',   'Artikuj',      'pill-new'],
    ] as $m)
    <div class="mod-card">
        <div class="mod-icon" style="background:{{ $m[1] }};">
            <i class="bi {{ $m[0] }}" style="color:{{ $m[2] }};"></i>
        </div>
        <div style="min-width:0;flex:1;">
            <div class="mod-title text-truncate">{{ $m[3] }}</div>
            <div class="mod-sub">{{ $m[4] }} {{ $m[5] }}</div>
        </div>
        <a href="#" class="mod-badge {{ $m[6] }}">CRUD</a>
    </div>
    @endforeach
</div>

{{-- ── Orders Table ── --}}
<div class="ord-table-wrap">
    <div class="ord-table-head">
        <h6>Lista e Porosive</h6>
        <div class="badge-row">
            <span class="pill pill-new">12 Të reja</span>
            <span class="pill pill-wait">20 Pritje</span>
            <span class="pill pill-ship">57 Dërguar</span>
            <span class="pill pill-done">98 Dorëzuar</span>
        </div>
    </div>
    <table class="ord-table">
        <thead>
            <tr>
                <th>#Porosia</th>
                <th>Klienti</th>
                <th>Kategoria</th>
                <th>Totali</th>
                <th>Data</th>
                <th>Pagesa</th>
                <th>Statusi</th>
            </tr>
        </thead>
        <tbody>
            @foreach([
                ['#00001','Ana Krasniqi',    'Libra',  '35.00','28.05.2026','Kartë', 'delivered'],
                ['#00002','Besart Hoxha',    'E-book', '12.00','27.05.2026','PayPal','shipped'],
                ['#00003','Dita Osmani',     'Libra',  '48.00','26.05.2026','Kartë', 'pending'],
                ['#00004','Fatlind Berisha', 'Audio',  '9.99', '25.05.2026','Kartë', 'new'],
                ['#00005','Genta Morina',    'Libra',  '22.50','24.05.2026','PayPal','delivered'],
                ['#00006','Ilir Gashi',      'E-book', '14.99','23.05.2026','Kartë', 'shipped'],
            ] as $row)
            @php
                $sts = match($row[6]) {
                    'delivered' => ['sts-delivered','Dorëzuar'],
                    'shipped'   => ['sts-shipped',  'Dërguar'],
                    'pending'   => ['sts-pending',  'Pritje'],
                    default     => ['sts-new',      'E re'],
                };
            @endphp
            <tr>
                <td style="font-weight:700;color:#aaa;font-size:0.78rem;">{{ $row[0] }}</td>
                <td style="font-weight:600;">{{ $row[1] }}</td>
                <td style="color:#aaa;">{{ $row[2] }}</td>
                <td style="font-weight:700;">€ {{ $row[3] }}</td>
                <td style="color:#aaa;font-size:0.78rem;">{{ $row[4] }}</td>
                <td style="color:#aaa;">{{ $row[5] }}</td>
                <td><span class="sts {{ $sts[0] }}">{{ $sts[1] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="text-align:center;padding:0.85rem;">
        <a href="{{ route('admin.payments') }}" style="color:var(--cherry);font-size:0.82rem;font-weight:700;text-decoration:none;">
            Shiko të gjitha porositë <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script>
const statsData = {
    month: {
        revenue:'€ 12,540', revPct:'▲ 12%', revUp:true,  revBar:'65',
        orders:'354',        ordPct:'▲ 8%',  ordUp:true,  ordBar:'42',
        profit:'€ 6,042',   proPct:'▼ 3%',  proUp:false, proBar:'55',
        clients:'217',       cliPct:'▲ 5%',  cliUp:true,  cliBar:'72',
        sub:'vs muaji i kaluar',
    },
    week: {
        revenue:'€ 3,120',  revPct:'▲ 6%',  revUp:true,  revBar:'38',
        orders:'87',         ordPct:'▼ 2%',  ordUp:false, ordBar:'22',
        profit:'€ 1,480',   proPct:'▲ 4%',  proUp:true,  proBar:'30',
        clients:'54',        cliPct:'▲ 1%',  cliUp:true,  cliBar:'20',
        sub:'vs java e mëparshme',
    },
    year: {
        revenue:'€ 148,900', revPct:'▲ 23%', revUp:true, revBar:'88',
        orders:'4,210',       ordPct:'▲ 18%', ordUp:true, ordBar:'78',
        profit:'€ 71,300',   proPct:'▲ 11%', proUp:true, proBar:'72',
        clients:'1,840',      cliPct:'▲ 31%', cliUp:true, cliBar:'90',
        sub:'vs viti i kaluar',
    },
};
function updateStats(period) {
    const d = statsData[period];
    set('revenue', d.revenue, d.revPct, d.revUp, d.revBar, d.sub);
    set('orders',  d.orders,  d.ordPct, d.ordUp, d.ordBar, d.sub);
    set('profit',  d.profit,  d.proPct, d.proUp, d.proBar, d.sub);
    set('clients', d.clients, d.cliPct, d.cliUp, d.cliBar, d.sub);
}
function set(k, val, pct, up, bar, sub) {
    document.getElementById('stat-'+k).textContent = val;
    const b = document.getElementById('bdg-'+k);
    b.textContent = pct;
    b.className = up ? 'bdg-up' : 'bdg-dn';
    document.getElementById('bar-'+k).style.width = bar + '%';
    document.getElementById('sub-'+k).textContent = sub;
}
</script>
@endsection
