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
    <link rel="stylesheet" href="css/codTicket.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script defer src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="jumbotron vertical-center">
        <div class="container text-center"> 
            <div class="row"> 
                <h1> ID TICKET  <?php echo htmlspecialchars($ticket_id); ?> </h1>   
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    Si quiere, puede proporcionar una dirección de correo electrónico para recibir actualizaciones sobre su tiquet. El correo proporcionado será confidencial y se utilizará únicamente para comunicarle los cambios de estado del tiquet. 
                </div>
                <div class="col-sm-1">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-5 col-paddingOff">
                    <form class="w-100 me-2">
                        <input type="search" class="form-control" placeholder="Introduce tu correo electrónico..." aria-label="Search">
                    </form>
                </div>
                <div class="col-sm-1 col-paddingOff">
                    <button type="submit" class="w-100 btn btn-primary mb-3">Enviar</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6 col-paddingOff">
                    <form action="ticket.php" method="get">
                        <button type="submit" class="w-100 btn btn-primary mb-3" name="id" value="<?php echo htmlspecialchars($ticket_id); ?>">
                            Consultar tiquet
                        </button>
                    </form>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
        </div>
    </div>
</body>
</html>