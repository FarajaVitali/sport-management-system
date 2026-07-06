<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fan Dashboard - Sports Portal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- FontAwesome for clean sport icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <div class="min-h-screen flex flex-col">
        <!-- TOP NAVIGATION BAR -->
        <nav class="bg-slate-900 text-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-trophy text-amber-400 text-2xl"></i>
                        <span class="text-xl font-black tracking-wider uppercase">Sports<span class="text-blue-500">Center</span></span>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-slate-300">Welcome back,</p>
                            <p class="text-xs text-slate-400 font-semibold">{{ auth()->user()->name ?? 'Fan Space' }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-md shadow-sm transition-all duration-200">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- MAIN LAYOUT WRAPPER -->
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex-1 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT & CENTER COLUMN: MATCH UPDATES AND SCHEDULES -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- 1. LIVE MATCHES ZONE -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold flex items-center gap-2 text-slate-800">
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                            Live Action Updates
                        </h2>
                        <span class="text-xs font-semibold bg-red-100 text-red-700 px-2.5 py-1 rounded-full uppercase tracking-wider">Real-time</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Loop through live fixtures dynamically -->
                        @forelse($liveFixtures ?? [] as $live)
                            <div class="bg-white border-l-4 border-red-500 rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                                <div class="bg-slate-50 px-4 py-2 flex justify-between items-center border-b border-gray-100">
                                    <span class="text-xs font-bold text-slate-500 uppercase flex items-center gap-1">
                                        <i class="fa-solid fa-circle-play text-blue-500"></i> {{ $live->sport->name ?? 'Match' }}
                                    </span>
                                    <span class="text-xs font-bold text-red-600 animate-pulse bg-red-50 px-2 py-0.5 rounded uppercase">{{ $live->live_status ?? 'LIVE' }}</span>
                                </div>
                                <div class="p-4 flex justify-between items-center">
                                    <div class="space-y-2 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-700 text-sm">{{ $live->homeTeam->name ?? 'Home Team' }}</span>
                                            <span class="text-lg font-black text-slate-900 bg-slate-100 px-2.5 py-0.5 rounded">{{ $live->home_team_score ?? 0 }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-700 text-sm">{{ $live->awayTeam->name ?? 'Away Team' }}</span>
                                            <span class="text-lg font-black text-slate-900 bg-slate-100 px-2.5 py-0.5 rounded">{{ $live->away_team_score ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Placeholder display if database is empty right now -->
                            <div class="col-span-2 bg-white p-6 rounded-xl border border-dashed border-gray-300 text-center py-8">
                                <i class="fa-solid fa-satellite-dish text-slate-300 text-3xl mb-2"></i>
                                <p class="text-sm font-medium text-slate-500">No matches are actively live right now.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- 2. UPCOMING FIXTURES -->
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-regular fa-calendar-days text-blue-500"></i> Upcoming Fixtures Schedule
                    </h2>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-900 text-white text-xs uppercase tracking-wider">
                                        <th class="py-3.5 px-4 font-semibold">Sport</th>
                                        <th class="py-3.5 px-4 font-semibold">Matchup</th>
                                        <th class="py-3.5 px-4 font-semibold">Date & Time</th>
                                        <th class="py-3.5 px-4 font-semibold text-center">Venue</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm text-slate-600">
                                    @forelse($upcomingFixtures ?? [] as $fixture)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="py-4 px-4 font-bold text-slate-900 uppercase text-xs">{{ $fixture->sport->name }}</td>
                                            <td class="py-4 px-4 font-medium">
                                                <span class="text-slate-900 font-semibold">{{ $fixture->homeTeam->name }}</span> 
                                                <span class="text-slate-400 font-normal px-1">vs</span> 
                                                <span class="text-slate-900 font-semibold">{{ $fixture->awayTeam->name }}</span>
                                            </td>
                                            <td class="py-4 px-4 font-medium">{{ \Carbon\Carbon::parse($fixture->match_time)->format('M d, h:i A') }}</td>
                                            <td class="py-4 px-4 text-center font-medium text-xs bg-slate-50/50">{{ $fixture->venue ?? 'Main Field' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-slate-400 font-medium">
                                                <i class="fa-solid fa-hourglass-start text-xl mb-1 block"></i> No upcoming matches listed yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <!-- RIGHT COLUMN: STANDINGS AND RULES INFOGRAPHIC -->
            <div class="space-y-8">
                
                <!-- 3. LEADERBOARD / TEAM STANDINGS -->
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <i class="fa-solid fa-ranking-star text-amber-500"></i> Overall Team Standings
                    </h2>
                    
                    <div class="space-y-3">
                        @forelse($teams ?? [] as $index => $team)
                            <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg border border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <span class="w-6 text-xs font-black text-slate-400 text-center">{{ $index + 1 }}</span>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">{{ $team->name }}</h4>
                                        <p class="text-xs text-slate-400 font-medium">{{ $team->college->name ?? 'College' }} • {{ $team->sport->name ?? '' }}</p>
                                    </div>
                                </div>
                                <span class="bg-blue-50 text-blue-700 font-black px-2.5 py-1 rounded text-xs tracking-wide">
                                    {{ $team->points ?? 0 }} PTS
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-center py-4 text-slate-400 font-medium">No standings computed yet.</p>
                        @endforelse
                    </div>
                </section>

                <!-- 4. TOURNAMENT RULES & COMPLIANCE -->
                <section class="bg-gradient-to-br from-slate-800 to-slate-900 text-white rounded-xl shadow-sm p-5">
                    <h2 class="text-lg font-bold mb-3 flex items-center gap-2 text-blue-400 border-b border-slate-700 pb-3">
                        <i class="fa-solid fa-scale-balanced"></i> Fair Play & Guidelines
                    </h2>
                    <ul class="space-y-3 text-xs text-slate-300 font-medium leading-relaxed">
                        @forelse($rules ?? [] as $rule)
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-blue-400 mt-0.5 shrink-0"></i>
                                <span><strong>{{ $rule->title }}:</strong> {{ $rule->description }}</span>
                            </li>
                        @empty
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-blue-400 mt-0.5 shrink-0"></i>
                                <span>Respect all refereeing decisions instantly on match grounds.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-blue-400 mt-0.5 shrink-0"></i>
                                <span>Unsportsmanlike conduct from fans will lead to points deduction for their corresponding college team.</span>
                            </li>
                        @endforelse
                    </ul>
                </section>
            </div>
        </div>
    </div>
</body>
</html>