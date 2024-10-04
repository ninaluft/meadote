<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login form.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validar o request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentar autenticar o usuário
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Verificar se há um redirecionamento específico no request
            if ($request->filled('redirectTo')) {
                return redirect($request->input('redirectTo'));
            }

            // Caso contrário, redirecionar para o dashboard apropriado
            return $this->redirectToDashboard(Auth::user());
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Handle the logout request.
     */
    public function destroy(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session to prevent reuse
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the homepage or login page
        return redirect('/');
    }

    /**
     * Redirect the user to their respective dashboard based on their type.
     */
    protected function redirectToDashboard($user)
    {
        // Check the user's type and redirect accordingly
        switch ($user->user_type) {
            case 'tutor':
                return redirect()->route('tutor.dashboard');
            case 'ong':
                return redirect()->route('ong.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->intended('/'); // Default redirection if no user_type matches
        }
    }
}
