<?php
session_start();

// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "alumne";
$password = "alumne";
$dbname = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se han enviado datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar los datos JSON enviados
    $datos = json_decode(file_get_contents('php://input'), true);

    if (!empty($datos)) {
        // Preparar la consulta SQL para inserción múltiple
        $stmt = $conn->prepare("INSERT INTO  () VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Vincular parámetros y ejecutar la consulta para cada conjunto de datos
        foreach ($datos as $dato) {
            $stmt->bind_param("sssdiis", $dato[''], $dato[''], $dato[''], $dato[''], $dato[''], $dato[''], $_SESSION['']);
            $stmt->execute();
        }

        // Cerrar la declaración preparada después de completar la inserción
        $stmt->close();

        // Imprimir mensaje de éxito
        echo "Datos guardados exitosamente";
    } else {
        // Imprimir mensaje si no se recibieron datos válidos
        echo "No se recibieron datos";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>