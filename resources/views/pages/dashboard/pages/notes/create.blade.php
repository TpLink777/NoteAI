<x-layouts.dashboard title="Nueva Nota">
    <div class="max-w-3xl mx-auto animate-slide-up">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Crear Nota</h2>
                <p class="mt-0.5 text-sm text-slate-500">Escribe tus ideas y asígnalas a una categoría.</p>
            </div>
            <a href="{{ route('notes.index') }}"
                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-colors">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-[var(--shadow-card)] ring-1 ring-slate-100">
            <form action="{{ route('notes.create') }}" method="POST" x-data="{ 
                title: '', 
                content: '',
                aiSuggestion: '',
                isGenerating: false,

                generateSuggestion(){
                    if(this.title.trim() === ''){
                        alert('Por favor ingresa un título para la nota.');
                        return;
                    }
                    
                    this.isGenerating = true;
                    this.aiSuggestion = '';
                    
                    axios.post('{{ route('ai.suggest') }}', 
                    { 
                        title: this.title 
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                        .then(res =>{
                            if(res.data && res.data.suggestion) {
                                this.aiSuggestion = res.data.suggestion;
                            } else {
                                alert('La IA no devolvió ninguna sugerencia.');
                            }
                        })
                        .catch(error => {
                            console.error('Error al generar sugerencia:', error);
                            alert('Hubo un error al generar la sugerencia. Inténtalo de nuevo.');
                        })
                        .finally(() => {
                            this.isGenerating = false;
                        });
                },        
            }">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Título</label>
                        <div class="flex gap-3">
                            <input name="title" type="text" x-model="title" id="title"
                                class="flex-1 w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                                placeholder="Ej. Ideas para el proyecto, Lista de pendientes...">

                            <button type="button" @click="generateSuggestion()"
                                :disabled="isGenerating || !title.trim()"
                                class="cursor-pointer bg-blue-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-950 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 shrink-0 min-w-[160px] shadow-sm">
                                <span x-show="!isGenerating" class="flex items-center gap-2">
                                    <x-heroicon-o-sparkles class="w-4 h-4" />
                                    <span class="hidden sm:inline">Proponer con IA</span>
                                </span>
                                <span x-show="isGenerating" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Generando...
                                </span>
                            </button>

                        </div>
                    </div>

                    <div>
                        <label for="category_id" class="mb-2 block text-sm font-medium text-slate-700">Categoría
                            (Opcional)</label>
                        <div class="relative">
                            <select name="category_id" id="category_id"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200">
                                <option value="">Selecciona una categoría</option>
                                @if(isset($categories)) {{-- sirve para verificar que la variable categories exista --}}
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ Str::ucfirst($category->name) }}</option>
                                @endforeach
                                @endif
                            </select>
                            <x-heroicon-o-chevron-down
                                class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                        </div>
                    </div>

                    <div class="relative">
                        <label for="content" class="mb-2 block text-sm font-medium text-slate-700">Contenido de la
                            nota</label>
                        <textarea name="content" x-model="content" id="content" rows="7"
                            class="w-full rounded-xl border border-slate-200 resize-none bg-slate-50 py-2.5 px-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            placeholder="Empieza a escribir..."></textarea>
                        <template x-if="aiSuggestion">
                            <div
                                class="absolute inset-x-2 bottom-2 bg-slate-900 text-white p-5 rounded-xl shadow-xl border border-slate-700 animate-slide-up z-10 flex flex-col gap-3">
                                <div class="flex items-center gap-2 text-indigo-400">
                                    <x-heroicon-o-bolt class="w-5 h-5" />
                                    <p class="text-xs font-bold uppercase tracking-wider">Sugerencia de NoteAI</p>
                                </div>
                                <p class="text-sm text-slate-200 leading-relaxed" x-text="aiSuggestion"></p>
                                <div class="flex justify-end gap-3 mt-1">
                                    <button type="button" @click="aiSuggestion=''"
                                        class="px-4 py-2 text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-colors">
                                        Descartar
                                    </button>
                                    <button type="button" @click="content= aiSuggestion; aiSuggestion=''"
                                        class="px-4 py-2 text-xs font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 shadow-md transition-all active:scale-95 flex items-center gap-1.5">
                                        <x-heroicon-o-check class="w-4 h-4" />
                                        Aceptar Sugerencia
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button :disabled="!title.trim() || !content.trim()" type="submit"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-slate-800 active:scale-[0.98]">
                            <x-heroicon-o-check class="w-4 h-4" />
                            Guardar Nota
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>