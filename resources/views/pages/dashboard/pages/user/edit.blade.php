<x-layouts.dashboard title="Editar Usuario">
    <div class="max-w-2xl mx-auto animate-slide-up">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Editar Usuario</h2>
                <p class="mt-0.5 text-sm text-slate-500">Modifica los datos del usuario.</p>
            </div>
            <a href="{{ route('usersPage') }}"
                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-colors">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-[var(--shadow-card)] ring-1 ring-slate-100">
            <form action="{{ route('user.update', $user->id) }}" method="POST"
                x-data="{ 
                    name: '{{ old('name', $user->name) }}', 
                    originalName: '{{ old('name', $user->name) }}',

                    noChanges(){
                        return this.name === this.originalName || !this.name.toString().trim()
                    }
                }"
                >
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nombre del Usuario</label>
                        <input type="text" name="name" id="name" x-model="name"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            placeholder="Ej. Juan Pérez">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                            :disabled="noChanges()"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 
                            py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                            <x-heroicon-o-check class="w-4 h-4" />
                            Actualizar Usuario
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
