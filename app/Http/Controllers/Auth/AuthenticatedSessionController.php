<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Aplication;

use App\Models\Users;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = $request->user();
    
        if ($user && ($user->status !== 'ACTIVE' || $user->user_type !== 'FYL')) {
        //if ($request->user() && ($request->user()->status !== 'ACTIVE' || !in_array($request->user()->user_type, ['FYL']))) {
            Auth::logout();
            if($user->user_type !== 'FYL')
                return redirect()->route('login')->with('status', __('No tienes acceso a esta plataforma.'));
            else
                return redirect()->route('login')->with('status', __('Tu cuenta no está activa.'));
            
        }

        $request->session()->regenerate();
        
        $aplications = Aplication::from('security_aplications AS A')
        ->join('security_functionalities AS F', 'A.id', '=', 'F.aplication_id')
        ->join('security_profiles AS P', 'A.id', '=', 'P.aplication_id')
        ->join('security_user_profiles AS UP', 'P.id', '=', 'UP.profile_id')
        ->select('A.id',
                  'A.icon',
                  'A.name',
                  'A.description',
                  'A.start_path',
                  'A.state')
        ->where('UP.user_id', '=', $request->user()?->id)
        ->where('A.state', '=', 'ACTIVE')
        ->groupby('A.id','A.name','A.icon','A.description','A.start_path','A.state')
        ->orderBy('A.name','asc')
        ->get();

        session(['aplication' => $aplications]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
