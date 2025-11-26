<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="{{ Cookie::get('tema', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Laravel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .theme-switcher {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('produtos.index') }}">🏪 Sistema Laravel</a>
            
            <div class="navbar-nav ms-auto">
                @if(session('user'))
                    <span class="navbar-text me-3">
                        Olá, {{ session('user')['name'] }}
                    </span>
                    <a class="nav-link theme-switcher me-3">
                        @if(Cookie::get('tema') === 'dark')
                            ☀️ Claro
                        @else
                            🌙 Escuro
                        @endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">🚪 Sair</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">🔐 Login</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="mt-5 py-3 bg-light text-center">
        <div class="container">
            <small class="text-muted">
                @if(Cookie::get('ultima_visita_produtos'))
                    Última visita: {{ Cookie::get('ultima_visita_produtos') }}
                @endif
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Alternador de tema
        document.querySelector('.theme-switcher').addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            
            // Enviar requisição para salvar preferência
            window.location.href = '{{ route("produtos.index") }}?tema=' + newTheme;
        });
    </script>
</body>
</html>