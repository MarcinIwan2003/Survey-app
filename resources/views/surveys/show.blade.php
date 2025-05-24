@extends('layouts.app')

@section('title', 'Podgląd Ankiety')

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
        color: #fff;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .glass-question {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .correct-answer {
        background-color: rgba(40, 167, 69, 0.3);
        border-left: 5px solid #28a745;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .wrong-answer {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .btn-back {
        margin-top: 2rem;
        font-weight: 600;
        border-radius: 0.75rem;
    }

    h2, h5, h6, p {
        color: #fff;
    }

    @media (max-width: 576px) {
        h2 {
            font-size: 1.5rem;
        }

        .glass-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="container py-5">
    <h2 class="text-center fw-bold text-white mb-5">🔎 Podgląd Ankiety</h2>

    <div class="glass-card">
        <div class="mb-4">
            <h5 class="card-title">{{ $survey->title }}</h5>
            <p class="text-light">Kod ankiety: <strong>{{ $survey->code }}</strong></p>
        </div>

        <h5 class="mb-4">📋 Pytania:</h5>

        @forelse ($survey->questions as $question)
            <div class="glass-question">
                <p class="mb-2"><strong>{{ $loop->iteration }}. {{ $question->text }}</strong></p>

                @if($question->explanation)
                    <p><em>ℹ️ Wyjaśnienie:</em> {{ $question->explanation }}</p>
                @endif

                <p class="mb-1">Typ pytania: <strong>{{ ucfirst($question->type) }}</strong></p>
                <p class="mb-1">Czas na przeczytanie: <strong>{{ $question->read_time }} sek.</strong></p>
                <p class="mb-3">Czas na odpowiedź: <strong>{{ $question->answer_time }} sek.</strong></p>

                <h6 class="mt-3 mb-2">📝 Odpowiedzi:</h6>
                @foreach ($question->options as $option)
                    <div class="{{ $option->is_correct ? 'correct-answer' : 'wrong-answer' }}">
                        {{ $option->text }}
                    </div>
                @endforeach
            </div>
        @empty
            <p>Brak pytań w tej ankiecie.</p>
        @endforelse
    </div>

    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-light text-primary btn-back shadow-sm">
            ⬅️ Powrót do panelu
        </a>
    </div>
</div>
@endsection
