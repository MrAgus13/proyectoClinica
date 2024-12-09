document.addEventListener("DOMContentLoaded", () => {
    // Función para añadir una caja de comentario
    function addCommentBox() {
        const commentBox = document.createElement("div");
        commentBox.classList.add("boxUnDes", "d-flex", "justify-content-between", "align-items-center", "mt-3");

        commentBox.innerHTML = `
            <p class="p-3 m-0">Un comentario ha sido agregado</p>
            <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
        `;
        
        const commentDetails = document.createElement("div");
        commentDetails.classList.add("boxDes", "p-3", "d-none");
        commentDetails.innerHTML = `
            <div class="infoPersonal mb-3">
                <p>Descripción de la incidencia:</p>
                <textarea class="form-control" id="comment-descripcion"></textarea>
            </div>
             <div class="infoPersonal mb-3">
                <p>Nombre del fichero:</p>
                <input type="file" class="form-control" value="Fichero de ejemplo" id="file-nombre">
            </div>
            <button class="btn btn-success">Guardar</button>
        `;

        // Añadir la caja y los detalles al contenedor
        const ticketInfo = document.getElementById("ticket-info");
        ticketInfo.appendChild(commentBox);
        ticketInfo.appendChild(commentDetails);

        // Asignar el evento de "Guardar" a cada botón "Guardar"
        const saveButton = commentDetails.querySelector("button");
        saveButton.addEventListener("click", () => {
            const comentario = commentDetails.querySelector('#comment-descripcion').value;
            const archivo = commentDetails.querySelector('#file-nombre').files[0];
            saveComment(comentario, archivo);
        });
    }

    // Función para manejar la apertura y cierre de las cajas
    function toggleBox(detailsElement) {
        const allBoxes = document.querySelectorAll(".boxDes");
        allBoxes.forEach(box => {
            if (box !== detailsElement) {
                box.classList.add("d-none");
            }
        });
        detailsElement.classList.toggle("d-none");
    }

    // Delegación de eventos: asignamos el evento de clic al contenedor principal
    const ticketInfo = document.getElementById("ticket-info");

    if (ticketInfo) {
        ticketInfo.addEventListener("click", (event) => {
            // Verificar si el clic fue en una de las cajas de comentarios
            const boxElement = event.target.closest(".boxUnDes");
            if (boxElement) {
                const detailsElement = boxElement.nextElementSibling;
                if (detailsElement && detailsElement.classList.contains("boxDes")) {
                    toggleBox(detailsElement);
                }
            }
        });
    }

    // Asignación de eventos a los botones para agregar cajas de comentario
    const addCommentBtn = document.getElementById("add-comment-btn");

    if (addCommentBtn) {
        addCommentBtn.addEventListener("click", addCommentBox);
    }
});
