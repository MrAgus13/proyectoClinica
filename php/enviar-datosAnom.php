<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $fecha = $_POST['fecha'];              
    $localizacion = $_POST['localizacion']; 
    $asunto = $_POST['asunto'];            
    $descripcion = $_POST['descripcion']; 
    $codigoIncidencia = $_POST['codigoIncidencia']; 

    // Validación de los datos recibidos
    if (empty($fecha) || empty($localizacion) || empty($asunto) || empty($descripcion)) {
        header('Location: ../formulario?error=1');
        exit();
    }

    // Inicializar la variable para el nombre del archivo
    $nombreArchivo = null;

    $idTicket = rand(10000000, 99999999);
    $directorioDestino = "../uploads/"; 
    $rutaArchivo = $directorioDestino . $nombreArchivo;

    // Preparar la consulta SQL para insertar el ticket
    $stmt = $conn->prepare("INSERT INTO TICKETS (ID_TICKET, FECHA_HECHO, LUGAR, ASUNTO, DESCRIPCION, ID_USUARIO) VALUES (?, ?, ?, ?, ?, ?)");

    $usuario = 1;  
    // Vincular los parámetros
    $stmt->bind_param("issssi", $idTicket, $fecha, $localizacion, $asunto, $descripcion, $usuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Manejo del archivo subido (si hay archivo)
        if (isset($_FILES['fichero']) && $_FILES['fichero']['error'] == 0) {
            // Carpeta donde se guardarán los archivos
            $directorioDestino = "../uploads/";  
            $nombreArchivo = basename($_FILES['fichero']['name']);
            $rutaArchivo = $directorioDestino . $nombreArchivo;
            
            // Mover el archivo desde la ubicación temporal al destino
            if (move_uploaded_file($_FILES['fichero']['tmp_name'], $rutaArchivo)) {
                // Si el archivo se carga correctamente, insertar el archivo en la tabla ARCHIVOS
                if ($nombreArchivo) {
                    $stmt = $conn->prepare("INSERT INTO ARCHIVOS (NOMBRE_ARCHIVO, RUTA_ARCHIVO, ID_TICKET) VALUES (?, ?, ?)");
                    $stmt->bind_param("ssi", $nombreArchivo, $rutaArchivo, $idTicket);

                    if ($stmt->execute()) {
                        echo "Archivo asociado al ticket correctamente.";
                    } else {
                        echo "Error al asociar el archivo al ticket: " . $stmt->error;
                    }
                    $stmt->close();
                }
            } else {
                echo "Error al cargar el archivo.";
            }
        }

        // Redirigir a la página del ticket con el ID
        header('Location: ../codTicket?id=' . $idTicket);
    } else {
        echo "Error al insertar ticket: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
    