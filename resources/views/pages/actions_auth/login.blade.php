<x-layouts.minimal title="Iniciar Sesión">
    <div class="min-h-screen flex">

        <div class="hidden lg:flex lg:w-1/2 w-full relative justify-center items-center login_img_section overflow-hidden">
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>

            <div class="relative z-10 w-full max-w-lg px-12 space-y-5 text-white animate-slide-up">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex w-10 h-10 items-center justify-center rounded-xl bg-white/10 backdrop-blur-sm">
                        <svg width="20" height="20" viewBox="0 0 14 14" fill="currentColor" class="text-white/90">
                            <rect x="1" y="1" width="5" height="5" rx="1.5" />
                            <rect x="8" y="1" width="5" height="5" rx="1.5" />
                            <rect x="1" y="8" width="5" height="5" rx="1.5" />
                            <rect x="8" y="8" width="5" height="5" rx="1.5" opacity="0.4" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-bold tracking-tight">NoteAI</h1>
                <p class="text-base text-slate-300 leading-relaxed max-w-sm">
                    Plataforma inteligente para organizar tus notas con el poder de la inteligencia artificial.
                </p>
                <div class="flex gap-6 pt-4 text-sm text-slate-400">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                        Seguro
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                        Rápido
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                        Inteligente
                    </div>
                </div>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 items-center justify-center bg-slate-50 px-6 py-8">
            <div class="w-full max-w-md animate-fade-in">
                <div class="rounded-2xl bg-white p-8 shadow-[var(--shadow-elevated)] ring-1 ring-slate-100">
                    <div class="text-center">
                        <h2 class="text-2xl font-semibold text-slate-800 tracking-tight">Bienvenido de vuelta</h2>
                        <p class="mt-1.5 text-sm text-slate-500">Ingresa tus credenciales para continuar</p>
                    </div>

                    <div class="my-6 h-px w-full bg-slate-100"></div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                            <div class="relative">
                                <x-heroicon-o-at-symbol
                                    class="absolute left-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-400" />
                                <input
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                                    placeholder="tu@email.com" name="email" type="email" />
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Contraseña</label>
                            <div class="relative">
                                <x-heroicon-o-lock-closed
                                    class="absolute left-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-400" />
                                <input
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                                    placeholder="••••••••" name="password" type="password" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember" class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-slate-300 text-slate-800 focus:ring-slate-500"/>
                                Recuérdame
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors duration-200">¿Olvidaste tu contraseña?</a>
                        </div>

                        <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-2.5 text-sm font-medium text-white cursor-pointer transition-all duration-200 hover:bg-slate-800 active:scale-[0.98] shadow-sm">
                            <x-heroicon-o-arrow-left-start-on-rectangle class="h-[18px] w-[18px]" />
                            Iniciar sesión
                        </button>

                        <div class="relative my-6">
                            <div class="h-px w-full bg-slate-100"></div>
                            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 text-xs text-slate-400 uppercase tracking-wider">
                                o
                            </span>
                        </div>

                        <a href="{{ route('redirect') }}"
                            class="flex w-full items-center justify-center gap-2.5 rounded-xl border border-slate-200 bg-white py-2.5 text-sm font-medium text-slate-700 transition-all duration-200 hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98]">
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Continuar con Google
                        </a>

                        <p class="text-center text-sm text-slate-500">
                            ¿No tienes cuenta?
                            <a href="{{ route('signUpPage') }}" class="font-medium text-slate-700 hover:text-slate-900 transition-colors duration-200">
                                Crear cuenta
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div id="alert-message" data-type="success" data-message="{{ json_encode(session('success')) }}"></div>
        @endif

        @if(session('error'))
        <div id="alert-message" data-type="error" data-message="{{ json_encode(session('error')) }}"></div>
        @endif

    </div>

</x-layouts.minimal>
