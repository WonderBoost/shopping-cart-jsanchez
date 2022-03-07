<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
         $shipping = 5;
         $final_price = 0;
         if ($price_total < 50) {
            $final_price = $price_total + $shipping;
         }else{
            $final_price = $price_total;
         }
      };
   };

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$final_price')") or die('falla en checkout');

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Gracias por su compra</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : ".($price_total < 50 ? $price_total +=5 : $price_total)."€  </span>
         </div>
         <div class='customer-details'>
            <p> Nombre : <span>".$name."</span> </p>
            <p> Número Célular : <span>".$number."</span> </p>
            <p> Correo Eléctronico : <span>".$email."</span> </p>
            <p> Dirección : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
            <p> Método de pago : <span>".$method."</span> </p>
         </div>
            <a href='products.php' class='btn'>Seguir comprando</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete su orden</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $shipping_fee = 5;
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;

      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>Tu carrito está vacío!</span></div>";
      }
      ?>
      <span class="grand-total"> Total: <?= ($grand_total < 50) ? $shipping_fee + $grand_total : $grand_total ?>€</span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Nombre</span>
            <input type="text" placeholder="ingrese su nombre" name="name" required>
         </div>
         <div class="inputBox">
            <span>Célular</span>
            <input type="number" placeholder="ingrese su número celular" name="number" required>
         </div>
         <div class="inputBox">
            <span>Correo Electrónico</span>
            <input type="email" placeholder="ingrese su correo eléctronico" name="email" required>
         </div>
         <div class="inputBox">
            <span>Método de pago</span>
            <select name="method">
               <option value="Efectivo" selected>Efectivo</option>
               <option value="Tarjeta de crédito">Tarjeta de crédito</option>
               <option value="paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Dirección línea 1</span>
            <input type="text" placeholder="Ingrese su dirección" name="flat" required>
         </div>
         <div class="inputBox">
            <span>Dirección línea 2</span>
            <input type="text" placeholder="Ingrese su dirección" name="street" required>
         </div>
         <div class="inputBox">
            <span>Ciudad</span>
            <input type="text" placeholder="Ingrese el nombre de su ciudad" name="city" required>
         </div>
         <div class="inputBox">
            <span>Estado</span>
            <input type="text" placeholder="Ingrese el nombre de su estado" name="state" required>
         </div>
         <div class="inputBox">
            <span>País</span>
            <input type="text" placeholder="Ingrese el nombre de su país" name="country" required>
         </div>
         <div class="inputBox">
            <span>Código Postal</span>
            <input type="number" placeholder="Ingrese su código postal" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="Ordenar Pedido" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>