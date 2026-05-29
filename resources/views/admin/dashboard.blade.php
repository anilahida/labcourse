@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Mirë se vini, {{ Auth::user()->name }}! 👋</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Pasqyra e sistemit të bibliotekës</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm border-0 shadow-sm" style="border-radius:10px;font-size:0.82rem;width:140px;">
            <option>Ky muaj</option>
            <option>Java e kaluar</option>
            <option>Ky vit</option>
        </select>
    </div>
</div>

{{-- ── Row 1: Main Stats ── --}}
<div class="row g-3 mb-3">
    <div class="col-sm-6 col-xl-3">
        <div class="s-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Të Ardhurat Totale</p>
                    <h3 class="fw-bold mb-0" style="font-size:1.6rem;">€ 12,540</h3>
                </div>
                <span class="bdg-up">▲ 12%</span>
            </div>
            <div style="height:5px;background:#f0f0f5;border-radius:3px;">
                <div style="width:65%;height:100%;background:var(--cherry);border-radius:3px;"></div>
            </div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.72rem;">vs muaji i kaluar</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="s-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Porositë Totale</p>
                    <h3 class="fw-bold mb-0" style="font-size:1.6rem;">354</h3>
                </div>
                <span class="bdg-up">▲ 8%</span>
            </div>
            <div style="height:5px;background:#f0f0f5;border-radius:3px;">
                <div style="width:42%;height:100%;background:#6366f1;border-radius:3px;"></div>
            </div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.72rem;">vs muaji i kaluar</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="s-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Fitimi Neto</p>
                    <h3 class="fw-bold mb-0" style="font-size:1.6rem;">€ 6,042</h3>
                </div>
                <span class="bdg-dn">▼ 3%</span>
            </div>
            <div style="height:5px;background:#f0f0f5;border-radius:3px;">
                <div style="width:55%;height:100%;background:#22c55e;border-radius:3px;"></div>
            </div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.72rem;">vs muaji i kaluar</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="s-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Klientë Aktivë</p>
                    <h3 class="fw-bold mb-0" style="font-size:1.6rem;">217</h3>
                </div>
                <span class="bdg-up">▲ 5%</span>
            </div>
            <div style="height:5px;background:#f0f0f5;border-radius:3px;">
                <div style="width:72%;height:100%;background:#f59e0b;border-radius:3px;"></div>
            </div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.72rem;">vs muaji i kaluar</p>
        </div>
    </div>
</div>

{{-- ── Row 2: CRUD Module Cards ── --}}
<div class="row g-3 mb-4">
    @foreach([
        ['bi-tag-fill','#fff0f2','var(--cherry)','Kuponat','98','Kodeve aktive','danger'],
        ['bi-credit-card-2-front-fill','#f0fdf4','#16a34a','Pagesat','€ 4,210','Muajin','success'],
        ['bi-star-fill','#fefce8','#ca8a04','Vlerësimet','127','Totale','warning'],
        ['bi-truck-front-fill','#eff6ff','#2563eb','Dërgesat','45','Aktive','primary'],
        ['bi-geo-alt-fill','#faf5ff','#7c3aed','Adresat','89','Regjistruara','secondary'],
        ['bi-heart-fill','#fff1f2','var(--cherry)','Lista Dëshirave','312','Artikuj','danger'],
    ] as $mod)
    <div class="col-sm-6 col-xl-2">
        <div class="s-card d-flex align-items-center gap-3" style="padding:1rem 1.1rem;">
            <div style="width:46px;height:46px;background:{{ $mod[1] }};border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi {{ $mod[0] }}" style="color:{{ $mod[2] }};font-size:1.1rem;"></i>
            </div>
            <div class="min-w-0">
                <h5 class="fw-bold mb-0" style="font-size:1.1rem;">{{ $mod[3] }}</h5>
                <p class="text-muted mb-0" style="font-size:0.7rem;">{{ $mod[4] }} {{ $mod[5] }}</p>
            </div>
            <a href="#" class="ms-auto badge bg-{{ $mod[6] }}-subtle text-{{ $mod[6] }} text-decoration-none"
               style="font-size:0.68rem;white-space:nowrap;">CRUD</a>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Order List Table ── --}}
<div class="card border-0 shadow-sm" style="border-radius:16px;overflow:hidden;">
    <div class="card-header bg-white border-0 pt-3 pb-2 px-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h6 class="fw-bold mb-0">Lista e Porosive</h6>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge rounded-pill px-3 py-2" style="background:#fff0f2;color:var(--cherry);font-size:0.72rem;">12 Të reja</span>
                <span class="badge rounded-pill px-3 py-2 bg-warning-subtle text-warning" style="font-size:0.72rem;">20 Në pritje</span>
                <span class="badge rounded-pill px-3 py-2 bg-primary-subtle text-primary" style="font-size:0.72rem;">57 Në rrugë</span>
                <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success" style="font-size:0.72rem;">98 Dorëzuar</span>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="font-size:0.83rem;">
                <thead>
                    <tr style="background:#fafafa;">
                        <th class="ps-4 py-3 border-0 text-muted fw-semibold" style="font-size:0.75rem;">#Porosia</th>
                        <th class="py-3 border-0 text-muted fw-semibold" style="font-size:0.75rem;">Klienti</th>
                        <th class="py-3 border-0 text-muted fw-semibold" style="font-size:0.75rem;">Kategoria</th>
                        <th class="py-3 border-0 text-muted fw-semibold" style="font-size:0.75rem;">Totali</th>
                        <th class="py-3 border-0 text-muted fw-semibold" style="font-size:0.75rem;">Data</th>
                        <th class="py-3 border-0 text-muted fw-semibold" style="font-size:0.75rem;">Pagesa</th>
                        <th class="py-3 pe-4 border-0 text-muted fw-semibold" style="font-size:0.75rem;">Statusi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['#00001','Ana Krasniqi','Libra','35.00','28.05.2026','Kartë','delivered'],
                        ['#00002','Besart Hoxha','E-book','12.00','27.05.2026','PayPal','shipped'],
                        ['#00003','Dita Osmani','Libra','48.00','26.05.2026','Kartë','pending'],
                        ['#00004','Fatlind Berisha','Audio','9.99','25.05.2026','Kartë','new'],
                        ['#00005','Genta Morina','Libra','22.50','24.05.2026','PayPal','delivered'],
                        ['#00006','Ilir Gashi','E-book','14.99','23.05.2026','Kartë','shipped'],
                    ] as $row)
                    @php
                        $map = [
                            'delivered' => ['success','Dorëzuar'],
                            'shipped'   => ['primary','Dërguar'],
                            'pending'   => ['warning','Pritje'],
                            'new'       => ['danger','E re'],
                        ];
                    @endphp
                    <tr style="border-top:1px solid #f5f5f5;">
                        <td class="ps-4 fw-semibold">{{ $row[0] }}</td>
                        <td>{{ $row[1] }}</td>
                        <td class="text-muted">{{ $row[2] }}</td>
                        <td class="fw-semibold">€ {{ $row[3] }}</td>
                        <td class="text-muted">{{ $row[4] }}</td>
                        <td class="text-muted">{{ $row[5] }}</td>
                        <td class="pe-4">
                            <span class="badge bg-{{ $map[$row[6]][0] }}-subtle text-{{ $map[$row[6]][0] }} rounded-pill px-3">
                                {{ $map[$row[6]][1] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 text-center py-3">
        <a href="#" style="color:var(--cherry);font-size:0.82rem;font-weight:700;text-decoration:none;">
            Shiko të gjitha porositë <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>
@endsection
