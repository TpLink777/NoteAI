<x-layouts.minimal title="Recuperar Contraseña">
    <div class="min-h-screen flex flex-col items-center justify-center bg-slate-50 px-4">

        <div class="w-full max-w-md animate-slide-up">

            <div class="flex items-center justify-center gap-2.5 mb-8">
                <div class="flex w-9 h-9 items-center justify-center rounded-xl bg-slate-900">
                    <svg width="18" height="18" viewBox="0 0 14 14" fill="currentColor" class="text-white">
                        <rect x="1" y="1" width="5" height="5" rx="1.5" />
                        <rect x="8" y="1" width="5" height="5" rx="1.5" />
                        <rect x="1" y="8" width="5" height="5" rx="1.5" />
                        <rect x="8" y="8" width="5" height="5" rx="1.5" opacity="0.4" />
                    </svg>
                </div>
                <span class="text-xl font-semibold text-slate-800 tracking-tight">NoteAI</span>
            </div>


            <div class="rounded-2xl bg-white p-8 shadow-[var(--shadow-elevated)] ring-1 ring-slate-100">
                <div class="text-center">
                    <h1 class="text-2xl font-semibold text-slate-800 tracking-tight">Ingresa tu correo para cambiar tu contraseña</h1>
                    <p class="mt-1.5 text-sm text-slate-500">Te enviaremos un codigo a tu correo para verificarlo</p>
                </div>

                <form action="{{ route('forgotPassword')  }}" method="POST" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <div class="relative">
                            <x-heroicon-o-at-symbol
                                class="absolute left-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-400" />
                            <input id="email" type="email" name="email"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                                placeholder="tu@email.com" required />
                        </div>
                        @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-2.5 text-sm font-medium text-white cursor-pointer transition-all duration-200 hover:bg-slate-800 active:scale-[0.98] shadow-sm">
                        <span class="uppercase tracking-wide">Siguiente</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </button>
                </form>
            </div>


            <p class="mt-6 text-center text-sm text-slate-500">
                <a href="{{ route('loginPage') }}"
                    class="font-medium text-slate-700 hover:text-slate-900 transition-colors duration-200">
                    Volver al inicio de sesión
                </a>
            </p>
        </div>

        @if(session('success'))
        <div id="alert-message" data-type="success" data-message="{{ json_encode(session('success')) }}"></div>
        @endif

        @if(session('error'))
        <div id="alert-message" data-type="error" data-message="{{ json_encode(session('error')) }}"></div>
        @endif

    </div>
</x-layouts.minimal>