<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="https://img.icons8.com/ios-glyphs/480/clothes.png" type="image/ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/detalles.css">
    <title>Tienda Online - Mis Compras</title>
</head>
<body>
    <div class="container">
        <?php
            include "sesion.php";
        ?>
        <header id="header"></header>
        <h1>Tienda Online UNO</h1>
        <br/>
        <h2>Ropa de moda</h2>
        <br>        
        <nav id="nav"></nav>
        <br>
        <?php
            // Generar el nombre del archivo de texto para el usuario actual
            $nombreArchivo = "compras_".$user.".txt";

            // Verificar si el archivo existe
            if (!file_exists($nombreArchivo)) {
                echo "<h3>No se han encontrado compras realizadas por el usuario ".$user."</h3>";
            } else {
                // Obtener el contenido del archivo
                $contenido = file_get_contents($nombreArchivo);

                // Convertir el contenido del archivo en un array de líneas
                $lineas = explode("\n", $contenido);

                // Imprimir la tabla de detalles de la compra
                echo "<h2>Detalles de la compras realizadas por el usuario ".$user."</h2><br/>";
                echo '<div class="table-responsive">';
                    echo "<table>";
                        echo "<thead><tr><th>Número de pedido</th><th>ID producto</th><th>Nombre</th><th>Cantidad</th><th>Precio</th></tr></thead>";
                        echo "<tbody>";
                            foreach ($lineas as $linea) {
                                $datos = explode("\t", $linea);
                                if (count($datos) == 6) {
                                    echo "<tr>";
                                    echo "<td>{$datos[0]}</td>";
                                    echo "<td>{$datos[2]}</td>";
                                    echo "<td>{$datos[3]}</td>";
                                    echo "<td>{$datos[4]}</td>";
                                    echo "<td>$" . number_format($datos[5], 2) . "</td>";
                                    echo "</tr>";
                                }
                            }
                        echo "</tbody>";
                    echo "</table>";
                echo '</div>';
            }
        ?>
        <br>
        <footer id="footer"></footer>
    </div>
    <script src="header-nav-footer.js"></script>
</body>
</html>