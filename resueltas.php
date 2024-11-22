<?php
session_start();  // Inicia la sesión PHP

// Verificar si la sesión está activa (si el usuario ha iniciado sesión)
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    // Si no está logueado, redirigir al login
    header('Location: login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">   
    <link rel="stylesheet" href="css/fonts.css">  
    <link rel="stylesheet" href="css/pPpalCelia.css">
    <script defer src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-evenly">
            <!-- Tarjeta nuevas incidencias -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary border-bottom pb-2">Notificaciones resueltas</h5>                                     
                        <table class="table table-bordered">                                                  
                            <tbody>
                                <tr>
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>Asunto</th>
                                    <th>Localización</th>
                                    <th></th>
                                </tr>
                                <?php
                                    session_start();

                                    // Configurar la conexión a la base de datos
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

                                    // Verificar si la sesión de usuario está definida
                                        // Obtener el email de la sesión
                                        $email = $_SESSION['email'];

                                        // Obtener y sanitizar la fecha del parámetro GET
                                        $date = $_GET['date'];
                                        $date = htmlspecialchars($date); // Sanitizar la fecha, si es necesario

                                        // Preparar la consulta SQL de manera segura usando declaración preparada
                                        $sql = "SELECT * FROM TICKETS WHERE ESTADO = 'RESUELTA'";

                                        // Preparar la declaración SQL
                                        $stmt = $conn->prepare($sql);

                                        if ($stmt === false) {
                                            die("Error en la preparación de la consulta: " . $conn->error);
                                        }

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
                                            // Mostrar los ejercicios como HTML directamente
                                            foreach ($exercises as $exercise) {
                                                echo '    <tr onclick="window.location.href=\'visuCelia?id=' . htmlspecialchars($exercise["ID_TICKET"]) . '\'">';
                                                echo '      <td> '. htmlspecialchars($exercise["FECHA_HECHO"]) . '</td>';
                                                echo '      <td> '. htmlspecialchars($exercise["ID_TICKET"]) . '</td>';
                                                echo '      <td> '. htmlspecialchars($exercise["ASUNTO"]) . '</td>';
                                                echo '      <td> '. htmlspecialchars($exercise["LUGAR"]) . '</td>';
                                                echo '      <td> '. htmlspecialchars($exercise["PROCESADO"]) . '</td>';
                                                echo '    </tr>';
                                            }
                                        }
                                ?>                               
                            </tbody>
                        </table>                      
                    </div>                
                </div>
            </div>     
        </div>   
    </div>
    <div class="text-center">
        <div>
            <a href="pPpalCelia"><button class="btn btn-primary">Consultar notificaciones en curso</button></a>
        </div>
    </div>
</body>
</html>