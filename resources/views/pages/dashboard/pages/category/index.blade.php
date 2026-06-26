<x-layouts.dashboard title="Categorías">
    <div class="max-w-6xl mx-auto animate-fade-in">


        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Categorías</h2>
                <p class="mt-0.5 text-sm text-slate-500">Gestiona las categorías de tus notas.</p>
            </div>
            <a href="{{ route('categories.createPage') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-slate-800 active:scale-[0.98]">
                <x-heroicon-o-plus class="w-4 h-4" />
                Nueva Categoría
            </a>
        </div>


        <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-100 shadow-[var(--shadow-card)]">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Creada
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Actualizada
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @foreach ($categories as $category)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-slate-400 text-center">
                            #{{ $category->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800 text-center">
                            {{ Str::ucfirst($category->name) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($category->status == 'activo')
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                {{ Str::ucfirst($category->status) }}
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                {{ Str::ucfirst($category->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-slate-500">
                            {{ $category->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-slate-500">
                            {{ $category->updated_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('categories.editPage', $category->id) }}"
                                    class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-all duration-150">
                                    <x-heroicon-o-pencil-square class="w-3.5 h-3.5" />
                                    Editar
                                </a>

                                @if ($category->status == 'inactivo')
                                <form action='{{ route('categories.delete', $category->id) }}' method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex btn-delete items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 hover:text-red-700 cursor-pointer transition-all duration-150 btn-delete-category">
                                        <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                        Eliminar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            {{ $categories->links('vendor.pagination.tailwind') }}
        </div>

        @if(session('success'))
            <div id="alert-message" data-type="success" data-message="{{ json_encode(session('success')) }}"></div>
        @endif

        @if(session('error'))
            <div id="alert-message" data-type="error" data-message="{{ json_encode(session('error')) }}"></div>
        @endif

    </div>
</x-layouts.dashboard>