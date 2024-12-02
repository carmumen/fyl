<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use App\Models\Fyl\Participants;
use App\Models\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use TCPDF;
use Exception;
use PhpParser\Node\Stmt\Return_;
use Carbon\Carbon;


class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index',  'link', 'register']]);
    }

    
    public function generatePdf($id)
    {
        $participant = DB::table('fyl_participants_view')->where('training_id', $id)->get();
        $pdf = PDF::loadView('fyl/reports.ficha', compact('participant'));
        $pdfPath = public_path('fichas/ficha.pdf'); // Ruta donde se guardará el PDF en el servidor
        $pdf->save($pdfPath); // Guarda el PDF en el servidor

        // Genera la respuesta
        $response = response()->download($pdfPath, 'ficha.pdf');

        // Establece el encabezado Content-Disposition
        $response->headers->set('Content-Disposition', 'attachment');

        return $response;
    }

    
    public function ficha($id,$set)
    {
        $campus = DB::table('fyl_training')->where('id', $id)->first();
        
        $participants = $this->getParticipantes($id);

        $desde = ($set * 30) - 29;

        // Filtrar y limitar los resultados
        $participant = $participants->filter(function ($item) use ($desde) {
            return $item->secuencial >= $desde;
        })->take(30);

        $pdf = [];

        if($campus->campus_id == 1){
            $pdf = Pdf::loadView('fyl/reports.ficha', \compact('participant'));
        }
        if($campus->campus_id == 2){
            $pdf = Pdf::loadView('fyl/reports.ficha-bog', \compact('participant'));
        }
        if($campus->campus_id == 3){
            $pdf = Pdf::loadView('fyl/reports.ficha-cue', \compact('participant'));
        }
        
        return $pdf->stream();
    }
    
    public function gafete($id)
    {
        $participant = $this->getParticipantes($id);
        //return $participant;
        $pdf = Pdf::loadView('fyl/reports.gafete', \compact('participant'));
        return $pdf->stream();

    }
    
    public function gafeteYour($id)
    {
        $participant = DB::table('fyl_participants_your_list_view')
                        ->where('training_id', $id)
                        ->orderby('surnames')
                        ->get();
        $contador = 1;

        foreach ($participant as $participantItem) {
            $participantItem->secuencial = $contador;
            $contador++;
        }
        
        
        //return $participant;
        $pdf = Pdf::loadView('fyl/reports.gafete', \compact('participant'));
        return $pdf->stream();

    }
    
    
    public function getParticipantes($id)
    {
        $participants = DB::table('fyl_participants_view')
        ->where('training_id', $id)
        ->orderby('surnames')
        ->get();

        $contador = 1;

        foreach ($participants as $participantItem) {
            $participantItem->secuencial = $contador;
            $contador++;
        }
        return $participants;
    }
    
   
    
    public function enrollerForTeam(Request $request)
    {
        $requestData = $request->all();
        
        $userId = auth()->id();

        $training = DB::select('CALL fyl_get_training_user_edit(?)', [$userId]);

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        if (empty($requestData)) {
            return view('fyl/reports/index', [
                'training' => $training,
                'trainingId' => 0,
            ]);
        } else {
            $trainingId = $request->training_id;
            $lifeParticipants = DB::select('CALL get_fyl_training_payments(?,?)', [$trainingId, 'F']);


            return view('fyl/reports/index', [
                'training' => $training,
                'lifeParticipants' => $lifeParticipants,
                'trainingId' => 0,
                'participants' => [],
            ]);
        }
    }
    

    public function payment_summary(Request $request)
    {
        $requestData = $request->all();
        
        //return $request;

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = DB::table('fyl_training_focus_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');
        
        $userId = auth()->id();
        
        $campuses = Users::find($userId)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        $campusId=0;
        $fechaInicio = "";
        $fechaFin = "";
        $program = "T";

        if (empty($requestData)) {
            return view('fyl/reports/payments', [
                'campus' => $campuses,
                'training' => $training,
                'trainingId' => 0,
                'campusId' => $campusId,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'program' => $program,
            ]);
        } else {
            $trainingId = $request->training_id;
            $program = $request->program;
            $programa = $request->program;
            switch($programa) {
                case 'T':
                    $programa = '%';
                    break;
                default:
                    // Opcional: Manejar otros casos o asignar un valor predeterminado
                     $programa = $programa .'%'; 
                    break;
            }
            
            if($request->fechaInicio)
            {
                $trainingId = 0;
                // Asignar fechas validadas a variables
                
                //return $programa;
                $fechaInicio = $request->fechaInicio;
                $fechaFin = $request->fechaFin;
                $fechaFinT = Carbon::parse($fechaFin)->endOfDay();
                $campusId = $request->campus_id;
    
                // Realizar la consulta en la base de datos
                $summary = DB::table('fyl_pagos_view')
                    ->select(
                        'MetodoPago',
                        DB::raw('sum(Monto) as Monto')
                    )
                    ->where('program', 'LIKE', $programa)
                    ->where('campus_id', '=', $campusId)
                    ->where('created_at', '>=', $fechaInicio)
                    ->where('created_at', '<=', $fechaFinT)
                    ->groupBy('MetodoPago')
                    ->orderBy('MetodoPago')
                    ->get();
                            
                $payment_summary = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('program', 'LIKE', $programa)
                            ->where('campus_id', '=', $campusId)
                            ->where('created_at', '>=', $fechaInicio)
                            ->where('created_at', '<=', $fechaFinT)
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
            }
            else
            {
                $summary = DB::table('fyl_pagos_view as p')
                            ->join('fyl_focus_participants as fp', 'p.participant_DNI', '=', 'fp.participant_DNI')
                            ->select(
                                'p.MetodoPago',
                                DB::raw('sum(p.Monto) as Monto')
                            )
                            ->where('fp.training_id_enroller', $trainingId)
                            ->where('p.program', 'LIKE', $programa)
                            ->groupBy('p.MetodoPago')
                            ->orderBy('p.MetodoPago')
                            ->get();
                            
                $payment_summary = DB::table('fyl_pagos_view as p')
                            ->join('fyl_focus_participants as fp', 'p.participant_DNI', '=', 'fp.participant_DNI')
                            ->select('p.*')
                            ->where('fp.training_id', $trainingId)
                            ->where('p.program', 'LIKE', $programa)
                            ->orderBy('p.equipoEnrolador')
                            ->orderBy('p.enrolador')
                            ->orderBy('p.surnames_names')
                            ->get();
            }
            
            $total = $summary->sum('Monto'); // Sumatoria total
            
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($payment_summary as $payment_summaryItem) {
                $payment_summaryItem->secuencial = $contador;
                $contador++;
            }
            
            $participants = DB::table('fyl_participants_view')->where('training_id', $trainingId)->count();
            $partes = floor($participants / 30);
            if ($participants % 30 > 0){
                $partes = $partes + 1;
            }
            
            $data = [
                'campus' => $campuses,
                'training' => $training,
                'trainingId' => $trainingId,
                'campusId' => $campusId,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
                'countParticipants' => $partes,
                'program' => $program,
            ];
            
           // return $data;

            return view('fyl/reports/payments',$data );
        }
    }
    

    public function payment_summary_focus(Request $request)
    {
        $requestData = $request->all();
        
        //return $request;

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = DB::table('fyl_training_focus_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');
        
        $userId = auth()->id();
        
        $campuses = Users::find($userId)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        $campusId=0;
        $fechaInicio = "";
        $fechaFin = "";

        if (empty($requestData)) {
            return view('fyl/reports/payment_summary', [
                'campus' => $campuses,
                'training' => $training,
                'trainingId' => 0,
                'campusId' => $campusId,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
            ]);
        } else {
            $trainingId = $request->training_id;
            
            if($request->fechaInicio)
            {
                $trainingId = 0;
                // Asignar fechas validadas a variables
                $fechaInicio = $request->fechaInicio;
                $fechaFin = $request->fechaFin;
                $campusId = $request->campus_id;
    
                // Realizar la consulta en la base de datos
                $summary = DB::table('fyl_pagos_view')
                    ->select(
                        'MetodoPago',
                        DB::raw('sum(Monto) as Monto')
                    )
                    ->where('program', 'LIKE', 'F%')
                    ->where('campus_id', '=', $campusId)
                    ->where('payment_date', '>=', $fechaInicio)
                    ->where('payment_date', '<=', $fechaFin)
                    ->groupBy('MetodoPago')
                    ->orderBy('MetodoPago')
                    ->get();
                            
                $payment_summary = DB::table('fyl_pagos_view')
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
            else
            {
                $summary = DB::table('fyl_pagos_view')
                            ->select(
                                'MetodoPago',
                                DB::raw('sum(Monto) as Monto')
                            )
                            ->where('training_id', $trainingId)
                            ->where('program', 'LIKE', 'F%')
                            ->groupBy('MetodoPago')
                            ->orderBy('MetodoPago')
                            ->get();
                            
                $payment_summary = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('training_id', $trainingId)
                            ->where('program', 'LIKE', 'F%')
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
            }
            
            $total = $summary->sum('Monto'); // Sumatoria total
            
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($payment_summary as $payment_summaryItem) {
                $payment_summaryItem->secuencial = $contador;
                $contador++;
            }
            
            $participants = DB::table('fyl_participants_view')->where('training_id', $trainingId)->count();
            $partes = floor($participants / 30);
            if ($participants % 30 > 0){
                $partes = $partes + 1;
            }

            return view('fyl/reports/payment_summary', [
                'campus' => $campuses,
                'training' => $training,
                'trainingId' => $trainingId,
                'campusId' => $campusId,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
                'countParticipants' => $partes
            ]);
        }
    }
    
    public function obtenerResumenPagos(Request $request)
    {
        // Validar las fechas del request
        $validated = $request->validate([
            'fechaInicio' => 'required|date|date_format:Y-m-d',
            'fechafin' => 'required|date|date_format:Y-m-d',
        ]);
    
        // Asignar fechas validadas a variables
        $fechaInicio = $validated['fechaInicio'];
        $fechaFin = $validated['fechafin'];
    
        // Realizar la consulta en la base de datos
        $summary = DB::table('fyl_pagos_view')
            ->select(
                'MetodoPago',
                DB::raw('sum(Monto) as Monto')
            )
            ->where('program', 'LIKE', 'F%')
            ->where('payment_date', '>=', $fechaInicio)
            ->where('payment_date', '<=', $fechaFin)
            ->groupBy('MetodoPago')
            ->orderBy('MetodoPago')
            ->get();
    
        return $summary;
    }

    public function payment_summary_your(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();
        
        
        
        $userId = auth()->id();
        
        $campuses = Users::find($userId)->campuses()->pluck('fyl_campus.name', 'fyl_campus.id');
        $campusId=0;
        $fechaInicio = "";
        $fechaFin = "";

        //return $associativeArray;
        
        if (empty($requestData)) {
            return view('fyl/reports/payment_summary_your', [
                'campus' => $campuses,
                'training' => $training,
                'trainingId' => 0,
                'campusId' => $campusId,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
            ]);
        } else {
            $trainingId = $request->training_id;
            
            if($request->fechaInicio)
            {
                $trainingId = 0;
                // Asignar fechas validadas a variables
                $fechaInicio = $request->fechaInicio;
                $fechaFin = $request->fechaFin;
                $campusId = $request->campus_id;
    
                // Realizar la consulta en la base de datos
                $summary = DB::table('fyl_pagos_view')
                    ->select(
                        'MetodoPago',
                        DB::raw('sum(Monto) as Monto')
                    )
                    ->where('program', 'LIKE', 'Y%')
                    ->where('campus_id', '=', $campusId)
                    ->where('payment_date', '>=', $fechaInicio)
                    ->where('payment_date', '<=', $fechaFin)
                    ->groupBy('MetodoPago')
                    ->orderBy('MetodoPago')
                    ->get();
                            
                $payment_summary = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('program', 'LIKE', 'Y%')
                            ->where('campus_id', '=', $campusId)
                            ->where('payment_date', '>=', $fechaInicio)
                            ->where('payment_date', '<=', $fechaFin)
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
            }
            else
            {
                $summary = DB::table('fyl_pagos_view')
                            ->select(
                                'MetodoPago',
                                DB::raw('sum(Monto) as Monto')
                            )
                            ->where('training_id', $trainingId)
                            ->where('program', 'LIKE', 'Y%')
                            ->groupBy('MetodoPago')
                            ->orderBy('MetodoPago')
                            ->get();
                            
                $payment_summary = DB::table('fyl_pagos_view')
                            ->select('*')
                            ->where('training_id', $trainingId)
                            ->where('program', 'LIKE', 'Y%')
                            ->orderBy('equipoEnrolador')
                            ->orderBy('enrolador')
                            ->orderBy('surnames_names')
                            ->get();
            }

            //$summary = DB::select('CALL get_fyl_resumen_pagos_por_metodo(?)',[$trainingId]);

            $total = 0;

            foreach ($summary as $row) {
                $total += $row->Monto;
            }

            //$total = $summary->sum('Monto'); // Sumatoria total

            //$payment_summary = DB::select('CALL get_fyl_payment_summary_your(?,?,?)', [$trainingId,$request->program,$request->parameter]);
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($payment_summary as $payment_summaryItem) {
                $payment_summaryItem->secuencial = $contador;
                $contador++;
            }
            
            

            return view('fyl/reports/payment_summary_your', [
                'campus' => $campuses,
                'training' => $training,
                'trainingId' => $trainingId,
                'campusId' => $campusId,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
            ]);
        }
    }
    
    public function payment_summary_life(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        //return $associativeArray;

        if (empty($requestData)) {
            return view('fyl/reports/payment_summary_life', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;

            $summary = DB::table('fyl_payment_summary_life_view')
                        ->select(
                            'MetodoPago',
                            DB::raw('sum(Monto) as Monto')
                        )
                        ->where('training_id', $trainingId)
                        ->where('program','LIKE','L')
                        ->groupBy('MetodoPago')
                        ->get();

            $total = $summary->sum('Monto'); // Sumatoria total

            $payment_summary = DB::select('CALL get_fyl_payment_summary_life(?,?,?)', [$trainingId,$request->program,$request->parameter]);
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($payment_summary as $payment_summaryItem) {
                $payment_summaryItem->secuencial = $contador;
                $contador++;
            }

            return view('fyl/reports/payment_summary_life', [
                'training' => $training,
                'trainingId' => $trainingId,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
            ]);
        }
    }
    

    public function listado(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        if (empty($requestData)) {
            return view('fyl/reports/lista_focus', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {

            $trainingId = $request->training_id;

            $summary = DB::table('fyl_payment_summary_view')
                        ->select(
                            'MetodoPago',
                            DB::raw('sum(Monto) as Monto')
                        )
                        ->where('training_id', $trainingId)
                        ->groupBy('MetodoPago')
                        ->get();

            $total = $summary->sum('Monto'); // Sumatoria total

            $lista_focus = DB::table('fyl_participants_view')
                        ->where('training_id', $trainingId)
                        ->orderby('surnames')
                        ->get();
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($lista_focus as $lista_focusItem) {
                $lista_focusItem->secuencial = $contador;
                $contador++;
            }


            return view('fyl/reports/lista_focus', [
                'training' => $training,
                'trainingId' => $trainingId,
                'lista_focus' => $lista_focus,
                'summary' => $summary,
                'total' => $total
            ]);
        }
    }
    

    public function listado_your(Request $request)
    {
        $requestData = $request->all();
        

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        if (empty($requestData)) {
            return view('fyl/reports/lista_your', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {

            $trainingId = $request->training_id;
            
            

            $lista_your = DB::table('fyl_participants_your_list_view')
                        ->where('training_id', $trainingId)
                        ->orderby('surnames')
                        ->get();
                        
            //return $lista_your;
                        
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($lista_your as $lista_yourItem) {
                $lista_yourItem->secuencial = $contador;
                $contador++;
            }


            return view('fyl/reports/lista_your', [
                'training' => $training,
                'trainingId' => $trainingId,
                'lista_your' => $lista_your,
            ]);
        }
    }
    
    public function listado_life(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $training = DB::table('fyl_training_in_game_fds_view')->where('user_id',$userId)->pluck('name', 'id');

        if (empty($requestData)) {
            return view('fyl/reports/lista_life', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {

            $trainingId = $request->training_id;

            $lista_life = DB::table('fyl_participants_life_view')
                        ->where('training_in_game', $trainingId)
                        ->get();
            $contador = 1;

            //return  $lista_life;
            // Asignar el número secuencial a cada registro
            foreach ($lista_life as $lista_lifeItem) {
                $lista_lifeItem->secuencial = $contador;
                $contador++;
            }


            return view('fyl/reports/lista_life', [
                'training' => $training,
                'trainingId' => $trainingId,
                'lista_life' => $lista_life
            ]);
        }
    }

    
    public function calls(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        if (empty($requestData)) {
            return view('fyl/reports/follow_focus', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;
            $filter = $request->filter;

            $follow = DB::select('CALL get_fyl_follow_focus(?,?)', [$trainingId, $filter]);
            $contador = 1;

            foreach ($follow as $followItem) {
                $followItem->secuencial = $contador;
                $contador++;
            }
            
            //return $follow;

            return view('fyl/reports/follow_focus', [
                'training' => $training,
                'trainingId' => $trainingId,
                'follow' => $follow,
                'filter' => $filter
            ]);
        }
    }
    
    public function callsFTY(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        if (empty($requestData)) {
            return view('fyl/reports/follow_focus_to_your', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;
            $filter = $request->filter;

            $follow = DB::select('CALL get_fyl_follow_focus_to_your(?,?)', [$trainingId, $filter]);
            $contador = 1;

            foreach ($follow as $followItem) {
                $followItem->secuencial = $contador;
                $contador++;
            }
            
            //return $follow;

            return view('fyl/reports/follow_focus_to_your', [
                'training' => $training,
                'trainingId' => $trainingId,
                'follow' => $follow,
                'filter' => $filter
            ]);
        }
    }
    
    public function callsYour(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado


        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();
        
        //return $training;
        
        //return $request;

        if (empty($requestData)) {
            return view('fyl/reports/follow_your', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;
            $filter = $request->filter;

            $follow = DB::select('CALL get_fyl_follow_your(?,?)', [$trainingId, $filter]);
            $contador = 1;

            foreach ($follow as $followItem) {
                $followItem->secuencial = $contador;
                $contador++;
            }
            
            //return $follow;

            return view('fyl/reports/follow_your', [
                'training' => $training,
                'trainingId' => $trainingId,
                'follow' => $follow,
                'filter' => $filter
            ]);
        }
    }
    
    public function focusParticipants(Request $request)
    {
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado


        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        if (empty($requestData)) {
            return view('fyl/reports/focus_participants', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;
            $_training_id_enroller = 0;
            $call_B = $request->input('call_B') ?: '%';
            $call_L = $request->input('call_L') ?: '%';
            $perfil = $request->input('perfil') ?: '%';
            $mode = $request->input('mode') ?: '%';

            $focusParticipants = DB::select('CALL get_fyl_focus_participants(?,?,?,?,?,?,?)', [$trainingId,$_training_id_enroller, $search, $call_B, $call_L,$perfil,$mode]);
            $contador = 1;

            foreach ($focusParticipants as $focusParticipantsItem) {
                $focusParticipantsItem->secuencial = $contador;
                $contador++;
            }
            $payment_summary = DB::select('CALL get_fyl_payment_summary_focus(?,?,?)', [$trainingId,$request->program,$request->parameter]);
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($payment_summary as $payment_summaryItem) {
                $payment_summaryItem->secuencial = $contador;
                $contador++;
            }

            $participants = DB::table('fyl_participants_view')->where('training_id', $trainingId)->count();
            $partes = floor($participants / 30);
            if ($participants % 30 > 0){
                $partes = $partes + 1;
            }

            return view('fyl/reports/focus_participants', [
                'training' => $training,
                'trainingId' => $trainingId,
                'focusParticipants' => $focusParticipants,
                'payment_summary' => $payment_summary,
                //'summary' => $summary,
                //'total' => $total,
                'countParticipants' => $partes
            ]);
        }
    }
}
