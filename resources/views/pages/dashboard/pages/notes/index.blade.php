<x-layouts.dashboard title="Notas">
    <div class="max-w-6xl mx-auto animate-fade-in">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Notas</h2>
                <p class="mt-0.5 text-sm text-slate-500">Gestiona y visualiza todas tus notas creadas.</p>
            </div>
            <a href="{{ route('notes.createPage') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-slate-800 active:scale-[0.98]">
                <x-heroicon-o-plus class="w-4 h-4" />
                Nueva Nota
            </a>
        </div>

        @if($notes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($notes as $note)
            <div
                class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:shadow-xl hover:ring-indigo-100 hover:-translate-y-1">
                <div
                    class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-indigo-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div
                    class="absolute inset-0 bg-linear-to-b from-slate-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                </div>

                <div class="p-6 flex-1 flex flex-col z-10 relative">
                    <div class="flex justify-between items-start mb-5">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20 transition-colors group-hover:bg-indigo-100/80 group-hover:ring-indigo-600/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            {{ $note->category->name ?? 'Sin categoría' }}
                        </span>
                        <div class="flex items-center gap-1">
                            @if ($note->status == 'activo' || $note->status == 'active')
                            <span class="relative flex h-2.5 w-2.5" title="Activo">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            @else
                            <span class="flex h-2.5 w-2.5 rounded-full bg-red-500 shadow-sm" title="Inactivo"></span>
                            @endif
                        </div>
                    </div>

                    <h3
                        class="text-xl font-bold text-slate-800 mb-2.5 line-clamp-1 group-hover:text-indigo-600 transition-colors duration-300 tracking-tight">
                        {{ $note->title }}
                    </h3>

                    <p class="text-sm text-slate-600 line-clamp-3 mb-4 flex-1 leading-relaxed">
                        {{ $note->content }}
                    </p>
                </div>


                <div
                    class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between z-10 relative group-hover:bg-indigo-50/30 transition-colors duration-300">
                    <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                        <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                        {{ $note->created_at->format('d/m/Y') }}
                    </span>

                    <div
                        class="flex items-center gap-1 opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('notes.editPage', $note->id) }}"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-sm hover:ring-1 hover:ring-slate-200 transition-all duration-200"
                            title="Editar">
                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                        </a>

                        <form action="{{ route('notes.delete', $note->id) }}" method="POST" class="inline m-0 p-0 form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                            class="inline-flex cursor-pointer items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:bg-white hover:text-red-600 hover:shadow-sm hover:ring-1 hover:ring-slate-200 transition-all duration-200"
                            title="Eliminar">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-end">
            {{ $notes->links('vendor.pagination.tailwind') }}
        </div>
        @else

        <div
            class="flex flex-col items-center justify-center py-20 px-4 rounded-2xl bg-white border border-slate-200 border-dashed shadow-sm text-center">
            <div
                class="w-20 h-20 mb-6 rounded-full bg-indigo-50 flex items-center justify-center ring-8 ring-indigo-50/50">
                <x-heroicon-o-document-plus class="w-10 h-10 text-indigo-500" />
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2 tracking-tight">No hay notas creadas</h3>
            <p class="text-sm text-slate-500 mb-8 max-w-sm leading-relaxed">Aún no has creado ninguna nota. Comienza
                añadiendo tu primera nota para organizar tus ideas y tareas diarias.</p>
            <a href="{{ route('notes.createPage') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-medium text-white shadow-sm shadow-indigo-200 transition-all duration-200 hover:bg-indigo-700 hover:shadow hover:-translate-y-0.5 active:translate-y-0">
                <x-heroicon-o-plus class="w-5 h-5" />
                Crear mi primera nota
            </a>
        </div>
        @endif


        @if(session('success'))
            <div id="alert-message" data-type="success" data-message="{{ json_encode(session('success')) }}"></div>
        @endif

        @if(session('error'))
            <div id="alert-message" data-type="error" data-message="{{ json_encode(session('error')) }}"></div>
        @endif
    </div>
</x-layouts.dashboard>