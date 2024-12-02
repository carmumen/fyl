<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class TablaExport implements FromView
{
    protected $table;
    protected $data;

    public function __construct($table, $data)
    {
        $this->table = $table;
        $this->data = $data;
        ini_set('memory_limit', '512M');
    }

    public function view(): View
    {
        $view = null;

        if ($this->table == 'resumen_pagos_general') {
            
            //dd($this->data);
            $view = view('fyl/reports/payment_general_table', [
                'payment_summary' => $this->data,
            ]);
        }

        if ($this->table == 'resumen_pago_focus') {
            $view = view('fyl/reports/payment_summary_table', [
                'payment_summary' => $this->data,
            ]);
        }

        if ($this->table == 'resumen_pago_your') {
            $view = view('fyl/reports/payment_summary_your_table', [
                'payment_summary' => $this->data,
            ]);
        }

        if ($this->table == 'resumen_pago_life') {
            $view = view('fyl/reports/payment_summary_life_table', [
                'payment_summary' => $this->data,
            ]);
        }
        if ($this->table == 'seguimiento_focus') {
            $view = view('fyl/reports/follow_focus_table', [
                'follow' => $this->data,
            ]);
        }
        if ($this->table == 'seguimiento_focus_to_your') {
            $view = view('fyl/reports/follow_focus_to_your_table', [
                'follow' => $this->data,
            ]);
        }
        if ($this->table == 'seguimiento_your') {
            $view = view('fyl/reports/follow_your_table', [
                'follow' => $this->data,
            ]);
        }
        if ($this->table == 'focus_participants') {
            $view = view('fyl/reports/focus_participants_table', [
                'focusParticipants' => $this->data,
            ]);
        }

        if ($this->table == 'lista' && !empty($this->data)) {
            $view = view('fyl/reports/lista_focus_table', [
                'lista_focus' => $this->data,
            ]);
        }

        if ($this->table == 'listay' && !empty($this->data)) {
            $view = view('fyl/reports/lista_your_table', [
                'lista_your' => $this->data,
            ]);
        }

        if ($this->table == 'listal' && !empty($this->data)) {
            $view = view('fyl/reports/lista_life_table', [
                'lista_life' => $this->data,
            ]);
        }

        if ($this->table == 'reporte_gastos' && !empty($this->data)) {
            $view = view('cash/gastos/reporte_gastos_table', [
                'gastos' => $this->data,
            ]);
        }

        if ($this->table == 'reporte_ingresos' && !empty($this->data)) {
            $view = view('cash/gastos/reporte_ingresos_table', [
                'ingresos' => $this->data,
            ]);
        }
        
        if ($this->table == 'equipos_en_juego' && !empty($this->data)) {
            $view = view('fyl/reports/equipos_en_juego_table', [
                'equipo' => $this->data,
            ]);
        }
        
        if ($this->table == 'dashboard_focus' && !empty($this->data)) {
            $view = view('fyl/focusParticipants/dashboard_focus', [
                'params' => $this->data,
            ]);
        }
        
        if ($this->table == 'dashboard_your' && !empty($this->data)) {
            $view = view('fyl/yourParticipants/dashboard_your', [
                'params' => $this->data,
            ]);
        }
        
        if ($this->table == 'dashboard_life' && !empty($this->data)) {
            //dd($this->data);
            $view = view('fyl/lifeParticipants/dashboard_life', [
                'params' => $this->data,
            ]);
        }
        
        if ($this->table == 'focus_declaracion' && !empty($this->data)) {
            //dd($this->data);
            $view = view('fyl/focusStatement/focus_statement', [
                'declaracion' => $this->data,
            ]);
        }
        
        if ($this->table == 'focus_rezagados' && !empty($this->data)) {
            //dd($this->data);
            $view = view('fyl/focusRezagados/listado', [
                'rezagados' => $this->data,
            ]);
        }

        
        // Aplicar estilos a la cabecera
        if ($view) {
            $view->with('styleArray', [
                'font' => [
                    'bold' => true, // Negritas
                    'background' => 'yellow',
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, // Centrar horizontalmente
                    'vertical' => Alignment::VERTICAL_CENTER, // Centrar verticalmente
                    'wrapText' => true,
                ],

            ]);

        }

        return $view ?? view('error_view');
    }
}
