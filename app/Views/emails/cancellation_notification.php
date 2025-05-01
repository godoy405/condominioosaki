<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelamento de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        .content {
            padding: 20px;
            background-color: #ffffff;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cancelamento de Reserva</h1>
        </div>
        
        <div class="content">
            <p>Olá,</p>
            
            <p>Informamos que sua reserva para a área <strong><?= esc($reservation->area_name) ?></strong> foi cancelada.</p>
            
            <div class="details">
                <p><strong>Detalhes da Reserva:</strong></p>
                <ul>
                    <li>Data: <?= date('d/m/Y', strtotime($reservation->date)) ?></li>
                    <li>Horário: <?= $reservation->start_time ?> às <?= $reservation->end_time ?></li>
                    <li>Motivo do Cancelamento: <?= esc($reason) ?></li>
                </ul>
            </div>
            
            <p>Se você tiver alguma dúvida ou precisar de mais informações, entre em contato conosco.</p>
            
            <p>Atenciosamente,<br>
            Sistema de Reservas</p>
        </div>
        
        <div class="footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p>&copy; <?= date('Y') ?> Sistema de Reservas. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html> 