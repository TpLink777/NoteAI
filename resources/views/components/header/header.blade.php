<header
    class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white/80 backdrop-blur-md px-8 py-4">
    <div class="flex items-center gap-3">
        <h1 class="text-lg font-semibold text-slate-800 tracking-tight">{{ $title }}</h1>
    </div>
    <div class="flex items-center gap-3">
        <div
            class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-sm font-medium text-slate-600 ring-1 ring-slate-200">
            {{ mb_strtoupper(substr(Auth()->user()->name, 0, 1)) }}
        </div>
        <span class="text-sm font-medium text-slate-600 hidden sm:inline">{{ Auth()->user()->name }}</span>
    </div>
</header>