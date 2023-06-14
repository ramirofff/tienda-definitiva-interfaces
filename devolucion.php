<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <?php
            include "sesion.php";

            $pedido = $_REQUEST['pedido'];

            // Nombre del archivo de texto para el usuario actual
            $nombreArchivo = "compras_".$user.".txt";

            // Verificar si el archivo existe
            if (!file_exists($nombreArchivo)) {
                echo '<script>Swal.fire({
                    icon: "error",
                    title: "ERROR",
                    text: "No se han encontrado compras realizadas por el usuario '.$user.'",
                }).then(function() {
                    window.location.href = "arrepentimiento.html";
                });</script>';
            } else {
                // Leer el contenido del archivo en un array de líneas
                $lineas = file($nombreArchivo, FILE_IGNORE_NEW_LINES);

                // Filtrar las líneas que cumplen con la condición $datos[0] == $pedido
                $nuevasLineas = array_filter($lineas, function ($linea) use ($pedido) {
                    $datos = explode("\t", $linea);
                    return count($datos) == 6 && $datos[0] != $pedido;
                });

                // Escribir el nuevo contenido en el archivo
                file_put_contents($nombreArchivo, implode("\n", $nuevasLineas));

                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Devolución en proceso",
                    text: "Gracias, chequearemos que existe el pedido y realizaremos la devolucion correspondiente",
                }).then(function() {
                    window.location.href = "arrepentimiento.html";
                });</script>';
            }
        ?>
    </div>
</body>
</html>