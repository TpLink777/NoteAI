<x-layouts.dashboard title="Editar Categoría">
    <div class="max-w-2xl mx-auto animate-slide-up">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Editar Categoría</h2>
                <p class="mt-0.5 text-sm text-slate-500">Modifica los detalles de la categoría existente.</p>
            </div>
            <a href="{{ route('categories.index') }}"
                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-colors">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-[var(--shadow-card)] ring-1 ring-slate-100">
            <form action="{{ route('categories.edit', $category->id)  }}" method="POST"
                x-data="{ 
                    name: '{{ old('name', $category->name) }}', 
                    status: '{{ old('status', $category->getRawOriginal('status')) }}', 
                
                    originalName: '{{ old('name', $category->name) }}',
                    originalStatus: '{{ old('status', $category->getRawOriginal('status')) }}', 

                    noChanges(){
                        const isEqual = this.name === this.originalName &&
                            this.status === this.originalStatus

                        const isAny = !this.name.toString().trim() || 
                            !this.status.toString().trim()

                            return isEqual || isAny
                    }
                }"
                >
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nombre de la
                            Categoría</label>
                        <input type="text" name="name" id="name" x-model="name"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            placeholder="Ej. Trabajo, Personal, Ideas...">
                    </div>

                    <div>
                        <label for="estatus" class="mb-2 block text-sm font-medium text-slate-700">Estado</label>
                        <div class="relative">
                            <select name="status" id="estatus" x-model="status"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200">
                                <option value="active" {{ old('status', $category->getRawOriginal('status')) == 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ old('status', $category->getRawOriginal('status') ?? '') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            <x-heroicon-o-chevron-down
                                class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                            :disabled="noChanges()"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 
                            px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                            <x-heroicon-o-check class="w-4 h-4" />
                            Actualizar Categoría
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>