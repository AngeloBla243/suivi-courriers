<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #f0f5fa 40%, #d2e2fa 100%);
            font-family: 'Segoe UI', 'Montserrat', Arial, sans-serif;
            min-height: 100vh;
        }

        .login-container {
            max-width: 380px;
            margin: 3rem auto;
            padding: 2.5rem 2.2rem 1.7rem 2.2rem;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 8px 28px rgba(33, 118, 189, 0.10);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2.title-app {
            font-size: 1.35rem;
            color: #2176bd;
            font-weight: 800;
            text-align: center;
            margin-bottom: .7rem;
            letter-spacing: 0.6px;
        }

        h3.sub-title {
            font-size: 1rem;
            color: #3a3f55;
            font-weight: 500;
            text-align: center;
            margin-bottom: 1.4rem;
            letter-spacing: 0.25px;
        }

        label,
        .input-label {
            color: #2176bd;
            font-weight: 600;
        }

        input[type="email"],
        input[type="password"] {
            border-radius: 13px;
            border: 1.5px solid #dde6f7;
            font-size: 1.02em;
            padding: .72em 1em;
            margin-top: .30em;
            margin-bottom: .85em;
            width: 100%;
            transition: border-color 0.13s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2176bd;
            box-shadow: 0 2px 8px rgba(33, 118, 189, 0.09);
        }

        .input-error {
            color: #d9534f;
            font-size: 0.92em;
            margin-bottom: 0.45em;
        }

        .remember-me {
            margin-bottom: 0.8rem;
        }

        .remember-me label {
            font-weight: 500;
            color: #2176bd;
            cursor: pointer;
        }

        .forgot-link {
            color: #2176bd;
            text-decoration: underline;
            font-size: .97em;
        }

        .forgot-link:hover {
            color: #174467;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            border-radius: 26px;
            background: #2176bd;
            color: #fff;
            font-size: 1.15em;
            font-weight: 700;
            letter-spacing: 0.7px;
            padding: 0.85em 0;
            border: none;
            margin-top: 0.8em;
            margin-bottom: .78em;
            box-shadow: 0 3px 18px rgba(33, 118, 189, 0.17);
            transition: background 0.20s;
        }

        .btn-login:hover,
        .btn-login:focus {
            background: #145795;
            color: #fff;
        }

        .logo-area {
            width: 130px;
            margin: 2.1rem auto 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-area img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(33, 118, 189, 0.15));
        }

        @media (max-width:600px) {
            .login-container {
                max-width: 99vw;
                border-radius: 0;
                padding: 2.2rem 0.6rem 1.6rem 0.6rem;
            }
        }
    </style>

    <div class="login-container">
        <h2 class="title-app">Gestion numérisée des Courriers.</h2>
        <h3 class="sub-title">Secrétariats de&nbsp;la&nbsp;DGDA</h3>

        <div class="logo-area mt-4">
            <!-- Mets ici ton logo : -->
            <img src="{{ asset('img/OIP.jpg') }}" alt="Logo DGDA">
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" style="width:100%;">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="input-error mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="input-error mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="remember-me block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600
                                    shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-3">
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif
                <button type="submit" class="btn-login">
                    {{ __('Se connecter') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
