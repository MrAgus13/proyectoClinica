document.addEventListener("DOMContentLoaded", function() {
    // Función para obtener los datos del archivo JSON
    function fetchData() {
        fetch('data.json')  // Ruta al archivo JSON que contiene los datos
            .then(response => response.json())
            .then(data => {
                // Solo agregamos la información inicial una vez
                addInitialInfo(data.initialInfo);
                
                // Generar todos los comentarios y ficheros
                data.comments.forEach(comment => addCommentBox(comment));
                data.files.forEach(file => addFileBox(file));
            })
            .catch(error => console.error("Error al cargar los datos:", error));
    }

    // Elemento contenedor principal donde se agregarán las nuevas cajas
    const ticketInfo = document.getElementById("ticket-info");

    // Función para añadir la caja de información inicial
    function addInitialInfo(info) {
        // Crear contenedor para la información inicial
        const initialInfoBox = document.createElement("div");
        initialInfoBox.classList.add("boxUnDes", "d-flex", "justify-content-between", "align-items-center", "mt-3");

        // Título de la caja y icono de despliegue
        initialInfoBox.innerHTML = `
            <p class="p-3 m-0">Información inicial del ticket</p>
            <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
        `;
        
        // Crear caja desplegable de información inicial con detalles (abierta por defecto)
        const initialInfoDetails = document.createElement("div");
        initialInfoDetails.classList.add("boxDes", "p-3");  // Se elimina 'd-none' para que esté abierta
        initialInfoDetails.innerHTML = `
            <div class="d-flex justify-content-between mb-3">
                <div class="infoPersonal" style="width: 48%;"> <!-- Se ajusta a la mitad del ancho -->
                    <p>Fecha de la incidencia:</p>
                    <input type="text" class="form-control" value="${info.date}" readonly>
                </div>
                <div class="infoPersonal" style="width: 48%;"> <!-- Se ajusta a la mitad del ancho -->
                    <p>Localización | Área clínica:</p>
                    <input type="text" class="form-control" value="${info.location} | ${info.area}" readonly>
                </div>
            </div>
            <div class="infoPersonal mb-3">
                <p>Asunto:</p>
                <input type="text" class="form-control" value="${info.subject}" readonly>
            </div>
            <div class="infoPersonal mb-3">
                <p>Descripción de la incidencia:</p>
                <textarea class="form-control" readonly>${info.description}</textarea>
            </div>
        `;

        // Añadir funcionalidad de mostrar/ocultar detalles
        initialInfoBox.addEventListener("click", () => toggleBox(initialInfoDetails));

        // Añadir al contenedor principal
        ticketInfo.appendChild(initialInfoBox);
        ticketInfo.appendChild(initialInfoDetails);
    }

    // Función para añadir una caja de comentario
    function addCommentBox(commentData) {
        // Crear contenedor de comentario
        const commentBox = document.createElement("div");
        commentBox.classList.add("boxUnDes", "d-flex", "justify-content-between", "align-items-center", "mt-3");

        // Título de la caja y icono de despliegue
        commentBox.innerHTML = `
            <p class="p-3 m-0">Un comentario ha sido agregado</p>
            <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
        `;
        
        // Crear caja desplegable de comentario con detalles
        const commentDetails = document.createElement("div");
        commentDetails.classList.add("boxDes", "p-3", "d-none");
        commentDetails.innerHTML = `
            <div class="infoPersonal mb-3">
                <p>Asunto:</p>
                <input type="text" class="form-control" value="${commentData.subject}" readonly>
            </div>
            <div class="infoPersonal mb-3">
                <p>Descripción de la incidencia:</p>
                <textarea class="form-control" readonly>${commentData.description}</textarea>
            </div>
        `;

        // Añadir funcionalidad de mostrar/ocultar detalles
        commentBox.addEventListener("click", () => toggleBox(commentDetails));

        // Añadir al contenedor principal
        ticketInfo.appendChild(commentBox);
        ticketInfo.appendChild(commentDetails);
    }

    // Función para añadir una caja de fichero
    function addFileBox(fileData) {
        // Crear contenedor de fichero
        const fileBox = document.createElement("div");
        fileBox.classList.add("boxUnDes", "d-flex", "justify-content-between", "align-items-center", "mt-3");

        // Título de la caja y icono de despliegue
        fileBox.innerHTML = `
            <p class="p-3 m-0">Un fichero ha sido agregado</p>
            <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
        `;
        
        // Crear caja desplegable de fichero con detalles
        const fileDetails = document.createElement("div");
        fileDetails.classList.add("boxDes", "p-3", "d-none");
        fileDetails.innerHTML = `
            <div class="infoPersonal mb-3">
                <p>Nombre del fichero:</p>
                <input type="text" class="form-control" value="${fileData.fileName}" readonly>
            </div>
            <div class="infoPersonal mb-3">
                <p>Descripción del fichero:</p>
                <textarea class="form-control" readonly>${fileData.fileDescription}</textarea>
            </div>
        `;

        // Añadir funcionalidad de mostrar/ocultar detalles
        fileBox.addEventListener("click", () => toggleBox(fileDetails));

        // Añadir al contenedor principal
        ticketInfo.appendChild(fileBox);
        ticketInfo.appendChild(fileDetails);
    }

    // Función para controlar la apertura y cierre de las cajas
    function toggleBox(detailsElement) {
        // Cerramos todas las cajas antes de abrir la seleccionada
        const allBoxes = document.querySelectorAll(".boxDes");
        allBoxes.forEach(box => {
            if (box !== detailsElement) {
                box.classList.add("d-none"); 
                 // Cerramos las cajas que no fueron seleccionadas
            }
        });
        // Alternamos la visibilidad de la caja seleccionada
        detailsElement.classList.toggle("d-none");
    }

    // Cargar los datos al inicio
    fetchData();
});

function saveComment() {
    const asunto = document.getElementById("comment-asunto").value;
    const descripcion = document.getElementById("comment-descripcion").value;

    // Crear objeto de comentario
    const commentData = {
        tipo: 'comentario',
        asunto: asunto,
        descripcion: descripcion,
    };

    // Guardar en el localStorage (simulando guardado en JSON)
    let savedComments = JSON.parse(localStorage.getItem("comments")) || [];
    savedComments.push(commentData);
    localStorage.setItem("comments", JSON.stringify(savedComments));

    alert("Comentario guardado con éxito.");
}

// Función para guardar los ficheros en el localStorage
function saveFile() {
    const nombre = document.getElementById("file-nombre").value;
    const descripcion = document.getElementById("file-descripcion").value;

    // Crear objeto de fichero
    const fileData = {
        tipo: 'fichero',
        nombre: nombre,
        descripcion: descripcion,
    };

    // Guardar en el localStorage (simulando guardado en JSON)
    let savedFiles = JSON.parse(localStorage.getItem("files")) || [];
    savedFiles.push(fileData);
    localStorage.setItem("files", JSON.stringify(savedFiles));

    alert("Fichero guardado con éxito.");
}   


// Para cargar los datos desde el localStorage y mostrarlos
function loadData() {
    const savedComments = JSON.parse(localStorage.getItem("comments")) || [];
    const savedFiles = JSON.parse(localStorage.getItem("files")) || [];

    savedComments.forEach(comment => {
        // Aquí puedes renderizar las cajas de comentarios de manera similar a como se hacen los nuevos
        console.log(comment);
    });

    savedFiles.forEach(file => {
        // Aquí puedes renderizar las cajas de ficheros de manera similar
        console.log(file);
    });
}

loadData(); // Llamamos a la función para cargar los datos al iniciar la página
