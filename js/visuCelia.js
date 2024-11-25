function cerrarTiquet(ticketId) {
    Swal.fire({
        title: "Recordatorio",
        text: "¿Estás seguro de que deseas cerrar este tiquet?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#134189",
        confirmButtonText: "Enviar",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('php/cerrar_tiquet.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: ticketId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "¡Cerrado!",
                        text: "Su incidencia ha sido cerrada.",
                        icon: "success",
                        timer: 1000, 
                        didClose: () => {
                            window.location.href = window.location.href;
                        }
                    });
                } else {
                    alert("Error al cerrar el tiquet: " + data.error);
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "¡ERROR!",
                    text: "Su incidencia no ha podido cerrarse.",
                    icon: "error",
                    timer: 1000,
                });
            });
        }
    });
}

