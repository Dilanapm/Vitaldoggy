<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Función específica para confirmar cambio de estado de usuario
    window.confirmUserStatusToggle = function(userId, userName, currentStatus) {
        const action = currentStatus ? 'desactivar' : 'activar';
        const statusText = currentStatus ? 'desactivado' : 'activado';
        const buttonColor = currentStatus ? '#dc2626' : '#16a34a';
        
        return Swal.fire({
            title: `¿${action.charAt(0).toUpperCase() + action.slice(1)} usuario?`,
            html: `¿Estás seguro de que quieres <strong>${action}</strong> a <br><em>${userName}</em>?<br><br>El usuario será <strong>${statusText}</strong>.`,
            icon: currentStatus ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: buttonColor,
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Sí, ${action}`,
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                popup: 'dark:bg-gray-800 dark:text-white',
                title: 'dark:text-white',
                htmlContainer: 'dark:text-gray-300',
                confirmButton: 'font-semibold px-6 py-3 rounded-lg',
                cancelButton: 'font-semibold px-6 py-3 rounded-lg'
            }
        });
    };

    // Función para mostrar toasts de éxito/error
    window.showToast = function(type, title, message) {
        Swal.fire({
            icon: type,
            title: title,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'dark:bg-gray-800 dark:text-white'
            }
        });
    };
</script>
