<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referee Control Center</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    <div class="min-h-screen flex flex-col">
        <!-- NAVIGATION BAR -->
        <nav class="bg-blue-950 text-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-whistle text-blue-400 text-2xl rotate-45"></i>
                        <span class="text-xl font-black tracking-wider uppercase">Match<span class="text-blue-400">Official</span></span>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-slate-300">Official Panel</p>
                            <p class="text-xs text-blue-300 font-semibold">{{ auth()->user()->name }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold uppercase tracking-wider px-4 py-2 rounded border border-slate-700 transition">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- MAIN LAYOUT WRAPPER -->
        <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex-1 space-y-8">
            
            <!-- SUCCESS MESSAGES FEEDBACK -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2 text-emerald-800 font-semibold text-sm">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- QUICK STATISTICS BANNER -->
            <section class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Assigned Matches</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ count($assignedFixtures ?? []) }}</h3>
                    </div>
                    <i class="fa-solid fa-clipboard-list text-slate-300 text-3xl"></i>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Live Duties</p>
                        <h3 class="text-3xl font-black text-red-600 mt-1">
                            {{ ($assignedFixtures ?? collect())->where('is_live', true)->count() }}
                        </h3>
                    </div>
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Match Rules Reference</p>
                        <a href="{{ route('rules.index') }}" class="text-xs font-bold text-blue-600 underline block mt-2 hover:text-blue-800">View Fair Play Guide →</a>
                    </div>
                    <i class="fa-solid fa-scale-balanced text-slate-300 text-3xl"></i>
                </div>
            </section>

            <!-- PRIMARY CONTROL PANELS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- FIXTURES MANAGEMENT BOARD (LEFT & CENTER COLUMN) -->
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-stopwatch text-blue-600"></i> Your Assigned Fixtures Panel
                    </h2>

                    @forelse($assignedFixtures ?? [] as $fixture)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                            <!-- Header Info -->
                            <div class="bg-slate-900 text-white px-5 py-3 flex flex-wrap justify-between items-center gap-2">
                                <div class="flex items-center space-x-2">
                                    <span class="bg-blue-600 text-[10px] font-bold uppercase px-2 py-0.5 rounded tracking-wider">
                                        {{ $fixture->sport->name ?? 'Sport Game' }}
                                    </span>
                                    <span class="text-xs text-slate-300 font-medium">
                                        <i class="fa-regular fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($fixture->match_time)->format('M d, h:i A') }}
                                    </span>
                                </div>
                                <div class="text-xs font-semibold text-slate-400">
                                    Venue: <span class="text-white">{{ $fixture->venue ?? 'Main Court' }}</span>
                                </div>
                            </div>

                            <!-- Live Status & Scoring Manager Form -->
                                        <!-- Live Status & Scoring Manager Form -->
<!-- Live Status & Scoring Manager Form -->
<form action="{{ route('referee.fixtures.update', $fixture->id) }}" method="POST" class="p-5 space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200">
        <!-- Home Team -->
        <div class="flex flex-col items-center sm:items-end">
            <label class="font-bold text-slate-700 text-sm mb-1">{{ $fixture->homeTeam->name }}</label>
            <input type="number" name="home_team_score" value="{{ $fixture->home_team_score ?? 0 }}" class="w-20 border rounded text-center py-1.5 font-black">
        </div>

        <div class="text-center text-slate-400 font-bold text-xs uppercase">VS</div>

        <!-- Away Team -->
        <div class="flex flex-col items-center sm:items-start">
            <label class="font-bold text-slate-700 text-sm mb-1">{{ $fixture->awayTeam->name }}</label>
            <input type="number" name="away_team_score" value="{{ $fixture->away_team_score ?? 0 }}" class="w-20 border rounded text-center py-1.5 font-black">
        </div>
    </div>

    <!-- Match Control Flags -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
        <div class="flex items-center space-x-4">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_live" value="1" {{ $fixture->is_live ? 'checked' : '' }} class="h-4 w-4">
                <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Set Match Live</span>
            </label>

            <select name="live_status" class="bg-white border text-xs font-semibold rounded px-2.5 py-1">
                <option value="Not Started" {{ $fixture->live_status == 'Not Started' ? 'selected' : '' }}>Scheduled</option>
                <option value="First Half" {{ $fixture->live_status == 'First Half' ? 'selected' : '' }}>First Half</option>
                <option value="Halftime" {{ $fixture->live_status == 'Halftime' ? 'selected' : '' }}>Halftime</option>
                <option value="Second Half" {{ $fixture->live_status == 'Second Half' ? 'selected' : '' }}>Second Half</option>
                <option value="Completed" {{ $fixture->live_status == 'Completed' ? 'selected' : '' }}>Full Time / Ended</option>
            </select>
        </div>

        <div class="flex items-center space-x-3">
            @if(!$fixture->is_live && $fixture->live_status === 'Not Started')
                <!-- THIS IS THE START BUTTON AS A FORM BUTTON -->
                <button type="submit" name="action" value="start_match" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase px-5 py-2.5 rounded transition">
                    <i class="fa-solid fa-play mr-1"></i> Start Match
                </button>
            @endif

            <button type="submit" name="action" value="update" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase px-5 py-2.5 rounded transition">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Update Match Data
            </button>
        </div>
    </div>
</form>
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-xl border border-dashed border-slate-300 text-center py-12">
                            <i class="fa-solid fa-circle-exclamation text-slate-300 text-4xl mb-3"></i>
                            <p class="font-bold text-slate-700">No Match Assignments Listed</p>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">You aren't linked as an official referee on any active game schedules currently.</p>
                        </div>
                    @endforelse
                </div>

                <!-- SIDEBAR GUIDELINES SIDE (RIGHT COLUMN) -->
                <div id="rules-card" class="space-y-6">
                    <div class="bg-slate-900 text-white rounded-xl shadow-sm p-5 border border-slate-800">
                        <h2 class="text-base font-bold mb-3 flex items-center gap-2 text-blue-400 border-b border-slate-800 pb-3">
                            <i class="fa-solid fa-gavel"></i> Referee Ground Code
                        </h2>
                        <ul class="space-y-3 text-xs text-slate-400 leading-relaxed font-medium">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-check text-blue-400 mt-0.5"></i>
                                <span>Ensure score counts are accurately updated in real-time for fans viewing dashboards across the campus.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-check text-blue-400 mt-0.5"></i>
                                <span>Remember to toggle off the <strong>"Set Match Live"</strong> flag and switch status to <strong>"Completed"</strong> as soon as the final whistle blows.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-check text-blue-400 mt-0.5"></i>
                                <span>Unsportsmanlike actions or complaints must be documented and directed straight to the Sports Board head.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>