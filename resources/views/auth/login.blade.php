<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - {{ Setting::get('site_name', 'VerdeParis75') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --vp-green: #2d6a4f;
            --vp-green-light: #40916c;
            --vp-green-dark: #1b4332;
            --vp-gold: #d4a853;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 50%, #40916c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }
        .login-header {
            background: var(--vp-green-dark);
            padding: 30px;
            text-align: center;
            color: #fff;
        }
        .login-header .brand {
            color: var(--vp-gold);
            font-size: 1.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .login-header .brand i {
            font-size: 1.8rem;
        }
        .login-header p {
            margin: 8px 0 0;
            font-size: .85rem;
            opacity: .7;
        }
        .login-body {
            padding: 30px;
        }
        .login-body .form-label {
            font-weight: 600;
            font-size: .85rem;
            color: #555;
        }
        .login-body .form-control {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            transition: border-color .2s, box-shadow .2s;
        }
        .login-body .form-control:focus {
            border-color: var(--vp-green-light);
            box-shadow: 0 0 0 .2rem rgba(45,106,79,.15);
        }
        .login-body .input-group-text {
            background: #f8f9fa;
            border: 1.5px solid #ddd;
            border-right: none;
            border-radius: 8px 0 0 8px;
            color: var(--vp-green);
        }
        .login-body .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        .btn-login {
            background: var(--vp-green);
            color: #fff;
            border: none;
            padding: 11px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            font-size: .95rem;
            transition: background .3s;
        }
        .btn-login:hover {
            background: var(--vp-green-light);
            color: #fff;
        }
        .form-check-input:checked {
            background-color: var(--vp-green);
            border-color: var(--vp-green);
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: rgba(255,255,255,.7);
            text-decoration: none;
            font-size: .85rem;
            transition: color .2s;
        }
        .back-link:hover {
            color: var(--vp-gold);
        }
    </style>
</head>
<body>
    <div>
        <div class="login-card">
            <div class="login-header">
                <div class="brand">
                    <i class="bi bi-tree-fill"></i> {{ Setting::get('site_name', 'VerdeParis75') }}
                </div>
                <p>Administration</p>
            </div>
            <div class="login-body">
                @if($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3" style="font-size: .85rem; border-radius: 8px;">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@verdeparis75.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Votre mot de passe">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember" style="font-size: .85rem; color: #666;">
                                Se souvenir de moi
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </button>
                </form>
            </div>
        </div>
        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left me-1"></i> Retour au site
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
