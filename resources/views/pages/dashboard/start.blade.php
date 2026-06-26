<x-layouts.dashboard title="Inicio">
    <div class="max-w-6xl mx-auto animate-fade-in">


        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-slate-800 tracking-tight">
                Bienvenido, {{ Auth()->user()->name }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">Aquí tienes un resumen de tu actividad.</p>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-5 stagger">
            <div
                class="animate-slide-up rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-[var(--shadow-card)] hover:shadow-[var(--shadow-elevated)] transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                        <x-heroicon-o-document-text class="w-5 h-5 text-slate-600" />
                    </div>
                    <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Notas</span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-800 tracking-tight">{{ $notes->count() }}</p>
                <p class="mt-1 text-sm text-slate-500">Total creadas</p>
            </div>


            <div
                class="animate-slide-up rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-[var(--shadow-card)] hover:shadow-[var(--shadow-elevated)] transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                        <x-heroicon-o-tag class="w-5 h-5 text-slate-600" />
                    </div>
                    <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Categorías</span>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-800 tracking-tight">{{ $categoriesActives->count() }}</p>
                <p class="mt-1 text-sm text-slate-500">Activas</p>
            </div>
        </div>

        <div class="mt-10 rounded-2xl bg-white p-8 ring-1 ring-slate-100 shadow-[var(--shadow-card)]">
            <h3 class="text-lg font-semibold text-slate-800 tracking-tight mb-1">Acciones rápidas</h3>
            <p class="text-sm text-slate-500 mb-6">Accede a las funciones principales de la plataforma.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('notes.index') }}"
                    class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition-all duration-200 hover:border-slate-300 hover:bg-slate-50">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 group-hover:bg-slate-200 transition-colors duration-200">
                        <x-heroicon-o-pencil-square class="w-5 h-5 text-slate-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">Nueva Nota</p>
                        <p class="text-xs text-slate-400">Crear una nota</p>
                    </div>
                </a>

                <a href="{{ route('categories.index') }}"
                    class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition-all duration-200 hover:border-slate-300 hover:bg-slate-50">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 group-hover:bg-slate-200 transition-colors duration-200">
                        <x-heroicon-o-tag class="w-5 h-5 text-slate-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">Categorías</p>
                        <p class="text-xs text-slate-400">Gestionar categorías</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
</x-layouts.dashboard>