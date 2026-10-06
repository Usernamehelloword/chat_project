<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verify Email</title>
        <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">

    </head>
    <body>
        @include('partials.loader')
        <div class="container">
            <h1>Verify Your Email Address</h1>
            <p>Before proceeding, please check your email for a verification link.</p>
            <p>If you did not receive the email, click the button below to request another.</p>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">Resend Verification Email</button>
            </form>
        </div>
    </body>
</html>