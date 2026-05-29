@extends('layouts.client')

@section('title', 'Checkout — ' . $book->titulli)
@section('page-title', 'Checkout')
@section('page-sub', 'Plotëso pagesën për librin')

@section('styles')
<style>
.checkout-wrap {
    max-width: 520px;
    margin: 0 auto;
}
.checkout-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    margin-bottom: 16px;
}
.book-summary {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #fff8f9;
    border-radius: 14px;
    border: 1.5px solid #fde0e5;
    margin-bottom: 1.5rem;
}
.book-thumb {
    width: 56px; height: 72px;
    background: linear-gradient(135deg, #fdf0f3, #ffe4ec);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1.6rem;
    color: var(--cherry);
}
.book-meta-title { font-weight: 800; font-size: .95rem; color: #1a0a0f; margin-bottom: 2px; }
.book-meta-author { font-size: .78rem; color: #aaa; }
.book-meta-price { font-size: 1.2rem; font-weight: 900; color: var(--cherry); margin-top: 4px; }

.form-group { margin-bottom: 1rem; }
.form-lbl { display: block; font-size: .76rem; font-weight: 700; color: #555; margin-bottom: .35rem; }
.form-inp {
    width: 100%; padding: .55rem .9rem;
    border: 1.5px solid #e8e4e1; border-radius: 10px;
    font-size: .88rem; font-family: 'Nunito', sans-serif;
    outline: none; background: white; transition: border-color .2s;
}
.form-inp:focus { border-color: var(--cherry); box-shadow: 0 0 0 3px rgba(196,30,58,.08); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

.card-preview {
    background: linear-gradient(135deg, #1C0A0E 0%, #3d1020 60%, #6b1530 100%);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    color: white;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}
.card-preview::before {
    content: '';
    position: absolute; right: -20px; top: -20px;
    width: 100px; height: 100px;
    background: rgba(255,255,255,.07); border-radius: 50%;
}
.card-chip { width: 32px; height: 24px; background: #f59e0b; border-radius: 5px; margin-bottom: .75rem; }
.card-num { font-size: 1rem; font-weight: 700; letter-spacing: 3px; margin-bottom: .5rem; font-family: monospace; }
.card-row { display: flex; justify-content: space-between; font-size: .7rem; opacity: .7; }

.btn-pay {
    width: 100%; padding: .75rem;
    background: var(--cherry); color: white;
    border: none; border-radius: 12px;
    font-size: 1rem; font-weight: 800;
    font-family: 'Nunito', sans-serif;
    cursor: pointer; transition: background .2s;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
}
.btn-pay:hover { background: #9B1530; }

.secure-note {
    text-align: center; font-size: .72rem; color: #aaa;
    margin-top: .75rem;
    display: flex; align-items: center; justify-content: center; gap: 4px;
}
</style>
@endsection

@section('content')
<div style="margin-bottom:16px;">
    <a href="{{ route('books.show', $book->id) }}" style="color:#aaa;font-size:.83rem;text-decoration:none;">
        <i class="bi bi-arrow-left"></i> Kthehu te libri
    </a>
</div>

<div class="checkout-wrap">

    {{-- Book summary --}}
    <div class="checkout-card">
        <div style="font-weight:800;font-size:.9rem;margin-bottom:1rem;">Detajet e Porosisë</div>
        <div class="book-summary">
            <div class="book-thumb">
                <i class="bi bi-book-half"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div class="book-meta-title">{{ $book->titulli }}</div>
                <div class="book-meta-author">{{ $book->author->emri ?? '' }} {{ $book->author->mbiemri ?? '' }}</div>
                <div class="book-meta-price">€ {{ number_format($book->cmimi, 2) }}</div>
            </div>
        </div>

        <div style="display:flex;justify-content:space-between;font-size:.83rem;padding:6px 0;border-top:1px solid #f5f0ec;">
            <span style="color:#aaa;font-weight:600;">Nëntotal</span>
            <span style="font-weight:700;">€ {{ number_format($book->cmimi, 2) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:.83rem;padding:6px 0;">
            <span style="color:#aaa;font-weight:600;">Dërgesa</span>
            <span style="font-weight:700;color:#16a34a;">Falas</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:1rem;padding:10px 0 0;border-top:1px solid #f5f0ec;margin-top:4px;">
            <span style="font-weight:800;">Totali</span>
            <span style="font-weight:900;color:var(--cherry);font-size:1.1rem;">€ {{ number_format($book->cmimi, 2) }}</span>
        </div>
    </div>

    {{-- Payment form --}}
    <div class="checkout-card">
        <div style="font-weight:800;font-size:.9rem;margin-bottom:1rem;">
            <i class="bi bi-credit-card-2-front-fill" style="color:var(--cherry);margin-right:6px;"></i>
            Të dhënat e Kartës
        </div>

        {{-- Card preview --}}
        <div class="card-preview">
            <div class="card-chip"></div>
            <div class="card-num" id="prev-num">**** **** **** ****</div>
            <div class="card-row">
                <span id="prev-name">EMRI MBIEMRI</span>
                <span id="prev-exp">MM/YY</span>
            </div>
        </div>

        <form action="{{ route('payments.process', $book->id) }}" method="POST">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <input type="hidden" name="shuma"   value="{{ $book->cmimi }}">

            <div class="form-group">
                <label class="form-lbl">Numri i Kartës</label>
                <input type="text" name="card_number" class="form-inp" id="inp-num"
                       placeholder="0000 0000 0000 0000" maxlength="19"
                       oninput="fmtCard(this)" required>
            </div>

            <div class="form-group">
                <label class="form-lbl">Emri në Kartë</label>
                <input type="text" name="card_name" class="form-inp" id="inp-name"
                       placeholder="Emri Mbiemri"
                       oninput="document.getElementById('prev-name').textContent=this.value.toUpperCase()||'EMRI MBIEMRI'">
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-lbl">Data e Skadimit</label>
                    <input type="text" name="expiry" class="form-inp" id="inp-exp"
                           placeholder="MM/YY" maxlength="5"
                           oninput="fmtExp(this)" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-lbl">CVV</label>
                    <input type="text" name="cvv" class="form-inp"
                           placeholder="123" maxlength="3" required>
                </div>
            </div>

            <div style="margin-top:1.5rem;">
                <button type="submit" class="btn-pay">
                    <i class="bi bi-lock-fill"></i>
                    Paguaj € {{ number_format($book->cmimi, 2) }}
                </button>
                <div class="secure-note">
                    <i class="bi bi-shield-check-fill" style="color:#16a34a;"></i>
                    Pagesa e sigurt — të dhënat e kartës nuk ruhen
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
function fmtCard(el) {
    let v = el.value.replace(/\D/g,'').substring(0,16);
    el.value = v.match(/.{1,4}/g)?.join(' ') || v;
    const padded = (v + '****************').substring(0,16);
    document.getElementById('prev-num').textContent =
        padded.match(/.{1,4}/g).join(' ');
}
function fmtExp(el) {
    let v = el.value.replace(/\D/g,'').substring(0,4);
    if (v.length >= 3) v = v.substring(0,2) + '/' + v.substring(2);
    el.value = v;
    document.getElementById('prev-exp').textContent = el.value || 'MM/YY';
}
</script>
@endsection
