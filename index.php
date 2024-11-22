<?php
if (isset($_GET['error'])) {
    $error_message = "Codigo incorrecto.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzón de sugerencias | Clínica Sagrada Família</title>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="js/home.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script defer src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
        <div class="container-fluid">
            <!-- Logo -->
            <div class="row my-5">
                <div class="col-md-3 offset-1">
                    <div class="logo">
                        <img src="img/csf-horitzontal-white.png" alt="logo-sagrada-familia" rel="preload" >
                    </div>
                </div>
            </div>
            <!-- Título -->
            <div class="row my-5"> 
                <h1 class="col-md-11 offset-1 titulo animate__animated animate__slideInDown">Notificación de riesgos y posibles <br>eventos adversos</h1>
            </div>
            <!-- Botones -->
            <div class="row g-0 align-items-end animate__animated animate__slideInDown">
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <a href="formulario"><button class="btn-principal">Crear nueva notificación</button></a>
                </div>
                <div class="col-md-3">
                    <button class="btn-principal" onclick="desplegarBuscador()">Consultar estado de notificación</button>
                </div>
                <div class="col-md-5">
                    <div class="animate__animated animate__fadeIn" id="space-code" style="display: none;">
                        <p id="textCod">Introduce el código de la notificación</p>
                        <label for="codigoIncidencia"></label>
                        <input type="text" placeholder="Código" onkeydown="validarNumero(event)" name="codigo" id="codigoIncidencia" maxlength="8">
                        <dotlottie-player id="icon" src="https://lottie.host/5f105f0c-69aa-42a8-a084-42867c944d23/PIRyCJNSqU.json" background="transparent" speed="1" loop autoplay></dotlottie-player>
                    </div>
                </div>
            </div>
   
        </div>     
    </div>
    
    <script>
        <?php if (isset($error_message)): ?> 
            Swal.fire({
            title: "Codigo incorrecto",
            text: "Por favor, facilite un numero de ticket correcto.",
            icon: "error",
            confirmButtonColor: "#134189",
            confirmButtonText: "OK"
            });
        <?php endif; ?>
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
</body>
</html>

