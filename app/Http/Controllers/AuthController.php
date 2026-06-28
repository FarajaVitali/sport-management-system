<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- REGISTRATION ---

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,coach,player',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'active', // Default status upon creation
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // --- ONBOARDING REDIRECTION FOR NEW USERS ---
        if ($user->role === 'coach') {
            return redirect()->route('coach.form');
        } elseif ($user->role === 'player') {
            return redirect()->route('player.form');
        }

        // Fallback for admin or unhandled roles
        return $this->redirectByRole();
    }

    // --- LOGIN ---

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);

        if (Auth::attempt($credentials)) {
            // OPTIONAL CHECK: If you want to block banned users right at login:
            if (Auth::user()->status === 'banned') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your access privileges have been suspended.']);
            }

            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors(['email' => 'Invalid login credentials']);
    }

    // --- REDIRECTION LOGIC ---

    private function redirectByRole()
    {
        $role = Auth::user()->role;

        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'coach' => redirect()->route('coach.dashboard'),
            'player' => redirect()->route('player.player_dashboard'),
            default => redirect('/'),
        };
    }

    // --- DASHBOARDS & MANAGEMENT ACTIONS ---

    public function showAdminDashboard()
    {
        $users = User::all(); 
        return view('admin.dashboard', compact('users'));
    }

    public function show()
    {
        $users = User::where('role', 'player')->with('playerProfile')->get();
        return view('admin.players', compact('users'));
    }

    /**
     * Change a user's access status to allowed (Active).
     */
    public function allowUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', "Player account access reinstated successfully!");
    }

    /**
     * Restrict a user's dashboard entry permissions (Banned/Suspended).
     */
    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);

        return redirect()->back()->with('success', "Player access privileges revoked immediately.");
    }

    public function showCoachDashboard() 
    {
        return view('coach.dashboard');
    }

    public function showPlayerDashboard() 
    {
        return view('player.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}