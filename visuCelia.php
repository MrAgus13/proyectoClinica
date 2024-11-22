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
    <script defer src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script defer src="js/home.js"></script>
    
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/visuCelia.css">
    
    <script src="js/visualizar.js"></script>
</head>
<body>
    
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

        // Obtener y sanitizar la fecha del parámetro GET
        $ticket_id = htmlspecialchars($ticket_id); // Sanitizar el ID del ticket

        // Preparar la consulta SQL de manera segura usando declaración preparada
        $sql = "SELECT * FROM TICKETS WHERE ID_TICKET = ?";

        // Preparar la declaración SQL
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ticket_id); // Vinculamos el ID del ticket

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

        // Verificar si se encontraron tickets
        if (count($exercises) > 0) {
            // Mostrar el ticket como HTML
            foreach ($exercises as $exercise) {
                echo '<div class="box animate__animated animate__fadeInDown">';
                echo '    <div class="salir">';
                echo '        <a href="pPpalCelia">';
                echo '            <img src="img/logout.svg" alt="">';
                echo '        </a>';
                echo '        <a href="php/cerrar-sesion.php">';
                echo '            <img src="img/salir.svg" alt="">';
                echo '        </a>';
                echo '    </div>';

                echo '    <div class="row">';
                echo '        <div class="col-sm-12 text-center">';
                echo '            <h1>Tiquet <span style="color: #134189;">' . htmlspecialchars($exercise["ID_TICKET"]) . '</span> </h1>';
                echo '        </div>';
                echo '    </div>';
                echo '    <br size="4px" />';

                echo '    <div class="header-info">';
                echo '        <div>Fecha: ' . htmlspecialchars($exercise["FECHA_HECHO"]) . '</div>';
                echo '        <div>Localización: ' . htmlspecialchars($exercise["LUGAR"]) . '</div>';
                echo '    </div>';

                echo '    <div class="form-section">';
                echo '        <label for="asunto">Asunto:</label>';
                echo '        <input type="text" id="asunto" class="form-control" value="' . htmlspecialchars($exercise["ASUNTO"]) . '" readonly>';
                echo '    </div>';

                echo '    <div class="form-section mt-3">';
                echo '        <label for="descripcion">Descripción del evento:</label>';
                echo '        <textarea id="descripcion" class="description-box" readonly>' . htmlspecialchars($exercise["DESCRIPCION"]) . '</textarea>';
                echo '    </div>';

                echo '    <div class="image-placeholder form-section mt-3 ">';
                echo '        Espacio para visualizar imágenes, archivos...';
                echo '    </div>';

                echo '    <div class="form-section mt-3">';
                echo '        <textarea class="response-box" placeholder="Escribe aquí tu respuesta"></textarea>';
                echo '    </div>';

                echo '    <div class="btns">';
                echo '        <input type="file" id="file" class="form-control" style="display: none;">';
                echo '        <button class="btn btn-secondary" onclick="document.getElementById(\'file\').click()">Adjuntar archivo</button>';
                echo '        <p>Tiquet <span style="color: #134189;">' . htmlspecialchars($exercise["ESTADO"]) . '</span> </p>';
                echo '        <button class="btn btn-primary btn_close">Enviar</button>';

                echo '        <button class="btn btn-primary">Cerrar tiquet</button>';
                echo '    </div>';
                echo '</div>';
            }
        }
    ?>
</body>
</html>
