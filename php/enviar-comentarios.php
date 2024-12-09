<?php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "alumne";
$password = "alumne";
$dbname = "clinica";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger el comentario y ticket_id
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : ''; 
    $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : ''; 
    $comentario = htmlspecialchars(trim($comentario), ENT_QUOTES, 'UTF-8'); // Sanitizar el comentario

    // Validación del comentario
    if (empty($comentario)) {
        // Redirigir con un error si el comentario está vacío
        header('Location: ../visuCelia?id=' . $ticket_id . '&error=1');
        exit();
    }

    // Inicializar variables para el archivo
    $nombreArchivo = null;
    $rutaArchivo = null;

    // Manejo del archivo subido (si hay archivo)
    if (isset($_FILES['fichero']) && $_FILES['fichero']['error'] == 0) {
        // Carpeta donde se guardarán los archivos
        $directorioDestino = "../uploads/";
        $nombreArchivo = basename($_FILES['fichero']['name']);
        $rutaArchivo = $directorioDestino . $nombreArchivo;

        // Verificar que el directorio de destino existe y tiene permisos de escritura
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);  // Crear el directorio si no existe
        }

        // Mover el archivo desde la ubicación temporal al destino
        if (!move_uploaded_file($_FILES['fichero']['tmp_name'], $rutaArchivo)) {
            // Si hay un error al cargar el archivo
            echo "Error al cargar el archivo.";
            exit();
        }
    }

    // Insertar el comentario en la tabla ADMIN_TICKETS
    $stmt = $conn->prepare("INSERT INTO ADMIN_TICKETS (ID_ADMIN, COMENTARIOS, ID_TICKET) VALUES (?, ?, ?)");
    $usuario = 1;  // Asumiendo que el ID de usuario es 1 (esto puede cambiar según tu lógica)
    $stmt->bind_param("isi", $usuario, $comentario, $ticket_id);  // Asocia el comentario con el ticket

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el ID del comentario insertado
        $idAdTicket = $stmt->insert_id;

        // Si se ha subido un archivo, insertarlo en la tabla ARCHIVOS
        if ($nombreArchivo && $rutaArchivo) {
            $stmt = $conn->prepare("INSERT INTO ARCHIVOS (NOMBRE_ARCHIVO, RUTA_ARCHIVO, ID_ADTICK) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $nombreArchivo, $rutaArchivo, $idAdTicket); // Asociar archivo al ticket

            if (!$stmt->execute()) {
                echo "Error al asociar el archivo al ticket: " . $stmt->error;
            }
            $stmt->close();
        }

        // Redirigir a la página del ticket con el ID
        header('Location: ../visuCelia?id=' . $ticket_id);
        exit();
    } else {
        echo "Error al insertar comentario: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
