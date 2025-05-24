@extends('layouts.app')

@section('title', 'Quiz')

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
        max-width: 800px;
        margin: auto;
        padding: 2rem;
        color: white;
    }

    .progress-wrapper {
        width: 100%;
        margin-bottom: 1rem;
    }

    .progress {
        height: 14px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: limegreen;
        height: 100%;
        transition: width 0.1s linear, background-color 0.3s ease;
    }

    .blinking {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0.3;
        }
    }

    .time-counter {
        font-weight: bold;
        font-size: 1.25rem;
        min-width: 40px;
        text-align: right;
        color: white;
    }

    .option-tile {
        border-radius: 1rem;
        padding: 2rem;
        margin: 1rem 0;
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .option-tile:hover {
        transform: scale(1.05);
        opacity: 0.95;
    }

    .color-yellow {
        background-color: #f1c40f;
    }

    .color-red {
        background-color: #e74c3c;
    }

    .color-blue {
        background-color: #3498db;
    }

    .color-green {
        background-color: #2ecc71;
    }

    @media (max-width: 576px) {
        .option-tile {
            padding: 1rem;
            font-size: 1rem;
        }

        .glass-card {
            padding: 1.5rem;
        }

        .time-counter {
            font-size: 1rem;
        }
    }
</style>

<div class="glass-card w-100">
<h4 class="fw-bold text-center mb-2" style="font-size: 1.25rem;">🧠 Pytanie {{ $session->current_question_index + 1 }}</h4>
<h2 class="question-text text-center mb-4">{{ $question->text }}</h2>


    {{-- Pasek czasu + licznik --}}
    <div class="progress-wrapper">
        <div class="progress">
            <div id="timer-bar" class="progress-bar" style="width: 100%"></div>
        </div>
        <div class="time-counter mt-2" id="time-left"></div>
    </div>

    {{-- Formularz odpowiedzi --}}
    <form method="POST" action="{{ route('quiz.answer', $session) }}" id="answer-form">
        @csrf
        <input type="hidden" name="option_id" id="option_id">

        @php
            $colors = ['color-yellow', 'color-red', 'color-blue', 'color-green'];
        @endphp

        <div class="row">
            @foreach ($question->options as $index => $option)
                <div class="col-md-6">
                    <div class="option-tile {{ $colors[$index % 4] }}" data-id="{{ $option->id }}">
                        {{ $option->text }}
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>

<script>
    const readTime = {{ $question->read_time }};
    const answerTime = {{ $question->answer_time }};
    const totalTime = readTime + answerTime;
    const startTime = Date.now();
    const endTime = startTime + totalTime * 1000;

    const timerBar = document.getElementById('timer-bar');
    const timeCounter = document.getElementById('time-left');
    const form = document.getElementById('answer-form');
    const optionInput = document.getElementById('option_id');

    const tick = () => {
        const now = Date.now();
        const msLeft = Math.max(endTime - now, 0);
        const secondsLeft = Math.ceil(msLeft / 1000);
        const percent = (msLeft / (totalTime * 1000)) * 100;

        timerBar.style.width = percent + '%';
        timeCounter.innerText = secondsLeft + 's';

        if (secondsLeft <= 5) {
            timerBar.classList.add('blinking');
            timerBar.style.backgroundColor = 'red';
        }

        if (msLeft <= 0) {
            clearInterval(timerInterval);
            optionInput.value = '';
            form.submit();
        }
    };

    const timerInterval = setInterval(tick, 100);
    tick(); // uruchom od razu

    document.querySelectorAll('.option-tile').forEach(tile => {
        tile.addEventListener('click', () => {
            optionInput.value = tile.getAttribute('data-id');
            clearInterval(timerInterval);
            form.submit();
        });
    });
</script>
@endsection
