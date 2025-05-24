@extends('layouts.app')

@section('title', 'Wyniki Ankiet')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1d2b64, #f8cdda);
    }

    [data-bs-theme="dark"] body {
        background: linear-gradient(135deg, #000428, #004e92);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        padding: 2rem;
        color: white;
        transition: transform 0.3s ease;
        text-align: center;
        height: 100%;
    }

    .glass-card:hover {
        transform: scale(1.02);
    }

    .survey-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .survey-code {
        color: #ccc;
        font-size: 0.9rem;
    }
</style>

<div class="container py-5">
    <h2 class="text-white text-center fw-bold mb-5">📊 Wyniki Twoich Ankiet</h2>

    <div class="row justify-content-center">
        @forelse($surveys as $survey)
            <div class="col-md-4 mb-4">
                <a href="{{ route('results.show', $survey) }}" class="text-decoration-none">
                    <div class="glass-card h-100">
                        <div class="survey-title">{{ $survey->title }}</div>
                        <div class="survey-code">Kod: {{ $survey->code }}</div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-white text-center">Brak dostępnych ankiet.</p>
        @endforelse
    </div>
</div>
@endsection
