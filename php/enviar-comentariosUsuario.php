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
    // Recoger los datos del formulario
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : ''; 
    $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : ''; 
    $comentario = htmlspecialchars(trim($comentario), ENT_QUOTES, 'UTF-8'); 

    // Validación de los datos recibidos
    if (empty($comentario)) {
        header('Location: ../ticket?id=' . $ticket_id . '&error=1');
        exit();
    }

    // Inicializar la variable para el nombre del archivo
    $nombreArchivo = null;

    // Si hay archivo, se gestiona
    if (isset($_FILES['fichero']) && $_FILES['fichero']['error'] == 0) {
        // Carpeta donde se guardarán los archivos
        $directorioDestino = "../uploads/";
        $nombreArchivo = basename($_FILES['fichero']['name']);
        $rutaArchivo = $directorioDestino . $nombreArchivo;

        // Verificar que el directorio de destino existe y tiene permisos de escritura
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);  
        }

        // Mover el archivo desde la ubicación temporal al destino
        if (!move_uploaded_file($_FILES['fichero']['tmp_name'], $rutaArchivo)) {
            echo "Error al cargar el archivo.";
            exit();
        }
    }

    // Insertar el comentario en la tabla USER_TICKETS
    $stmt = $conn->prepare("SELECT ID_USUARIO FROM TICKETS WHERE ID_TICKET = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
        $usuario = $ticket['ID_USUARIO'];
    
    } 

    $stmt = $conn->prepare("INSERT INTO USER_TICKETS (ID_USER, COMENTARIOS,ID_TICKET) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $usuario, $comentario,$ticket_id);

    // Ejecutar la consulta para insertar el comentario
    if (!$stmt->execute()) {
        echo "Error al insertar comentario: " . $stmt->error;
        $stmt->close();
        exit();
    }

    // Obtener el ID del ticket insertado
    $idAdTicket = $stmt->insert_id;
    $stmt->close();

    // Si hubo archivo, asociarlo al comentario
    if ($nombreArchivo) {
        $stmt = $conn->prepare("INSERT INTO ARCHIVOS (NOMBRE_ARCHIVO, RUTA_ARCHIVO, ID_USTICK) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nombreArchivo, $rutaArchivo, $idAdTicket);

        if (!$stmt->execute()) {
            echo "Error al asociar el archivo al ticket: " . $stmt->error;
        }
        $stmt->close();
    }

    // Redirigir a la página del ticket con el ID
    header('Location: ../ticket?id=' . $ticket_id);
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
