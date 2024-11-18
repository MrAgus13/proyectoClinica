<?php
session_start();

// Credenciales de acceso a la base de datos
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'alumne';
$DATABASE_PASS = 'alumne';
$DATABASE_NAME = 'clinica';

// Conexión a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    // Si se encuentra un error en la conexión
    exit('Fallo en la conexión de MySQL: ' . mysqli_connect_error());
}

// Se valida si se ha enviado información, con la función isset()
if (!isset($_POST['mail'], $_POST['password'])) {
    // Si no hay datos muestra error y redirige
    header('Location: ../login');
    exit();
}

// Evitar inyección SQL y proteger la entrada
$mail = mysqli_real_escape_string($conexion, $_POST['mail']);
$password = $_POST['password'];

// Preparar la consulta SQL para verificar el usuario
if ($stmt = $conexion->prepare('SELECT USUARIO_ADMIN, CONTRASENA, NOMBRE FROM ADMIN WHERE USUARIO_ADMIN = ?')) {
    // Parámetros de enlace de la cadena 's'
    $stmt->bind_param('s', $mail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Usuario encontrado, obtener el correo electrónico, la contraseña en texto plano y el nombre
        $stmt->bind_result($db_mail, $db_password, $nombre);
        $stmt->fetch();

        // Verificar la contraseña ingresada con la contraseña almacenada en texto plano
        if ($password === $db_password) {
            // Contraseña correcta, crear sesión
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $nombre;
            $_SESSION['mail'] = $db_mail; // Guardar el mail en la sesión
            header('Location: ../pPpalCelia'); // Redirigir al inicio
            exit();
        } else {
            // Contraseña incorrecta
            header('Location: ../login?error=1'); // Redirigir con mensaje de error
            exit();
        }
    } else {
        // Usuario no encontrado
        header('Location: ../login?error=1'); // Redirigir con mensaje de error
        exit();
    }

    $stmt->close();
} else {
    // Error al preparar la consulta SQL
    exit('Error al preparar la consulta SQL: ' . $conexion->error);
}

$conexion->close();
?>
