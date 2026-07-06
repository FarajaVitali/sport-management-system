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
            'role' => 'required|in:coach,player,referee,fan',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'active', 
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'coach') {
            return redirect()->route('coach.form');
        } elseif ($user->role === 'player') {
            return redirect()->route('player.form');
        }

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
            $user = Auth::user();

            if ($user->status === 'banned') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been suspended. Please contact the administrator.']);
            }

            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors(['email' => 'Invalid login credentials']);
    }

    // --- CENTRALIZED REDIRECTION ENGINE ---

    private function redirectByRole()
{
    $user = Auth::user();
    
    // DEBUG: Uncomment the next line to see what role the system sees
    // dd($user->role); 

    if (!$user->role) {
        return redirect('/login')->with('error', 'Your account has no assigned role.');
    }

    return match($user->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'coach'   => redirect()->route('coach.dashboard'),
        'player'  => redirect()->route('player.player_dashboard'),
        'referee' => redirect()->route('referee.dashboard'),
        'fan'     => redirect()->route('fan.dashboard'),
        default   => redirect('/'),
    };
}

    // --- DASHBOARDS & MANAGEMENT ACTIONS ---

    public function showAdminDashboard()
    {
        // SECURITY CHECK
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $users = User::all(); 
        return view('admin.dashboard', compact('users'));
    }
    public function show()
    {
        $users = User::where('role', 'player')->with('playerProfile')->get();
        return view('admin.players', compact('users'));
    }

    public function allowUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', "Account access reinstated successfully!");
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);
        return redirect()->back()->with('success', "User access privileges revoked immediately.");
    }

    public function showCoachDashboard() 
    {
        $coach = Auth::user();
        if ($coach->coachProfile && $coach->coachProfile->team) {
            $team = $coach->coachProfile->team;
            $players = User::where('role', 'player')
                ->whereHas('playerProfile', function($query) use ($team) {
                    $query->where('team', $team->name); 
                })
                ->with('playerProfile')
                ->get();
        } else {
            $team = null;
            $players = collect();
        }

        return view('coach.dashboard', compact('team', 'players'));
    }

    public function showRefereeDashboard()
    {
        return redirect()->route('referee.dashboard');
    }

    public function showFanDashboard()
    {
        return view('fan.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}