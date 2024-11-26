<?php
if (isset($_GET['id'])) {
    // Obtener el valor de 'ticket' desde la URL
    $ticket_id = $_GET['id'];
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzón de sugerencias | Clínica Sagrada Família</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="js/tickPruebas.js"></script>
    <script src="js/tickPruebasGenerar.js"></script>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/ticket.css">
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
                    // Preparar la consulta SQL de manera segura usando declaración preparada
                    $sql = "SELECT * FROM TICKETS WHERE ID_TICKET = '$ticket_id'";
                    
                    // Preparar la declaración SQL
                    $stmt = $conn->prepare($sql);
                    
                    if ($stmt === false) {
                        die("Error en la preparación de la consulta: " . $conn->error);
                    }

                    $stmt->execute();
                   
                    $result = $stmt->get_result(); 
                    
                    $stmt->close();

                    // Conseguir ficheros
                    
                    $sql = "SELECT RUTA_ARCHIVO, NOMBRE_ARCHIVO FROM ARCHIVOS WHERE ID_TICKET = '$ticket_id'";
                    
                    $stmt = $conn->prepare($sql);

                    // Ejecutar la consulta
                    $stmt->execute();

                    $archivos = [];

                    $archivos = $stmt->get_result(); 

                    // Cerrar la declaración preparada
                    $stmt->close();

                    // Cerrar conexión
                    $conn->close();

                    // Verificar si se encontró un ticket
                    if ($row = $result->fetch_assoc()) {
                        // Mostrar los ejercicios como HTML directamente
                        echo '    <div class="salir">';
                        echo '        <a href="index">';
                        echo '            <img src="img/logout.svg" alt="">';
                        echo '        </a>';
                        echo '    </div>';
                        echo '   <div class="text-tick mb-4">';
                        echo '      <h1>Tiquet <span style="color: #134189;">'. htmlspecialchars($row["ID_TICKET"]) . '</span></h1>';
                        echo '      <p>Estado <span style="color: #134189;">'. htmlspecialchars($row["ESTADO"]) . '</span></p>';
                        echo '   </div>';
                        echo '   <div class="boxUnDes d-flex justify-content-between align-items-center mt-3" id="infoBox">';
                        echo '      <p class="p-3 m-0">Información inicial del ticket</p>';
                        echo '      <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">';
                        echo '   </div>';
                        echo '   <div class="boxDes p-3" id="infoDetails">';
                        echo '      <div class="d-flex justify-content-between mb-3">';
                        echo '        <div class="infoPersonal" style="width: 48%;">';
                        echo '            <p>Fecha de la incidencia:</p>';
                        echo '            <input type="text" class="form-control" value="' . htmlspecialchars($row['FECHA_HECHO']) . '" readonly>';
                        echo '        </div>';
                        echo '        <div class="infoPersonal" style="width: 48%;">';
                        echo '            <p>Localización | Área clínica:</p>';
                        echo '            <input type="text" class="form-control" value="' . htmlspecialchars($row['LUGAR']) . '" readonly>';
                        echo '        </div>';
                        echo '      </div>';
                        echo '      <div class="infoPersonal mb-3">';
                        echo '          <p>Asunto:</p>';
                        echo '          <input type="text" class="form-control" value="' . htmlspecialchars($row['ASUNTO']) . '" readonly>';
                        echo '      </div>';
                        echo '      <div class="infoPersonal mb-3">';
                        echo '          <p>Descripción de la incidencia:</p>';
                        echo '          <input type="text" class="form-control" value="' . htmlspecialchars($row['DESCRIPCION']) . '" readonly>';
                        echo '      </div>';
                        if ($archivo = $archivos->fetch_assoc()) {
                            echo '      <p>Ficheros</p>';
                            echo '      <div class="file-box">';
                            foreach ($archivos as $archivo) {
                                echo '    <div class="image-placeholder form-section mt-3">';
                                echo '      <a class="" href="'.htmlspecialchars($archivo['RUTA_ARCHIVO']).'" download="'.htmlspecialchars($archivo['NOMBRE_ARCHIVO']).'">';
                                echo '          <img class="file-img" src="img/file.png" alt=""><br><p"> '. htmlspecialchars($archivo['NOMBRE_ARCHIVO']) .'</p> ';
                                echo '      </a>';
                                echo '    </div>';
                            }
                            echo '      </div>';
                        }
                        echo '   </div>';
                        
                    }
                    else{
                        header('Location: ../index?error=1');
                    }
            ?>  
            
        </div>   
        <!-- Botón para añadir comentarios y archivos -->
        <div class="text-center mt-4">
            <button id="add-comment-btn" class="btn btn-primary btnadd">Añadir comentario</button>
        </div>
    </div> 
<script>
    function saveComment(){
        var comentario = document.getElementById('comentario').value; // Comentario del formulario
        var archivo = document.getElementById('file').files[0]; // Archivo adjunto (si existe)

        // Verificar que el comentario no esté vacío
        if (comentario.trim() === "") {
            Swal.fire('¡Error!', 'Debes escribir un comentario.', 'error');
            return;
        }

        var formData = new FormData();
        formData.append('comentario', comentario); // Agregar el comentario al FormData
        formData.append('ticket_id', <?php echo json_encode($ticket_id); ?>); // Agregar el ID del ticket
        if (archivo) {
            formData.append('fichero', archivo); // Agregar el archivo al FormData
        }

        // Realizar la solicitud AJAX al script PHP
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/enviar-comentariosUsuario.php', true);

        // Cuando la solicitud sea completada
        xhr.onload = function () {
            if (xhr.status === 200) {
                Swal.fire('¡Éxito!', 'Comentario enviado con éxito.', 'success');
                // Opcional: Redirigir o actualizar la página
                location.reload(); // Recargar la página para ver los cambios
            } else {
                Swal.fire('¡Error!', 'Hubo un problema al enviar el comentario.', 'error');
            }
        };

        xhr.send(formData);
    }
</script>
</body>
</html>
