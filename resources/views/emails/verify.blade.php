{{-- resources/views/emails/verify.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verifica tu cuenta en Indaluz</title>
    <style>
        body {
            background-color: #f0fdf4;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 480px;
            margin: 2rem auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #16a34a;
            text-align: center;
            padding: 1rem;
        }
        .header img {
            height: 48px;
        }
        .content {
            padding: 1.5rem;
            color: #374151;
        }
        .content h1 {
            font-size: 1.5rem;
            color: #16a34a;
            margin-bottom: 1rem;
        }
        .content p {
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background-color: #16a34a;
            color: #ffffff;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 1rem;
        }
        .footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 1rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz">
        </div>
        <div class="content">
            <h1>¡Hola {{ $name }}!</h1>
            <p>Gracias por registrarte en <strong>Indaluz</strong>. Para activar tu cuenta y empezar a disfrutar de productos frescos de Almería, confirma tu correo haciendo clic en el botón:</p>
            <p style="text-align: center;">
                <a href="{{ $url }}" class="btn">Verificar mi cuenta</a>
            </p>
            <p>Si el botón no funciona, copia y pega esta URL en tu navegador:</p>
            <p style="word-break: break-all;"><a href="{{ $url }}">{{ $url }}</a></p>
            <p>Si no solicitaste este correo, puedes ignorarlo.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Indaluz – Plataforma local de productos frescos de Almería.
        </div>
    </div>
</body>
</html>
