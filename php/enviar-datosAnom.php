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
    $fecha = $_POST['fecha'];              // Recoger la fecha del evento
    $localizacion = $_POST['localizacion']; // Recoger la localización
    $asunto = $_POST['asunto'];            // Recoger el asunto
    $descripcion = $_POST['descripcion'];  // Recoger la descripción
    $codigoIncidencia = $_POST['codigoIncidencia']; // Recoger el código de incidencia

    // Validación de los datos recibidos (opcional, pero recomendable)
    if (empty($fecha) || empty($localizacion) || empty($asunto) || empty($descripcion)) {
        echo "Por favor, complete todos los campos requeridos.";
        exit;
    }

    // Inicializar la variable para el nombre del archivo
    $nombreArchivo = null;

    // Manejo del archivo subido (si hay archivo)
    if (isset($_FILES['fichero']) && $_FILES['fichero']['error'] == 0) {
        // Carpeta donde se guardarán los archivos (asegúrate de crearla y darle permisos de escritura)
        $directorioDestino = "uploads/";  // Debes tener esta carpeta creada
        $nombreArchivo = $directorioDestino . basename($_FILES['fichero']['name']);
        
        // Mover el archivo desde la ubicación temporal al destino
        if (move_uploaded_file($_FILES['fichero']['tmp_name'], $nombreArchivo)) {
            echo "Archivo cargado correctamente.";
        } else {
            echo "Error al cargar el archivo.";
        }
    }

    // Generar un ID de ticket aleatorio
    $idTicket = rand(10000000, 99999999);

    // Preparar la consulta SQL para insertar el ticket
    $stmt = $conn->prepare("INSERT INTO TICKETS (ID_TICKET, FECHA_HECHO, LUGAR, ASUNTO, DESCRIPCION, ID_USUARIO) VALUES (?, ?, ?, ?,?, ?)");

    $usuario = 1;
    // Vincular los parámetros
    $stmt->bind_param("issssi", $idTicket, $fecha, $localizacion, $asunto, $descripcion, $usuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header('Location: ../codTicket?id=' . $idTicket);
    } else {
        echo "Error al insertar ticket: " . $stmt->error;
        // Generar un ID de ticket aleatorio
        $idTicket = rand(10000000, 99999999);

        // Preparar la consulta SQL para insertar el ticket
        $stmt = $conn->prepare("INSERT INTO TICKETS (ID_TICKET, FECHA_HECHO, LUGAR, ASUNTO, DESCRIPCION, ID_USUARIO) VALUES (?, ?, ?, ?, ?,?)");

        // Vincular los parámetros
        $stmt->bind_param("issssi", $idTicket, $fecha, $localizacion, $asunto, $descripcion, $usuario);
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
