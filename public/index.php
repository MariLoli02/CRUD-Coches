<?php
require dirname(__DIR__, 1) . "/vendor/autoload.php";

use App\{Marcas, Autos};

(new Marcas)->crearMarcas(10);
(new Autos)->crearAutos(20);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CDN SWEETALERT2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Gestion Coches</title>
</head>

<body style="background-color: darkseagreen;">
    <h3 class="text-center mt-4"></h3>
    <div class="container text-center">
        <a href="Marcas/index.php" class="btn btn-primary"><i class="fas fa-book"></i> Gestionar Marcas</a>
        <a href="Autos/index.php" class="btn btn-primary"><i class="fas fa-car"></i> Gestionar Autos</a>
    </div>
</body>

</html>