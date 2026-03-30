<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Reset - SoleSearch</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700" rel="stylesheet" />

    @vite([
        'resources/css/app.css',
        'resources/css/dashboard.css'
    ])

    <style>
        .reset-container {
            min-height: calc(100vh - 72px); /* Accounting for larger nav height */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #000;
            font-family: 'DM Sans', sans-serif;
        }

        .reset-card {
            background: #111;
            border: 1px solid #222;
            padding: 40px;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.8);
        }

        .reset-card h2 {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .demo-badge {
            display: inline-block;
            background: rgba(201, 149, 74, 0.1);
            color: #c9954a;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .reset-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Reusing your admin-form styles from dashboard.css */
        .reset-form input {
            width: 100%;
            padding: 12px 16px;
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }

        .reset-form input:focus {
            border-color: #c9954a;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #c9954a; /* SoleSearch Gold */
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }

        .submit-btn:hover {
            background: #e8b96a;
        }

        .back-link {
            display: block;
            margin-top: 24px;
            text-align: center;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link:hover { color: #fff; }

        .error-text {
            color: #ff5c5c;
            font-size: 13px;
            margin-top: -8px;
        }
    </style>
</head>
<body style="background: #000; margin: 0;">     

    <div class="reset-container">
        <div class="reset-card">
            <h2>Quick Reset</h2>
            <div class="demo-badge">LABORATORY DEMO MODE</div>

            <form method="POST" action="{{ route('password.update') }}" class="reset-form">
                @csrf
                
                <input type="email" name="email" placeholder="Registered Email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror

                <input type="password" name="password" placeholder="New Password" required>
                
                <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror

                <button type="submit" class="submit-btn">Reset Password Now</button>
            </form>

            <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>