document.addEventListener("DOMContentLoaded", function () {
    // Elemento contenedor principal donde se agregarán las nuevas cajas
    const ticketInfo = document.getElementById("ticket-info");

    //Mostrar/ocultar detalles para cada caja
    function toggleBox(detailsElement) {
        // Cerramos todas las cajas antes de abrir la seleccionada
        const allBoxes = document.querySelectorAll(".boxDes");
        allBoxes.forEach(box => {
            if (box !== detailsElement) {
                box.classList.add("d-none"); // Cerramos las cajas que no fueron seleccionadas
            }
        });

        // Alternamos la visibilidad de la caja seleccionada
        detailsElement.classList.toggle("d-none");
    }

    // Asignar evento de clic a todas las cajas existentes
    function initializeToggleEvents() {
        const toggleElements = document.querySelectorAll(".infoBox");
        toggleElements.forEach(toggleElement => {
            const detailsElement = toggleElement.nextElementSibling; // Caja de detalles asociada
            toggleElement.addEventListener("click", () => toggleBox(detailsElement));
        });
    }

    // Inicializar la funcionalidad de plegar/desplegar al cargar la página
    initializeToggleEvents();
});
