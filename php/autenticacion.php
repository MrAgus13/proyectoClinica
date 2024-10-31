<?php
session_start();

// Credenciales de acceso a la base de datos
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'alumne';
$DATABASE_PASS = 'alumne';
$DATABASE_NAME = '';

// Conexión a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    // Si se encuentra un error en la conexión
    exit('Fallo en la conexión de MySQL: ' . mysqli_connect_error());
}

// Se valida si se ha enviado información, con la función isset()
if (!isset($_POST['email'], $_POST['password'])) {
    // Si no hay datos muestra error y redirige
    header('Location: ../login');
    exit();
}

// Evitar inyección SQL
if ($stmt = $conexion->prepare('SELECT email, password, nombre FROM users WHERE email = ?')) {
        // Parámetros de enlace de la cadena 's'
        $stmt->bind_param('s', $_POST['email']);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            // Usuario encontrado, obtener el correo electrónico, la contraseña hasheada y el nombre
            $stmt->bind_result($email, $hashed_password, $nombre);
            $stmt->fetch();
    
            // Verificar la contraseña ingresada con la contraseña hasheada
            if (password_verify($_POST['password'], $hashed_password)) {
                // Contraseña correcta, crear sesión
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $nombre;
                $_SESSION['email'] = $email; // Guardar el email en la sesión
                header('Location: ../index');
            } else {
                // Contraseña incorrecta
                header('Location: ../login');
            }
        } else {
            // Usuario no encontrado
            header('Location: ../login');
        }

        $stmt->close();
    } else {
        // Error al preparar la consulta SQL
        exit('Error en la consulta SQL: ' . $conexion->error);
    }
    
    $conexion->close();
?>