@props([
    'email', 
    'action', 
    'resendAction', 
    'buttonText' => 'Verificar código', 
    'title' => 'Verifica tu email', 
    'description' => 'Ingresa el código de 6 dígitos enviado a'
])


<div class="rounded-2xl bg-white p-8 shadow-[var(--shadow-elevated)] ring-1 ring-slate-100">
    <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
        <x-heroicon-o-shield-check class="w-7 h-7 text-slate-600" />
    </div>

    <h1 class="text-center text-xl font-semibold text-slate-800 tracking-tight">
        {{ $title }}
    </h1>
    <p class="mt-1.5 text-center text-sm text-slate-500">
        {{ $description }}
        <span class="font-medium text-slate-700">{{ $email }}</span>
    </p>

    <form action="{{ $action }}" method="POST" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="code"
                class="block text-xs font-medium uppercase tracking-widest text-slate-400 mb-2">
                Código de verificación
            </label>
            <input id="code" type="text" name="code" inputmode="numeric" autocomplete="one-time-code"
                maxlength="6" placeholder="· · · · · ·"
                class="w-full h-14 rounded-xl border border-slate-200 bg-slate-50 text-center font-mono text-2xl tracking-[0.3em] text-slate-800 placeholder-slate-300 transition-all duration-200 focus:border-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-slate-200
            @error('code') border-red-300 ring-1 ring-red-200 @enderror">
            @error('code')
                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="flex w-full items-center cursor-pointer justify-center gap-2 rounded-xl bg-slate-900 py-3.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-slate-800 active:scale-[0.98]">
            <x-heroicon-o-shield-check class="w-[18px] h-[18px]" />
            {{ $buttonText }}
        </button>
    </form>

    <div class="mt-6 flex items-center gap-2 justify-center">
        <p class="text-sm text-slate-400">
            ¿No recibiste el código?
        </p>
        <form action="{{ $resendAction }}" method="POST">
            @csrf
            <button type="submit" class="font-medium text-sm text-slate-700 hover:text-slate-900 hover:underline cursor-pointer transition-colors duration-200">
                Reenviar
            </button>
        </form>
    </div>
</div>
