<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect admins after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }


    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->get('remember'))) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return back()->with($request->only('email', 'remember'));
    }


    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('admin')->logout();
        /**
         * Sessions should always be invalidated at login to help prevent Session fixation attacks.
         * Invalidating a session will mark the session as invalid and will be destroyed.
         */
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

}
