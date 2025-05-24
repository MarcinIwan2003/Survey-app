@extends('layouts.app')

@section('title', 'Podsumowanie Quizu')

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
        margin-bottom: 2rem;
        color: white;
    }

    .question-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #fff;
    }

    .answer-correct {
        background-color: rgba(40, 167, 69, 0.25);
        border-left: 6px solid #28a745;
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 0.5rem;
    }

    .answer-wrong {
        background-color: rgba(220, 53, 69, 0.25);
        border-left: 6px solid #dc3545;
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 0.5rem;
    }

    .correct-answer {
        background-color: rgba(40, 167, 69, 0.15);
        border: 1px dashed #28a745;
        padding: 1rem;
        border-radius: 0.75rem;
        font-size: 1.1rem;
        color: #28ff7a;
        margin-top: 0.75rem;
        font-weight: bold;
    }

    .explanation {
        background-color: rgba(255, 255, 255, 0.05);
        border-left: 4px solid #17a2b8;
        padding: 0.9rem 1.2rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        color: #d1ecf1;
        margin-top: 0.5rem;
    }

    .summary-header {
        text-align: center;
        color: white;
        font-weight: bold;
        margin-bottom: 3rem;
        font-size: 2rem;
    }

    @media (max-width: 576px) {
        .glass-card {
            padding: 1.5rem;
        }

        .question-title {
            font-size: 1.2rem;
        }

        .correct-answer,
        .explanation {
            font-size: 0.95rem;
        }
    }
</style>

<div class="container py-5">
    <h2 class="summary-header">📊 Podsumowanie Quizu</h2>

    @foreach ($questions as $question)
        @php
            $userAnswer = $answers->get($question->id);
            $selectedOption = $userAnswer ? $question->options->firstWhere('id', $userAnswer->option_id) : null;
            $correctOption = $question->options->firstWhere('is_correct', true);
            $isCorrect = $selectedOption && $selectedOption->is_correct;
        @endphp

        <div class="glass-card">
            <div class="question-title">{{ $loop->iteration }}. {{ $question->text }}</div>

            @if ($selectedOption)
                <div class="{{ $isCorrect ? 'answer-correct' : 'answer-wrong' }}">
                    <strong>Twoja odpowiedź:</strong> {{ $selectedOption->text }}
                </div>
            @else
                <div class="answer-wrong">
                    <strong>Brak odpowiedzi</strong>
                </div>
            @endif

            @if (!$isCorrect && $correctOption)
                <div class="correct-answer">✅ Poprawna odpowiedź: {{ $correctOption->text }}</div>
            @endif

            @if (!$isCorrect && $question->explanation)
                <div class="explanation">ℹ️ <strong>Wyjaśnienie:</strong> {{ $question->explanation }}</div>
            @endif
        </div>
    @endforeach

    <div class="text-center mt-5">
        <a href="{{ route('home') }}" class="btn btn-light text-primary fw-bold px-4 py-2 rounded-3 shadow-sm">
            🔙 Powrót do strony głównej
        </a>
    </div>
</div>
@endsection
