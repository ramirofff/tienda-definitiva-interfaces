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
    <link rel="stylesheet" href="estilos/pedidos.css">
    <title>Carrito de Compras</title>
</head>
<body>
    <div class="container">
        <header id="header"></header>
        <h1 class="titulo">Tienda Online UNO</h1>
        <br/>
        <h2 class="titulo">Ropa de moda</h2>
        <br/><br/>
        <nav id="nav"></nav>
        <br/><br/>
        <?php
        include "sesion.php";
        include "conexion.php";
        $query="SELECT * FROM productos WHERE cantidad > 0 ORDER BY tipo";
        $consulta=mysqli_query($conexion,$query);
        $cantidad=mysqli_num_rows($consulta);
        if($cantidad > 0){?>
            <h1 class="titulo">Carrito:</h1>
            <br/><hr/>
            <div class="row container">
                <div class="col-6">
                    <p>Producto</p>
                </div>
                <div class="col-3">
                    <p>Precio</p>
                </div>
                <div class="col-3">
                    <p>Cantidad</p>
                </div>
            </div>
            <hr/>
            <?php while($obj=mysqli_fetch_object($consulta)){ ?>
                <div class="row">
                    <div class="col-2">
                        <div class="d-flex align-items-center justify-content-around h-100 border-bottom pb-2 pt-3 tab">
                            <img src="<?php echo $obj->imagen?>" class="carrito-imagen" alt="...">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex align-items-center justify-content-around h-100 border-bottom pb-2 pt-3 tab">
                            <h5><?php echo $obj->nombre?></h5>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex align-items-center justify-content-center h-100 border-bottom pb-2 pt-3">
                            <h5>$ <?php echo $obj->precio * $obj->cantidad?></h5>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex align-items-center justify-content-evenly h-100 border-bottom pb-2 pt-3">
                            <h5><?php echo $obj->cantidad?></h5>
                            <a href="eliminarCarrito.php?nombre=<?php echo $obj->nombre?>" class="btn btn-danger btn-sm btn-borrar">X</a>
                        </div>
                    </div>
                </div>
		    <?php }
        }else{ ?>
            <img src="https://www.mercadomate.com.ar/images/carritovacio.png" alt="...">
        <?php } ?>
        <br/><br/>
        <?php
            $query="SELECT * FROM productos WHERE cantidad > 0";
            $consulta=mysqli_query($conexion,$query);
            $productos = [];
            $total = 0;
            while($obj=mysqli_fetch_object($consulta)){
                $producto = [
                    'nombre' => $obj->nombre,
                    'cantidad' => $obj->cantidad,
                    'precio' => $obj->precio,
                    'id' => $obj->id
                ];
                $total += ($obj->cantidad * $obj->precio);
                $productos[] = $producto;
            }
            $_SESSION['total_carrito'] = $total;
            echo '<p>El total es: $ '.$total.'<p>';
        ?>
        <a href="pago.php?productos=<?php echo urlencode(json_encode($productos));?>" class="btn btn-primary btn-lg" onclick="return <?php echo $total?> > 0">
            <i class="bi bi-cart-check"></i> Comprar
        </a>
        <br/><br/>
        <footer id="footer"></footer>
    </div>
    <script src="header-nav-footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script language="javascript" type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>
    <script>
        $('.btn-borrar').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            Swal.fire({
                title: '¿Está seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '¡Eliminado!',
                        'Su producto ha sido sacado del carrito',
                        'success'
                    )
                    document.location.href = href;
                }
            })
        })
    </script>
</body>
</html>