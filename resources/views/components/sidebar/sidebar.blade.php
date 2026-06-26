<nav
    class="w-[15rem] h-screen bg-gradient-to-b from-slate-900 to-slate-950 border-r border-slate-800/50 px-4 py-6 flex-shrink-0">
    <div class="flex h-full flex-col justify-between">

        <div>
            {{-- Brand --}}
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2.5 px-2 text-[15px] font-semibold text-white no-underline tracking-tight">
                <div class="flex w-8 h-8 items-center justify-center rounded-lg bg-white/10 backdrop-blur-sm">
                    <svg width="16" height="16" viewBox="0 0 14 14" fill="currentColor" class="text-white/90">
                        <rect x="1" y="1" width="5" height="5" rx="1.5" />
                        <rect x="8" y="1" width="5" height="5" rx="1.5" />
                        <rect x="1" y="8" width="5" height="5" rx="1.5" />
                        <rect x="8" y="8" width="5" height="5" rx="1.5" opacity="0.4" />
                    </svg>
                </div>
                <span>NoteAI</span>
            </a>

            <div class="mt-8 flex flex-col gap-1">
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13.5px] font-medium transition-all duration-200
                    {{ Route::is('dashboard') ? 'bg-white/10 text-white border-l-2 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-slate-200 border-l-2 border-transparent' }}">
                    <x-heroicon-o-home-modern class="w-[18px] h-[18px] flex-shrink-0" />
                    <span>Home</span>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13.5px] font-medium transition-all duration-200
                    {{ Route::is('categories.*') ? 'bg-white/10 text-white border-l-2 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-slate-200 border-l-2 border-transparent' }}">
                    <x-heroicon-o-tag class="w-[18px] h-[18px] flex-shrink-0" />
                    <span>Categories</span>
                </a>
                @role('admin')
                <a href="{{ route('usersPage') }}"
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13.5px] font-medium transition-all duration-200
                    {{ Route::is('usersPage') ? 'bg-white/10 text-white border-l-2 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-slate-200 border-l-2 border-transparent' }}">
                    <x-heroicon-o-users class="w-[18px] h-[18px] flex-shrink-0" />
                    <span>Users</span>
                </a>
                @endrole
                <a href="{{ route('notes.index') }}"
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13.5px] 
                    {{ Route::is('notes.*') ? 'bg-white/10 text-white border-l-2 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-slate-200 border-l-2 border-transparent' }} font-medium text-slate-400 hover:bg-white/5 hover:text-slate-200 transition-all duration-200 border-l-2 border-transparent">
                    <x-heroicon-o-pencil class="w-[18px] h-[18px] flex-shrink-0" />
                    <span>Notes</span>
                </a>
            </div>
        </div>


        <div class="relative" id="dropdown">
            <div class="h-px w-full bg-slate-800 mb-4"></div>

            <button
                class="w-full px-3 py-3 flex items-center gap-3 rounded-lg bg-white/5 hover:bg-white/10 p-2.5 cursor-pointer transition-all duration-200"
                id="logout">
                <div class="flex flex-col items-start">
                    <span class="text-[13px] font-medium text-white leading-tight">
                        {{ mb_strtoupper(strtok(Auth()->user()->name, ' ')) }}
                    </span>
                    <span class="text-[11px] text-slate-500 leading-tight">{{ Auth()->user()->email ?? '' }}</span>
                </div>
            </button>

            <form action="{{ route('logout') }}" method="POST" id="form"
                class="hidden absolute left-0 bottom-full mb-2 w-full rounded-lg bg-slate-800 border border-slate-700 p-1.5 shadow-lg z-50 animate-slide-down">
                @csrf
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="flex-1 rounded-md px-3 py-2 text-left flex gap-2 items-center text-sm text-slate-300 hover:bg-slate-700 hover:text-white cursor-pointer transition-colors duration-150">
                        <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4" />
                        Cerrar sesión
                    </button>

                    <button type="button"
                        class="cursor-pointer p-1.5 rounded-md hover:bg-slate-700 transition-colors duration-150"
                        id="btnClose">
                        <x-heroicon-o-x-mark class="w-4 h-4 text-slate-400 hover:text-white" />
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>