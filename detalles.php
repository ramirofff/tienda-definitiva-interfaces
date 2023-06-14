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
    <title>Tienda Online UNO</title>
</head>
<body>
  <?php
    include "sesion.php";
    // Recibimos los datos de la URL y los decodificamos
    if (isset($_GET['productos'])) {
      $productos = json_decode(urldecode($_GET['productos']));
      $numero_pedido = date("YmdHis") . rand(1000, 9999);
    }
  ?>
  <header>
    <ul class="header-section nav nav-pills">
      <li><a href="tienda.php" class="nav-link active"><i class="bi bi-house-door-fill"></i> Página Principal</a></li>
      <li><a href="arrepentimiento.html" class="nav-link"><i class="bi bi-bag-check-fill"></i> Boton de arrepentimiento</a></li>
      <li><a href="cerrarSesion.php" class="nav-link"><i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
    </ul>
    <hr/>
    <h1>Tienda Online UNO</h1>
  </header>
  <br>
  <!-- Mostramos los datos recibidos -->
  <h1>Gracias por su compra</h1>
  <p><?php echo $user; ?></p>
  <p>Número de pedido: <?php echo $numero_pedido; ?></p>
  <p>Total: $ <?php echo $_SESSION['total_carrito']; ?></p>
  <br>
  <h2>Productos comprados:</h2>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ID producto</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Precio</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $producto): ?>
          <tr>
            <td><?php echo $producto->id; ?></td>
            <td><?php echo $producto->nombre; ?></td>
            <td><?php echo $producto->cantidad; ?></td>
            <td>$<?php echo $producto->cantidad * $producto->precio; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php
    function generarNombreArchivo($nombreUsuario) {
      return "compras_" . $nombreUsuario . ".txt";
    }
    // Generar el nombre del archivo de texto para el usuario actual
    $nombreArchivo = generarNombreArchivo($user);

    // Crear una variable para almacenar todos los productos comprados
    $linea = '';

    // Agregar cada producto comprado a la variable $linea
    foreach ($productos as $producto) {
      $linea .= $numero_pedido . "\t" . $user . "\t" . $producto->id . "\t" . $producto->nombre . "\t" . $producto->cantidad . "\t" . $producto->cantidad * $producto->precio . "\n";
    }

    // Escribir la variable $linea en el archivo de texto correspondiente al usuario
    file_put_contents($nombreArchivo, $linea, FILE_APPEND);

    // despues de guardar el archivo, entro a la base de datos 
    // y vuelvo a poner la cantidad en 0, por si el usuario quiere realizar otra compra 
    include "conexion.php";

    $query="UPDATE productos
            SET cantidad = 0,
                stock = 10";
    
    $consulta=mysqli_query($conexion,$query);
  ?>
  <footer>
    <hr/>
    <div class="footerFlex">
      <div>
        Contacto:<br/>
        <i class="bi bi-person-circle"></i> Tienda, Uno<br/>
        <i class="bi bi-telephone-fill"></i> 1168017247<br/>
        <i class="bi bi-envelope-fill"></i><a href="mailto:loreedithgomez@gmail.com"> Correo</a>
      </div>
      <div>
        Ayuda:<br/>
        <a href="arrepentimiento.html"> Boton de arrepentimiento</a><br/>
        <a href="politicas.html"> Politicas de privacidad</a>
      </div>
      <div>
        Nosotros:<br/>
        <a href="newsletter.html"> Suscribirse a Newsletter</a><br/>
        <a href="nosotros.html"> Sobre Nosotros</a>
      </div>
    </div>
    <br/>
    <strong>Derechos Reservados &copy; 2023</strong>
  </footer>
</body>
</html>