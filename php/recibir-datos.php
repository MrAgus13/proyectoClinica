<?php
session_start();

// Verificar si se proporcionó una fecha válida
if (!isset($_GET['date'])) {
    echo json_encode(["error" => "No se proporcionó una fecha válida"]);
    exit;
}

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

// Verificar si la sesión de usuario está definida
if (isset($_SESSION['email'])) {
    // Obtener el email de la sesión
    $email = $_SESSION['email'];

    // Obtener y sanitizar la fecha del parámetro GET
    $date = $_GET['date'];
    $date = htmlspecialchars($date); // Sanitizar la fecha, si es necesario

    // Preparar la consulta SQL de manera segura usando declaración preparada
    $sql = "SELECT * FROM  WHERE dia = ? AND email = ?";

    // Preparar la declaración SQL
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincular los parámetros
    $stmt->bind_param("ss", $date, $email);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Crear un array para almacenar los resultados
    $exercises = [];

    // Iterar sobre los resultados y almacenarlos en el array
    while ($row = $result->fetch_assoc()) {
        $exercises[] = $row;
    }

    // Cerrar la declaración preparada
    $stmt->close();

    // Cerrar conexión
    $conn->close();

    // Verificar si se encontraron ejercicios
    if (count($exercises) > 0) {
        echo '    <p> Dia de ' . htmlspecialchars($exercises[0]["grupo_muscular"]) . '</p>';
        // Mostrar los ejercicios como HTML directamente
        foreach ($exercises as $exercise) {
            echo '<div class="exercises">';
            echo '    <p>' . htmlspecialchars($exercise["ejercicio"]) , '</p><hr style="margin: 0;"><p>', htmlspecialchars($exercise["peso"]) ,' Kgs / ', htmlspecialchars($exercise["series"]),'x',htmlspecialchars($exercise["repeticiones"]) ,' reps'.'</p>';
            echo '</div>';
        }
    }
} else {
    echo json_encode(["error" => "La sesión de email no está definida"]);
    exit;
}
?>

