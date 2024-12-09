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
        <div class="salir justify-content-end">
            <a href="php/cerrar-sesion.php"><img src="img/salir.svg" alt=""></a>
        </div>
        <div class="row justify-content-evenly">
            <!-- Tarjeta nuevas incidencias -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary pb-2">Nuevas incidencias</h5>                                     
                        <table class="table table-bordered" >   
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>Asunto</th>
                                    <th>Localización</th>
                                    <th>Datos adjuntos</th>
                                </tr>
                            </thead>
                            
                            <tbody>
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

                                // Preparar la consulta SQL para obtener tickets con estado 'NUEVA'
                                $sql = "SELECT * FROM TICKETS WHERE ESTADO = 'NUEVA'";

                                // Preparar la declaración SQL
                                $stmt = $conn->prepare($sql);
                                if ($stmt === false) {
                                    die("Error en la preparación de la consulta: " . $conn->error);
                                }

                                // Ejecutar la consulta
                                $stmt->execute();

                                // Obtener el resultado de la consulta
                                $result = $stmt->get_result();

                                // Crear un array para almacenar los resultados de los tickets
                                $exercises = [];

                                // Iterar sobre los resultados y almacenarlos en el array
                                while ($row = $result->fetch_assoc()) {
                                    $exercises[] = $row;
                                }

                                // Cerrar la declaración preparada
                                $stmt->close();

                                // Ahora podemos recorrer los resultados de los tickets y mostrar la información
                                if (count($exercises) > 0) {
                                    foreach ($exercises as $exercise) {
                                        // Mostrar la información del ticket
                                        echo '<tr onclick="window.location.href=\'visuCelia?id=' . htmlspecialchars($exercise["ID_TICKET"]) . '\'">';
                                        echo '  <td>' . htmlspecialchars($exercise["FECHA_HECHO"]) . '</td>';
                                        echo '  <td>' . htmlspecialchars($exercise["ID_TICKET"]) . '</td>';
                                        echo '  <td>' . htmlspecialchars($exercise["ASUNTO"]) . '</td>';
                                        echo '  <td>' . htmlspecialchars($exercise["LUGAR"]) . '</td>';

                                        // Obtener los archivos relacionados con este ticket
                                        $ticket_id = $exercise["ID_TICKET"];  

                                        // Preparar la consulta SQL para obtener los archivos de este ticket
                                        $sql_archivos = "SELECT RUTA_ARCHIVO, NOMBRE_ARCHIVO FROM ARCHIVOS WHERE ID_TICKET = ?";
                                        $stmt_archivos = $conn->prepare($sql_archivos);
                                        $stmt_archivos->bind_param("i", $ticket_id); 
                                        $stmt_archivos->execute();
                                        $result_archivos = $stmt_archivos->get_result();

                                        // Si hay archivos, mostrar un ícono o algo similar
                                        if ($result_archivos->num_rows > 0) {
                                            echo '  <td style="display: flex; justify-content: center;">';
                                            echo '    <img width="20px" src="img/file.png">';  
                                            echo '  </td>';
                                        } else {
                                            echo '  <td></td>';
                                        }

                                        echo '  <td></td>';
                                        echo '</tr>';

                                        // Cerrar la declaración de archivos
                                        $stmt_archivos->close();
                                    }
                                }

                                // Cerrar la conexión a la base de datos
                                $conn->close();
                            ?>                  
                            </tbody>
                        </table>                      
                    </div>                
                </div>
            </div>
            <!-- Tarjeta incidencias en curso -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary pb-2">Incidencias en curso</h5> 
                        <table class="table table-bordered">                                                                                                   
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>Asunto</th>
                                    <th>Localización</th>
                                    <th>Datos adjuntos</th>
                                </tr>
                            </thead>
                            <tbody>
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

                                // Preparar la consulta SQL para obtener tickets con estado 'En Curso'
                                $sql = "SELECT * FROM TICKETS WHERE ESTADO = 'En Curso'";

                                // Preparar la declaración SQL
                                $stmt = $conn->prepare($sql);
                                if ($stmt === false) {
                                    die("Error en la preparación de la consulta: " . $conn->error);
                                }

                                // Ejecutar la consulta
                                $stmt->execute();

                                // Obtener el resultado de la consulta
                                $result = $stmt->get_result();

                                // Crear un array para almacenar los resultados de los tickets
                                $exercises = [];

                                // Iterar sobre los resultados y almacenarlos en el array
                                while ($row = $result->fetch_assoc()) {
                                    $exercises[] = $row;
                                }

                                // Cerrar la declaración preparada
                                $stmt->close();

                                // Ahora podemos recorrer los resultados de los tickets y mostrar la información
                                if (count($exercises) > 0) {
                                    foreach ($exercises as $exercise) {
                                        // Mostrar la información del ticket
                                        echo '<tr onclick="window.location.href=\'visuCelia?id=' . htmlspecialchars($exercise["ID_TICKET"]) . '\'">';
                                        echo '  <td>' . htmlspecialchars($exercise["FECHA_HECHO"]) . '</td>';
                                        echo '  <td>' . htmlspecialchars($exercise["ID_TICKET"]) . '</td>';
                                        echo '  <td>' . htmlspecialchars($exercise["ASUNTO"]) . '</td>';
                                        echo '  <td>' . htmlspecialchars($exercise["LUGAR"]) . '</td>';

                                        // Obtener los archivos relacionados con este ticket
                                        $ticket_id = $exercise["ID_TICKET"];  

                                        // Preparar la consulta SQL para obtener los archivos de este ticket
                                        $sql_archivos = "SELECT RUTA_ARCHIVO, NOMBRE_ARCHIVO FROM ARCHIVOS WHERE ID_TICKET = ?";
                                        $stmt_archivos = $conn->prepare($sql_archivos);
                                        $stmt_archivos->bind_param("i", $ticket_id); 
                                        $stmt_archivos->execute();
                                        $result_archivos = $stmt_archivos->get_result();

                                        // Si hay archivos, mostrar un ícono o algo similar
                                        if ($result_archivos->num_rows > 0) {
                                            echo '  <td style="display: flex; justify-content: center;">';
                                            echo '    <img width="20px" src="img/file.png">';  
                                            echo '  </td>';
                                        } else {
                                            echo '  <td></td>'; 
                                        }

                                        echo '</tr>';

                                        // Cerrar la declaración de archivos
                                        $stmt_archivos->close();
                                    }
                                }

                                // Cerrar la conexión a la base de datos
                                $conn->close();
                            ?>
                        </tbody>
                    </table>  
                    </div>                  
                </div>  
            </div>           
        </div>   
        <div class="text-center">
            <div>
                <a href="resueltas"><button class="btn btn-primary">Consultar incidencias resueltas</button></a>
            </div>
        </div>
    </div>
</body>
</html>