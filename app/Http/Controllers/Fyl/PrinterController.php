<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\Fyl\Payment;

class PrinterController extends Controller
{
    public function generarFactura($id)
    {
        $factura = DB::table('fyl_payment_voucher_view')->where('id',$id)->first();

        // L¨®gica para obtener los datos necesarios para la factura
        // ...

        $pdf = PDF::loadView('fyl/participants/voucher', compact('factura'));

        return $pdf->stream('factura.pdf');
    }
}

