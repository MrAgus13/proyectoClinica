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
                        <h5 class="card-title text-primary border-bottom pb-2">Nuevas incidencias</h5>                                     
                        <table class="table table-bordered">                                                  
                            <tbody>
                                <tr>
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>Asunto</th>
                                    <th>Localización</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>2024-11-01</td>
                                    <td>18431</td>
                                    <td>Posible mejora de las camas</td>
                                    <td>REA</td>
                                    <td><img src="img/file_present.svg" alt=""></td>
                                </tr>
                                <tr>
                                    <td>2024-11-02</td>
                                    <td>2548</td>
                                    <td>Proveedor de medicación</td>
                                    <td>Farmacia</td>
                                    <td></td>
                                </tr>                              
                            </tbody>
                        </table>                      
                    </div>                
                </div>
            </div>
            <!-- Tarjeta incidencias en curso -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary border-bottom pb-2">Incidencias en curso</h5> 
                        <table class="table table-bordered">                                                  
                            <tbody>
                                <tr>
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>Asunto</th>
                                    <th>Localización</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>                              
                            </tbody>
                        </table>  
                    </div>                  
                </div>  
            </div>           
        </div>   
        <div class="text-center">
            <div>
                <a href="resueltas.html"><button class="btn btn-primary">Consultar incidencias resueltas</button></a>
            </div>
        </div>
        <div class="salir justify-content-end">
            <a href="php/cerrar-sesion.php">
                Cerrar sesión
                <img src="img/salir.svg" alt="">
            </a>
        </div>
    </div>
</body>
</html>