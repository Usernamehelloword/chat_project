<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: max(20px, env(safe-area-inset-top, 0px)) 16px max(20px, env(safe-area-inset-bottom, 0px));

            background: linear-gradient(-45deg,
                #f1d3d3,
                #d98686,
                #e7bcbc,
                #f4dddd);
            background-size: 400% 400%;
            animation: bgMove 12s ease infinite;
        }

        @keyframes bgMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .auth-wrapper {
            width: 100%;
            max-width: 480px;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: fadeIn .6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card */
        .login-card {
            width: 100%;
            background: #d98686;
            border-radius: 28px;
            padding: 40px 32px 35px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .18),
                        0 4px 15px rgba(217, 134, 134, .3);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .25);
        }

        /* Subtle modern card header accent */
        .card-accent {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 90px;
            height: 5px;
            background: rgba(255, 255, 255, .7);
            border-radius: 0 0 8px 8px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .card-header .avatar-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .22);
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 26px;
            color: white;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .1);
        }

        .card-header h2 {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: .5px;
        }

        .card-header p {
            font-size: 13px;
            opacity: .85;
            margin-top: 5px;
        }

        /* Alerts */
        .alert-error {
            background: rgba(140, 20, 20, .35);
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 20px;
            color: white;
            font-size: 13px;
            line-height: 1.4;
        }

        .alert-error ul {
            margin-left: 18px;
        }

        .alert-success {
            background: rgba(40, 140, 60, .35);
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 20px;
            color: white;
            font-size: 13px;
            text-align: center;
        }

        /* Input Group with full-width underline and contained eye icon */
        .input-group {
            display: flex;
            align-items: center;
            border-bottom: 2.5px solid rgba(255, 255, 255, .8);
            padding: 8px 4px;
            margin-bottom: 26px;
            transition: border-color .25s ease, box-shadow .25s ease;
        }

        .input-group:focus-within {
            border-bottom-color: #ffffff;
            box-shadow: 0 4px 14px rgba(255, 255, 255, .25);
        }

        .input-group .icon {
            color: white;
            font-size: 18px;
            width: 26px;
            flex-shrink: 0;
            opacity: .95;
            text-align: center;
        }

        .input-group input {
            flex: 1;
            min-width: 0;
            border: none;
            background: transparent;
            color: white;
            font-size: 16px; /* Prevents auto zoom on mobile */
            outline: none;
            padding: 4px 10px;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, .75);
            font-size: 14.5px;
        }

        .input-group .eye {
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 6px;
            opacity: .85;
            flex-shrink: 0;
            transition: opacity .2s, transform .2s;
        }

        .input-group .eye:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        /* Submit Button */
        .login-btn {
            display: block;
            width: 100%;
            height: 48px;
            margin-top: 15px;
            border: none;
            border-radius: 25px;
            background: white;
            color: #d98686;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .14);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, .2);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Bottom Navigation Buttons */
        .bottom-actions {
            width: 100%;
            display: flex;
            gap: 12px;
            margin-top: 18px;
            justify-content: center;
        }

        .bottom-actions a {
            flex: 1;
            text-decoration: none;
        }

        .sub-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 23px;
            background: rgba(217, 134, 134, .95);
            backdrop-filter: blur(8px);
            color: white;
            font-size: 14.5px;
            font-weight: bold;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
            border: 1px solid rgba(255, 255, 255, .3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sub-btn:hover {
            background: #c66e6e;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .18);
        }

        /* Responsive Breakpoints */
        @media (max-width: 480px) {
            body {
                padding: max(16px, env(safe-area-inset-top, 0px)) 14px max(16px, env(safe-area-inset-bottom, 0px));
            }

            .login-card {
                padding: 32px 22px 28px;
                border-radius: 24px;
            }

            .card-header h2 {
                font-size: 22px;
            }

            .input-group {
                margin-bottom: 22px;
                padding: 6px 2px;
            }

            .input-group input {
                font-size: 15px;
            }

            .bottom-actions {
                flex-direction: row;
                gap: 10px;
            }

            .sub-btn {
                height: 44px;
                font-size: 13.5px;
            }
        }

        @media (max-width: 360px) {
            .bottom-actions {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>

<body>

@include('partials.loader')

<div class="auth-wrapper">

    <div class="login-card">

        <div class="card-accent"></div>

        <div class="card-header">
            <div class="avatar-icon">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2>Login</h2>
            <p>Welcome back! Enter your details to continue.</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-group">
                <i class="fa-solid fa-envelope icon"></i>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email Address"
                    required
                    autocomplete="email">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
                    autocomplete="current-password">
                <i class="fa-solid fa-eye eye" id="togglePassword" title="Show/Hide Password"></i>
            </div>

            <button class="login-btn" type="submit">
                Log In
            </button>
        </form>

    </div>

    <div class="bottom-actions">
        <a href="{{ route('register') }}">
            <button type="button" class="sub-btn">
                Register
            </button>
        </a>

        <a href="#">
            <button type="button" class="sub-btn">
                Forgot Password
            </button>
        </a>
    </div>

</div>

<script>
    const toggle = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    if (toggle && password) {
        toggle.addEventListener("click", function() {
            if (password.type === "password") {
                password.type = "text";
                this.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                password.type = "password";
                this.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    }
</script>

</body>
</html>