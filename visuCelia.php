<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    // Si no está logueado, redirigir al login
    header('Location: login');
    exit();
}

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
    <script defer src="bootstrap/js/bootstrap.mi    n.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script defer src="js/home.js"></script>
    <script src="js/visuCelia.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        $stmt->close();

        $sql = "SELECT RUTA_ARCHIVO, NOMBRE_ARCHIVO FROM ARCHIVOS WHERE ID_TICKET = '$ticket_id'";
                    
        $stmt = $conn->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute();

        $archivos = [];

        $archivos = $stmt->get_result(); 

        // Cerrar la declaración preparada
        $stmt->close();

        // Verificar si se encontró un ticket
        if ($row = $result->fetch_assoc()) {
            // Actualizar el estado si es 'Nueva'
            if ($row["ESTADO"] == 'Nueva') {
                $update_sql = "UPDATE TICKETS SET ESTADO = 'En Curso' WHERE ID_TICKET = ?";
                $stmt2 = $conn->prepare($update_sql);
                $stmt2->bind_param("i", $ticket_id);
                $stmt2->execute();
                $stmt2->close();
                $row["ESTADO"] = 'En Curso'; // Actualizamos el estado para reflejar el cambio en la UI
            }

            // Mostrar el ticket como HTML
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
            echo '            <h1>Tiquet <span style="color: #134189;">' . htmlspecialchars($row["ID_TICKET"]) . '</span> </h1>';
            echo '        </div>';
            echo '    </div>';
            echo '    <br size="4px" />';

            echo '    <div class="header-info">';
            echo '        <div>Fecha: ' . htmlspecialchars($row["FECHA_HECHO"]) . '</div>';
            echo '        <div>Localización: ' . htmlspecialchars($row["LUGAR"]) . '</div>';
            echo '    </div>';

            echo '    <div class="form-section">';
            echo '        <label for="asunto">Asunto:</label>';
            echo '        <input type="text" id="asunto" class="form-control" value="' . htmlspecialchars($row["ASUNTO"]) . '" readonly>';
            echo '    </div>';

            echo '    <div class="form-section mt-3">';
            echo '        <label for="descripcion">Descripción del evento:</label>';
            echo '        <textarea id="descripcion" class="description-box" readonly>' . htmlspecialchars($row["DESCRIPCION"]) . '</textarea>';
            echo '    </div>';

            if ($archivo = $archivos->fetch_assoc()) {
                echo '    <div class="image-placeholder form-section mt-3 row " style="display:block;">';
                foreach ($archivos as $archivo) {
                    echo '    <div class="col-sm-1"   >';
                    echo '      <a href="'.htmlspecialchars($archivo['RUTA_ARCHIVO']).'" download="'.htmlspecialchars($archivo['NOMBRE_ARCHIVO']).'">';
                    echo '          <img style="padding: 1.5em;" src="img/file.png" title="'. htmlspecialchars($archivo['NOMBRE_ARCHIVO']) .'"><br><p"> </p> ';
                    echo '      </a>';
                    echo '    </div>';
                }
                echo '    </div>';
            } else{
                echo '    <div class="image-placeholder form-section mt-3 row " >';
                    echo '        Espacio para visualizar imágenes, archivos...';
                echo '    </div>';
                
            }


            //Mostrar comentarios admin
            $sqlCommentsAdmin = "SELECT * FROM ADMIN_TICKETS WHERE ID_TICKET = ?";
            $stmt = $conn->prepare($sqlCommentsAdmin);
            $stmt->bind_param("i", $ticket_id);
            $stmt->execute();
            $commentsAdmin = $stmt->get_result();
            $stmt->close();
            if ($commentsAdmin->num_rows > 0) {
                echo '<div style="float: left;width: 50%;  padding:1%;">';
                    echo '    <div class="infoPersonal mb-3">';
                    echo '        <p>Tus comentarios </p>';
                    echo '    </div>';

                while ($commentAdmin = $commentsAdmin->fetch_assoc()) {
                    // Obtener el ID del comentario para buscar el archivo asociado
                    $comentarioId = $commentAdmin['ID_ADTICK']; // ID del comentario del administrador
                    
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
                        $archivoLink = $archivo['RUTA_ARCHIVO']; // Ruta del archivo
                    }
    
        
                    // Mostrar los detalles del comentario y el archivo, si existe
                    echo '    <div>';

                    echo '        <textarea class="form-control" id="comment-admin" readonly>' . htmlspecialchars($commentAdmin['COMENTARIOS']) . '</textarea>';
                    echo '    </div>';
                    echo '    </br>';

        
                    if ($archivoLink) {
                        // Mostrar el enlace de descarga si el archivo existe
                        echo '<div class="infoPersonal mb-3">';
                        echo '    <p>Fichero: </p>';
                        echo '    <a href="' . $archivoLink . '" download>';
                        echo '        <img src="img/file.png" alt="Descargar archivo">';
                        echo '    </a>';
                        echo '</div>';
                    }
        
                }
                echo '    </div>';
            }

            // Mostrar comentarios del usuario
            $sqlComments = "SELECT * FROM USER_TICKETS WHERE ID_TICKET = ?";
            $stmt = $conn->prepare($sqlComments);
            $stmt->bind_param("i", $ticket_id);
            $stmt->execute();
            $comments = $stmt->get_result();
            $stmt->close();
            if ($comments->num_rows > 0) {
                echo '<div style="float: right;width: 50%; padding:1%;">';
                echo '    <div class="infoPersonal mb-3">';
                echo '        <p>Comentario del usuario </p>';
                echo '    </div>';
                while ($comment = $comments->fetch_assoc()) {
                    // Obtener el ID del comentario para buscar el archivo asociado
                    $comentarioId = $comment['ID_USTICK']; // ID del comentario del usuario
                    
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
                        $archivoLink = $archivo['RUTA_ARCHIVO']; // Ruta del archivo
                    }

                    // Mostrar el comentario y el archivo si existe
                    echo '    <div>';
                    echo '        <textarea class="form-control" id="comment" readonly>' . htmlspecialchars($comment['COMENTARIOS']) . '</textarea>';
                    echo '    </div>';

                    if ($archivoLink) {
                        // Mostrar el enlace de descarga si el archivo existe
                        echo '<div class="infoPersonal mb-3">';
                        echo '    <p>Fichero: </p>';
                        echo '    <a href="' . htmlspecialchars($archivoLink) . '" download>';
                        echo '        <img src="img/file.png" alt="Descargar archivo">';
                        echo '    </a>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            

            //Archivos adjuntos
            echo '    <div class="form-section mt-3">';
            echo '        <textarea id="comentario" class="response-box" placeholder="Escribe aquí tu respuesta"></textarea>';
            echo '    </div>';
            echo '    <div class="btns">';
            echo '        <input type="file" id="file" class="form-control" style="display: none;">';
            echo '        <button class="btn btn-secondary" onclick="document.getElementById(\'file\').click()">Adjuntar archivo</button>';
            echo '        <p>Estado del tiquet: <span style="color: #134189;">' . htmlspecialchars($row["ESTADO"]) . '</span> </p>';
            echo '        <button class="btn btn-primary btn_close">Enviar</button>';
            if ($row["ESTADO"] != "Resuelto") {
                echo '        <button class="btn btn-primary btn_close" onclick="cerrarTiquet(' . htmlspecialchars($row['ID_TICKET']) . ')">Cerrar tiquet</button>';
            }
            echo '    </div>';
            echo '</div>';
        } else {
            echo '<p>No se encontró el ticket solicitado.</p>';
        }
        $conn->close();
    ?>
</body>
<script>
    document.querySelector('.btn_close').addEventListener('click', function () {
    var comentario = document.getElementById('comentario').value; // Comentario del formulario
    var archivo = document.getElementById('file').files[0]; // Archivo adjunto (si existe)

    // Verificar que el comentario no esté vacío
    if (comentario.trim() === "") {
        Swal.fire('¡Error!', 'Debes escribir un comentario.', 'error');
        return;
    }

    var formData = new FormData();
    formData.append('comentario', comentario); // Agregar el comentario al FormData
    formData.append('ticket_id', <?php if (isset($_GET['id'])) {$ticket_id = $_GET['id'];} echo json_encode($ticket_id); ?>); 

    
    // Validar archivo si existe
    if (archivo) {
        var fileType = archivo.type;
        var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Tipos permitidos
        if (!allowedTypes.includes(fileType)) {
            Swal.fire('¡Error!', 'Solo se permiten archivos de tipo imagen o PDF.', 'error');
            return;
        }
        formData.append('fichero', archivo); // Agregar el archivo al FormData
    }

    // Realizar la solicitud AJAX al script PHP
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/enviar-comentarios.php', true);

    // Cuando la solicitud sea completada
    xhr.onload = function () {
        if (xhr.status === 200) {
            Swal.fire('¡Éxito!', 'Comentario enviado con éxito.', 'success');
            location.reload();
            } else {
            Swal.fire('¡Error!', 'Hubo un problema al enviar el comentario. Código de error: ' + xhr.status, 'error');
        }
    };

    // Manejar errores de red
    xhr.onerror = function () {
        Swal.fire('¡Error!', 'Hubo un problema con la conexión de red.', 'error');
    };

    // Enviar los datos
    xhr.send(formData);
});

</script>
</html>
