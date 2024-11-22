<?php
if (isset($_GET['id'])) {
    // Obtener el valor de 'ticket' desde la URL
    $ticket_id = $_GET['id'];
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzón de sugerencias | Clínica Sagrada Família</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/ticket.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="js/tickPruebas.js"></script>
    <script src="js/tickPruebasGenerar.js"></script>
</head>
<body>
    <div class="container box-tick mt-5">
       <div id="ticket-info">
            <!-- Información inicial del ticket y otros elementos dinámicos se agregarán aquí -->
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
                    $sql = "SELECT * FROM TICKETS WHERE ID_TICKET = '$ticket_id'";

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
                            echo '   <div class="text-tick mb-4">';
                            echo '      <h1>Tiquet <span style="color: #134189;">'. htmlspecialchars($exercise["ID_TICKET"]) . '</span></h1>';
                            echo '      <p>Estado <span style="color: #134189;">'. htmlspecialchars($exercise["ESTADO"]) . '</span></p>';
                            echo '   </div>';
                            echo '   <div class="boxUnDes d-flex justify-content-between align-items-center mt-3" id="infoBox">';
                            echo '      <p class="p-3 m-0">Información inicial del ticket</p>';
                            echo '      <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">';
                            echo '   </div>';
                            echo '   <div class="boxDes p-3" id="infoDetails">';
                            echo '      <div class="d-flex justify-content-between mb-3">';
                            echo '        <div class="infoPersonal" style="width: 48%;">';
                            echo '            <p>Fecha de la incidencia:</p>';
                            echo '            <input type="text" class="form-control" value="' . htmlspecialchars($exercise['FECHA_HECHO']) . '" readonly>';
                            echo '        </div>';
                            echo '        <div class="infoPersonal" style="width: 48%;">';
                            echo '            <p>Localización | Área clínica:</p>';
                            echo '            <input type="text" class="form-control" value="' . htmlspecialchars($exercise['LUGAR']) . '" readonly>';
                            echo '        </div>';
                            echo '      </div>';
                            echo '      <div class="infoPersonal mb-3">';
                            echo '          <p>Asunto:</p>';
                            echo '          <input type="text" class="form-control" value="' . htmlspecialchars($exercise['ASUNTO']) . '" readonly>';
                            echo '      </div>';
                            echo '      <div class="infoPersonal mb-3">';
                            echo '          <p>Descripción de la incidencia:</p>';
                            echo '          <input type="text" class="form-control" value="' . htmlspecialchars($exercise['DESCRIPCION']) . '" readonly>';
                            echo '      </div>';
                            echo '   </div>';
                            
                        }
                        
                    }
                    else{
                    
                    }
            ?>  
        </div>
        
        <!-- Botón para añadir comentarios y archivos -->
        <div class="text-center mt-4">
            <button id="add-comment-btn" class="btn btn-primary btnadd">Añadir comentario</button>
            <button id="add-file-btn" class="btn btn-secondary btnadd">Añadir fichero</button>
        </div>
    </div> 
</body>
</html>
