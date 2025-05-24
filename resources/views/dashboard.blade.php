@extends('layouts.app')

@section('title', 'Panel Użytkownika')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1d2b64, #f8cdda);
    }

    [data-bs-theme="dark"] body {
        background: linear-gradient(135deg, #000428, #004e92);
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
    }

    .dashboard-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .dashboard-title {
        font-weight: 600;
        font-size: 1.25rem;
    }

    @media (max-width: 768px) {
        .dashboard-icon {
            font-size: 2.5rem;
        }
        .dashboard-title {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container py-5">
    <h2 class="text-center text-white fw-bold mb-5">👤 Witaj w swoim panelu</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-10 col-md-6 col-lg-4">
            <a href="{{ route('surveys.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="dashboard-icon">📋</div>
                    <div class="dashboard-title">Moje ankiety</div>
                </div>
            </a>
        </div>
        <div class="col-10 col-md-6 col-lg-4">
            <a href="{{ route('results.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="dashboard-icon">📊</div>
                    <div class="dashboard-title">Zobacz wyniki</div>
                </div>
            </a>
        </div>
        <div class="col-10 col-md-6 col-lg-4">
            <a href="{{ route('surveys.create') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="dashboard-icon">➕</div>
                    <div class="dashboard-title">Utwórz nową ankietę</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection