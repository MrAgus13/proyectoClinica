<?php
session_start();
if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === TRUE) {
    // Si no está logueado, redirigir al login
    header('Location: pPpalCelia');
    exit();
}

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $error_message = "Las credenciales son incorrectas. Por favor, intenta de nuevo.";
            break;
        case 2:
            $error_message = "El usuario no existe.";
            break;
        case 3:
            $error_message = "Tu cuenta está desactivada. Por favor, contacta con el administrador.";
            break;
        default:
            $error_message = "Ocurrió un error inesperado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Clínica Sagrada Família</title>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script defer src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
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
        <div class="formContainer">
            <div class="row my-4">
                <div class="col">
                    <h1>¡Hola Celia!</h1>
                </div>
            </div>
            <div class="row text-start">
                <form action="php/autenticacion.php" method="POST" id="form">
                    <label for="mail">Correo</label><br>
                    <input type="text" id="mail" name="mail" placeholder="ejemplo@gmail.com" required><br>
                    
                    <label for="password">Contraseña</label><br>
                    <input type="password" id="password" name="password" placeholder="21345253" required><br>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label><br>
                    </div>

                    <button class="button_login" type="submit">Iniciar sesión</button><br>
                    <a href="#">Recuperar Contraseña</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Trigger the shake animation for invalid inputs
        <?php if (isset($error_message)): ?> 
            window.onload = function() {
                // Add the invalid-input class to the inputs that failed
                var mailInput = document.getElementById("mail");
                var passwordInput = document.getElementById("password");

                mailInput.classList.add("invalid-input");
                passwordInput.classList.add("invalid-input");

                // Optionally, you can also add a red color to the labels
                var mailLabel = document.querySelector('label[for="mail"]');
                var passwordLabel = document.querySelector('label[for="password"]');
                
                mailLabel.classList.add("invalid-label");
                passwordLabel.classList.add("invalid-label");
            };
        <?php endif; ?>
    </script>
</body>
</html>
