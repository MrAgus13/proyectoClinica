let isVisible = false;

function desplegarBuscador() {
    const searchButton = document.getElementById('space-code');

    isVisible = !isVisible;

    searchButton.style.display = isVisible ? "block" : "none";
}


document.addEventListener('DOMContentLoaded', function() {
    const dotLottiePlayer = document.getElementById('icon');

    if (dotLottiePlayer) {
        dotLottiePlayer.addEventListener('click', function() {
            const codigo = document.getElementById("codigoIncidencia").value; 

            if (codigo) {
                window.location.href = 'ticket?id=' + encodeURIComponent(codigo);
            } else {
                alert('Por favor, introduce un código válido.');
            }
        });
    }
});

function validarNumero(event) {
    // Verifica si se presionó la tecla Enter
    if (event.key === 'Enter') {
        var numero = document.getElementById("codigoIncidencia").value;

        // Validar si el número tiene exactamente 8 dígitos
        if (/^\d{8}$/.test(numero)) {
            alert("Número válido. ¡Tique confirmado!");
           
        } else {
            alert("Por favor, ingresa un número de 8 dígitos.");
        }
    }
}
