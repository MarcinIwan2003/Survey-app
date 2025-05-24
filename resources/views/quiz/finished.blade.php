@extends('layouts.app')

@section('title', 'Quiz Zakończony')

@section('content')
<div class="container py-5 text-center text-white">
    <h2 class="fw-bold mb-4">🎉 Gratulacje!</h2>
    <p>Ukończyłeś/aś quiz jako <strong>{{ $session->nickname }}</strong>.</p>
    <p>Dziękujemy za udział!</p>

    <a href="{{ route('welcome') }}" class="btn btn-light mt-4">Powrót</a>
</div>
@endsection
