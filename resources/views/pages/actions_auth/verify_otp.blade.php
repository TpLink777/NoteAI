<x-layouts.minimal title="Verificar Email">
    <div class="relative flex min-h-screen flex-col items-center justify-center bg-slate-50 py-12 px-4">
        <div class="w-full max-w-sm animate-slide-up">
            <x-auth.otp-form 
                :email="session('pending_user.email')" 
                :action="route('otp.verify')"
                :resendAction="route('resendOtp')"
                buttonText="Verificar cuenta"
            />
        </div>
    </div>
</x-layouts.minimal>
