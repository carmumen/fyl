<!-- resources/views/factura.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
</head>
<body style="font-size:35px;">
    <!-- Contenido de la factura -->
    <div style="heigth:400px">
        <div class="flex justify-center">
            <img width="100%" class=" py-2" src="{{ url('images/fyl.jpeg') }}" />
        </div>
        <table style="width:100%">
            <tr>
                <th style="text-align:center">Comprobante de Pago</th>
            </tr>
            <tr>
                <td style="text-align:center">{{ $factura->numero }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <th style="text-align:left; padding:3px">Cliente:</th>
                <td>{{ $factura->names_razon_social }}</td>
            </tr>
            <tr>
                <th style="text-align:left; padding:3px">CI RUC:</th>
                <td>{{ $factura->CC_RUC }}</td>
            </tr>
            <tr>
                <th style="text-align:left; padding:3px">Fecha:</th>
                <td>{{ $factura->payment_date }}</td>
            </tr>
        </table>
        
        <table border="1" style="width:100%">
            <tr style="background-color:black; color:white">
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio</th>
            </tr>
            <tr>
                <td>{{ $factura->description }}</td>
                <td style="text-align:center">1</td>
                <td style="text-align:center">{{ $factura->amount }}</td>
            </tr>
        </table>
        <p>
        <table>
            <tr>
                <th style="text-align:left">Forma de pago:</th>
                <td>{{ $factura->method }}</td>
            </tr>
        </table>
        </p>
        <p style="text-align:right">
            {{ $factura->name }}
            <br>
            
        </p>
        <hr>
    </div>
        
    
</body>
</html>
