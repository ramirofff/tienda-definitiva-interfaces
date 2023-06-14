<?php
  // Recibimos los datos de la URL y los decodificamos
  if (isset($_GET['productos'])) {
    $productos = json_decode(urldecode($_GET['productos']));
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css"/>
  <link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.min.css"/>
  <link rel="icon" href="https://img.icons8.com/ios-glyphs/480/clothes.png" type="image/ico"/>
  <link rel="stylesheet" href="estilos/pago.css">
  <title>Tienda Online - Pago</title>
</head>
<body>
  <?php
    include "sesion.php";
  ?>
  <div id="app" class="container">
    <form class="form-inline needs-validation" method="post" v-on:submit="comprobarPago" autocomplete="on" novalidate>
      <h1>{{titulo}}</h1>
      <br/>
      <?php echo '<h2>El usuario '.$user.'<h2>';?>
      <?php echo '<h2>ha realizado una compra por: $'.$_SESSION['total_carrito'].'<h2>';?>
      <br/>
      <label class="form-label" for="nombre"><i class="bi bi-credit-card"></i>  Nombre en la tarjeta:</label>
      <br/>
      <input type="text" id="nombre" name="nombre" class="form-control form1" v-model="nombre" minlength="5" maxlength="50" placeholder="Ingrese nombre" required/>
      <small>Nombre completo como se muestra en la tarjeta</small>
      <br/>
      <label class="form-label" for="numero"><i class="bi bi-credit-card-2-front"></i> Número de Tarjeta:</label>
      <br/>
      <input type="text" id="numero" name="numero" class="form-control form1" v-model="numero" minlength="16" maxlength="16" pattern="[0-9]{16}" placeholder="1234 5678 9012 3456" required/>
      <small>Ingrese solamente números</small>
      <br/>
      <label class="form-label" for="fecha"><i class="bi bi-calendar-date"></i> Vencimiento:</label>
      <div>
        <select class="form-select form2" v-model="mes" name="fecha" required>
          <option value="" selected disabled>MM</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
        </select>
        /
        <select class="form-select form2" v-model="año" name="fecha" required>
          <option value="" selected disabled>YYYY</option>
          <option value="1">2021</option>
          <option value="2">2022</option>
          <option value="3">2023</option>
          <option value="4">2024</option>
          <option value="5">2025</option>
        </select>
      </div>
      <small>Ingrese el mes y el año en el que vence la tarjeta</small>
      <br/>
      <label class="form-label" for="cvv"><i class="bi bi-credit-card-2-back"></i> CVV:</label>
      <br/>
      <input type="text" id="cvv" name="cvv" class="form-control form1" v-model="cvv" minlength="3" maxlength="3" pattern="[0-9]{3}" placeholder="123" required/>
      <br/>
      <button type="submit" class="btn btn-lg btn-primary">
        <i class="bi bi-cash-coin"></i> Confirmar
      </button>
      <a href="tienda.php" class="btn btn-lg btn-primary"><i class="bi bi-x-octagon-fill"></i> Cancelar</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
  <script>
    const app = new Vue({
      el: '#app',
      data: {
        titulo: 'Tienda Online UNO',
        nombre: '',
        numero: '',
        mes: '',
        año: '',
        cvv: '',
        fechaTarjeta: 0,
        fechaActual: 0,
        confirmarPago: false,
        // Recibimos el arreglo de productos de pedidos.php
        productos: <?php echo json_encode($productos);?>,
      },
      methods: {
        comprobarPago: function (e) {
          if (this.numero === '') {
            alert('[ERROR] El número de la Tarjeta no puede estar vacío');
            e.preventDefault();
          } else if (isNaN(this.numero)) {
            alert('[ERROR] El número de la Tarjeta debe tener un valor numerico');
            this.numero = '';
            e.preventDefault();
          }

          if (this.cvv === '') {
            alert('[ERROR] El cvv de la Tarjeta no puede estar vacío');
            e.preventDefault();
          } else if (isNaN(this.cvv)) {
            alert('[ERROR] El cvv de la Tarjeta debe tener un valor numerico');
            this.cvv = '';
            e.preventDefault();
          }

          if (this.año === '' || this.mes === '') {
            alert('[ERROR] El año y el mes de la Tarjeta no pueden estar vacíos');
            e.preventDefault();
          } else {

            if (this.año == 1){
              this.año = 21;
            } else if (this.año == 2){
              this.año = 22;
            } else if (this.año == 3){
              this.año = 23;
            } else if (this.año == 4){
              this.año = 24;
            } else {
              this.año = 25;
            }

            this.fechaTarjeta = Number(this.año.toString() + this.mes.toString().padStart(2, '0'));
            this.fechaActual = Number(new Date().getFullYear().toString().slice(-2) + (new Date().getMonth() + 1).toString().padStart(2, '0'));

            if (this.fechaTarjeta > this.fechaActual) {
              e.preventDefault();
            }
            else {
              alert('La tarjeta esta vencida! Introducir datos nuevamente');
              this.año = '';
              this.mes = '';
              e.preventDefault();
            }
          }

          this.pago();
        },

        pago: function () {
          this.confirmarPago = false;
          if (
            this.nombre != '' &&
            this.numero != '' &&
            this.mes != '' &&
            this.año != '' &&
            this.cvv != ''
          ) {
            this.confirmarPago = true;
          }

          if (this.confirmarPago === true) {
            // Redireccionamos a detalles.php con los datos en la URL
            alert('Gracias por su compra! seras redirigido');
            window.location.href = "detalles.php?productos=" + encodeURIComponent(JSON.stringify(this.productos));
          }
        },

        agregarProducto: function (producto) {
          this.productos.push(producto);
        }
      }
    });
  </script>
  <script src="formulario.js"></script>
</body>
</html>