
export const ComfirmAlert = () => {
    document.querySelectorAll('.form-delete').forEach(FormConfirm => {
        FormConfirm.addEventListener('click', (e) => {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#020617',
                color: '#f8fafc',
                iconColor: '#f59e0b',
                confirmButtonColor: '#1d4ed8',
                cancelButtonColor: '#dc2626',
                customClass: {
                    popup: 'rounded-2xl border border-slate-800 shadow-2xl',
                    title: 'text-xl font-bold tracking-tight',
                    htmlContainer: 'text-slate-400 text-sm',
                    confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-medium transition-transform active:scale-95',
                    cancelButton: 'rounded-xl px-5 py-2.5 text-sm font-medium transition-transform active:scale-95'
                },
                buttonsStyling: true
            }).then((res) => {
                if (res.isConfirmed) {
                    FormConfirm.submit();
                }
            });
        })
    })
}


export const CustomAlert = () => {

    const identifierContent = document.getElementById('alert-message')

    if (!identifierContent) return

    const type = identifierContent.dataset.type
    const message = JSON.parse(identifierContent.dataset.message)

    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        theme: 'dark',
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    }).fire({
        icon: type,
        title: message
    });

}


