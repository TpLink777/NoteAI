<x-layouts.minimal title="Página no encontrada">

    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 overflow-hidden relative">

        {{-- Subtle geometric pattern --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>

        <div class="relative z-10 text-center px-6 animate-slide-up">
            <p class="text-sm font-medium uppercase tracking-widest text-slate-500 mb-4">Error 404</p>

            <h1 class="text-[8rem] sm:text-[10rem] font-bold text-white leading-none tracking-tighter">
                4<span class="text-slate-600">0</span>4
            </h1>

            <h2 class="text-lg font-medium text-slate-400 mt-2 mb-2">Página no encontrada</h2>

            <p class="text-sm text-slate-500 max-w-sm mx-auto mb-10">
                Lo sentimos, la página que buscas no existe o fue movida a otra ubicación.
            </p>

            <a href="/"
                class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-medium text-slate-900 shadow-sm transition-all duration-200 hover:bg-slate-100 active:scale-[0.98]">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver al inicio
            </a>
        </div>
    </div>

</x-layouts.minimal>
