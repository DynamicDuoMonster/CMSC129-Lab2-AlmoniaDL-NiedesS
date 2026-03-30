<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SoleSearch</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body>


    <div class="login-container">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <h2>Welcome to SoleSearch</h2>

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <label for="email">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                value="{{ old('email') }}"
                required
            />

            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            />

            <button type="submit">Log In</button>

            <div class="login-footer">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        </form>
    </div>

</body>
</html>
