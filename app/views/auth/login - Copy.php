<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kinde ERP</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
        }
        .login-container {
            background: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            text-align: center;
        }
        .login-container label {
            display: block;
            margin-bottom: .5rem;
            font-weight: 600;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: .75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            width: 100%;
            padding: .75rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
        .login-container .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Kinde ERP Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="/login">
            <label for="identifier">Username or Email</label>
            <input type="text" name="identifier" id="identifier" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
