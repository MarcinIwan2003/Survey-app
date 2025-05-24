@extends('layouts.app')

@section('title', 'Statystyki Ankiety')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1d2b64, #f8cdda);
    }

    [data-bs-theme="dark"] body {
        background: linear-gradient(135deg, #000428, #004e92);
    }

    .glass-section {
        background: rgba(255, 255, 255, 0.12);
        border-radius: 1.5rem;
        backdrop-filter: blur(20px);
        padding: 2rem;
        color: white;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        margin-bottom: 2rem;
    }

    .question-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .stat-line {
        margin: 0.25rem 0;
    }

    .option-box {
        background-color: rgba(255,255,255,0.1);
        border-radius: 0.75rem;
        padding: 0.75rem;
        margin-top: 0.5rem;
    }

    .option-correct {
        border-left: 4px solid #28a745;
    }
</style>

<div class="container py-5">
    <h2 class="text-white fw-bold mb-5 text-center">📋 Statystyki: {{ $survey->title }}</h2>

    {{-- Ogólne podsumowanie --}}
    <div class="glass-section mb-5">
        <h4 class="mb-3">📈 Ogólne Statystyki</h4>
        <p class="stat-line">📋 Liczba pytań: <strong>{{ count($questionStats) }}</strong></p>
        <p class="stat-line">🧾 Łączna liczba odpowiedzi: <strong>{{ $overallTotal }}</strong></p>
        <p class="stat-line">✅ Łączna liczba poprawnych odpowiedzi: <strong>{{ $overallCorrect }}</strong></p>
        <p class="stat-line">📊 Średnia skuteczność: <strong>{{ $averagePercent }}%</strong></p>

        @if ($mostKnown && $leastKnown)
            <p class="stat-line mt-3">🏆 Najlepiej znane pytanie:
                <strong>"{{ $mostKnown['text'] }}"</strong> ({{ $mostKnown['percent'] }}%)</p>
            <p class="stat-line">❗ Najsłabiej znane pytanie:
                <strong>"{{ $leastKnown['text'] }}"</strong> ({{ $leastKnown['percent'] }}%)</p>
        @endif
    </div>

    {{-- Statystyki per pytanie --}}
    @foreach ($questionStats as $q)
        <div class="glass-section">
            <div class="question-title">{{ $loop->iteration }}. {{ $q['text'] }}</div>

            <p class="stat-line">🧮 Odpowiedzi: <strong>{{ $q['total'] }}</strong></p>
            <p class="stat-line">✅ Poprawnych: <strong>{{ $q['correct'] }}</strong></p>
            <p class="stat-line">📈 Skuteczność: <strong>{{ $q['percent'] }}%</strong></p>

            <div class="mt-3">
                <p class="fw-bold mb-2">Rozkład odpowiedzi:</p>
                @foreach ($q['options'] as $opt)
                    <div class="option-box {{ $opt['is_correct'] ? 'option-correct' : '' }}">
                        {{ $opt['text'] }} — <strong>{{ $opt['count'] }}</strong> odpowiedzi
                        @if($opt['is_correct']) <span class="text-success ms-2">(Poprawna)</span> @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="text-center mt-4">
        <a href="{{ route('results.index') }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 py-2">
            🔙 Wróć do listy ankiet
        </a>
    </div>
</div>
@endsection
