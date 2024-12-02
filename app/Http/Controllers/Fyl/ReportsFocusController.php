<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportsFocusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index',  'link', 'register']]);
    }

    public function index(Request $request)
    {
        //return 'hola';
        $requestData = $request->all();

        $search = $request->input('search') ?: '';

        if ($search == '') {
            if (Str::length(session('search')) > 1)
                $search = session('search');
        }

        session(['search' => $search]);

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $userId = auth()->id(); // Reemplaza con el ID de usuario deseado

        $result = DB::select('CALL sp_get_training_payments(?)', [$userId]);

        $collection = collect($result);

        $training = $collection->pluck('name', 'id')->toArray();

        if (empty($requestData)) {
            return view('fyl/reports.focus', [
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
            
            return view('fyl/reports.focus', [
                 'training' => $training,
                'trainingId' => $trainingId,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
                'countParticipants' => $partes
            ]);

        }
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

        return $pdf->stream();
    }

    public function gafete($id)
    {
        $participant = $this->getParticipantes($id);
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

    public function payment_summary_focus(Request $request)
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

        //$training = $collection->pluck('name', 'id')->toArray();
        //$training = DB::table('fyl_training_focus_view')->where('user_id',$userId)->pluck('name', 'id')->toArray();
        
        $training = DB::table('fyl_training_focus_participants_view as T')
         ->where('T.user_id', '=', auth()->id())
         ->pluck('name','id');

        //return $training;

        if (empty($requestData)) {
            return view('fyl/reports/payment_summary', [
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

            return view('fyl/reports/payment_summary', [
                'training' => $training,
                'trainingId' => $trainingId,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
                'countParticipants' => $partes
            ]);
        }
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

        //return $associativeArray;

        if (empty($requestData)) {
            return view('fyl/reports/payment_summary_your', [
                'training' => $training,
                'trainingId' => 0
            ]);
        } else {
            $trainingId = $request->training_id;

            $summary = DB::table('fyl_payment_summary_your_view')
                        ->select(
                            'MetodoPago',
                            DB::raw('sum(Monto) as Monto')
                        )
                        ->where('training_id', $trainingId)
                        ->where('program','LIKE','Y%')
                        ->groupBy('MetodoPago')
                        ->get();

            $total = $summary->sum('Monto'); // Sumatoria total

            $payment_summary = DB::select('CALL get_fyl_payment_summary_your(?,?,?)', [$trainingId,$request->program,$request->parameter]);
            $contador = 1;

            // Asignar el número secuencial a cada registro
            foreach ($payment_summary as $payment_summaryItem) {
                $payment_summaryItem->secuencial = $contador;
                $contador++;
            }

            //return $payment_summary;

            // $participants = DB::table('fyl_participants_view')->where('training_id', $trainingId)->count();
            // $partes = floor($participants / 30);
            // if ($participants % 30 > 0){
            //     $partes = $partes + 1;
            // }

            return view('fyl/reports/payment_summary_your', [
                'training' => $training,
                'trainingId' => $trainingId,
                'payment_summary' => $payment_summary,
                'summary' => $summary,
                'total' => $total,
                // 'countParticipants' => $partes
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

    public function listadoYour(Request $request)
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

        //return $training;

        //return $request;

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

            return view('fyl/reports/follow_focus', [
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

            $call_B = $request->input('call_B') ?: '%';
            $call_L = $request->input('call_L') ?: '%';
            $perfil = $request->input('perfil') ?: '%';
            $mode = $request->input('mode') ?: '%';

            $focusParticipants = DB::select('CALL get_fyl_focus_participants(?,?,?,?,?,?)', [$trainingId, $search, $call_B, $call_L,$perfil,$mode]);
            $contador = 1;

            foreach ($focusParticipants as $focusParticipantsItem) {
                $focusParticipantsItem->secuencial = $contador;
                $contador++;
            }

            return view('fyl/reports/focus_participants', [
                'training' => $training,
                'trainingId' => $trainingId,
                'focusParticipants' => $focusParticipants,
            ]);
        }
    }
}



