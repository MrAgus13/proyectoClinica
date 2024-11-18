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
