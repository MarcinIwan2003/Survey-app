@extends('layouts.app')

@section('title', 'Dołącz do Quizu')

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
        max-width: 500px;
        margin: auto;
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
</style>

<div class="d-flex justify-content-center align-items-center ">
    <div class="glass-card p-5 text-white w-100">
        <h2 class="fw-bold text-center mb-4">🚀 Dołącz do quizu</h2>

        {{-- Komunikaty --}}
        @if (session('status'))
            <div class="alert alert-success text-center bg-opacity-75">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center bg-opacity-75">
                {{ session('error') }}
            </div>
        @endif

        {{-- Formularz --}}
        <form method="POST" action="{{ route('quiz.start') }}">
            @csrf

            <div class="form-floating mb-4">
                <input type="text" name="nickname" id="nickname"
                       class="form-control bg-light bg-opacity-75 text-dark @error('nickname') is-invalid @enderror"
                       required placeholder="Twój nick" value="{{ old('nickname') }}">
                <label for="nickname">Twój nick</label>
                @error('nickname')
                    <div class="invalid-feedback text-white">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input type="text" name="code" id="code"
                       class="form-control bg-light bg-opacity-75 text-dark @error('code') is-invalid @enderror"
                       required placeholder="Kod quizu" value="{{ old('code') }}">
                <label for="code">Kod quizu</label>
                @error('code')
                    <div class="invalid-feedback text-white">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-light text-primary btn-submit w-100 shadow-sm">
                Dołącz teraz 🎯
            </button>
        </form>
    </div>
</div>
@endsection
