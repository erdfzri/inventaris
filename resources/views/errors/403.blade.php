<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background: #2b3a8b;
            color: #fff;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }
        .container {
            text-align: center;
        }
        .code {
            font-size: 15rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 2rem;
            opacity: 0.2;
        }
        .message {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .sub-message {
            font-size: 1.125rem;
            opacity: 0.7;
            margin-bottom: 3rem;
        }
        .btn {
            background: #fff;
            color: #2b3a8b;
            padding: 1rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="code">403</div>
        <div class="message">FORBIDDEN</div>
        <div class="sub-message">Oops! You don't have access to this page.</div>
        <a href="{{ url()->previous() }}" class="btn">GO BACK</a>
    </div>
</body>
</html>
