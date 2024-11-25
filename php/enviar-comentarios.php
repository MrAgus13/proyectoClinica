<?php
session_start();

// Verificar si 'id' está presente en la URL
if (isset($_GET['id'])) {
    // Obtener el valor de 'ticket' desde la URL
    $ticket_id = $_GET['id'];
}

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
    $comentario = $_POST['comentario']; // Recoger el comentario

    // Validación de los datos recibidos
    if (empty($comentario)) {
        header('Location: ../visuCelia?id='.$ticket_id.'&error=1');
        exit();
    }

    // Inicializar la variable para el nombre del archivo
    $nombreArchivo = null;

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
        if (move_uploaded_file($_FILES['fichero']['tmp_name'], $rutaArchivo)) {
            // Insertar el comentario en la tabla ADMIN_TICKETS
            $stmt = $conn->prepare("INSERT INTO ADMIN_TICKETS (ID_ADMIN, COMENTARIOS) VALUES (?, ?)");
            $usuario = 1;  // Ejemplo: asumiendo que el ID de usuario es 1 (esto puede cambiar según tu lógica)
            $stmt->bind_param("is", $usuario, $comentario);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID del ticket insertado
                $idAdTicket = $stmt->insert_id;

                // Insertar el archivo en la tabla ARCHIVOS
                if ($nombreArchivo) {
                    $stmt = $conn->prepare("INSERT INTO ARCHIVOS (NOMBRE_ARCHIVO, RUTA_ARCHIVO, ID_ADTICK) VALUES (?, ?, ?)");
                    $stmt->bind_param("ssi", $nombreArchivo, $rutaArchivo, $idAdTicket);

                    if ($stmt->execute()) {
                        echo "Archivo asociado al ticket correctamente.";
                    } else {
                        echo "Error al asociar el archivo al ticket: " . $stmt->error;
                    }
                    $stmt->close();
                }

                // Redirigir a la página del ticket con el ID
                header('Location: ../visuCelia?id=' . $ticket_id);
                exit();
            } else {
                echo "Error al insertar ticket: " . $stmt->error;
            }

            // Cerrar la declaración preparada
            $stmt->close();
        } else {
            echo "Error al cargar el archivo.";
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
