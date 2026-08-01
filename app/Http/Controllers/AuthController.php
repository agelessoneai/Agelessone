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
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginInput = trim($credentials['login']);
        $password = $credentials['password'];
        $remember = $request->boolean('remember');

        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        if (Auth::attempt([$fieldType => $loginInput, 'password' => $password], $remember) ||
            Auth::attempt(['email' => $loginInput, 'password' => $password], $remember) ||
            Auth::attempt(['mobile' => $loginInput, 'password' => $password], $remember)) {

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

        return back()->withErrors(['login' => 'Invalid email, phone number, or password.'])->onlyInput('login');
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
