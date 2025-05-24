<!DOCTYPE html>
<html lang="pl" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quiz App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e8f0ff, #fceff9);
            transition: background 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #000428, #004e92);
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.85) !important;
        }

        [data-bs-theme="dark"] .navbar {
            background-color: rgba(30, 30, 30, 0.9) !important;
        }

        .navbar-brand {
            font-size: 1.25rem;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem;
            }
        }

        .btn-modern {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 500;
            border: none;
            color: white;
            background: linear-gradient(135deg, #6c63ff, #3f8efc);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-modern:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        .btn-outline-modern {
            background: rgba(255, 255, 255, 0.15);
            color: #3f8efc;
            border: 1px solid #3f8efc;
        }

        .btn-outline-modern:hover {
            background: #3f8efc;
            color: white;
        }

        .btn-auth {
            min-width: 120px;
            text-align: center;
        }

        @media (max-width: 576px) {
            .btn-auth {
                padding: 0.4rem 0.75rem;
                font-size: 0.75rem;
            }
        }

        .form-switch .form-check-input {
            width: 3rem;
            height: 1.5rem;
            background-color: #ccc;
            border: none;
            transition: all 0.3s ease;
        }

        .form-switch .form-check-input:checked {
            background-color: #3f8efc;
        }

        .form-switch .form-check-input:focus {
            box-shadow: none;
        }

        .navbar-toggler {
            border: none;
            padding: 6px 10px;
            border-radius: 10px;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23222' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0,0,0,0.7)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        [data-bs-theme="dark"] .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.8)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        footer {
            font-size: 0.85rem;
            text-align: center;
            padding: 1rem;
            color: #777;
        }

        [data-bs-theme="dark"] footer {
            color: #aaa;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">🎯 Quiz App</a>

        @guest
            <div class="ms-auto d-flex flex-row flex-wrap align-items-center gap-2 mt-2">
                <a href="{{ route('login') }}" class="btn btn-outline-modern btn-modern btn-auth">Zaloguj się</a>
                <a href="{{ route('register') }}" class="btn btn-modern btn-auth">Zarejestruj się</a>
                <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle" role="switch">
                    <span id="themeIcon" class="ms-2 fs-5">🌙</span>
                </div>
            </div>
        @else
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <div class="ms-auto d-flex flex-column flex-lg-row gap-2 mt-3 mt-lg-0 align-items-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-modern btn-auth">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-modern btn-modern btn-auth">Wyloguj się</button>
                    </form>
                    <div class="form-check form-switch d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" id="darkModeToggle" role="switch">
                        <span id="themeIcon" class="ms-2 fs-5">🌙</span>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<footer>
    &copy; {{ date('Y') }} Quiz App. Wszelkie prawa zastrzeżone.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const html = document.documentElement;
    const themeSwitch = document.getElementById('darkModeToggle');
    const themeIcon = document.getElementById('themeIcon');

    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    themeSwitch.checked = savedTheme === 'dark';
    themeIcon.textContent = savedTheme === 'dark' ? '☀️' : '🌙';

    themeSwitch.addEventListener('change', () => {
        const newTheme = themeSwitch.checked ? 'dark' : 'light';
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        themeIcon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
    });
</script>

</body>
</html>
