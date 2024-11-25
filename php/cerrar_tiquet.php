<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);

    // Validar que el ID esté presente
    if (!isset($input['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID de tiquet no proporcionado.']);
        exit;
    }

    $ticket_id = intval($input['id']);

    // Configurar la conexión a la base de datos
    $servername = "localhost";
    $username = "alumne";
    $password = "alumne";
    $dbname = "clinica";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Conexión fallida a la base de datos.']);
        exit;
    }

    // Actualizar el estado del tiquet
    $sql = "UPDATE TICKETS SET ESTADO = 'Resuelto' WHERE ID_TICKET = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>
