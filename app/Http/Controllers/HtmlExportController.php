<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class HtmlExportController extends Controller
{
   public function exportHtmlToExcel(Request $request)
    {
        $htmlContent = $request->input('html');

        if (!$htmlContent) {
            return response()->json(['error' => 'No se recibió HTML.'], 400);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Usar DOMDocument para analizar HTML
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);

        if (!$dom) {
            return response()->json(['error' => 'Error al cargar el HTML.'], 500);
        }

        // Obtener la primera tabla HTML
        $table = $dom->getElementsByTagName('table')->item(0);

        if (!$table) {
            return response()->json(['error' => 'No se encontró una tabla en el HTML.'], 500);
        }

        $rowIndex = 1;
        foreach ($table->getElementsByTagName('tr') as $row) {
            $colIndex = 'A';
            foreach ($row->getElementsByTagName('td') as $cell) {
                $sheet->setCellValue($colIndex . $rowIndex, $cell->nodeValue);
                $colIndex++;
            }
            $rowIndex++;
        }

        // Crear el escritor de Excel
        $writer = new Xlsx($spreadsheet);

        // Guardar el archivo en memoria
        $filename = 'export.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export') . '.xlsx';

        try {
            $writer->save($tempFile);
            Log::info("Archivo guardado en: $tempFile");
        } catch (\Exception $e) {
            Log::error('Error al guardar el archivo: ' . $e->getMessage());
            return response()->json(['error' => 'Error al guardar el archivo: ' . $e->getMessage()], 500);
        }

        // Devolver el archivo como descarga
        return Response::download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}
