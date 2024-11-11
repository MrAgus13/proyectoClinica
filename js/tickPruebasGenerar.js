// ticketManual.js (Generación manual de cajas con funcionalidad de guardar)
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
                <p>Asunto:</p>
                <input type="text" class="form-control" value="Asunto del comentario" id="comment-asunto">
            </div>
            <div class="infoPersonal mb-3">
                <p>Descripción de la incidencia:</p>
                <textarea class="form-control" id="comment-descripcion"></textarea>
            </div>
            <button class="btn btn-success" onclick="saveComment()">Guardar</button>
        `;

        commentBox.addEventListener("click", () => toggleBox(commentDetails));

        // Añadir la caja y los detalles en el contenedor principal
        const ticketInfo = document.getElementById("ticket-info");
        ticketInfo.appendChild(commentBox);
        ticketInfo.appendChild(commentDetails);
    }

    // Función para añadir una caja de fichero
    function addFileBox() {
        const fileBox = document.createElement("div");
        fileBox.classList.add("boxUnDes", "d-flex", "justify-content-between", "align-items-center", "mt-3");

        fileBox.innerHTML = `
            <p class="p-3 m-0">Un fichero ha sido agregado</p>
            <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
        `;
        
        const fileDetails = document.createElement("div");
        fileDetails.classList.add("boxDes", "p-3", "d-none");
        fileDetails.innerHTML = `
            <div class="infoPersonal mb-3">
                <p>Nombre del fichero:</p>
                <input type="file" class="form-control" value="Fichero de ejemplo" id="file-nombre">
            </div>
            <div class="infoPersonal mb-3">
                <p>Descripción del fichero:</p>
                <textarea class="form-control" id="file-descripcion"></textarea>
            </div>
            <button class="btn btn-success" onclick="saveFile()">Guardar</button>
        `;

        fileBox.addEventListener("click", () => toggleBox(fileDetails));

        // Añadir la caja y los detalles en el contenedor principal
        const ticketInfo = document.getElementById("ticket-info");
        ticketInfo.appendChild(fileBox);
        ticketInfo.appendChild(fileDetails);
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

    // Función para guardar los comentarios en el localStorage
   

    // Asignación de eventos a los botones para agregar cajas de comentario y fichero
    const addCommentBtn = document.getElementById("add-comment-btn");
    const addFileBtn = document.getElementById("add-file-btn");

    if (addCommentBtn) {
        addCommentBtn.addEventListener("click", addCommentBox);
    }

    if (addFileBtn) {
        addFileBtn.addEventListener("click", addFileBox);
    }
});
