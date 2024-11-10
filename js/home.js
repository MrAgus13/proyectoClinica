let isVisible = false;

function desplegarBuscador() {
    const searchButton = document.getElementById('space-code');

    isVisible = !isVisible;

    searchButton.style.display = isVisible ? "flex" : "none";
}


document.addEventListener('DOMContentLoaded', function() {
    const dotLottiePlayer = document.getElementById('icon');

    if (dotLottiePlayer) {
        dotLottiePlayer.addEventListener('click', function() {
            window.location.href = 'ticket';
            /*          
              const code = document.getElementById('incidentCode').value;
                if (code) {
                    // Redirigir a una nueva página con el código como parámetro
                    window.location.href = 'ticket.html?code=' + encodeURIComponent(code);
                } else {
                    alert('Por favor, introduce un código válido.');
                }
            */
        });
    }
});