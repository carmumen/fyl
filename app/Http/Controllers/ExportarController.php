<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TablaExport;
use Illuminate\Support\Facades\DB; // Asegúrate de crear una clase TablaExport

class ExportarController extends Controller
{
    public function exportarTabla($table, $id, $second = null)
    {
        //return $second;
        $userId = auth()->id();
        $data = [];
        $nombre = "";
        switch ($table) {
            case 'resumen_pagos_general':
                $partes = explode('|', $second);
                $program = $partes[0]; // Contendría "F"
                $parameter = $partes[1]; // Contendría "D"
                $campusId = $partes[2]; // Contendría el campus_id
                $fechaInicio = $partes[3]; // Contendría 0 ó fecha de inicio
                $fechaFin = $partes[4]; // Contendría 0 ó fecha de fin
                
                switch($program) {
                    case 'T':
                        $program = '%';
                        break;
                    default:
                        // Opcional: Manejar otros casos o asignar un valor predeterminado
                         $program = $program .'%'; 
                        break;
                }
                
                
                
                
                if($parameter == 'C')
                {
                    $data = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('training_id', $id)
                            ->where('program', 'LIKE', $program)
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
                }
                else
                {
                    $data = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('program', 'LIKE', $program)
                            ->where('campus_id', '=', $campusId)
                            ->where('payment_date', '>=', $fechaInicio)
                            ->where('payment_date', '<=', $fechaFin)
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
                }
                
                
                break;
                
            case 'resumen_pago_focus':
                $partes = explode('|', $second);
                $program = $partes[0]; // Contendría "F"
                $parameter = $partes[1]; // Contendría "D"
                $campusId = $partes[2]; // Contendría el campus_id
                $fechaInicio = $partes[3]; // Contendría 0 ó fecha de inicio
                $fechaFin = $partes[4]; // Contendría 0 ó fecha de fin
                //$data = DB::table('get_fyl_payment_summary_focus')->where('training_id', $id)->get();
                //$data = DB::select('CALL get_fyl_payment_summary_focus(?,?,?)', [$id,$program,$parameter]);
                
                if($parameter == 'C')
                {
                    $data = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('training_id', $id)
                            ->where('program', 'LIKE', 'F%')
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
                }
                else
                {
                    $data = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('program', 'LIKE', 'F%')
                            ->where('campus_id', '=', $campusId)
                            ->where('payment_date', '>=', $fechaInicio)
                            ->where('payment_date', '<=', $fechaFin)
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
                }
                
                
                break;
            case 'resumen_pago_your':
                $partes = explode('|', $second);
                $program = $partes[0]; // Contendría "F"
                $parameter = $partes[1]; // Contendría "D"
                //$data = DB::table('get_fyl_payment_summary_focus')->where('training_id', $id)->get();
                $data = DB::select('CALL get_fyl_payment_summary_your(?,?,?)', [$id,$program,$parameter]);
                break;
            case 'resumen_pago_life':
                $partes = explode('|', $second);
                $program = $partes[0]; // Contendría "F"
                $parameter = $partes[1]; // Contendría "D"
                //$data = DB::table('get_fyl_payment_summary_focus')->where('training_id', $id)->get();
                $data = DB::select('CALL get_fyl_payment_summary_life(?,?,?)', [$id,$program,$parameter]);
                break;
            case 'seguimiento_focus':
                $data = DB::select('CALL get_fyl_follow_focus(?,?)', [$id, $second]);
                break;
            case 'seguimiento_focus_to_your':
                $data = DB::select('CALL get_fyl_follow_focus_to_your(?,?)', [$id, $second]);
                break;
            case 'seguimiento_your':
                $data = DB::select('CALL get_fyl_follow_your(?,?)', [$id, $second]);
                break;
            case 'focus_participants':
                $search = '%';
                $call_B = '%';
                $call_L = '%';
                $perfil = '%';
                $mode = '%';
                $trainingIdEnroller = '0';
                $trainingId = $id;
                
                $data = DB::select('CALL get_fyl_focus_participants(?,?,?,?,?,?,?)', [$trainingId,$trainingIdEnroller, $search, $call_B, $call_L,$perfil,$mode]);
                break;
            case 'lista':
                $data = DB::table('fyl_participants_view')
                        ->where('training_id', $id)
                        ->orderby('surnames')
                        ->get();
                break;
            case 'listay':         
                $data = DB::table('fyl_participants_your_list_view')
                    ->where('training_id', $id)
                    ->orderby('surnames')
                    ->get();
                break;
            case 'listal':
                $data = DB::table('fyl_participants_life_view')
                    ->where('training_in_game', $id)
                    ->orderby('surnames')
                    ->get();
                break;
            case 'reporte_gastos':
                $partes = explode('|', $second);
                $campusId = $id;
                $fechaInicio = $partes[0];
                $fechaFin = $partes[1];
                
                $data = DB::table('cash_obtener_gastos')
                                ->where('campus_id',$campusId)
                                ->where('fecha','>=',$fechaInicio)
                                ->where('fecha','<=',$fechaFin)
                                ->get();
                break;
            case 'reporte_ingresos':
                $partes = explode('|', $second);
                $campusId = $id;
                $fechaInicio = $partes[0];
                $fechaFin = $partes[1];
                
                $data = DB::select('CALL fyl_ingresos_por_fechas(?,?,?)', [$campusId,$fechaInicio,$fechaFin]);
                break;
                
            case 'equipos_en_juego':
                $data = DB::select('CALL get_fyl_equipo_en_juego (?)', [$id ]);
                break;
                
            case 'dashboard_focus':
                $training = DB::select('CALL fyl_get_name_dashboard(?,?)', [$id,"focus"]);
                $nombre = $training[0]->name;
                $titulo = $training[0]->titulo;
                
                $payments = DB::select('CALL get_fyl_dashboard_focus_payments(?)', [$id]);
                $payments_staff = DB::select('CALL get_fyl_dashboard_focus_payments_staff(?)', [$id]);
                $confirm = DB::select('CALL get_fyl_dashboard_focus_confirm(?)', [$id]);
                $attendance = DB::select('CALL get_fyl_dashboard_focus_attendance(?)', [$id]);
                $attendance_teams = DB::select('CALL get_fyl_dashboard_focus_attendance_teams(?)', [$id]);
                
                $gender = DB::select('CALL fyl_focus_participants_gender(?)', [$id]); 
                $city = DB::select('CALL fyl_focus_participants_city(?)', [$id]);
                $ageRange = DB::select('CALL fyl_focus_participants_age_range(?)', [$id]);

                $data = [
                    'titulo' => $titulo,
                    'payments' => $payments,
                    'payments_staff' => $payments_staff,
                    'confirm' => $confirm,
                    'attendance' => $attendance,
                    'attendance_teams' => $attendance_teams,
                    'gender' => $gender,
                    'city' => $city,
                    'age_range' => $ageRange,
                ];
                break;
                
            case 'dashboard_your':
                $training = DB::select('CALL fyl_get_name_dashboard(?,?)', [$id,"your"]);
                $nombre = $training[0]->name;
                $titulo = $training[0]->titulo;
            
                $payments = DB::select('CALL get_fyl_dashboard_your_payment(?)', [$id]);
                $attendance = DB::select('CALL get_fyl_dashboard_your_attended(?)', [$id]);
                $statement = DB::select('CALL get_fyl_dashboard_your_statement(?)', [$id]);
                
                $paseFocus = DB::select('CALL get_fyl_jornada_focus(?)', [$id]); //PARA REPORTE DE RESUMEN FOCUS
                $seguimiento = DB::select('CALL get_seguimiento_focus_a_your(?)', [$id]); //PARA REPORTE DE SEGUIMIENTO
                $inicial = DB::select('CALL get_fyl_jornada_your_inicial(?)', [$id]); //PARA REPORTE DE DATOS INICIALES YOUR
                $sabado = DB::select('CALL get_fyl_jornada_your_sabado(?)', [$id]); //NO SE UTILIZA
                $domingo = DB::select('CALL get_fyl_jornada_your_domingo(?)', [$id]); //NO SE UTILIZA
               
                
                $gestion = DB::table('fyl_gestion_your_view')->where('training_id',$id)->get(); // PARA REPORTE DE GESTION

                $jornadaPagos = DB::select('CALL get_fyl_jornada_your(?)', [$id]); // PARA REPORTE JORNADA YOUR
                
                $jornada = DB::table('fyl_pagos_your_attended_view as p')
                    ->select('p.*',
                        DB::raw('CASE WHEN payment_status_life = "PAGO TOTAL" AND (pago_viernes + pago_sabado + pago_domingo + pago_posterior) = 0 THEN 1 ELSE 0 END AS PSP')
                    )
                    ->where('p.training_id', $id)
                    ->orderBy('p.staff', 'ASC')
                    ->orderBy('p.participant', 'ASC')
                    ->get();// PARA REPORTE DETALLE JORNADA 
                
                
                $data = [
                    'titulo' => $titulo,
                    'payments' => $payments,
                    'statement' => $statement,
                    'attendance' => $attendance,
                    'paseFocus' => $paseFocus,
                    'seguimiento'=> $seguimiento,
                    'inicial' => $inicial,
                    'sabado' => $sabado,
                    'domingo' => $domingo,
                    'gestion' => $gestion,
                    'jornada' => $jornada,
                    'jornadaPagos' => $jornadaPagos
                ];
                break;
                
            case 'dashboard_life':
                $training = DB::select('CALL fyl_get_name_dashboard(?,?)', [$id,"life"]);
                $nombre = $training[0]->name;
                $titulo = $training[0]->titulo;
                
                $trainings = DB::table('fyl_fds_training_view')
                            ->where('user_id',$userId)
                            ->orderBy('id','DESC')
                            ->pluck('name','id');
                
                $dashboard = DB::select('CALL get_fyl_life_dashboard(?)', [$id]); 
                $pagos = DB::select('CALL get_fyl_payments_fds(?)', [$id]);
                $pagosDetails = DB::select('CALL get_fyl_payment_fds_detail(?)', [$id]);
                $coach = DB::select('CALL get_fyl_coach_fds(?)', [$id]);
                $dashboard_academy = [];
                $pagos_academy = [];
                $pagosDetails_academy = [];
                $academy = DB::table('fyl_fds_team as ft')
                    ->join('fyl_fds as f', 'ft.fds_id', '=', 'f.id')
                    ->where('f.training_in_game', '=', 19)
                    ->whereNotNull('ft.DNI_coach_academia')
                    ->where(DB::raw('LENGTH(ft.DNI_coach_academia)'), '>', 2)
                    ->orderByDesc('ft.id')
                    ->get();
                
               if($academy){
                   
                   $dashboard_academy = DB::select('CALL get_fyl_life_dashboard_academy(?)', [$id]); 
                   
                   $pagos_academy = DB::select('CALL get_fyl_payments_fds_academy(?)', [$id]);
                   
                   $pagosDetails_academy = DB::select('CALL get_fyl_payment_fds_detail_academy(?)', [$id]);
                   
               }
               
               $pagoMedios = DB::table('fyl_payment_participant as pp')
                                ->join('fyl_payment as p', 'pp.id', '=', 'p.fyl_payment_participant')
                                ->where('p.comment', 'Pago Medios')
                                ->where('pp.training_id',$id)
                                ->count();
                                
                                //return $pagosDetails;
                
                $data = [
                    'titulo' => $titulo,
                    'training' => $trainings,
                    'trainingId' => $id,
                    'dashboard' => $dashboard,
                    'pagos' => $pagos,
                    'pagosDetails' => $pagosDetails,
                    'coach' => $coach,
                    'academy' => $academy,
                    'dashboard_academy' => $dashboard_academy,
                    'pagos_academy' => $pagos_academy,
                    'pagosDetails_academy' => $pagosDetails_academy,
                    'pagoMedios' => $pagoMedios,
                ];
            
            break;
            
            case 'focus_declaracion':
    
                $focusParticipants = DB::select('CALL get_fyl_focus_participants_game(?,?,?,?,?)', [$id, '%', '%', '%', '%']);
    
                $contador = 1;
    
                // Asignar el número secuencial a cada registro
                foreach ($focusParticipants as $focusParticipantsItem) {
                    $focusParticipantsItem->secuencial = $contador;
                    $focusParticipantsItem->comments = $this->cargaComentarios($focusParticipantsItem->id);
                    $contador++;
                };
                
                $data = $focusParticipants;
                
                break;
                
            case 'focus_rezagados':
                $data = DB::table('fyl_get_focus_rezagados_view as fr')
                            ->leftJoin('fyl_get_focus_rezagados_count_llamadas_view as llc','fr.DNI','=','llc.participant_DNI')
                            ->where('campus_id',$id)
                            ->orderBy('trainingOriginal', 'DESC')
                            ->orderBy('surnames_names', 'ASC')
                            ->get();
                break;
        }
        
        //return $data;

        if (!in_array($table, ['dashboard_focus', 'dashboard_your', 'dashboard_life'])) {
            $contador = 1;
            foreach ($data as $dataItem) {
                $dataItem->secuencial = $contador++;
            }
        }

        
        //return $data;
        
        cache()->flush();

        $export = new TablaExport($table, $data);
        
        //return $export;

        if ($export instanceof \Maatwebsite\Excel\Concerns\FromView) {
            $exportData = $export->view()->render();
            //dd($export);
            if (!empty($exportData)) {
                ob_end_clean();
                ob_start();
                
                //return Excel::download($export, $table . '.csv');
                if ($nombre !== "")
                {
                    return Excel::download($export, $nombre. '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                }
                
                else
                    return Excel::download($export, $table. '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            } else {
                return 'No hay datos para exportar.';
            }
        } else {
            return 'Clase de exportación no válida.';
        }
    }
    
    public function cargaComentarios($id)
    {
        $comments = DB::table('fyl_focus_participants_comments as c')
                        ->join('users as u', 'c.user_id','u.id')
                        ->select('c.*', 'u.name')
                        ->where('focus_participants_id',$id)->get();
        return $comments;
    }

}
