<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
class AuthController extends Controller
{
    public function showLogin(): View { return view('auth.login'); }
    public function showRegister(): View { return view('auth.register'); }
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required','email'], 'password' => ['required']]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return match (auth()->user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'security' => redirect()->route('security.dashboard'),
                'site_supervisor' => redirect()->route('supervisor.dashboard'),
                'sales' => redirect()->route('sales.dashboard'),
                'inventory_manager' => redirect()->route('office-inventory.index'),
                'workshop_manager' => redirect()->route('workshops.index'),
                'accounts' => redirect()->route('accounts.expenses.index'),
                default => redirect()->route('user.dashboard'),
            };
        }
        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }
    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','confirmed','min:6'],
        ]);
        $user = User::create(['name'=>$data['name'], 'email'=>$data['email'], 'password'=>Hash::make($data['password']), 'role'=>'office_staff']);
        Auth::login($user);
        return redirect()->route('user.dashboard');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
