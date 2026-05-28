@extends('layouts.admin')
@section('title','Kuponat')

@section('styles')
<style>
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.page-head h4{font-weight:900;margin:0 0 2px;}
.page-head p{color:#aaa;margin:0;font-size:.83rem;}
.btn-add{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.5rem 1.25rem;font-size:.85rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;font-family:'Nunito',sans-serif;cursor:pointer;transition:background .2s;}
.btn-add:hover{background:#9B1530;color:white;}
.adm-table-wrap{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden;}
table.at{width:100%;border-collapse:collapse;font-size:.83rem;}
table.at thead tr{background:#fafafa;}
table.at th{padding:10px 16px;color:#aaa;font-weight:700;font-size:.7rem;text-transform:uppercase;letter-spacing:.4px;text-align:left;border-bottom:1px solid #f5f5f5;}
table.at td{padding:11px 16px;border-bottom:1px solid #f5f5f5;color:#333;vertical-align:middle;}
table.at tbody tr:last-child td{border-bottom:none;}
table.at tbody tr:hover td{background:#fdfbfb;}
.act-btns{display:flex;gap:6px;align-items:center;}
.btn-edit{background:#fef3c7;color:#b45309;border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:600;}
.btn-del {background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:600;}
.ptype{font-size:.7rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.ptype-pct{background:#fef3c7;color:#92400e;}
.ptype-fix{background:#dcfce7;color:#15803d;}

/* ── Modal ── */
.modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:2000;align-items:center;justify-content:center;}
.modal-bg.open{display:flex;}
.modal-box{background:white;border-radius:18px;padding:2rem;width:100%;max-width:420px;box-shadow:0 8px 32px rgba(0,0,0,.18);}
.modal-box h5{font-weight:900;margin:0 0 1.25rem;font-size:1rem;}
.form-row{margin-bottom:.9rem;}
.form-lbl{display:block;font-size:.76rem;font-weight:700;color:#555;margin-bottom:.3rem;}
.form-inp,.form-sel{width:100%;padding:.5rem .85rem;border:1.5px solid #e8e4e1;border-radius:10px;font-size:.875rem;font-family:'Nunito',sans-serif;outline:none;transition:border-color .2s;background:white;color:#1a0a0f;box-sizing:border-box;}
.form-inp:focus,.form-sel:focus{border-color:var(--cherry);box-shadow:0 0 0 3px rgba(196,30,58,.1);}
.modal-foot{display:flex;gap:8px;margin-top:1.25rem;}
.btn-save{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.55rem 1.5rem;font-size:.85rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;}
.btn-save:hover{background:#9B1530;}
.btn-cancel-m{background:#f2f4f8;color:#555;border:none;border-radius:10px;padding:.55rem 1.1rem;font-size:.85rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;}
</style>
@endsection

@section('content')

{{-- ── Create Modal ── --}}
<div class="modal-bg" id="modalCreate">
    <div class="modal-box">
        <h5><i class="bi bi-tag-fill" style="color:var(--cherry);margin-right:.4rem;"></i>Shto Kupon të Ri</h5>
        @if($errors->any())
        <div style="background:#fee2e2;border-radius:8px;padding:.6rem .9rem;margin-bottom:1rem;font-size:.78rem;color:#dc2626;">
            @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
        </div>
        @endif
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <label class="form-lbl">Kodi i Kuponit *</label>
                <input type="text" name="code" class="form-inp" value="{{ old('code') }}"
                       placeholder="p.sh. SUMMER20" style="text-transform:uppercase;" required>
            </div>
            <div class="form-row">
                <label class="form-lbl">Tipi *</label>
                <select name="type" class="form-sel" required>
                    <option value="percent" {{ old('type')=='percent'?'selected':'' }}>Përqindje (%)</option>
                    <option value="fixed"   {{ old('type')=='fixed'  ?'selected':'' }}>Fikse (€)</option>
                </select>
            </div>
            <div class="form-row">
                <label class="form-lbl">Vlera *</label>
                <input type="number" name="value" class="form-inp" value="{{ old('value') }}"
                       placeholder="p.sh. 20" step="0.01" min="0" required>
            </div>
            <div class="modal-foot">
                <button type="submit" class="btn-save"><i class="bi bi-check2"></i> Ruaj</button>
                <button type="button" class="btn-cancel-m" onclick="closeModal('modalCreate')">Anulo</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Edit Modal ── --}}
<div class="modal-bg" id="modalEdit">
    <div class="modal-box">
        <h5><i class="bi bi-pencil-fill" style="color:#b45309;margin-right:.4rem;"></i>Edito Kuponin</h5>
        <form id="editForm" action="" method="POST">
            @csrf @method('PUT')
            <div class="form-row">
                <label class="form-lbl">Kodi i Kuponit *</label>
                <input type="text" name="code" id="editCode" class="form-inp"
                       style="text-transform:uppercase;" required>
            </div>
            <div class="form-row">
                <label class="form-lbl">Tipi *</label>
                <select name="type" id="editType" class="form-sel" required>
                    <option value="percent">Përqindje (%)</option>
                    <option value="fixed">Fikse (€)</option>
                </select>
            </div>
            <div class="form-row">
                <label class="form-lbl">Vlera *</label>
                <input type="number" name="value" id="editValue" class="form-inp"
                       step="0.01" min="0" required>
            </div>
            <div class="modal-foot">
                <button type="submit" class="btn-save"><i class="bi bi-check2"></i> Përditëso</button>
                <button type="button" class="btn-cancel-m" onclick="closeModal('modalEdit')">Anulo</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Page header ── --}}
<div class="page-head">
    <div>
        <h4>Menaxhimi i Kuponave</h4>
        <p>{{ $coupons->count() }} kupona gjithsej</p>
    </div>
    <button class="btn-add" onclick="openModal('modalCreate')">
        <i class="bi bi-plus-lg"></i> Shto Kupon të Ri
    </button>
</div>

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div class="adm-table-wrap">
    <table class="at">
        <thead>
            <tr><th>#</th><th>Kodi</th><th>Tipi</th><th>Vlera</th><th>Krijuar</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($coupons as $c)
        <tr>
            <td style="color:#aaa;font-size:.75rem;">{{ str_pad($c->id,4,'0',STR_PAD_LEFT) }}</td>
            <td><strong style="font-family:monospace;letter-spacing:1px;font-size:.9rem;">{{ strtoupper($c->code) }}</strong></td>
            <td><span class="ptype {{ $c->type==='percent'?'ptype-pct':'ptype-fix' }}">
                {{ $c->type==='percent' ? 'Përqindje' : 'Fikse' }}
            </span></td>
            <td style="font-weight:700;">{{ $c->type==='percent' ? $c->value.'%' : '€ '.number_format($c->value,2) }}</td>
            <td style="color:#aaa;font-size:.78rem;">{{ $c->created_at->format('d M Y') }}</td>
            <td>
                <div class="act-btns">
                    <button class="btn-edit"
                            onclick="openEdit({{ $c->id }},'{{ addslashes($c->code) }}','{{ $c->type }}','{{ $c->value }}')">
                        <i class="bi bi-pencil"></i> Edito
                    </button>
                    <form action="{{ route('admin.coupons.destroy',$c->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn-del" onclick="return confirm('Fshi kuponin {{ strtoupper($c->code) }}?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:3rem;color:#aaa;">
            <i class="bi bi-tag" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
            Nuk ka kupona. Shto kuponin e parë!
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
function openEdit(id, code, type, value) {
    document.getElementById('editForm').action = '/labcourse/public/admin/coupons/' + id;
    document.getElementById('editCode').value  = code;
    document.getElementById('editType').value  = type;
    document.getElementById('editValue').value = value;
    openModal('modalEdit');
}
// Close on backdrop click
['modalCreate','modalEdit'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});
// Auto-open create modal if there were validation errors
@if($errors->any())
openModal('modalCreate');
@endif
</script>
@endsection
