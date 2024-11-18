document.addEventListener("DOMContentLoaded", function() {
    // Elemento contenedor principal donde se agregarán las nuevas cajas
    const ticketInfo = document.getElementById("ticket-info");

    // Función para añadir la caja de información inicial
    function addInitialInfo() {
        // Crear contenedor para la información inicial
        const initialInfoBox = document.getElementById("infoBox");

        // Crear caja desplegable de información inicial con detalles (abierta por defecto)
        const initialInfoDetails = document.getElementById("infoDetails");

        // Añadir funcionalidad de mostrar/ocultar detalles
        initialInfoBox.addEventListener("click", () => toggleBox(initialInfoDetails));

        // Añadir al contenedor principal
        ticketInfo.appendChild(initialInfoBox);
        ticketInfo.appendChild(initialInfoDetails);
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
