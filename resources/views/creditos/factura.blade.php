<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Crédito #{{ $credito->id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #4f46e5; }
        .details-container { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .details-container td { padding: 8px; vertical-align: top; }
        .section-title { font-weight: bold; background-color: #f1f5f9; padding: 5px; margin-bottom: 10px; border-radius: 3px;}
        .table-items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table-items th, .table-items td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        .table-items th { background-color: #f8fafc; color: #475569; }
        .totals { margin-top: 20px; text-align: right; }
        .totals strong { font-size: 16px; }
        .footer { position: absolute; bottom: 30px; width: 100%; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SISTEMA DE CRÉDITOS</h1>
        <p>Comprobante de Otorgamiento</p>
    </div>

    <table class="details-container">
        <tr>
            <td width="50%">
                <div class="section-title">Datos del Cliente</div>
                <p>
                    <strong>Nombre:</strong> {{ $credito->cliente->nombres ?? $credito->cliente->nombre }} {{ $credito->cliente->apellidos ?? $credito->cliente->apellido }}<br>
                    <strong>DUI:</strong> {{ $credito->cliente->dui ?? 'N/A' }}<br>
                    <strong>Teléfono:</strong> {{ $credito->cliente->telefono ?? 'N/A' }}
                </p>
            </td>
            <td width="50%" style="text-align: right;">
                <div class="section-title" style="text-align: center;">Detalles de Factura</div>
                <p>
                    <strong>N° de Crédito:</strong> #{{ str_pad($credito->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($credito->fecha_inicio)->format('d/m/Y') }}<br>
                    <strong>Estado:</strong> {{ strtoupper($credito->estado) }}
                </p>
            </td>
        </tr>
    </table>

    <table class="table-items">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Plazo</th>
                <th>Tasa de Interés</th>
                <th>Monto Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Otorgamiento de Crédito Personal</td>
                <td>{{ $credito->plazo_meses }} meses</td>
                <td>{{ number_format($credito->tasa_interes, 2) }}%</td>
                <td>${{ number_format($credito->monto, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <p><strong>Monto Original:</strong> ${{ number_format($credito->monto, 2) }}</p>
        <p><strong>Saldo Pendiente:</strong> ${{ number_format($credito->saldo, 2) }}</p>
    </div>

    <div class="footer">
        Este documento es un comprobante válido emitido el {{ date('d/m/Y H:i') }}<br>
        Gracias por su confianza.
    </div>

</body>
</html>