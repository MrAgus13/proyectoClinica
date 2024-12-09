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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/tickPruebas.js"></script>
    <script src="js/tickPruebasGenerar.js"></script>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/ticket.css">
</head>
<body>
    <div class="container box-tick mt-5">
       <div id="ticket-info">
            <!-- Información inicial del ticket y otros elementos -->
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

                        $sql = "SELECT * FROM USER_TICKETS WHERE ID_TICKET = '$ticket_id'";
                    
                        $stmt = $conn->prepare($sql);
    
                        // Ejecutar la consulta
                        $stmt->execute();
    
                        $comments = [];
    
                        $comments = $stmt->get_result(); 
    
                        // Cerrar la declaración preparada
                        $stmt->close();

                        if ($comment = $comments->fetch_assoc()) {
                        
                            foreach ($comments as $comment) {
                                // Obtener el ID del comentario para buscar el archivo asociado
                                $comentarioId = $comment['ID_USTICK']; // Asumiendo que 'id' es el campo de identificación del comentario
                            
                                // Obtener el archivo relacionado desde la tabla ARCHIVOS
                                $queryArchivo = "SELECT * FROM ARCHIVOS WHERE ID_USTICK = ?";
                                $stmt = $conn->prepare($queryArchivo);
                                $stmt->bind_param("i", $comentarioId);
                                $stmt->execute();
                                $resultArchivo = $stmt->get_result();
                                $archivo = $resultArchivo->fetch_assoc();
                            
                                // Si hay un archivo asociado al comentario, mostrar el enlace de descarga
                                $archivoLink = '';
                                if ($archivo) {
                                    $archivoLink = $archivo['RUTA_ARCHIVO']; 
                                }
                            
                                // Mostrar el comentario
                                echo '<div class="boxUnDes d-flex justify-content-between align-items-center mt-3">
                                        <p class="p-3 m-0">Has agregado un comentario </p>
                                        <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
                                      </div>';
                            
                                // Mostrar los detalles del comentario y el archivo, si existe
                                echo '<div class="boxDes p-3 d-none">
                                        <div class="infoPersonal mb-3">
                                            <p>Descripción de la incidencia:</p>
                                            <textarea class="form-control" id="comment">' . htmlspecialchars($comment['COMENTARIOS']) . '</textarea>
                                        </div>';
                            
                                if ($archivoLink) {
                                    // Mostrar el enlace de descarga si el archivo existe
                                    echo '<div class="infoPersonal mb-3">
                                            <p>Fichero: </p>
                                            <a href="' . $archivoLink . '" download>
                                                <img src="img/file.png" alt="Descargar archivo">
                                              
                                            </a>
                                          </div>';
                                }
                            
                                echo '</div>';
                            }
                        }

                        $sql = "SELECT * FROM ADMIN_TICKETS WHERE ID_TICKET = '$ticket_id'";
                    
                        $stmt = $conn->prepare($sql);
    
                        // Ejecutar la consulta
                        $stmt->execute();
    
                        $commentsAdmin = [];
    
                        $commentsAdmin = $stmt->get_result(); 
    
                        // Cerrar la declaración preparada
                        $stmt->close();

                        if ($commentAdmin = $commentsAdmin->fetch_assoc()) {
                        
                            foreach ($commentsAdmin as $commentAdmin) {
                                // Obtener el ID del comentario para buscar el archivo asociado
                                $comentarioId = $commentAdmin['ID_ADTICK']; // Asumiendo que 'id' es el campo de identificación del comentario
                            
                                // Obtener el archivo relacionado desde la tabla ARCHIVOS
                                $queryArchivo = "SELECT * FROM ARCHIVOS WHERE ID_ADTICK = ?";
                                $stmt = $conn->prepare($queryArchivo);
                                $stmt->bind_param("i", $comentarioId);
                                $stmt->execute();
                                $resultArchivo = $stmt->get_result();
                                $archivo = $resultArchivo->fetch_assoc();
                            
                                // Si hay un archivo asociado al comentario, mostrar el enlace de descarga
                                $archivoLink = '';
                                if ($archivo) {
                                    $archivoLink = $archivo['RUTA_ARCHIVO']; // Suponiendo que 'ruta' es el campo que contiene la ruta del archivo
                                }
                            
                                // Mostrar el comentario
                                echo '<div class="boxUnDes d-flex justify-content-between align-items-center mt-3">
                                        <p class="p-3 m-0">Te han agregado un comentario </p>
                                        <img class="dropdownIcon" src="img/dropdownIcon.svg" alt="">
                                      </div>';
                            
                                // Mostrar los detalles del comentario y el archivo, si existe
                                echo '<div class="boxDes p-3 d-none">
                                        <div class="infoPersonal mb-3">
                                            <p>Descripción de la incidencia:</p>
                                            <textarea class="form-control" id="comment-admin">' . htmlspecialchars($commentAdmin['COMENTARIOS']) . '</textarea>
                                        </div>';
                            
                                if ($archivoLink) {
                                    // Mostrar el enlace de descarga si el archivo existe
                                    echo '<div class="infoPersonal mb-3">
                                            <p>Fichero: </p>
                                            <a href="' . $archivoLink . '" download>
                                                <img src="img/file.png" alt="Descargar archivo">
                                              
                                            </a>
                                          </div>';
                                }
                            
                                echo '</div>';
                            }
                        }
                        $conn->close();

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
        var comentario = document.getElementById('comment-descripcion').value; // Comentario del formulario
        var archivo = document.getElementById('file-nombre').files[0]; // Archivo adjunto (si existe)

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
                location.reload();
                
            } else {
                Swal.fire('¡Error!', 'Hubo un problema al enviar el comentario.', 'error');
            }
        };

        xhr.send(formData);
    }
</script>
</body>
</html>
