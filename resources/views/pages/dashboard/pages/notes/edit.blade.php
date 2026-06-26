<x-layouts.dashboard title="Editar Nota">
    <div class="max-w-3xl mx-auto animate-slide-up overflow-hidden">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Editar Nota</h2>
                <p class="mt-0.5 text-sm text-slate-500">Modifica el contenido o estado de tu nota.</p>
            </div>
            <a href="{{ route('notes.index') }}"
                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-colors">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-[var(--shadow-card)] ring-1 ring-slate-100">
            <form action="{{ route('notes.update', $note->id) }}" method="POST" x-data="editNote">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Título</label>
                        <input type="text" name="title" id="title" required x-model="title"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category_id"
                                class="mb-2 block text-sm font-medium text-slate-700">Categoría</label>
                            <div class="relative">
                                <select name="category_id" id="category_id" x-model="category_id"
                                    class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200">
                                    <option value="">Sin categoría</option>
                                    @if(isset($categories))
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $note->category_id ?? '')
                                        == $category->id) ? 'selected' : '' }}>
                                        {{ Str::ucfirst($category->name) }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-heroicon-o-chevron-down
                                    class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                            </div>
                        </div>

                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Estado</label>
                            <div class="relative">
                                <select name="status" id="status" x-model="status"
                                    class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-sm text-slate-800 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200">
                                    <option value="active" {{ old('status', $note->getRawOriginal('status')) == 'active'
                                        ? 'selected' : ''
                                        }}>Activo</option>
                                    <option value="inactive" {{ old('status', $note->getRawOriginal('status') ?? '') ==
                                        'inactive' ? 'selected'
                                        : '' }}>Inactivo</option>
                                </select>
                                <x-heroicon-o-chevron-down
                                    class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label for="content" class="mb-2 block text-sm font-medium text-slate-700">Contenido de la
                                nota</label>
                            <button type="button" @click="improveContent()" :disabled="isGenerating"
                                class="inline-flex items-center gap-2 px-3 py-1.5 cursor-pointer bg-blue-900 rounded-lg text-xs font-medium text-white hover:bg-blue-950 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <x-heroicon-o-sparkles class="w-3.5 h-3.5" />
                                <span x-text="isGenerating ? 'Generando...' : 'Mejorar con IA'"></span>
                            </button>
                        </div>
                        <textarea name="content" id="content" required rows="6" x-model="content"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200 resize-none"></textarea>

                        <template x-if="aiSuggestion">
                            <div
                                class="absolute inset-x-2 bottom-2 bg-blue-900 text-white p-5 rounded-xl shadow-xl border border-slate-700 animate-slide-up z-10 flex flex-col gap-3">
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
                        <button type="submit" :disabled="noChanges()"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                            <x-heroicon-o-check class="w-4 h-4" />
                            Actualizar Nota
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('editNote', () => ({
                title: {!! json_encode(old('title', $note->title) ?? '') !!},
                content: {!! json_encode(old('content', $note->content) ?? '') !!},
                status: {!! json_encode(old('status', $note->getRawOriginal('status')) ?? '') !!},
                category_id: {!! json_encode(old('category_id', $note->category_id) ?? '') !!},

                originalTitle: {!! json_encode(old('title', $note->title) ?? '') !!},
                originalContent: {!! json_encode(old('content', $note->content) ?? '') !!},
                originalStatus: {!! json_encode(old('status', $note->getRawOriginal('status')) ?? '') !!},
                originalCategory_id: {!! json_encode(old('category_id', $note->category_id) ?? '') !!},

                aiSuggestion: '',
                isContentNoAny: false,
                isGenerating: false,

                noChanges() {
                    const isEqual = this.title === this.originalTitle &&
                        this.content === this.originalContent &&
                        this.status === this.originalStatus &&
                        this.category_id === this.originalCategory_id;

                    const isAny = !this.title.toString().trim() ||
                        !this.content.toString().trim() ||
                        !this.status.toString().trim();

                    return isEqual || isAny;
                },

                improveContent() {
                    const textInput = this.content;
                    if (!textInput || textInput.trim() === '') {
                        this.isContentNoAny = true;
                        return;
                    }
                    this.isContentNoAny = false;
                    this.aiSuggestion = '';
                    this.isGenerating = true;

                    axios.post('{{ route("ai.improve") }}', {
                        content: this.content
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => {
                        if (res.data && res.data.suggestion) {
                            this.aiSuggestion = res.data.suggestion;
                        } else {
                            alert('La IA no devolvió ninguna sugerencia.');
                        }
                    })
                    .catch(err => {
                        console.error('Error al generar sugerencia:', err);
                        alert('Hubo un error al generar la sugerencia. Inténtalo de nuevo.');
                    })
                    .finally(() => {
                        this.isGenerating = false;
                    });
                }
            }));
        });
    </script>
</x-layouts.dashboard>