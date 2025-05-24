@extends('layouts.app')

@section('title', 'Moje Ankiety')

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
        -webkit-backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        padding: 2rem;
        color: #fff;
        transition: transform 0.3s ease-in-out;
    }

    .glass-card:hover {
        transform: scale(1.01);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .survey-code {
        font-size: 0.9rem;
        color: #ddd;
    }

    .btn-view {
        font-weight: 600;
        font-size: 1rem;
        padding: 0.75rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-view:hover {
        transform: scale(1.02);
    }

    @media (max-width: 576px) {
        h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container py-5">
    <h2 class="text-center fw-bold text-white mb-5">📝 Moje Ankiety</h2>

    <div class="row justify-content-center">
        @forelse ($surveys as $survey)
            <div class="col-md-4 mb-4">
                <div class="glass-card text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $survey->title }}</h5>
                        <p class="survey-code">Kod ankiety: {{ $survey->code }}</p>
                    </div>
                    <div>
                        <a href="{{ route('surveys.show', $survey) }}" class="btn btn-light text-primary btn-view w-100 shadow-sm mt-4">
                            Podgląd 📄
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-white">Brak utworzonych ankiet.</p>
        @endforelse
    </div>
</div>
@endsection
