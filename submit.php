<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="estilos/estilos.css">
</head>
<body>
	<?php 

        include "sesion.php";
        include "conexion.php";

	    // Recibiendo datos del formulario
	    $email = $_POST['email'];

	    // Verificar si el correo ya existe en la base de datos
	    $stmt = $conexion->prepare("SELECT id FROM subscriber WHERE email = ?");
	    $stmt->bind_param("s", $email);
	    $stmt->execute();
	    $stmt->store_result();
	    if ($stmt->num_rows > 0) {
	        echo "<br/><h1>Ya estás suscrito al newsletter</h1><br/>";
	        header("Refresh: 5; url=tienda.php");
	        echo "<h2>Serás redirigido a la página principal en 5 segundos</h2><br/>"; ?>
			<img src="https://ayuda.nuthost.com/wp-content/uploads/2020/10/Formulario-de-suscripcion-al-Newsletter-NUTHOST-Centro-de-Ayuda.png" alt="..." class="img"/> <?php
	    } else {
	        // Insertar correo en la base de datos
            $stmt = $conexion->prepare("INSERT INTO subscriber (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "<br/><h1>Te has suscrito exitosamente al newsletter</h1><br/>";
                header("Refresh: 5; url=tienda.php");
                echo "<h2>Serás redirigido a la página principal en 5 segundos</h2><br/>"; ?>
			    <img src="https://ayuda.nuthost.com/wp-content/uploads/2020/10/Formulario-de-suscripcion-al-Newsletter-NUTHOST-Centro-de-Ayuda.png" alt="..." class="img"/> <?php
            } else {
                echo "<br/><h1>Ocurrió un error al suscribirte al newsletter</h1><br/>";
                header("Refresh: 5; url=tienda.php");
                echo "<h2>Serás redirigido a la página principal en 5 segundos</h2><br/>"; ?>
			    <img src="https://ayuda.nuthost.com/wp-content/uploads/2020/10/Formulario-de-suscripcion-al-Newsletter-NUTHOST-Centro-de-Ayuda.png" alt="..." class="img"/> <?php
            }
        }

        // Cerrar conexión a la base de datos
        $stmt->close();
        $conexion->close();
    ?>
</body>
</html>