<x-layouts.dashboard title="Usuarios">
    <div class="max-w-6xl mx-auto animate-fade-in">

        <div class="mb-8">
            <h2 class="text-xl font-semibold text-slate-800 tracking-tight">Usuarios</h2>
            <p class="mt-0.5 text-sm text-slate-500">Administra los usuarios de la plataforma.</p>
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
                            Email
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Creado
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Actualizado
                        </th>
                        <th
                            class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @foreach ($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-slate-400 text-center">
                            #{{ $user->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-medium text-slate-600 ring-1 ring-slate-200 flex-shrink-0">
                                    {{ mb_strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-slate-800">{{ Str::ucfirst($user->name) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                            {{ $user->updated_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('user.editPage', $user->id) }}"
                                    class="inline-flex cursor-pointer items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-all duration-150">
                                    <x-heroicon-o-pencil-square class="w-3.5 h-3.5" />
                                    Editar
                                </a>

                                <form action='{{ route('user.delete', $user->id) }}' method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 hover:text-red-700 cursor-pointer transition-all duration-150 btn-delete-category">
                                        <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>


        @if(session('success'))
        <div id="alert-message" data-type="success" data-message="{{ json_encode(session('success')) }}"></div>
        @endif

        @if(session('error'))
        <div id="alert-message" data-type="error" data-message="{{ json_encode(session('error')) }}"></div>
        @endif

    </div>

</x-layouts.dashboard>