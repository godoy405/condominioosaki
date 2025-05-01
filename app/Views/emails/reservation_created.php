<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Reserva Criada</title>
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
            <h1>Nova Reserva Criada</h1>
        </div>
        
        <div class="content">
            <p>Olá,</p>
            
            <p>Uma nova reserva foi criada para a área <strong><?= esc($reservation->area_name) ?></strong>.</p>
            
            <div class="details">
                <p><strong>Detalhes da Reserva:</strong></p>
                <ul>
                    <li>Código: <?= esc($reservation->code) ?></li>
                    <li>Data: <?= date('d/m/Y', strtotime($reservation->desired_date)) ?></li>
                    <li>Horário: <?= date('H:i', strtotime($reservation->desired_date)) ?></li>
                    <?php if(isset($reservation->notes) && !empty($reservation->notes)): ?>
                    <li>Observações: <?= esc($reservation->notes) ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <p>Para mais detalhes, acesse o sistema de reservas.</p>
            
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