<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Indaluz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2d5a27, #4a7c59);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .pedido-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #4a7c59;
        }
        .pedido-info h3 {
            margin: 0 0 10px 0;
            color: #2d5a27;
            font-size: 18px;
        }
        .productos {
            margin-top: 20px;
        }
        .producto-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .producto-item:last-child {
            border-bottom: none;
        }
        .producto-imagen {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #e9ecef;
        }
        .producto-info {
            flex: 1;
        }
        .producto-nombre {
            font-weight: bold;
            color: #2d5a27;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .producto-precio {
            color: #4a7c59;
            font-weight: bold;
            font-size: 18px;
        }
        .total {
            background-color: #2d5a27;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            border-radius: 8px;
        }
        .total h2 {
            margin: 0;
            font-size: 24px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">🌱 Indaluz</div>
            <h1>Pedido Confirmado</h1>
            <p>¡Gracias por tu compra!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="pedido-info">
                <h3>Detalles del Pedido</h3>
                <p><strong>Número de Pedido:</strong> #{{ $datos['pedido_id'] }}</p>
                <p><strong>Cliente:</strong> {{ $datos['cliente_nombre'] }}</p>
                <p><strong>Fecha:</strong> {{ $datos['fecha'] }}</p>
            </div>

            <div class="productos">
                <h3 style="color: #2d5a27; margin-bottom: 15px;">Productos:</h3>
                
                @foreach($datos['productos'] as $item)
                <div class="producto-item">
                    <img src="{{ asset('storage/' . ($item['producto']->imagen ?? 'productos/default.jpg')) }}" 
                         alt="{{ $item['producto']->nombre }}" 
                         class="producto-imagen">
                    <div class="producto-info">
                        <div class="producto-nombre">{{ $item['producto']->nombre }}</div>
                        <p style="margin: 5px 0; color: #6c757d;">
                            Cantidad: {{ $item['cantidad'] }} {{ ucfirst($item['producto']->unidad_medida) }}
                        </p>
                        <div class="producto-precio">{{ number_format($item['subtotal'], 2) }}€</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="total">
                <h2>Total: {{ number_format($datos['total'], 2) }}€</h2>
            </div>

            <p style="text-align: center; color: #6c757d; margin-top: 30px;">
                Nos pondremos en contacto contigo pronto para coordinar la entrega.
                <br><br>
                <strong>¡Gracias por elegir Indaluz!</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} Indaluz - Productos frescos de Almería</p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>