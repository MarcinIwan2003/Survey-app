@extends('layouts.app')

@section('title', 'Rejestracja')

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
        width: 100%;
        padding: 5rem;
        color: white;
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
        width: 100%;
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

    .invalid-feedback {
        display: block;
    }

    @media (max-width: 576px) {
        .glass-card {
            padding: 2rem;
            margin: 1rem;
        }

        h2 {
            font-size: 1.5rem;
        }
    }
</style>


    <div class="glass-card">
        <h2 class="fw-bold text-center mb-4">📝 Rejestracja</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-floating mb-4">
                <input id="name" type="text" class="form-control bg-light bg-opacity-75 text-dark @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Imię i nazwisko">
                <label for="name">Imię i nazwisko</label>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input id="email" type="email" class="form-control bg-light bg-opacity-75 text-dark @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Adres email">
                <label for="email">Adres email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input id="password" type="password" class="form-control bg-light bg-opacity-75 text-dark @error('password') is-invalid @enderror" name="password" required placeholder="Hasło">
                <label for="password">Hasło</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input id="password-confirm" type="password" class="form-control bg-light bg-opacity-75 text-dark" name="password_confirmation" required placeholder="Potwierdź hasło">
                <label for="password-confirm">Potwierdź hasło</label>
            </div>

            <button type="submit" class="btn btn-light text-primary btn-submit shadow-sm">
                Zarejestruj się
            </button>
        </form>
    </div>

@endsection
