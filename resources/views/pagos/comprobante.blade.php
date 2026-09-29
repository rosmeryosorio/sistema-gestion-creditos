```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago de Crédito #{{ $pago->id }}</title>

    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 14px; 
            color: #1e293b; 
            margin: 20px;
        }

        .header { 
            text-align: center; 
            margin-bottom: 25px; 
        }

        .header h1 { 
            margin: 0; 
            color: #4f46e5; 
            font-size: 26px; 
            font-weight: bold; 
            letter-spacing: 0.5px;
        }

        .header p { 
            margin: 6px 0 0 0; 
            color: #475569; 
            font-size: 14px;
        }

        .payment-label {
            text-align: center;
            margin-bottom: 20px;
            color: #4f46e5;
            font-size: 16px;
            font-weight: bold;
        }

        .details-container { 
            width: 100%; 
            margin-bottom: 25px; 
            border-collapse: collapse; 
        }

        .details-container td { 
            vertical-align: top; 
            padding: 0;
        }

        .section-title { 
            font-weight: 600; 
            background-color: #f1f5f9; 
            padding: 8px 12px; 
            border-radius: 6px; 
            font-size: 13px;
            color: #1e293b;
        }

        .info-block {
            padding: 8px 12px;
            line-height: 1.6;
        }

        .table-items { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }

        .table-items th { 
            border: 1px solid #e2e8f0; 
            padding: 10px 12px; 
            text-align: left; 
            background-color: #f8fafc; 
            color: #334155; 
            font-size: 13px;
            font-weight: bold;
        }

        .table-items td { 
            border: 1px solid #e2e8f0; 
            padding: 12px; 
            font-size: 13px;
        }

        .payment-amount {
            margin-top: 25px;
            padding: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-align: center;
        }

        .payment-amount .label {
            color: #475569;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .payment-amount .amount {
            color: #4f46e5;
            font-size: 24px;
            font-weight: bold;
        }

        .totals { 
            margin-top: 20px; 
            text-align: right; 
            line-height: 1.8;
        }

        .totals p {
            margin: 0;
            font-size: 15px;
            color: #0f172a;
        }

        .totals strong {
            font-weight: 700;
        }

        .credit-status {
            margin-top: 25px;
            padding: 12px;
            text-align: center;
            background-color: #f1f5f9;
            border-radius: 6px;
            font-size: 13px;
        }

        .footer {
            margin-top: 35px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>SISTEMA DE CRÉDITOS</h1>
        <p>Comprobante de Pago de Crédito</p>
    </div>

    <div class="payment-label">
        ABONO REGISTRADO
    </div>

    <table class="details-container">
        <tr>

            <!-- DATOS DEL CLIENTE -->
            <td width="48%">
                <div class="section-title">
                    Datos del Cliente
                </div>

                <div class="info-block">
                    <strong>Nombre:</strong> 
                    {{ $pago->credito->cliente->nombres ?? $pago->credito->cliente->nombre }}
                    {{ $pago->credito->cliente->apellidos ?? $pago->credito->cliente->apellido }}
                    <br>

                    <strong>DUI:</strong> 
                    {{ $pago->credito->cliente->dui ?? 'N/A' }}
                    <br>

                    <strong>Teléfono:</strong> 
                    {{ $pago->credito->cliente->telefono ?? 'N/A' }}
                </div>
            </td>

            <td width="4%"></td>

            <!-- DATOS DEL CRÉDITO -->
            <td width="48%">
                <div class="section-title" style="text-align: right;">
                    Datos del Crédito
                </div>

                <div class="info-block" style="text-align: right;">

                    <strong>N° de Crédito:</strong>
                    #{{ str_pad($pago->credito_id, 6, '0', STR_PAD_LEFT) }}
                    <br>

                    <strong>Fecha del Abono:</strong>
                    {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}
                    <br>

                    <strong>Estado:</strong>
                    {{ strtoupper($pago->credito->estado) }}

                </div>
            </td>

        </tr>
    </table>


    <!-- INFORMACIÓN DEL PAGO -->

    <table class="table-items">

        <thead>
            <tr>
                <th>Concepto</th>
                <th>Método de Pago</th>
                <th>Fecha del Abono</th>
                <th style="text-align: right;">Monto</th>
            </tr>
        </thead>

        <tbody>

            <tr>

                <td>
                    Abono a Crédito #{{ str_pad($pago->credito_id, 6, '0', STR_PAD_LEFT) }}
                </td>

                <td>
                    {{ $pago->metodo_pago ?? 'Efectivo' }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}
                </td>

                <td style="text-align: right; font-weight: 600;">
                    ${{ number_format($pago->monto, 2) }}
                </td>

            </tr>

        </tbody>

    </table>


    <!-- MONTO DEL ABONO -->

    <div class="payment-amount">

        <div class="label">
            MONTO DEL ABONO
        </div>

        <div class="amount">
            ${{ number_format($pago->monto, 2) }}
        </div>

    </div>


    <!-- RESUMEN DEL CRÉDITO -->

    <div class="totals">

        <p>
            <strong>Abono realizado:</strong>
            ${{ number_format($pago->monto, 2) }}
        </p>

        <p>
            <strong>Saldo pendiente:</strong>
            ${{ number_format($pago->credito->saldo, 2) }}
        </p>

    </div>


    <!-- ESTADO DEL CRÉDITO -->

    <div class="credit-status">

        <strong>Estado actual del crédito:</strong>
        {{ strtoupper($pago->credito->estado) }}

    </div>


    <div class="footer">
        Gracias por realizar su pago.
        <br>
        Este documento es un comprobante del abono realizado al crédito.
    </div>

</body>
</html>
```
