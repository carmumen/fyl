<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Aplication;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
    }

    public function update($request, Aplication $Aplication)
    {
    }

    public function destroy(Aplication $Aplication)
    {
    }
}
