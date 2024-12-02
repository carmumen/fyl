<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function generateQRCode(Request $request)
    {
        $data = $request->get('data'); // Obtener los datos para el código QR

        // Codificar los datos en formato URL
        $encodedData = urlencode($data);

        // Construir la URL del servicio de Google Charts para generar el código QR
        $qrCodeUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$encodedData";

        // Devolver una vista con la imagen del código QR
        return view('qrcode', ['qrCodeUrl' => $qrCodeUrl]);
    }
}
