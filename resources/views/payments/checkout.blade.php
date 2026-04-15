@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-white fw-bold text-center">Procedimi i Pagesës</div>
                <div class="card-body p-4">
                    <div class="mb-4 text-center">
                        <h5>Libri: <strong>{{ $book->titulli }}</strong></h5>
                        <p class="text-success fs-4 fw-bold">Çmimi: {{ $book->cmimi }} €</p>
                    </div>

                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                        <input type="hidden" name="shuma" value="{{ $book->cmimi }}">

                        <div class="mb-3">
                            <label class="form-label">Numri i Kartelës</label>
                            <input type="text" name="card_number" class="form-control" placeholder="0000 0000 0000 0000" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data e Skadimit</label>
                                <input type="text" name="expiry" class="form-control" placeholder="MM/YY" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CVV</label>
                                <input type="text" name="cvv" class="form-control" placeholder="123" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg mt-3">Paguaj Tani</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection