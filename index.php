<?php
// start session
session_start();

require_once('php/CreateDb.php');
require_once('./php/component.php');

// create instance of Createdb class
$database = new CreateDb(dbname:"Productdb", tablename:"Producttb");

if(isset($_POST["add"])){
  //  print_r($_POST["product_id"]);
  if(isset($_SESSION["cart"])){

  $item_array_id =  array_column($_SESSION["cart"],"product_id" );

  if(in_array($_POST["product_id"], $item_array_id)){
echo"<script> alert('Product is already added in the cart')</script>";
echo"<script> window.location='index.php' </script>";
  }else{
$count = count($_SESSION["cart"]);
$item_array = array(
    "product_id"=>$_POST["product_id"]
);
$_SESSION["cart"][$count] = $item_array;

  }

  }else{
    $item_array = array(
        "product_id"=>$_POST["product_id"]
    );

    //create a new session variable
    $_SESSION["cart"][0] = $item_array;
    print_r($_SESSION["cart"]);

  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php require_once("php/header.php")?>
<div class="container">
    <div class="row text-center py-5" >
       <?php
      $result= $database->getData();
     while($row = mysqli_fetch_assoc($result)) {
         component($row["product_name"],$row["product_price"],$row["product_image"], $row["id"]);
      }
       ?>
    </div>
</div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>