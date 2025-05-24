@extends('layouts.app')

@section('title', 'Utwórz nową ankietę')

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
        max-width: 1000px;
        margin: auto;
        padding: 3rem;
        color: white;
    }

    .form-control {
        border-radius: 0.75rem;
        padding: 1rem;
    }

    .btn-submit {
        font-weight: 600;
        font-size: 1.1rem;
        padding: 0.75rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-submit:hover {
        transform: scale(1.02);
    }

    [data-bs-theme="dark"] .form-control {
        background-color: rgba(255, 255, 255, 0.07);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .form-control::placeholder {
        color: #bbb;
    }

    [data-bs-theme="dark"] label {
        color: #ddd;
    }

    @media (max-width: 576px) {
        h2 {
            font-size: 1.5rem;
        }

        .glass-card {
            padding: 2rem !important;
        }
    }

    .question-card.collapsed .question-body {
        display: none;
    }

    .question-card-header {
        cursor: pointer;
    }
</style>

<div class="d-flex justify-content-center align-items-center">
    <div class="glass-card w-100">
        <h2 class="fw-bold text-center mb-4">🧩 Utwórz nową ankietę</h2>

        <form method="POST" action="{{ route('surveys.store') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label">Tytuł ankiety</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div id="questionsWrapper"></div>

            <button type="button" class="btn btn-light text-primary w-100 mb-4" onclick="addQuestion()">
                ➕ Dodaj pytanie
            </button>

            <button type="submit" class="btn btn-success w-100">
                📤 Zapisz ankietę
            </button>
        </form>
    </div>
</div>

<script>
    let questionIndex = 0;

    function addQuestion() {
        document.querySelectorAll('.question-card').forEach(q => q.classList.add('collapsed'));
        const wrapper = document.getElementById('questionsWrapper');
        const div = document.createElement('div');
        div.className = 'card bg-light bg-opacity-75 text-dark mb-4 question-card';
        div.innerHTML = `
            <div class="card-header question-card-header" onclick="this.parentElement.classList.toggle('collapsed')">
                <strong>Pytanie #${questionIndex + 1}</strong>: <span class="preview-text">(Nowe pytanie)</span>
            </div>
            <div class="card-body question-body">
                <div class="mb-2">
                    <label>Treść pytania</label>
                    <input type="text" name="questions[${questionIndex}][text]" class="form-control" required oninput="updatePreviewText(this)">
                </div>

                <div class="mb-2">
                    <label>Typ pytania</label>
                    <select name="questions[${questionIndex}][type]" class="form-select" onchange="renderOptions(${questionIndex}, this.value)">
                        <option value="abc">ABCD</option>
                        <option value="truefalse">Prawda / Fałsz</option>
                        <option value="binary">2 odpowiedzi</option>
                    </select>
                </div>

                <div id="options_${questionIndex}" class="mb-3"></div>

                <div class="mb-3">
                    <label>Wyjaśnienie (opcjonalne)</label>
                    <textarea name="questions[${questionIndex}][explanation]" class="form-control" rows="2" placeholder="Wyjaśnienie poprawnej odpowiedzi"></textarea>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Czas na przeczytanie (sekundy)</label>
                        <input type="number" name="questions[${questionIndex}][read_time]" class="form-control" min="1" value="5">
                    </div>
                    <div class="col">
                        <label>Czas na odpowiedź (sekundy)</label>
                        <input type="number" name="questions[${questionIndex}][answer_time]" class="form-control" min="1" value="10">
                    </div>
                </div>
            </div>
        `;

        wrapper.appendChild(div);
        renderOptions(questionIndex, 'abc');
        questionIndex++;
    }

    function renderOptions(index, type) {
        const container = document.getElementById(`options_${index}`);
        const optionLabels = {
            abc: ['A', 'B', 'C', 'D'],
            binary: ['1', '2'],
            truefalse: ['Prawda', 'Fałsz']
        }[type];

        let html = '<label>Odpowiedzi <small>(zaznacz poprawną)</small></label>';
        optionLabels.forEach((label, i) => {
            const required = (type === 'truefalse') ? '' : 'required';
            const value = type === 'truefalse' ? label : '';
            html += `
                <div class="input-group mb-2">
                    <span class="input-group-text">${label}</span>
                    <input type="text" name="questions[${index}][options][${i}][text]" class="form-control" value="${value}" ${required} ${type === 'truefalse' ? 'readonly' : ''}>
                    <span class="input-group-text">
                        <input type="radio" name="questions[${index}][correct]" value="${i}" required>
                    </span>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    function updatePreviewText(input) {
        const parent = input.closest('.question-card');
        parent.querySelector('.preview-text').textContent = input.value || '(Nowe pytanie)';
    }
</script>
@endsection